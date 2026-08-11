<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function vcpc_theme_setup_features() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
	add_theme_support( 'custom-logo', [
		'height'      => 80,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
	] );

	register_nav_menus( [
		'primary' => __( 'Primary Navigation', 'vcpc' ),
	] );
}
add_action( 'after_setup_theme', 'vcpc_theme_setup_features' );

function vcpc_enqueue_theme_assets() {
	// Custom premium typography link or inline CSS can go in header, styling is in main.css.
	wp_enqueue_style( 'vcpc-main', VCPC_URI . '/assets/css/main.css', [], VCPC_VERSION );

	// GSAP & ScrollTrigger from CDN
	wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', [], '3.12.5', true );
	wp_enqueue_script( 'gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', [ 'gsap' ], '3.12.5', true );

	wp_enqueue_script( 'vcpc-animations', VCPC_URI . '/assets/js/animations.js', [ 'gsap', 'gsap-scrolltrigger' ], VCPC_VERSION, true );
	wp_enqueue_script( 'vcpc-main', VCPC_URI . '/assets/js/main.js', [ 'jquery' ], VCPC_VERSION, true );

	wp_enqueue_script( 'vcpc-form', VCPC_URI . '/assets/js/form-handler.js', [], VCPC_VERSION, true );
	wp_localize_script( 'vcpc-form', 'vcpcForm', [
		'endpoint' => esc_url_raw( rest_url( 'vcpc/v1/join' ) ),
		'nonce'    => wp_create_nonce( 'wp_rest' ),
	] );
}
add_action( 'wp_enqueue_scripts', 'vcpc_enqueue_theme_assets' );

function vcpc_enqueue_admin_assets( $hook ) {
	global $post;
	$front_id = (int) get_option( 'page_on_front' );
    
	// Load on post edit screens and our custom options page. The repeater script
	// is also used from admin meta boxes, so we enqueue it broadly in admin.
	$is_options_page = ( 'toplevel_page_vcpc-theme-settings' === $hook );
	$is_post_edit = in_array( $hook, array( 'post.php', 'post-new.php' ), true );

	if ( $is_post_edit || $is_options_page ) {
		wp_enqueue_media();
		wp_enqueue_style( 'jquery-ui-css', 'https://code.jquery.com/ui/1.13.2/themes/smoothness/jquery-ui.css', [], '1.13.2' );
		wp_enqueue_style( 'vcpc-admin-metaboxes', VCPC_URI . '/assets/css/admin-metaboxes.css', [], VCPC_VERSION );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'vcpc-admin-repeater', VCPC_URI . '/assets/js/admin-repeater.js', [ 'jquery', 'jquery-ui-sortable' ], VCPC_VERSION, true );
	}
}
add_action( 'admin_enqueue_scripts', 'vcpc_enqueue_admin_assets' );
