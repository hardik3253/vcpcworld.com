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
			'name'          => __( 'Journey Signups', 'vcpc' ),
			'singular_name' => __( 'Signup', 'vcpc' ),
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
	$columns['email']    = __( 'Email', 'vcpc' );
	$columns['mobile']   = __( 'Mobile', 'vcpc' );
	$columns['country']  = __( 'Country', 'vcpc' );
	$columns['audience'] = __( 'I am a', 'vcpc' );
	return $columns;
}
add_filter( 'manage_vcpc_lead_posts_columns', 'vcpc_lead_columns' );

function vcpc_lead_column_content( $column, $post_id ) {
	if ( in_array( $column, [ 'email', 'mobile', 'country', 'audience' ], true ) ) {
		echo esc_html( get_post_meta( $post_id, $column, true ) );
	}
}
add_action( 'manage_vcpc_lead_posts_custom_column', 'vcpc_lead_column_content', 10, 2 );
