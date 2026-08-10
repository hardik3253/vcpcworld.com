<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<section class="section section--contact" id="contact">
	<div class="section__inner">
		<p class="eyebrow" data-anim="fade-up">Contact</p>
		<h2 class="contact__title" data-anim="fade-up">Get in Touch</h2>
		<div class="contact__grid">
			<div data-anim="fade-up">
				<h4>Press</h4>
				<a href="mailto:<?php echo esc_attr( vcpc_field( 'contact_press_email', 'press@vcpcworld.com' ) ); ?>">
					<?php echo esc_html( vcpc_field( 'contact_press_email', 'press@vcpcworld.com' ) ); ?>
				</a>
			</div>
			<div data-anim="fade-up">
				<h4>General Enquiries</h4>
				<a href="mailto:<?php echo esc_attr( vcpc_field( 'contact_general_email', 'hello@vcpcworld.com' ) ); ?>">
					<?php echo esc_html( vcpc_field( 'contact_general_email', 'hello@vcpcworld.com' ) ); ?>
				</a>
			</div>
		</div>
	</div>
</section>
