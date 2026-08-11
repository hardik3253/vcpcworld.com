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
	'milan_full_paragraphs' => [
		'label' => __( 'Paragraphs (Repeater)', 'vcpc' ),
		'type'  => 'repeater',
		'fields' => [
			'paragraph' => [
				'label' => __( 'Paragraph Text', 'vcpc' ),
				'type'  => 'textarea',
			],
		],
	],
	'milan_full_media' => [
		'label' => __( 'Media (Image or Self-hosted Video)', 'vcpc' ),
		'type'  => 'media',
	],
] );
