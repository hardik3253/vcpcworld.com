<?php if ( ! defined( 'ABSPATH' ) ) exit; 

$eyebrow    = vcpc_field( 'story_eyebrow', '' );
$heading    = vcpc_field( 'story_heading', '' );
$story_content = vcpc_field( 'story_content', '' );
$image_id      = vcpc_field( 'story_image', 0 );

// Backward compatibility: migrate old repeater data to content string if new content is empty
if ( empty( $story_content ) ) {
	$para_json = vcpc_field( 'story_paragraphs', '' );
	if ( $para_json ) {
		$paragraphs = json_decode( $para_json, true );
		if ( is_array( $paragraphs ) ) {
			foreach ( $paragraphs as $row ) {
				if ( ! empty( $row['paragraph'] ) ) {
					$story_content .= '<p>' . esc_html( $row['paragraph'] ) . '</p>';
				}
			}
		}
	}
}

// Show section only if data exists
if ( ! empty( $eyebrow ) || ! empty( $heading ) || ! empty( $story_content ) || ! empty( $image_id ) ) :
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
					
					<?php if ( ! empty( $story_content ) ) : ?>
						<div class="story__paragraphs">
							<?php echo wp_kses_post( wpautop( $story_content ) ); ?>
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
