<?php
if ( ! defined( 'ABSPATH' ) ) exit;

new VCPC_Metabox( 'join', __( 'VCPC Section: Join the Journey', 'vcpc' ), [
	'join_heading' => [
		'label' => __( 'Heading', 'vcpc' ),
		'type'  => 'text',
	],
	'join_sublines' => [
		'label' => __( 'Sublines (Repeater)', 'vcpc' ),
		'type'  => 'repeater',
		'fields' => [
			'line' => [
				'label' => __( 'Line Text', 'vcpc' ),
				'type'  => 'text',
			],
		],
		'desc' => __( 'Default: "Be among the first to experience VCPC.", "Receive exclusive updates, launch invitations and early access."', 'vcpc' ),
	],
	'join_form_fields' => [
		'label' => __( 'Contact Form Fields (Repeater)', 'vcpc' ),
		'type'  => 'repeater',
		'fields' => [
			'field_name' => [
				'label' => __( 'Field Identifier / Name (e.g. "mobile")', 'vcpc' ),
				'type'  => 'text',
			],
			'field_label' => [
				'label' => __( 'Field Label (e.g. "Mobile Number *")', 'vcpc' ),
				'type'  => 'text',
			],
			'field_type' => [
				'label' => __( 'Field Type (e.g. "text", "email", "tel", "select")', 'vcpc' ),
				'type'  => 'text',
			],
			'field_required' => [
				'label' => __( 'Required? (Enter "yes" or leave empty)', 'vcpc' ),
				'type'  => 'text',
			]
		],
		'desc' => __( 'Add, update, or delete fields dynamically. Use "select" type to use the audience choices configured below.', 'vcpc' )
	],
	'join_audience_options' => [
		'label' => __( 'Audience Type Options (Repeater)', 'vcpc' ),
		'type'  => 'repeater',
		'fields' => [
			'label' => [
				'label' => __( 'Label Text', 'vcpc' ),
				'type'  => 'text',
			],
		],
		'desc' => __( 'Default rows: "Consumer", "Hair Professional", "Salon Owner", "Distributor", "Media". These populate the drop-down choices if you have a field with "select" type.', 'vcpc' ),
	],
	'join_submit_label' => [
		'label' => __( 'Submit Button Label', 'vcpc' ),
		'type'  => 'text',
		'desc'  => __( 'Default: "Join VCPC"', 'vcpc' ),
	],
] );
