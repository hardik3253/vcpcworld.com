<?php if ( ! defined( 'ABSPATH' ) ) exit; 

$eyebrow    = vcpc_field( 'story_story_eyebrow', 'The Story' );
$heading    = vcpc_field( 'story_story_heading', 'Protection First™' );
$para_json  = vcpc_field( 'story_story_paragraphs', '' );
$image_id   = vcpc_field( 'story_story_image', 0 );

$paragraphs = [];
if ( $para_json ) {
	$paragraphs = json_decode( $para_json, true );
}
if ( empty( $paragraphs ) || ! is_array( $paragraphs ) ) {
	$paragraphs = [
		[ 'paragraph' => 'VCPC was founded on a simple principle: protection is not an afterthought, it is the foundation of beauty. In modern styling, hair is subject to extreme stressors. We wanted to design a range that empowers stylists while keeping hair structural integrity intact.' ],
		[ 'paragraph' => 'Every single treatment represents years of research into custom lipid replenishing matrices and bio-mimetic keratin chains. We are proud to launch India’s luxury professional haircare house, bridging Milanese fashion with high-end hair diagnostics.' ]
	];
}
?>
<section class="section section--story" id="story">
	<div class="section__inner story__inner">
		<div class="story__grid">
			<div class="story__content text-measure" data-anim="fade-up">
				<p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
				<h2 class="section__heading"><?php echo esc_html( $heading ); ?></h2>
				
				<div class="story__paragraphs">
					<?php foreach ( $paragraphs as $row ) : 
						if ( empty( $row['paragraph'] ) ) continue;
						?>
						<p><?php echo esc_html( $row['paragraph'] ); ?></p>
					<?php endforeach; ?>
				</div>
			</div>
			
			<?php if ( $image_id ) : ?>
				<div class="story__media" data-anim="fade-up">
					<?php echo wp_get_attachment_image( $image_id, 'large', false, [ 'class' => 'story__img' ] ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
