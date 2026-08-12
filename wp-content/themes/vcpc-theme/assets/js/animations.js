document.addEventListener( 'DOMContentLoaded', function() {
	'use strict';

	// Register GSAP plugins
	gsap.registerPlugin(ScrollTrigger);

	// Hero Animation
	const heroElements = document.querySelectorAll('#hero [data-anim="fade-up"]');
	if (heroElements.length > 0) {
		gsap.from(heroElements, {
			y: 40,
			opacity: 0,
			duration: 1.2,
			stagger: 0.2,
			ease: 'power3.out',
			delay: 0.2
		});
	}

	// Staggered reveal line animation for Philosophy Section
	const philosophyLines = document.querySelectorAll('#philosophy [data-anim="reveal-line"]');
	if (philosophyLines.length > 0) {
		gsap.from(philosophyLines, {
			scrollTrigger: {
				trigger: '#philosophy .philosophy__reveal',
				start: 'top 80%',
				toggleActions: 'play none none none'
			},
			y: 30,
			opacity: 0,
			duration: 0.8,
			stagger: 0.3,
			ease: 'power2.out'
		});
	}

	// Parallax background on Milan Teaser section
	const milanTeaser = document.querySelector('#milan-teaser');
	if (milanTeaser) {
		gsap.to(milanTeaser, {
			scrollTrigger: {
				trigger: milanTeaser,
				start: 'top bottom',
				end: 'bottom top',
				scrub: true
			},
			backgroundPositionY: '30%',
			ease: 'none'
		});
	}

	// Parallax background on Join section
	const joinSection = document.querySelector('#join.parallax-bg');
	if (joinSection) {
		gsap.to(joinSection, {
			scrollTrigger: {
				trigger: joinSection,
				start: 'top bottom',
				end: 'bottom top',
				scrub: true
			},
			backgroundPositionY: '30%',
			ease: 'none'
		});
	}

	// General fade up triggers for sections content
	const fadeUpElements = document.querySelectorAll('.section [data-anim="fade-up"]:not(#hero [data-anim="fade-up"]):not(#philosophy [data-anim="fade-up"])');
	fadeUpElements.forEach(element => {
		gsap.from(element, {
			scrollTrigger: {
				trigger: element,
				start: 'top 85%',
				toggleActions: 'play none none none'
			},
			y: 35,
			opacity: 0,
			duration: 0.9,
			ease: 'power2.out'
		});
	});
});
