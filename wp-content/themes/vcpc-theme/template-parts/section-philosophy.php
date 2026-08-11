<?php if ( ! defined( 'ABSPATH' ) ) exit; 

$eyebrow     = vcpc_field( 'philosophy_eyebrow', '' );
$intro       = vcpc_field( 'philosophy_intro', '' );
$suffix      = vcpc_field( 'philosophy_intro_suffix', '' );
$reveal_json = vcpc_field( 'philosophy_reveal_lines', '' );
$paragraph   = vcpc_field( 'philosophy_paragraph', '' );

$reveal_lines = [];
if ( $reveal_json ) {
	$reveal_lines = json_decode( $reveal_json, true );
}
if ( ! is_array( $reveal_lines ) ) {
	$reveal_lines = [];
}

// Show section only if data exists
if ( ! empty( $eyebrow ) || ! empty( $intro ) || ! empty( $reveal_lines ) || ! empty( $paragraph ) ) :
	?>
	<section class="section section--philosophy" id="philosophy">
		<div class="section__inner philosophy__inner">
			<div class="philosophy__grid">
				<?php if ( ! empty( $eyebrow ) || ! empty( $intro ) ) : ?>
					<div class="philosophy__header">
						<?php if ( ! empty( $eyebrow ) ) : ?>
							<p class="eyebrow" data-anim="fade-up"><?php echo esc_html( $eyebrow ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $intro ) ) : ?>
							<h2 class="section__heading" data-anim="fade-up">
								<?php echo esc_html( $intro ); ?> 
								<?php if ( ! empty( $suffix ) ) : ?>
									<span class="philosophy__accent"><?php echo esc_html( $suffix ); ?></span>
								<?php endif; ?>
							</h2>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				
				<?php if ( ! empty( $reveal_lines ) ) : ?>
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
				<?php endif; ?>

				<?php if ( ! empty( $paragraph ) ) : ?>
					<div class="philosophy__body-content text-measure" data-anim="fade-up">
						<p class="paragraph-lead"><?php echo esc_html( $paragraph ); ?></p>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
