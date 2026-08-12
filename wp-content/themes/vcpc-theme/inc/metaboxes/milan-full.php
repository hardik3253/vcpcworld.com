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
	'milan_full_content' => [
		'label' => __( 'Milan Full Content', 'vcpc' ),
		'type'  => 'wysiwyg',
	],
	'milan_full_media' => [
		'label' => __( 'Right Side Image (or Video)', 'vcpc' ),
		'type'  => 'media',
	],
] );
