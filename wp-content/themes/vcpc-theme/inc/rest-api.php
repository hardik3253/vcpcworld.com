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
	// Nonce check (sent by wp_localize_script)
	$nonce = $request->get_header( 'X-WP-Nonce' );
	if ( ! $nonce || ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
		return new WP_REST_Response( [ 'success' => false, 'message' => 'Invalid request.' ], 403 );
	}

	$params = $request->get_json_params();

	$first_name = isset( $params['first_name'] ) ? sanitize_text_field( $params['first_name'] ) : '';
	$last_name  = isset( $params['last_name'] )  ? sanitize_text_field( $params['last_name'] )  : '';
	$email      = isset( $params['email'] )      ? sanitize_email( $params['email'] )            : '';
	$mobile     = isset( $params['mobile'] )     ? sanitize_text_field( $params['mobile'] )       : '';
	$country    = isset( $params['country'] )    ? sanitize_text_field( $params['country'] )      : '';
	$audience   = isset( $params['audience'] )   ? sanitize_text_field( $params['audience'] )      : '';

	// Basic honeypot anti-spam field, expected to stay empty
	if ( ! empty( $params['website'] ) ) {
		return new WP_REST_Response( [ 'success' => true ], 200 ); // silently accept, don't store
	}

	if ( empty( $first_name ) || empty( $email ) || ! is_email( $email ) ) {
		return new WP_REST_Response( [ 'success' => false, 'message' => 'Please provide a valid name and email.' ], 400 );
	}

	$lead_id = wp_insert_post( [
		'post_type'   => 'vcpc_lead',
		'post_title'  => $first_name . ' ' . $last_name . ' — ' . $email,
		'post_status' => 'publish',
	] );

	if ( is_wp_error( $lead_id ) || ! $lead_id ) {
		return new WP_REST_Response( [ 'success' => false, 'message' => 'Could not save submission.' ], 500 );
	}

	update_post_meta( $lead_id, 'first_name', $first_name );
	update_post_meta( $lead_id, 'last_name', $last_name );
	update_post_meta( $lead_id, 'email', $email );
	update_post_meta( $lead_id, 'mobile', $mobile );
	update_post_meta( $lead_id, 'country', $country );
	update_post_meta( $lead_id, 'audience', $audience );

	// Notify admin
	$admin_email = get_option( 'admin_email' );
	wp_mail(
		$admin_email,
		'New VCPC Journey Signup: ' . $first_name . ' ' . $last_name,
		"New signup received:\n\nName: $first_name $last_name\nEmail: $email\nMobile: $mobile\nCountry: $country\nI am a: $audience"
	);

	/**
	 * Hook for CRM/ESP integration (Mailchimp, Klaviyo, HubSpot, etc.)
	 * add_action( 'vcpc_lead_saved', function( $lead_id, $data ) { ... }, 10, 2 );
	 */
	do_action( 'vcpc_lead_saved', $lead_id, compact( 'first_name', 'last_name', 'email', 'mobile', 'country', 'audience' ) );

	return new WP_REST_Response( [ 'success' => true, 'message' => 'Thank you — you\'re on the list.' ], 200 );
}
