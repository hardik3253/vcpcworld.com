<?php if ( ! defined( 'ABSPATH' ) ) exit; 

$eyebrow    = vcpc_field( 'dali_fashion_eyebrow', '' );
$heading    = vcpc_field( 'dali_fashion_heading', '' );
$content    = vcpc_field( 'dali_fashion_content', '' );
$media_id   = vcpc_field( 'dali_fashion_media', 0 );
$gallery_raw = vcpc_field( 'dali_fashion_gallery', '' );

// Gather all media IDs (primary image first, followed by gallery images)
$gallery_ids = array_filter( array_map( 'absint', explode( ',', (string) $gallery_raw ) ) );
$all_media_ids = [];
if ( $media_id ) {
	$all_media_ids[] = absint( $media_id );
}
foreach ( $gallery_ids as $gid ) {
	if ( ! in_array( $gid, $all_media_ids, true ) ) {
		$all_media_ids[] = $gid;
	}
}

if ( ! empty( $eyebrow ) || ! empty( $heading ) || ! empty( $content ) || ! empty( $all_media_ids ) ) :

	$has_gallery = ( count( $all_media_ids ) > 1 );
	$section_classes = 'section section--exhibition';
	if ( $has_gallery ) {
		$section_classes .= ' has-scroll-gallery';
	}
	?>
	<section class="<?php echo esc_attr( $section_classes ); ?>" id="dali-fashion">
		<div class="section__inner exhibition__inner">
			<div class="exhibition__grid">
				
				<?php if ( ! empty( $all_media_ids ) ) : ?>
					<div class="exhibition__media <?php echo $has_gallery ? 'has-scroll-gallery-media' : ''; ?>" <?php echo $has_gallery ? '' : 'data-anim="fade-up"'; ?>>
						<div class="scroll-gallery" data-count="<?php echo count( $all_media_ids ); ?>">
							<?php foreach ( $all_media_ids as $idx => $img_id ) : 
								$mime = get_post_mime_type( $img_id );
								$is_video = ( strpos( $mime, 'video' ) !== false );
								$caption = wp_get_attachment_caption( $img_id );
								?>
								<div class="scroll-gallery__item <?php echo ( 0 === $idx ) ? 'is-active' : ''; ?>" data-slide-index="<?php echo $idx; ?>">
									<?php if ( $is_video ) : ?>
										<video class="exhibition__video scroll-gallery__media" src="<?php echo esc_url( wp_get_attachment_url( $img_id ) ); ?>" controls loop muted playsinline></video>
									<?php else : ?>
										<?php echo wp_get_attachment_image( $img_id, 'large', false, [ 'class' => 'exhibition__img scroll-gallery__img' ] ); ?>
									<?php endif; ?>
									<?php if ( ! empty( $caption ) ) : ?>
										<div class="scroll-gallery__caption"><?php echo esc_html( $caption ); ?></div>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

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

			</div>
		</div>
	</section>
<?php endif; ?>
