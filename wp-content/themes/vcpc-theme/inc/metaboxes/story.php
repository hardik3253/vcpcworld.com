<?php
if ( ! defined( 'ABSPATH' ) ) exit;

new VCPC_Metabox( 'story', __( 'VCPC Section: Story', 'vcpc' ), [
	'story_eyebrow' => [
		'label' => __( 'Eyebrow', 'vcpc' ),
		'type'  => 'text',
	],
	'story_heading' => [
		'label' => __( 'Heading', 'vcpc' ),
		'type'  => 'text',
		'desc'  => __( 'Default: "Protection First™"', 'vcpc' ),
	],
	'story_paragraphs' => [
		'label' => __( 'Paragraphs (Repeater)', 'vcpc' ),
		'type'  => 'repeater',
		'fields' => [
			'paragraph' => [
				'label' => __( 'Paragraph Text', 'vcpc' ),
				'type'  => 'textarea',
			],
		],
	],
	'story_image' => [
		'label' => __( 'Image (Optional)', 'vcpc' ),
		'type'  => 'media',
	],
] );
