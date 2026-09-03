<?php
if ( ! defined( 'ABSPATH' ) ) exit;

new VCPC_Metabox( 'milan_full', __( 'VCPC Section: From Milan Full', 'vcpc' ), [
	'milan_full_eyebrow' => [
		'label' => __( 'Eyebrow', 'vcpc' ),
		'type'  => 'text',
	],
	'milan_full_heading' => [
		'label' => __( 'Heading', 'vcpc' ),
		'type'  => 'text',
	],
	'milan_full_content' => [
		'label' => __( 'Milan Full Content', 'vcpc' ),
		'type'  => 'wysiwyg',
	],
	'milan_full_media' => [
		'label' => __( 'Primary Image (or Video)', 'vcpc' ),
		'type'  => 'media',
		'desc'  => __( 'First image displayed initially.', 'vcpc' ),
	],
	'milan_full_gallery' => [
		'label' => __( 'Additional Images for Scroll Transition (Gallery)', 'vcpc' ),
		'type'  => 'gallery',
		'desc'  => __( 'Select additional images. The left content stays fixed while scrolling transitions sequentially through these images.', 'vcpc' ),
	],
] );
