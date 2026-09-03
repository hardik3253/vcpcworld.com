<?php
if ( ! defined( 'ABSPATH' ) ) exit;

new VCPC_Metabox( 'dali_fashion', __( 'VCPC Section: Dalí & Fashion', 'vcpc' ), [
	'dali_fashion_eyebrow' => [
		'label' => __( 'Eyebrow', 'vcpc' ),
		'type'  => 'text',
	],
	'dali_fashion_heading' => [
		'label' => __( 'Heading', 'vcpc' ),
		'type'  => 'text',
	],
	'dali_fashion_content' => [
		'label' => __( 'Content', 'vcpc' ),
		'type'  => 'wysiwyg',
	],
	'dali_fashion_media' => [
		'label' => __( 'Primary Image (or Video)', 'vcpc' ),
		'type'  => 'media',
		'desc'  => __( 'First image displayed initially.', 'vcpc' ),
	],
	'dali_fashion_gallery' => [
		'label' => __( 'Additional Images for Scroll Transition (Gallery)', 'vcpc' ),
		'type'  => 'gallery',
		'desc'  => __( 'Select additional images. Content stays fixed while scrolling transitions sequentially through these images.', 'vcpc' ),
	],
] );
