/**
 * Site-wide interactions: nav, search overlay, cart drawer, quick view,
 * wishlist (localStorage), newsletter signup, new-arrivals carousel.
 * No framework — vanilla JS + WooCommerce's own add-to-cart/cart-fragments.
 */
( function () {
	'use strict';

	var backdrop = document.getElementById( 'kc-overlay-backdrop' );
	var openPanels = [];

	function showBackdrop() {
		if ( ! backdrop ) return;
		backdrop.hidden = false;
		requestAnimationFrame( function () {
			backdrop.classList.add( 'is-visible' );
		} );
	}

	function hideBackdropIfIdle() {
		if ( ! backdrop || openPanels.length ) return;
		backdrop.classList.remove( 'is-visible' );
		window.setTimeout( function () {
			if ( ! openPanels.length ) backdrop.hidden = true;
		}, 300 );
	}

	function openPanel( el, openClass ) {
		if ( ! el ) return;
		el.hidden = false;
		requestAnimationFrame( function () {
			el.classList.add( openClass );
		} );
		openPanels.push( el );
		showBackdrop();
		document.body.classList.add( 'kc-no-scroll' );
	}

	function closePanel( el, openClass ) {
		if ( ! el ) return;
		el.classList.remove( openClass );
		openPanels = openPanels.filter( function ( p ) { return p !== el; } );
		window.setTimeout( function () {
			if ( ! el.classList.contains( openClass ) ) el.hidden = true;
		}, 300 );
		hideBackdropIfIdle();
		if ( ! openPanels.length ) document.body.classList.remove( 'kc-no-scroll' );
	}

	function closeAllPanels() {
		[ [ searchOverlay, 'is-open' ], [ cartDrawer, 'is-open' ], [ quickViewModal, 'is-open' ] ].forEach( function ( pair ) {
			closePanel( pair[0], pair[1] );
		} );
	}

	if ( backdrop ) {
		backdrop.addEventListener( 'click', closeAllPanels );
	}
	document.addEventListener( 'keydown', function ( e ) {
		if ( e.key === 'Escape' ) closeAllPanels();
	} );

	/* Sticky header */
	var header = document.getElementById( 'kc-header' );
	if ( header ) {
		var onScroll = function () {
			header.classList.toggle( 'is-scrolled', window.scrollY > 8 );
		};
		onScroll();
		window.addEventListener( 'scroll', onScroll, { passive: true } );
	}

	/* Mobile menu */
	var navToggle = document.getElementById( 'kc-nav-toggle' );
	var mobileMenu = document.getElementById( 'kc-mobile-menu' );
	if ( navToggle && mobileMenu ) {
		navToggle.addEventListener( 'click', function () {
			var expanded = navToggle.getAttribute( 'aria-expanded' ) === 'true';
			navToggle.setAttribute( 'aria-expanded', String( ! expanded ) );
			mobileMenu.classList.toggle( 'is-open', ! expanded );
		} );
	}

	/* Search overlay */
	var searchToggle = document.getElementById( 'kc-search-toggle' );
	var searchOverlay = document.getElementById( 'kc-search-overlay' );
	var searchClose = document.getElementById( 'kc-search-close' );
	var searchInput = document.getElementById( 'kc-search-input' );
	var searchResults = document.getElementById( 'kc-search-results' );
	var searchDebounce;

	if ( searchToggle && searchOverlay ) {
		searchToggle.addEventListener( 'click', function () {
			openPanel( searchOverlay, 'is-open' );
			window.setTimeout( function () { searchInput && searchInput.focus(); }, 350 );
		} );
	}
	if ( searchClose ) {
		searchClose.addEventListener( 'click', function () { closePanel( searchOverlay, 'is-open' ); } );
	}
	if ( searchInput && window.kcData ) {
		searchInput.addEventListener( 'input', function () {
			var term = searchInput.value.trim();
			window.clearTimeout( searchDebounce );
			if ( term.length < 2 ) {
				searchResults.innerHTML = '';
				return;
			}
			searchDebounce = window.setTimeout( function () {
				var url = window.kcData.ajaxUrl + '?action=kc_search_products&nonce=' + encodeURIComponent( window.kcData.searchNonce ) + '&q=' + encodeURIComponent( term );
				fetch( url )
					.then( function ( r ) { return r.json(); } )
					.then( function ( res ) {
						if ( ! res.success ) return;
						renderSearchResults( res.data );
					} );
			}, 300 );
		} );
	}

	function renderSearchResults( items ) {
		if ( ! items.length ) {
			searchResults.innerHTML = '<p class="kc-muted kc-small">No products found.</p>';
			return;
		}
		searchResults.innerHTML = items.map( function ( item ) {
			return '<a class="kc-search-result" href="' + item.permalink + '">' +
				'<img src="' + item.image + '" alt="" loading="lazy">' +
				'<span><span class="kc-search-result__name">' + item.title + '</span><br><span class="kc-small kc-muted">' + item.price + '</span></span>' +
				'</a>';
		} ).join( '' );
	}

	/* Cart drawer */
	var cartToggle = document.getElementById( 'kc-cart-toggle' );
	var cartDrawer = document.getElementById( 'kc-cart-drawer' );
	var cartClose = document.getElementById( 'kc-cart-close' );
	if ( cartToggle && cartDrawer ) {
		cartToggle.addEventListener( 'click', function () { openPanel( cartDrawer, 'is-open' ); } );
	}
	if ( cartClose ) {
		cartClose.addEventListener( 'click', function () { closePanel( cartDrawer, 'is-open' ); } );
	}

	/* WooCommerce add-to-cart: auto-open drawer + toast on success */
	if ( window.jQuery ) {
		window.jQuery( document.body ).on( 'added_to_cart', function () {
			openPanel( cartDrawer, 'is-open' );
			showToast( 'Added to cart ✓' );
		} );
	}

	/* Toast */
	var toastEl = document.getElementById( 'kc-toast' );
	var toastTimeout;
	function showToast( message ) {
		if ( ! toastEl ) return;
		toastEl.textContent = message;
		toastEl.classList.add( 'is-visible' );
		window.clearTimeout( toastTimeout );
		toastTimeout = window.setTimeout( function () {
			toastEl.classList.remove( 'is-visible' );
		}, 2200 );
	}

	/* Quick view */
	var quickViewModal = document.getElementById( 'kc-quick-view-modal' );
	var quickViewContent = document.getElementById( 'kc-quick-view-content' );
	var quickViewClose = document.getElementById( 'kc-quick-view-close' );

	document.addEventListener( 'click', function ( e ) {
		var btn = e.target.closest( '.kc-quick-view' );
		if ( ! btn || ! window.kcData ) return;
		e.preventDefault();
		openPanel( quickViewModal, 'is-open' );
		quickViewContent.innerHTML = '<div class="kc-modal__loading">Loading…</div>';
		var url = window.kcData.ajaxUrl + '?action=kc_quick_view&nonce=' + encodeURIComponent( window.kcData.quickViewNonce ) + '&product_id=' + encodeURIComponent( btn.dataset.productId );
		fetch( url )
			.then( function ( r ) { return r.json(); } )
			.then( function ( res ) {
				if ( res.success ) {
					quickViewContent.innerHTML = res.data;
				} else {
					quickViewContent.innerHTML = '<p class="kc-muted">Unable to load this product.</p>';
				}
			} );
	} );
	if ( quickViewClose ) {
		quickViewClose.addEventListener( 'click', function () { closePanel( quickViewModal, 'is-open' ); } );
	}

	/* Wishlist (localStorage-backed, no account required) */
	var WISHLIST_KEY = 'kc_wishlist';
	function getWishlist() {
		try {
			return JSON.parse( window.localStorage.getItem( WISHLIST_KEY ) || '[]' );
		} catch ( err ) {
			return [];
		}
	}
	function setWishlist( ids ) {
		window.localStorage.setItem( WISHLIST_KEY, JSON.stringify( ids ) );
	}
	function refreshWishlistButtons() {
		var ids = getWishlist();
		document.querySelectorAll( '.kc-wishlist-btn' ).forEach( function ( btn ) {
			var id = btn.dataset.productId;
			btn.setAttribute( 'aria-pressed', ids.indexOf( id ) !== -1 ? 'true' : 'false' );
		} );
	}
	document.addEventListener( 'click', function ( e ) {
		var btn = e.target.closest( '.kc-wishlist-btn' );
		if ( ! btn ) return;
		var id = btn.dataset.productId;
		var ids = getWishlist();
		var idx = ids.indexOf( id );
		if ( idx === -1 ) {
			ids.push( id );
			showToast( 'Added to wishlist' );
		} else {
			ids.splice( idx, 1 );
		}
		setWishlist( ids );
		btn.setAttribute( 'aria-pressed', idx === -1 ? 'true' : 'false' );
		btn.classList.remove( 'kc-pulse' );
		void btn.offsetWidth;
		btn.classList.add( 'kc-pulse' );
	} );
	refreshWishlistButtons();

	/* Newsletter */
	var newsletterForm = document.getElementById( 'kc-newsletter-form' );
	if ( newsletterForm && window.kcData ) {
		newsletterForm.addEventListener( 'submit', function ( e ) {
			e.preventDefault();
			var email = document.getElementById( 'kc-newsletter-email' ).value;
			var msg = document.getElementById( 'kc-newsletter-message' );
			var body = new URLSearchParams();
			body.set( 'action', 'kc_newsletter_signup' );
			body.set( 'email', email );
			body.set( 'nonce', window.kcData.newsletterNonce );
			fetch( window.kcData.ajaxUrl, { method: 'POST', body: body } )
				.then( function ( r ) { return r.json(); } )
				.then( function ( res ) {
					msg.textContent = ( res.data && res.data.message ) || '';
					if ( res.success ) newsletterForm.reset();
				} );
		} );
	}

	/* New arrivals carousel: drag + arrow nav */
	document.querySelectorAll( '[data-carousel-prev], [data-carousel-next]' ).forEach( function ( btn ) {
		btn.addEventListener( 'click', function () {
			var id = btn.dataset.carouselPrev || btn.dataset.carouselNext;
			var track = document.getElementById( id );
			if ( ! track ) return;
			var amount = track.clientWidth * 0.8 * ( btn.dataset.carouselPrev ? -1 : 1 );
			track.scrollBy( { left: amount, behavior: 'smooth' } );
		} );
	} );

	document.querySelectorAll( '.kc-carousel' ).forEach( function ( track ) {
		var isDown = false, startX, scrollLeft;
		track.addEventListener( 'pointerdown', function ( e ) {
			isDown = true;
			startX = e.clientX;
			scrollLeft = track.scrollLeft;
		} );
		[ 'pointerup', 'pointerleave' ].forEach( function ( evt ) {
			track.addEventListener( evt, function () { isDown = false; } );
		} );
		track.addEventListener( 'pointermove', function ( e ) {
			if ( ! isDown ) return;
			track.scrollLeft = scrollLeft - ( e.clientX - startX );
		} );
	} );
} )();
