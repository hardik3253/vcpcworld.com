<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function vcpc_enqueue_assets() {
	// Fonts (self-hosted — drop .woff2 files into assets/fonts and uncomment)
	// wp_enqueue_style( 'vcpc-fonts', VCPC_URI . '/assets/fonts/fonts.css', [], VCPC_VERSION );

	wp_enqueue_style( 'vcpc-main', VCPC_URI . '/assets/css/main.css', [], VCPC_VERSION );

	// GSAP for scroll animations (loaded from a CDN — swap for a local copy if you need offline builds)
	wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', [], '3.12.5', true );
	wp_enqueue_script( 'gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', [ 'gsap' ], '3.12.5', true );

	wp_enqueue_script( 'vcpc-animations', VCPC_URI . '/assets/js/animations.js', [ 'gsap', 'gsap-scrolltrigger' ], VCPC_VERSION, true );
	wp_enqueue_script( 'vcpc-main', VCPC_URI . '/assets/js/main.js', [], VCPC_VERSION, true );

	wp_enqueue_script( 'vcpc-form', VCPC_URI . '/assets/js/form-handler.js', [], VCPC_VERSION, true );
	wp_localize_script( 'vcpc-form', 'vcpcForm', [
		'endpoint' => esc_url_raw( rest_url( 'vcpc/v1/join' ) ),
		'nonce'    => wp_create_nonce( 'wp_rest' ),
	] );
}
add_action( 'wp_enqueue_scripts', 'vcpc_enqueue_assets' );
