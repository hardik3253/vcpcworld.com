<?php if ( ! defined( 'ABSPATH' ) ) exit; 

$heading      = vcpc_field( 'milan_teaser_milan_teaser_heading', '' );
$para_json    = vcpc_field( 'milan_teaser_milan_teaser_paragraphs', '' );
$link_label   = vcpc_field( 'milan_teaser_milan_teaser_link_label', '' );
$link_target  = vcpc_field( 'milan_teaser_milan_teaser_link_target', '' );
$bg_image_id  = vcpc_field( 'milan_teaser_milan_teaser_background_image', 0 );

$paragraphs = [];
if ( $para_json ) {
	$paragraphs = json_decode( $para_json, true );
}
if ( ! is_array( $paragraphs ) ) {
	$paragraphs = [];
}

// Show section only if data exists
if ( ! empty( $heading ) || ! empty( $paragraphs ) || ! empty( $link_label ) || ! empty( $bg_image_id ) ) :

	$bg_style = '';
	if ( $bg_image_id ) {
		$bg_url = wp_get_attachment_image_url( $bg_image_id, 'full' );
		if ( $bg_url ) {
			$bg_style = ' style="background-image: url(' . esc_url( $bg_url ) . ');"';
		}
	}
	?>
	<section class="section section--milan-teaser parallax-bg" id="milan-teaser"<?php echo $bg_style; ?>>
		<div class="milan-teaser__overlay"></div>
		<div class="section__inner milan-teaser__inner">
			<div class="milan-teaser__content text-measure">
				<?php if ( ! empty( $heading ) ) : ?>
					<h2 class="section__heading" data-anim="fade-up"><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>
				
				<?php if ( ! empty( $paragraphs ) ) : ?>
					<div class="milan-teaser__body" data-anim="fade-up">
						<?php foreach ( $paragraphs as $row ) : 
							if ( empty( $row['paragraph'] ) ) continue;
							?>
							<p><?php echo esc_html( $row['paragraph'] ); ?></p>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $link_label ) ) : ?>
					<div class="milan-teaser__cta" data-anim="fade-up">
						<a href="<?php echo esc_attr( ! empty( $link_target ) ? $link_target : '#milan' ); ?>" class="btn btn--outline">
							<?php echo esc_html( $link_label ); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
