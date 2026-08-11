<?php
if ( ! defined( 'ABSPATH' ) ) exit;

new VCPC_Metabox( 'contact', __( 'VCPC Section: Contact', 'vcpc' ), [
	'contact_heading' => [
		'label' => __( 'Heading', 'vcpc' ),
		'type'  => 'text',
		'desc'  => __( 'Default: "Get in Touch"', 'vcpc' ),
	],
	'contact_entries' => [
		'label' => __( 'Contact Email Entries (Repeater)', 'vcpc' ),
		'type'  => 'repeater',
		'fields' => [
			'label' => [
				'label' => __( 'Label Text', 'vcpc' ),
				'type'  => 'text',
			],
			'email' => [
				'label' => __( 'Email Address', 'vcpc' ),
				'type'  => 'email',
			],
		],
		'desc' => __( 'Default rows: "Press -> press@vcpcworld.com", "General Enquiries -> hello@vcpcworld.com"', 'vcpc' ),
	],
] );
