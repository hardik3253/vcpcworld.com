<?php if ( ! defined( 'ABSPATH' ) ) exit; 

$eyebrow       = vcpc_field( 'hero_hero_eyebrow', '' );
$headline      = vcpc_field( 'hero_hero_headline', '' );
$subheadline   = vcpc_field( 'hero_hero_subheadline', '' );
$line_1        = vcpc_field( 'hero_hero_line_1', '' );
$line_2        = vcpc_field( 'hero_hero_line_2', '' );
$cta_label     = vcpc_field( 'hero_hero_cta_label', '' );
$cta_target    = vcpc_field( 'hero_hero_cta_target', '' );
$bg_image_id   = vcpc_field( 'hero_hero_background_image', 0 );

// Show section only if at least one parameter is set
if ( ! empty( $eyebrow ) || ! empty( $headline ) || ! empty( $subheadline ) || ! empty( $line_1 ) || ! empty( $line_2 ) || ! empty( $cta_label ) || ! empty( $bg_image_id ) ) :

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
				<?php if ( ! empty( $eyebrow ) ) : ?>
					<p class="eyebrow" data-anim="fade-up"><?php echo esc_html( $eyebrow ); ?></p>
				<?php endif; ?>
				
				<?php if ( ! empty( $headline ) || ! empty( $subheadline ) ) : ?>
					<h1 class="hero__heading" data-anim="fade-up">
						<?php echo esc_html( $headline ); ?>
						<?php if ( ! empty( $subheadline ) ) : ?>
							<br><span class="hero__heading--accent"><?php echo esc_html( $subheadline ); ?></span>
						<?php endif; ?>
					</h1>
				<?php endif; ?>

				<?php if ( ! empty( $line_1 ) || ! empty( $line_2 ) ) : ?>
					<p class="hero__tagline" data-anim="fade-up">
						<?php if ( ! empty( $line_1 ) ) : ?>
							<strong><?php echo esc_html( $line_1 ); ?></strong>
						<?php endif; ?>
						<?php if ( ! empty( $line_2 ) ) : ?>
							<span><?php echo esc_html( $line_2 ); ?></span>
						<?php endif; ?>
					</p>
				<?php endif; ?>

				<?php if ( ! empty( $cta_label ) ) : ?>
					<div class="hero__cta-wrapper" data-anim="fade-up">
						<a href="<?php echo esc_attr( ! empty( $cta_target ) ? $cta_target : '#join' ); ?>" class="btn btn--primary">
							<?php echo esc_html( $cta_label ); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<div class="hero__scroll-cue" aria-hidden="true">↓</div>
	</section>
<?php endif; ?>
