<?php
/**
 * VCPC Theme functions
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'VCPC_VERSION', '1.0.0' );
define( 'VCPC_DIR', get_template_directory() );
define( 'VCPC_URI', get_template_directory_uri() );

// Required Modules & Helpers
require_once VCPC_DIR . '/inc/theme-setup.php';
require_once VCPC_DIR . '/inc/repeater-fields.php';

// Base Metabox class
require_once VCPC_DIR . '/inc/metaboxes/class-vcpc-metabox.php';

// Theme options (contains location helpers needed by metabox configs)
require_once VCPC_DIR . '/inc/theme-options-page.php';

// Metabox configs for Front Page
require_once VCPC_DIR . '/inc/metaboxes/hero.php';
require_once VCPC_DIR . '/inc/metaboxes/philosophy.php';
require_once VCPC_DIR . '/inc/metaboxes/milan-teaser.php';
require_once VCPC_DIR . '/inc/metaboxes/coming-soon.php';
require_once VCPC_DIR . '/inc/metaboxes/join.php';
require_once VCPC_DIR . '/inc/metaboxes/story.php';
require_once VCPC_DIR . '/inc/metaboxes/milan-full.php';
require_once VCPC_DIR . '/inc/metaboxes/dali-fashion.php';
require_once VCPC_DIR . '/inc/metaboxes/salvador-dali.php';
require_once VCPC_DIR . '/inc/metaboxes/angelo-seminara.php';
require_once VCPC_DIR . '/inc/metaboxes/contact.php';
require_once VCPC_DIR . '/inc/metaboxes/layout-settings.php';

// Leads & Form endpoint
require_once VCPC_DIR . '/inc/lead-cpt.php';
require_once VCPC_DIR . '/inc/rest-api.php';

/**
 * Cleanup header output.
 */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

// Seeding removed to ensure empty default page meta behavior as requested.

/**
 * Retrieve metabox fields with clean fallbacks.
 */
function vcpc_field( $field_key, $fallback = '' ) {
	$post_id = 0;
	if ( is_singular() ) {
		$post_id = get_queried_object_id();
	}
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	if ( ! $post_id ) {
		$post_id = (int) get_option( 'page_on_front' );
	}
	if ( ! $post_id ) {
		return $fallback;
	}
	
	$meta_exists = metadata_exists( 'post', $post_id, '_vcpc_' . $field_key );
	if ( ! $meta_exists ) {
		return $fallback;
	}

	$val = get_post_meta( $post_id, '_vcpc_' . $field_key, true );
	return ( '' !== $val && null !== $val ) ? $val : $fallback;
}

/**
 * Determine page-specific layout overrides directly.
 */
function vcpc_should_hide_header() {
	if ( ! is_singular() ) {
		return false;
	}
	$post_id = get_queried_object_id();
	if ( ! $post_id ) {
		return false;
	}
	$val = get_post_meta( $post_id, '_vcpc_layout_settings_hide_header', true );
	return ( 'yes' === strtolower( trim( $val ) ) );
}

function vcpc_should_hide_footer() {
	if ( ! is_singular() ) {
		return false;
	}
	$post_id = get_queried_object_id();
	if ( ! $post_id ) {
		return false;
	}
	$val = get_post_meta( $post_id, '_vcpc_layout_settings_hide_footer', true );
	return ( 'yes' === strtolower( trim( $val ) ) );
}
