/************************************************
BE SLIDER
************************************************/
;(function($) {
	function set_slider_height() {
    	jQuery('.component').each(function() {
    		var $this = jQuery(this), $width = parseInt($this.width()), $default_height = $this.attr('data-height'), $mobile_height = $this.attr('data-mobile-height');
    		jQuery('.ps-container-wrap').height(jQuery(window).height()-(jQuery('#header').height()+(jQuery('.layout-box-top').height()*2+jQuery('#wpadminbar').height())));
    		if($width < 767) {
    			$this.height($mobile_height);
    		} else {
    			$this.height($default_height);
    		}
    		if($default_height == '100%') {
    			$this.height($this.parent().parent().height());
    		}
    		if(jQuery('.ps-content-inner').length > 0 ) {
	            jQuery('.ps-content-inner').each(function () {
	                var $this = jQuery(this);
	                	$this.simplebar();
	            });
	        }
    	});
    }
	$.fn.BeSlider = function() {
		var support = { animations : Modernizr.cssanimations },
		animEndEventNames = {
			'WebkitAnimation' : 'webkitAnimationEnd',
			'OAnimation' : 'oAnimationEnd',
			'msAnimation' : 'MSAnimationEnd',
			'animation' : 'animationend'
		},
		animEndEventName = animEndEventNames[ Modernizr.prefixed( 'animation' ) ];
		var cntAnims = 0,
			isAnimating = false,
			$current_slider = jQuery(this);
		var navigate = function( $this, dir ) {
			if( isAnimating ) {
				return false;
			}
			var component = $this.closest('.component');
				items = component.children('ul.itemwrap').children('li'),
				itemsCount = component.children('ul.itemwrap').children('li').length,
				current = parseInt($this.closest('.component').attr('data-current'));
				currentItem = items[ current ];
			cntAnims = 0;
			isAnimating = true;
			if( dir === 'next' ) {
				current = current < itemsCount - 1 ? current + 1 : 0;
			} else if( dir === 'prev' ) {
				current = current > 0 ? current - 1 : itemsCount - 1;
			}
			
			$this.closest('.component').attr('data-current', current);
			var nextItem = items[ current ];
			var onEndAnimationCurrentItem = function() {
				jQuery(currentItem).removeClass( 'current' );
				jQuery(currentItem).removeClass( dir === 'next' ? 'navOutNext' : 'navOutPrev' );
				++cntAnims;
				if( cntAnims === 2 ) {
					isAnimating = false;
				}
			}
			var onEndAnimationNextItem = function() {
				jQuery(nextItem).unbind( animEndEventName, onEndAnimationNextItem );
				jQuery(nextItem).addClass( 'current' );
				jQuery(nextItem).removeClass( dir === 'next' ? 'navInNext' : 'navInPrev' );
				++cntAnims;
				if( cntAnims === 2 ) {
					isAnimating = false;
				}
			}
			if( support.animations ) {
				currentItem.addEventListener( animEndEventName, onEndAnimationCurrentItem );
				nextItem.addEventListener( animEndEventName, onEndAnimationNextItem );
			}
			else {
				onEndAnimationCurrentItem();
				onEndAnimationNextItem();
			}
			jQuery(currentItem).addClass(dir === 'next' ? 'navOutNext' : 'navOutPrev');
			jQuery(nextItem).addClass(dir === 'next' ? 'navInNext' : 'navInPrev');
		};
		var addImage = function(index) {
			var items = $current_slider.find('ul.itemwrap').children('li');
			if((items.eq(index).length > 0) && (!items.eq(index).find('.be-slide-bg').hasClass('image-loaded')) && (!items.eq(index).find('.be-slide-bg').hasClass('be-slider-video'))) {
				loadImage(items.eq(index).find('.be-slide-bg').attr('data-image'), function() {
					items.eq(index).find('.be-slide-bg').html(this);
					this.resizeToParent();
					this.css('opacity', 1);
					items.eq(index).find('.be-slide-bg').addClass('image-loaded');
					items.closest('.component').find('.component-nav').find('a').fadeIn();
					addImage(index+1);
				});
			} else {
				return true;
			}
		}
		var loadImage = function(src, callback) {
			var img = $('<img>').on('load', function(){
				callback.call(img);
			});
			img.attr('src',src);
		}
		var Init = function( $this ) {
			$this.find('ul.itemwrap li:first-child').addClass('current');
			addImage(0);
			if($this.find('ul.itemwrap li').length < 2) {
				$this.find('nav.component-nav').remove();
			}
		}
		Init($current_slider);
		jQuery('.be-slider-next, .be-slider-prev').off();
		jQuery('.be-slider-next').on('click', function(e) {
			e.preventDefault(); 
			navigate( jQuery(this), 'next' );
		});
		jQuery('.be-slider-prev').on('click', function(e) {
			e.preventDefault(); 
			navigate( jQuery(this), 'prev' );
		});
    };
    jQuery(document).ready(function() {
    	set_slider_height();
    	jQuery('.component:not(.no-load)').each(function() {
    		jQuery(this).BeSlider();
    	});
    });
    jQuery(document).on("update_content", function() {
		set_slider_height();
    	jQuery('.component:not(.no-load)').each(function() {
    		jQuery(this).BeSlider();
    	});
	});
    jQuery(window).smartresize(function () {
    	set_slider_height();
    });
}( jQuery ));

