<?php
if ( ! defined( 'ABSPATH' ) ) exit;

new VCPC_Metabox( 'angelo_seminara', __( 'VCPC Section: Angelo Seminara', 'vcpc' ), [
	'angelo_seminara_eyebrow' => [
		'label' => __( 'Eyebrow', 'vcpc' ),
		'type'  => 'text',
	],
	'angelo_seminara_heading' => [
		'label' => __( 'Heading', 'vcpc' ),
		'type'  => 'text',
	],
	'angelo_seminara_content' => [
		'label' => __( 'Content', 'vcpc' ),
		'type'  => 'wysiwyg',
	],
	'angelo_seminara_media' => [
		'label' => __( 'Image (or Video)', 'vcpc' ),
		'type'  => 'media',
	],
] );
