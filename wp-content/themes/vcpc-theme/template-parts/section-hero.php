<?php if ( ! defined( 'ABSPATH' ) ) exit; 

$eyebrow       = vcpc_field( 'hero_hero_eyebrow', 'VCPC' );
$headline      = vcpc_field( 'hero_hero_headline', 'Care with Fashion' );
$subheadline   = vcpc_field( 'hero_hero_subheadline', 'Protection Comes First™' );
$line_1        = vcpc_field( 'hero_hero_line_1', "India's Luxury Professional Haircare House." );
$line_2        = vcpc_field( 'hero_hero_line_2', 'Inspired by fashion. Guided by art. Built by professionals.' );
$cta_label     = vcpc_field( 'hero_hero_cta_label', 'Join the Journey' );
$cta_target    = vcpc_field( 'hero_hero_cta_target', '#join' );
$bg_image_id   = vcpc_field( 'hero_hero_background_image', 0 );

$bg_style = '';
if ( $bg_image_id ) {
	$bg_url = wp_get_attachment_image_url( $bg_image_id, 'full' );
	if ( $bg_url ) {
		$bg_style = ' style="background-image: url(' . esc_url( $bg_url ) . ');"';
	}
}
?>
<section class="section section--hero" id="hero"<?php echo $bg_style; ?>>
	<div class="hero__overlay"></div>
	<div class="section__inner hero__inner">
		<div class="hero__content">
			<p class="eyebrow" data-anim="fade-up"><?php echo esc_html( $eyebrow ); ?></p>
			<h1 class="hero__heading" data-anim="fade-up">
				<?php echo esc_html( $headline ); ?><br>
				<span class="hero__heading--accent"><?php echo esc_html( $subheadline ); ?></span>
			</h1>
			<p class="hero__tagline" data-anim="fade-up">
				<strong><?php echo esc_html( $line_1 ); ?></strong><br>
				<span><?php echo esc_html( $line_2 ); ?></span>
			</p>
			<div class="hero__cta-wrapper" data-anim="fade-up">
				<a href="<?php echo esc_attr( $cta_target ); ?>" class="btn btn--primary">
					<?php echo esc_html( $cta_label ); ?>
				</a>
			</div>
		</div>
	</div>
	<div class="hero__scroll-cue" aria-hidden="true">↓</div>
</section>
