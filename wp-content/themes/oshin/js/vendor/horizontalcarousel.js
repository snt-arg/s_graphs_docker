/**Horizontal Carousel, Centered Slider & Full Screen Slider**/
	
;(function ( $ ) {
	var $gallery_wrap = $(this);
	var $gallery_container = $gallery_wrap.children('#gallery-container');
	var $position = 1;
	var padding_l = 0;
	var padding_r = 0;
	var current = 0, w_width = 0;
	var center = $gallery_wrap.width()/2;
	var nmb_images = $gallery_container.children('.placeholder').length;
	// var $thumbnail_test = jQuery('.be-carousel-thumb');
	var scrolled = false, scrollTimeout;
	var move_slide = function() {};
	var show_image = function() {};
	var preload = function() {};
	var pause_vimeo_video = function() {};
	var image_resize = function() {};
	var show_arrows = function() {};
	$.fn.thumbnailSlider = function(){
		$thumbnailElement = $(this);
		
		$thumbnailElement.on( 'click', '.gallery-thumb', function( event ) {
		  	// if ( !cellElement ) {
		   //  	return;
		  	// }
		    var $target = jQuery(this).attr('data-target');
		    move_slide(parseInt($target));
		});
	}
	$.fn.CenteredSlider = function() {
		$gallery_wrap = $(this);
		$gallery_container = $gallery_wrap.children('#gallery-container');
		$gallery_all_container = $gallery_wrap.parent('.gallery-all-container');
		$position = 1;
		padding_l = 0;
		padding_r = 0;
		current = 0, w_width = 0;
		center = $gallery_wrap.width()/2;
		nmb_images = $gallery_container.children('.placeholder').length;
		scrolled = false, scrollTimeout;
		jQuery('.style1_placehloder').each(function(i) {
			jQuery(this).find('img').attr('src', jQuery(this).attr('data-source'));
			image_resize();
		});
		show_image = function($show_overlay, $moveto) {
			$show_overlay = typeof $show_overlay === 'undefined' ? true : false;
			$moveto = ((typeof $moveto === 'undefined') || $moveto == true) ? true : false;
			$obj = $gallery_container.find('.placeholder:eq('+current+')');
			$length = $gallery_container.find('.placeholder').length;
			if(($obj.length > 0) && (jQuery('#gallery-container-wrap').length > 0)) {
				var $offset 			= $obj.offset();
				var $parent_offset 		= jQuery('#gallery-container-wrap').offset();
				var obj_left 			= $offset.left-$parent_offset.left;
				var obj_center 			= obj_left + ($obj.width()/2);
				var center				= $gallery_wrap.width()/2;
				var currentScrollLeft 	= parseFloat($gallery_wrap.scrollLeft(),10);
				var move 				= currentScrollLeft + (obj_center - center);
				
				if($gallery_container.hasClass('vertical-carousel')) {
					obj_left 			= $offset.top-$parent_offset.top ;
					obj_center 			= obj_left + ($obj.height()/2);
					center				= $gallery_wrap.height()/2;
					currentScrollLeft 	= parseFloat($gallery_wrap.scrollTop(),10);
					move 				= currentScrollLeft + (obj_center - center);
				}
				if($show_overlay) {
					if($obj.hasClass('hentry')) {
						var $element = $obj.find('.portfolio-item-overlay');
						var $element_title = $obj.find('.attachment-details-custom-slider');
						jQuery('.portfolio-item-overlay').not($element).stop(true, true).fadeIn();
						jQuery('.attachment-details-custom-slider').not($element_title).css('display', 'none');
						$element.stop(true, true).fadeOut();
						if(!$element_title.is(":visible"))
							$element_title.css('display', 'block');
					} else {
						var $element = $obj.find('.overlay_placeholder');
						var $element_title = $obj.find('.attachment-details-custom-slider');
						jQuery('.overlay_placeholder').not($element).stop(true, true).fadeIn();
						jQuery('.attachment-details-custom-slider').not($element_title).css('display', 'none');
						$element.stop(true, true).fadeOut();
						if(!$element_title.is(":visible"))
							$element_title.css('display', 'block');
					}
				}
				if($moveto) {
					if($gallery_container.hasClass('vertical-carousel')) {
						if(move != $gallery_wrap.scrollTop()) {
							$gallery_wrap.stop().animate({scrollTop: move});
						}
					} else {
						if(move != $gallery_wrap.scrollLeft()) {
							$gallery_wrap.stop().animate({scrollLeft: move});
						}
					}
				}
			}
			show_arrows();
			$gallery_wrap.css('opacity', 1);
			jQuery('.page-loader').fadeOut();
		};
		preload = function(index) {
			var $obj = $gallery_container.find('.placeholder:eq('+index+')');
			if($obj.length > 0) {
				if($obj.hasClass('load')) {
					$obj.removeClass('load');
					if($obj.attr('data-source') != 'video') {
						loadImage($obj.attr('data-source'), $obj.attr('data-alt') , function() {
							$obj.find('img').remove();
							$obj.prepend(this);
							if($obj.attr('data-href')) {
								this.wrap('<a class="slider-img-wrap dJAX_internal" target='+$obj.attr('data-target')+' href='+$obj.attr('data-href')+'></a>');
								$obj.find('.overlay_placeholder').appendTo($obj.find('a.slider-img-wrap'));
							}
							this.fadeIn(500, function() {
								jQuery('.gallery-slider-wrap').find('.loader').fadeOut();
								if($obj.hasClass('center')) {
									$obj.find('img').resizeToParent().css('opacity', 1);
								}
								else {
									$obj.find('img').css('opacity', 1);
								}
								image_resize();
								if($gallery_all_container.hasClass('normal-scroll') && jQuery('html').hasClass('no-touch')) {
									show_image(false, false);
								} else {
									show_image(false);
								}
								$obj.removeClass('show-title');
							});
						});
					}
				}
			}
		}
		loadImage = function(src, alt, callback) {
			var img = jQuery('<img>').on('load', function(){
				callback.call(img);
			});
			img.attr('src',src);
			img.attr('alt',alt);
		}
		for( i=current; i<=nmb_images; i++) {
			preload(i);
		}
		move_slide = function($action) {
			if($action == 'next' || $action == 'prev') {
				if($action == 'next') {
					nmb_images = $gallery_container.children('.placeholder').length;
					if(current+1 < nmb_images) {
						pause_vimeo_video();
						current++;
						show_image();
					}
				}
				if($action == 'prev') {
					if(current > 0) {
						pause_vimeo_video();
						current--;
						show_image();
					}
				}
			} else {
				current = $action;
				show_image();
			}
		};
		show_arrows = function() {
			if(nmb_images == 1) {
				jQuery('.arrow_prev').remove();
				jQuery('.arrow_next').remove();
			}
			if(nmb_images == current+1) {
				jQuery('.arrow_next').stop().fadeOut();
				jQuery('.arrow_prev').stop().fadeIn();
			} else if(current == 0) {
				jQuery('.arrow_prev').stop().fadeOut();
				jQuery('.arrow_next').stop().fadeIn();
			} else {
				jQuery('.arrow_prev').stop().fadeIn();
				jQuery('.arrow_next').stop().fadeIn();
			}
		};
		pause_vimeo_video = function() {
			//var prev_index = current-1;
			var iframe_id = $gallery_container.find('.placeholder:eq('+current+') .be-vimeo-video').first().attr('id');
			//var iframe_id = obj.first().attr('id'); 
			if( iframe_id ) {
				var iframe = document.getElementById( iframe_id );
				var player = $f(iframe);
				player.api("pause");
			}
		}
		Number_or_zero = function(num){
			num = Number(num);
			if(isNaN(num)){
				num = 0;
			}
			return num;
		}
		image_resize = function() {
			var $border_length = 2;
			if(jQuery('body').hasClass('be-themes-layout-layout-border-header-top')) {
				$border_length = 1;
			}
			var $height = (Number_or_zero(jQuery(window).height())-(Number_or_zero(jQuery('#header').innerHeight())+(Number_or_zero(jQuery('.layout-box-bottom:visible').height())*$border_length)+Number_or_zero(jQuery('#wpadminbar').innerHeight())+Number_or_zero(jQuery('#portfolio-title-nav-wrap').innerHeight())+Number_or_zero(jQuery('#footer').innerHeight()))), $slider_height = $height;
			//console.log("$height",$height);
			if(jQuery('#gallery-container-wrap').attr('data-height')) {
				$slider_height = (($height/100)*parseInt(jQuery('#gallery-container-wrap').attr('data-height')));
				var $padding = ($height-$slider_height)/2;
				jQuery('#gallery-container-wrap').css('padding', $padding+'px 0px '+$padding+'px 0px').css('opacity', 1);
			}
			jQuery('#gallery-container-wrap').height($slider_height);
			jQuery('.style1_placehloder').each(function(i) {
				jQuery(this).height($slider_height);
				jQuery(this).find('img').height($slider_height);
			});
			jQuery('.placeholder.center img').resizeToParent();
			if($gallery_all_container.hasClass('normal-scroll') && jQuery('html').hasClass('no-touch')) {
				show_image(false, false);
			} else {
				show_image(false);
			}
			jQuery('.gallery-all-container').removeClass('resized');
		}
		if($gallery_all_container.hasClass('normal-scroll') && jQuery('html').hasClass('no-touch')) {
			show_image(true, false);
		} else {
			show_image();
		}
		if(jQuery('html').hasClass('touch') && (jQuery(window).width() > 767)) {
			jQuery('body').off('touchstart');
			jQuery('body').on('touchstart', '#gallery-container-wrap', function(e) {
				var touch = e.originalEvent,
					startX = touch.changedTouches[0].pageX;
				$gallery_wrap.on('touchmove',function(e){
					e.preventDefault();
					touch = e.originalEvent.touches[0] ||
							e.originalEvent.changedTouches[0];
					if(touch.pageX - startX > 10){
						$gallery_wrap.off('touchmove');
						move_slide('prev');
					}
					else if (touch.pageX - startX < -10){
						$gallery_wrap.off('touchmove');
						move_slide('next');
					}
				});
			}).on('touchend',function() {
				$gallery_wrap.off('touchmove');
			});
		} else {
			$gallery_wrap.off('mousewheel');
			$gallery_wrap.on('mousewheel',function(event){//, delta, deltaX,deltaY) {

				if(jQuery(window).width() > 767) {
					if(jQuery('.gallery-all-container').hasClass('normal-scroll') && jQuery('html').hasClass('no-touch')) {
						if($gallery_container.hasClass('vertical-carousel')) {
							$gallery_wrap.animate({scrollTop: '-='+(event.deltaY * event.deltaFactor)}, 0);
						} 
						else {
							$gallery_wrap.animate({scrollLeft: '-='+(event.deltaY * event.deltaFactor)}, 0);
						}
						event.preventDefault();
						
					} else {
						event.preventDefault();
						if(!scrolled) {
							scrolled = true;
							if((event.deltaY * event.deltaFactor) < 0) {
								move_slide('next');
							} else {
								move_slide('prev');
							}
						}
						clearTimeout(scrollTimeout);
						scrollTimeout = setTimeout(function() {
							scrolled = false;
						}, 45);
					}
				}
			});
		}
		jQuery(document).keydown(function(e) {
			if(jQuery('#gallery-container-wrap').length > 0) {
				if(!scrolled) {
					scrolled = true;
					if(e.which == 37 || e.which == 38 || e.which == 39 || e.which == 40) {
						if(e.which == 37) {
							move_slide('prev');
						} else if(e.which == 38) {
							move_slide('prev');
						} else if(e.which == 39) {
							move_slide('next');
						} else {
							move_slide('next');
						}
						e.preventDefault();
					}
					clearTimeout(scrollTimeout);
					scrollTimeout = setTimeout(function() {
						scrolled = false;
					}, 45);
				}
			}
		});
	}
	image_resize();
	jQuery(window).smartresize(function() {
		image_resize();
	});
	jQuery(document).on('click', '.arrow_next', function(e) {
		move_slide('next');
	});
	jQuery(document).on('click', '.arrow_prev', function(e) {
		move_slide('prev');
	});
	jQuery(document).on('mouseup', '#gallery-container-wrap, .arrow_next, .arrow_prev', function(e) {
		if(jQuery('.gallery_content').hasClass('show')) {
			jQuery('.gallery_content').removeClass('show');
			jQuery('.single_portfolio_info_close').find('.font-icon').addClass('icon_document_alt').removeClass('icon_close');
		}
	});
	// jQuery(document).on('click', '.elastislide-carousel ul li a', function(e) {
	// 	e.preventDefault();
	// 	var $target = jQuery(this).attr('data-target');
	// 	move_slide(parseInt($target));
	// });

}( jQuery ));