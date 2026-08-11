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
</main>
<?php get_footer(); ?>
