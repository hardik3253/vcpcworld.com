<?php if ( ! defined( 'ABSPATH' ) ) exit; 

$heading      = vcpc_field( 'contact_contact_heading', 'Get in Touch' );
$entries_json = vcpc_field( 'contact_contact_entries', '' );

$entries = [];
if ( $entries_json ) {
	$entries = json_decode( $entries_json, true );
}
if ( empty( $entries ) || ! is_array( $entries ) ) {
	$entries = [
		[ 'label' => 'Press', 'email' => 'press@vcpcworld.com' ],
		[ 'label' => 'General Enquiries', 'email' => 'hello@vcpcworld.com' ]
	];
}
?>
<section class="section section--contact" id="contact">
	<div class="section__inner contact__inner">
		<h2 class="section__heading align-center" data-anim="fade-up"><?php echo esc_html( $heading ); ?></h2>
		
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
	</div>
</section>
