<?php
if ( ! defined( 'ABSPATH' ) ) exit;

new VCPC_Metabox( 'hero', __( 'VCPC Section: Hero', 'vcpc' ), [
	'hero_eyebrow' => [
		'label' => __( 'Eyebrow', 'vcpc' ),
		'type'  => 'text',
		'desc'  => __( 'Default: "VCPC"', 'vcpc' ),
	],
	'hero_headline' => [
		'label' => __( 'Headline', 'vcpc' ),
		'type'  => 'text',
		'desc'  => __( 'Default: "Care with Fashion"', 'vcpc' ),
	],
	'hero_subheadline' => [
		'label' => __( 'Subheadline', 'vcpc' ),
		'type'  => 'text',
		'desc'  => __( 'Default: "Protection Comes First™"', 'vcpc' ),
	],
	'hero_line_1' => [
		'label' => __( 'Line 1', 'vcpc' ),
		'type'  => 'text',
		'desc'  => __( 'Default: "India\'s Luxury Professional Haircare House."', 'vcpc' ),
	],
	'hero_line_2' => [
		'label' => __( 'Line 2', 'vcpc' ),
		'type'  => 'text',
		'desc'  => __( 'Default: "Inspired by fashion. Guided by art. Built by professionals."', 'vcpc' ),
	],
	'hero_cta_label' => [
		'label' => __( 'CTA Label', 'vcpc' ),
		'type'  => 'text',
		'desc'  => __( 'Default: "Join the Journey"', 'vcpc' ),
	],
	'hero_cta_target' => [
		'label' => __( 'CTA Target', 'vcpc' ),
		'type'  => 'text',
		'desc'  => __( 'Default: "#join"', 'vcpc' ),
	],
	'hero_right_image' => [
		'label' => __( 'Right Side Image', 'vcpc' ),
		'type'  => 'media',
	],
	'hero_background_image' => [
		'label' => __( 'Background Image', 'vcpc' ),
		'type'  => 'media',
	],
] );
