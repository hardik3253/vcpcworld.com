<?php
if ( ! defined( 'ABSPATH' ) ) exit;

new VCPC_Metabox( 'coming_soon', __( 'VCPC Section: Coming Soon', 'vcpc' ), [
	'coming_soon_heading' => [
		'label' => __( 'Heading', 'vcpc' ),
		'type'  => 'text',
	],
	'coming_soon_items' => [
		'label' => __( 'Products/Features (Repeater)', 'vcpc' ),
		'type'  => 'repeater',
		'fields' => [
			'title' => [
				'label' => __( 'Title', 'vcpc' ),
				'type'  => 'text',
			],
			'description' => [
				'label' => __( 'Description', 'vcpc' ),
				'type'  => 'textarea',
			],
			'icon_image' => [
				'label' => __( 'Icon Image (Optional)', 'vcpc' ),
				'type'  => 'media',
			],
		],
		'desc'  => __( 'Default rows: "Protection Lab™ / Professional Hair Analysis.", "Protection Dose™ / Professional Hair Treatments at Home."', 'vcpc' ),
	],
] );
