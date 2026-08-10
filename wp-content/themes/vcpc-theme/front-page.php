<?php
/**
 * The one-page landing template. Assign the Page you create in wp-admin
 * as the Front Page (Settings > Reading) — this file will then render it.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<main id="main-content">
	<?php get_template_part( 'template-parts/section', 'hero' ); ?>
	<?php get_template_part( 'template-parts/section', 'philosophy' ); ?>
	<?php get_template_part( 'template-parts/section', 'milan-teaser' ); ?>
	<?php get_template_part( 'template-parts/section', 'coming-soon' ); ?>
	<?php get_template_part( 'template-parts/section', 'join' ); ?>
	<?php get_template_part( 'template-parts/section', 'story' ); ?>
	<?php get_template_part( 'template-parts/section', 'milan-full' ); ?>
	<?php get_template_part( 'template-parts/section', 'contact' ); ?>
</main>

<?php get_footer(); ?>
