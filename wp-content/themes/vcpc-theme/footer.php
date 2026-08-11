<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php if ( ! vcpc_should_hide_footer() ) : ?>
<footer class="vcpc-footer">
	<div class="vcpc-footer__inner">
		<!-- Footer Tagline Lines -->
		<div class="vcpc-footer__taglines">
			<?php 
			$tagline_json = get_option( 'vcpc_footer_tagline', '' );
			if ( $tagline_json ) {
				$taglines = json_decode( $tagline_json, true );
				if ( is_array( $taglines ) ) {
					foreach ( $taglines as $row ) {
						if ( ! empty( $row['line'] ) ) {
							echo '<p class="vcpc-footer__tagline">' . esc_html( $row['line'] ) . '</p>';
						}
					}
				}
			} else {
				echo '<p class="vcpc-footer__tagline">Care with Fashion</p>';
				echo '<p class="vcpc-footer__tagline">Protection Comes First™</p>';
				echo '<p class="vcpc-footer__tagline">India\'s Luxury Professional Haircare House.</p>';
			}
			?>
		</div>

		<!-- Footer navigation & Social links -->
		<div class="vcpc-footer__meta">
			<div class="vcpc-footer__social">
				<?php 
				$socials_json = get_option( 'vcpc_social_links', '' );
				if ( $socials_json ) {
					$socials = json_decode( $socials_json, true );
					if ( is_array( $socials ) ) {
						foreach ( $socials as $row ) {
							if ( ! empty( $row['url'] ) ) {
								$label = ! empty( $row['platform'] ) ? $row['platform'] : 'Social Link';
								echo '<a href="' . esc_url( $row['url'] ) . '" target="_blank" rel="noopener noreferrer" class="vcpc-footer__social-link">';
								if ( ! empty( $row['icon'] ) ) {
									echo wp_get_attachment_image( $row['icon'], 'thumbnail', true, [ 'style' => 'width:18px;height:18px;vertical-align:middle;margin-right:5px;' ] );
								}
								echo esc_html( $label );
								echo '</a>';
							}
						}
					}
				} else {
					echo '<a href="#" class="vcpc-footer__social-link">Instagram</a>';
					echo '<a href="#" class="vcpc-footer__social-link">YouTube</a>';
					echo '<a href="#" class="vcpc-footer__social-link">LinkedIn</a>';
				}
				?>
			</div>
			
			<div class="vcpc-footer__copyright">
				<?php 
				$copyright = get_option( 'vcpc_copyright_text', '© VCPC' );
				echo esc_html( $copyright ) . ' ' . date( 'Y' );
				?>
			</div>
		</div>
	</div>
</footer>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
