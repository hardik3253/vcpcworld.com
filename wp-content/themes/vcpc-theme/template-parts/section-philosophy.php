<?php if ( ! defined( 'ABSPATH' ) ) exit; 

$eyebrow     = vcpc_field( 'philosophy_philosophy_eyebrow', 'Philosophy' );
$intro       = vcpc_field( 'philosophy_philosophy_intro', 'Beautiful hair begins with protection.' );
$suffix      = vcpc_field( 'philosophy_philosophy_intro_suffix', '(“Hair Treatments”)' );
$reveal_json = vcpc_field( 'philosophy_philosophy_reveal_lines', '' );
$paragraph   = vcpc_field( 'philosophy_philosophy_paragraph', 'Beautiful hair starts with health. VCPC is the bridge between advanced haircare science and high-end luxury styling.' );

$reveal_lines = [];
if ( $reveal_json ) {
	$reveal_lines = json_decode( $reveal_json, true );
}
if ( empty( $reveal_lines ) || ! is_array( $reveal_lines ) ) {
	$reveal_lines = [
		[ 'line' => 'Every colour.' ],
		[ 'line' => 'Every cut.' ],
		[ 'line' => 'Every style.' ],
		[ 'line' => 'Starts with healthy, protected hair.' ],
	];
}
?>
<section class="section section--philosophy" id="philosophy">
	<div class="section__inner philosophy__inner">
		<div class="philosophy__grid">
			<div class="philosophy__header">
				<p class="eyebrow" data-anim="fade-up"><?php echo esc_html( $eyebrow ); ?></p>
				<h2 class="section__heading" data-anim="fade-up">
					<?php echo esc_html( $intro ); ?> <span class="philosophy__accent"><?php echo esc_html( $suffix ); ?></span>
				</h2>
			</div>
			
			<div class="philosophy__reveal">
				<?php foreach ( $reveal_lines as $index => $row ) : 
					if ( empty( $row['line'] ) ) continue;
					?>
					<div class="philosophy__reveal-line" data-anim="reveal-line">
						<span class="reveal-number"><?php echo sprintf( '%02d', $index + 1 ); ?></span>
						<p class="reveal-text"><?php echo esc_html( $row['line'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="philosophy__body-content text-measure" data-anim="fade-up">
				<p class="paragraph-lead"><?php echo esc_html( $paragraph ); ?></p>
			</div>
		</div>
	</div>
</section>
