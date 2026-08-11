<?php
if ( ! defined( 'ABSPATH' ) ) exit;

new VCPC_Metabox( 'milan_teaser', __( 'VCPC Section: From Milan Teaser', 'vcpc' ), [
	'milan_teaser_heading' => [
		'label' => __( 'Heading', 'vcpc' ),
		'type'  => 'text',
	],
	'milan_teaser_paragraphs' => [
		'label' => __( 'Paragraphs (Repeater)', 'vcpc' ),
		'type'  => 'repeater',
		'fields' => [
			'paragraph' => [
				'label' => __( 'Paragraph Text', 'vcpc' ),
				'type'  => 'textarea',
			],
		],
	],
	'milan_teaser_link_label' => [
		'label' => __( 'Link Label', 'vcpc' ),
		'type'  => 'text',
		'desc'  => __( 'Default: "Discover More"', 'vcpc' ),
	],
	'milan_teaser_link_target' => [
		'label' => __( 'Link Target', 'vcpc' ),
		'type'  => 'text',
		'desc'  => __( 'Default: "#milan"', 'vcpc' ),
	],
	'milan_teaser_background_image' => [
		'label' => __( 'Background Image', 'vcpc' ),
		'type'  => 'media',
	],
] );
