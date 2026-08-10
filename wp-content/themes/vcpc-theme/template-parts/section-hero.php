<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<section class="section section--hero" id="hero">
	<div class="section__bg" aria-hidden="true"></div>
	<div class="section__inner hero__inner">
		<p class="eyebrow" data-anim="fade-up"><?php echo esc_html( vcpc_field( 'hero_eyebrow', 'VCPC' ) ); ?></p>
		<h1 class="hero__heading" data-anim="fade-up">
			<?php echo esc_html( vcpc_field( 'hero_heading', 'Care with Fashion' ) ); ?><br>
			<span class="hero__heading--accent"><?php echo esc_html( vcpc_field( 'hero_subheading', 'Protection Comes First™' ) ); ?></span>
		</h1>
		<p class="hero__tagline" data-anim="fade-up">
			<?php echo esc_html( vcpc_field( 'hero_tagline', "India's Luxury Professional Haircare House. Inspired by fashion. Guided by art. Built by professionals." ) ); ?>
		</p>
		<a href="#join" class="btn btn--primary" data-anim="fade-up">
			<?php echo esc_html( vcpc_field( 'hero_cta_label', 'Join the Journey' ) ); ?>
		</a>
	</div>
	<div class="hero__scroll-cue" aria-hidden="true">↓</div>
</section>
