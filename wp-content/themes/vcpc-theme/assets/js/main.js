(function () {
	'use strict';

	document.documentElement.classList.remove( 'no-js' );

	var nav = document.getElementById( 'site-nav' );
	var toggle = document.getElementById( 'nav-toggle' );
	var links = document.querySelector( '.vcpc-nav__links' );

	function onScroll() {
		if ( window.scrollY > 40 ) {
			nav.classList.add( 'is-scrolled' );
		} else {
			nav.classList.remove( 'is-scrolled' );
		}
	}
	window.addEventListener( 'scroll', onScroll, { passive: true } );
	onScroll();

	if ( toggle && links ) {
		toggle.addEventListener( 'click', function () {
			var isOpen = links.classList.toggle( 'is-open' );
			toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
		} );

		links.querySelectorAll( 'a' ).forEach( function ( link ) {
			link.addEventListener( 'click', function () {
				links.classList.remove( 'is-open' );
				toggle.setAttribute( 'aria-expanded', 'false' );
			} );
		} );
	}
})();
