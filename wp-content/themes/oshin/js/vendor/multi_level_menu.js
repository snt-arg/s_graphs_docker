/**
 * main.js
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2015, Codrops
 * http://www.codrops.com
 */
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

	function MLMenu(el, options) {
		this.el = el;
		this.options = extend( {}, this.options );
		extend( this.options, options );
		this.menus = jQuery(this.el).find( '.menu-container' ).toArray();
		// index of current menu
		this.current = 0;

		this._init();
	}

	MLMenu.prototype.options = {
		// show breadcrumbs
		breadcrumbsCtrl : false,
		// initial breadcrumb text
		initialBreadcrumb : 'all',
		// show back button
		backCtrl : true,
		//Initial delay
		initialDelay : 200,
		// delay between each menu item sliding animation
		itemsDelayInterval : 60,
		// direction 
		direction : 'r2l',
		// callback: item that doesn´t have a submenu gets clicked
		// onItemClick([event], [inner HTML of the clicked item])
		onItemClick : function(ev, itemName) { return false; }
	};

	MLMenu.prototype._init = function() {
		// iterate the existing menus and create an array of menus, more specifically an array of objects where each one holds the info of each menu element and its menu items
		this.menusArr = [];
		var self = this,
			menuAlignment = jQuery( '.be-sidemenu' ).attr( 'data-menu-alignment' );
		
		if( this.options.backCtrl ) {
			this.backCtrl = document.createElement('button');
			this.backCtrl.className = 'menu__back menu__back--hidden';
			this.backCtrl.setAttribute('aria-label', 'Go back');
			this.backCtrl.innerHTML = '<span class="icon icon--arrow-left"></span>';
		}

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
			if( jQuery( menuEl ).hasClass( 'sub-menu' ) ){
				jQuery(menuEl).prepend( "<li class='menu-item'><span class = 'menu__back'><span class = 'icon icon--arrow-left'></span></span></li>" );
			}
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
		
		if( jQuery( 'body' ).hasClass( 'left-static-menu' ) ){
			jQuery( '.special-header-menu' ).css('display','block');
			self.animateMenu( 'openMenu' );
		}
		// event binding
		this._initEvents();
	};

	MLMenu.prototype._initEvents = function() {
		var self = this;
		for(var i = 0, len = this.menusArr.length; i < len; ++i) {
			this.menusArr[i].menuItems.forEach(function(item, pos) {
				if( jQuery( item ).find('span.sub-menu-controller' ).length != 0 ){
					item.querySelector('.sub-menu-controller').addEventListener('click', function(ev) {
						var targetEle = jQuery( ev.target ).closest( '.menu-item' )[0].children[0];
						var submenu = targetEle.getAttribute('data-submenu'),
							itemName = targetEle.innerHTML,
							subMenuEl = self.el.querySelector('ul[data-menu="' + submenu + '"]');
						
						// check if there's a sub menu for this item
						if( submenu && subMenuEl ) {
							ev.preventDefault();
							// open it
							self._openSubMenu(subMenuEl, pos, itemName);
						}
						else {
							// add class current
							var currentlink = self.el.querySelector('.menu__link--current');
							if( currentlink ) {
								classie.remove(self.el.querySelector('.menu__link--current'), 'menu__link--current');
							}
							classie.add(targetEle, 'menu__link--current');
							
							// callback
							self.options.onItemClick(ev, itemName);
					}
					});
				}
				if( '#' == jQuery( item ).find('a').attr('href') || 'undefined' == typeof jQuery( item ).find('a').attr('href') ){
					// If the link is # or empty, open the submenu on click in case it has submenu
					item.addEventListener( 'click', function(ev){
						var submenu = ev.target.getAttribute('data-submenu'),
							itemName = ev.target.innerHTML,
							subMenuEl = self.el.querySelector('ul[data-menu="' + submenu + '"]');

						// check if there's a sub menu for this item
						if( submenu && subMenuEl ) {
							ev.preventDefault();
							// open it
							self._openSubMenu(subMenuEl, pos, itemName);
						}
						else {
							// add class current
							var currentlink = self.el.querySelector('.menu__link--current');
							if( currentlink ) {
								classie.remove(self.el.querySelector('.menu__link--current'), 'menu__link--current');
							}
							classie.add(ev.target, 'menu__link--current');							
							// callback
							self.options.onItemClick(ev, itemName);
						}
					} )
				}
			});
		}
		
		// back navigation
		if( this.options.backCtrl ) {
			jQuery( document ).on( 'click', '.menu__back', function( ev ){
				self._back();
			} );
		}

		jQuery( document ).on( 'click', '.hamburger-nav-controller-wrap', function( ev ){
			//Animate the current menu on opening the side-menu
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

	MLMenu.prototype.animateMenu = function( animationType ){
		var self = this,
			menuItems = typeof self.menusArr[self.current] != 'undefined' ? self.menusArr[self.current].menuItems : [],
			farthestIdx = menuItems.length - 1,
			specialHeaderBottomText = jQuery( '.special-header-bottom-text' ),
			specialHeaderLogo = jQuery( '.special-header-logo' );
		if( self.isAnimating == false || 'undefined' == typeof self.isAnimating ){
			self.isAnimating = true;
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

						self.isAnimating = false;
					});
				}			
				if( animationType == 'closeMenu' ){
					item.style.WebkitAnimationDelay = item.style.animationDelay = parseInt(	0 ) + 'ms' ;
					classie.add(self.menusArr[self.current].menuEl, 'animate-closemenu');
					self.isAnimating = false;
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
		}

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
			if( jQuery( 'body' ).hasClass( 'left-static-menu' ) ){
				specialHeaderBottomText.css( 'visibility', 'visible' );
				specialHeaderLogo.css( 'visibility', 'visible' );
			}
		}
	};

	MLMenu.prototype._openSubMenu = function(subMenuEl, clickPosition, subMenuName) {
		if( this.isAnimating ) {
			return false;
		}
		this.isAnimating = true;
		
		// save "parent" menu index for back navigation
		this.menusArr[this.menus.indexOf(subMenuEl)].backIdx = this.current;
		// save "parent" menu´s name
		this.menusArr[this.menus.indexOf(subMenuEl)].name = subMenuName;
		// current menu slides out
		this._menuOut(clickPosition);
		// next menu (submenu) slides in
		this._menuIn(subMenuEl, clickPosition);
	};

	MLMenu.prototype._back = function() {
		if( this.isAnimating ) {
			return false;
		}

		this.isAnimating = true;

		// current menu slides out
		this._menuOut();
		// next menu (previous menu) slides in
		var backMenu = this.menusArr[this.menusArr[this.current].backIdx].menuEl;
		this._menuIn(backMenu);

		// remove last breadcrumb
		if( this.options.breadcrumbsCtrl ) {
			this.breadcrumbsCtrl.removeChild(this.breadcrumbsCtrl.lastElementChild);
		}
	};

	MLMenu.prototype._menuOut = function(clickPosition) {
		// the current menu
		var self = this,
			currentMenu = this.menusArr[this.current].menuEl,
			isBackNavigation = typeof clickPosition == 'undefined' ? true : false;

		// slide out current menu items - first, set the delays for the items
		this.menusArr[this.current].menuItems.forEach(function(item, pos) {
			item.style.WebkitAnimationDelay = item.style.animationDelay = isBackNavigation ? parseInt(pos * self.options.itemsDelayInterval) + 'ms' : parseInt(Math.abs(clickPosition - pos) * self.options.itemsDelayInterval) + 'ms';
		});
		// animation class
		switch( this.options.direction ){
			case 'r2l' : classie.add(currentMenu, isBackNavigation ? 'animate-outToRight' : 'animate-outToLeft');
						 break;
			case 'l2r' : classie.add(currentMenu, isBackNavigation ? 'animate-outToLeft' : 'animate-outToRight');	
						 break;
			case 't2b' : classie.add(currentMenu, isBackNavigation ? 'animate-outToTop' : 'animate-outToBottom');
						 break;
			case 'b2t' : classie.add(currentMenu, isBackNavigation ? 'animate-outToBottom' : 'animate-outToTop');
						 break;
		}
	};

	MLMenu.prototype._menuIn = function(nextMenuEl, clickPosition) {
		
		var self = this,
			// the current menu
			currentMenu = this.menusArr[this.current].menuEl,
			isBackNavigation = typeof clickPosition == 'undefined' ? true : false,
			// index of the nextMenuEl
			nextMenuIdx = this.menus.indexOf(nextMenuEl);

			
		var	nextMenuItems = this.menusArr[nextMenuIdx].menuItems,
			nextMenuItemsTotal = nextMenuItems.length;
		// slide in next menu items - first, set the delays for the items
		nextMenuItems.forEach(function(item, pos) {
			item.style.WebkitAnimationDelay = item.style.animationDelay = isBackNavigation ? parseInt(pos * self.options.itemsDelayInterval) + 'ms' : parseInt(Math.abs(clickPosition - pos) * self.options.itemsDelayInterval) + 'ms';

			// we need to reset the classes once the last item animates in
			// the "last item" is the farthest from the clicked item
			// let's calculate the index of the farthest item
			var farthestIdx = clickPosition <= nextMenuItemsTotal/2 || isBackNavigation ? nextMenuItemsTotal - 1 : 0;

			if( pos === farthestIdx ) {
				onEndAnimation(item, function() {
					// reset classes
					switch( self.options.direction ){
						case 'r2l' : classie.remove(currentMenu, isBackNavigation ? 'animate-outToRight' : 'animate-outToLeft' );
									 classie.remove(nextMenuEl, isBackNavigation ? 'animate-inFromLeft' : 'animate-inFromRight' ); 
									 break;
						case 'l2r' : classie.remove(currentMenu, isBackNavigation ? 'animate-outToLeft' : 'animate-outToRight');
									 classie.remove(nextMenuEl, isBackNavigation ? 'animate-inFromRight' : 'animate-inFromLeft');
									 break;
						case 't2b' : classie.remove(currentMenu, isBackNavigation ? 'animate-outToTop' : 'animate-outToBottom');
									 classie.remove(nextMenuEl, isBackNavigation ? 'animate-inFromBottom' : 'animate-inFromTop');
									 break;
						case 'b2t' : classie.remove(currentMenu, isBackNavigation ? 'animate-outToBottom' : 'animate-outToTop');
									 classie.remove(nextMenuEl, isBackNavigation ? 'animate-inFromTop' : 'animate-inFromBottom');
									 break;
					}
					classie.remove(currentMenu, 'menu__level--current');
					classie.add(nextMenuEl, 'menu__level--current');

					//reset current
					self.current = nextMenuIdx;
					
					// we can navigate again..
					self.isAnimating = false;
				});
			}
		});	
		
		// animation class
		switch( this.options.direction ){
			case 'r2l' : classie.add(nextMenuEl, isBackNavigation ? 'animate-inFromLeft' : 'animate-inFromRight' );
						 break;
			case 'l2r' : classie.add(nextMenuEl, isBackNavigation ? 'animate-inFromRight' : 'animate-inFromLeft');
						 break;
			case 't2b' : classie.add(nextMenuEl, isBackNavigation ? 'animate-inFromBottom' : 'animate-inFromTop');
						 break;
			case 'b2t' : classie.add(nextMenuEl, isBackNavigation ? 'animate-inFromTop' : 'animate-inFromBottom');
						 break;
		}
	};

	MLMenu.prototype._addBreadcrumb = function(idx) {
		if( !this.options.breadcrumbsCtrl ) {
			return false;
		}

		var bc = document.createElement('a');
		bc.innerHTML = idx ? this.menusArr[idx].name : this.options.initialBreadcrumb;
		this.breadcrumbsCtrl.appendChild(bc);

		var self = this;
		bc.addEventListener('click', function(ev) {
			ev.preventDefault();

			// do nothing if this breadcrumb is the last one in the list of breadcrumbs
			if( !bc.nextSibling || self.isAnimating ) {
				return false;
			}

			self.isAnimating = true;
			
			// current menu slides out
			self._menuOut();
			// next menu slides in
			var nextMenu = self.menusArr[idx].menuEl;
			self._menuIn(nextMenu);

			// remove breadcrumbs that are ahead
			var siblingNode;
			while (siblingNode = bc.nextSibling) {
				self.breadcrumbsCtrl.removeChild(siblingNode);
			}
		});
	};

	window.MLMenu = MLMenu;

})(window);