(function( global, factory, $ ) {
    if ( typeof define == 'function' && define.amd ) {
        // AMD - RequireJS
        define( 'TatsuCarousel', factory );
      } else if ( typeof module == 'object' && module.exports ) {
        // CommonJS - Browserify, Webpack
        module.exports = factory($);
      } else {
        // Browser globals
        global.TatsuCarousel = factory($);
      }
})( window, function( $ ) {
    var $win = $( window ),
        TatsuCarousel = function( ele ) {
            if( null != ele && !ele.hasClass( 'slider-initialized' ) ) {
                if( $.fn.hasOwnProperty( 'flickity' ) ) {
                    if( null != ele && ele instanceof $ ) {
                        this.ele = ele;
                        this.prevWidth = window.innerWidth;
                        this.bindMethods();
                        this.setFlickitySettings();
                        this.initLazyLoad();
                        this.initFullscreenSlider();
                        this.initVariableSlider();
                        this.initDestroyInMobile();
                        this.initEvents();
                        this.adjustArrows();
                        this.initFlickity();
                    }else {
                        console.error( 'Invalid Arg passed to TatsuCarousel' );
                    }
                }else {
                    console.error( 'Flickity is not added. TatsuCarousel depends on Flickity' );
                }
            }
        };
        TatsuCarousel.prototype.initFullscreenSlider = function() {
            if( '1' === this.ele.attr( 'data-fullscreen' ) && ( 767 < window.innerWidth || null == this.ele.attr( 'data-destroy-in-mobile' ) && null == this.ele.attr( 'data-variable-width' ) ) ) {
                var fullScreenOffetSelectors = this.ele.attr( 'data-fullscreen-offset' ),
                    fullScreenHeight = $win.height(),
                    slides = this.ele.find( '.tatsu-carousel-col-inner' ),
                    offsetHeight = 0;
                if( 'string' == typeof fullScreenOffetSelectors ) {
                    var selectorsArray = fullScreenOffetSelectors.split( ',' );
                    selectorsArray.forEach( function( curSelector ) {
                        var curEle = $( curSelector );
                        if( 0 < curSelector.length ) {
                            offsetHeight += curEle.height();
                        }
                    } );
                }
                slides.css( 'height', ( fullScreenHeight - offsetHeight ) + 'px' );
            }
        };
        TatsuCarousel.prototype.updateFullscreenSlider = function() {
            if( 767 < window.innerWidth || ( null == this.ele.attr( 'data-destroy-in-mobile' ) && null == this.ele.attr( 'data-variable-width' ) ) ) {
                var fullScreenOffetSelectors = this.ele.attr( 'data-fullscreen-offset' ),
                    fullScreenHeight = $win.height(),
                    slides = this.ele.find( '.tatsu-carousel-col-inner' ),
                    offsetHeight = 0;
                if( 'string' == typeof fullScreenOffetSelectors ) {
                    var selectorsArray = fullScreenOffetSelectors.split( ',' );
                    selectorsArray.forEach( function( curSelector ) {
                        var curEle = $( curSelector );
                        if( 0 < curSelector.length ) {
                            offsetHeight += curEle.height();
                        }
                    } );
                }
                slides.css( 'height', ( fullScreenHeight - offsetHeight ) + 'px' );
            }
        };
        TatsuCarousel.prototype.adjustArrows = function() {
            if( true === this.settings.prevNextButtons && null != this.ele.attr( 'data-outer-arrows' ) && $(window).width() > this.ele.width() ) {
                var curGutter = !isNaN( parseInt( this.ele.attr( 'data-gutter' ) ) ) ? parseInt( this.ele.attr( 'data-gutter' ) ) : 0,
                    margin = (curGutter/2) + 50;
                this.ele.css({
                    'margin'  : '0 -' + margin + 'px',
                    'padding' : '0 50px'
                });
            }
        }
        TatsuCarousel.prototype.bindMethods = function() {
            this.lazyLoad = this.lazyLoad.bind(this);
            this.throttledLazyLoad = 'function' == typeof $.throttle ? $.throttle(this.lazyLoad, 200) : this.lazyLoad;
            this.flickityInit = this.flickityInit.bind(this);
            this.updateVariableSlider = this.updateVariableSlider.bind(this);
            this.updateFullscreenSlider = this.updateFullscreenSlider.bind( this );
            this.destroyInMobile = this.destroyInMobile.bind(this);
            this.lazyLoadOnScroll = this.lazyLoadOnScroll.bind(this);
            this.updatePreviousWidth = this.updatePreviousWidth.bind(this);
        };
        TatsuCarousel.prototype.setFlickitySettings = function() {
            this.settings = null;
            var sliderSettingsDefaults = {
                    contain : true,
                    wrapAround : false,
                    watchCSS : false,
                    percentPosition : true,
                    cellAlign : 'left',
                    adaptiveHeight : false,
                    pageDots : false,
                    prevNextButtons : false,
                    autoPlay : false,
                    freeScroll : false,
                },
                options = {};
            if( '1' == this.ele.attr( 'data-center-mode' ) ) {
                options.cellAlign = 'center';
            }
            if( '1' == this.ele.attr( 'data-autoplay' ) ) {
                options.autoPlay = !isNaN( Number(this.ele.attr( 'data-autoplay-speed' )) ) ? Number(this.ele.attr( 'data-autoplay-speed' )) : 3000;
            }
            if( '1' == this.ele.attr( 'data-dots' ) ) {
                options.pageDots = true;
            }
            if( '1' === this.ele.attr( 'data-destroy-in-mobile' ) ) {
                options.watchCSS = true;
            }
            if( '1' == this.ele.attr( 'data-arrows' ) ) {
                options.prevNextButtons = true;
            }
            if( '1' == this.ele.attr('data-variable-width') ) {
                if( 767 >= window.innerWidth ) {
                    options.adaptiveHeight = true;
                }else {
                    options.percentPosition = false;    
                }
            }
            if( '1' == this.ele.attr( 'data-infinite' ) ) {
                options.wrapAround = true;
            }
            if( '1' == this.ele.attr( 'data-free-scroll' ) ) {
                options.freeScroll = true;
            }
            this.settings = $.extend( sliderSettingsDefaults, options ); 
        };
        TatsuCarousel.prototype.getMaxHeight = function() {
            var maxHeight = 0,
                slides = this.ele.find( '.tatsu-carousel-col-inner' );
            slides.each(function(){
                var curSlide = $(this);
                if( maxHeight < curSlide.height() ) {
                    maxHeight = curSlide.height();
                }
            });
            return  maxHeight;
        }
        TatsuCarousel.prototype.initEqualHeightSlider = function() {
            if( '1' === this.ele.attr( 'data-equal-height' ) ) {
                var maxHeight = this.getMaxHeight(),
                    slides = this.ele.find( '.tatsu-carousel-col-inner' );
                slides.height( maxHeight );
                this.ele.addClass( 'tatsu-equal-height-slider' );
            }
        };
        TatsuCarousel.prototype.initDestroyInMobile = function() {
            if( '1' === this.ele.attr( 'data-destroy-in-mobile' ) && window.innerWidth < 768 && '1' === this.ele.attr('data-lazy-load') ) {
                var slides = this.ele.find('.tatsu-carousel-col-inner');
                slides.css( 'height', 'auto');
                slides.each(function(){
                    var curSlideInner = $(this),    
                        curAspectRatio = ( curSlideInner.find( '.tatsu-carousel-img' ).attr( 'data-aspect-ratio' ) ) || 1;
                    if( null != curAspectRatio ) {
                        curSlideInner.height( curSlideInner.width()/curAspectRatio );
                    }
                });
            }
        };
        TatsuCarousel.prototype.lazyLoadOnScroll = function() {
            if( 0 < this.imagesToLazyLoad.length ) {
                var visibleImages = this.imagesToLazyLoad.parent().filter(function () {
                    return $(this).isVisible(-100);
                });
                if( 0 < visibleImages.length ) {
                    this.loadImages(visibleImages.find('.tatsu-carousel-img-lazy-load'));
                }
            }
        };
        TatsuCarousel.prototype.destroyInMobile = function() {
            var curWidth = window.innerWidth,
                slides = this.ele.find('.tatsu-carousel-col-inner');
            if( ( this.prevWidth <= 767 && curWidth > 767 ) ) {
                slides.css('height', '');
                $win.off( 'scroll', this.lazyLoadOnScroll );
            }else if( ( this.prevWidth > 767 && curWidth <= 767 ) ) {
                slides.css('width', '');
                slides.each(function(){
                    var curSlideInner = $(this),    
                        curAspectRatio = ( curSlideInner.find( '.tatsu-carousel-img' ).attr( 'data-aspect-ratio' ) ) || 1;
                    if( null != curAspectRatio ) {
                        curSlideInner.height( curSlideInner.width()/curAspectRatio );
                    }
                });
                if( 0 < this.imagesToLazyLoad.length ) {
                    $win.on( 'scroll', this.lazyLoadOnScroll );
                }
            }else if( curWidth < 768 ) {
                slides.each(function(){
                    var curSlideInner = $(this),    
                        curAspectRatio = ( curSlideInner.find( '.tatsu-carousel-img' ).attr( 'data-aspect-ratio' ) ) || 1;
                    if( null != curAspectRatio ) {
                        curSlideInner.height( curSlideInner.width()/curAspectRatio );
                    }
                });
                if( 0 < this.imagesToLazyLoad.length ) {
                    $win.on( 'scroll', this.lazyLoadOnScroll );
                }
            }
        };
        TatsuCarousel.prototype.initVariableSlider = function() {
            if( '1' === this.ele.attr( 'data-variable-width' ) ) {
                var slides = this.ele.find( '.tatsu-carousel-col-inner' ),
                    carouselHeight = slides.height();
                if( 768 <= window.innerWidth ) {
                    slides.each(function() {
                        var curSlideInner = $(this),
                            curAspectRatio = ( curSlideInner.find( '.tatsu-carousel-img' ).attr( 'data-aspect-ratio' ) ) || 1;
                        if( null != curAspectRatio ) {
                            curSlideInner.width( carouselHeight * curAspectRatio );
                        }
                    });
                }else {
                    if( null == this.ele.attr( 'data-destroy-in-mobile' ) ) {
                        slides.each(function() {
                            var curSlideInner = $(this),
                                curAspectRatio = curSlideInner.find( '.tatsu-carousel-img' ).attr( 'data-aspect-ratio' );
                            if( null != curAspectRatio ) {
                                curSlideInner.height( curSlideInner.width()/curAspectRatio );
                            }
                        });
                    }
                }
            }  
        };
        TatsuCarousel.prototype.updateVariableSlider = function() {
            var slides = this.ele.find( '.tatsu-carousel-col-inner' ),
                curWidth = window.innerWidth,
                carouselHeight = slides.height();
            if( null == this.ele.attr( 'data-destroy-in-mobile' ) ) {
                if( ( this.prevWidth <= 767 && curWidth > 767 ) || ( this.prevWidth > 767 && curWidth <= 767 ) ) {
                    //flickity doesnt have option to change option on a already initialized slider
                    this.destroy();
                    new TatsuCarousel(this.ele); 
                }else if( 768 <= window.innerWidth ) {
                    slides.each(function(){
                        var curSlideInner = $(this),
                            curAspectRatio = curSlideInner.find( '.tatsu-carousel-img' ).attr( 'data-aspect-ratio' );
                        if( null != curAspectRatio ) {
                            curSlideInner.width( carouselHeight * curAspectRatio );
                        }
                    });
                }else {
                    slides.css( 'width', '' );
                    slides.each(function() {
                        var curSlideInner = $(this),
                            curAspectRatio = curSlideInner.find( '.tatsu-carousel-img' ).attr( 'data-aspect-ratio' );
                        if( null != curAspectRatio ) {
                            curSlideInner.height( curSlideInner.width()/curAspectRatio );
                        }
                    });
                }
                if( this.ele.hasClass( 'flickity-enabled' ) ) {
                    this.ele.flickity( 'reposition' );
                }
            }else {
                if( 768 <= window.innerWidth ) {
                    slides.each(function(){
                        var curSlideInner = $(this),
                            curAspectRatio = curSlideInner.find( '.tatsu-carousel-img' ).attr( 'data-aspect-ratio' );
                        if( null != curAspectRatio ) {
                            curSlideInner.width( carouselHeight * curAspectRatio );
                        }
                    });
                    if( this.ele.hasClass( 'flickity-enabled' ) ) {
                        this.ele.flickity( 'reposition' );
                    }
                }else {
                    if( null == this.ele.attr( 'data-lazy-load' ) ) {
                        slides.css( 'width', '' );
                    }
                }
            }
            
        };
        TatsuCarousel.prototype.flickityInit = function() {
            if( '1' === this.ele.attr( 'data-lazy-load' ) ) {
                this.lazyLoad();
            }
            this.ele.addClass('tatsu-carousel-initialized');
        };
        TatsuCarousel.prototype.updatePreviousWidth = function() {
            this.prevWidth = window.innerWidth;
        };
        TatsuCarousel.prototype.initEvents = function() {
            this.ele.on( 'ready.flickity', this.flickityInit);
            if( '1' === this.ele.attr( 'data-lazy-load' ) ) {
                this.ele.on( 'scroll.flickity', this.throttledLazyLoad );
            }
            if( '1' === this.ele.attr( 'data-destroy-in-mobile' ) && '1' === this.ele.attr( 'data-lazy-load' ) ) {
                if( 768 > window.innerWidth  ) {
                    $win.on('scroll', this.lazyLoadOnScroll);
                    this.lazyLoadOnScroll();
                }
                $win.on('debouncedresize', this.destroyInMobile);
            }
            if( '1' === this.ele.attr( 'data-fullscreen' ) ) {
                $win.on( 'debouncedresize', this.updateFullscreenSlider );
            }
            if( '1' === this.ele.attr('data-variable-width') ) {
                $win.on( 'debouncedresize', this.updateVariableSlider );
            }
            
            $win.on('debouncedresize', this.updatePreviousWidth);
        };
        TatsuCarousel.prototype.removeEvents = function() {
            this.ele.off( 'ready.flickity', this.flickityInit);
            if( '1' === this.ele.attr( 'data-lazy-load' ) ) {
                this.ele.off( 'scroll.flickity', this.throttledLazyLoad );
            }
            if( '1' === this.ele.attr( 'data-destroy-in-mobile' ) && '1' === this.ele.attr( 'data-lazy-load' ) ) {
                $win.off('scroll', this.lazyLoadOnScroll);
                $win.off('debouncedresize', this.destroyInMobile);
            }
            if( '1' === this.ele.attr( 'data-fullscreen' ) ) {
                $win.off( 'debouncedresize', this.updateFullscreenSlider );
            }
            if( '1' === this.ele.attr('data-variable-width') ) {
                $win.off( 'debouncedresize', this.updateVariableSlider );
            }
            $win.off('debouncedresize', this.updatePreviousWidth);
        };
        TatsuCarousel.prototype.destroy = function() {
            this.ele.find('.tatsu-carousel-col-inner').css({height : '', width : ''});
            this.removeEvents();
            this.ele.flickity('destroy');
            this.ele.removeClass('tatsu-carousel-initialized');
        };
        TatsuCarousel.prototype.initLazyLoad = function() {
            this.imagesToLazyLoad = null;
            if( '1' === this.ele.attr( 'data-lazy-load' ) ) {
                this.imagesToLazyLoad = this.ele.find( '.tatsu-carousel-img-lazy-load' );
            }
        };
        TatsuCarousel.prototype.getDoppelgangers = function( images ) {
            var srcArray = [],
                doppelgangers = $();
            if( 0 < this.imagesToLazyLoad.length ) {
                images.each(function(){
                    srcArray.push($(this).attr('data-src'));
                });
                this.imagesToLazyLoad.each(function(){
                    var curImage = $(this);
                    if( 0 < curImage.length && null == curImage.attr( 'src' ) && -1 < srcArray.indexOf( curImage.attr( 'data-src' ) ) ) {
                        doppelgangers = doppelgangers.add(curImage);
                    }
                });
            }
            return doppelgangers;
        };
        TatsuCarousel.prototype.loadImages = function( images ) {   
            var isAdaptive = this.ele.hasClass( 'tatsu-carousel-adaptive-image' ); 
            images.one( 'load', function() {
                $(this).addClass( 'tatsu-carousel-img-lazy-loaded' );
            }).each(function(){
                var curImage = $(this);
                if( isAdaptive ) {
                    curImage.attr( 'srcset', curImage.attr( 'data-srcset' ) );
                }else {
                    curImage.attr( 'src', curImage.attr( 'data-src' ) );
                }
            });
            this.imagesToLazyLoad = this.imagesToLazyLoad.not( images );
            if( 0 == this.imagesToLazyLoad.length ) {
                this.ele.off( 'scroll.flickity', this.throttledLazyLoad );
            }
        };
        TatsuCarousel.prototype.getVisibleSlides = function() {
            var draggableContainer = this.ele.find( '.flickity-viewport' ),
                sliderLeft = draggableContainer.offset().left,
                boundaries = {
                    left : sliderLeft,
                    right : sliderLeft + draggableContainer.width()
                };
            return this.imagesToLazyLoad.filter(function() {
                var curImage = $(this),
                    imageSlide = curImage.parent(),
                    curImageLeft = imageSlide.offset().left,
                    curImageRight = imageSlide.offset().left + imageSlide.outerWidth(true);
                return ( ( curImageRight > boundaries.left && curImageRight <= boundaries.right ) || ( curImageLeft < boundaries.right && curImageLeft >= boundaries.left ) );
            });
        };
        TatsuCarousel.prototype.lazyLoad = function() {
            if( 0 < this.imagesToLazyLoad.length ) {
                var visibleImages = this.getVisibleSlides();
                if( null != visibleImages && 0 < visibleImages.length ) {
                    this.loadImages(visibleImages);
                }
            }
        };
        TatsuCarousel.prototype.initFlickity = function() {
            this.ele.flickity( this.settings );
        };
        return TatsuCarousel;
}, jQuery );