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

	// Pinned scroll gallery for sections with multiple images (#milan, #dali-fashion, #salvador-dali)
	const scrollGallerySections = document.querySelectorAll('.section.has-scroll-gallery');

	scrollGallerySections.forEach(function(section) {
		const gallery = section.querySelector('.scroll-gallery');
		if (!gallery) return;

		const items = gallery.querySelectorAll('.scroll-gallery__item');
		const count = items.length;
		if (count <= 1) return;

		// Ensure the first slide is visible and others start hidden
		gsap.set(items[0], { opacity: 1, scale: 1, visibility: 'visible' });
		for (let i = 1; i < count; i++) {
			gsap.set(items[i], { opacity: 0, scale: 0.96, visibility: 'hidden' });
		}

		// Responsive handling
		let mm = gsap.matchMedia();

		mm.add('(min-width: 992px)', function() {
			// On desktop: pin the section so content remains fixed,
			// while scroll progress sequentially changes images.
			const scrollPerImage = Math.max(window.innerHeight * 0.85, 600);
			const totalDistance = (count - 1) * scrollPerImage;

			const tl = gsap.timeline({
				scrollTrigger: {
					trigger: section,
					start: 'top top',
					end: () => '+=' + totalDistance,
					pin: true,
					pinSpacing: true,
					scrub: 0.6,
					anticipatePin: 1,
					invalidateOnRefresh: true,
				}
			});

			for (let i = 1; i < count; i++) {
				const prev = items[i - 1];
				const curr = items[i];

				// Crossfade out previous, fade in current
				tl.to(prev, {
					opacity: 0,
					scale: 0.96,
					duration: 1,
					ease: 'power1.inOut'
				}, 'slide-' + i);

				tl.to(curr, {
					opacity: 1,
					scale: 1,
					visibility: 'visible',
					duration: 1,
					ease: 'power1.inOut'
				}, 'slide-' + i);

				// Brief pause between transitions so each image is admired
				if (i < count - 1) {
					tl.to({}, { duration: 0.6 });
				}
			}

			return function() {
				items.forEach(function(el, idx) {
					gsap.set(el, { clearProps: 'all' });
					if (idx === 0) {
						gsap.set(el, { opacity: 1, visibility: 'visible', scale: 1 });
					}
				});
			};
		});

		mm.add('(max-width: 991px)', function() {
			// On mobile: pin the media element with smooth transition
			const scrollPerImage = Math.max(window.innerHeight * 0.7, 450);
			const totalDistance = (count - 1) * scrollPerImage;

			const tl = gsap.timeline({
				scrollTrigger: {
					trigger: gallery,
					start: 'center center',
					end: () => '+=' + totalDistance,
					pin: true,
					pinSpacing: true,
					scrub: 0.6,
					anticipatePin: 1,
					invalidateOnRefresh: true,
				}
			});

			for (let i = 1; i < count; i++) {
				const prev = items[i - 1];
				const curr = items[i];

				tl.to(prev, {
					opacity: 0,
					scale: 0.96,
					duration: 1,
					ease: 'power1.inOut'
				}, 'm-slide-' + i);

				tl.to(curr, {
					opacity: 1,
					scale: 1,
					visibility: 'visible',
					duration: 1,
					ease: 'power1.inOut'
				}, 'm-slide-' + i);

				if (i < count - 1) {
					tl.to({}, { duration: 0.5 });
				}
			}

			return function() {
				items.forEach(function(el, idx) {
					gsap.set(el, { clearProps: 'all' });
					if (idx === 0) {
						gsap.set(el, { opacity: 1, visibility: 'visible', scale: 1 });
					}
				});
			};
		});
	});
});
