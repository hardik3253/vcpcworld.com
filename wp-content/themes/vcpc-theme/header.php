<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="VCPC — India's Luxury Professional Haircare House. Care with Fashion. Protection Comes First™.">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="vcpc-nav" id="site-nav">
	<div class="vcpc-nav__inner">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="vcpc-nav__logo">VCPC</a>
		<nav class="vcpc-nav__links" aria-label="Primary">
			<a href="#story">Story</a>
			<a href="#from-milan">From Milan</a>
			<a href="#contact">Contact</a>
			<a href="#join" class="vcpc-nav__cta">Join the Journey</a>
		</nav>
		<button class="vcpc-nav__toggle" id="nav-toggle" aria-label="Open menu" aria-expanded="false">
			<span></span><span></span><span></span>
		</button>
	</div>
</header>
