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
		'label' => __( 'Image (or Video)', 'vcpc' ),
		'type'  => 'media',
	],
] );
