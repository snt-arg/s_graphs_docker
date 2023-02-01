;(function($) {
    jQuery.fn.center = function(parent) {
        if (parent) {
            parent = this.parent();
        } else {
            parent = window;
        }
        this.css({
            "position": "absolute",
            "top": (((jQuery(parent).height() - this.outerHeight()) / 2) + jQuery(parent).scrollTop() + "px"),
            "left": (((jQuery(parent).width() - this.outerWidth()) / 2) + jQuery(parent).scrollLeft() + "px")
        });
        return this;
    }
})(jQuery);

// Custom Side with Fade Animation
;(function($) {
    jQuery.fn.slideFadeToggle  = function(speed, easing, callback) {
        return this.animate({opacity: 'toggle', height: 'toggle', padding: 'toggle', margin: 'toggle'}, speed, easing, callback);
    };
})();

/**OS SCROLLBAR**/
;(function($) {
	var scrollbarWidth = 0;
	$.getScrollbarWidth = function() {
		if ( !scrollbarWidth ) {
			// if ( $.browser.msie ) {
			if (navigator.userAgent.match(/MSIE ([0-9]+)\./)){
				var $textarea1 = $('<textarea cols="10" rows="2"></textarea>')
						.css({ position: 'absolute', top: -1000, left: -1000 }).appendTo('body'),
					$textarea2 = $('<textarea cols="10" rows="2" style="overflow: hidden;"></textarea>')
						.css({ position: 'absolute', top: -1000, left: -1000 }).appendTo('body');
				scrollbarWidth = $textarea1.width() - $textarea2.width();
				$textarea1.add($textarea2).remove();
			} else {
				var $div = $('<div />')
					.css({ width: 100, height: 100, overflow: 'auto', position: 'absolute', top: -1000, left: -1000 })
					.prependTo('body').append('<div />').find('div')
						.css({ width: '100%', height: 200 });
				scrollbarWidth = 100 - $div.width();
				$div.parent().remove();
			}
		}
		return scrollbarWidth;
	};
})(jQuery);

//Parallax
;(function( $ ) {
	var $window = $(window), update_parallax;
	var windowHeight = $window.height();

	$window.resize(function () {
		windowHeight = $window.height();
	});

	$.fn.parallax = function(xpos, speedFactor, outerHeight) {
		var $this = $(this);
		var getHeight;
		var firstTop;
		var paddingTop = 0;
		//get the starting position of each element to have parallax applied to it    
		$this.each(function(){
			firstTop = $this.offset().top;
		});
		if (outerHeight) {
			getHeight = function(jqo) {
			return jqo.outerHeight(true);
		};
		} else {
			getHeight = function(jqo) {
				return jqo.height();
			};
		}
		// setup defaults if arguments aren't specified
		if (arguments.length < 1 || xpos === null) xpos = "50%";
		if (arguments.length < 2 || speedFactor === null) speedFactor = 0.5;
		if (arguments.length < 3 || outerHeight === null) outerHeight = true;
		// function to be called whenever the window is scrolled or resized
		update_parallax = function() {
			var pos = $window.scrollTop();
			$this.each(function() {
				var $element = $(this);
				var top = $element.offset().top;
				var height = getHeight($element);
				// Check if totally above or totally below viewport
				if (top + height < pos || top > pos + windowHeight) {
					return;
				}
				$this.css('backgroundPosition', xpos + " " + Math.round((firstTop - pos) * speedFactor) + "px");
			});
		}
		$window.on('scroll.parallaxscroll', update_parallax);
		$window.on('smartresize.parallaxresize', update_parallax);
		update_parallax();
	};
	jQuery(document).on("update_content", function() {
		if(jQuery(this).find('.be-section.be-bg-parallax').length == 0) {
			$window.off('scroll.parallaxscroll', update_parallax);
			$window.off('scroll.parallaxresize', update_parallax);
		}
    });
})(jQuery);


