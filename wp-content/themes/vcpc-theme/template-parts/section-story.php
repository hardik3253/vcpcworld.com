<?php if ( ! defined( 'ABSPATH' ) ) exit; 

$eyebrow    = vcpc_field( 'story_story_eyebrow', '' );
$heading    = vcpc_field( 'story_story_heading', '' );
$para_json  = vcpc_field( 'story_story_paragraphs', '' );
$image_id   = vcpc_field( 'story_story_image', 0 );

$paragraphs = [];
if ( $para_json ) {
	$paragraphs = json_decode( $para_json, true );
}
if ( ! is_array( $paragraphs ) ) {
	$paragraphs = [];
}

// Show section only if data exists
if ( ! empty( $eyebrow ) || ! empty( $heading ) || ! empty( $paragraphs ) || ! empty( $image_id ) ) :
	?>
	<section class="section section--story" id="story">
		<div class="section__inner story__inner">
			<div class="story__grid">
				<div class="story__content text-measure" data-anim="fade-up">
					<?php if ( ! empty( $eyebrow ) ) : ?>
						<p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $heading ) ) : ?>
						<h2 class="section__heading"><?php echo esc_html( $heading ); ?></h2>
					<?php endif; ?>
					
					<?php if ( ! empty( $paragraphs ) ) : ?>
						<div class="story__paragraphs">
							<?php foreach ( $paragraphs as $row ) : 
								if ( empty( $row['paragraph'] ) ) continue;
								?>
								<p><?php echo esc_html( $row['paragraph'] ); ?></p>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
				
				<?php if ( $image_id ) : ?>
					<div class="story__media" data-anim="fade-up">
						<?php echo wp_get_attachment_image( $image_id, 'large', false, [ 'class' => 'story__img' ] ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