;(function($) {
	function update_be_slider() {
		if(jQuery(window).width() < 960){
			jQuery('.ps-container-wrap').find('.component.no-load').each(function(){
				jQuery(this).removeClass('no-load').addClass('loaded');
				jQuery(this).BeSlider();
			});
		}
	}
	function create_slider() {
		var Slider = (function() {
			var $container = $( '#ps-container' ),
				$contentwrapper = $container.children( 'div.ps-contentwrapper' ),
				$items = $contentwrapper.children( 'div.ps-content' ),
				itemsCount = $items.length,
				$slidewrapper = $container.children( 'div.ps-slidewrapper' ),
				$slidescontainer = $slidewrapper.find( 'div.ps-slides' ),
				$slides = $slidescontainer.children( 'div' ),
				$navprev = $container.find( 'a.ps-prev' ),
				$navnext = $container.find( 'a.ps-next' ),
				current = itemsCount-1,
				isAnimating = isMouseWheelAnimating = false,
				init = function() {
					$container.data( 'current_slide', current );
					initEvents();
					slide();
				},
				initEvents = function() {
					$navprev.click(function( event ) {
						if( !isAnimating ) {
							slide( 'prev' );
						}
						return false;
					});
					$navnext.click(function( event ) {
						if( !isAnimating ) {
							slide( 'next' );
						}
						return false;
					});
					$container.on('mousewheel',function(event, delta, deltaX,deltaY) {
						if((jQuery(window).width()) > 960) {
							event.preventDefault();
							if(delta < 0) {
								if( !isAnimating && !isMouseWheelAnimating ) {
									isMouseWheelAnimating = true;
									slide( 'prev' );
								}
							} else {
								if( !isAnimating && !isMouseWheelAnimating ) {
									isMouseWheelAnimating = true;
									slide( 'next' );
								}
							}
							if(isMouseWheelAnimating) {
								setTimeout(function() {
		  							isMouseWheelAnimating = false;
								}, 1500);
							}
						}
					});
					//jQuery('.ps-content-inner').mCustomScrollbar('update');
				},
				update_arrows = function() {
					var current_index = $container.data( 'current_slide' );
					if( current == itemsCount-1 ) {
						jQuery('.ps-next').fadeOut();
						jQuery('.ps-prev').fadeIn();
					} else if(current_index == 0) {
						jQuery('.ps-prev').fadeOut();
						jQuery('.ps-next').fadeIn();
					} else {
						jQuery('.ps-next').fadeIn();
						jQuery('.ps-prev').fadeIn();
					}
					if(itemsCount < 2) {
						jQuery('.ps-next, .ps-prev').remove();
					}
				},
				load_be_slider = function() {
					var current_index = $container.data( 'current_slide' ), $i = 0;
					for( $i=current_index; $i<current_index+3; $i++ ) {
						if($slidescontainer.children('div:eq('+((itemsCount-1)-$i)+')').find('.component').hasClass('no-load')) {
							$slidescontainer.children('div:eq('+((itemsCount-1)-$i)+')').find('.component').removeClass('no-load').addClass('loaded');
							$slidescontainer.children('div:eq('+((itemsCount-1)-$i)+')').find('.component').BeSlider();
						}
					}
				},
				slide = function( dir ) {
					isAnimating = true;
					current = $container.data( 'current_slide' );
					if( dir === 'next' ) {
						( current < itemsCount - 1 ) ? ++current : current = current;
					}
					else if( dir === 'prev' ) {
						( current > 0 ) ? --current : current = current;
					}
					$container.data( 'current_slide', current );
					update_arrows();
					load_be_slider();
					$contentwrapper.animate({top : '-'+(current*100)+'%'}, 400, function() {
		    			isAnimating = false;
					});
					$slidescontainer.animate({top : '-'+(((itemsCount-1)-current)*100)+'%'}, 400, function() {
		    			isAnimating = false;
					});
					//jQuery('.ps-content-inner').mCustomScrollbar('update');
				};
			return { init : init };
		})();
		Slider.init();
		update_be_slider();
	}
	jQuery(window).bind('resize', update_be_slider);
	jQuery(document).ready(function() {
		create_slider();
	});
	jQuery(document).on("update_content", function() {
		create_slider();
	});
})(jQuery);