;(function( $ ) {
    'use strict';

	var vendorScriptsUrl = oshineThemeConfig.vendorScriptsUrl,
		dependencies = oshineThemeConfig.dependencies || {};

	if( 'undefined' != typeof dependencies ) {
		for( var dependency in dependencies ) {
			if( dependencies.hasOwnProperty( dependency ) ) {
				asyncloader.register( dependencies[ dependency ], dependency );
			}
		}
	}
	
	/**
	 * youtube player api
	 */
	(function($) {
		if( $( '.be-youtube-embed' ).length ) {
			var tag = document.createElement('script');
			tag.src = "https://www.youtube.com/iframe_api";
			var firstScriptTag = document.getElementsByTagName('script')[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
			var previousAPIReadyCallback = window.onYouTubeIframeAPIReady;
			window.onYouTubeIframeAPIReady =  function() {
				if( 'function' == typeof previousAPIReadyCallback ) {
					previousAPIReadyCallback();
				}
				$(document).trigger( 'YTAPIReady' );
			}
		}
	})(jQuery);

	asyncloader.register( 'https://f.vimeocdn.com/js/froogaloop2.min.js' , 'vimeo' );
	asyncloader.register( "https://player.vimeo.com/api/player.js", 'vimeonew' );

	
    function Selector_Cache() {
	    var collection = {};

	    function get_from_cache( selector ) {
	        if ( undefined === collection[ selector ] ) {
	            collection[ selector ] = jQuery( selector );
	        }

	        return collection[ selector ];
	    }

	    return { get: get_from_cache };
	}

    jQuery(document).ready( function() {


	    var oshine_scripts = (function() {

	    	var page_loader = jQuery('.page-loader'), 
	    	 	 ajax_url = jQuery('#ajax_url').val(), 
				 fixedFooter = jQuery( '#be-fixed-footer-wrap' ),
				 fixedFooterPlaceholder = jQuery( '#be-fixed-footer-placeholder' ),
	    	 	 transition, 
	    	 	 exclude_links,
	    	 	 body = jQuery('body'),
                  html = jQuery('html'),
                  $win = jQuery(window),
                  $doc = jQuery(document),
	    	 	 selectors = new Selector_Cache(),
	    	 	 to_top_button = jQuery('#back-to-top'),
	    	 	 fullscreen_wrap = jQuery('.hero-section-wrap, .full-screen-section, .tatsu-fullscreen'),
				 didScroll = false, 
	    	 	 

	    	resize_gallery_video =  function() {
		        if (jQuery(window).width() < 769) {
		        	var width = jQuery('#gallery-container-wrap').width();
		            jQuery('iframe.gallery').each(function () {
		                jQuery(this).width( width );
		            });
		        } else {
		            jQuery('iframe.gallery').each(function () {
		                jQuery(this).width( ( jQuery(this).height() * 1.77 ) );
		            });
		        }
	    	},

	    	menu_link_animation = function() {
		        var delay = 100, 
		            index = 0,
		            slidebar_menu = document.getElementById("slidebar-menu").children,
		            child_count = slidebar_menu.length;
				setTimeout( function(){
					jQuery('#slidebar-menu').children('li').each( function(i, el ){
						setTimeout( function(){
							jQuery(this).addClass("menu-loaded");
						}.bind(this), delay * i );
					}); 
				}, 500 );  				
	    	},

	    	custom_scrollbar = function() {
	    		if( !body.hasClass('tatsu-frame') ) {
		    		var gallery_content = jQuery('.simplebar-content');
				        if ( gallery_content.length > 0 ) {
							gallery_content.perfectScrollbar();
							
				        }
				} 		
	    	}, 

	    	single_page_nav = function() {
	    		if ( body.hasClass('single-page-version') && !body.hasClass('section-scroll') ) {
			        var append_section = '',
			            specific_section = jQuery('.tatsu-section'),
			            section_length = specific_section.length,
			            section_id, 
			            section_title,
			            index = 0;
			        if( jQuery('.single-page-nav-wrap').length > 0 ){
			            body.find('.single-page-nav-wrap').remove();
			        }
		           
		            if( jQuery('#hero-section').length > 0 ){
		                append_section = '<a class="single-page-nav-link back-to-top" href="#"><span>Home</span></a>';
		            }
		            for ( index; index < section_length; index++ ) {
		                section_id = specific_section.eq(index).attr('id');
		                section_title = specific_section.eq(index).attr('data-title');
		                if( section_id ){
		                    if( section_title ){   
		                        section_title = "<span>" + section_title + "</span>";                                                 
		                    } else {
		                        section_title = '';
		                    }
		                    append_section += '<a class="single-page-nav-link" href="#'+section_id+'">'+section_title+'</a>';       
		                }
		            }
		            body.append('<div class="single-page-nav-wrap clearfix"><div class="single-page-nav-wrap-inner clearfix"><div class="sinle-page-nav-links">'+append_section+'</div></div></div>');
		        } 
		        
	    	},

	    	menu_item_update = function() {
		        var header_height = jQuery('#wpadminbar').height() + 1,
		            main_menu_items = jQuery('li.menu-item'),
		            single_page_nav_dots = jQuery('.single-page-nav-link'),  //Should add context after converting single-page-nav-wrap and single-page-nav-links to ID
		            total_sections = jQuery('.tatsu-section'),
		            section_count = total_sections.length,
		            window_height = jQuery(window),
		            header_bottom_bar = jQuery('#header-bottom-bar'),
		            index = 0;
		        if( body.hasClass('top-header') ){
		            header_height += Number_or_zero( jQuery('#header-wrap').attr('data-default-height') );
		            if( header_bottom_bar.length > 0 ){
		                header_height += header_bottom_bar.height();
		            }
		        }
		        if( body.hasClass('single-page-version') ){
		            main_menu_items.removeClass('current-menu-item');
		            for( index; index < section_count; index++ ) {
		                var current_object = total_sections.eq(index),
		                    current_object_id = current_object.attr('id');           
		                if( window_height.scrollTop() + header_height >= current_object.offset().top ){
		                    main_menu_items.removeClass('current-menu-item current-section');
		                    single_page_nav_dots.removeClass('current-section-nav-link');
		                    if( current_object_id ){
		                        main_menu_items.find('a[href$="#'+ current_object_id +'"]').closest('li.menu-item').addClass('current-menu-item current-section');
		                        single_page_nav_dots.filter('a[href$="#' + current_object_id + '"]').addClass('current-section-nav-link');
		                    }
		                }
		            }
		        }
	    	},



	    	open_leftstrip = function() {
				if( jQuery( 'body' ).hasClass( 'left-sliding' ) || jQuery( 'body' ).hasClass( 'top-overlay-menu' ) ){
					jQuery('.left-strip-wrapper').removeClass('hide');
					html = html.removeClass('hide-overflow');	    
				}		
	    	},



	    	animate_scroll = function( element ) {
		        if ( body.hasClass('section-scroll') && ( jQuery(window).width() > 1024 ) && html.hasClass('csstransforms') ) {
		            jQuery.fn.translate(element);
		            return false;
				}
				if (jQuery(element).hasClass('be-gdpr-popup') || jQuery(element).hasClass('white-popup') ){
                    return false;
                }
		        var $scroll_to = 1, 
		        $sticky_offset,
		        header_wrap = jQuery('#header-wrap'),
		        header_wrap_default_height = Number_or_zero( header_wrap.attr('data-default-height') ),
		        header_wrap_sticky_height = Number_or_zero( header_wrap.attr('data-sticky-height') ),
		        top_bar_height = Number_or_zero( jQuery('#header-top-bar-wrap').innerHeight() ),
		        bottom_bar_height = Number_or_zero( jQuery('#header-bottom-bar').innerHeight() ),
		        admin_bar_height = Number_or_zero( jQuery('#wpadminbar').height() ),
		        hero_section = jQuery('.header-hero-section'),
		        first_pb_section = jQuery( '#page-content div' ).children( '.tatsu-section:nth-child(1)'),
		        bordered_header_layout = jQuery('#main').hasClass('layout-border-header-top');


		        if ( element.length > 0 ) {
					$scroll_to = Number_or_zero( element.offset().top ) - admin_bar_height;
		        }

		        if ( jQuery(window).width() > 960 && !( body.hasClass('page-template-page-splitscreen-left')  || body.hasClass('page-template-page-splitscreen-right') ) ) {
		            if ( body.hasClass('sticky-header') || body.hasClass('transparent-sticky') ) {
		                if ( body.hasClass('sticky-header') ) {
		                    $sticky_offset = jQuery('#header').offset().top + header_wrap_default_height + top_bar_height + bottom_bar_height;
		                }
		                if ( body.hasClass('transparent-sticky') ) {
		                    if( hero_section.length > 0 ){
		                        $sticky_offset = Number_or_zero( hero_section.offset().top ) + Number_or_zero( hero_section.height() )  - admin_bar_height;    
		                    } else if( first_pb_section.length > 0 ) {
		                        $sticky_offset = Number_or_zero( first_pb_section.offset().top ) + Number_or_zero( first_pb_section.height() ) - admin_bar_height;
		                    }
						}
						
		                if( bordered_header_layout ) { 
		                    $scroll_to = $scroll_to - ( header_wrap_default_height + bottom_bar_height );
		                } else {
		                    if ($scroll_to > $sticky_offset) {
		                        $scroll_to = $scroll_to - ( header_wrap_sticky_height + bottom_bar_height );
		                    }
		                    if ($scroll_to < $sticky_offset) {
		                        $scroll_to = $scroll_to - ( header_wrap_default_height + bottom_bar_height );
		                    }
		                    if ($scroll_to === $sticky_offset && jQuery('body').hasClass('transparent-sticky')) {
		                        $scroll_to = $scroll_to - ( header_wrap_sticky_height + bottom_bar_height );
		                    }
						} 
						
						
		            } else {
		                if( bordered_header_layout ) {
							$scroll_to = $scroll_to - Number_or_zero( jQuery('#header-inner-wrap' ).innerHeight() );
		                }
		            }
		        }
				//console.log("$scroll_to",$scroll_to);
		        jQuery('body, html').animate({scrollTop: $scroll_to }, 1000, 'easeOutQuart', function () {
		            close_sidebar();
		            open_leftstrip();
		            menu_item_update();
		        });	    		
	    	},

		    sticky_sidebar = function() {
		        var $window = jQuery(window), 
		        $sidebar = jQuery( ".floting-sidebar" ), 
		        offset = jQuery( '#content-wrap' ).offset(), 
		        $scrollHeight = jQuery( "#page-content" ).height(), 
		        $scrollOffset = jQuery( "#page-content" ).offset(), 
		        $headerHeight = 0,
		        admin_bar_height = Number_or_zero( jQuery('#wpadminbar').innerHeight() );

		        if ( $sidebar.length > 0 && !body.hasClass('tatsu-frame') ) {
		            if ( body.hasClass('sticky-header') || body.hasClass('transparent-sticky')) {
		                $headerHeight = Number_or_zero( jQuery('#header-inner-wrap').innerHeight() ) + admin_bar_height;
		            } else {
		                $headerHeight = admin_bar_height;
		            }
		            if ( $window.width() > 960 ) {
		                if ( ( $window.scrollTop() + $headerHeight ) > offset.top ) {
		                    if ( $window.scrollTop() + $headerHeight + $sidebar.height() + 50 < $scrollOffset.top + $scrollHeight ) {
		                        $sidebar.stop().animate({
		                            marginTop: ( $window.scrollTop() - offset.top ) + $headerHeight + 30,
		                            paddingTop: 30
		                        });
		                    } else {
		                        $sidebar.stop().animate({
		                            marginTop: ( $scrollHeight - $sidebar.height() - 80 ) + 30,
		                            paddingTop: 30
		                        });
		                    }
		                } else {
		                    $sidebar.stop().animate({
		                        marginTop: 0,
		                        paddingTop: 0
		                    });
		                }
		            } else {
		                $sidebar.css('margin-top', 0);
		            }
		        }
		        if ( jQuery(".fixed-sidebar").length > 0 ) {
		            var $sidebarSelector = jQuery(".fixed-sidebar"),
					offset = jQuery('#content-wrap').offset(),
					$mainWrapper = jQuery( '#main-wrapper' ),
					isOverflow = $sidebarSelector.closest( '.fixed-sidebar-page' ).hasClass( 'be-content-overflow' ),
					overflowWrapper = jQuery( '#be-overflow-image-content-inner' ),
					marginLeftOffset = 0,
		            $scrollHeight = jQuery("#page-content").height(),
		            $scrollOffset = jQuery("#page-content").offset(),
		            $scroll_top = $window.scrollTop(),
		            $footerHeight = Number_or_zero(jQuery('#footer').outerHeight()),
		            $widgetsHeight = Number_or_zero(jQuery('#bottom-widgets').outerHeight()),
		            $sidebarHeight = $sidebarSelector.find('.fixed-sidebar-content .be-section').outerHeight(),
					$portfolioNavigationHeight = Number_or_zero(jQuery( '#portfolio-navigation-bottom-wrap' ).outerHeight()),
		            $headerHeight = Number_or_zero( jQuery( '#header-wrap' ).attr( 'data-sticky-height' ) ) || Number_or_zero(jQuery('#header-inner-wrap').height()),// + Number_or_zero(jQuery('#wpadminbar').height()),
					$heroSectionHeight = Number_or_zero(jQuery('.hero-section-wrap').height()),
					$sidebar_width = ( $sidebarSelector.attr('data-sidebar-width')/100 ) || 0.428,
		            $headerTopPadding = 0,
		            $breakingPoint1 = 0,
					$breakingPoint2 = 0;
					if( isOverflow ) {
						marginLeftOffset = (overflowWrapper.parent().width()) - ( body.outerWidth()/2 );
					}
					asyncloader.require( 'imagesloaded' , function(){
						jQuery( '.content-single-sidebar' ).imagesLoaded( function() {
							$sidebarSelector.closest( '#content-wrap' ).css( 'min-height', $sidebarSelector.outerHeight() );
						} );
					});
					
		            // Sticky Default Header
		            if (( body.hasClass('sticky-header') || body.hasClass('transparent-sticky') )){ // && !isOverflow ) {
		                $headerTopPadding = $headerHeight;
		            } 

		            // Non Sticky Header 
		            if(  body.hasClass('header-transparent') ){ //Transparent 
		                if($heroSectionHeight > 0){ //With Hero Section
		                    $breakingPoint1 = $heroSectionHeight;
		                }else{ //Without Hero Section
		                    $breakingPoint1 = 1;
		                }
		            }else{ //Non Transparent
		                if($heroSectionHeight > 0){ //With Hero Section
		                    $breakingPoint1 = $heroSectionHeight + $headerHeight;
		                }else{ //Without Hero Section
		                    $breakingPoint1 = $headerHeight;
		                }
					}
					
					if( jQuery( '#header-top-bar-wrap' ).length ){
						$breakingPoint1 = $breakingPoint1 + jQuery( '#header-top-bar-wrap' ).outerHeight();
					}

					if ( jQuery("#portfolio-title-nav-wrap").length > 0 ) {
                        $breakingPoint1 = $breakingPoint1 + jQuery('#portfolio-title-nav-wrap').outerHeight();
					} 					
					
					$breakingPoint2 = (jQuery(document).height()) - ($scroll_top +  jQuery(window).height() + $footerHeight + $widgetsHeight + $portfolioNavigationHeight);
					
					var contentPosition = jQuery('#content').index();
					jQuery( '#content' ).siblings().each(function(i,e){
						if( $(e).hasClass( 'tatsu-section' ) ){
							if( i < contentPosition ) {
								$breakingPoint1 = $breakingPoint1 + $(e).outerHeight();
							} else {
								$breakingPoint2 = $breakingPoint2 - $(e).outerHeight();
							}
						}
					});
					if ($window.width() > 940 ) {
						if( isOverflow ) {
							if( overflowWrapper.closest( '.be-content-overflow' ).hasClass( 'left-overflow-page' ) ) {
								overflowWrapper.css( { marginLeft: ( 0 > marginLeftOffset ) ? ( marginLeftOffset + 'px' ) : '0px', opacity : '1'} );
							}else{
								overflowWrapper.css( { marginRight : ( 0 > marginLeftOffset ) ? ( marginLeftOffset + 'px' ) : '0px', opacity : '1'} );
							}
						}
		                if ($scroll_top < $breakingPoint1) {
							$sidebarSelector.removeClass('active-fixed').css('top', 0);
							if( !isOverflow ) {
							   $sidebarSelector.width($sidebarSelector.parent().outerWidth() * $sidebar_width);
							}else{
								$sidebarSelector.css( 'left', '' );
								$sidebarSelector.width($sidebarSelector.closest( '#content-wrap' ).outerWidth() * $sidebar_width);
							}
		                } 
		                else if($breakingPoint2 <= 0){
							var $negative;
							if( ( body.hasClass('sticky-header') || body.hasClass('transparent-sticky') ) ){
								$negative = $breakingPoint2 + $headerHeight;
							} else {
								$negative = $breakingPoint2;
							}
							$sidebarSelector.addClass('active-fixed').removeClass('top-animate').css('top', $negative);
							if( !isOverflow ) {
								$sidebarSelector.width($sidebarSelector.parent().outerWidth() * $sidebar_width);
							}else{
								$sidebarSelector.css( 'left', $sidebarSelector.parent().offset().left );
								$sidebarSelector.width($sidebarSelector.closest( '#content-wrap' ).outerWidth() * $sidebar_width);
							}

		                }
		                else if(($scroll_top >= $breakingPoint1) && ($breakingPoint2 > 0)){
							$sidebarSelector.css( 'top', '0' );
							$sidebarSelector.addClass('active-fixed  top-animate');
							if( 0 != $headerTopPadding ) {
								if( $scroll_top > window.innerHeight ) {
									$sidebarSelector.css({
										top : $headerTopPadding
									});
								}else{
									$sidebarSelector.css({
										top : 0
									});
								}
							}
							if( !isOverflow ) {
								$sidebarSelector.width($sidebarSelector.parent().outerWidth() * $sidebar_width);
							}else{
								$sidebarSelector.css( 'left', $sidebarSelector.parent().offset().left );
								$sidebarSelector.width($sidebarSelector.closest( '#content-wrap' ).outerWidth() * $sidebar_width);
							}
		                }		                
		            }else{
						if( isOverflow ) {
							if( '0px' != overflowWrapper.css( 'margin-left' ) ) {
								overflowWrapper.css( 'margin-left', '0' );
							}
							if( '0' == overflowWrapper.css( 'opacity' ) ) {
								overflowWrapper.css( 'opacity', '1' );
							}
						}
					}
		        }
		    },

		    split_screen = function() {
		        if ( ( jQuery(".page-template-page-splitscreen-left").length > 0 ) || ( jQuery(".page-template-page-splitscreen-right").length > 0 ) ) {
		            var $heroSection = jQuery("#hero-section"),
		            $window = jQuery(window),
		            $scroll_top = $window.scrollTop(),
		            $footerHeight = Number_or_zero(jQuery('#footer').outerHeight()),
		            $widgetsHeight = Number_or_zero(jQuery('#bottom-widgets').outerHeight()),
		            $headerHeight = Number_or_zero(jQuery('#header-inner-wrap').height()),
		            $headerTopPadding = 0,
		            $headerTopPaddingonScroll = 0,
		            $breakingPoint1 = 0,
		            $breakingPoint2 = 0;

		            // Non Sticky Header 
		            if(  body.hasClass('header-transparent') ){ //Transparent 
		                $breakingPoint1 = 1;
		                $headerTopPadding = 0;
		            }else{ //Non Transparent
		                $breakingPoint1 = $headerHeight;
		                $headerTopPadding = $headerHeight;
		            }

		            $breakingPoint2 = (jQuery(document).height()) - ($scroll_top +  $window.height() + $footerHeight + $widgetsHeight);
					//console.log("$breakingPoint2",$breakingPoint2);
		            if ($window.width() > 960) {
		                $heroSection.css('top', $headerTopPadding);
		                if ($scroll_top < $breakingPoint1) {
		                    $heroSection.css('top', $headerTopPadding - ($scroll_top));
		                } 
		                else if($breakingPoint2 <= 0){
		                    $heroSection.css('top', $breakingPoint2);
		                }
		                else if(($scroll_top >= $breakingPoint1) && ($breakingPoint2 > 0)){
		                    $heroSection.css('top', 0 );
		                }
		            }
		        }
		    },

		    superfish = function() {
		    	asyncloader.require( [ 'superfish', 'hoverintent' ], function(){
			        var $menu = jQuery('#navigation .menu, #navigation-left-side .menu, #navigation-right-side .menu').children('ul');
			        $menu.superfish({
			            animation: {opacity: 'show'},
			            animationOut: {opacity: 'hide'},
			            speed : 400,
			            delay: 600
			        });
			    });		    	
		    },

			sliders = function() {
		    	var gallery_wrap = jQuery('#gallery-container-wrap');
		        if ( gallery_wrap.length > 0 ) {	
					var deps = [ 'horizontalcarousel', 'fitvids', 'resizetoparent', 'mousewheel' ];
					if( jQuery('be-vimeo-embed').length ){
						deps.push('vimeo');
					}
		        	asyncloader.require( deps, function(){
			            gallery_wrap.fitVids();
			            gallery_wrap.CenteredSlider();
			            //gallery_wrap.thumbnailSlider();
			            resize_gallery_video();
			            jQuery('.be-carousel-thumb').thumbnailSlider();
			        });
		        }		    	
		    },

			carousel_thumb = function() {
		        jQuery(document).on('mouseenter', '.carousel_bar_dots', function () {
		            jQuery(this).parent().find('.carousel_bar_wrap').css('opacity', '0').stop().animate({ opacity: 1, bottom: '0px' }, 500);
		        });
		        jQuery(document).on('mouseleave', '.carousel_bar_area', function () {
		            jQuery(this).find('.carousel_bar_wrap').stop().animate({ opacity: 0, bottom: '-500px' }, 500);
		        });				
			},

			carouselIOSFix = function() {
				var touchingCarousel = false,
					touchStartCoords;
			
				document.body.addEventListener('touchstart', function(e) {
					if (e.target.closest('.flickity-slider')) {
					touchingCarousel = true;
					} else {
					touchingCarousel = false;
					return;
					}
			
					touchStartCoords = {
					x: e.touches[0].pageX,
					y: e.touches[0].pageY
					}
	
				});
			
				document.body.addEventListener('touchmove', function(e) {
					if (!(touchingCarousel && e.cancelable)) {
					return;
					}
			
					var moveVector = {
					x: e.touches[0].pageX - touchStartCoords.x,
					y: e.touches[0].pageY - touchStartCoords.y
					};
			
					if (Math.abs(moveVector.x) > 7)
					e.preventDefault()
			
				}, {passive: false});
			},

		    rev_slider_bg_check = function() {
	
		        if ( !body.hasClass('disable_rev_slider_bg_check') && !body.hasClass('semi') ) {

					var rev_slider_wrapper = jQuery('#hero-section').find('.rev_slider_wrapper');
					if( 0 === jQuery('#hero-section').length ) {
						rev_slider_wrapper = jQuery( '.tatsu-section:first-child' ).find('.rev_slider_wrapper');
					}
		            if ( body.hasClass('header-transparent') && rev_slider_wrapper.length > 0 ) {
		            	asyncloader.require( 'backgroundcheck', function() {
			                rev_slider_wrapper.each(function () {
			                    var $wrapper = jQuery(this).attr('id'), 
			                    $instance = jQuery(this).find('.rev_slider').attr('id'), 
			                    be_revapi = $instance.split('_');
			                    window['revapi'+be_revapi[2]].bind("revolution.slide.onchange", function (e, data) {
			                        setTimeout(function () {
			                            BackgroundCheck.init({
			                                targets: '#header #header-inner-wrap',
			                                images: '.active-revslide .tp-bgimg'
			                            });
			                            BackgroundCheck.refresh();
			                        }, 100);
			                    });
			                });
			            });
		            }
		        }
		    },

		    header_search = function() {
		        jQuery(document).on('click', '.header-search-controls .search-button', function () {
		        	var search_box = jQuery('.search-box-wrapper');
		            search_box.fadeToggle().find('.s').focus();
		            if ( search_box.hasClass('style2-header-search-widget') ) {
						if( !( ( jQuery( 'body' ).hasClass( 'overlay-center-align-menu' ) || jQuery( 'body' ).hasClass( 'overlay-left-align-menu' ) || jQuery( 'body' ).hasClass( 'overlay-horizontal-menu' ) ) && jQuery( '.be-sidemenu' ).hasClass( 'opened' ) ) ){
							// Incase the user has opened the overlaymenu and has clicked the search button, then don't toggle the 'hide-overflow', as the class is already added
		                	html = html.toggleClass('hide-overflow');
						}
		            }
		        });

		        jQuery(document).on('click', '.header-search-form-close', function (e) {
		            e.preventDefault();
		            close_search_box();
		        });		        		    	
		    },

		    mobile_menu = function() {   	
		        jQuery(document).on('click','#mobile-menu li a', function() {
		            if( jQuery(this).attr('href') != '#' && !jQuery(this).closest('li').hasClass('menu-item-has-children') ){
		                close_mobile_menu();   
		            }
		        });

		        jQuery(document).on('click', '.mobile-nav-controller-wrap', function () {
		            jQuery('.mobile-menu').slideFadeToggle();
		            jQuery('.mobile-nav-controller .be-mobile-menu-icon').toggleClass('is-clicked'); 
		        });

		        jQuery(document).on('click', '.mobile-sub-menu-controller', function () {
		            jQuery(this).siblings('.sub-menu').slideFadeToggle();
		            jQuery(this).toggleClass('isClicked');
		        });
		    },

		    falling_menu = function() {
		        jQuery(document).on('click', '.menu-falling-animate-controller', function () {
		            //var delay = 0, 
		            var $this = jQuery(this);  
					body.toggleClass('menu-animate-fall-active');
					jQuery('.menu-falling-animate-controller .be-mobile-menu-icon').toggleClass('is-clicked');
	                jQuery('#menu, #left-menu, #right-menu').children('.menu-item').each(function(i, el) {
							var delay =  i * 50;
							jQuery(this).css('transition-delay', delay+'ms');		
	                });
		        });		    	
			},

			top_page_stack = function() {
				if( jQuery( 'body' ).hasClass( 'page-stack-top' ) ){
					//Check if the class is there in body
					asyncloader.require( ['modernizr', 'classie'], function(){
						var backToTop = jQuery( '#back-to-top' ).detach();
						backToTop.appendTo(jQuery( 'body' ));
						jQuery( '#header' ).insertBefore( jQuery( "#main-wrapper" ) );
						asyncloader.require( 'page_stack_top', function(){			
						});
					} );
				}	    	
			},

			perspective_navigation = function(){
				if( jQuery( 'body' ).hasClass( 'perspective-left' ) || jQuery( 'body' ).hasClass('perspective-right') ){
					//Check if the class is there in body
					asyncloader.require( ['modernizr', 'classie'], function(){
						asyncloader.require( 'perspective_navigation', function(){
							var backToTop = jQuery( '#back-to-top' ).detach();
							backToTop.appendTo(jQuery( 'body' ));
							jQuery( '#header' ).insertBefore( jQuery( "#main-wrapper" ) );				
						});
					} );
				}
			},

			multi_level_menu = function(){
				/*Convert normal menu to multilevel menu in case of
					Page stack right
					Page stack left
					Overlay center align
					Overlay left align
					special left menu
					special right menu
					perspective left
					perspective right
					left-static-menu
					left-strip-menu
				*/
				if( 'newMultilevelMenu' == jQuery( '.be-sidemenu' ).attr( 'data-submenu' ) ){
					asyncloader.require( ['modernizr', 'classie'], function(){
						var dataSubMenu = 1,
								menuUls = jQuery( '.special-header-menu > ul' );
						$( menuUls ).attr( 'data-menu', 'main' );
						menuUls = menuUls.find( 'ul' );
						Array.prototype.forEach.call( menuUls, function( menuUl ){
							jQuery( menuUl ).addClass( 'menu-container' );
							$( menuUl ).attr( 'data-menu', 'submenu-' + dataSubMenu );
							$($( menuUl ).siblings( 'a' )).attr( 'data-submenu', 'submenu-' + dataSubMenu++ );
							$( menuUl ).detach().appendTo( '.special-header-menu' );
						} );
						asyncloader.require( 'multi_level_menu', function(){			

							var menuEl = document.getElementsByClassName('special-header-menu')[0],
								mlmenu = new MLMenu(menuEl, {
									backCtrl : true, // show back button
									direction : jQuery( '.be-sidemenu' ).attr( 'data-link-animation-direction' )
								});
						});
					});
				} else if( 'oldMultilevelMenu' == jQuery( '.be-sidemenu' ).attr( 'data-submenu' ) ){
					asyncloader.require( ['modernizr', 'classie'], function(){
						asyncloader.require( 'old_menu_animation', function(){
							var menuEl = document.getElementsByClassName('special-header-menu')[0],
								mlmenu = new OldMenu(menuEl, {
									direction : jQuery( '.be-sidemenu' ).attr( 'data-link-animation-direction' )
								});
						})
					});
				}
			},

			sticky_sections = function() {
				if( body.hasClass( 'be-sticky-sections' ) && !jQuery( 'body' ).hasClass( 'tatsu-frame' ) ) {
					asyncloader.require( 'sticky_sections', function() {
						var stickyScrollType = jQuery( '.be-sections-wrap' ).attr( 'data-sticky-scroll' ),
							$win = jQuery(window),
							globalSections = jQuery('.tatsu-global-section'),
							sectionsContainer = jQuery('#content .tatsu-section').parent(),
							stickyContainer = '#main-wrapper',
							defaultHeaderHeight = jQuery( '#header'  ).outerHeight() + ( jQuery( '#wpadminbar' ).length ? jQuery( '#wpadminbar' ).height() : 0 );
						if( jQuery( '#tatsu-header-wrap'  ).outerHeight() > 0 ){
							stickyContainer = '#be-sticky-section-fixed-wrap'
							defaultHeaderHeight = jQuery( '#tatsu-header-wrap'  ).outerHeight() + ( jQuery( '#wpadminbar' ).length ? jQuery( '#wpadminbar' ).height() : 0 );
						}							
						var	transparentHeaderDynamicColorChange = function() {
								var curSection = jQuery( this ),
									headerInnerWrap = jQuery( '#header-inner-wrap' ),
									headerScheme,
									headerSchemeFromSection = curSection.attr( 'data-headerscheme' );
								if( body.hasClass( 'header-transparent' ) ) {
									headerScheme = headerInnerWrap.attr( 'data-headerscheme' );
									if( headerScheme != headerSchemeFromSection ) {
										headerInnerWrap.find( '#navigation' ).css( 'transition', 'none' );
										headerInnerWrap.removeClass( 'background--dark' == headerSchemeFromSection ? 'background--light' : 'background--dark' );
										headerInnerWrap.find( '#navigation' ).css( 'transition', 'color 700ms cubic-bezier(0.645, 0.045, 0.355, 1)' );
										headerInnerWrap.addClass( headerSchemeFromSection );
										headerInnerWrap.attr( 'data-headerscheme', headerSchemeFromSection );
									}
								}
							},
							triggerTatsuAnimation = function() {
								if( null != tatsu ) {
									tatsu.cssAnimate( false, '', jQuery(this) );
								}
							},
							stickySectionDotsDynamicColorChange = function() {
								var curSection = jQuery( this ),
									dotsNav = jQuery( '#sticky-dots-navigation' ),
									headerScheme,
									headerSchemeFromSection = curSection.attr( 'data-headerscheme' );
								if( 0 < dotsNav.length ) {
									headerScheme = dotsNav.attr( 'data-headerscheme' );
									if( headerScheme != headerSchemeFromSection ) {
										dotsNav.find( 'span' ).css( 'transition', 'none' );
										dotsNav.removeClass( 'background--dark' == headerSchemeFromSection ? 'background--light' : 'background--dark' );
										dotsNav.find( 'span' ).css( 'transition', 'background 700ms cubic-bezier(0.645, 0.045, 0.355, 1)' );
										dotsNav.addClass( headerSchemeFromSection );
										dotsNav.attr( 'data-headerscheme', headerSchemeFromSection );
									}
								}
							},
							triggerPortfolio = function() {
								var curSection = jQuery( this ),
									portfolio = curSection.find( '.portfolio' );
								if( 0 < portfolio.length && null != oshinePortfolio ) {
									if( portfolio.hasClass( 'portfolio-delay-load' ) ) {
										oshinePortfolio.portfolioScrollReveal( portfolio.find( '.element' ) );
									}
									if( portfolio.hasClass( 'portfolio-lazy-load' ) ) {
										oshinePortfolio.portfolioLazyReveal( portfolio.find( '.thumb-wrap' ).find( 'img' ) );
									}
								}
							},
							setCurrentActiveMenu = function() {
								var menuItems = jQuery( 'li.menu-item' ),
									curActiveSection = jQuery( this );
								if( curActiveSection.length && ( ( defaultHeaderHeight + $win.scrollTop() ) >= curActiveSection.offset().top ) ) {
									menuItems.removeClass( 'current-menu-item' );
									menuItems.find('a[href$="#'+ curActiveSection.attr( 'id' ) +'"]').closest('li.menu-item').addClass('current-menu-item current-section');
								}
							},
							initCallBack = function( activeSection ) {
								stickySectionDotsDynamicColorChange.call(activeSection);
								triggerPortfolio.call(activeSection);
								setCurrentActiveMenu.call(activeSection);
								triggerTatsuAnimation.call(activeSection);
								if( body.hasClass( 'be-themes-layout-layout-border-header-top' ) || body.hasClass( 'be-themes-layout-layout-border' ) ) {
									if( 0 < jQuery( '#sticky-dots-navigation' ).length ) {
										if( 0 < jQuery( '.layout-box-right' ).length ) {
											jQuery( '#sticky-dots-navigation' ).css( 'right', jQuery( '.layout-box-right' ).width() + 17 + 'px' );
										}
									}
								}
							},
							enableOverlay = jQuery( '.be-sections-wrap' ).attr( 'data-sticky-overlay' ),
							stickyOptions = {
								autoScroll : 'auto_scroll' == stickyScrollType ? true : false,
								fixedParent : stickyContainer,
								scrollCallback : function( secIndex ) {
									triggerTatsuAnimation.call(this);
									triggerPortfolio.call(this);
								},
								scrollingSpeed : 1200,
								overlay : 0 == enableOverlay ? false : true,
								fullScreenOffset : [ '#wpadminbar', '#header', '.layout-box-top', '.layout-box-bottom' ],
								dots : true,
								footer : [ '.tatsu-global-section-bottom', '#bottom-widgets', '#footer' ],
								navigationPosition : 'right',
								afterLoad : function() {
									triggerPortfolio.call(this);
									triggerTatsuAnimation.call(this);
									transparentHeaderDynamicColorChange.call(this, arguments);
									stickySectionDotsDynamicColorChange.call(this);
									setCurrentActiveMenu.call(this);
								}
							};
						if( 0 < globalSections.length && 0 < sectionsContainer.length ) {
							sectionsContainer.prepend( jQuery('.tatsu-global-section-top') ).append( jQuery('.tatsu-global-section-penultimate') );
						}
						if( 967 < jQuery( window ).width() ) {
							stickySections.initialize( '.be-sections-wrap', stickyOptions , initCallBack );
						}
						jQuery(window).on( 'resize', function() {
							if( 967 < jQuery(window).width() && !body.hasClass( 'sticky-enabled' ) ) {
								stickySections.initialize( '.be-sections-wrap', stickyOptions , initCallBack );
							}else if( 968 > jQuery(window).width() && body.hasClass( 'sticky-enabled' ) ) {
								stickySections.destroy();
							}
						} )
					} );
				}
			},

			sub_menu = function() {
		        jQuery(document).on('click', '.top-overlay-menu .menu-item-has-children a, .left-header .menu-item-has-children a , #mobile-menu .menu-item-has-children a', function () {
		            if(jQuery(this).attr('href') == '#'){
		                jQuery(this).siblings('.sub-menu').slideFadeToggle();
		                jQuery(this).siblings('.mobile-sub-menu-controller').toggleClass('isClicked');
		            }
		        });				
			},

			local_scroll = function() {
				asyncloader.require( 'easing', function() {
			        jQuery(document).on('click', 'a[href="#"]', function (e) {
			            e.preventDefault();
			        });
			        jQuery(document).on('click', 'a', function (e) {
			            var $link_to = jQuery(this).attr('href'), 
			            url_arr, 
			            $element,
			            mobile_menu = jQuery('.mobile-menu'),
			            $path = window.location.href;
			            if ( jQuery(this).hasClass('ui-tabs-anchor') || jQuery(this).closest('.wc-tabs').length > 0 ) {
			                return false;
						}
			            if ( $link_to && !( ( jQuery( 'body' ).hasClass( 'perspective-left' ) || jQuery( 'body' ).hasClass( 'perspective-right' ) || jQuery( 'body' ).hasClass( 'page-stack-top' ) ) && jQuery(window).width() >= 960  ) ) {
			                url_arr = $link_to.split('#');
			                if ($link_to.indexOf('#') >= 0 && $path.indexOf(url_arr[0]) >= 0) {
			                    $element = $link_to.substring($link_to.indexOf('#') + 1);
			                    if ($element) {
			                        if (jQuery('#' + $element).length > 0) {
										e.preventDefault();
										if( jQuery( body ).hasClass( 'be-sticky-sections' ) && 960 < window.innerWidth ) {
											var section = jQuery( '#' + $element ),
												secIndex = stickySections.getStickyIndex( section[0] );
											if( -1 < secIndex && secIndex < jQuery( '.sticky-section' ).length ) {
												if( body.scrollTop() === 0 ) {
													body.scrollTop(1);
												}
												stickySections.moveTo( secIndex );
											}
										}else if( jQuery( body ).hasClass( 'be-sticky-active' ) && 960 < window.innerWidth ) {

												var getElement = jQuery( '#' + $element );

												if(jQuery(getElement).length){
													var  getOffset = jQuery(getElement ).offset().top;
													var  top = jQuery('#header-inner-wrap').position().top;
													var  height = jQuery('#header-inner-wrap').height() + top;
													jQuery('html,body').animate({
														scrollTop: getOffset - height
													}, 500);
												}


										}else if (jQuery(window).width() < 960 && mobile_menu.length > 0 ) {
			                                mobile_menu.slideUp(500, function () {
			                                    animate_scroll(jQuery('#' + $element));
			                                });
			                            } else {
			                                animate_scroll(jQuery('#' + $element));
			                            }
			                        }
			                    }
			                }
			            }
			        });	
			    });			
			},

			sliderbar_navigation = function() {
		        jQuery(document).on('click', '.sliderbar-nav-controller-wrap', function () {
		            jQuery('.sb-slidebar').toggleClass('opened');
		            body = body.toggleClass('slider-bar-opened');

		            if( body.hasClass('top-overlay-menu') ) {
		               html = html.toggleClass('hide-overflow');
		                // jQuery('.layout-box-container').fadeOut();
		                if( body.hasClass('be-themes-layout-layout-border-header-top') ){
		                    jQuery('.sliderbar-menu-controller .be-mobile-menu-icon').toggleClass('is-clicked');
		                }
		            } else{
		                jQuery('.sliderbar-menu-controller .be-mobile-menu-icon').toggleClass('is-clicked');
		            }
		        });				
			},

			special_menu_view_handler = function() {		
				jQuery('.be-sidemenu').toggleClass('opened');
				body = body.toggleClass('side-menu-opened');
				
				if( jQuery('body').hasClass( 'overlay-center-align-menu' ) || jQuery('body').hasClass( 'overlay-left-align-menu' ) || jQuery('body').hasClass( 'overlay-horizontal-menu' ) ){
					if( jQuery( 'body' ).hasClass( 'side-menu-opened' ) ){
						jQuery( '#header' ).css( 'z-index', '16' );
						jQuery( '.be-sidemenu' ).css({ 'z-index' : '15', 'visibility' : 'visible' });
						jQuery('html').toggleClass('hide-overflow');
						var transEndEvent = function( ev ){
							ev.stopPropagation();
							if( ! (jQuery( 'body' ).hasClass( 'side-menu-opened' ) ) && jQuery(ev.target).hasClass('be-sidemenu') ){
								jQuery(this).unbind( 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', transEndEvent );
								jQuery( '.be-sidemenu' ).css({ 'z-index' : '-1', 'visibility' : 'hidden' });
								jQuery( '#header' ).css('z-index' , '10');
								if( jQuery( '.search-box-wrapper' ).css( 'display' ) == 'none' || jQuery( '.search-box-wrapper' ).length == 0 || jQuery('.search-box-wrapper').hasClass( 'style1-header-search-widget' ) ){
									// This condition for, in case after opening the overlay menu, user clicks the search button, then 'hide-overflow' shouldnt be removed
									jQuery( 'html' ).removeClass( 'hide-overflow' );
								}
							}
						};
						jQuery( '.be-sidemenu' ).bind('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', transEndEvent);
					}
					if( jQuery('#be-left-strip').length != 0 ){
						/* Resize the masterslider when menu is opend and closed */
						if( 'undefined' != typeof window.masterslider_instances && ( jQuery('body').hasClass( 'overlay-left-align-menu' ) || jQuery('body').hasClass( 'overlay-center-align-menu' ) ) ){							
							var masterSliderResizeHandler = function( ev ){
								jQuery(this).unbind( 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', masterSliderResizeHandler );
								window.masterslider_instances.forEach( function( item ){
									item._updateLayout();
								} );
							}
							jQuery( '.be-sidemenu' ).bind('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', masterSliderResizeHandler );	
						}
					}
				} else {
					jQuery('html').toggleClass('hide-overflow');	
				}
			},

			sidemenu_navigation = function(){
				if( !( jQuery( 'body' ).hasClass( 'perspective-left' ) || jQuery( 'body' ).hasClass( 'perspective-right' ) || jQuery( 'body' ).hasClass( 'page-stack-top' ) || jQuery( 'body' ).hasClass( 'menu-animate-fall' ) ) ){
					//Attach click events for the hamburger menu except for page stack top case. For page stack top, the event is attached in page_stack_top.js
					jQuery(document).on('click', '.hamburger-nav-controller-wrap', function (ev) {
						ev.stopPropagation();
						special_menu_view_handler();
						jQuery( '.hamburger-nav-controller .be-mobile-menu-icon' ).toggleClass( 'is-clicked' );
					})
				}
			},

			left_strip = function() {
		        jQuery(document).on('click', '#sb-left-strip', function () {
		            var $this = jQuery(this);
		            jQuery('.sb-slidebar').toggleClass('opened');   
		            if( $this.hasClass('menu_push_main') ){
		                body = jQuery('body').toggleClass('slider-bar-opened');  
		            }
		            if($this.hasClass('overlay')) {
		                html = html.toggleClass('hide-overflow');
		                jQuery('.layout-box-container').fadeOut();     
		            }
		            if( $this.hasClass('strip') ) {
		                jQuery('.left-strip-wrapper').toggleClass('hide');    
		                jQuery('#main-wrapper').toggleClass('hidden-strip'); 
		            }
		        });				
			},

			be_left_strip = function() {
				if( !( jQuery( 'body' ).hasClass( 'perspective-right' ) ) ) {
					jQuery(document).on( 'click', '#be-left-strip', function( ev ){
						special_menu_view_handler();
						jQuery( '#be-left-strip .be-mobile-menu-icon' ).toggleClass( 'is-clicked' );
					});
				}
			},

			left_header_close_overlay = function(){
				if( jQuery( 'body' ).hasClass( 'left-header' ) && ( jQuery( 'body' ).hasClass( 'overlay-center-align-menu' ) || jQuery( 'body' ).hasClass( 'overlay-left-align-menu' ) ) ){
					jQuery( document ).on( 'click', '.be-overlay-menu-close', function( ev ){
						ev.stopPropagation();
						// Don't call special_menu_view_handler() function here to do the closing of overlay menu. Its causing a bug on double click of close button as the code does toggling of classes
						jQuery('.be-sidemenu').removeClass('opened');
						body = body.removeClass('side-menu-opened');
						jQuery( '#be-left-strip .be-mobile-menu-icon' ).removeClass( 'is-clicked' );
						if( 'undefined' != typeof window.masterslider_instances ){							
							var masterSliderResizeHandler = function( ev ){
								jQuery(this).unbind( 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', masterSliderResizeHandler );
								window.masterslider_instances.forEach( function( item ){
									item._updateLayout();
								} );
							}
							jQuery( '.be-sidemenu' ).bind('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', masterSliderResizeHandler );	
						}
					} )
				}
			},

	    	close_sidebar = function() {		        
		        if( body.hasClass('top-overlay-menu') || body.hasClass('left-overlay-menu') ){
		            if( body.hasClass('be-themes-layout-layout-border-header-top')){
		                close_slidebar_menu();
		            }
		            jQuery('.layout-box-container').fadeIn();  
		            jQuery('#slidebar-menu li').removeClass('menu-loaded');
		        } else {
		            close_slidebar_menu();
		        }
		        jQuery('.sb-slidebar').removeClass('opened');

		        body = body.removeClass( 'slider-bar-opened' );  
	    	},

			close_sidemenu = function(){
				if( !jQuery( 'body' ).hasClass( 'page-stack-top' ) ){
					//Add the close sidemenu event on cliking of #main except for page stack top. For Page Stack top, the event is attached in page_stack_top.js
					jQuery(document).on('click', '#main', function () {
						setTimeout( function(){
							if( jQuery('body').hasClass( 'side-menu-opened' ) ){
								special_menu_view_handler();
								jQuery( '.hamburger-nav-controller .be-mobile-menu-icon' ).toggleClass( 'is-clicked' );
								jQuery( '#be-left-strip .be-mobile-menu-icon' ).toggleClass( 'is-clicked' );
							}
						}, 0 );
					})

					jQuery( document ).on( 'keyup', function( ev ) {
						if( jQuery('body').hasClass( 'side-menu-opened' ) ){
							var keyCode = ev.keyCode || ev.which;
							if( keyCode === 27 ) {
								setTimeout( function(){
									special_menu_view_handler();
									jQuery( '.hamburger-nav-controller .be-mobile-menu-icon' ).toggleClass( 'is-clicked' );
									jQuery( '#be-left-strip .be-mobile-menu-icon' ).toggleClass( 'is-clicked' );
								}, 0);
							}
						}
					} );

					var path = window.location.href;
					jQuery( '.special-header-menu .menu-item a' ).each( function( index, item ){
						var href = item.getAttribute( 'href' ),
							urlArr = href.split('#');

						if( href == "#" ){
							return false;	
						}
						if( href.indexOf( '#' ) >= 0 && path.indexOf(urlArr[0]) >= 0 )
						{
							var pageid = href.split('#')[1];
							item.addEventListener('click', function(ev) {
								// ev.preventDefault();
								if( jQuery('body').hasClass( 'side-menu-opened' ) ){
									setTimeout( function(){
										special_menu_view_handler();
										jQuery( '.hamburger-nav-controller .be-mobile-menu-icon' ).toggleClass( 'is-clicked' );
										jQuery( '#be-left-strip .be-mobile-menu-icon' ).toggleClass( 'is-clicked' );
									}, 0);
								}
							} );
						}
					});
				}
			},

	    	close_slidebar_menu = function() {
		        var be_sidebar_mobile_menu = jQuery('.sliderbar-menu-controller').find('.be-mobile-menu-icon');
		        if( body.hasClass( 'slider-bar-opened') && body.hasClass('top-header' ) ){
		            be_sidebar_mobile_menu.toggleClass('is-clicked');
		        }	    		
	    	},

	    	close_mobile_menu = function() {
	    		var mobile_menu = jQuery('.mobile-menu');
		        if ( mobile_menu.is(":visible") ) {
		            mobile_menu.slideFadeToggle();
		            jQuery('.mobile-nav-controller .be-mobile-menu-icon').toggleClass('is-clicked');
		        }
	    	},

	    	close_search_box = function() {
	    		var search_box = jQuery('.search-box-wrapper');
		        if ( search_box.is(":visible") ) {
		            search_box.fadeOut();
					if( search_box.hasClass('style2-header-search-widget') ){
		            	html = html.toggleClass('hide-overflow');
					}
		        }
	    	},			

			close_overlay_menu = function() {
		        jQuery(document).on('click', '.overlay-menu-close', function () {
		            close_sidebar();
		            open_leftstrip();
		        });				
			},

			close_gallery_info_box = function() {
		        jQuery(document).on('click', '.single_portfolio_info_close', function () {
		            jQuery(this).closest('.gallery_content').toggleClass('show');
		            //jQuery(".gallery_content_area").mCustomScrollbar("update");
		        });				
            },
            portfolioTemplateZoro = function() {
                var pauseYTJson = JSON.stringify({
                        'event': 'command',
                        'func': 'pauseVideo'
                    }),
                    playYTJson = JSON.stringify({
                        'event': 'command',
                        'func': 'playVideo'
                    }),
                    curActiveIndex = -1,
                    lockWheel = false,
                    container,
                    slides,
                    nav,
                    pauseVideoSlide = function(slide) {
                        if( slide && slide.hasClass('ps-fade-slide-video') ) {
                            if( slide.hasClass('ps-fade-slide-video-youtube') ) {
                                if(slide.find('iframe').length) {
                                    slide.find('iframe')[0].contentWindow.postMessage(pauseYTJson, '*');
                                }
                            }else if( slide.hasClass('ps-fade-slide-video-vimeo') ) {
                                var player = slide.data('player');
                                if( player ) {
                                    player.pause();
                                }
                            }else{
                                if( slide.find('video').length ) {
                                    slide.find('video')[0].pause();
                                }
                            }
                        }
                    },
                    playVideoSlide = function(slide, triggerGDPRPopup) {
                        if( slide.hasClass('ps-fade-slide-video') ) {
                            if( slide.hasClass('ps-fade-slide-video-youtube') ) {
                                if( slide.find('iframe').length ) {
                                    slide.find('iframe')[0].contentWindow.postMessage(playYTJson, '*');
                                }else if( triggerGDPRPopup && slide.find('.be-gdpr-consent-message').length ) {
                                    slide.find('.privacy-settings').trigger('click');
                                }
                            }else if( slide.hasClass('ps-fade-slide-video-vimeo') ) {
                                var player = slide.data('player');
                                if( player ) {
                                    player.play();
                                }else if( triggerGDPRPopup && slide.find('.be-gdpr-consent-message').length ) {
                                    slide.find('.privacy-settings').trigger('click');
                                }
                            }else{
                                if( slide.find('video').length ) {
                                    slide.find('video')[0].play();
                                }
                            }
                        }
                    },
                    setActive = function(index, triggerGDPRPopup, handleColorChange) {
                        if(index === curActiveIndex ) {
                            return;
                        }
                        var target = nav.eq(index),
                            targetParent = target.parent(),
                            prevIndex = curActiveIndex,
                            prevSlide = slides.eq(prevIndex),
                            prevTarget = nav.eq(prevIndex),
                            curSlide = slides.eq(index);
                        pauseVideoSlide(prevSlide);
                        nav.removeClass('is-active');
                        prevTarget.css('color', '');
                        slides.removeClass('is-active');
                        target.addClass('is-active');
                        curSlide.addClass('is-active');
                        playVideoSlide(curSlide, triggerGDPRPopup);
                        if( handleColorChange ) {
                            if( targetParent.attr('data-color') ) {
                                target.css('color', targetParent.attr('data-color'));
                            }
                            if( targetParent.attr('data-bg-color') ) {
                                container.css('background', targetParent.attr('data-bg-color'));
                            }else {
                                container.css('background', '');
                            }
                        }
                        curActiveIndex = index;
                    },
                    createVimeoPlayerInstances = function() {
                        $doc.on( 'be_video_loaded', function( event, iframeEle ) {
                            if(iframeEle.closest('.be-vimeo-embed').length) {
                                asyncloader.require('vimeonew', function() {
                                    var player = new Vimeo.Player(iframeEle[0]);
                                    iframeEle.closest('.ps-fade-slide-video').data('player', player);
                                });
                            }                                                             
                        });
                    },
                    lazyLoadSlideImages = function() {
                        var slideImages = $( '.ps-fade-slide-img' );
                        if( slideImages.length ) {
                            slideImages.each(function() {                                
                                var curImg = $(this);
                                if( null != curImg.attr( 'data-src' ) ) {
                                    curImg.on( 'load', function() {
                                        curImg.addClass('ps-fade-slide-img-lazyloaded');
                                    });
                                    curImg.attr( 'src', curImg.attr( 'data-src' ) );
                                    if( this.complete) {
                                        curImg.trigger( 'load' );
                                    }
                                }
                            });
                        }
                    };
                if($('.ps-fade').length) {
                    container = $('.ps-fade');
                    slides = container.find('.ps-fade-slide'),
                    nav = container.find('.ps-fade-nav-item-inner');
                    var reloadCellsOnVideoLoad = function() {
                            $doc.on( 'be_video_loaded', function( event, iframeEle ) {
                                if($win.width() < 768) {
                                    $('.ps-fade-gallery-inner').flickity('reloadCells');
                                }
                            });
                        },
                        mouseEnterHandler = function() {
                            setActive($(this).parent().index(), false, true);
                        },
                        addAnimationDelay = function() {
                            nav.each(function(index){
                                $(this).parent().css('transition-delay', (index * 100) + 'ms');
                            });
                        },
                        setGalleryHeight = function() {
                            var offsetHeight = 0;
                            if( $('.ps-fade-nav').outerHeight() < $('.ps-fade-gallery-inner').outerHeight() ) {
                                offsetHeight += $('#header').outerHeight();
							}
							if( jQuery('#tatsu-header-container').length > 0 ){
								offsetHeight += jQuery('#tatsu-header-container').height();
							}
							if( jQuery('#tatsu-footer-container').length > 0 ){
								offsetHeight += jQuery('#tatsu-footer-container').height();
							}
                            if(body.hasClass('admin-bar')) {
                                offsetHeight += 32;
                            }
                            $('.ps-fade-gallery-inner').css('height', ($win.height() - offsetHeight));
                        },
                        checkIfStickykitNeeded = function() {
                            var scrollContainer = $('.ps-fade-nav'),
                                galleryContainer = $('.ps-fade-gallery-inner'),
                                offsetTop = 0;
                            if( body.hasClass('admin-bar') ) {
                                offsetTop += $('#wpadminbar').height();
                            }
                            if( scrollContainer.outerHeight() > galleryContainer.outerHeight() ) {
                                asyncloader.require('stickykit', function(){
                                    galleryContainer.stick_in_parent({
                                        parent : galleryContainer.closest( '.ps-fade-inner' ),
                                        offset_top : offsetTop
                                    });
                                });
                            }
                        },
                        removeZoroDesktop = function() {
                            $('.ps-fade-gallery-inner').css('height', '');
                            nav.off( 'mouseenter', mouseEnterHandler );
                            $('.ps-fade-nav').addClass('ps-fade-nav-vert-center');
                            $('.ps-fade-gallery-inner').trigger("sticky_kit:detach");                           
                        },
                        initZoroMobile = function() {
                            container.addClass('ps-fade-mobile');
                            asyncloader.require('flickity', function() {
                                $('.ps-fade-gallery-inner').on( 'change.flickity', function(event, index) {
                                    $('.ps-fade-nav-inner').flickity('select', index);
                                    setActive(index, false, true);
                                });
                                $('.ps-fade-gallery-inner').on( 'ready.flickity', function() {
                                    setActive(0, false, true);
                                    container.addClass('ps-fade-initialized');
                                } );
                                $('.ps-fade-nav-inner').on( 'change.flickity', function(event, index) {
                                    $('.ps-fade-gallery-inner').flickity('select', index);
                                    setActive(index, false, true);
                                });
                                $('.ps-fade-gallery-inner').flickity({pageDots : false, adaptiveHeight : true, prevNextButtons: false});
                                $('.ps-fade-nav-inner').flickity({adaptiveHeight : true, prevNextButtons: false});
                            });
                        },
                        removeZoroMobile = function() {
                            container.removeClass('ps-fade-mobile');
                            $('.ps-fade-gallery-inner').flickity('destroy');
                            $('.ps-fade-nav-inner').flickity('destroy');
                        },
                        addResizeEvent = function() {
                            $win.on('resize', function() {
                                if( $win.width() < 1025 ) {
                                    if( !container.hasClass('ps-fade-mobile') ) {  
                                    removeZoroDesktop();
                                    initZoroMobile();
                                    }
                                }else {
                                    if( container.hasClass('ps-fade-mobile') ) {
                                    removeZoroMobile();
                                    initZoro();
                                    }
                                }
                            });
                        },
                        checkIfVertAlignNav = function() {
                            if( $('.ps-fade-nav').outerHeight() < $('.ps-fade-gallery-inner').outerHeight() ) {
                                $('.ps-fade-nav').addClass('ps-fade-nav-vert-center');
                            }
                        },
                        initZoro = function() {
                            setGalleryHeight();
                            checkIfStickykitNeeded();
                            checkIfVertAlignNav();
                            nav.on( 'mouseenter', mouseEnterHandler );
                            nav.eq(0).trigger('mouseenter');
                            container.addClass('ps-fade-initialized');
                        };
                    createVimeoPlayerInstances();
                    reloadCellsOnVideoLoad();
                    addResizeEvent();
                    lazyLoadSlideImages();
                    if( $(window).width() > 1024 ) {
                        addAnimationDelay();
                        initZoro();
                    }else {
                        initZoroMobile();
                    }
                }

                if($('.ps-fade-horizontal').length) {
                    container = $('.ps-fade-horizontal');
                    nav = container.find('.ps-fade-horizontal-nav-item-inner');
                    slides = container.find('.ps-fade-slide');
                    var navSlider = $('.ps-fade-horizontal-nav'),
                        mouseWheelNav = null != container.attr('data-mousewheel-nav'),
                        navParent = nav.parent(),
                        setGalleryHeight = function() {
                            var offsetHeight = 0;
                            if( body.hasClass('admin-bar') ) {
                                offsetHeight += 32;
                            }
                            offsetHeight += Number_or_zero($('#header').height());
                            offsetHeight += Number_or_zero($('#bottom-widgets').height());
							offsetHeight += Number_or_zero($('#footer').height());
							//console.log("offsetHeight",offsetHeight);
                            navParent.css('height', $win.height() - offsetHeight);
                        },
                        addAnimationDelay = function() {
                            nav.each(function(index){
                                $(this).css('transition-delay', ((index + 1) * 100) + 'ms');
                                setTimeout(function() {
                                    $(this).css('transition-delay', ''); //reset so color transition and other transitions don't get affected by this delay
                                }.bind(this), ((index + 1) * 100));
                            });
                        },
                        initNavSliderAndSlides = function() {
                            asyncloader.require('flickity', function() {
                                var initialIndex = null != container.attr( 'data-start-from-center' ) ? Math.floor(slides.length/2) : 0;
                                navSlider.on('ready.flickity', function() {
                                    if( lockWheel ) {
                                        lockWheel = false;
                                    }
                                    setActive(initialIndex, true);
                                    container.addClass('ps-fade-horizontal-initialized');
                                });
                                navSlider.on( 'change.flickity', function(event, index) {
                                    lockWheel = true;
                                    setActive(index, true);
                                });
                                navSlider.on('settle.flickity', function() {
                                    lockWheel = false;
                                });
                                navSlider.flickity({
                                    prevNextButtons : false,
                                    pageDots : false,
                                    initialIndex : initialIndex
                                });
                            });
                        },
                        mouseEnterHandler = function() {
                            if(!lockWheel) {
                                setActive($(this).parent().index(), true);
                            }
                        },
                        scrollHandler = function(event) {
                            if( !lockWheel ) {
                                if( event.originalEvent.wheelDelta > 0 || event.originalEvent.detail < 0 ) {
                                    navSlider.flickity('previous', true);                          
                                }else { 
                                    navSlider.flickity('next', true);
                                }
                            }
                        },
                        initTemplate = function() {
                            setGalleryHeight();
                            addAnimationDelay();
                            if( 1024 < $win.width() ) {
                                //nav.on('mouseenter', mouseEnterHandler);
                                if( mouseWheelNav ) {
                                    $win.on('mousewheel DOMMouseScroll', scrollHandler);    
                                }
                            }else {
                                container.addClass('ps-fade-horizontal-mobile');
                            }
                            initNavSliderAndSlides();
                        },
                        addResizeEvent = function() {
                            $win.on('resize', function() {
                                if( 1024 < $win.width() && container.hasClass('ps-fade-horizontal-mobile') ) {
                                    setGalleryHeight();
                                    //nav.on('mouseenter', mouseEnterHandler);
                                    if( mouseWheelNav ) {
                                        $win.on('mousewheel DOMMouseScroll', scrollHandler);
                                    }
                                    container.removeClass('ps-fade-horizontal-mobile');
                                }else if( 1025 > $win.width() && !container.hasClass('ps-fade-horizontal-mobile') ) {
                                    setGalleryHeight();
                                    //nav.off('mouseenter', mouseEnterHandler);
                                    if( mouseWheelNav ) {
                                        $win.off('mousewheel DOMMouseScroll', scrollHandler);                                      
                                    }
                                    container.addClass('ps-fade-horizontal-mobile');  
                                }
                            });
                        };
                    addResizeEvent();
                    createVimeoPlayerInstances();
                    lazyLoadSlideImages();
                    initTemplate();
                }
            },
			close_popups = function() {
		        jQuery(document).on('mouseup', '.sliderbar-menu-controller, .sb-slidebar, .mobile-nav-controller, .mobile-menu, .header-search-controls .search-button, .search-box-wrapper', function () {
		            if (jQuery(this).hasClass('sliderbar-menu-controller') || jQuery(this).hasClass('sb-slidebar')) {
		                close_mobile_menu();
		                close_search_box();
		            }
		            if (jQuery(this).hasClass('mobile-nav-controller') || jQuery(this).hasClass('mobile-menu')) {
		                close_sidebar();
		                close_search_box();
		            }
		            if (jQuery(this).hasClass('search-button') || jQuery(this).hasClass('search-box-wrapper')) {
		                close_mobile_menu();
		                close_sidebar();
		            }
		            return false;
		        });	

		        jQuery(document).on('mouseup', function () {
		            close_sidebar();
		            open_leftstrip();
		            close_mobile_menu();
		            close_search_box();
		        });

		        jQuery(document).on('keyup', function (e) {
		            if (e.keyCode === 27) {
		                close_sidebar();
		                open_leftstrip();
		                close_search_box();
		                if (jQuery('.gallery_content').hasClass('show')) {
		                    jQuery('.gallery_content').removeClass('show');
		                } else {
		                    if (jQuery('.gallery-slider-wrap').hasClass('opened')) {
		                        jQuery('html').removeClass('overflow-hidden');
		                        jQuery('.gallery-slider-wrap').css('left', '100%').css('opacity', 0);
		                        setTimeout(function () {
		                            jQuery('.gallery-slider-wrap').removeClass('opened');
		                            jQuery('.gallery-slider-content').empty();
		                            jQuery('.gallery-slider-wrap').css('left', '-100%');
		                        }, 300);
		                    }
		                }
		            }
		        });
			},

			back_to_top = function() {
		        jQuery(document).on('click', '#back-to-top, .back-to-top', function (e) {
		            e.preventDefault();
		            jQuery('body,html').animate({ scrollTop: 0 }, 1000, 'easeInOutQuint');
		        });				
			},

			show_back_to_top_button = function() {
		        if ( jQuery(window).scrollTop() > 10 ) {
		            to_top_button.fadeIn();
		        } else {
		            to_top_button.fadeOut();
		        }
			},

		    flickity_default_header = function(){   
		        if(jQuery('.portfolio-sliders').length){
		            if(jQuery('body.header-transparent').length){
		                if(Number_or_zero(jQuery(window).width()) <= 960){
		                    jQuery('#header-inner-wrap').css('position','relative');
		                }
		                else{
		                    jQuery('#header-inner-wrap').css('position','absolute');
		                }
		            }
		        }
			},  
			
			Number_or_zero = function(num){
				num = Number(num);
				if(isNaN(num)){
					num = 0;
				}
				return num;
			},

		    flickity_getHeight = function(){
		        if(jQuery('#content.portfolio-sliders').length){
		            var $this = jQuery('#content.portfolio-sliders'),
		                $gutter_width = Number_or_zero($this.attr('data-gutter-width')),
		                $slider_type = $this.attr('data-slider-type'),
		                $window_width = Number_or_zero(jQuery(window).width()) + jQuery.getScrollbarWidth(), //Number_or_zero(jQuery('#main-wrapper').width()) + jQuery.getScrollbarWidth()
		                $mobile_calculation = true,
		                $full_window_height = Number_or_zero(jQuery(window).height()),
		                $window_height = $full_window_height-(Number_or_zero(jQuery('#header').innerHeight())+Number_or_zero(jQuery('#wpadminbar').innerHeight())+Number_or_zero(jQuery('#portfolio-title-nav-wrap').innerHeight()));


		            if($this.find('.disable-flickity-mobile').length){
		                $mobile_calculation = false;
		            }
		            if(jQuery('body').hasClass('be-themes-layout-layout-border-header-top')) {
		                var $border_length = 1;  
		            }else{
		                var $border_length = 2;
		            }
		            //Calculate Height and Width of Image Wrappers
		            //CONDITION 1 - If Flickity is Disabled for Mobile Devices 
		            if($mobile_calculation == false && $window_width <= 960){  
		                //Remove Scrollbar in Mobile View
		                var $scrollable_content =  $this.find('.gallery_content_slide');
		                $scrollable_content.height('auto');
		               // if( 'undefined' !== typeof mCustomScrollbar ) {
		                	//$scrollable_content.mCustomScrollbar("disable"); 
		               // }
		                //Add Image URL to src tag
		                $this.find('.be-flickity .img-wrap').each(function(){
		                    var $this_img_wrap = jQuery(this),
		                        $this_img = $this_img_wrap.find('img'),
		                        $data_source = $this_img.attr('data-flickity-lazyload');

		                    $this_img.removeAttr("data-flickity-lazyload");
		                    $this_img.attr('src',$data_source);
		                    $this_img_wrap.width('100%').height('100%');
		                }); 
		            }
		            //CONDITION 2 - Calculation for all Desktop Screen Sizes. And for Mobile Screen Size when Flickity is Enabled.
		            if($mobile_calculation == true || $window_width > 960){  
		                if($window_width <= 960 ) {
		                    if($window_width >= 480 && $window_width < 640){
		                        $window_height = $full_window_height;
		                    }
		                    $this.find('.img-wrap').width($window_width).height($window_height);
		                    $this.find('.be-flickity').css('padding',0);
		                }else{ 

		                    if($slider_type == 'be-ribbon-carousel' || $slider_type == 'be-center-carousel'){ 
		                        if(jQuery('#bottom-widgets').length){
		                            var $footer_height = 0;
		                        }else{
		                            var $footer_height = Number_or_zero(jQuery('#footer').innerHeight()) ;
		                        }
		                        var $window_height_addl = $window_height-((Number_or_zero(jQuery('.layout-box-bottom:visible').height())*$border_length)+$footer_height),
		                            $given_slider_height = $this.attr('data-height');
		                        
		                        //Set Height and Width according to above Calculations
		                        var $slider_height = Math.round(($window_height_addl/100)*parseInt($given_slider_height)),
		                            $padding = ($window_height_addl-$slider_height)/2;
		                        
		                        $this.find('.img-wrap').height($slider_height);
		                        $this.find('.gallery_content_slide').height($slider_height);
		                        
		                        $this.find('.be-flickity').css('padding', $padding+'px 0px '+$padding+'px 0px').css('opacity', 1);
		                        $this.find('.be-flickity .img-wrap').each(function(){
		                            var $this_img = jQuery(this),
		                                $img = $this_img.find('img'),
		                                $img_actual_width = $this_img.attr('data-image-width'),
		                                $img_actual_height = $this_img.attr('data-image-height'),
		                                $img_width = Math.round(($img_actual_width * $slider_height)/$img_actual_height);  

		                            $this_img.width($img_width);
		                        }); 

		                    } else if ($slider_type == 'be-centered' || $slider_type == 'be-fullscreen'){

		                        $given_slider_height = $this.attr('data-height');//100;
		                        //Larger Screens
		                        if(jQuery('#bottom-widgets').length){
		                            var $footer_height = 0;
		                        }else{
		                            var $footer_height = Number_or_zero(jQuery('#footer').innerHeight()) ;
		                        }                            
		                        var $window_height_addl = $window_height-((Number_or_zero(jQuery('.layout-box-bottom:visible').height())*$border_length)+$footer_height);

		                        //Set Height and Width according to above Calculations
		                        var $slider_height = (($window_height_addl/100)*parseInt($given_slider_height)),
		                            $padding = ($window_height_addl-$slider_height)/2;

		                        $this.find('.be-flickity').css('padding', $padding+'px 0px '+$padding+'px 0px').css('opacity', 1);
		                        $this.find('.img-wrap').height($slider_height).width('100%'); 
		                    }
		                }
		            } 
		            
		            //Calculation of Thumbnail Position if Flickity is Enabled for Mobile Devices
		            if($mobile_calculation == true){
		                if($window_width <= 960){
		                    var $thumbnail_position =  $window_height+37 - Number_or_zero(jQuery('#header').innerHeight()); 
		                    jQuery('.portfolio-sliders .single-portfolio-slider.carousel_bar_area').css('top',$thumbnail_position);  
		                }else{
		                    jQuery('.portfolio-sliders .single-portfolio-slider.carousel_bar_area').css('top','initial'); 
		                }
		            }
		        }
		    },

		    flickity_call = function(){
		        var $flickity_gallery = jQuery('.main-gallery.be-flickity');
		        if( $flickity_gallery.length > 0 ) {
			        var    $slider_type = $flickity_gallery.closest('.portfolio-sliders').attr('data-slider-type'),
			            $nav_arrow = Boolean($flickity_gallery.attr('data-nav-arrow')),
			            $auto_play_time = parseInt($flickity_gallery.attr('data-auto-play')),
			            $free_scroll = Boolean($flickity_gallery.attr('data-free-scroll')),
			            $keyboard_crtl = Boolean($flickity_gallery.attr('data-keyboard-crtl')),
			            $loop_ctrl = Boolean($flickity_gallery.attr('data-loop-crtl')),
			            $cell_align = 'center',
			            $percentPosition = true,
			            $body = jQuery('body');

			        if($auto_play_time <= 0){
			            $auto_play_time = false;
			        }
			        
			        if($slider_type == 'be-ribbon-carousel'){
			            $cell_align = 'left';
			            $percentPosition = false;
			        }
			        if($slider_type == 'be-center-carousel'){
			            $cell_align = 'center';
			            $percentPosition = false;
			        }
			        if((Number_or_zero(jQuery(window).width()) + jQuery.getScrollbarWidth()) <= 960){
			            $free_scroll = false;
			        }
			        var $flickity_gallery = jQuery('.main-gallery.be-flickity').flickity({
			            lazyLoad: 3,
			            prevNextButtons: $nav_arrow,
			            wrapAround: $loop_ctrl,
			            freeScroll: $free_scroll,
			            accessibility: $keyboard_crtl,
			            autoPlay: $auto_play_time,
			            contain: true,
			            cellAlign: $cell_align,
			            percentPosition:$percentPosition,
			            pageDots: false,
			            watchCSS: true,
			            arrowShape: { 
			              x0: 20,
			              x1: 40, y1: 20,
			              x2: 45, y2: 20,
			              x3: 25
			            }   
			        });

			        var $flickity_instance = $flickity_gallery.data('flickity');
			       
			        var iframes = $flickity_gallery.find('.img-wrap iframe');
			        if($slider_type == 'be-ribbon-carousel' || $slider_type == 'be-center-carousel'){
			            flickity_resetGutter($flickity_gallery);
			        }
			        $flickity_gallery.on('lazyLoad.flickity',function(event, cellElement){
			            var img = event.originalEvent.target;
			            // Resize to Parent
			            if($slider_type != 'be-centered'){
			                if(Number_or_zero(jQuery(window).width()) > 960){
			                    jQuery(img).resizeToParent(); 
			                }
			            }

			        })
			        // Apply Fit Vids
			        $flickity_gallery.find('.img-wrap iframe').fitVids();
			        $flickity_gallery.find('.img-wrap iframe').css('opacity',1);
			        $flickity_gallery.find('.img-wrap .img-overlay-wrap').css('display','block');

			        if($slider_type == 'be-fullscreen'){
			            $flickity_gallery.flickity('resize');
			        }

			        $flickity_gallery.on( 'settle.flickity', function( event, pointer ){
			            // Pause Video on Slider Movement
			            iframes.each( function() {
			                var iframe_id = jQuery(this).attr('id');
			                if( iframe_id ) {
			                    var iframe = document.getElementById( iframe_id );
			                    var player = $f(iframe);
			                    player.api("pause");
			                }
			            });

			            var $this_img_wrap = jQuery($flickity_instance.selectedElement);
			            // Increment Slider Count
			            jQuery('.current-slide-count').text(($flickity_instance.selectedIndex) + 1);
			            // Remove Overlay Wrapper
			            $flickity_gallery.find('.img-wrap.is-selected').css('z-index','-1');
			            // Background Check
			            if (!($body.hasClass('disable_rev_slider_bg_check')) && !($body.hasClass('semi'))){
			                if($slider_type == 'be-fullscreen' && ($this_img_wrap.find('iframe').length <= 0) ){
			                    
			                    BackgroundCheck.init({
			                        targets: '#header #header-inner-wrap, .portfolio-sliders .transparent-nav-bar',
			                        images: '.be-fullscreen .img-wrap.is-selected img'
			                    });
			                    
			                    BackgroundCheck.refresh();
			                }
			            }
			        });
				}
		        // BackgroundCheck.destroy();
		    },

		    flickity_resize = function(){
		        var $flickity_gallery = jQuery('.main-gallery.be-flickity'),
		            $slider_type = $flickity_gallery.closest('.portfolio-sliders').attr('data-slider-type'); 

		        if($slider_type != 'be-centered'){
		            if(Number_or_zero(jQuery(window).width()) > 960){
		                $flickity_gallery.find('.img-wrap img').resizeToParent(); 
		            }
		        }
		    },

		    flickity_resetGutter = function(onFlickityGallery){
		        var $flickity_slider = onFlickityGallery.find('.flickity-slider'),
		            $flickity_wrapper = onFlickityGallery.closest('#content'),
		            $gutter_width = $flickity_wrapper.attr('data-gutter-width');
		        
		        if(Number_or_zero(jQuery(window).width()) <= 960 ) {
		            $flickity_slider.css('left',0);
		        }else{
		            $flickity_slider.css('left',Number_or_zero($gutter_width)); 
		        }
			},
				
			blog_category_hover_bg = function() {

				var blogContainer = jQuery( '.style8-blog' );
				blogContainer.on( 'mouseenter', '.post-meta.post-category a',  function( event ) {

					var curElement = jQuery( this ),
						bgColor = curElement.attr( 'data-background-color' ) || '';
					curElement.css( {
						backgroundColor : bgColor,
						borderColor : bgColor 
					} );

				} );
				blogContainer.on( 'mouseleave', '.post-meta.post-category a', function( event ) {

					var curElement = jQuery( this );
					curElement.css( {
						backgroundColor : '',
						borderColor : ''
					} );

				} );

			},

		    flickity_thumb_call = function(){

		        var $flickity_thumb_gallery = jQuery('.be-flickity-thumb').flickity({
		            asNavFor: '.main-gallery', 
		            freeScroll: true,
		            contain: true, 
		            pageDots: false,
		            prevNextButtons: false
		        });
		    },

		    carousel_thumb_call = function(){

		        var $flickity_thumb_gallery = jQuery('.be-carousel-thumb').flickity({
		            freeScroll: true,
		            contain: true, 
		            pageDots: false,
		            prevNextButtons: false
		        });
		    },

			triggerStackShare = function( hoverTargets ) {

				var hoverTargets = hoverTargets || jQuery( '.be-share-stack-mask' );
				hoverTargets.each( function() {

					var	hoverTarget = jQuery( this ),
						hoverTargetChildren = hoverTarget.children(),
						shareTargets = hoverTargetChildren.slice( 1 ),
						stackTop = hoverTarget.parent().hasClass( 'be-stack-top' );
					hoverTarget.on( 'mouseenter', function( event ) {

						if( !stackTop ) {
							hoverTarget.css( 'width', ( ( hoverTargetChildren.length * 15 ) + ( ( hoverTargetChildren.length - 1 ) * 10 ) ) + 'px' );
							shareTargets.each( function(i, e) {
								
								var left = ( ( i + 1 ) * 25 ) + 'px';
								jQuery( this ).css({
									left : left,
									opacity : 1
								});

							} );
						}else{
							hoverTarget.css( 'height', ( ( hoverTargetChildren.length * 17 ) + ( ( hoverTargetChildren.length - 1 ) * 10 ) ) + 'px' );
							hoverTarget.css( 'bottom', 0 );
							shareTargets.each(function( i, e ) {
								
								var bottom = ( ( i + 1 ) * 25 ) + 'px';
								jQuery( this ).css({
									bottom : bottom,
									opacity : 1
								});

							} );						
						}
					
					} );
					hoverTarget.on( 'mouseleave', function( event ) {

						if( !stackTop ) {
							hoverTarget.css( 'width', '' );
							shareTargets.each( function( i, e ) {
								
								jQuery( this ).css({
									left : 0,
									opacity : 0
								});

							} );
						}else{
							hoverTarget.css( 'height', '' );
							shareTargets.each( function( i, e ) {
								
								jQuery( this ).css({
									bottom : 0,
									opacity : 0
								});

							} );
						}
					
					} );    

				});

			},

			triggerFixedFooter = function() {

				if( 0 < fixedFooter.length && 0 < fixedFooterPlaceholder.length && !jQuery( 'body' ).hasClass( 'be-fixed-footer-disable' ) ) {
					if( 1024 < jQuery( window ).width() ) {
						fixedFooterPlaceholder.css( 'display', 'block' );
						fixedFooterPlaceholder.height( fixedFooter.outerHeight() );
						fixedFooter.css('visibility', 'visible');
						if( 'fixed'  != fixedFooter.css( 'position' ) ) {
							fixedFooter.css( 'position', 'fixed' );
						}
						jQuery( 'body' ).addClass( 'be-fixed-footer' );
					}else{
						fixedFooterPlaceholder.css( 'display', 'none' );
						fixedFooter.css( 'position', 'relative' );
						fixedFooter.css( 'visibility', 'visible' );
						jQuery( 'body' ).removeClass( 'be-fixed-footer' );
					}
				}

			},

		    woocommerce = function() {
				jQuery(document).on( 'mouseenter', '.header-cart-controls', function() {
					if(jQuery(this).find('.cart_list.product_list_widget ').length > 0) {
						jQuery(this).find('.widget_shopping_cart_wrap').stop(true, false).fadeIn();
					}
				});

				jQuery(document).on( 'mouseleave', '.header-cart-controls', function() {
					if(jQuery(this).find('.cart_list.product_list_widget ').length > 0) {
						jQuery(this).find('.widget_shopping_cart_wrap').stop(true, false).fadeOut();
					}
				});

				asyncloader.require( 'magnificpopup', function() {
					jQuery('.product-single-boxed-content .images').magnificPopup({
						delegate: 'a',
						type: 'image',
						tLoading: 'Loading image #%curr%...',
						mainClass: 'mfp-img-mobile',
						gallery: {
							enabled: true,
				            navigateByImgClick: true,
				            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
						},
						image: {
				            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
						}
				    });	
				});	    	
		    },

		    heroSectionParallax = function() {
		    	var parallax = jQuery('.be-section.be-bg-parallax');
		        if( parallax.length > 0 ) {
		            parallax.each(function (i, el) {
		                var el = jQuery(el);
		                if (el.visible(true)) {
		                    if(!jQuery(this).hasClass('parallaxed')) {
		                        jQuery(this).parallax("50%", 0.4);
		                        jQuery(this).addClass('parallaxed');
		                    }
		                }
		            });
		        }		    	
		    },

		    tatsuFirstSection = function() {
		    	if( jQuery('#hero-section').length == 0 ) {
		    		//jQuery('#header-inner-wrap').addClass( jQuery('.tatsu-section:first-child').attr('data-headerscheme') );
		    	}
			},
			
			video = function() {
				var vimeoVideos = $( '.be-vimeo-embed' ),
					youtubeVideos = $( '.be-youtube-embed' ),
					loadYoutubeVideos,
					videoReadyCallback;
				videoReadyCallback = function( iframeEle ) {
					asyncloader.require( ['fitvids'], function(){
						if( null != iframeEle && 0 < iframeEle.length ) {
							iframeEle.closest( '.be-video-embed' ).removeClass( 'be-embed-placeholder' );
							iframeEle.parent().fitVids();
							$(document).trigger( 'be_video_loaded', [ iframeEle ] );
						}  
					});        
				};
				loadYoutubeVideos = function() {
					youtubeVideos.each(function() {
						var curVideo = $(this),
							curPlayer = null,
							id = null != curVideo.attr( 'data-video-id' ) ? curVideo.attr( 'data-video-id' ) : null,
							autoplay = null != curVideo.attr( 'data-autoplay' ) ? parseInt(curVideo.attr( 'data-autoplay' )) : null,
							loopVideo = null != curVideo.attr( 'data-loop' ) ? parseInt(curVideo.attr( 'data-loop' )) : null;
	
						if( null != id ) {
							var playerVariables = { 
								'autoplay': autoplay,
								'loop' : loopVideo,
								'rel' : 0
							};
							if(loopVideo){
								playerVariables.playlist = id;
							}
							
							var ytPlayerSettings = {
								videoId : id,
								playerVars: playerVariables,
								width : curVideo.width(),
								height : curVideo.width()/1.7777,
								events: {
									'onReady': function (e) {
										if( autoplay ){
											e.target.mute();   
										}
									}
								}
							};
							//fix - Revslider background video 
							if(0< $('rs-bgvideo').length){
								ytPlayerSettings.host='https://www.youtube-nocookie.com';
								ytPlayerSettings.origin=window.location.hostname;
							}
							
							curPlayer = new YT.Player( this, ytPlayerSettings);

							// curPlayer = new YT.Player( this, {
							// 	videoId : id,
							// 	playerVars: playerVariables,
							// 	width : curVideo.width(),
							// 	height : curVideo.width()/1.7777,
							// 	events: {
							// 		'onReady': function (e) {
							// 			if( autoplay ){
							// 				e.target.mute();   
							// 			}
							// 		}
							// 	}
							// });
							videoReadyCallback( $( curPlayer.getIframe() ) );
						}
					});
				}
				//vimeo videos
				if( 0 < vimeoVideos.length ) {
					asyncloader.require( [ 'vimeonew' ], function() {
						vimeoVideos.each( function() {
							var curVideo = $(this),
								curPlayer = null,
								id = !isNaN( Number( curVideo.attr( 'data-video-id' ) ) ) ? Number( curVideo.attr( 'data-video-id' ) ) : null,
								autoplay = null != curVideo.attr( 'data-autoplay' ) ? parseInt(curVideo.attr( 'data-autoplay' )) : false,
								loopVideo = null != curVideo.attr( 'data-loop' ) ? parseInt(curVideo.attr( 'data-loop' )) : false;
							if( null != id ) {
								var curPlayer = new Vimeo.Player( this, {
									id : id,
									autoplay : autoplay ? true : false,
									loop : loopVideo ? true : false,
									muted : autoplay ? true : false,
									width : curVideo.width(),
									height : Math.ceil(curVideo.width()/1.7777),    
								});
								curPlayer.ready().then( function() {
									videoReadyCallback( curVideo.children( 'iframe' ) );
								});
							}
						} );
					} );
				}
	
				if( 0 < youtubeVideos.length ) {
					if( 'undefined' != typeof YT && 'function' == typeof YT.Player ) {
						loadYoutubeVideos();
					}else {
						$(document).on( 'YTAPIReady', loadYoutubeVideos );
					}
				}
			},

		    ready = function() {

				//jQuery( 'body' ).css( 'display', 'none' );
				tatsuFirstSection();
				blog_category_hover_bg();
				triggerFixedFooter();
				sticky_sidebar();
		    	jQuery('.component ul li:first-child').addClass('current');

		    	asyncloader.require( 'fitvids' , function(){
	    	        body.find('iframe').not('.rev_slider iframe').each(function () {
						if(jQuery(this).parents('rs-bgvideo').length==0){
							jQuery(this).parent().fitVids();console.log("not rev slider");
						}
	            		//jQuery(this).parent().fitVids();
	        		});
	    	    });

		        jQuery( document ).on( 'click', '.top-overlay-menu .sliderbar-nav-controller-wrap, .left-overlay-menu .left-strip-wrapper',  menu_link_animation );	

		        //Handle Transparent & Sticky Headers
		        asyncloader.require( [ 'transparentheader' ], function(){
		        	jQuery('#header').Transparent();
		        });	 

		        //Handle Scroll to Sections
		        if( body.hasClass('section-scroll') && !body.hasClass('tatsu-frame') ) {
					var deps = [ 'scrolltosections', 'mousewheel' ];
					if( jQuery('be-vimeo-embed').length ){
						deps.push('vimeo');
					}
		        	asyncloader.require( deps, function(){
		        		body.SectionScroll();
		        	});
		        }

		        if( jQuery('#galaxy-canvas').length > 0 ) {
		        	asyncloader.require( [ 'greensock', 'request_animation_frame', 'galaxycanvas' ], function(){
		            	galaxy_canvas();
		            });
		        }

		        if( jQuery('#pattern-canvas').length > 0 ) {
		        	asyncloader.require( [ 'greensock', 'request_animation_frame', 'patterncanvas' ], function(){
		            	pattern_canvas();  
		          });
		        }

		        if( jQuery('#waterdrops-canvas').length > 0 ) {
		        	asyncloader.require( [ 'greensock', 'request_animation_frame', 'waterdropcanvas' ], function(){
		            	water_drop_canvas();
		            });
		        }

		        if( fullscreen_wrap.length > 0 ) {
					asyncloader.require( [ 'fullscreenheight' ], function(){
						fullscreen_wrap.FullScreen();
					});		        	
		        }	

				
				//Perspective Left & right
				perspective_navigation();			
				//Top Page Stack
				top_page_stack();
				
		        custom_scrollbar();
		        close_sidebar();
		        open_leftstrip();
		        menu_item_update();
		        single_page_nav();
		        superfish();
                sliders();
		        rev_slider_bg_check();
		        woocommerce();
		        heroSectionParallax();

				//sticky_sections
				sticky_sections();


				//stack share icons trigger
				triggerStackShare();

		        //Handle Click Events
		        close_overlay_menu();
		        close_gallery_info_box();
		        close_popups();
		        back_to_top();
		        left_strip();
		        sliderbar_navigation();
		        local_scroll();
		        sub_menu();
		        falling_menu();
		        mobile_menu();
		        header_search();
				
				//BE Left strip
				be_left_strip();
				left_header_close_overlay();
				//Side menu
				sidemenu_navigation();
				close_sidemenu();

		        //Handle Mouseover events
		        carousel_thumb();

		        //Flickity
		        if( jQuery('.main-gallery.be-flickity').length > 0 ) {
					var hasVimeo = jQuery('.main-gallery.be-flickity').attr('data-vimeo'),
						flickityDeps = ['flickity', 'backgroundcheck', 'resizetoparent' ];
					if( "1" == hasVimeo && jQuery('be-vimeo-embed').length ) {
						flickityDeps.push( 'vimeo' );
					}
			        asyncloader.require( flickityDeps, function() {
				        flickity_default_header();
		        		flickity_getHeight();
		        		flickity_call();
		        		flickity_thumb_call();
		        				        	
			        });
				}
				

			    if( jQuery('.be-carousel-thumb').length > 0 ) {
			    	asyncloader.require('flickity', function() {
						carousel_thumb_call();  		
			    	});
				}
				carouselIOSFix();
				//Multi Level Menu
				multi_level_menu();
                video();
                portfolioTemplateZoro();

		    },

		    run = function() {

		    	ready();

		    	//On Window Scroll Event

		    	jQuery(window).on('scroll', function () {	    		
					didScroll = true;
		    	});

				setInterval( function(){
					if( didScroll ) {
						didScroll = false;
						show_back_to_top_button();
					}
				},100 );

				if( body.hasClass('single-page-version') ){
					jQuery(window).on('scroll', function () {
						menu_item_update();
					});
				}

			    if( jQuery(".floting-sidebar").length > 0 || jQuery(".fixed-sidebar").length > 0 ) {
					jQuery(window).on('scroll', function () {
						sticky_sidebar();
					});					
				}

				if( body.hasClass('page-template-page-splitscreen-left') || body.hasClass('page-template-page-splitscreen-right') ) {
					jQuery(window).on('scroll', function () {
						split_screen();
					});						
				}

		    	//On Window Resize Event
		    	jQuery(window).on( 'resize.oshine', function() {
		    		sticky_sidebar();
		    		split_screen();
					triggerFixedFooter();
		    		//close_mobile_menu();
		    		menu_item_update();
			        if (jQuery(window).width() > 960) {
			            jQuery('.mobile-menu').slideUp();
						jQuery( '.mobile-nav-controller .be-mobile-menu-icon' ).removeClass( 'is-clicked' );
			        } else {
						jQuery( 'body' ).removeClass( 'side-menu-opened' );
						jQuery( '.be-sidemenu' ).removeClass( 'opened' );
						jQuery( '.hamburger-nav-controller .be-mobile-menu-icon' ).removeClass( 'is-clicked' );
						jQuery( '#be-left-strip .be-mobile-menu-icon' ).removeClass( 'is-clicked' );
						jQuery('html').removeClass('hide-overflow');
						if( jQuery('body').hasClass( 'overlay-center-align-menu' ) || jQuery('body').hasClass( 'overlay-left-align-menu' ) || jQuery('body').hasClass( 'overlay-horizontal-menu' ) ){
							jQuery( '#header' ).css( 'z-index', '10' );
							jQuery( '.be-sidemenu' ).css({ 'z-index' : '-1', 'visibility' : 'hidden' });
						}
					}

	        	 	//jQuery(".gallery_content_area, .ps-content-inner, .gallery_content_slide").mCustomScrollbar("update");


					if( jQuery('.main-gallery.be-flickity').length > 0 ) {
						asyncloader.require( ['flickity', 'backgroundcheck', 'resizetoparent'], function() {
						    flickity_default_header();
						    flickity_getHeight();
						    var $flickity_gallery = jQuery('.main-gallery.be-flickity');

						    if(jQuery(window).width() > 960){
						        $flickity_gallery.find('.img-wrap').each(function(){
						            var $this_img = jQuery(this),
						                $img = $this_img.find('img');
						            //Reassign Img Source Attribute to Enable Lazyload in Larger Screen Sizes
						            if( ($img.attr('src') ) && !($img.hasClass('flickity-lazyloaded') ) ) {
						            var $data_source = $img.attr('src');
						                $img.removeAttr("src");
						                $img.attr('data-flickity-lazyload',$data_source);
						            }
						        });
						    }
						    $flickity_gallery.flickity('reloadCells');
						    // Resize to Parent
						    flickity_resize();
						    flickity_resetGutter($flickity_gallery);
						    flickity_thumb_call();
						});
					}

				    if( jQuery('.be-carousel-thumb').length > 0 ) {
				    	asyncloader.require( 'flickity', function() {
							carousel_thumb_call();  		
				    	});
					}	
		    	});

		    	// On Window Load Event
				jQuery(window).on( 'load', function () {
						var $hash = window.location.hash;
				        if ($hash) {
				            if (jQuery($hash).length > 0) {
								if( body.hasClass( 'be-sticky-sections' ) ) {
									var secIndex = jQuery( $hash ).index();
									if( null != stickySections && -1 < secIndex && secIndex < jQuery( '.sticky-section' ).length ) {
										stickySections.moveTo( secIndex );
									}
								}else{
									animate_scroll( jQuery($hash) );
								}
				            }
				        }
				        setTimeout(function () {
				        	asyncloader.require( 'imagesloaded' , function(){
					            body.imagesLoaded(function () {
									split_screen();
									if( body.hasClass( 'be-sticky-sections' ) && !body.hasClass( 'tatsu-frame' ) && 967 < jQuery( window ).width() ) {
										stickySections.updateLayout();										
									}
					            });
					        });    
				        }, 200);
				        custom_scrollbar();
				});
		    }


			return {
				run: run,
				animate_scroll : animate_scroll,
				triggerStackShare : triggerStackShare
			}

	    })();
		
	    oshine_scripts.run();
		window.oshine_scripts = oshine_scripts;

	});    

})( jQuery );

;(function($) {
    if($(".ps-fade").length > 0 ){
        console.log("ps-fade in");
        if( $(window).width() < 768 ){
            console.log("flickity mobile");
            setTimeout(function(){
                $(".ps-fade-gallery-inner").flickity("destroy");
                $(".ps-fade-gallery-inner").flickity({pageDots:!1,adaptiveHeight:!0,prevNextButtons:!1});
            },1000);
        }
    }
})(jQuery);