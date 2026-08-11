<?php
/**
 * VCPC Theme functions
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'VCPC_VERSION', '1.0.0' );
define( 'VCPC_DIR', get_template_directory() );
define( 'VCPC_URI', get_template_directory_uri() );

// Required Modules & Helpers
require_once VCPC_DIR . '/inc/theme-setup.php';
require_once VCPC_DIR . '/inc/repeater-fields.php';

// Base Metabox class
require_once VCPC_DIR . '/inc/metaboxes/class-vcpc-metabox.php';

// Metabox configs for Front Page
require_once VCPC_DIR . '/inc/metaboxes/hero.php';
require_once VCPC_DIR . '/inc/metaboxes/philosophy.php';
require_once VCPC_DIR . '/inc/metaboxes/milan-teaser.php';
require_once VCPC_DIR . '/inc/metaboxes/coming-soon.php';
require_once VCPC_DIR . '/inc/metaboxes/join.php';
require_once VCPC_DIR . '/inc/metaboxes/story.php';
require_once VCPC_DIR . '/inc/metaboxes/milan-full.php';
require_once VCPC_DIR . '/inc/metaboxes/contact.php';

// Theme options
require_once VCPC_DIR . '/inc/theme-options-page.php';

// Leads & Form endpoint
require_once VCPC_DIR . '/inc/lead-cpt.php';
require_once VCPC_DIR . '/inc/rest-api.php';

/**
 * Cleanup header output.
 */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

/**
 * Seed defaults hook (creates static front page on theme activation if one does not exist,
 * and sets default meta values so site renders correctly right away).
 */
