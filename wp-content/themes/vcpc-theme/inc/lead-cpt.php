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
	] );

	register_post_meta( 'vcpc_lead', 'first_name', [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
	register_post_meta( 'vcpc_lead', 'last_name',  [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
	register_post_meta( 'vcpc_lead', 'email',      [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
	register_post_meta( 'vcpc_lead', 'mobile',     [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
	register_post_meta( 'vcpc_lead', 'country',    [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
	register_post_meta( 'vcpc_lead', 'audience',   [ 'show_in_rest' => true, 'single' => true, 'type' => 'string' ] );
}
add_action( 'init', 'vcpc_register_lead_cpt' );

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
