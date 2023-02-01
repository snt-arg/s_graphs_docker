/**OS SCROLLBAR**/
;(function($) {
	var ua = window.navigator.userAgent;
    var msie = ua.indexOf("NET4");
    //console.log(ua);
    //console.log(msie);
    if(msie > -1){
    	$('body').addClass('internet_expoler');
    }
	var scrollbarWidth = 0;
	$.getScrollbarWidth = function() {
		if ( !scrollbarWidth ) {
			if ( $.browser.msie ) {
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

/**
 * jQuery Unveil
 * A very lightweight jQuery plugin to lazy load images
 * http://luis-almeida.github.com/unveil
 *
 * Licensed under the MIT license.
 * Copyright 2013 Luís Almeida
 * https://github.com/luis-almeida
 */

;(function($) {

  $.fn.unveil = function(threshold, callback) {

    var $w = $(window),
        th = threshold || 0,
        retina = window.devicePixelRatio > 1,
        attrib = retina? "data-src-retina" : "data-src",
        images = this,
        loaded;

    this.one("unveil", function() {
      var source = this.getAttribute(attrib);
      source = source || this.getAttribute("data-src");
      if (source) {
        this.setAttribute("src", source);
        if (typeof callback === "function") callback.call(this);
      }
    });

    function unveil() {
      var inview = images.filter(function() {
        var $e = $(this);
        if ($e.is(":hidden")) return;

        var wt = $w.scrollTop(),
            wb = wt + $w.height(),
            et = $e.offset().top,
            eb = et + $e.height();

        return eb >= wt - th && et <= wb + th;
      });

      loaded = inview.trigger("unveil");
      images = images.not(loaded);
    }

    $w.on("scroll.unveil resize.unveil lookup.unveil", unveil);

    unveil();

    return this;

  };

})(window.jQuery || window.Zepto);

/******************************************************************************/
/** Smart Resize **/

;(function($,sr) {
 // debouncing function from John Hann
 // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
 var debounce = function (func, threshold, execAsap) {
    var timeout;
     return function debounced () {
         var obj = this, args = arguments;
         function delayed () {
             if (!execAsap)
                 func.apply(obj, args);
             timeout = null;
         };

         if (timeout)
             clearTimeout(timeout);
         else if (execAsap)
             func.apply(obj, args);

         timeout = setTimeout(delayed, threshold || 100);
     };
 }
 // smartresize 
 jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };
})(jQuery,'smartresize');

/******************************************************************************/

;(function($) {
	/**
   * Copyright 2012, Digital Fusion
   * Licensed under the MIT license.
   * http://teamdf.com/jquery-plugins/license/
   *
   * @author Sam Sehnert
   * @desc A small plugin that checks whether elements are within
   *     the user visible viewport of a web browser.
   *     only accounts for vertical position, not horizontal.
   */
	$.fn.visible = function(partial) {
    
      var $t            = $(this),
          $w            = $(window),
          viewTop       = $w.scrollTop(),
          viewBottom    = viewTop + $w.height(),
          _top          = $t.offset().top,
          _bottom       = _top + $t.height(),
          compareTop    = partial === true ? _bottom : _top,
          compareBottom = partial === true ? _top : _bottom;
    
    return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

  };
    
})(jQuery);

/******************************************************************************/

(function( $ ) {
    'use strict';

	var vendorScriptsUrl = oshineModulesConfig.vendorScriptsUrl,
		dependencies = oshineModulesConfig.dependencies || {};

    // asyncloader.register( vendorScriptsUrl+'backgroundcheck.js', 'backgroundcheck' );
    // asyncloader.register( vendorScriptsUrl+'backgroundposition.js', 'backgroundposition' );
    // asyncloader.register( vendorScriptsUrl+'countdown.js', 'countdown' );
    // asyncloader.register( vendorScriptsUrl+'easing.js', 'easing' );
    // asyncloader.register( vendorScriptsUrl+'easypiechart.js', 'easypiechart' );
    // asyncloader.register( vendorScriptsUrl+'fitvids.js', 'fitvids' );
    // asyncloader.register( vendorScriptsUrl+'fullscreenheight.js', 'fullscreenheight' );
    // asyncloader.register( vendorScriptsUrl+'hoverdir.js', 'hoverdir' );
    // asyncloader.register( vendorScriptsUrl+'isotope.js', 'isotope' );
    // asyncloader.register( vendorScriptsUrl+'justifiedgallery.js', 'justifiedgallery' );
    // asyncloader.register( vendorScriptsUrl+'magnificpopup.js', 'magnificpopup' );
    // asyncloader.register( vendorScriptsUrl+'mousewheel.js', 'mousewheel' );
    // asyncloader.register( vendorScriptsUrl+'owlcarousel.js', 'owlcarousel' );
    // asyncloader.register( vendorScriptsUrl+'photoswipe.js', 'photoswipe' );
    // asyncloader.register( vendorScriptsUrl+'resizetoparent.js', 'resizetoparent' );
    // asyncloader.register( vendorScriptsUrl+'rotate.js', 'rotate' );
    // asyncloader.register( vendorScriptsUrl+'typed.js', 'typed' );
    // asyncloader.register( vendorScriptsUrl+'waypoints.js', 'waypoints' );
    // asyncloader.register( vendorScriptsUrl+'imagesloaded.js', 'imagesloaded' );  
    // asyncloader.register( vendorScriptsUrl+'beslider.js', 'beslider' );    
    // asyncloader.register( vendorScriptsUrl+'vivusSVGanimation.js', 'vivusSVGanimation' );    
    // asyncloader.register( vendorScriptsUrl+'tilt.js', 'tilt' );

	if( 'undefined' != typeof dependencies ) {
		for( var dependency in dependencies ) {
			if( dependencies.hasOwnProperty( dependency ) ) {
				asyncloader.register( dependencies[ dependency ], dependency );
			}
		}
	}

    var directionalHover = function( element ) {	    
    	 asyncloader.require( 'hoverdir', function() {
    	 	var elementInner = element.find( '.element-inner' );
            if( element.hasClass('style3-hover') ) {
                elementInner.each(function () {
                    jQuery(this).hoverdir();
                });
            } else if( element.hasClass('style4-hover') ) {
                elementInner.each(function () {
                    jQuery(this).hoverdir({
                        inverse: true
                    });
                });                   
            }
        });
    };

   var photoswipe =  function( gallerySelector ) {

            asyncloader.require( 'photoswipe', function() {

                    var parseThumbnailElements = function(el) {
                        var items = [],
                            el,
                            childElements,
                            thumbnailEl,
                            size,
                            item;

                        var anchor = jQuery(el).find('a.thumb-wrap');
                        anchor.each( function() {
                            size = jQuery(this).attr('data-size').split('x');
                            item = {
                                src: jQuery(this).attr('href'),
                                w: parseInt(size[0], 10),
                                h: parseInt(size[1], 10),
                                author: jQuery(this).attr('data-author')
                            };
                            item.title = jQuery(this).attr('title');
                            item.el = jQuery(this);
                            item.o = {
                                src: item.src,
                                w: item.w,
                                h: item.h
                            };

                            items.push(item);
                        });
                        return items;
                    };

                    // find nearest parent element
                    var closest = function closest(el, fn) {
                        return el && ( fn(el) ? el : closest(el.parentNode, fn) );
                    };

                    var onThumbnailsClick = function(e) {
                        e = e || window.event;
                        e.preventDefault ? e.preventDefault() : e.returnValue = false;

                        var eTarget = e.target || e.srcElement;

                        if(!clickedListItem) {
                            return;
                        }

                        var clickedGallery = clickedListItem.parentNode;

                        var childNodes = clickedListItem.parentNode.childNodes,
                            numChildNodes = childNodes.length,
                            nodeIndex = 0,
                            index;

                        for (var i = 0; i < numChildNodes; i++) {
                            if(childNodes[i].nodeType !== 1) { 
                                continue; 
                            }

                            if(childNodes[i] === clickedListItem) {
                                index = nodeIndex;
                                break;
                            }
                            nodeIndex++;
                        }

                        if(index >= 0) {
                            openPhotoSwipe( index, clickedGallery );
                        }
                        return false;
                    };

                    var photoswipeParseHash = function() {
                        var hash = window.location.hash.substring(1),
                        params = {};

                        if(hash.length < 5) { // pid=1
                            return params;
                        }

                        var vars = hash.split('&');
                        for (var i = 0; i < vars.length; i++) {
                            if(!vars[i]) {
                                continue;
                            }
                            var pair = vars[i].split('=');  
                            if(pair.length < 2) {
                                continue;
                            }           
                            params[pair[0]] = pair[1];
                        }

                        if(params.gid) {
                            params.gid = parseInt(params.gid, 10);
                        }

                        if(!params.hasOwnProperty('pid')) {
                            return params;
                        }
                        params.pid = parseInt(params.pid, 10);
                        return params;
                    };

                    var openPhotoSwipe = function(index, galleryElement, disableAnimation) {

                        var pswpElement = document.querySelectorAll('.pswp')[0],
                            gallery,
                            options,
                            items,
                            history = true;

                        if( jQuery('body').hasClass('all-ajax-content') ){
                            history = false;
                        }

                        items = parseThumbnailElements(galleryElement); //Parse Demo Gallery
                        
                        // define options (if needed)
                        options = {
                            index: index,
                            history: history,
                            galleryUID: galleryElement.attr('data-pswp-uid'),

                            getThumbBoundsFn: function(index) {
                                // See Options->getThumbBoundsFn section of docs for more info
                                
                                var thumbnail = items[index].el.find('img')[0],
                                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                                    rect = thumbnail.getBoundingClientRect(); 

                                return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
                            },

                            addCaptionHTMLFn: function(item, captionEl, isFake) {

                                if(!item.title) {
                                    captionEl.children[0].innerText = '';
                                    return false;
                                }
                                captionEl.children[0].innerHTML = item.title; //+  '<br/><small>Photo: ' + item.author + '</small>';
                                return true;
                            }
                            
                        };

                        var radios = document.getElementsByName('gallery-style');
                        for (var i = 0, length = radios.length; i < length; i++) {
                            if (radios[i].checked) {
                                if(radios[i].id == 'radio-all-controls') {

                                } else if(radios[i].id == 'radio-minimal-black') {
                                    options.mainClass = 'pswp--minimal--dark';
                                    options.barsSize = {top:0,bottom:0};
                                    options.captionEl = false;
                                    options.fullscreenEl = false;
                                    options.shareEl = false;
                                    options.bgOpacity = 0.85;
                                    options.tapToClose = true;
                                    options.tapToToggleControls = false;
                                }
                                break;
                            }
                        }

                        if(disableAnimation) {
                            options.showAnimationDuration = 0;
                        }

                        // Pass data to PhotoSwipe and initialize it
                        gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);


                        
                        var realViewportWidth,
                            useLargeImages = false,
                            firstResize = true,
                            imageSrcWillChange;

                        gallery.listen('beforeResize', function() {

                            var dpiRatio = window.devicePixelRatio ? window.devicePixelRatio : 1;
                            dpiRatio = Math.min(dpiRatio, 2.5);
                            realViewportWidth = gallery.viewportSize.x * dpiRatio;


                            if(realViewportWidth >= 1200 || (!gallery.likelyTouchDevice && realViewportWidth > 800) || screen.width > 1200 ) {
                                if(!useLargeImages) {
                                    useLargeImages = true;
                                    imageSrcWillChange = true;
                                }
                                
                            } else {
                                if(useLargeImages) {
                                    useLargeImages = false;
                                    imageSrcWillChange = true;
                                }
                            }

                            if(imageSrcWillChange && !firstResize) {
                                gallery.invalidateCurrItems();
                            }

                            if(firstResize) {
                                firstResize = false;
                            }

                            imageSrcWillChange = false;

                        });

                        gallery.listen('gettingData', function(index, item) {
                            //if( useLargeImages ) {
                                item.src = item.o.src;
                                item.w = item.o.w;
                                item.h = item.o.h;
                            // } else {
                            //     item.src = item.m.src;
                            //     item.w = item.m.w;
                            //     item.h = item.m.h;
                            // }
                        });

                        gallery.init();

                    };



                    var galleryElements = jQuery(gallerySelector);
                    var i = 0;
                    galleryElements.each( function() {
                        var $this = jQuery(this);
                        $this.attr('data-pswp-uid',i+1);
                        $this.off('click');
                        $this.on('click', 'a.thumb-wrap', function(e) {
                            e.preventDefault();
                            openPhotoSwipe(jQuery(this).closest('.element').index(), $this );
                        });
                        i++;
                    });


                    // Parse URL and open gallery if it contains #&pid=3&gid=1
                    var hashData = photoswipeParseHash();
                    if(hashData.pid > 0 && hashData.gid > 0) {
                        openPhotoSwipe( hashData.pid - 1 ,  galleryElements.eq( hashData.gid - 1 ), true );
                    }
            });                 
    };    
     

     jQuery(document).ready( function() {

		var $window = jQuery( window ),
		$body = jQuery('body');
	    var oshine_modules = (function() {

	        var  ajax_url = jQuery( '#ajax_url' ).val(),
	        	 tatsuCallbacks = {},
	        	 testimonialCarousel,
                 portfolioElement = jQuery( '.element' ),
				 animatedChartsWrap = jQuery( '.chart' ),
				 skillsWrap = jQuery( '.be-skill' ),
				 svgModules = jQuery( '.oshine-svg-icon:not( .svg-line-animate )' ),
				 svgAnimateModules = jQuery( '.svg-line-animate' ),
				 svgAnimateModulesCount = svgAnimateModules.length,
				 alreadyVisibleIndex = 0,
				 scrollInterval,
				 didScroll = false,

	        countDown = function( shouldUpdate ) {
				var countdownWrap = jQuery( '.be-countdown' ),
					countdownScripts = ( oshineModulesConfig.dependencies.countdownLangFile ) ? [] : 'countdown';
	        	if( !shouldUpdate ) {
					if( countdownWrap.length > 0 ) {
						asyncloader.require( countdownScripts, function() { 
						    countdownWrap.each( function() {
						        var $this = jQuery(this);
						        var $date = parseDate( $this.attr( 'data-time' ) );   //moment( $this.data().time, 'YYYY-MM-DD HH:mm:ss').toDate();
						        $this.countdown({until: $date});
						    }); 
						});
					} 
				} else {
				    countdownWrap.each( function() {
				        var $this = jQuery(this);
				        var $date = parseDate( $this.attr( 'data-time' ) );   //moment( $this.data().time, 'YYYY-MM-DD HH:mm:ss').toDate();
				        $this.countdown( {until: $date} );
				    });					
				}        	
	        },


	        parseDate = function(dateAsString) {
			    return new Date(dateAsString.replace(/-/g, '/'))
			},
         

			iconGrid = function(shouldUpdate) {
                var iconGridWrap =  jQuery( '.grid-wrap' );				
				if( iconGridWrap.length > 0 ) {
				    iconGridWrap.each(function () {
                       //if( !jQuery(this).hasClass('changed') ) {
    				        var $this = jQuery(this), 
    				        	$col = Number( $this.attr( 'data-col' ) ), 
    				        	i,
    				        	$gridColumn = $this.find('.grid-col'),
    				        	$length = $gridColumn.length;

    				       // $this.addClass('changed');
    				        $gridColumn.css('width', 100 / $col + '%');
    				        $this.find('.grid-col:nth-of-type(' + $col + 'n)').css('border-right', 'none');
    				        for (i = 0; i < $length; i += $col) {
    				            $gridColumn.slice(i, i + $col).wrapAll("<div class='grid-row clearfix'></div>");
    				        }
    				        $this.find('.grid-row:last-child').find('.grid-col').css('border-bottom', 'none');
    				        $this.css('opacity', 1);
                        //}
				  });
				}
			    if(jQuery('.process-style1').length > 0) {
			        jQuery('.process-style1').each(function () {
			            jQuery(this).find('.process-divider:last-child').remove();
			        });
			    }	
			},

			animatedIconModule = function() {
	        	var  animatedIconModuleOne = jQuery( '.animate-icon-module-style1' ),
	        	 	 animatedIconModuleTwo = jQuery( '.animate-icon-module-style2-wrap' );
				if( animatedIconModuleOne.length > 0 ) {

			        animatedIconModuleOne.each(function () {
			            var $this = jQuery(this),
			            $gutter = Number( $this.closest('.animate-icon-module-style1-wrap').attr( 'data-gutter-width' ) ),
			            $width = Number( $this.closest('.animate-icon-module-style1-wrap-container').width() ),
			            $numberOfSiblings = $this.siblings().length,
			            $item_width = ( $width - ( $numberOfSiblings * $gutter ) );

			            $this.closest('.animate-icon-module-style1-wrap').width( $width );		            
			            $this.width( $item_width / ( $numberOfSiblings + 1 ) );
			            if ( $this.is(':last-child') ) {
			                $this.css('margin-right', '0px');
			            } else {
			                $this.css('margin-right', $gutter + 'px');
			            }
			            // $this.css('margin-bottom', $gutter + 'px');
			            $this.css( 'opacity', 1 );
			        });

				}

				if( animatedIconModuleTwo.length > 0 ) {

			       animatedIconModuleTwo.each(function(){

			            var $this = jQuery(this), 
			            $normal_content_height = 0, 
			            $hover_content_height = 0, 
			            $module_height = 0,
			            $max_module_height = 0,
			            i=1,
			            $animatedModule = $this.find('.animate-icon-module-style2');

			            // Find the Height of the Tallest Sibling
			            $animatedModule.each(function () {
			                var $this_module = jQuery(this);

			                $normal_content_height = Number( $this_module.find('.animate-icon-module-style2-normal-content').innerHeight() );
			                $hover_content_height = Number( $this_module.find('.animate-icon-module-style2-hover-content').innerHeight() );
			                $module_height = $normal_content_height + $hover_content_height;
			                
			                if( jQuery(window).width() <= 960 ){
			                    $this_module.closest('.animate-icon-module-style2-wrap').css('height', 'auto');
			                    $this_module.find('.animate-icon-module-style2-inner-wrap').css('height', $module_height + 115 + 'px');
			                } else{
			                    if( i == 1 ){
			                        $max_module_height = $module_height; 
			                    } else{
			                        if($module_height >= $max_module_height){
			                            $max_module_height = $module_height;    
			                        }
			                    }
			                    i = i+1;
			                }
			            });

			            if(jQuery(window).width() > 960){
			                $this.css('height', $max_module_height * 2 + 40 + 'px');
			                $this.find('.animate-icon-module-style2-inner-wrap').css('height', 'auto');
			            }
			            
			           $animatedModule.css( 'opacity', 1 );

			        });
				}

			},

			animatedCharts = function( shouldUpdate ) {
				//var animatedChartsWrap = jQuery( '.chart' );

				if( animatedChartsWrap.length > 0 ) {
					asyncloader.require( 'easypiechart', function() {
					    animatedChartsWrap.each(function (i) {
					        var $this = jQuery(this);
					        	//$options = $this.data();
					        if ( $this.visible(true) ) {
					           $this.easyPieChart({
					                animate : 1000,
					                barColor : $this.attr( 'data-bar-color' ), // $options.barColor,
					                trackColor : $this.attr( 'data-track-color' ), //$options.trackColor,
					                scaleColor : $this.attr( 'data-scale-color' ), // $options.scaleColor,
					                size : $this.attr( 'data-size' ), //$options.size,
					                lineWidth : $this.attr( 'data-line-width' ), //$options.lineWidth,
					                onStep : function (from, to, percent) {
					                    $this.find('.percentage').text(Math.round(percent));
					                }
					            });
					        }
					    });
					});
				}

			},

			progressBar = function() {
                var skillsContainer = skillsWrap.closest('.skill_container');

                if( skillsContainer.length > 0 ) {
                    skillsContainer.each(function () {
                        if( jQuery(this).hasClass('skill-vertical') ) {
                            var $width = (100 / jQuery(this).find('.skill-wrap').length) + '%';
                            jQuery(this).find('.skill-wrap').css('width', $width).css('display', 'block');
                        } else {
							jQuery(this).find('.skill-wrap').css( 'width', '100%' );
						}
                    });
                }


				if( skillsWrap.length > 0) {
				    skillsWrap.each(function (i) {
				        var $this = jQuery(this),
				        	$animate_property = 'width';
				        if ( $this.visible(true) ) {
				            if ( $this.closest('.skill_container').hasClass('skill-vertical') ) {
				                $animate_property = 'height';
				            }
				            $this.css( $animate_property, $this.attr( 'data-skill-value' ) );
				        }
				    });
				}

			},

			justifiedGallery = function() {
                var justifiedGalleryWrap = jQuery( '.justified-gallery' ),
                    itemsToLazyLoad = jQuery();
				if( justifiedGalleryWrap.length > 0 ){
                    var sequentialReveal = function(elements) {
                            if( null != elements && elements.length ) {
                                if( elements.closest('.justified-gallery').hasClass( 'none' ) ) {
                                    elements.find('.flip-img-wrap').addClass('img-loaded');
                                    return;
                                }
                                elements.each(function(index, element) {
                                    setTimeout(function() {
                                        jQuery(element).find('.flip-img-wrap').addClass('img-loaded');
                                    }, index * 200);
                                });
                            }
                        },
                        updateLazyLoadItems = function( elements ) {
                            itemsToLazyLoad = itemsToLazyLoad.add(elements);
                        },
                        lazyLoad = function() {
                            if( 0 < itemsToLazyLoad.length ) {
                                var visibleImages = itemsToLazyLoad.filter(function() {
                                    var $e = jQuery(this),
                                        wt = $window.scrollTop(),
                                        wb = wt + $window.height(),
                                        et = $e.offset().top,
                                        eb = et + $e.height();
                                    return eb >= wt - 200 && et <= wb + 200;
                                });
                                if( 0 < visibleImages.length ) {
                                    visibleImages.one( 'load', function() {
                                        $(this).closest( '.element' ).addClass('jg-entry-visible');
                                    }).each( function( el ) {
                                        var curEl = $(this)
										curEl.attr( 'srcset', curEl.attr( 'data-srcset' ) );
                                        curEl.attr( 'src', curEl.attr( 'data-src' ) );
                                    });
                                    itemsToLazyLoad = itemsToLazyLoad.not( visibleImages );
                                }
                            }
                        };
					asyncloader.require( [ 'justifiedgallery', 'waypoints', 'imagesloaded', 'photoswipe' ], function() {
					    justifiedGalleryWrap.each(function () {
                            var $this = jQuery(this),
                                $elements = $this.find('.element'),
							    $options = {};
							    $options.imageHeight = $this.attr( 'data-image-height' );
							    $options.gutterWidth = $this.attr( 'data-gutter-width' );

                            $this.on( 'jg.complete jg.resize', function( event ) {
                                lazyLoad();
                                $(this).closest( '.justified-gallery-outer-wrap' ).css( 'visibility', 'visible' );
                            } );
							$this.justifiedGallery({
								rowHeight : $options.imageHeight, 
								margins : $options.gutterWidth,
								lastRow : 'nojustify', 
                                waitThumbnailsLoad : false,
                                imgSelector : '.thumb-img'
							});
					        //$this.imagesLoaded(function () {

                            photoswipe( $this );

                            directionalHover( $elements );
                            sequentialReveal( $elements );
                            if( $this.attr('data-lazy-load') ) {
                                updateLazyLoadItems( $this.find( '.thumb-img' ) );
                            }
						});


						if(jQuery(".trigger_infinite_scroll.justified_gallery_infinite_scroll").length > 0 && !$body.hasClass('tatsu-frame')) {
				            jQuery(".trigger_infinite_scroll.justified_gallery_infinite_scroll").each(function () {
				                var $this = jQuery(this),
				                $justified_gallery_wrap = $this.closest('.justified-gallery-inner-wrap'),
				                $justified_gallery = $justified_gallery_wrap.find('.justified-gallery'),
				               // $options = $justified_gallery_wrap.data(),
				                $paged = Number( $justified_gallery_wrap.attr('data-paged') ),
				                $ajaxData = "action=" + $justified_gallery_wrap.attr('data-action') + 
                                            //"&source=" + $justified_gallery_wrap.attr('data-source') + 
                                            "&images_arr=" + $justified_gallery_wrap.attr('data-images-array') + 
                                            "&items_per_load=" + $justified_gallery_wrap.attr('data-items-per-load') + 
                                            "&lazy_load=" + ( $justified_gallery_wrap.attr('data-lazy-load') || '0' ) + 
                                            "&hover_style=" + $justified_gallery_wrap.attr('data-hover-style') + 
                                            "&img_grayscale=" + $justified_gallery_wrap.attr('data-image-grayscale') + 
                                            "&image_effect=" + $justified_gallery_wrap.attr('data-image-effect') + 
                                            "&thumb_overlay_color=" + $justified_gallery_wrap.attr('data-thumb-overlay-color') + 
                                            "&gradient_style_color=" + $justified_gallery_wrap.attr('data-grad-style-color') + 
                                            "&like_button=" + $justified_gallery_wrap.attr('data-like-button') + 
                                            "&disable_overlay=" + $justified_gallery_wrap.attr('data-disable-overlay');

				                var be_waypoint = new Waypoint({
				                    element: $this,
				                    handler: function (direction) {
				                        if (direction === 'down') {
				                            var $this_waypoint = this,
				                            	$page_loader = jQuery('.page-loader');
				                            $this_waypoint.disable(); //Disable Waypoint untill Images are Loaded
				                            $page_loader.fadeIn();
				                            jQuery.ajax({
				                                type: "POST",
				                                url: ajax_url,
				                                data: $ajaxData + "&paged=" + $paged                                                ,
				                            }).done(function (data) {
				                                if ( '0' != data ) {
				                                    var $newItems = jQuery(data);
                                                        $justified_gallery.on('jg.complete jg.resize', function () {
                                                            Waypoint.refreshAll();    
                                                            $this_waypoint.enable(); //Enable Waypoint 
                                                        } );
		
				                                        $justified_gallery.append($newItems).justifiedGallery('norewind');
                                                        sequentialReveal($newItems);
                                                        if( $justified_gallery.attr('data-lazy-load') ) {
                                                            updateLazyLoadItems($newItems.find('.thumb-img'));
                                                        }
                                                        $paged = Number($paged) + 1;
                                                        $justified_gallery_wrap.attr('data-paged', $paged);
				                                        $page_loader.fadeOut();

				                                } else {
				                                    $this_waypoint.destroy();
				                                    $this.fadeOut();
				                                    $page_loader.fadeOut();
				                                }
				                            });
				                       }
				                    }, 
				                    offset: 'bottom-in-view'
				                })

				            });
                        }
                        $window.on('scroll', function() {
                            lazyLoad();
                        })
				    });
			    }	
			},

			like = function() {
				jQuery(document).on('click', '.gallery-like .custom-like-button', function (e) {
					var $this = jQuery(this), $post_id = $this.attr('data-post-id');
					// $this.addClass('disable');
					jQuery.ajax({
						
						type: "POST",
						url: ajax_url,
						dataType: 'json',
						data: "action=post_like&post_id=" + $post_id,
						success : function (msg) {
							if (msg.status === "success") {
								if( msg.type === "like" ){
									$this.addClass('liked');
									$this.removeClass('no-liked');
									$this.find('span').text(msg.count);
								}else{
									$this.removeClass('liked');
									$this.addClass('no-liked');
									$this.find('span').text(msg.count);
								}
							}
						},
						error: function (msg) {
							alert(msg);
						}
					});
					return false;
				});
			},

			accordion = function( shouldUpdate ) {

				var accordionWrap = jQuery( '.accordion' );				
				if( !shouldUpdate ) {
					if( accordionWrap.length > 0 ) {
						accordionWrap.each(function () {
							var $accordion = jQuery(this), 
							$collapse = Number( $accordion.attr('data-collapsed') );
							$accordion.accordion({
								collapsible: $collapse,
								heightStyle: "content",
								active: false
							}).css('opacity', 1);			        

						});
					}						
				}else {
					if( 0 < accordionWrap.length ) {
						accordionWrap.each( function() {

							var accordion = jQuery( this ),
								collapse = Number( accordion.attr( 'data-collapsed' ) );
								if( collapse ) {
									accordion.accordion( "option", "collapsible", true );
								}else{
									accordion.accordion( "option", "collapsible", false );
								}
								accordion.accordion( "refresh" );

						} );
					}
				}

			},

			tabs = function( shouldUpdate ) {
				var tabsWrap = jQuery( '.tabs' );
				if( !shouldUpdate ) {
					if(tabsWrap.length > 0) {
						tabsWrap.tabs({
							fx : {
								opacity : 'toggle',
								duration : 200
							}
						}).css('opacity', 1);
					}
				}else{
					if( 0 < tabsWrap.length ) {
						tabsWrap.tabs( "refresh" );
					}
				}
	
			},

			services = function() {

				 jQuery(document).on('mouseenter.oshine mouseleave.oshine', '.service-wrap', function (e) {
				 	var $this = jQuery(this),
				 		$icon = $this.find('.font-icon'),
				 		$options = {};
				 		
	                $options.hoverColor = $this.attr( 'data-hover-color' );
	                $options.hoverBgColor = $this.attr( 'data-hover-bg-color' );
	                $options.bgColor = $this.attr( 'data-bg-color' );
	                $options.color = $this.attr( 'data-color' );
	                	
				 	if( 'mouseenter' == e.type ) {
				 		$icon.css({
				 			'background-color': $options.hoverBgColor,
				 			'color': $options.hoverColor
				 		});
				 	} else {
				 		$icon.css({
				 			'background-color': $options.bgColor,
				 			'color': $options.color
				 		});
				 	}
				 });
			},

            clientCarousel = function( shouldUpdate ) {
                var clientsWrap = jQuery( '.client-carousel-module' );
                if( shouldUpdate ) {                  
                    clientsWrap.each( function() {
                        jQuery(this).trigger( 'destroy.owl.carousel' );
                        jQuery(this).find( '.owl-stage-outer' ).children().unwrap();
                    });                           
                } else{
                    if(clientsWrap.length > 0 ){
                        asyncloader.require( [ 'owlcarousel', 'imagesloaded' ], function(){
                            clientsWrap.imagesLoaded(function () {
                                clientsWrap.each(function () {
                                    var $this = jQuery(this),
                                        $slideshowspeed = Number( $this.attr('data-slide-show-speed') ) , 
                                        $slideshow = Number( $this.attr( 'data-slide-show' ) ),
                                        $nav_dots = Number( $this.attr( 'data-slide-navigation-dots' ) ),
                                        $item_number = $this.children('.client-carousel-item').length,
                                        $wrap = $this.closest('.carousel-wrap');

                                    if($item_number > 5){
                                        $item_number = 5;
                                    }

                                    if( 0 == $slideshow ){
                                        $slideshow = false;
                                    } else {
                                        $slideshow = true;
                                    }

									if( 0 == $nav_dots ){
                                        $nav_dots = false;
                                    } else {
                                        $nav_dots = true;
                                    }

                                    if($item_number == 1){
                                        $this.fadeIn();
                                    }else{                    
                                        $this.owlCarousel({
                                            navSpeed: 500,
                                            autoplay: $slideshow,
                                            autoplayTimeout: $slideshowspeed,
                                            autoplaySpeed: 1000,
                                            autoplayHoverPause: true,
                                            loop: true,
                                            navRewind: false,
                                            nav: false,
                                            responsiveRefreshRate: 0,
                                            responsive: {
                                                0:{
                                                    items:2,
                                                    dots:$nav_dots
                                                },
                                                768:{
                                                    items:$item_number,
                                                    dots:$nav_dots
                                                }
                                            },
                                            onInitialize: function() {
                                                $this.fadeIn(500);
                                                $this.trigger('refresh.owl.carousel');
                                            },
                                        });
                                    }
                                    if( 0 == $wrap.css( 'opacity' ) ) {
                                        $wrap.css( { 'opacity' : '1', 'height' : 'auto', 'overflow' : 'initial' } );
                                    }                                   
                                });
                            });
                        });
                    }                    
                }
    
            },

			portfolioCarousel = function() {
				var portfolioCarouselWrap = jQuery( '.portfolio-carousel-module' );
				if( portfolioCarouselWrap.length > 0 ){
					asyncloader.require( [ 'owlcarousel', 'imagesloaded' ], function(){
					    portfolioCarouselWrap.imagesLoaded(function () {
					        jQuery('.portfolio-carousel-module').each(function () {
					            var $this = jQuery(this),
							        $slideshowspeed = Number( $this.attr('data-slide-show-speed') ) , 
							        $slideshow = Number( $this.attr( 'data-slide-show' ) ),$number_of_cols = Number( $this.attr( 'data-cols' ) ),$mobile_cols = 2,			
									$autoplaySpeed = Number( $this.attr('data-slide-show-speed')),            
					            	$item_number = $this.children('.carousel-item').length;
								if(typeof $number_of_cols ==='undefined' || $number_of_cols == null || $number_of_cols == ''){
									$number_of_cols = 2;
								}
					            if($number_of_cols > 5){
					                $number_of_cols = 5;
					            }

					            if( 0 == $slideshow ) {
					                $slideshow = false;
					            } else {
					                $slideshow = true;
					            }				            
								if($number_of_cols == 1){
									$mobile_cols = 1;
					            }

					            if($item_number == 1){
					                $this.fadeIn();
					            }else{
					                $this.owlCarousel({
					                    autoplay: $slideshow,
					                    autoplayTimeout: $slideshowspeed,
					                    autoplaySpeed: $autoplaySpeed, 
					                    autoplayHoverPause: true,
					                    navRewind: false,
										loop: true,
					                    navText: ['<i class="font-icon icon-arrow_carrot-left"></i>','<i class="font-icon icon-arrow_carrot-right"></i>'],
					                    responsiveRefreshRate: 0,
					                    responsive: {
					                        0:{
					                            items:$mobile_cols,
					                            dots:true,
					                            nav: false
					                        },
					                        767:{
					                            items:$number_of_cols,
					                            dots:false,
					                            nav: true
					                        }
					                    },
					                    onInitialize: function() {
					                        $this.fadeIn(500);
					                        $this.trigger('refresh.owl.carousel');
					                    }
					                });
									
					            }
					        });
					    });
					});
				}
			},

            imageSlider = function( shouldUpdate ) {
                var imageSliderWrap = jQuery( '.be_image_slider' );
                if( shouldUpdate ) {
                    var $owl = imageSliderWrap.find( '.image_slider_module' );
                    $owl.each( function() {
                        jQuery(this).trigger('destroy.owl.carousel');   
                        jQuery(this).find( '.owl-stage-outer' ).children().unwrap();                                
                    });
                } else {
                   if( imageSliderWrap.length > 0 ) {
                        asyncloader.require( [ 'owlcarousel', 'imagesloaded' ], function(){
                            imageSliderWrap.imagesLoaded(function () {
                                jQuery('.be_image_slider').each(function () {
                                    var $this = jQuery(this).find('.image_slider_module'), 
										closestPortfolio = $this.closest( '.portfolio' ),
                                        $slideshowspeed = Number( $this.attr('data-slide-show-speed') ) , 
                                        $slideshow = Number( $this.attr( 'data-slide-show' ) ),
                                        $number = $this.find('.be_image_slide').length,
                                        $wrap = $this.closest('.be_image_slider');  

                                    if( 0 == $slideshow ) {
                                        $slideshow = false;
                                    } else {
                                        $slideshow = true;
                                    }

                                    if( $number == 1 ) {
                                        $this.fadeIn();
                                    } else {         
										$this.on( 'initialized.owl.carousel', function( event ) {

											var portfolioInstance;
											if( 0 < closestPortfolio.length ) {
												portfolioInstance = closestPortfolio.data( "oshinePortfolio" );
												setTimeout( function() {
													portfolioInstance.portfolioContainer.isotope( 'layout' );
												}, 100 ) ;
											}

										} );                             
                                        $this.owlCarousel({
                                            items:1,
                                            autoHeight: true,
                                            autoplay: $slideshow,
                                            autoplayTimeout: $slideshowspeed, 
                                            autoplaySpeed: 1000,
                                            autoplayHoverPause: true,
                                            navRewind: false,
                                            nav: true,
                                            loop: true,
                                            navText: ['<i class="font-icon icon-arrow_carrot-left"></i>','<i class="font-icon icon-arrow_carrot-right"></i>'],
                                            dots: ( 0 < closestPortfolio.length ) ? false : true,
                                            onInitialize: function() {
                                                $this.fadeIn(500);
                                                $this.trigger('refresh.owl.carousel');
                                            }
                                        });
										$this.on( "translated.owl.carousel", function( event ) {

											var portfolioInstance;
											if( 0 < closestPortfolio.length ) {
												portfolioInstance = closestPortfolio.data( "oshinePortfolio" );
												setTimeout( function() {
													portfolioInstance.portfolioContainer.isotope( 'layout' );
												}, 250 );
											}

										} )
                                    }
                                    if( '0' == $wrap.css( 'opacity' ) ) {
                                        $wrap.css( { 'opacity' : '1', 'height' : 'auto', 'overflow' : 'initial' } );
                                    }                                    
                                });
                            });
                        });
                    }

                }
            },

            testimonials = function( shouldUpdate ) {
                    var testimonialsWrap = jQuery( '.testimonials-slides' );
                    if( shouldUpdate ) {
                        var $owl = testimonialsWrap.find('.testimonial_module');
                        $owl.each( function() {
                            jQuery(this).trigger('destroy.owl.carousel');   
                            jQuery(this).find( '.owl-stage-outer' ).children().unwrap();                                
                        });
                    } else{
                        if ( testimonialsWrap.length > 0 ) {
                            asyncloader.require( [ 'owlcarousel', 'imagesloaded' ], function(){             
                                testimonialsWrap.imagesLoaded(function () {
                                    jQuery('.testimonials-slides').each(function () {
                                        
                                        var $slide = jQuery(this),
                                            $this = jQuery(this).find('.testimonial_module'), 
                                            $slideshowspeed = Number( $this.attr('data-slide-show-speed') ) , 
                                            $slideshow = Number( $this.attr( 'data-slide-show' ) ),
                                            $pagination = Number( $this.attr('data-pagination') ),
                                            $number = $slide.find('.testimonial_slide').length,
                                            $wrap = $this.closest('.testimonials_wrap');  

                                        if( 0 == $slideshow ) {
                                            $slideshow = false;
                                        } else {
                                            $slideshow = true;
                                        }

                                        if($pagination == 0){
                                            $pagination = false;
                                        }else{
                                            $pagination = true;
                                        }
                                        
                                        if($number == 1){
                                            $slide.fadeIn();                                           
                                        }else{
                                            testimonialCarousel =  $this.owlCarousel({
                                                items: 1 ,
                                                autoHeight: true,
                                                autoplay: $slideshow,
                                                autoplayTimeout: $slideshowspeed,
                                                autoplaySpeed: 1000,
                                                autoplayHoverPause: true,
                                                navRewind: false,
                                                loop: true,
                                                dots: $pagination,
                                                onInitialize: function() {
                                                    $slide.fadeIn();
                                                    $this.trigger('refresh.owl.carousel');
                                                }
                                            });

                                        }
                                        
                                        if( $wrap[0].style.opacity == '0' ) {
                                            $wrap.css({'opacity':'1', 'height' : 'auto','overflow' :'initial' });
                                        }                                        
                                    });
                                });
                            });
                        }                      
                    }
            },

			tweets = function() {
				var tweetsWrap = jQuery( '.tweet-slides' );
				if ( tweetsWrap.length > 0 ) {
					asyncloader.require( [ 'owlcarousel', 'imagesloaded' ], function(){
					    tweetsWrap.each(function () {
					        var $slide = jQuery(this),
					        $this = jQuery(this).find('.twitter_module'), 
					        $slideshowspeed = Number( $this.attr('data-slide-show-speed') ) , 
					        $slideshow = Number( $this.attr( 'data-slide-show' ) ),
					        $pagination = Number( $this.attr('data-pagination') ),
					        $number = $this.children('.tweet_list').length;

				            if( 0 == $slideshow ){
				                $slideshow = false;
				            } else{
				                $slideshow = true;
				            }

					        if($pagination == 0){
					            $pagination = false;
					        }else{
					            $pagination = true;
					        }

					        if($number == 1){
					            $slide.fadeIn();
					        }else{
					            $this.owlCarousel({
					                items:1,
					                autoHeight: true,
					                autoplay: $slideshow,
					                autoplayTimeout: $slideshowspeed,
					                autoplaySpeed: 1000,
					                autoplayHoverPause: true,
					                navRewind: false,
					                loop: true,
					                dots: $pagination,
					                onInitialize: function () {
					                    $slide.fadeIn();
					                    $this.trigger('refresh.owl.carousel');
					                }
					            });  
					        }
					    });
					});
				}	
			},

            contentSlider = function( shouldUpdate ) {
                var contentSliderWrap = jQuery( '.content-slider' );
                if( shouldUpdate ) {
                    contentSliderWrap.each( function() {
                        var $owl = jQuery(this).find('.content_slider_module');
                        $owl.trigger( 'destroy.owl.carousel' );
                        $owl.find( '.owl-stage-outer' ).children().unwrap();                        
                    });
                } else {
                    if ( contentSliderWrap.length > 0 ) {
                        asyncloader.require( [ 'owlcarousel', 'imagesloaded' ], function(){
                            contentSliderWrap.imagesLoaded(function () {
                                contentSliderWrap.each(function () {
                                    var $slide = jQuery(this),
                                        $this = jQuery(this).find('.content_slider_module'), 
                                        $slideshowspeed = Number( $this.attr('data-slide-show-speed') ) , 
                                        $slideshow = Number( $this.attr( 'data-slide-show' ) ),
                                        $item_number = $this.children('.content_slide').length;
                                    
                                    if( 0 == $slideshow ){
                                        $slideshow = false;
                                    } else{
                                        $slideshow = true;
                                    }

                                    if($item_number == 1){
                                        $slide.fadeIn();
                                    }else{
                                        $this.owlCarousel({
                                            items:1,
                                            autoHeight: true,
                                            autoplay: $slideshow,
                                            autoplayTimeout: $slideshowspeed,
                                            autoplaySpeed: 1000,
                                            autoplayHoverPause: true,
                                            navRewind: false,
                                            loop: true,
                                            dots: true,
                                            onInitialize: function () {
                                                $slide.fadeIn();
                                                $this.trigger('refresh.owl.carousel');
                                            }
                                        });
                                    }
                                    if( 0 == $this.closest( '.content-slide-wrap' )[0].style.opacity ) {
                                        $this.closest('.content-slide-wrap').css( { 'opacity' : '1', 'overflow' : 'initial', 'height' : 'auto' } );
                                    }                                   
                                });
                            });
                        });
                    }
                }
            },

			owlButtons = function() {
				 jQuery(document).on('mouseenter.oshine mouseleave.oshine', '.owl-carousel', function (e) {
				 	var $owlButtons = jQuery(this).find('.owl-buttons');
				 	if( 'mouseenter' == e.type ){
				 		$owlButtons.css( 'opacity', 1 );
				 	} else {
				 		$owlButtons.css( 'opacity', 0 );
				 	}
				 });
			},

			textRotate = function() {
				var rotatesWrap = jQuery( '.rotates' );
				if( rotatesWrap.length > 0 ) {
					asyncloader.require( 'rotate', function(){				
					    rotatesWrap.each(function () {
					    	var $this = jQuery(this),
					    		$options = $this.data();

					        $this.textrotator({
					            animation : $options.animation,
					            separator : "||",
					            speed : $options.speed
					        }).css('opacity', 1);
					    });
					});
				}	
			},

			typedText = function() {
				var typedWrap = jQuery( '.typed' );
				if( typedWrap.length > 0 ) {
					asyncloader.require( 'typed', function(){				
					    typedWrap.each(function () {
					        var $this = jQuery(this), 
					        	$typed_text = $this.text(), 
					        	$typed_text_arr = $typed_text.split('||');
					        $this.empty().typed({
					            strings: $typed_text_arr,
					            typeSpeed: 30,
					            backDelay: 500,
					            loop: true,
					            loopCount: false
					        }).css('opacity', 1);
					    });
					});
				}
			},

			contact = function() {
		        jQuery(document).on('click.oshine', '.contact_submit', function () {
					console.log( 'contact form clicked' );
					var $this = jQuery(this),
						$contact_form =  $this.closest('.contact_form'),
		            	$contact_status = $contact_form.find(".contact_status"), 
						$contact_loader = $contact_form.find(".contact_loader"),
						consent_checkbox = $contact_form.find('.consent-checkbox'),
						isConsentGiven = !consent_checkbox.length || consent_checkbox.prop('checked') ? true: false;
					if( !isConsentGiven ) {
						$contact_status.removeClass("tatsu-success").addClass("tatsu-error");
						$contact_status.html( $contact_form.attr('data-consent-error') ).slideDown();
						return false;
					}	
					$contact_loader.fadeIn();

					jQuery.ajax({
						type: "POST",
						url: ajax_url,
						dataType: 'json',
						data: "action=contact_authentication&" + jQuery(this).closest(".contact").serialize(),
						success    : function (msg) {
							$contact_loader.fadeOut();
							if (msg.status === "error") {
								$contact_status.removeClass("tatsu-success").addClass("tatsu-error");
							} else {
								$contact_status.addClass("tatsu-success").removeClass("tatsu-error");
							}
							$contact_status.html(msg.data).slideDown();
						},
						error: function () {
							$contact_status.html("Please Try Again Later").slideDown();
						}
					});
		            return false;
		        }); 			
			},

            mailchimp = function() {
                jQuery(document).on('click.oshine', '.oshine-mc-submit', function () {
					var $this = jQuery(this),
						$subscription_form = $this.closest('.oshine-mc-wrap'), 
                        $subscribe_status = $subscription_form.find(".subscribe_status"), 
						$subscribe_loader = $subscription_form.find(".subscribe_loader"),
						consent_checkbox = $subscription_form.find('.consent-checkbox'),
						isConsentGiven = !consent_checkbox.length || consent_checkbox.prop('checked') ? true: false;
					if( !isConsentGiven ) {
						$subscribe_status.removeClass("tatsu-success").addClass("tatsu-error");
						$subscribe_status.html( $subscription_form.attr('data-consent-error') ).slideDown();
						return false;
					}
					$subscribe_loader.fadeIn();
                    jQuery.ajax({
                        type: "POST",
                        url: ajax_url,
                        dataType: 'json',
                        data: "action=mailchimp_subscription&" + jQuery(this).closest(".oshine-mc-form").serialize(),
                        success : function (msg) {
                            $subscribe_loader.fadeOut();
                            if (msg.status === "error") {
                                $subscribe_status.removeClass("tatsu-success").addClass("tatsu-error");
                            } else {
                                $subscribe_status.addClass("tatsu-success").removeClass("tatsu-error");
                            }
                            $subscribe_status.html(msg.data).slideDown();
                        },
                        error: function () {
                            $subscribe_status.html("Please Try Again Later").slideDown();
                            $subscribe_loader.fadeOut();
                        }
                    });
                    return false;
                }); 
            },

			svgLineAnimate = function(shouldUpdate,moduleId) {
				asyncloader.require( 'vivusSVGanimation', function() {
					//SVG animate front-end
					if( svgAnimateModules.length > 0 ) {
						svgAnimateModules.each(function (i, el) {
							var el = jQuery( el );
							var svgObject = el.find( 'svg' )[0],
								pathTimingFunction = el.attr( 'data-path-animation' ),
								animTimingFunction = el.attr( 'data-svg-animation' ),
								duration = el.attr( 'data-animation-duration' ),
								delay = el.attr( 'data-animation-delay' );
							new Vivus(
									svgObject, 
									{
										duration: duration,
										pathTimingFunction	: Vivus[pathTimingFunction],
										animTimingFunction	: Vivus[animTimingFunction],
										delay : delay,
										onReady: function() {
											el.css( 'visibility', 'visible' );
										}
									}, 
									function() {
										console.log('Svg Animated');	
								}); 
						});
					}
					//SVG animate in tatsu
					 var svgAnimatesInTatsu = jQuery('.oshine-svg-icon span');
					  if(svgAnimatesInTatsu.length > 0){
					 	svgAnimatesInTatsu.each(function(index,element){
							var element = jQuery(element).parent();
							 if(!moduleId || element.parent().hasClass('be-pb-observer-'+moduleId)){
							 var svgObject1 = element.attr( 'data-target' ),
								 pathTimingFunction = element.attr( 'data-path-animation' ),
								 animTimingFunction = element.attr( 'data-svg-animation' ),
								 duration = element.attr( 'data-animation-duration' ),
								 delay = element.attr( 'data-animation-delay' ),
								 fileUrl = element.attr( 'data-svg-url');
					 			element.children().empty();
					 		 new Vivus(svgObject1, {
									  file:fileUrl,
									  duration: duration,
									  pathTimingFunction	: Vivus[pathTimingFunction],
									  animTimingFunction	: Vivus[animTimingFunction],
									  delay : delay,
									  onReady: function() {
										element.css( 'visibility', 'visible' );
									}
									}, 
					 			function() {
					 				console.log('Svg Animated');	
					 		}); 
							 } 
						});
					}
				
				});
			},

			registerCallbacks = function() {
				tatsuCallbacks['be_countdown'] = countDown;
				tatsuCallbacks['chart'] = animatedCharts;
				tatsuCallbacks['typed'] = typedText;
				tatsuCallbacks['accordion'] = accordion;
				tatsuCallbacks['tabs'] = tabs;
				tatsuCallbacks['justified_gallery'] = justifiedGallery;
				tatsuCallbacks['clients'] = clientCarousel;
				tatsuCallbacks['portfolio_carousel'] = portfolioCarousel;
				tatsuCallbacks['testimonials'] = testimonials;
				tatsuCallbacks['tweets'] = tweets;
				tatsuCallbacks['content_slides'] = contentSlider;
				tatsuCallbacks['flex_slider'] = imageSlider;
				tatsuCallbacks['rotates'] = textRotate;
				tatsuCallbacks['skills'] = progressBar;
				tatsuCallbacks['animate_icons_style1'] = animatedIconModule;
				tatsuCallbacks['animate_icons_style2'] = animatedIconModule;
				tatsuCallbacks['services'] = services;	
                tatsuCallbacks['recent_posts'] = imageSlider;
                tatsuCallbacks['grids'] = iconGrid;    	
				tatsuCallbacks[ 'oshine_svg_icon' ] = svgLineAnimate;

			},

			ready = function() {  

                if( !jQuery('body').hasClass('tatsu-frame') && ( jQuery('.component').length > 0 || jQuery('#ps-container').length > 0 ) ) {
                    asyncloader.require( [ 'resizetoparent', 'mousewheel' ], function() {
                            asyncloader.require( 'beslider', function() {
                        });
                    });
                }                      

				countDown();
				iconGrid();
				animatedIconModule();
				animatedCharts();
				progressBar();
				justifiedGallery();
				like();
				accordion();
				tabs();
				services();
				clientCarousel();
				portfolioCarousel();
				imageSlider();
				testimonials();
				tweets();
				contentSlider();
				owlButtons();
				textRotate();
				typedText();
				contact();
				mailchimp();
			//	svgInitialRender();				
				svgLineAnimate();
				
				registerCallbacks();

			},
			
			run = function() {

				ready();

				jQuery(window).on( 'tatsu_update.oshine', function( e, data )  {
                   // cssAnimate();
				 	animatedChartsWrap = jQuery( '.chart' );
					skillsWrap = jQuery( '.be-skill' );		 
					if( 'trigger_ready' == data.moduleName ) {
						ready();
					} else if( data.moduleName in tatsuCallbacks ) {					
						tatsuCallbacks[data.moduleName]( data.shouldUpdate, data.moduleId );	
                        if( jQuery('.be-photoswipe-gallery').length > 0 ) {
                            photoswipe( '.be-photoswipe-gallery' );
                        }										
					}
				});

				jQuery(window).resize( function() {
					animatedIconModule();
				});

				jQuery(window).on( 'scroll', function(){
					didScroll = true;
				});

				// scrollInterval = setInterval( function() {
				// 	if( didScroll ) {
				// 		didScroll = false;
				// 		svgLineAnimate();
				// 	}
				// }, 50);

				if( animatedChartsWrap.length > 0 || $body.hasClass('tatsu-frame') ) {
					jQuery(window).on('scroll', function(){
						animatedCharts();
					});
				}
				
				if( skillsWrap.length > 0 || $body.hasClass('tatsu-frame') ) {
					jQuery(window).on('scroll', function(){
						progressBar();
					});
				}

				jQuery(document).on( 'update_content', function(){
					jQuery(document).off( 'mouseenter.oshine mouseleave.oshine scroll.oshine click.oshine', '**' );
					ready();				
				});
			}

			return {
				run: run
			}

	    })();
	    var oshine_portfolio = (function() {

	            var ajax_url = jQuery('#ajax_url').val(),
	                vendorScriptsUrl = oshineModulesConfig.vendorScriptsUrl,
	                portfolio = jQuery('.portfolio'),
                    portfolioWithDelayLoadCount = jQuery( '.portfolio.portfolio-delay-load' ).length,
                    portfolioWithLazyLoadCount = jQuery( '.portfolio.portfolio-lazy-load' ).length,
                    initializedPortfolioWithDelayCount = 0,
					portfolios = jQuery( '.portfolio' ),
                    initializedPortfolioWithLazyCount = 0,
	                portfolioContainer = jQuery('.portfolio-container'),
	                element = portfolioContainer.find('.element'),
	                elementInner = element.find('.element-inner'),
	                trigger = jQuery('.trigger_infinite_scroll'),

                    portfolioScrollReveal = (function() {
                        var delayLoadElements = jQuery( '.portfolio.portfolio-delay-load' ).find( '.element' );
                        if( 0 < delayLoadElements.length ) {
                            delayLoadElements.on( 'webkitAnimationStart oanimationstart msAnimationStart animationstart', function( event ) {

								if( jQuery( event.target ).hasClass( 'element' ) ) {
									var el = jQuery( this );
                                	el.addClass( 'end-animation' );
								}

                            } );
                            delayLoadElements.on( 'webkitAnimationEnd oanimationend msAnimationEnd animationend', function( event ) {

                                var el = jQuery( this );
                                el.addClass( 'animation-complete' );

                            } );
                        }
                        return {
                            delayReveal : function( elements ) {

											
											var portfolioDelay = 200,
												visibleElements;
											if( null == elements ) {
                                                visibleElements = delayLoadElements.filter( function( i, el ) {

                                                    return ( jQuery( el ).visible( true ) && jQuery( el ).is( ":visible" ) && ( window.innerHeight - el.getBoundingClientRect().top > 30 ) );

												} );
											}else {
												visibleElements = elements.filter( function( i, el ) {

                                                    return ( jQuery( el ).visible( true ) && jQuery( el ).is( ":visible" ) && ( window.innerHeight - el.getBoundingClientRect().top > 30 ) );

												} );
											}
                                            visibleElements.each( function( i , el ) {

                                                var el = jQuery( el );
                                                el.addClass( "already-visible delay-loaded" );												
                                                el.css( 'animation-delay', portfolioDelay + 'ms' );
                                                portfolioDelay = portfolioDelay + 200;
                                                el.addClass( el.closest( '.portfolio' ).attr( "data-animation" ) );

                                            } );
                                            delayLoadElements = delayLoadElements.not( visibleElements );

                                        },
                            addElements : function( newElements, shouldAddListeners ) {

                                            delayLoadElements = delayLoadElements.add( newElements );
                                            if( 0 < newElements.length && !shouldAddListeners ) {
                                                newElements.on( 'webkitAnimationStart oanimationstart msAnimationStart animationstart', function( event ) {

													if( jQuery( event.target ).hasClass( 'element' ) ) {
														var el = jQuery( this );
														el.addClass( 'end-animation' );															
													}

                                                } );
                                            }

                                        }
                        }

                    })(),

                    portfolioLazyReveal = (function() {

                        var lazyLoadImages = jQuery( '.portfolio.portfolio-lazy-load' ).find( '.thumb-wrap' ).find( 'img' ) ,
                            $w = jQuery( window ),
                            th = 200,
                            $wh = $w.height(),
                         	reveal = function( elements ) {

								var visibleImages;
								if( null == elements ) { 
									visibleImages = lazyLoadImages.filter(function() {

										var $e = jQuery(this),
											wt = $w.scrollTop(),
											wb = wt + $wh,
											et = $e.offset().top,
											eb = et + $e.height();
										return eb >= wt - th && et <= wb + th;
									
									});
								}else {
									visibleImages = elements.filter(function() {

										var $e = jQuery(this),
											wt = $w.scrollTop(),
											wb = wt + $wh,
											et = $e.offset().top,
											eb = et + $e.height();
										return eb >= wt - th && et <= wb + th;
									
									});
								}
								visibleImages.each( function() {

									var el = jQuery( this );
									el.load( function() {

										el.css( "opacity", "1" );

									} )
									el.attr( 'src', el.attr( 'data-src' ) );

								} );
								lazyLoadImages = lazyLoadImages.not( visibleImages );

                        	},
							addElements = function( newElements ) {
								
								if( 0 < newElements.length ) {
									lazyLoadImages = lazyLoadImages.add( newElements );
								}
								
							}; 
						return {
							reveal : reveal,
							addElements : addElements
						}

                    })(),
                
				portfolioModule = function() {  

                    this.portfolioContainer = null,
                    this.closest_portfolio = null,
                    this.initalRender = false,
					this.dataSource = '',
					this.gutter_width,
					this.initialRender = false,
					this.elements = null,
                    this.init = function(element,actionParam){

                        this.portfolioContainer = element.find('.portfolio-container');
                        this.closest_portfolio = element; 
                        this.setColumnWidth();
						this.elements = element.find( '.element' );
						this.storeData();
						this.getDataSource();
						this.gutter_width();
						
			        },
					this.storeData = function() {

						this.closest_portfolio.data( "oshinePortfolio", this );

					},
					this.getDataSource = function() {

						if( 'undefined' != typeof this.closest_portfolio.attr( 'data-source' ) ) {
							this.dataSource = JSON.parse( this.closest_portfolio.attr( 'data-source' ) ).source;
						}

					},
                    this.getContainerWidth = function(){

                        return this.closest_portfolio.width();
                   
					},
                    this.setContainerWidth = function(roundedWidthParam){
                    
					    this.portfolioContainer.width(roundedWidthParam);
                    
					},
                    this.gutter_width = function(){
                    
					    this.gutter_width =  Number(this.closest_portfolio.attr('data-gutter-width'));
						if( 'number' != typeof this.gutter_width ) {
							this.gutter_width = 0;
						}
                    
					},
                    this.getElementNormalHeight = function () {

                        var normalHeight = 0,
							elementsWithNormalHeight = this.portfolioContainer.find( '.no-wide-width-height:visible' ),
							elementsWithWideWidth,
                            elementsWithWideHeight,
							elementsWithWideWidthHeight;
						if( 0 < elementsWithNormalHeight.length ) {
							normalHeight = elementsWithNormalHeight.find( '.flip-img-wrap,.post-thumb-wrap' ).outerHeight();
						}else{
							elementsWithWideWidth = this.portfolioContainer.find( '.wide-width:visible' );
                            elementsWithWideHeight = this.portfolioContainer.find( '.wide-height:visible' );
							elementsWithWideWidthHeight = this.portfolioContainer.find( '.wide-width-height:visible' );
							if( 0 < elementsWithWideWidth.length ) {
								normalHeight = elementsWithWideWidth.find( '.flip-img-wrap,.post-thumb-wrap' ).outerHeight();
							}else if( 0 < elementsWithWideHeight.length ) {  
                                normalHeight = ( elementsWithWideHeight.find( '.flip-img-wrap,.post-thumb-wrap' ).outerHeight() - this.gutter_width )/2;
                            }else if( 0 < elementsWithWideWidthHeight.length ) {
								normalHeight = ( elementsWithWideWidthHeight.find( '.flip-img-wrap,.post-thumb-wrap' ).outerHeight() - this.gutter_width )/2;
							}else{
								normalHeight = 0;
							}
						}
						return normalHeight;

                    },
					this.getElementNormalWidth = function() {

						var normalWidth = 0,
							elementsWithNormalWidth = this.portfolioContainer.find( '.no-wide-width-height:visible,.wide-height:visible' ),
							elementsWithWideWidth,
							elementsWithWideWidthHeight;
						if( 0 < elementsWithNormalWidth.length ) {
							normalWidth = elementsWithNormalWidth.find( '.flip-img-wrap,.post-thumb-wrap' ).width();
						}else{
							elementsWithWideWidth = this.portfolioContainer.find( '.wide-width:visible' );
							elementsWithWideWidthHeight = this.portfolioContainer.find( '.wide-width-height:visible' );
							if( 0 < elementsWithWideWidth.length ) {
								normalWidth = ( elementsWithWideWidth.find( '.flip-img-wrap,.post-thumb-wrap' ) - this.gutter_width )/2;
							}else if( 0 < elementsWithWideWidthHeight.length ) {
								normalWidth = ( elementsWithWideWidthHeight.find( '.flip-img-wrap,.post-thumb-wrap' ) - this.gutter_width )/2;
							}else{
								normalWidth = 0;
							}
						}
						return normalWidth;
					
					},
                    this.noOfColumns = function () {

                        var windowTotalWidth = jQuery(window).width() + jQuery.getScrollbarWidth() ,
							$isBlog = jQuery( 'body' ).hasClass( 'blog' ) ;
						//console.log(jQuery.getScrollbarWidth())
                        if( windowTotalWidth < 1280 && windowTotalWidth >= 768 ) {
							if( ( $isBlog && windowTotalWidth > 960 ) || !$isBlog ) {
								switch(this.closest_portfolio.attr('data-col')){
									case 'two':
										return 2;
									case 'one':
										return 1;
									default :
										return 3;
								}
							}else{
								if( 1 == this.closest_portfolio.attr( 'data-col' ) ) {
									return 1;
								}else{
									return 2;
								}
							}
                        }else if ( windowTotalWidth < 768 && windowTotalWidth > 481 ){
							if( $isBlog ) {
								return 1;
							}
                            switch(this.closest_portfolio.attr('data-col')){
                                case 'one':
                                    return 1;
                                default :
                                    return 2;
                            }
                        }else if ( windowTotalWidth <= 481 ){
                            if( this.closest_portfolio.hasClass( 'portfolio-two-col-mobile' ) ) {
                                return 2;
                            }else {
                                return 1;
                            }
                        }else{
                            switch(this.closest_portfolio.attr('data-col')){
                                case 'five':
                                    return 5;
                                case 'four':
                                    return 4;
                                case 'three':
                                    return 3;
                                case 'two':
                                    return 2;
                                case 'one':
                                    return 1;
                                default :
                                    return 3;
                            }
                        }
                    
					},
                    this.getRoundedWidth = function () {

                        var rounded_width = Math.floor(this.getContainerWidth() );
                        var nCols = this.noOfColumns();
                        if(nCols == 0) nCols = 1;
                        var remainder = Math.floor(rounded_width / nCols);
                        rounded_width = remainder * nCols + nCols;
                        this.setContainerWidth( rounded_width );
                        return rounded_width; 
                    
					},
                    this.setColumnWidth = function () {
                        
						this.columnWidth = this.getRoundedWidth() / this.noOfColumns();
                    
					},
					this.prepareToFireIsotope = function() {

						var currentInstance = this;
						if( this.closest_portfolio.hasClass( 'portfolio-delay-load' ) || this.closest_portfolio.hasClass( 'portfolio-lazy-load' ) ) {
							this.multiGridSetup( null, false );
							this.applyIsotope( !this.closest_portfolio.hasClass( 'portfolio-delay-load' ) ? true : false );
						}else{
							this.portfolioContainer.imagesLoaded( function(){

								currentInstance.multiGridSetup( null, false );
								currentInstance.applyIsotope( true );

							} );
						}

					},
                    this.multiGridSetup = function ( $newItems, $isResize ) {

						var elements = $newItems || this.elements,
							currentAspectRatio,
							flipImageWrap,
							vNormalHeight,
							normalWidth,
							vGutterWidth = this.gutter_width;
                        if ( this.closest_portfolio.hasClass('full-screen-gutter') && 1 != Number(this.closest_portfolio.attr('data-enable-masonry'))  && 'flickr' != this.dataSource ) {  
                            if( !$isResize ) {
								vNormalHeight = this.getElementNormalHeight();
							}else{
								currentAspectRatio = this.closest_portfolio.attr( 'data-aspect-ratio' );
								vNormalHeight = Math.round( this.getElementNormalWidth()/currentAspectRatio );								
							}
							elements.each( function() {

								var currentElement = jQuery( this );
								if( currentElement.hasClass( 'wide-height' ) ) {
									currentElement.find( '.flip-img-wrap,.post-thumb-wrap' ).css( 'height', ( vNormalHeight*2 ) + vGutterWidth );
								}else if( currentElement.hasClass( 'wide-width-height' ) ) {
									if( 480 > window.innerWidth ) {
                                        var actualWidth = currentElement.width() - parseInt( currentElement.children(0).css( 'margin-left' ) );
										currentElement.find( '.flip-img-wrap,.post-thumb-wrap' ).css( 'height', Math.round( actualWidth/currentElement.find( 'img' ).attr( 'data-aspect-ratio' ) ) );
									}else{
										currentElement.find( '.flip-img-wrap,.post-thumb-wrap' ).css( 'height', (vNormalHeight*2) + vGutterWidth );
									}
								}else{
									currentElement.find( '.flip-img-wrap,.post-thumb-wrap' ).css( 'height', vNormalHeight );
								}

							} );

                        }else if( 'flickr' == this.dataSource ||  Number(this.closest_portfolio.attr('data-enable-masonry')) == 1 ) {
							if( !$isResize ) {
								elements.find( '.flip-img-wrap,.post-thumb-wrap' ).each( function(i, el) {
									var currentElement = jQuery( el );
									currentElement.css( 'height', currentElement.outerHeight() );

								} );
							}else if( $isResize ) {
								var normalElementWidth = this.getElementNormalWidth();
								elements.find( '.flip-img-wrap,.post-thumb-wrap' ).each( function( i, el ) {

									var currentElement = jQuery( el );
									currentElement.css( 'height', Math.round( normalElementWidth/currentElement.attr( 'data-aspect-ratio' ) ) );

								} );
							}
						}
						if( !this.initialRender || null != $newItems ) {
							elements.find( '.flip-img-wrap,.post-thumb-wrap' ).css( "padding-bottom", "0px" );							
							elements.find( '.flip-img-wrap,.post-thumb-wrap' ).find( 'img' ).resizeToParent();		
						}

                            
                    },
                    this.applyIsotope = function( delayLoad ) {
						
                        var column_width = this.columnWidth,
							flipWrap = this.portfolioContainer.find('.flip-img-wrap,.post-thumb-wrap'),
							shouldMaintainOrder = '1' == this.closest_portfolio.attr( 'data-maintain-order' );
                        this.portfolioContainer.isotope({
							isInitLayout : false,
                            itemSelector : '.element',
                            masonry: {
								columnWidth : column_width,
								horizontalOrder: shouldMaintainOrder
                            },
							transitionDuration : this.closest_portfolio.hasClass( 'portfolio-delay-load' ) ? 0 : 450
                        }).isotope('on','layoutComplete', function( laidOutItems ) {
                           
                            if( !this.initialRender ) {
                                if( Number( this.closest_portfolio.hasClass( 'portfolio-delay-load' ) ) ) {
										this.elements.addClass( "element-animate" );
										this.portfolioContainer.css( "visibility", "visible" );
										if( !$body.hasClass( 'be-sticky-sections' ) || 960 >= window.innerWidth ) {
											if( this.portfolioContainer.hasClass( 'style8-blog' ) ) {
												setTimeout( portfolioScrollReveal.delayReveal, 100 );
											}else{
												setTimeout( portfolioScrollReveal.delayReveal, 0 );
											}
											initializedPortfolioWithDelayCount++;
											if( initializedPortfolioWithDelayCount == portfolioWithDelayLoadCount ) {
												jQuery( window ).trigger( "beDelayLoad" );
											}
										}
                                }else{
                                    this.portfolioContainer.css( "visibility", "visible" );                                
                                }
                                if( Number( this.closest_portfolio.hasClass( 'portfolio-lazy-load' ) ) ) {
									if( !$body.hasClass( 'be-sticky-sections' ) || 960 >= window.innerWidth ) {
										if( this.portfolioContainer.hasClass( 'style8-blog' ) ) {
											setTimeout( 
												portfolioLazyReveal.reveal, 200
											);
										}else{
											portfolioLazyReveal.reveal();
										}
										initializedPortfolioWithLazyCount++;
										if( initializedPortfolioWithLazyCount == portfolioWithLazyLoadCount ) {
											jQuery( window ).trigger( "beLazyLoad" );
										}
									}
                                }
                                this.initialRender = true;
                            }
							setTimeout( function(){
								
								Waypoint.refreshAll();
								if( delayLoad ) {
									this.delayLoad( this.elements );
								}
							}.bind( this ), 0 );

                        }.bind( this ));
						this.portfolioContainer.isotope( 'layout' );

                    },

                    this.delayLoad = function ( $elements ) {

						var delay = 100;
						$elements.each( function() {

							var curElement = jQuery( this ).find( 'img' );
							setTimeout( function() {
								curElement.parent().addClass( 'img-loaded' );
								curElement.closest('.flip-wrap').next().addClass('img-loaded');
							}, delay );
							delay = delay + 200;

						} );

                    },
                    this.portfolioParallaxSetup = function(){
                        if(this.portfolioContainer.hasClass('portfolio-item-parallax')) {
                            this.portfolioContainer.parentsUntil('.be-section').css('overflow', 'visible');
                            this.portfolioContainer.closest('.be-section').css('overflow', 'visible');
                            this.portfolioContainer.css('overflow', 'visible').find('.element').css('overflow', 'visible');
                        }
                    },

					this.triggerResize = function() {

						this.setColumnWidth();
						this.multiGridSetup( null, true );
						this.applyIsotope( false );

					}
                },

	            portfolioMainModule = function( portfolio ){
	                var portfolioModuleInst = [], i = 0; 
	                // Loop for Each Portfolio Item
	                portfolio.each(function () {
	                    // Default Portfolio Layout
	                    portfolioModuleInst[i] = new portfolioModule();
	                    portfolioModuleInst[i].init( jQuery(this) );
	                    portfolioModuleInst[i].prepareToFireIsotope();
	                    portfolioModuleInst[i].portfolioParallaxSetup();
	                    // Increment loop Counter
	                    i++;
	                }); //End of Loop
	            },


	            paginationData = function(triggerParam, portfolioParam, elementParam) {
	                var $this = portfolioParam,
	                    $trigger = triggerParam,
	                    $ajaxData = '';


	                switch(elementParam){
	                    case 'portfolio' : 

	                        $ajaxData = "action=" + $this.attr("data-action") + 
	                                    "&category=" + $this.attr("data-category") + 
	                                    "&masonry=" + $this.attr("data-enable-masonry") + 
	                                    "&showposts=" + $this.attr("data-showposts") + 
	                                    "&col=" + $this.attr("data-col") + 
	                                    "&gallery=" + $this.attr("data-gallery") + 
	                                    "&filter=" + $this.attr("data-filter") + 
										"&meta_to_show=" + $this.attr("data-meta_to_show") + 
										"&placeholder_color" + $this.attr("data-placeholder-color") +
	                                    "&show_filters=" + $this.attr("data-show_filters") + 
	                                    "&thumb_overlay_color=" + $this.attr("data-thumbnail-bg-color") + 
	                                    "&title_style=" + ( $this.attr("data-title-style") || "") + 
	                                    "&title_color=" + $this.attr("data-title-color") + 
	                                    "&cat_color=" + $this.attr("data-cat-color") + 
	                                    "&title_animation_type=" + ( $this.attr("data-title-animation-type") || "" ) + 
	                                    "&cat_animation_type=" + ( $this.attr("data-cat-animation-type") || "" ) + 
	                                    "&gutter_width=" + Number( $this.attr("data-gutter-width") ) + 
	                                    "&hover_style=" + ( $this.attr("data-hover-style") || "" ) + 
	                                    "&img_grayscale=" + $this.attr("data-img-grayscale") + 
	                                    "&image_effect=" + ( $this.attr("data-image-effect") || "" ) + 
	                                    "&gradient_style_color=" + $this.attr("data-gradient-style-color") + 
	                                    "&cat_hide=" + $this.attr("data-cat-hide") + 
	                                    "&like_button=" + $this.attr("data-like-indicator") + 
										"&placeholder_color=" + $this.attr( "data-placeholder-color" ) + 
                                        "&prebuilt_hover_style=" + ( $this.attr( "data-prebuilt-hover-style" ) || "" );

	                        return $ajaxData;

	                    case 'gallery' :

	                        $ajaxData = "action=" + $this.attr("data-action") + 
	                                    "&masonry=" + $this.attr("data-enable-masonry") + 
	                                    "&source=" + $this.attr("data-source") + 
	                                    "&gutter_width=" + $this.attr("data-gutter-width") + 
	                                    "&col=" + $this.attr("data-col") + 
	                                    "&data_gutter_width=" + Number( $this.attr("data-gutter-width") ) + 
	                                    "&images_arr=" + $this.attr("data-images-array") + 
	                                    "&items_per_load=" + $this.attr("data-items-per-load") + 
	                                    "&hover_style=" + $this.attr("data-hover-style") + 
	                                    "&img_grayscale=" + $this.attr("data-image-grayscale") + 
	                                    "&lightbox_type=" + $this.attr("data-lightbox-type") + 
	                                    "&image_source=" + $this.attr("data-image-source") + 
	                                    "&image_effect=" + $this.attr("data-image-effect") + 
	                                    "&thumb_overlay_color=" + $this.attr("data-thumb-overlay-color") + 
	                                    "&gradient_style_color=" + $this.attr("data-grad-style-color") + 
	                                    "&like_button=" + $this.attr("data-like-button") + 
	                                    "&hover_content_option=" + $this.attr("data-hover-content") + 
	                                    "&hover_content_color=" + $this.attr("data-hover-content-color") + 
										"&lazy_load=0" +
										"&delay_load=" + ( $this.hasClass( 'portfolio-delay-load' ) ? 1 : 0 ) +
										"&placeholder_color=" + $this.attr( 'data-placeholder-color' ); 

	                        return $ajaxData;

	                    case 'blog' :

	                        $ajaxData = "action=" + $this.attr("data-action") + 
	                        "&showposts=" + $this.attr("data-showposts") + 
	                        "&gutter_width=" + Number( $this.attr("data-gutter-width") ) + 
							"&blog_style=" + ( portfolioParam.find( '.portfolio-container' ).hasClass( 'style3-blog' ) ? 'style3' : 'style8' ) + 
	                        "&total_items=" + $trigger.attr('data-total-items') ;

	                        return $ajaxData;

	                }
	            },

	            infiniteScroll = function( triggerParam, portfolioParam, pagedParam, elementTypeParam ) {
	                var $this = triggerParam,
	                $portfolio = portfolioParam,
	                $paged = pagedParam;


	                var be_waypoint = new Waypoint({
	                    element: $this,
	                    handler: function (direction) {
	                        if (direction === 'down') {
	                            var $this_waypoint = this, 
	                            $page_loader = jQuery('.page-loader');
	                            $this_waypoint.disable(); //Disable Waypoint untill Images are Loaded
	                            $page_loader.fadeIn();
	                            jQuery.ajax({
	                                type: "POST",
	                                url: ajax_url,
	                                data: paginationData( $this, $portfolio, elementTypeParam) + "&paged=" + $paged 
	                            }).done(function (data) {
	                                if (data !== 0 && data !== '0' && data) {
	                                    var $newItems = jQuery(data).filter( function() {
												return 1 == this.nodeType;
											}),
											$portfolioInstance = $portfolio.data( "oshinePortfolio" );
                                        if( $portfolio.hasClass( 'be-portfolio-prebuilt-hover-style3' ) ) {
                                            tiltHoverEffect( $newItems.find( '.thumb-wrap' ) );
                                        }
										$portfolioInstance.elements = $portfolioInstance.elements.add( $newItems );
                                        if( $portfolio.hasClass( 'portfolio-delay-load' ) ) {
                                                $newItems.addClass( 'element-animate' );
												$portfolioInstance.portfolioContainer.append( $newItems );
												$portfolioInstance.multiGridSetup( $newItems, false );
												$portfolioInstance.portfolioContainer.isotope( "appended", $newItems );
												portfolioScrollReveal.addElements( $newItems );
												portfolioScrollReveal.delayReveal();
                                                if(elementTypeParam == 'portfolio' || elementTypeParam == 'gallery' ){
                                                    directionalHover( $portfolio.find('.element') );
                                                }
                                                if(elementTypeParam == 'blog'){
													portfolioLazyReveal.addElements( $newItems.find( '.thumb-wrap' ).find( 'img' ) );
													setTimeout( portfolioLazyReveal.reveal, 100 );													
                                                    $newItems.find('.be_image_slider').each(function () {
                                                        var $this = jQuery(this).find('.image_slider_module');
                                                        be_blog_gallery($this); 
                                                    });
                                                    $newItems.fitVids();
													oshine_scripts.triggerStackShare( $newItems.find( '.be-share-stack-mask' ) );
                                                }
                                                window.tatsu.lightbox();
                                                $this_waypoint.enable(); //Enable Waypoint 
                                                $paged = Number($paged) + 1;
                                                $page_loader.fadeOut();  
                                        }else{
                                            $newItems.imagesLoaded(function() {
												$portfolioInstance.portfolioContainer.append( $newItems )
												$portfolioInstance.multiGridSetup( $newItems, false );
												$portfolioInstance.portfolioContainer.isotope( "appended", $newItems );
												$portfolioInstance.delayLoad( $newItems );
                                                if(elementTypeParam == 'portfolio' || elementTypeParam == 'gallery' ){
                                                    directionalHover( $portfolio.find('.element') );
                                                }
                                                if(elementTypeParam == 'blog'){
                                                    $newItems.find('.be_image_slider').each(function () {
                                                        var $this = jQuery(this).find('.image_slider_module');
                                                        be_blog_gallery($this); 
                                                    });
                                                    $newItems.fitVids();
                                                }
												window.tatsu.lightbox();
												
												if( window.be_gdpr_magnific_popup_retrigger ){
													window.be_gdpr_magnific_popup_retrigger();
												}

                                                $this_waypoint.enable(); //Enable Waypoint 
                                                $paged = Number($paged) + 1;
                                                $page_loader.fadeOut();

                                            });
                                        }
	                                } else {
	                                    $this_waypoint.destroy();
	                                    $page_loader.fadeOut();
	                                }
	                            });
	                       }
	                    }, 
	                    offset: 'bottom-in-view'    
	                });
	            },

	            loadmore = function( triggerParam, portfolioParam, pagedParam, elementTypeParam ){
	                var $this = triggerParam,
	                $portfolio = portfolioParam,
	                $paged = pagedParam,
	                $page_loader = jQuery('.page-loader');
	                $page_loader.fadeIn();
	                $this.addClass('disabled');
	                jQuery.ajax({
	                    type: "POST",
	                    url: ajax_url,
	                    data: paginationData( $this, $portfolio , elementTypeParam) + "&paged=" + $paged ,
	                    success: function (data) {

	                        if (data!== 0 && data !== '0' && data) {
	                            var $newItems = jQuery(data).filter( function() {
									return 1 == this.nodeType;
									}),
									$portfolioInstance = $portfolio.data( "oshinePortfolio" );
                                if( $portfolio.hasClass( 'be-portfolio-prebuilt-hover-style3' ) ) {
                                    tiltHoverEffect( $newItems.find( '.thumb-wrap' ) );
                                }
								$portfolioInstance.elements = $portfolioInstance.elements.add( $newItems );
								if( $portfolio.hasClass( 'portfolio-delay-load' ) ) {
									$newItems.addClass( 'element-animate' );
									$portfolioInstance.portfolioContainer.append( $newItems )
									$portfolioInstance.multiGridSetup( $newItems, false );

									$portfolioInstance.portfolioContainer.isotope( "appended", $newItems );
									portfolioScrollReveal.addElements( $newItems );
									portfolioScrollReveal.delayReveal();
									if(elementTypeParam == 'portfolio' || elementTypeParam == 'gallery' ){
										directionalHover( $portfolio.find('.element') );
									}
									if(elementTypeParam == 'blog'){
										portfolioLazyReveal.addElements( $newItems.find( '.thumb-wrap' ).find( 'img' ) );
										setTimeout( portfolioLazyReveal.reveal, 100 );
										$newItems.find('.be_image_slider').each(function () {
											var $this = jQuery(this).find('.image_slider_module');
											be_blog_gallery($this); 
										});
										$newItems.fitVids();
										oshine_scripts.triggerStackShare( $newItems.find( '.be-share-stack-mask' ) );
									}

									window.tatsu.lightbox();

									$portfolio.attr("data-paged", Number($paged) + 1);
									
									$this.attr("data-total-items", function () {
										return (Number(jQuery(this).attr('data-total-items')) - $newItems.find('.element-inner').length);
									});

									if ($this.attr("data-total-items") <= 0) {
										$this.fadeOut(500, function () {
											$this.remove();
										});
									}
									$this.removeClass('disabled');
									$page_loader.fadeOut();

								}else{
									$newItems.imagesLoaded(function () {
										
										$portfolioInstance.portfolioContainer.append( $newItems )
										$portfolioInstance.multiGridSetup( $newItems, false );
										$portfolioInstance.portfolioContainer.isotope( "appended", $newItems );
										$portfolioInstance.delayLoad( $newItems );
										if(elementTypeParam == 'portfolio' || elementTypeParam == 'gallery' ){
											directionalHover( $portfolio.find('.element') );
										}
										if(elementTypeParam == 'blog'){
											$newItems.find('.be_image_slider').each(function () {
												var $this = jQuery(this).find('.image_slider_module');
												be_blog_gallery($this); 
											});
											$newItems.fitVids();
										}

										window.tatsu.lightbox();
										if( window.be_gdpr_magnific_popup_retrigger ){
											window.be_gdpr_magnific_popup_retrigger();
										}
										$portfolio.attr("data-paged", Number($paged) + 1);
										
										$this.attr("data-total-items", function () {
											return (Number(jQuery(this).attr('data-total-items')) - $newItems.find('.element-inner').length);
										});

										if ($this.attr("data-total-items") <= 0) {
											$this.fadeOut(500, function () {
												$this.remove();
											});
										}
										$this.removeClass('disabled');
										$page_loader.fadeOut();
										
										if( typeof window.triggerBeGdpr === 'function' ){
											window.triggerBeGdpr();
										}
									});									
								}
	                        } else {
	                            $this.addClass('disabled');
	                            $page_loader.fadeOut();
	                        }
	                    }
	                });
	            },

                //code to detect browser type. 
                //Source code : https://stackoverflow.com/questions/9847580/how-to-detect-safari-chrome-ie-firefox-and-opera-browser
                detectBrowser = function() {

                    // Opera 8.0+
                    var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0,
                        isFirefox = typeof InstallTrigger !== 'undefined',
                        isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification)),
                        isIE = !!document.documentMode,
                        isEdge = !!window.StyleMedia,
                        isChrome = !!window.chrome && !!window.chrome.webstore;
                    return isOpera ? 'Opera' : isFirefox ? 'Firefox' : isSafari ? 'Safari' : isIE ? 'IE' : isEdge ? 'Edge' : isChrome ? 'Chrome' : false;

                }, 

                tiltHoverEffect = function( elements ) {

                    if( 0 < jQuery( '.be-portfolio-prebuilt-hover-style3' ).length ) {
                        asyncloader.require( 'tilt', function() {
                            var targetElements = elements || jQuery( '.be-portfolio-prebuilt-hover-style3' ).closest( '.portfolio-all-wrap' ).css( 'overflow', 'visible' ).find( '.thumb-wrap' ),
                                targetBrowser = detectBrowser();
                            if( 'string' == typeof targetBrowser && ( 'Edge' == targetBrowser || 'IE' == targetBrowser ) ) {
                                return;
                            }else if( 'string' == typeof targetBrowser && 'Safari' == targetBrowser ) {
                                targetElements.find( '.thumb-shadow-wrapper' ).css( 'display', 'none' );
                                if( jQuery( 'body' ).hasClass( 'be-fixed-footer' ) ) { 
                                    jQuery( '#be-fixed-footer-wrap' ).css( 'position', 'relative' );
                                    jQuery( '#be-fixed-footer-placeholder' ).css( 'display', 'none' );
									jQuery( 'body' ).removeClass( 'be-fixed-footer' );
									jQuery( 'body' ).addClass( 'be-fixed-footer-disable' );
                                } 
                            }
                            targetElements.tilt({
                                glare : true,
                                maxGlare : 0.3,
                                perspective : 1000,
                                speed : 4000,
                                maxTilt : 10,
                                scale : 1.05
                            });

                        } );
                    }

                },

	            be_blog_gallery = function(blog_gallery_post){
	                var $this = blog_gallery_post,
	                $slideshow = $this.attr('data-auto-slide'),
	                $slideshowspeed = 1000;
	                if( 'no' == $slideshow ){
	                    $slideshow = false;
	                } else {
	                    $slideshow = true;
	                    $slideshowspeed = $this.attr('data-slide-interval');
					}
					asyncloader.require( [ 'owlcarousel', 'imagesloaded' ], function(){
						
						$this.imagesLoaded( function() {

							$this.owlCarousel({
								items:1,
								autoHeight: true,
								autoplay: $slideshow,
								autoplayTimeout: $slideshowspeed, 
								autoplaySpeed: 1000,
								autoplayHoverPause: true,
								navRewind: false,
								nav: true,
								loop: true,
								navText: ['<i class="font-icon icon-arrow_carrot-left"></i>','<i class="font-icon icon-arrow_carrot-right"></i>'],
								dots:false,
								onInitialize: function() {
									$this.fadeIn(500);
									$this.trigger('refresh.owl.carousel');
								}
							});	
							$this.closest( '.portfolio-container' ).isotope( 'layout' );						
						
						} );

					});
	                
	            },

	            forcePortfolioTitles = function() {

                    var portfolioContainer = jQuery('.portfolio-container');
	                portfolioContainer.imagesLoaded(function () {
	                    if( portfolioContainer.hasClass( 'force-show-thumb-overlay' ) ) {
	                       portfolioContainer.css('opacity','1');
	                    }
	                }); 
	           
				 },


	            triggerInfiniteScroll = function(){
	                if( trigger.length > 0 ) {
	                    trigger.each( function() {
	                        var $portfolio = jQuery(this).closest('.portfolio');
	                        infiniteScroll( jQuery(this), $portfolio , $portfolio.attr( 'data-paged' ), jQuery(this).attr( 'data-type' ) )
	                    });
	                }
	            },


	            animationTrigger = function() {
	                jQuery(document).on( 'mouseenter.oshine mouseleave.oshine', '.element-inner', function(e) {
	                    var $animationTrigger = jQuery(this).find( '.animation-trigger' );
	                    if( $animationTrigger.length > 0 ) {    
		                    if( 'mouseenter' == e.type ){
		                        $animationTrigger.addClass( $animationTrigger.attr( 'data-animation-type' ) );
		                    } else {
		                        $animationTrigger.removeClass( $animationTrigger.attr( 'data-animation-type' ) );
		                    }
		                }
	                });
	            },

	            parallaxPortfolioClasses = function() {              
	                jQuery('.portfolio-container').each(function () {
	                    var $this = jQuery(this), 
	                        $i = 0;
	                    if($this.closest('.portfolio').hasClass('two-col')) {
	                        $this.find('.element').each(function() {
	                            if($i == 1 || $i == 2) {
	                                jQuery(this).addClass('parallax-effect');
	                                $i = $i+1;
	                            } else if($i == 3) {
	                                jQuery(this).addClass('no-parallax-effect');
	                                $i = 0;
	                            } else {
	                                jQuery(this).addClass('no-parallax-effect');
	                                $i = $i+1;
	                            }
	                        });
	                    } else {
	                        $this.find('.element:odd').addClass('parallax-effect');
	                        $this.find('.element:even').addClass('no-parallax-effect');
	                    }
	                });      
	            },

	            parallaxPortfolio = function() {
                    var portfolioContainer = jQuery('.portfolio-container');
	                if( portfolioContainer.length > 0  && portfolioContainer.hasClass('portfolio-item-parallax') ) {
	                    if(jQuery('html').hasClass('no-touch') && (jQuery(window).width() >= 768)) {
	                        portfolioContainer.each(function() {
	                            var $window_height = jQuery(window).height(), $window_scroll_top = jQuery(window).scrollTop();
	                            jQuery(this).find('.element.parallax-effect').each(function() {
	                                var $this = jQuery(this), offset = $this.offset().top, animate_pos = offset-($window_height/2), opacity = ((animate_pos) - $window_scroll_top)/1.5, opacity_2 = opacity*1.7;
	                                $this.find('.element-inner').css({
	                                    '-webkit-transform' : 'translatey('+opacity_2+'px) scale(0.7) translatez(0px)',
	                                    '-moz-transform' : 'translatey('+opacity_2+'px) scale(0.7) translatez(0px)',
	                                    '-o-transform' : 'translatey('+opacity_2+'px) scale(0.7) translatez(0px)',
	                                    '-ms-transform' : 'translatey('+opacity_2+'px) scale(0.7) translatez(0px)',
	                                    'transform' : 'translatey('+opacity_2+'px) scale(0.7) translatez(0px)'
	                                });
	                                $this.find('.thumb-title-wrap, .custom-like-button').css({
	                                    '-webkit-transform' : 'scale(1.4) translatez(0px)',
	                                    '-moz-transform' : 'scale(1.4) translatez(0px)',
	                                    '-o-transform' : 'scale(1.4) translatez(0px)',
	                                    '-ms-transform' : 'scale(1.4) translatez(0px)',
	                                    'transform' : 'scale(1.4) translatez(0px)'
	                                });
	                            });
	                            jQuery(this).find('.element.no-parallax-effect').each(function() {
	                                var $this = jQuery(this), offset = $this.offset().top, animate_pos = offset-($window_height/2), opacity = ((animate_pos) - $window_scroll_top)/2;
	                                $this.find('.element-inner').css({
	                                    '-webkit-transform' : 'translatey('+opacity+'px) translatez(0px)',
	                                    '-moz-transform' : 'translatey('+opacity+'px) translatez(0px)',
	                                    '-o-transform' : 'translatey('+opacity+'px) translatez(0px)',
	                                    '-ms-transform' : 'translatey('+opacity+'px) translatez(0px)',
	                                    'transform' : 'translatey('+opacity+'px) translatez(0px)',
	                                });
	                            });
	                        });
	                    }
	                }   
	            },

	            filter = function() {
                    var delayCall = '';
	                jQuery(document).on('click', '.sort', function () {
						var currentTrigger = jQuery( this ),                           
							filterClass = currentTrigger.data().id.toString(),
							closestPortfolio = currentTrigger.closest( '.portfolio' ),
							filterElements;
						if( filterClass && filterClass.toString ) {
							filterClass = filterClass.toString();
						}
						currentTrigger.closest( '.filters' ).find( '.sort' ).removeClass( 'current_choice' );
                        
						currentTrigger.addClass( 'current_choice' );
						if( closestPortfolio.hasClass( 'portfolio-delay-load' ) ) {
							var classQuotient = 'delay-loaded already-visible end-animation animation-complete ' + closestPortfolio.attr( 'data-animation' ),
								currentVisibleElements = closestPortfolio.find( '.element.delay-loaded' );
							filterElements = ( 'element' != filterClass ) ? ( closestPortfolio.find( '.element' ).filter( function() {
								
								return ( 'string' == typeof jQuery( this ).attr( 'data-category-names' ) && ( 0 <= jQuery( this ).attr( 'data-category-names' ).indexOf( filterClass ) ) );

							}) ) : closestPortfolio.find( '.element' );
							currentVisibleElements.css( 'animation-delay', 'initial' );
							currentVisibleElements.removeClass( classQuotient );
							currentVisibleElements.addClass( 'end-animation' );
							closestPortfolio.addClass( 'filter-scale-back-animation' );
                            if( '' != delayCall ) {
                                clearTimeout( delayCall );
                            }
							delayCall = setTimeout( function() {
                                if( '' != delayCall ) {
                                    delayCall = '';
                                }
								closestPortfolio.removeClass( 'filter-scale-back-animation' );
								filterElements.removeClass( classQuotient );	
								closestPortfolio.data( 'oshinePortfolio' ).portfolioContainer.isotope({
									filter : function() {
										var curCategories = jQuery( this ).attr( 'data-category-names' ),
                                            curCategoriesArray,
											result = false;
                                        if( 'element' == filterClass ) {
                                            result = true;
                                        }else if( 'string' == typeof curCategories && '' != curCategories ) {
                                            curCategoriesArray = curCategories.split( " " );
                                            if( '' == curCategoriesArray[ curCategoriesArray.length - 1 ] ) {
                                                curCategoriesArray.pop();
                                            }
                                            if( 0 <= curCategoriesArray.indexOf( filterClass ) ) {
                                                result = true;
                                            }else{
                                                result = false;
                                            }                                            
                                        }else{
                                            result = false;
                                        }

										return result;

									}
								});
								portfolioScrollReveal.addElements( filterElements, true );
								portfolioScrollReveal.delayReveal();
								if( closestPortfolio.hasClass( 'portfolio-lazy-load' ) ) {
									portfolioLazyReveal.reveal();
								}
                                jQuery( window ).trigger( 'resize' );
							}, 300 );
						}else{
							closestPortfolio.data( 'oshinePortfolio' ).portfolioContainer.isotope({
								filter : function() {
                                            var curCategories = jQuery( this ).attr( 'data-category-names' ),
                                                curCategoriesArray,
                                                result = false;
                                            if( 'element' == filterClass ) {
                                                result = true;
                                            }else if( 'string' == typeof curCategories && '' != curCategories ) {
                                                curCategoriesArray = curCategories.split( " " );
                                                if( '' == curCategoriesArray[ curCategoriesArray.length - 1 ] ) {
                                                    curCategoriesArray.pop();
                                                }
                                                if( 0 <= curCategoriesArray.indexOf( filterClass ) ) {
                                                    result = true;
                                                }else{
                                                    result = false;
                                                }                                            
                                            }else{
                                                result = false;
                                            }

                                            return result;
										
                                        }
							});	
							if( closestPortfolio.hasClass( 'portfolio-lazy-load' ) ) {
								setTimeout( portfolioLazyReveal.reveal, 450 );
							}	
                            jQuery( window ).trigger( 'resize' );					
						}
	                });                
	            },

	            triggerLoadMore = function() {
	                jQuery(document).on('click', '.trigger_load_more:not(.disabled)', function () {
	                    var $portfolio = jQuery(this).closest('.portfolio'),
	                        $paged = Number( $portfolio.attr('data-paged') );
	                    loadmore( jQuery(this), $portfolio, $paged, jQuery(this).attr('data-type') );
	                });
	            },

	            portfolioLike = function() {
	                jQuery(document).on('click', '.portfolio-like .custom-like-button', function (e) {
	                    var $this = jQuery(this), $post_id = $this.attr('data-post-id');
	                    // $this.addClass('disable');
	                    jQuery.ajax({
	                        type: "POST",
	                        url: ajax_url,
	                        dataType: 'json',
	                        data: "action=post_like&post_id=" + $post_id,
	                        success : function (msg) {
								if (msg.status === "success") {
									if( msg.type === "like" ){
										$this.addClass('liked');
										$this.removeClass('no-liked');
										$this.find('span').text(msg.count);
									}else{
										$this.removeClass('liked');
										$this.addClass('no-liked');
										$this.find('span').text(msg.count);
									}
								}
							},
	                        error: function (msg) {
								alert(msg);
	                        }
	                    });
	                    return false;
	                });
	            },
          

	            lightboxGallery = function() {
                    asyncloader.require( 'magnificpopup', function() { 
    	                if (jQuery('.popup-gallery').length > 0) {
    	                    jQuery('.popup-gallery').magnificPopup({
    	                        delegate: 'a',
    	                        type: 'image',
    	                        tLoading: 'Loading image #%curr%...',
    	                        mainClass: 'mfp-img-mobile',
    	                        gallery: {
    	                            enabled: true,
    	                            navigateByImgClick: true,
    	                            preload: [0, 1]
    	                        },
    	                        image: {
    	                            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
    	                        },
    	                        preloader: true,
    	                        callbacks: {
    	                            afterClose: function () {
    	                                if (jQuery('body').hasClass('smooth-scroll')) {
    	                                    jQuery('html').css('overflow-y', 'scroll');
    	                                }
    	                            },
    	                            open: function () {
    	                                jQuery('body').addClass('mfp-active-state');
    	                                if (jQuery('#main').hasClass('layout-border')) {
    	                                    jQuery('.mfp-content').addClass('layout-border');
    	                                }
    	                            },
    	                            close: function () {
    	                                jQuery('body').removeClass('mfp-active-state');
    	                            }
    	                        }
    	                    });
    	                }

    	                jQuery(document).on('click.oshine', '.be-lightbox-gallery.mfp-image', function (e) {
    	                    e.preventDefault();
    	                    jQuery(this).next('.popup-gallery').magnificPopup('open');
    	                });
                    });                
	            },

	            ready = function( portfolio ) {

	                    asyncloader.require( ['isotope', 'imagesloaded', 'resizetoparent', 'waypoints' ], function() {  
							
                            jQuery('html').addClass('show-overflow');
                            portfolioMainModule( portfolio );
                            triggerInfiniteScroll();
                            triggerLoadMore();
                            lightboxGallery();
                            portfolioLike();
                            filter();
							forcePortfolioTitles();
                            tiltHoverEffect();
                            directionalHover( portfolio.find( '.element' ) );
                            parallaxPortfolioClasses();
                            parallaxPortfolio();
                            animationTrigger();
                            if( jQuery('.be-photoswipe-gallery').length > 0 ) {
                                photoswipe( '.be-photoswipe-gallery' );
                            }
                            tatsu.lightbox();                        
	                    });
	                
	            }, 

	            run = function() {
	                portfolio = jQuery('.portfolio');
	                if( portfolio.length > 0 ) {	                   
	                    ready( portfolio );
	                }

	                jQuery(window).on( 'tatsu_update.oshine', function( e, data )  {
	                	
	                    if( 'oshine_gallery' === data.moduleName || 'gallery' === data.moduleName || 'portfolio' === data.moduleName || 'trigger_ready' === data.moduleName || 'blog' == data.moduleName ) {
	                    	
	                        portfolio = jQuery('.portfolio');
							ready( portfolio );

	                    }
	                });                

	                jQuery(window).resize( function() {
                        
	                    if( portfolio.length > 0 ) {
                            asyncloader.require( ['isotope', 'imagesloaded', 'resizetoparent', 'waypoints' ], function() { 
	                           portfolio.each( function() {

									var currentPortfolioInstance = jQuery( this ).data( 'oshinePortfolio' );
									currentPortfolioInstance.triggerResize();

							   } )
                           });

	                    }
	                });
					
					if( portfolioWithLazyLoadCount > 0 ) {
                        jQuery( window ).one( 'beLazyLoad', function( event ) {
                            
                            jQuery( window ).on( "scroll", function( event ) {

                                portfolioLazyReveal.reveal();

                            } );
                           
                        } );
                    }
                    if( portfolioWithDelayLoadCount > 0 ) {
                        jQuery( window ).one( 'beDelayLoad', function( event ) {

                            jQuery( window ).on( "scroll", function( event ) {

                                portfolioScrollReveal.delayReveal();

                            } );
                        
                        } );
                    }
					if( portfolioContainer.length > 0 && portfolioContainer.hasClass('portfolio-item-parallax') ) {
						jQuery(window).on( 'scroll', function(){
							parallaxPortfolio();
						});
					}

	            };

	            return {
					run: run,
					portfolioLazyReveal : portfolioLazyReveal.reveal,
					portfolioScrollReveal : portfolioScrollReveal.delayReveal
	            }

	    })();

        oshine_modules.run();
		oshine_portfolio.run();    
		window.oshinePortfolio = {
			portfolioLazyReveal : oshine_portfolio.portfolioLazyReveal,
			portfolioScrollReveal : oshine_portfolio.portfolioScrollReveal
		};
     });

})( jQuery );