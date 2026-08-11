<?php
if ( ! defined( 'ABSPATH' ) ) exit;

new VCPC_Metabox( 'layout_settings', __( 'VCPC Page Layout Settings', 'vcpc' ), [
	'hide_header' => [
		'label' => __( 'Hide Header on this page?', 'vcpc' ),
		'type'  => 'text',
		'desc'  => __( 'Enter "yes" to hide the Header menu on this page, or leave blank to show it.', 'vcpc' ),
	],
	'hide_footer' => [
		'label' => __( 'Hide Footer on this page?', 'vcpc' ),
		'type'  => 'text',
		'desc'  => __( 'Enter "yes" to hide the Footer on this page, or leave blank to show it.', 'vcpc' ),
	],
] );
