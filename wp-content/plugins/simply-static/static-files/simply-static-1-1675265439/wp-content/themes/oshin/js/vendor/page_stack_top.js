;(function(window) {

	'use strict';
	var support = { transitions: Modernizr.csstransitions },
		// transition end event name
		transEndEventNames = { 'WebkitTransition': 'webkitTransitionEnd', 'MozTransition': 'transitionend', 'OTransition': 'oTransitionEnd', 'msTransition': 'MSTransitionEnd', 'transition': 'transitionend' },
		transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
		onEndTransition = function( el, callback ) {
			var onEndCallbackFn = function( ev ) {
				if( support.transitions ) {
					if( ev.target != this ) return;
					this.removeEventListener( transEndEventName, onEndCallbackFn );
				}
				if( callback && typeof callback === 'function' ) { callback.call(this); }
			};
			if( support.transitions ) {
				el.addEventListener( transEndEventName, onEndCallbackFn );
			}
			else {
				onEndCallbackFn();
			}
		},
		// the pages wrapper
		stack = document.getElementsByClassName('be-page-stack-wrapper')[0],
		// the page elements
		header = document.getElementById( 'header-inner-wrap' ),
		// total number of page elements
		//pagesTotal = pages.length,
		pagesTotal = 3,
		// index of current page
		current = 0,
		windowHeight = window.innerHeight,
		// menu button
		menuCtrl = document.querySelector('.hamburger-nav-controller-wrap'),
		// the navigation wrapper
		nav = document.querySelector('.special-header-menu'),
		// the menu nav items
		// navItems = [].slice.call(nav.querySelectorAll('.menu-item a')),
		navItems = jQuery( nav ).find( '.menu-item a' ).toArray(),
		// check if menu is open
		isMenuOpen = false,
		// store the scrolled value
		scrolled = 0,
		// Difference in sticky and default logo heights in case of solid header, to be used for the scrollTop calculation
		diffLogoHeights = jQuery( 'body' ).hasClass( 'header-solid' ) ? jQuery( '#header-wrap' ).attr( 'data-default-height' ) - jQuery( '#header-wrap' ).attr( 'data-sticky-height' ) : 0,
        pages = jQuery( '.be-page-stack' ),
        containers = jQuery( '.be-page-stack-container' ),
		mainWrapper = jQuery( '.be-page-stack-wrapper' ),
		init = function(){
			buildStack();
			initEvents();
	   }
	function buildStack() {
		var stackPagesIdxs = getStackPagesIdxs();

		// set z-index, opacity, initial transforms to pages and add class page--inactive to all except the current one
		for(var i = 0; i < pagesTotal; ++i) {
			var page = pages[i],
				posIdx = stackPagesIdxs.indexOf(i),
                container = containers[i];

			if( current !== i ) {
				classie.add(page, 'page--inactive');

				if( posIdx !== -1 ) {
					// visible pages in the stack
                    container.style.WebkitTransform = 'translate3d(0,100%,0)';
					container.style.transform = 'translate3d(0,100%,0)';
				}
				else {
					// invisible pages in the stack
					container.style.WebkitTransform = 'translate3d(0,75%,-300px)';
					container.style.transform = 'translate3d(0,75%,-300px)';		
				}
			}
			else {
				classie.remove(page, 'page--inactive');
			}
			// container.style.zIndex = i < current ? parseInt(current - i) : parseInt(pagesTotal + current - i);
			container.style.zIndex = i < current ? parseInt( 15 ) : parseInt( 15 - i);

			if( posIdx !== -1 ) {
				page.style.opacity = parseFloat(1 - 0.1 * posIdx);
			}
			else {
				page.style.opacity = 0;
			}
		}
	}

	// event binding
	function initEvents() {
		// menu button click
		menuCtrl.addEventListener('click', toggleMenu);
		var path = window.location.href;
		// navigation menu clicks
		navItems.forEach(function(item) {
			var href = item.getAttribute( 'href' ),
				urlArr = href.split('#'),
				$element;

			if( href == "#" ){
				return false;	
			}
			if( href.indexOf( '#' ) >= 0 && path.indexOf(urlArr[0]) >= 0 )
			{
				$element = href.substring(href.indexOf('#') + 1);
				if ($element) {
					if (jQuery('#' + $element).length > 0) {					
						item.addEventListener('click', function(ev) {
							ev.preventDefault();
							openPage( $element );
						});						
					}
				}
			}

		});

		// clicking on a page when the menu is open triggers the menu to close again and open the clicked page
		
		Array.prototype.forEach.call(pages, function(page) {

			page.addEventListener('click', function(ev) {
				if( isMenuOpen ) {
					ev.preventDefault();
					closeMenu();
				}
			});
		});
		
		// header.addEventListener( 'click', function( ev ){
		// 	//Don't let the clicking of hamburger menu trigger the close menu event attached to the header
		// 	if( ! ( jQuery(ev.target).hasClass( 'hamburger-nav-controller' ) || jQuery(ev.target).hasClass( 'be-mobile-menu-icon' ) || jQuery(ev.target).hasClass( 'hamburger-nav-controller-wrap' ) ) ) {
		// 		if( isMenuOpen ){
		// 			closeMenu();
		// 		}
		// 	}
		// } );

		// keyboard navigation events
		document.addEventListener( 'keyup', function( ev ) {
			if( !isMenuOpen ) return; 
			var keyCode = ev.keyCode || ev.which;
			if( keyCode === 27 ) {
				closeMenu();
			}
		} );

		jQuery(window).on( 'resize', function() {
			if (jQuery(window).width() <= 960) {
				if( isMenuOpen ){
					closeMenu();
				}
			}
		});
	}

	// toggle menu fn
	function toggleMenu(ev) {
		if( isMenuOpen ) {
			closeMenu();
		}
		else {
			openMenu();
			isMenuOpen = true;
		}
	}

	// opens the menu
	function openMenu() {
		scrolled = jQuery( document ).scrollTop();
		pages[0].style.top = scrolled  * -1  + 'px';
		var callback = function(){
			// toggle the menu button
			jQuery( '.hamburger-nav-controller .be-mobile-menu-icon' ).addClass( 'is-clicked' );
			jQuery('.be-sidemenu').addClass('opened');
			jQuery('body').addClass('side-menu-opened page-stack-top-opened');
			if( jQuery( 'body' ).hasClass( 'admin-bar' ) ){
				jQuery( 'html' ).css( 'height', 'calc(100% - 32px)' );
			}
			// Showing the be-sidemenu
			jQuery( '.be-sidemenu' ).css({ 'width' : '100vw', 'height' : '50%', 'visibility' : 'visible' });		

			var transEndEvent = function( ev ){
				ev.stopPropagation();
				if( ! (jQuery( 'body' ).hasClass( 'side-menu-opened' ) ) && jQuery(ev.target).hasClass('be-sidemenu') ){
					jQuery(this).unbind( 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', transEndEvent );
					jQuery( '.be-sidemenu' ).css({ 'width' : '1px', 'height' : '1px', 'visibility' : 'hidden' });
				}
			};
			jQuery( '.be-sidemenu' ).bind('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', transEndEvent);
			jQuery( stack ).addClass('pages-stack--open');
			
			// now set the page transforms
			var stackPagesIdxs = getStackPagesIdxs(),
				solidHeaderHeight = jQuery( 'body' ).hasClass( 'header-solid' )? Number( jQuery( '#header-wrap' ).attr( 'data-default-height' ) ) : 0;

			setTimeout( function() {
				var yOffset = ( ( 0.75 * windowHeight ) - solidHeaderHeight ) + 'px';
				mainWrapper.css( 'perspective', '1200px' ) ;
				for(var i = 0, len = stackPagesIdxs.length; i < len; ++i) {
					var container = containers[stackPagesIdxs[i]];
					container.style.transform = 'translate3d(0,0,0)';
					container.style.WebkitTransform = 'translate3d(0,' + yOffset + ', ' + parseInt(-1 * 200 - 50*i) + 'px)'; // -200px, -230px, -260px
					container.style.transform = 'translate3d(0,' + yOffset + ', ' + parseInt(-1 * 200 - 50*i) + 'px)';
				}
			}, 0 );
		
		}
		callback();
	}

	// closes the menu
	function closeMenu() {
		openPage();	
	}

	// opens a page
	function openPage(id) {
		var futurePage = containers[current],
			stackPagesIdxs = getStackPagesIdxs( current );

		// set transforms for the new current page
		futurePage.style.WebkitTransform = 'translate3d(0, 0, 0)';
		futurePage.style.transform = '';
		futurePage.style.opacity = 1;

		// set transforms for the other items in the stack	
		for(var i = 0, len = stackPagesIdxs.length; i < len; ++i) {
			var container = containers[stackPagesIdxs[i]];
			container.style.WebkitTransform = 'translate3d(0,100%,0)';
			container.style.transform = 'translate3d(0,100%,0)';
		}
		jQuery( '.hamburger-nav-controller .be-mobile-menu-icon' ).removeClass( 'is-clicked' );
		jQuery('.be-sidemenu').removeClass('opened');
		jQuery('body').removeClass('side-menu-opened');
		if( jQuery( 'body' ).hasClass( 'admin-bar' ) ){
			jQuery( 'html' ).css( 'height', '' );
		}
		onEndTransition(futurePage, function() {
			jQuery(stack).removeClass('pages-stack--open');
			jQuery( 'body' ).removeClass( 'page-stack-top-opened' );
			mainWrapper.css( 'perspective', '' );
            for( var i = 0; i < pagesTotal ; i++  ){
                pages[i].style.top = '0px';
            }
            jQuery( "body,html" ).scrollTop( scrolled );
            if( id )
            {
				window.oshine_scripts.animate_scroll( jQuery( '#' + id ) );
            }
			// reorganize stack
			buildStack();
			isMenuOpen = false;
		});
	}

	// gets the current stack pages indexes. If any of them is the excludePage then this one is not part of the returned array
	function getStackPagesIdxs(excludePageIdx) {
		var nextStackPageIdx = current + 1 ,//< pagesTotal ? current + 1 : 0,
			nextStackPageIdx_2 = current + 2 ,//< pagesTotal ? current + 2 : nextStackPageIdx + 1 < pagesTotal ? nextStackPageIdx + 1 : 0,			
			idxs = [],
			excludeIdx = excludePageIdx || -1;

		if( excludePageIdx != current ) {
			idxs.push(current);
		}
		if( excludePageIdx != nextStackPageIdx ) {
			idxs.push(nextStackPageIdx);
		}
		if( excludePageIdx != nextStackPageIdx_2 ) {
			idxs.push(nextStackPageIdx_2);
		}
		return idxs;
	}

	 init();

})(window);