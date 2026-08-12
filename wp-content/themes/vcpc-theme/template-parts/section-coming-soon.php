<?php if ( ! defined( 'ABSPATH' ) ) exit; 

$heading    = vcpc_field( 'coming_soon_heading', '' );
$items_json = vcpc_field( 'coming_soon_items', '' );

$items = [];
if ( $items_json ) {
	$items = json_decode( $items_json, true );
}
if ( ! is_array( $items ) ) {
	$items = [];
}

// Show section only if data exists
if ( ! empty( $heading ) || ! empty( $items ) ) :
	?>
	<section class="section section--coming-soon" id="coming-soon">
		<div class="section__inner coming-soon__inner">
			<?php if ( ! empty( $heading ) ) : ?>
				<h2 class="section__heading align-center" data-anim="fade-up"><?php echo wp_kses_post( html_entity_decode( $heading, ENT_QUOTES, 'UTF-8' ) ); ?></h2>
			<?php endif; ?>
			
			<?php if ( ! empty( $items ) ) : ?>
				<div class="coming-soon__grid">
					<?php foreach ( $items as $row ) : 
						if ( empty( $row['title'] ) ) continue;
						?>
						<div class="coming-soon__card" data-anim="fade-up">
							<?php if ( ! empty( $row['icon_image'] ) ) : ?>
								<div class="coming-soon__icon">
									<?php echo wp_get_attachment_image( $row['icon_image'], 'thumbnail' ); ?>
								</div>
							<?php endif; ?>
							<h3 class="coming-soon__title"><?php echo wp_kses_post( html_entity_decode( $row['title'], ENT_QUOTES, 'UTF-8' ) ); ?></h3>
							<?php if ( ! empty( $row['description'] ) ) : ?>
								<p class="coming-soon__desc"><?php echo wp_kses_post( html_entity_decode( $row['description'], ENT_QUOTES, 'UTF-8' ) ); ?></p>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
