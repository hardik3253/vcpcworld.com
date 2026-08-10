<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<footer class="site-footer">
	<div class="section__inner site-footer__inner">
		<div class="site-footer__brand">
			<p class="site-footer__logo">VCPC</p>
			<p>Care with Fashion</p>
			<p>Protection Comes First™</p>
			<p>India's Luxury Professional Haircare House.</p>
		</div>
		<div class="site-footer__social">
			<?php $ig = vcpc_field( 'social_instagram' ); $yt = vcpc_field( 'social_youtube' ); $li = vcpc_field( 'social_linkedin' ); ?>
			<?php if ( $ig ) : ?><a href="<?php echo esc_url( $ig ); ?>" target="_blank" rel="noopener">Instagram</a><?php endif; ?>
			<?php if ( $yt ) : ?><a href="<?php echo esc_url( $yt ); ?>" target="_blank" rel="noopener">YouTube</a><?php endif; ?>
			<?php if ( $li ) : ?><a href="<?php echo esc_url( $li ); ?>" target="_blank" rel="noopener">LinkedIn</a><?php endif; ?>
		</div>
	</div>
	<p class="site-footer__copy">© <?php echo esc_html( date( 'Y' ) ); ?> VCPC</p>
</footer>
