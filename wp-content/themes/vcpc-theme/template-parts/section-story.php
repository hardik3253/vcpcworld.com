<?php if ( ! defined( 'ABSPATH' ) ) exit;

$body_raw = vcpc_field( 'story_body',
	"VCPC is building India's globally positioned luxury professional haircare house. Inspired by fashion, art and culture.\n\nFounded by Vipul Chudasama after more than two decades of professional hairdressing and educating over 55,000 hair professionals.\n\nOur belief is simple. Beautiful hair is not created by styling alone. It begins by protecting the integrity of the hair fibre.\n\nThis philosophy—Protection First™—guides everything we create. From professional education to salon rituals, from home treatments to luxury collections.\n\nVCPC is more than a haircare brand. It is a new vision for professional haircare."
);
$paragraphs = array_filter( array_map( 'trim', explode( "\n\n", $body_raw ) ) );
?>
<section class="section section--story" id="story">
	<div class="section__inner">
		<p class="eyebrow" data-anim="fade-up"><?php echo esc_html( vcpc_field( 'story_kicker', 'Protection First™' ) ); ?></p>
		<div class="story__body">
			<?php foreach ( $paragraphs as $p ) : ?>
				<p data-anim="fade-up"><?php echo esc_html( $p ); ?></p>
			<?php endforeach; ?>
		</div>
	</div>
</section>
