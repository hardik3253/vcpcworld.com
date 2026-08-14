<?php if ( ! defined( 'ABSPATH' ) ) exit; 

$eyebrow    = vcpc_field( 'salvador_dali_eyebrow', '' );
$heading    = vcpc_field( 'salvador_dali_heading', '' );
$content    = vcpc_field( 'salvador_dali_content', '' );
$media_id   = vcpc_field( 'salvador_dali_media', 0 );

if ( ! empty( $eyebrow ) || ! empty( $heading ) || ! empty( $content ) || ! empty( $media_id ) ) :

	$is_video = false;
	$media_html = '';
	if ( $media_id ) {
		$mime = get_post_mime_type( $media_id );
		if ( strpos( $mime, 'video' ) !== false ) {
			$is_video = true;
			$video_url = wp_get_attachment_url( $media_id );
			$media_html = '<video class="exhibition__video" src="' . esc_url( $video_url ) . '" controls loop muted playsinline></video>';
		} else {
			$media_html = wp_get_attachment_image( $media_id, 'large', false, [ 'class' => 'exhibition__img' ] );
		}
	}
	?>
	<section class="section section--exhibition" id="salvador-dali">
		<div class="section__inner exhibition__inner">
			<div class="exhibition__grid">
				
				<div class="exhibition__content text-measure" data-anim="fade-up">
					<?php if ( ! empty( $eyebrow ) ) : ?>
						<p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $heading ) ) : ?>
						<h2 class="section__heading"><?php echo esc_html( $heading ); ?></h2>
					<?php endif; ?>
					
					<?php if ( ! empty( $content ) ) : ?>
						<div class="exhibition__paragraphs">
							<?php echo wp_kses_post( wpautop( $content ) ); ?>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( $media_html ) : ?>
					<div class="exhibition__media" data-anim="fade-up">
						<?php echo $media_html; ?>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</section>
<?php endif; ?>
