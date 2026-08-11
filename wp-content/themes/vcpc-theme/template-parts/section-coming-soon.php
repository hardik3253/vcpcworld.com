<?php if ( ! defined( 'ABSPATH' ) ) exit; 

$heading    = vcpc_field( 'coming_soon_coming_soon_heading', 'Coming Soon' );
$items_json = vcpc_field( 'coming_soon_coming_soon_items', '' );

$items = [];
if ( $items_json ) {
	$items = json_decode( $items_json, true );
}
if ( empty( $items ) || ! is_array( $items ) ) {
	$items = [
		[
			'title'       => 'Protection Lab™ / Professional Hair Analysis.',
			'description' => 'A comprehensive diagnostic suite for salons, providing high-precision structural readings of the hair shaft.',
			'icon_image'  => 0
		],
		[
			'title'       => 'Protection Dose™ / Professional Hair Treatments at Home.',
			'description' => 'Highly concentrated boosters designed to extend salon treatment results in daily residential routines.',
			'icon_image'  => 0
		]
	];
}
?>
<section class="section section--coming-soon" id="coming-soon">
	<div class="section__inner coming-soon__inner">
		<h2 class="section__heading align-center" data-anim="fade-up"><?php echo esc_html( $heading ); ?></h2>
		
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
					<h3 class="coming-soon__title"><?php echo esc_html( $row['title'] ); ?></h3>
					<?php if ( ! empty( $row['description'] ) ) : ?>
						<p class="coming-soon__desc"><?php echo esc_html( $row['description'] ); ?></p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
