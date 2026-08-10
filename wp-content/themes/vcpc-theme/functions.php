<?php
/**
 * VCPC Theme functions
 * No page builder. No ACF. Plain WordPress template hierarchy + custom fields via
 * register_post_meta() so content is still editable from wp-admin without a plugin.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'VCPC_VERSION', '1.0.0' );
define( 'VCPC_DIR', get_template_directory() );
define( 'VCPC_URI', get_template_directory_uri() );

/** ---------------------------------------------------------
 * Theme setup
 * ------------------------------------------------------- */
function vcpc_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );
	add_theme_support( 'custom-logo', [
		'height'      => 60,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	] );

	register_nav_menus( [
		'primary' => __( 'Primary Navigation', 'vcpc' ),
		'footer'  => __( 'Footer Navigation', 'vcpc' ),
	] );
}
add_action( 'after_setup_theme', 'vcpc_theme_setup' );

/** ---------------------------------------------------------
 * Includes
 * ------------------------------------------------------- */
require_once VCPC_DIR . '/inc/enqueue.php';
require_once VCPC_DIR . '/inc/theme-fields.php';   // replaces ACF — plain custom fields
require_once VCPC_DIR . '/inc/rest-api.php';       // Join the Journey form endpoint
require_once VCPC_DIR . '/inc/lead-cpt.php';       // stores form submissions as a CPT (viewable in wp-admin)

/** ---------------------------------------------------------
 * Misc cleanup
 * ------------------------------------------------------- */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
