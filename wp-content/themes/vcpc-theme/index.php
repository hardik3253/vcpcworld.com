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
	get_template_part( 'template-parts/section', 'hero' );
	get_template_part( 'template-parts/section', 'philosophy' );
	get_template_part( 'template-parts/section', 'milan-teaser' );
	get_template_part( 'template-parts/section', 'coming-soon' );
	get_template_part( 'template-parts/section', 'join' );
	get_template_part( 'template-parts/section', 'story' );
	get_template_part( 'template-parts/section', 'milan-full' );
	get_template_part( 'template-parts/section', 'contact' );
	?>
</main>
<?php get_footer(); ?>
