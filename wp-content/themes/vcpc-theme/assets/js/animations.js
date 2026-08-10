(function () {
	'use strict';

	if ( typeof gsap === 'undefined' ) return;
	gsap.registerPlugin( ScrollTrigger );

	// Simple fade-up reveal for anything marked data-anim="fade-up"
	document.querySelectorAll( '[data-anim="fade-up"]' ).forEach( function ( el ) {
		gsap.to( el, {
			opacity: 1,
			y: 0,
			duration: 0.9,
			ease: 'power2.out',
			scrollTrigger: {
				trigger: el,
				start: 'top 85%',
				toggleActions: 'play none none none',
			},
		} );
	} );

	// Staggered stacked reveal for the Philosophy lines
	var stackItems = gsap.utils.toArray( '[data-anim="stack"]' );
	if ( stackItems.length ) {
		gsap.to( stackItems, {
			opacity: 1,
			y: 0,
			duration: 0.7,
			ease: 'power2.out',
			stagger: 0.15,
			scrollTrigger: {
				trigger: stackItems[0].closest( '.philosophy__stack' ),
				start: 'top 80%',
				toggleActions: 'play none none none',
			},
		} );
	}

	// Hero elements animate on load rather than on scroll
	gsap.to( '.section--hero [data-anim="fade-up"]', {
		opacity: 1,
		y: 0,
		duration: 1,
		ease: 'power2.out',
		stagger: 0.15,
		delay: 0.2,
	} );
})();
