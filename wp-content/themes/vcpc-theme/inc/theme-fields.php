<?php
/**
 * Native WordPress custom fields for the VCPC landing page.
 * No ACF. Uses a plain meta box + register_post_meta() so the client
 * can still edit copy from wp-admin without any page-builder plugin.
 *
 * The meta box only shows on the Page that is set as the site's
 * Front Page (Settings > Reading > Front page displays > A static page).
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/** ---------------------------------------------------------
 * Field schema: one entry per editable string.
 * key => [ label, type ('text'|'textarea'|'url'|'email'), section ]
 * ------------------------------------------------------- */
function vcpc_field_schema() {
	return [
		// Hero
		'hero_eyebrow'      => [ 'Hero — Eyebrow', 'text', 'Hero' ],
		'hero_heading'      => [ 'Hero — Heading', 'text', 'Hero' ],
		'hero_subheading'   => [ 'Hero — Subheading', 'text', 'Hero' ],
		'hero_tagline'      => [ 'Hero — Tagline', 'textarea', 'Hero' ],
		'hero_cta_label'    => [ 'Hero — CTA Label', 'text', 'Hero' ],

		// Philosophy
		'philosophy_kicker' => [ 'Philosophy — Kicker', 'text', 'Philosophy' ],
		'philosophy_lines'  => [ 'Philosophy — Stacked lines (one per row)', 'textarea', 'Philosophy' ],
		'philosophy_body'   => [ 'Philosophy — Body copy', 'textarea', 'Philosophy' ],

		// Milan teaser
		'milan_teaser_kicker' => [ 'Milan Teaser — Kicker', 'text', 'Milan Teaser' ],
		'milan_teaser_body'   => [ 'Milan Teaser — Body copy', 'textarea', 'Milan Teaser' ],
		'milan_teaser_cta'    => [ 'Milan Teaser — CTA Label', 'text', 'Milan Teaser' ],

		// Coming soon
		'lab_title'  => [ 'Coming Soon — Protection Lab Title', 'text', 'Coming Soon' ],
		'lab_sub'    => [ 'Coming Soon — Protection Lab Subtitle', 'text', 'Coming Soon' ],
		'dose_title' => [ 'Coming Soon — Protection Dose Title', 'text', 'Coming Soon' ],
		'dose_sub'   => [ 'Coming Soon — Protection Dose Subtitle', 'text', 'Coming Soon' ],

		// Join the Journey
		'join_heading' => [ 'Join — Heading', 'text', 'Join the Journey' ],
		'join_body'    => [ 'Join — Body copy', 'textarea', 'Join the Journey' ],

		// Story
		'story_kicker' => [ 'Story — Kicker', 'text', 'Story' ],
		'story_body'   => [ 'Story — Body copy (paragraphs separated by blank line)', 'textarea', 'Story' ],

		// Milan full
		'milan_full_kicker' => [ 'From Milan (full) — Kicker', 'text', 'From Milan' ],
		'milan_full_body'   => [ 'From Milan (full) — Body copy', 'textarea', 'From Milan' ],

		// Contact
		'contact_press_email' => [ 'Contact — Press Email', 'email', 'Contact' ],
		'contact_general_email' => [ 'Contact — General Enquiries Email', 'email', 'Contact' ],

		// Footer / social
		'social_instagram' => [ 'Footer — Instagram URL', 'url', 'Footer' ],
		'social_youtube'   => [ 'Footer — YouTube URL', 'url', 'Footer' ],
		'social_linkedin'  => [ 'Footer — LinkedIn URL', 'url', 'Footer' ],
	];
}

/** ---------------------------------------------------------
 * Register meta so it's readable via REST/get_post_meta cleanly
 * ------------------------------------------------------- */
function vcpc_register_post_meta() {
	foreach ( vcpc_field_schema() as $key => $config ) {
		register_post_meta( 'page', '_vcpc_' . $key, [
			'show_in_rest' => false,
			'single'       => true,
			'type'         => 'string',
			'auth_callback' => function () { return current_user_can( 'edit_pages' ); },
		] );
	}
}
add_action( 'init', 'vcpc_register_post_meta' );

/** ---------------------------------------------------------
 * Meta box — only on the configured Front Page
 * ------------------------------------------------------- */
function vcpc_add_meta_box() {
	$front_id = (int) get_option( 'page_on_front' );
	if ( ! $front_id ) return;

	add_meta_box(
		'vcpc_landing_fields',
		__( 'VCPC Landing Page Content', 'vcpc' ),
		'vcpc_render_meta_box',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'vcpc_add_meta_box' );

function vcpc_render_meta_box( $post ) {
	$front_id = (int) get_option( 'page_on_front' );
	if ( $post->ID !== $front_id ) {
		echo '<p>' . esc_html__( 'This box only applies to the page set as your site\'s Front Page (Settings > Reading).', 'vcpc' ) . '</p>';
		return;
	}

	wp_nonce_field( 'vcpc_save_fields', 'vcpc_fields_nonce' );

	$schema = vcpc_field_schema();
	$sections = [];
	foreach ( $schema as $key => $config ) {
		$sections[ $config[2] ][ $key ] = $config;
	}

	foreach ( $sections as $section_label => $fields ) {
		echo '<h3 style="margin-top:20px;border-bottom:1px solid #ddd;padding-bottom:6px;">' . esc_html( $section_label ) . '</h3>';
		foreach ( $fields as $key => $config ) {
			list( $label, $type ) = $config;
			$value = get_post_meta( $post->ID, '_vcpc_' . $key, true );
			echo '<p><label for="vcpc_' . esc_attr( $key ) . '"><strong>' . esc_html( $label ) . '</strong></label><br/>';
			if ( 'textarea' === $type ) {
				echo '<textarea style="width:100%;" rows="4" id="vcpc_' . esc_attr( $key ) . '" name="vcpc_fields[' . esc_attr( $key ) . ']">' . esc_textarea( $value ) . '</textarea>';
			} else {
				echo '<input type="text" style="width:100%;" id="vcpc_' . esc_attr( $key ) . '" name="vcpc_fields[' . esc_attr( $key ) . ']" value="' . esc_attr( $value ) . '" />';
			}
			echo '</p>';
		}
	}
}

function vcpc_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['vcpc_fields_nonce'] ) || ! wp_verify_nonce( $_POST['vcpc_fields_nonce'], 'vcpc_save_fields' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_page', $post_id ) ) return;
	if ( ! isset( $_POST['vcpc_fields'] ) ) return;

	$schema = vcpc_field_schema();
	foreach ( $schema as $key => $config ) {
		if ( ! isset( $_POST['vcpc_fields'][ $key ] ) ) continue;
		$type  = $config[1];
		$raw   = wp_unslash( $_POST['vcpc_fields'][ $key ] );
		$clean = ( 'textarea' === $type ) ? sanitize_textarea_field( $raw ) : sanitize_text_field( $raw );
		update_post_meta( $post_id, '_vcpc_' . $key, $clean );
	}
}
add_action( 'save_post_page', 'vcpc_save_meta_box' );

/** ---------------------------------------------------------
 * Helper: get a field value with a hardcoded fallback (from the
 * approved copy deck) so the site works even before an editor
 * touches wp-admin.
 * ------------------------------------------------------- */
function vcpc_field( $key, $fallback = '' ) {
	$front_id = (int) get_option( 'page_on_front' );
	if ( ! $front_id ) return $fallback;
	$value = get_post_meta( $front_id, '_vcpc_' . $key, true );
	return ( '' !== $value && null !== $value ) ? $value : $fallback;
}
