<?php if ( ! defined( 'ABSPATH' ) ) exit; 

$heading      = vcpc_field( 'contact_contact_heading', '' );
$entries_json = vcpc_field( 'contact_contact_entries', '' );

$entries = [];
if ( $entries_json ) {
	$entries = json_decode( $entries_json, true );
}
if ( ! is_array( $entries ) ) {
	$entries = [];
}

// Show section only if data exists
if ( ! empty( $heading ) || ! empty( $entries ) ) :
	?>
	<section class="section section--contact" id="contact">
		<div class="section__inner contact__inner">
			<?php if ( ! empty( $heading ) ) : ?>
				<h2 class="section__heading align-center" data-anim="fade-up"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
			
			<?php if ( ! empty( $entries ) ) : ?>
				<div class="contact__grid">
					<?php foreach ( $entries as $row ) : 
						if ( empty( $row['email'] ) ) continue;
						$label = ! empty( $row['label'] ) ? $row['label'] : 'Enquiry';
						?>
						<div class="contact__card" data-anim="fade-up">
							<span class="contact__label"><?php echo esc_html( $label ); ?></span>
							<a href="mailto:<?php echo esc_attr( $row['email'] ); ?>" class="contact__email">
								<?php echo esc_html( $row['email'] ); ?>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
