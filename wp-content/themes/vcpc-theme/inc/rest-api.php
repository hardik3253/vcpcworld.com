<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'rest_api_init', function () {
	register_rest_route( 'vcpc/v1', '/join', [
		'methods'             => 'POST',
		'callback'            => 'vcpc_handle_join_submission',
		'permission_callback' => '__return_true',
	] );
} );

function vcpc_handle_join_submission( WP_REST_Request $request ) {
	// Nonce check
	$nonce = $request->get_header( 'X-WP-Nonce' );
	if ( ! $nonce || ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
		return new WP_REST_Response( [ 'success' => false, 'message' => __( 'Security verification failed.', 'vcpc' ) ], 403 );
	}

	$params = $request->get_json_params();
	if ( ! $params ) {
		$params = $_POST;
	}

	// Basic honeypot field check
	if ( ! empty( $params['website'] ) ) {
		return new WP_REST_Response( [ 'success' => true ], 200 ); // Silently ignore spam
	}

	// Read fields config from landing page
	$front_id = (int) get_option( 'page_on_front' );
	$fields = [];
	if ( $front_id ) {
		$fields_json = get_post_meta( $front_id, '_vcpc_join_join_form_fields', true );
		if ( $fields_json ) {
			$fields = json_decode( $fields_json, true );
		}
	}

	// Fallback to default fields structure if empty
	if ( empty( $fields ) || ! is_array( $fields ) ) {
		$fields = [
			[ 'field_name' => 'first_name', 'field_label' => 'First Name', 'field_type' => 'text', 'field_required' => 'yes' ],
			[ 'field_name' => 'last_name', 'field_label' => 'Last Name', 'field_type' => 'text', 'field_required' => 'yes' ],
			[ 'field_name' => 'email', 'field_label' => 'Email Address', 'field_type' => 'email', 'field_required' => 'yes' ],
			[ 'field_name' => 'mobile', 'field_label' => 'Mobile Number', 'field_type' => 'tel', 'field_required' => 'yes' ],
			[ 'field_name' => 'country', 'field_label' => 'Country', 'field_type' => 'text', 'field_required' => 'yes' ],
			[ 'field_name' => 'audience', 'field_label' => 'I am a', 'field_type' => 'select', 'field_required' => 'yes' ],
		];
	}

	$errors = [];
	$sanitized_data = [];

	foreach ( $fields as $f ) {
		if ( empty( $f['field_name'] ) ) continue;
		$name = $f['field_name'];
		$label = $f['field_label'];
		$type = $f['field_type'];
		$is_required = ( ! empty( $f['field_required'] ) && strtolower( $f['field_required'] ) === 'yes' );

		$val = isset( $params[ $name ] ) ? $params[ $name ] : '';

		// Validation
		if ( $is_required && ( '' === $val || null === $val ) ) {
			$errors[ $name ] = sprintf( __( '%s is required.', 'vcpc' ), $label );
			continue;
		}

		if ( 'email' === $type && ! empty( $val ) ) {
			$val = sanitize_email( $val );
			if ( ! is_email( $val ) ) {
				$errors[ $name ] = __( 'A valid email address is required.', 'vcpc' );
				continue;
			}
		} elseif ( 'url' === $type && ! empty( $val ) ) {
			$val = esc_url_raw( $val );
		} else {
			$val = sanitize_text_field( $val );
		}

		// Validation check for Select (audience choices)
		if ( 'select' === $type && ! empty( $val ) ) {
			$audience_valid = false;
			if ( $front_id ) {
				$audience_options_meta = get_post_meta( $front_id, '_vcpc_join_audience_options', true );
				if ( ! empty( $audience_options_meta ) ) {
					$options = json_decode( $audience_options_meta, true );
					if ( is_array( $options ) ) {
						foreach ( $options as $opt ) {
							if ( isset( $opt['label'] ) && $opt['label'] === $val ) {
								$audience_valid = true;
								break;
							}
						}
					}
				}
			}

			// Fallback static audience options validation
			if ( ! $audience_valid ) {
				$static_audiences = [ 'Consumer', 'Hair Professional', 'Salon Owner', 'Distributor', 'Media' ];
				if ( in_array( $val, $static_audiences, true ) ) {
					$audience_valid = true;
				}
			}

			if ( ! $audience_valid ) {
				$errors[ $name ] = __( 'Please select a valid option.', 'vcpc' );
				continue;
			}
		}

		$sanitized_data[ $name ] = $val;
	}

	if ( ! empty( $errors ) ) {
		return new WP_REST_Response( [ 'success' => false, 'errors' => $errors ], 400 );
	}

	// Create Lead CPT
	$title_parts = [];
	if ( isset( $sanitized_data['first_name'] ) ) $title_parts[] = $sanitized_data['first_name'];
	if ( isset( $sanitized_data['last_name'] ) ) $title_parts[] = $sanitized_data['last_name'];
	if ( isset( $sanitized_data['email'] ) ) $title_parts[] = '(' . $sanitized_data['email'] . ')';
	$lead_title = ! empty( $title_parts ) ? implode( ' ', $title_parts ) : __( 'New Lead Submission', 'vcpc' );

	$lead_id = wp_insert_post( [
		'post_type'   => 'vcpc_lead',
		'post_title'  => sanitize_text_field( $lead_title ),
		'post_status' => 'publish',
	] );

	if ( is_wp_error( $lead_id ) || ! $lead_id ) {
		return new WP_REST_Response( [ 'success' => false, 'message' => __( 'Could not register lead. Please try again later.', 'vcpc' ) ], 500 );
	}

	// Save all dynamic fields to lead CPT meta
	foreach ( $sanitized_data as $key => $val ) {
		update_post_meta( $lead_id, $key, $val );
	}

	// Send admin notification email
	$admin_email = get_option( 'admin_email' );
	$subject     = __( 'New VCPC Journey Lead Registration', 'vcpc' );
	
	$message     = "A new registration request has been submitted with the following fields:\n\n";
	foreach ( $fields as $f ) {
		if ( empty( $f['field_name'] ) ) continue;
		$name = $f['field_name'];
		$label = $f['field_label'];
		$val = isset( $sanitized_data[ $name ] ) ? $sanitized_data[ $name ] : '';
		$message .= sprintf( "%s: %s\n", $label, $val );
	}

	wp_mail( $admin_email, $subject, $message );

	// Hook for ESP/CRM integrations
	do_action( 'vcpc_lead_saved', $lead_id, $sanitized_data );

	return new WP_REST_Response( [ 'success' => true, 'message' => __( 'Thank you — you have been added to the journey.', 'vcpc' ) ], 200 );
}
