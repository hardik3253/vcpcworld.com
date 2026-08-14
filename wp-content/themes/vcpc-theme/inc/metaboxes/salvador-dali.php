<?php
if ( ! defined( 'ABSPATH' ) ) exit;

new VCPC_Metabox( 'salvador_dali', __( 'VCPC Section: Salvador Dalí', 'vcpc' ), [
	'salvador_dali_eyebrow' => [
		'label' => __( 'Eyebrow', 'vcpc' ),
		'type'  => 'text',
	],
	'salvador_dali_heading' => [
		'label' => __( 'Heading', 'vcpc' ),
		'type'  => 'text',
	],
	'salvador_dali_content' => [
		'label' => __( 'Content', 'vcpc' ),
		'type'  => 'wysiwyg',
	],
	'salvador_dali_media' => [
		'label' => __( 'Image (or Video)', 'vcpc' ),
		'type'  => 'media',
	],
] );
