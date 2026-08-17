<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- SEO / OG Meta details -->
	<meta name="description" content="<?php echo esc_attr( vcpc_field( 'hero_line_1', "India's Luxury Professional Haircare House." ) . ' ' . vcpc_field( 'hero_line_2', 'Inspired by fashion. Guided by art.' ) ); ?>">
	<meta property="og:title" content="VCPC — India's Luxury Professional Haircare House">
	<meta property="og:description" content="Exclusive details on VCPC Milan Fashion Week 2026 announcement, diagnostic Protection Lab™, and Protection Dose™ treatments.">
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?php echo esc_url( home_url( '/' ) ); ?>">
	<?php 
	$logo_id = get_option( 'vcpc_site_logo', 0 );
	if ( $logo_id ) {
		$logo_url = wp_get_attachment_image_url( $logo_id, 'large' );
		if ( $logo_url ) {
			echo '<meta property="og:image" content="' . esc_url( $logo_url ) . '">';
		}
	}
	?>

	<!-- Preload Fonts if any, or load clean premium serif & sans from Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

	<!-- Organization & WebSite JSON-LD Schema -->
	<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "Organization",
		"name": "VCPC",
		"url": "<?php echo esc_url( home_url( '/' ) ); ?>",
		"logo": "<?php echo $logo_id ? esc_url( wp_get_attachment_image_url( $logo_id, 'full' ) ) : ''; ?>"
	}
	</script>

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( ! vcpc_should_hide_header() ) : ?>
<header class="vcpc-nav" id="site-nav">
	<div class="vcpc-nav__inner">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="vcpc-nav__logo">
			<?php 
			if ( $logo_id ) {
				echo wp_get_attachment_image( $logo_id, 'medium', false, [ 'class' => 'vcpc-logo-img' ] );
			} else {
				echo 'VCPC';
			}
			?>
		</a>
		<div class="vcpc-nav__menu-container">
			<?php 
			wp_nav_menu( [
				'theme_location' => 'primary',
				'container'      => 'nav',
				'container_class'=> 'vcpc-nav__links',
				'container_id'   => 'primary-menu-container',
				'menu_class'     => 'vcpc-nav__menu-list',
				'fallback_cb'    => function() {
					?>
					<nav class="vcpc-nav__links" aria-label="Primary">
						<a href="#philosophy"><?php _e( 'Philosophy', 'vcpc' ); ?></a>
						<a href="#coming-soon"><?php _e( 'Labs', 'vcpc' ); ?></a>
						<a href="#story"><?php _e( 'Story', 'vcpc' ); ?></a>
						<a href="#milan"><?php _e( 'From Milan', 'vcpc' ); ?></a>
						<a href="#contact"><?php _e( 'Contact', 'vcpc' ); ?></a>
					</nav>
					<?php
				}
			] );
			?>
			<?php if ( vcpc_is_header_join_button_enabled() ) : ?>
				<a href="#join" class="vcpc-nav__cta"><?php _e( 'Join the Journey', 'vcpc' ); ?></a>
			<?php endif; ?>
		</div>
		<button class="vcpc-nav__toggle" id="nav-toggle" aria-label="Open menu" aria-expanded="false">
			<span></span><span></span><span></span>
		</button>
	</div>
</header>
<?php endif; ?>
