<?php if ( ! defined( 'ABSPATH' ) ) exit;

$body_raw = vcpc_field( 'milan_full_body',
	"Every iconic luxury brand has a beginning. VCPC begins in Milan.\n\nOur international debut takes place during Milan Fashion Week 2026 as the Official Technical Partner of Dalí & Fashion.\n\nHosted at Palazzo Reale, the exhibition explores the extraordinary relationship between Salvador Dalí, fashion and artistic expression, bringing together works from some of the world's leading museums and fashion houses.\n\nAs part of this landmark exhibition, world-renowned hair designer Angelo Seminara is creating bespoke hair and wig installations.\n\nVCPC is proud to support this creative collaboration, marking the beginning of our journey on the global stage.\n\nThis is where our story begins."
);
$paragraphs = array_filter( array_map( 'trim', explode( "\n\n", $body_raw ) ) );
?>
<section class="section section--milan-full" id="milan-full">
	<div class="section__inner">
		<p class="eyebrow" data-anim="fade-up"><?php echo esc_html( vcpc_field( 'milan_full_kicker', 'From Milan' ) ); ?></p>
		<div class="milan-full__body">
			<?php foreach ( $paragraphs as $p ) : ?>
				<p data-anim="fade-up"><?php echo esc_html( $p ); ?></p>
			<?php endforeach; ?>
		</div>
	</div>
</section>
