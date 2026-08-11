<?php
if ( ! defined( 'ABSPATH' ) ) exit;

new VCPC_Metabox( 'philosophy', __( 'VCPC Section: Philosophy', 'vcpc' ), [
	'philosophy_eyebrow' => [
		'label' => __( 'Eyebrow', 'vcpc' ),
		'type'  => 'text',
	],
	'philosophy_intro' => [
		'label' => __( 'Intro Headline', 'vcpc' ),
		'type'  => 'text',
		'desc'  => __( 'Default: "Beautiful hair begins with protection."', 'vcpc' ),
	],
	'philosophy_intro_suffix' => [
		'label' => __( 'Intro Suffix / Accent text', 'vcpc' ),
		'type'  => 'text',
		'desc'  => __( 'Default: "(“Hair Treatments”)"', 'vcpc' ),
	],
	'philosophy_reveal_lines' => [
		'label' => __( 'Staggered Reveal Lines (Repeater)', 'vcpc' ),
		'type'  => 'repeater',
		'fields' => [
			'line' => [
				'label' => __( 'Line Text', 'vcpc' ),
				'type'  => 'text',
			],
		],
		'desc'  => __( 'Default: "Every colour.", "Every cut.", "Every style.", "Starts with healthy, protected hair."', 'vcpc' ),
	],
	'philosophy_paragraph' => [
		'label' => __( 'Paragraph', 'vcpc' ),
		'type'  => 'textarea',
	],
] );
