<?php if ( ! defined( 'ABSPATH' ) ) exit; 

$eyebrow    = vcpc_field( 'milan_full_eyebrow', '' );
$heading    = vcpc_field( 'milan_full_heading', '' );
$para_json  = vcpc_field( 'milan_full_paragraphs', '' );
$media_id   = vcpc_field( 'milan_full_media', 0 );

$paragraphs = [];
if ( $para_json ) {
	$paragraphs = json_decode( $para_json, true );
}
if ( ! is_array( $paragraphs ) ) {
	$paragraphs = [];
}

// Show section only if data exists
if ( ! empty( $eyebrow ) || ! empty( $heading ) || ! empty( $paragraphs ) || ! empty( $media_id ) ) :

	$is_video = false;
	$media_html = '';
	if ( $media_id ) {
		$mime = get_post_mime_type( $media_id );
		if ( strpos( $mime, 'video' ) !== false ) {
			$is_video = true;
			$video_url = wp_get_attachment_url( $media_id );
			$media_html = '<video class="milan-full__video" src="' . esc_url( $video_url ) . '" controls loop muted playsinline></video>';
		} else {
			$media_html = wp_get_attachment_image( $media_id, 'large', false, [ 'class' => 'milan-full__img' ] );
		}
	}
	?>
	<section class="section section--milan-full" id="milan">
		<div class="section__inner milan-full__inner">
			<div class="milan-full__grid">
				<?php if ( $media_html ) : ?>
					<div class="milan-full__media" data-anim="fade-up">
						<?php echo $media_html; ?>
					</div>
				<?php endif; ?>
				
				<div class="milan-full__content text-measure" data-anim="fade-up">
					<?php if ( ! empty( $eyebrow ) ) : ?>
						<p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $heading ) ) : ?>
						<h2 class="section__heading"><?php echo esc_html( $heading ); ?></h2>
					<?php endif; ?>
					
					<?php if ( ! empty( $paragraphs ) ) : ?>
						<div class="milan-full__paragraphs">
							<?php foreach ( $paragraphs as $row ) : 
								if ( empty( $row['paragraph'] ) ) continue;
								?>
								<p><?php echo esc_html( $row['paragraph'] ); ?></p>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