function vcpc_seed_theme_defaults() {
	// Create Landing page if it doesn't exist
	if ( ! get_option( 'page_on_front' ) ) {
		$page_id = wp_insert_post( [
			'post_title'   => 'VCPC Landing',
			'post_content' => '',
			'post_status'  => 'publish',
			'post_type'    => 'page',
		] );

		if ( $page_id && ! is_wp_error( $page_id ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $page_id );

			// Seed defaults for metaboxes
			update_post_meta( $page_id, '_vcpc_hero_eyebrow', 'VCPC' );
			update_post_meta( $page_id, '_vcpc_hero_headline', 'Care with Fashion' );
			update_post_meta( $page_id, '_vcpc_hero_subheadline', 'Protection Comes First™' );
			update_post_meta( $page_id, '_vcpc_hero_line_1', "India's Luxury Professional Haircare House." );
			update_post_meta( $page_id, '_vcpc_hero_line_2', 'Inspired by fashion. Guided by art. Built by professionals.' );
			update_post_meta( $page_id, '_vcpc_hero_cta_label', 'Join the Journey' );
			update_post_meta( $page_id, '_vcpc_hero_cta_target', '#join' );

			update_post_meta( $page_id, '_vcpc_philosophy_eyebrow', 'Philosophy' );
			update_post_meta( $page_id, '_vcpc_philosophy_intro', 'Beautiful hair begins with protection.' );
			update_post_meta( $page_id, '_vcpc_philosophy_intro_suffix', '(“Hair Treatments”)' );
			update_post_meta( $page_id, '_vcpc_philosophy_reveal_lines', wp_json_encode([
				[ 'line' => 'Every colour.' ],
				[ 'line' => 'Every cut.' ],
				[ 'line' => 'Every style.' ],
				[ 'line' => 'Starts with healthy, protected hair.' ],
			]) );
			update_post_meta( $page_id, '_vcpc_philosophy_paragraph', 'We believe fashion and care should co-exist. The hair design process must prioritize longevity, moisture-locking technologies, and cuticle shielding. VCPC represents that bridge: sophisticated artistry built upon scientific protection.' );

			update_post_meta( $page_id, '_vcpc_milan_teaser_heading', 'From Milan' );
			update_post_meta( $page_id, '_vcpc_milan_teaser_paragraphs', wp_json_encode([
				[ 'paragraph' => 'Born in the fashion capitals, engineered for modern salon environments. VCPC introduces high-performance formulas designed by leading experts.' ]
			]) );
			update_post_meta( $page_id, '_vcpc_milan_teaser_link_label', 'Discover More' );
			update_post_meta( $page_id, '_vcpc_milan_teaser_link_target', '#milan' );

			update_post_meta( $page_id, '_vcpc_coming_soon_heading', 'Coming Soon' );
			update_post_meta( $page_id, '_vcpc_coming_soon_items', wp_json_encode([
				[ 'title' => 'Protection Lab™ / Professional Hair Analysis.', 'description' => 'A comprehensive diagnostic suite for salons, providing high-precision structural readings of the hair shaft.', 'icon_image' => 0 ],
				[ 'title' => 'Protection Dose™ / Professional Hair Treatments at Home.', 'description' => 'Highly concentrated boosters designed to extend salon treatment results in daily residential routines.', 'icon_image' => 0 ]
			]) );

			update_post_meta( $page_id, '_vcpc_join_heading', 'Join the Journey' );
			update_post_meta( $page_id, '_vcpc_join_sublines', wp_json_encode([
				[ 'line' => 'Be among the first to experience VCPC.' ],
				[ 'line' => 'Receive exclusive updates, launch invitations and early access.' ]
			]) );
			update_post_meta( $page_id, '_vcpc_join_audience_options', wp_json_encode([
				[ 'label' => 'Consumer' ],
				[ 'label' => 'Hair Professional' ],
				[ 'label' => 'Salon Owner' ],
				[ 'label' => 'Distributor' ],
				[ 'label' => 'Media' ]
			]) );
			update_post_meta( $page_id, '_vcpc_join_submit_label', 'Join VCPC' );

			update_post_meta( $page_id, '_vcpc_story_eyebrow', 'The Story' );
			update_post_meta( $page_id, '_vcpc_story_heading', 'Protection First™' );
			update_post_meta( $page_id, '_vcpc_story_paragraphs', wp_json_encode([
				[ 'paragraph' => 'VCPC was founded on a simple principle: protection is not an afterthought, it is the foundation of beauty. In modern styling, hair is subject to extreme stressors. We wanted to design a range that empowers stylists while keeping hair structural integrity intact.' ],
				[ 'paragraph' => 'Every single treatment represents years of research into custom lipid replenishing matrices and bio-mimetic keratin chains. We are proud to launch India’s luxury professional haircare house, bridging Milanese fashion with high-end hair diagnostics.' ]
			]) );

			update_post_meta( $page_id, '_vcpc_milan_full_eyebrow', 'Milan Fashion Week 2026' );
			update_post_meta( $page_id, '_vcpc_milan_full_heading', 'The Runway Collaboration' );
			update_post_meta( $page_id, '_vcpc_milan_full_paragraphs', wp_json_encode([
				[ 'paragraph' => 'On the runways of Milan, hair experiences extreme stress with back-to-back styling, styling heat, and intensive product layers. VCPC served as the invisible protector behind the scenes.' ],
				[ 'paragraph' => 'We partnered with leading global houses to prep models, ensuring that hair retained its natural luster, flexibility, and structure despite daily styling transitions.' ]
			]) );

			update_post_meta( $page_id, '_vcpc_contact_heading', 'Get in Touch' );
			update_post_meta( $page_id, '_vcpc_contact_entries', wp_json_encode([
				[ 'label' => 'Press', 'email' => 'press@vcpcworld.com' ],
				[ 'label' => 'General Enquiries', 'email' => 'hello@vcpcworld.com' ]
			]) );

			// Options table defaults
			update_option( 'vcpc_footer_tagline', wp_json_encode([
				[ 'line' => 'Care with Fashion' ],
				[ 'line' => 'Protection Comes First™' ],
				[ 'line' => "India's Luxury Professional Haircare House." ]
			]) );
			update_option( 'vcpc_social_links', wp_json_encode([
				[ 'platform' => 'Instagram', 'url' => 'https://instagram.com/vcpc', 'icon' => 0 ],
				[ 'platform' => 'YouTube', 'url' => 'https://youtube.com/vcpc', 'icon' => 0 ],
				[ 'platform' => 'LinkedIn', 'url' => 'https://linkedin.com/company/vcpc', 'icon' => 0 ]
			]) );
			update_option( 'vcpc_copyright_text', '© VCPC' );
		}
	}
}
add_action( 'after_switch_theme', 'vcpc_seed_theme_defaults' );

/**
 * Retrieve metabox fields with clean fallbacks.
 */
function vcpc_field( $field_key, $fallback = '' ) {
	$front_id = (int) get_option( 'page_on_front' );
	if ( ! $front_id ) {
		return $fallback;
	}
	$val = get_post_meta( $front_id, '_vcpc_' . $field_key, true );
	return ( '' !== $val && null !== $val ) ? $val : $fallback;
}
