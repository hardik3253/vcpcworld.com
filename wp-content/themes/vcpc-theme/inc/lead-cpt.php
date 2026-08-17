<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Stores "Join the Journey" submissions as a private CPT so the client
 * can view/export leads from wp-admin without a form-plugin dependency.
 */
function vcpc_register_lead_cpt() {
	register_post_type( 'vcpc_lead', [
		'label'        => __( 'Journey Signups', 'vcpc' ),
		'labels'       => [
			'name'               => __( 'Journey Signups', 'vcpc' ),
			'singular_name'      => __( 'Signup', 'vcpc' ),
			'menu_name'          => __( 'Journey Signups', 'vcpc' ),
			'all_items'          => __( 'All Signups', 'vcpc' ),
			'view_item'          => __( 'View Signup', 'vcpc' ),
			'search_items'       => __( 'Search Signups', 'vcpc' ),
			'not_found'          => __( 'No signups found', 'vcpc' ),
			'not_found_in_trash' => __( 'No signups found in Trash', 'vcpc' ),
		],
		'public'       => false,
		'show_ui'      => true,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-email-alt',
		'supports'     => [ 'title' ],
		'capability_type' => 'post',
		'capabilities' => [
			'create_posts' => false,
		],
		'map_meta_cap' => true,
	] );

	register_post_type( 'vcpc_diagnosis', [
		'label'        => __( 'Hair Diagnoses', 'vcpc' ),
		'labels'       => [
			'name'               => __( 'Hair Diagnoses', 'vcpc' ),
			'singular_name'      => __( 'Diagnosis', 'vcpc' ),
			'menu_name'          => __( 'Hair Diagnoses', 'vcpc' ),
			'all_items'          => __( 'All Diagnoses', 'vcpc' ),
			'view_item'          => __( 'View Diagnosis', 'vcpc' ),
			'search_items'       => __( 'Search Diagnoses', 'vcpc' ),
			'not_found'          => __( 'No diagnoses found', 'vcpc' ),
			'not_found_in_trash' => __( 'No diagnoses found in Trash', 'vcpc' ),
		],
		'public'       => false,
		'show_ui'      => true,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-clipboard',
		'supports'     => [ 'title' ],
		'capability_type' => 'post',
		'capabilities' => [
			'create_posts' => false,
		],
		'map_meta_cap' => true,
	] );

	register_post_meta( 'vcpc_lead', 'first_name', [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
	register_post_meta( 'vcpc_lead', 'last_name',  [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
	register_post_meta( 'vcpc_lead', 'email',      [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
	register_post_meta( 'vcpc_lead', 'mobile',     [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
	register_post_meta( 'vcpc_lead', 'country',    [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
	register_post_meta( 'vcpc_lead', 'audience',   [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );

	register_post_meta( 'vcpc_diagnosis', 'name', [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
	register_post_meta( 'vcpc_diagnosis', 'contact_number', [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
	register_post_meta( 'vcpc_diagnosis', 'email', [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
	register_post_meta( 'vcpc_diagnosis', 'instagram', [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
	register_post_meta( 'vcpc_diagnosis', 'city', [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
	register_post_meta( 'vcpc_diagnosis', 'hair_condition', [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
	register_post_meta( 'vcpc_diagnosis', 'hair_stressors', [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
	register_post_meta( 'vcpc_diagnosis', 'hair_needs', [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
	register_post_meta( 'vcpc_diagnosis', 'professional_treatment', [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
	register_post_meta( 'vcpc_diagnosis', 'homecare', [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
}
add_action( 'init', 'vcpc_register_lead_cpt' );

/** Display diagnosis details metabox */
function vcpc_add_diagnosis_details_metabox() {
	add_meta_box(
		'vcpc_diagnosis_details',
		__( 'Hair Diagnosis Details', 'vcpc' ),
		'vcpc_render_diagnosis_details_metabox',
		'vcpc_diagnosis',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'vcpc_add_diagnosis_details_metabox' );

function vcpc_render_diagnosis_details_metabox( $post ) {
	$fields = [
		'name' => [ 'label' => __( 'Full Name', 'vcpc' ), 'key' => 'name' ],
		'contact_number' => [ 'label' => __( 'Contact Number', 'vcpc' ), 'key' => 'contact_number' ],
		'email' => [ 'label' => __( 'Email Address', 'vcpc' ), 'key' => 'email' ],
		'instagram' => [ 'label' => __( 'Instagram Handle', 'vcpc' ), 'key' => 'instagram' ],
		'city' => [ 'label' => __( 'City', 'vcpc' ), 'key' => 'city' ],
		'hair_condition' => [ 'label' => __( 'Hair Condition', 'vcpc' ), 'key' => 'hair_condition' ],
		'hair_stressors' => [ 'label' => __( 'Hair Stressors', 'vcpc' ), 'key' => 'hair_stressors' ],
		'hair_needs' => [ 'label' => __( 'Hair Needs', 'vcpc' ), 'key' => 'hair_needs' ],
		'professional_treatment' => [ 'label' => __( 'Professional Treatment', 'vcpc' ), 'key' => 'professional_treatment' ],
		'homecare' => [ 'label' => __( 'Homecare', 'vcpc' ), 'key' => 'homecare' ],
	];
	
	?>
	<div style="background: #f8f6f2; padding: 20px; border-radius: 4px;">
		<?php foreach ( $fields as $field_key => $field ) : 
			$value = get_post_meta( $post->ID, $field['key'], true );
			if ( empty( $value ) ) {
				continue;
			}
		?>
			<div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid rgba(23,23,26,0.1);">
				<strong style="display: block; margin-bottom: 4px; color: #7b6852;"><?php echo esc_html( $field['label'] ); ?></strong>
				<p style="margin: 0; color: #17171a;"><?php echo nl2br( esc_html( $value ) ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
}

/** Show key fields as admin columns for quick scanning/export */
function vcpc_diagnosis_columns( $columns ) {
	$columns['email'] = __( 'Email', 'vcpc' );
	$columns['contact_number'] = __( 'Contact', 'vcpc' );
	$columns['city'] = __( 'City', 'vcpc' );
	$columns['hair_condition'] = __( 'Hair Condition', 'vcpc' );
	return $columns;
}
add_filter( 'manage_vcpc_diagnosis_posts_columns', 'vcpc_diagnosis_columns' );

function vcpc_diagnosis_column_content( $column, $post_id ) {
	if ( in_array( $column, [ 'email', 'contact_number', 'city', 'hair_condition' ], true ) ) {
		echo esc_html( get_post_meta( $post_id, $column, true ) );
	}
}
add_action( 'manage_vcpc_diagnosis_posts_custom_column', 'vcpc_diagnosis_column_content', 10, 2 );

/** Display signup details metabox */
function vcpc_add_signup_details_metabox() {
	add_meta_box(
		'vcpc_signup_details',
		__( 'Journey Signup Details', 'vcpc' ),
		'vcpc_render_signup_details_metabox',
		'vcpc_lead',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'vcpc_add_signup_details_metabox' );

function vcpc_render_signup_details_metabox( $post ) {
	$fields = [
		'first_name' => [ 'label' => __( 'First Name', 'vcpc' ), 'key' => 'first_name' ],
		'last_name' => [ 'label' => __( 'Last Name', 'vcpc' ), 'key' => 'last_name' ],
		'email' => [ 'label' => __( 'Email', 'vcpc' ), 'key' => 'email' ],
		'mobile' => [ 'label' => __( 'Mobile', 'vcpc' ), 'key' => 'mobile' ],
		'country' => [ 'label' => __( 'Country', 'vcpc' ), 'key' => 'country' ],
		'audience' => [ 'label' => __( 'I am a', 'vcpc' ), 'key' => 'audience' ],
	];
	
	?>
	<div style="background: #f8f6f2; padding: 20px; border-radius: 4px;">
		<?php foreach ( $fields as $field_key => $field ) : 
			$value = get_post_meta( $post->ID, $field['key'], true );
			if ( empty( $value ) ) {
				continue;
			}
		?>
			<div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid rgba(23,23,26,0.1);">
				<strong style="display: block; margin-bottom: 4px; color: #7b6852;"><?php echo esc_html( $field['label'] ); ?></strong>
				<p style="margin: 0; color: #17171a;"><?php echo nl2br( esc_html( $value ) ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
}

/** Show key fields as admin columns for quick scanning/export */
function vcpc_lead_columns( $columns ) {
	$columns['first_name'] = __( 'First Name', 'vcpc' );
	$columns['last_name']  = __( 'Last Name', 'vcpc' );
	$columns['email']      = __( 'Email', 'vcpc' );
	$columns['mobile']     = __( 'Mobile', 'vcpc' );
	$columns['country']    = __( 'Country', 'vcpc' );
	$columns['audience']   = __( 'I am a', 'vcpc' );
	return $columns;
}
add_filter( 'manage_vcpc_lead_posts_columns', 'vcpc_lead_columns' );

function vcpc_lead_column_content( $column, $post_id ) {
	if ( in_array( $column, [ 'first_name', 'last_name', 'email', 'mobile', 'country', 'audience' ], true ) ) {
		echo esc_html( get_post_meta( $post_id, $column, true ) );
	}
}
add_action( 'manage_vcpc_lead_posts_custom_column', 'vcpc_lead_column_content', 10, 2 );

/**
 * Add a CSV Export Button to CPT list table screen.
 */
function vcpc_add_export_button() {
	global $typenow;
	if ( 'vcpc_lead' !== $typenow ) {
		return;
	}
	?>
	<div class="alignleft actions">
		<input type="submit" name="vcpc_export_csv" id="vcpc_export_csv" class="button button-primary" value="<?php esc_attr_e( 'Export leads to CSV', 'vcpc' ); ?>" />
	</div>
	<?php
}
add_action( 'restrict_manage_posts', 'vcpc_add_export_button' );

/**
 * Stream Lead Signups to CSV when button is clicked.
 */
function vcpc_handle_csv_export() {
	if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( isset( $_GET['vcpc_export_csv'] ) || isset( $_POST['vcpc_export_csv'] ) ) {
		// Clean buffer
		if ( ob_get_level() ) {
			ob_end_clean();
		}

		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=vcpc-leads-' . date( 'Y-m-d-His' ) . '.csv' );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );

		$output = fopen( 'php://output', 'w' );

		// Header row
		fputcsv( $output, [
			'ID',
			'Date Submitted',
			'First Name',
			'Last Name',
			'Email',
			'Mobile',
			'Country',
			'Audience Type'
		] );

		$query = new WP_Query( [
			'post_type'      => 'vcpc_lead',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'fields'         => 'ids'
		] );

		if ( $query->have_posts() ) {
			foreach ( $query->posts as $post_id ) {
				fputcsv( $output, [
					$post_id,
					get_the_date( 'Y-m-d H:i:s', $post_id ),
					get_post_meta( $post_id, 'first_name', true ),
					get_post_meta( $post_id, 'last_name', true ),
					get_post_meta( $post_id, 'email', true ),
					get_post_meta( $post_id, 'mobile', true ),
					get_post_meta( $post_id, 'country', true ),
					get_post_meta( $post_id, 'audience', true )
				] );
			}
		}

		fclose( $output );
		exit;
	}
}
add_action( 'admin_init', 'vcpc_handle_csv_export' );
