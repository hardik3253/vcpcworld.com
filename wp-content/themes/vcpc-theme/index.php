<?php
/**
 * Fallback template. The real page lives in front-page.php — this only
 * runs if WordPress can't match front-page.php (e.g. "Front page displays"
 * isn't set to "A static page" yet in Settings > Reading).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<main id="main-content">
	<div class="section__inner">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article>
				<div><?php the_content(); ?></div>
			</article>
		<?php endwhile; endif; ?>
	</div>
    
	<?php
	// Also render the theme's one-page sections (same as front-page.php)
	if ( vcpc_should_render_section( 'hero' ) ) : ?><?php get_template_part( 'template-parts/section', 'hero' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'philosophy' ) ) : ?><?php get_template_part( 'template-parts/section', 'philosophy' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'milan_teaser' ) ) : ?><?php get_template_part( 'template-parts/section', 'milan-teaser' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'coming_soon' ) ) : ?><?php get_template_part( 'template-parts/section', 'coming-soon' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'join' ) ) : ?><?php get_template_part( 'template-parts/section', 'join' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'story' ) ) : ?><?php get_template_part( 'template-parts/section', 'story' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'milan_full' ) ) : ?><?php get_template_part( 'template-parts/section', 'milan-full' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'dali_fashion' ) ) : ?><?php get_template_part( 'template-parts/section', 'dali-fashion' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'salvador_dali' ) ) : ?><?php get_template_part( 'template-parts/section', 'salvador-dali' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'angelo_seminara' ) ) : ?><?php get_template_part( 'template-parts/section', 'angelo-seminara' ); ?><?php endif; ?>
	<?php if ( vcpc_should_render_section( 'contact' ) ) : ?><?php get_template_part( 'template-parts/section', 'contact' ); ?><?php endif; ?>
	<?php
	?>
</main>
<?php get_footer(); ?>
