;(function(window) {

	'use strict';

	var support = { animations : Modernizr.cssanimations },
		animEndEventNames = { 'WebkitAnimation' : 'webkitAnimationEnd', 'OAnimation' : 'oAnimationEnd', 'msAnimation' : 'MSAnimationEnd', 'animation' : 'animationend' },
		animEndEventName = animEndEventNames[ Modernizr.prefixed( 'animation' ) ],
		onEndAnimation = function( el, callback ) {
			var onEndCallbackFn = function( ev ) {
				if( support.animations ) {
					if( ev.target != this ) return;
					this.removeEventListener( animEndEventName, onEndCallbackFn );
				}
				if( callback && typeof callback === 'function' ) { callback.call(); }
			};
			if( support.animations ) {
				el.addEventListener( animEndEventName, onEndCallbackFn );
			}
			else {
				onEndCallbackFn();
			}
		};

	function extend( a, b ) {
		for( var key in b ) { 
			if( b.hasOwnProperty( key ) ) {
				a[key] = b[key];
			}
		}
		return a;
	}

	function OldMenu(el, options) {
		this.el = el;
		this.options = extend( {}, this.options );
		extend( this.options, options );
		this.menus = jQuery(this.el).find( '.menu-container' ).toArray();
		// index of current menu
		this.current = 0;

		this._init();
	}

	OldMenu.prototype.options = {
		//Initial delay
		initialDelay : 200,
		// delay between each menu item sliding animation
		itemsDelayInterval : 60,
		// direction 
		direction : 'r2l'
	};

	OldMenu.prototype._init = function() {
		// iterate the existing menus and create an array of menus, more specifically an array of objects where each one holds the info of each menu element and its menu items
		this.menusArr = [];
		var self = this,
			menuAlignment = jQuery( '.be-sidemenu' ).attr( 'data-menu-alignment' );
		
		//In case scroll bar is not there, set align-self to user's selection else change it to auto
		if( jQuery( 'body' ).hasClass( 'overlay-left-align-menu' ) && jQuery( '.special-header-bottom-text' ).length > 0 ){
			var specialHeaderBottomText = jQuery( '.special-header-bottom-text' ),
				clientHeight =specialHeaderBottomText[0].clientHeight,
				scrollHeight =specialHeaderBottomText[0].scrollHeight;
			if( clientHeight == scrollHeight ){
				jQuery( specialHeaderBottomText ).css( 'align-self', menuAlignment );
			}
		}

		this.menus.forEach(function(menuEl, pos) {
			var menu = {menuEl : menuEl, menuItems : [].slice.call(menuEl.querySelectorAll('.menu-item'))},
				clientHeight = menuEl.clientHeight,
				scrollHeight = menuEl.scrollHeight;
			self.menusArr.push(menu);
			// set current menu class
			if( pos === self.current ) {
				classie.add(menuEl, 'menu__level--current');
			}	
			//In case scroll bar is not there, set justify-content to user's selection else let it stay in flex-start ( written in css )
			if( clientHeight == scrollHeight ){
				jQuery( menuEl ).css( 'justify-content', menuAlignment );
			}	
		});
				
		// if( jQuery( 'body' ).hasClass( 'left-static-menu' ) ){
		// 	self.animateMenu( 'openMenu' );
		// }
		// event binding
		this._initEvents();
	};

	OldMenu.prototype._initEvents = function() {
		var self = this;
		for(var i = 0, len = this.menusArr.length; i < len; ++i) {
			this.menusArr[i].menuItems.forEach(function(item, pos) {
				if( jQuery( item ).find('span.mobile-sub-menu-controller' ).length != 0 ){
					item.querySelector('.mobile-sub-menu-controller').addEventListener('click', function(ev) {
						var targetEle = jQuery( ev.target ).closest( '.menu-item' ).children( 'ul' ),
							menuItems = targetEle.find( 'li' ).toArray().filter( function ( item ){
								if( item.parentElement == targetEle[0] ){
									return true;
								}
								if( jQuery( item ).parent().css( 'display' ) != 'none' ){
									return true;
								}
							});
						if( targetEle.css( 'display' ) == 'none' ){
							// This means the click event has been generated and the menu is hidden, so animate it.
							self.animateSubMenu( menuItems, 'openMenu' );
						} else {
							self.animateSubMenu( menuItems, 'closeMenu' );
						}
					});
				}
			});
		}
		
		jQuery( document ).on( 'click', '.hamburger-nav-controller-wrap', function( ev ){
			//Animate the current menu on opening the side-menu
			//The sidemenu_navigation script will act first and add the side-menu-opened class first, hence now animate the menu, by calling animateMenu( 'openMenu' ), other case call the opposite
			if( jQuery( 'body' ).hasClass( 'perspective-left' ) || jQuery( 'body' ).hasClass( 'perspective-right' ) ){
				if( !jQuery( 'body' ).hasClass( 'perspectiveview-open' ) ){
					self.animateMenu( 'openMenu' );
				} else if( jQuery( 'body' ).hasClass( 'perspectiveview-open' ) ){
					self.animateMenu( 'closeMenu' );
				}
			} else {
				//The sidemenu_navigation script will act first and add the side-menu-opened class first, hence now animate the menu, by calling animateMenu( 'openMenu' ), other case call the opposite
				if( jQuery('body').hasClass( 'side-menu-opened' ) ){		
					self.animateMenu( 'openMenu' );
				} else {			
					self.animateMenu( 'closeMenu' );
				}
			}

		} );

		jQuery( document ).on( 'click', '#be-left-strip', function( ev ){
			//Animate the current menu on opening the side-menu
			//The sidemenu_navigation script will act first and add the side-menu-opened class first, hence now animate the menu, by calling animateMenu( 'openMenu' ), other case call the opposite
			if( jQuery( 'body' ).hasClass( 'perspective-right' ) ){
				if( !jQuery( 'body' ).hasClass( 'perspectiveview-open' ) ){	
					self.animateMenu( 'openMenu' );
				} else if( jQuery( 'body' ).hasClass( 'perspectiveview-open' ) ){
					self.animateMenu( 'closeMenu' );
				}
			} else {
				if( jQuery('body').hasClass( 'side-menu-opened' ) ){
					self.animateMenu( 'openMenu' );
				} else {
					self.animateMenu( 'closeMenu' );
				}
			}
		} );

		jQuery(document).on('click', '#main', function () {
			if( jQuery('body').hasClass( 'side-menu-opened' ) || jQuery('body').hasClass( 'perspectiveview' ) ){
				self.animateMenu( 'closeMenu' );
			}
			
		})
		
		jQuery( document ).on( 'click', '.be-overlay-menu-close', function(){
			if( jQuery('body').hasClass( 'side-menu-opened' ) ){
				self.animateMenu( 'openMenu' );
			} else {
				self.animateMenu( 'closeMenu' );
			}
		} )

		jQuery( window ).on( 'resize', function(){
			var menuAlignment = jQuery( '.be-sidemenu' ).attr( 'data-menu-alignment' ),
				specialHeaderBottomText = jQuery( '.special-header-bottom-text' ) ;
			setTimeout(function(){
				if( jQuery( 'body' ).hasClass( 'overlay-left-align-menu' ) && specialHeaderBottomText.length > 0 ){
					jQuery( specialHeaderBottomText ).css( 'align-self', 'auto' );
					var clientHeight =specialHeaderBottomText[0].clientHeight,
						scrollHeight =specialHeaderBottomText[0].scrollHeight;
					//In case scroll bar is not there, set align-self to user's selection else change it to auto
					if( clientHeight == scrollHeight ){
						jQuery( specialHeaderBottomText ).css( 'align-self', menuAlignment );
					} else {
						jQuery( specialHeaderBottomText ).css( 'align-self', 'auto' );
					}
				}
				self.menus.forEach(function(menuEl, pos) {
					var	clientHeight = menuEl.clientHeight,
						scrollHeight = menuEl.scrollHeight;
					//In case scroll bar is not there, set justify-content to user's selection else change it to flex-start
					if( clientHeight == scrollHeight ){
						jQuery( menuEl ).css( 'justify-content', menuAlignment );
					} else {
						jQuery( menuEl ).css( 'justify-content', 'flex-start' );
					}
				})
			}, 500 );
		} );

		document.addEventListener( 'keyup', function( ev ) {
			if( jQuery('body').hasClass( 'side-menu-opened' ) || jQuery('body').hasClass( 'perspectiveview' ) ){
				var keyCode = ev.keyCode || ev.which;
				if( keyCode === 27 ) {
					self.animateMenu( 'closeMenu' );
				}
			}
		} );


	};

	OldMenu.prototype.animateSubMenu = function( menuItems, animationType ){
		var self = this,
			parentElement = menuItems[0].parentElement,	
			farthestIdx = menuItems.length - 1;

		menuItems.forEach(function(item, pos) {
			item.style.WebkitAnimationDelay = item.style.animationDelay = parseInt(pos * self.options.itemsDelayInterval ) + 'ms' ;
			if( pos == farthestIdx ){
				onEndAnimation(item, function() {
					// reset classes
					if( animationType == 'closeMenu' ){
						switch( self.options.direction ){
							case 'r2l' : classie.remove(parentElement, 'animate-outToRight');
										break;
							case 'l2r' : classie.remove(parentElement, 'animate-outToLeft');
										break;
							case 't2b' : classie.remove(parentElement, 'animate-outToTop');
										break;
							case 'b2t' : classie.remove(parentElement, 'animate-outToBottom');
										break;
						}
					} else if( animationType == 'openMenu' ) {
						switch( self.options.direction ){
							case 'r2l' : classie.remove(parentElement, 'animate-inFromRight');
										break;
							case 'l2r' : classie.remove(parentElement, 'animate-inFromLeft');
										break;
							case 't2b' : classie.remove(parentElement, 'animate-inFromTop');
										break;
							case 'b2t' : classie.remove(parentElement, 'animate-inFromBottom');
										break;
						}
					}
					
				});
				//setTimeout is used of 450ms as in 400ms the jQuery animate used for animating submenu finishes 
				setTimeout(function(){self.menus.forEach(function(menuEl, pos) {
					var	clientHeight = menuEl.clientHeight,
						scrollHeight = menuEl.scrollHeight;
					
					//In case scroll bar is not there, set justify-content to user's selection else change it to flex-start
					if( clientHeight == scrollHeight ){
						jQuery( menuEl ).css( 'justify-content', jQuery( '.be-sidemenu' ).attr( 'data-menu-alignment' ) );
					} else {
						jQuery( menuEl ).css( 'justify-content', 'flex-start' );
					}
				})},450);
			}
			if( animationType == 'closeMenu' ){
				// item.style.WebkitAnimationDelay = item.style.animationDelay = parseInt(pos * self.options.itemsDelayInterval / 4 ) + 'ms' ;
				switch( self.options.direction ){
					case 'r2l' : classie.add(parentElement, 'animate-outToRight');
									break;
					case 'l2r' : classie.add(parentElement, 'animate-outToLeft');
									break;
					case 't2b' : classie.add(parentElement, 'animate-outToTop');
									break;
					case 'b2t' : classie.add(parentElement, 'animate-outToBottom');
									break;
				}
			} else if( animationType == 'openMenu' ) {
				switch( self.options.direction ){
					case 'r2l' : classie.add(parentElement, 'animate-inFromRight');
									break;
					case 'l2r' : classie.add(parentElement, 'animate-inFromLeft');
									break;
					case 't2b' : classie.add(parentElement, 'animate-inFromTop');
									break;
					case 'b2t' : classie.add(parentElement, 'animate-inFromBottom');
									break;
				}
			}
		});
	};

	OldMenu.prototype.animateMenu = function( animationType ){
		var self = this,
			// Get all the menu-items which are visible
			menuItems = typeof self.menusArr[self.current] != 'undefined' ? jQuery( self.menusArr[self.current].menuItems ).filter( ":visible" ).toArray() : [],
			farthestIdx = menuItems.length - 1,
			specialHeaderBottomText = jQuery( '.special-header-bottom-text' ),
			specialHeaderLogo = jQuery( '.special-header-logo' );

		menuItems.forEach(function(item, pos) {
			// Add the initial delay too when menu opens
			item.style.WebkitAnimationDelay = item.style.animationDelay = parseInt( (pos * self.options.itemsDelayInterval) + self.options.initialDelay ) + 'ms' ;
			if( pos == farthestIdx ){
				onEndAnimation(item, function() {
					// reset classes
					if( animationType == 'closeMenu' ){
						classie.remove(self.menusArr[self.current].menuEl, 'animate-closemenu');
					} else if( animationType == 'openMenu' ) {
						switch( self.options.direction ){
							case 'r2l' : classie.remove(self.menusArr[self.current].menuEl, 'animate-inFromRight');
										break;
							case 'l2r' : classie.remove(self.menusArr[self.current].menuEl, 'animate-inFromLeft');
										break;
							case 't2b' : classie.remove(self.menusArr[self.current].menuEl, 'animate-inFromTop');
										break;
							case 'b2t' : classie.remove(self.menusArr[self.current].menuEl, 'animate-inFromBottom');
										break;
						}
					}
				});
			}
			if( animationType == 'closeMenu' ){
				item.style.WebkitAnimationDelay = item.style.animationDelay = parseInt(	0 ) + 'ms' ;
				classie.add(self.menusArr[self.current].menuEl, 'animate-closemenu');
			} else if( animationType == 'openMenu' ) {
				switch( self.options.direction ){
					case 'r2l' : classie.add(self.menusArr[self.current].menuEl, 'animate-inFromRight');
									break;
					case 'l2r' : classie.add(self.menusArr[self.current].menuEl, 'animate-inFromLeft');
									break;
					case 't2b' : classie.add(self.menusArr[self.current].menuEl, 'animate-inFromTop');
									break;
					case 'b2t' : classie.add(self.menusArr[self.current].menuEl, 'animate-inFromBottom');
									break;
				}
			}
		});

		var logoTextAnimationEndFunction = function( specialHeaderItem ) {
			// reset classes
			if( animationType == 'closeMenu' ){
				specialHeaderItem.removeClass( 'animate-closemenu');
			} else if( animationType == 'openMenu' ) {
				switch( self.options.direction ){
					case 'r2l' :specialHeaderItem.removeClass( 'animate-inFromRight');
								break;
					case 'l2r' :specialHeaderItem.removeClass( 'animate-inFromLeft');
								break;
					case 't2b' :specialHeaderItem.removeClass( 'animate-inFromTop');
								break;
					case 'b2t' :specialHeaderItem.removeClass( 'animate-inFromBottom');
								break;
				}
			}
		};

		if( specialHeaderBottomText.length != 0 ){
			onEndAnimation(specialHeaderBottomText[0], logoTextAnimationEndFunction.bind( null, specialHeaderBottomText) );
		}
		if( specialHeaderLogo.length != 0 ){
			onEndAnimation(specialHeaderLogo[0], logoTextAnimationEndFunction.bind(null, specialHeaderLogo) );
		}

		if( animationType == 'closeMenu' ){
			specialHeaderBottomText.css( 'animation-delay', parseInt( 0 ) + 'ms' );
			specialHeaderLogo.css( 'animation-delay', parseInt( 0 ) + 'ms' );
			specialHeaderBottomText.addClass( 'animate-closemenu');
			specialHeaderLogo.addClass( 'animate-closemenu');
		} else if( animationType == 'openMenu' ) {
			specialHeaderBottomText.css( 'animation-delay', parseInt( self.options.initialDelay ) + 'ms' );			
			specialHeaderLogo.css( 'animation-delay', parseInt( self.options.initialDelay ) + 'ms' );			
			switch( self.options.direction ){
				case 'r2l' : 
								specialHeaderBottomText.addClass( 'animate-inFromRight');
								specialHeaderLogo.addClass( 'animate-inFromRight');
								break;
				case 'l2r' : 
								specialHeaderBottomText.addClass( 'animate-inFromLeft');
								specialHeaderLogo.addClass( 'animate-inFromLeft');
								break;
				case 't2b' : 
								specialHeaderBottomText.addClass( 'animate-inFromTop');
								specialHeaderLogo.addClass( 'animate-inFromTop');
								break;
				case 'b2t' : 
								specialHeaderBottomText.addClass( 'animate-inFromBottom');
								specialHeaderLogo.addClass( 'animate-inFromBottom');
								break;
			}
			// if( jQuery( 'body' ).hasClass( 'left-static-menu' ) ){
			// 	specialHeaderBottomText.css( 'visibility', 'visible' );
			// 	specialHeaderLogo.css( 'visibility', 'visible' );
			// }
		}
	};
	window.OldMenu = OldMenu;

})(window);