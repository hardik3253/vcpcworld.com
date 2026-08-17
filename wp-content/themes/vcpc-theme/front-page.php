<?php
/**
 * The one-page landing template. Assign the Page you create in wp-admin
 * as the Front Page (Settings > Reading) — this file will then render it.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<main id="main-content">
	<?php 
	// Render default Block Editor content/custom layout blocks from backend first
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			the_content();
		}
	}
	?>

	<?php if ( vcpc_should_render_section( 'hero' ) ) : ?><?php get_template_part( 'template-parts/section', 'hero' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'philosophy' ) ) : ?><?php get_template_part( 'template-parts/section', 'philosophy' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'milan_teaser' ) ) : ?><?php get_template_part( 'template-parts/section', 'milan-teaser' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'coming_soon' ) ) : ?><?php get_template_part( 'template-parts/section', 'coming-soon' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'join' ) ) : ?><?php get_template_part( 'template-parts/section', 'join' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'diagnosis' ) ) : ?><?php get_template_part( 'template-parts/section', 'diagnosis' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'story' ) ) : ?><?php get_template_part( 'template-parts/section', 'story' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'milan_full' ) ) : ?><?php get_template_part( 'template-parts/section', 'milan-full' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'dali_fashion' ) ) : ?><?php get_template_part( 'template-parts/section', 'dali-fashion' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'salvador_dali' ) ) : ?><?php get_template_part( 'template-parts/section', 'salvador-dali' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'angelo_seminara' ) ) : ?><?php get_template_part( 'template-parts/section', 'angelo-seminara' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'contact' ) ) : ?><?php get_template_part( 'template-parts/section', 'contact' ); ?><?php endif; ?>
</main>

<?php get_footer(); ?>
