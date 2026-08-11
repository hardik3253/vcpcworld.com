<?php if ( ! defined( 'ABSPATH' ) ) exit; 

$heading      = vcpc_field( 'milan_teaser_milan_teaser_heading', 'From Milan' );
$para_json    = vcpc_field( 'milan_teaser_milan_teaser_paragraphs', '' );
$link_label   = vcpc_field( 'milan_teaser_milan_teaser_link_label', 'Discover More' );
$link_target  = vcpc_field( 'milan_teaser_milan_teaser_link_target', '#milan' );
$bg_image_id  = vcpc_field( 'milan_teaser_milan_teaser_background_image', 0 );

$bg_style = '';
if ( $bg_image_id ) {
	$bg_url = wp_get_attachment_image_url( $bg_image_id, 'full' );
	if ( $bg_url ) {
		$bg_style = ' style="background-image: url(' . esc_url( $bg_url ) . ');"';
	}
}

$paragraphs = [];
if ( $para_json ) {
	$paragraphs = json_decode( $para_json, true );
}
if ( empty( $paragraphs ) || ! is_array( $paragraphs ) ) {
	$paragraphs = [
		[ 'paragraph' => 'Born in the fashion capitals, engineered for modern salon environments. VCPC introduces high-performance formulas designed by leading experts.' ]
	];
}
?>
<section class="section section--milan-teaser parallax-bg" id="milan-teaser"<?php echo $bg_style; ?>>
	<div class="milan-teaser__overlay"></div>
	<div class="section__inner milan-teaser__inner">
		<div class="milan-teaser__content text-measure">
			<h2 class="section__heading" data-anim="fade-up"><?php echo esc_html( $heading ); ?></h2>
			
			<div class="milan-teaser__body" data-anim="fade-up">
				<?php foreach ( $paragraphs as $row ) : 
					if ( empty( $row['paragraph'] ) ) continue;
					?>
					<p><?php echo esc_html( $row['paragraph'] ); ?></p>
				<?php endforeach; ?>
			</div>

			<div class="milan-teaser__cta" data-anim="fade-up">
				<a href="<?php echo esc_attr( $link_target ); ?>" class="btn btn--outline">
					<?php echo esc_html( $link_label ); ?>
				</a>
			</div>
		</div>
	</div>
</section>
