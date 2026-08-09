/**
 * Hero entrance + scroll reveals via GSAP/ScrollTrigger. Fully skipped for
 * prefers-reduced-motion (CSS already shows content at full opacity in that
 * case — see homepage.css [data-kc-reveal-child] reduced-motion block).
 */
( function () {
	'use strict';

	if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		return;
	}
	if ( typeof window.gsap === 'undefined' ) {
		return;
	}

	var gsap = window.gsap;
	if ( window.ScrollTrigger ) {
		gsap.registerPlugin( window.ScrollTrigger );
	}

	/* Hero entrance sequence, runs immediately on load */
	var hero = document.querySelector( '.kc-hero' );
	if ( hero ) {
		var heroChildren = hero.querySelectorAll( '[data-kc-reveal-child]' );
		gsap.timeline( { defaults: { ease: 'power2.out' } } )
			.to( heroChildren, { opacity: 1, y: 0, duration: 0.8, stagger: 0.12 } );
		hero.classList.add( 'kc-revealed' );
	}

	/* Scroll-triggered reveals for every other section */
	var sections = document.querySelectorAll( '[data-kc-reveal]:not(.kc-hero)' );
	sections.forEach( function ( section ) {
		var children = section.querySelectorAll( '[data-kc-reveal-child]' );
		if ( ! children.length ) return;

		if ( window.ScrollTrigger ) {
			window.ScrollTrigger.create( {
				trigger: section,
				start: 'top 82%',
				once: true,
				onEnter: function () {
					gsap.to( children, { opacity: 1, y: 0, duration: 0.7, stagger: 0.1, ease: 'power2.out' } );
				},
			} );
		} else {
			gsap.to( children, { opacity: 1, y: 0, duration: 0.7, stagger: 0.1, ease: 'power2.out' } );
		}
	} );

	/* Subtle parallax on the promo banner image */
	var parallaxEls = document.querySelectorAll( '[data-kc-parallax]' );
	if ( window.ScrollTrigger ) {
		parallaxEls.forEach( function ( el ) {
			gsap.to( el, {
				yPercent: 12,
				ease: 'none',
				scrollTrigger: {
					trigger: el,
					start: 'top bottom',
					end: 'bottom top',
					scrub: true,
				},
			} );
		} );
	}
} )();
