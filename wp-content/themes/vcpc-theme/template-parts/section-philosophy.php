<?php if ( ! defined( 'ABSPATH' ) ) exit;

$lines_raw = vcpc_field( 'philosophy_lines', "Every colour.\nEvery cut.\nEvery style." );
$lines = array_filter( array_map( 'trim', explode( "\n", $lines_raw ) ) );
?>
<section class="section section--philosophy" id="philosophy">
	<div class="section__inner">
		<p class="eyebrow" data-anim="fade-up"><?php echo esc_html( vcpc_field( 'philosophy_kicker', 'Our Philosophy' ) ); ?></p>
		<h2 class="philosophy__title" data-anim="fade-up">Beautiful hair begins with protection.</h2>

		<div class="philosophy__stack">
			<?php foreach ( $lines as $i => $line ) : ?>
				<p class="philosophy__line" data-anim="stack" data-index="<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $line ); ?></p>
			<?php endforeach; ?>
			<p class="philosophy__line philosophy__line--final" data-anim="stack" data-index="<?php echo esc_attr( count( $lines ) ); ?>">Starts with healthy, protected hair.</p>
		</div>

		<p class="philosophy__body" data-anim="fade-up">
			<?php echo esc_html( vcpc_field( 'philosophy_body', 'Protection First™ is the philosophy behind every experience, treatment and product created by VCPC.' ) ); ?>
		</p>
	</div>
</section>
