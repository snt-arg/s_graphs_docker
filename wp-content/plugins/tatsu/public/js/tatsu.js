;(function($) {
    'use strict';
    $(document).on('click','a.tatsu_doc_link',function(){
        var doc_link = $(this).attr('href');
        window.open(doc_link,'_blank');
    });
	/**
   * Resize Background Video
   */
    $.fn.tatsuResizeMedia = function() {
        if( this.length > 0 ) {
            this.each(function () {
                var $img = jQuery(this), 
                $section = $img.parent(), 
                windowWidth = $section.width(), 
                windowHeight = $section.outerHeight(), 
                r_w = windowHeight / windowWidth, 
                i_w = $img.width(), 
                i_h = $img.height(), 
                r_i = i_h / i_w, 
                new_w, 
                new_h;
                
                if (r_w > r_i) {
                    new_h = windowHeight;
                    new_w = windowHeight / r_i;
                } else {
                    new_h = windowWidth * r_i;
                    new_w = windowWidth;
                }
                $img.css({
                    width : new_w,
                    height : new_h,
                    left : (windowWidth - new_w) / 2,
                    top : (windowHeight - new_h) / 2,
                    display : 'block'
                });
            });
        }
  };
    
})(jQuery);

(function( $ ) {
    'use strict';

    var vendorScriptsUrl = tatsuFrontendConfig.vendorScriptsUrl,
        dependencies = tatsuFrontendConfig.dependencies || {},
        maps_api_key = tatsuFrontendConfig.mapsApiKey;


    if( 'undefined' != typeof dependencies ) {
		for( var dependency in dependencies ) {
			if( dependencies.hasOwnProperty( dependency ) ) {
				asyncloader.register( dependencies[ dependency ], dependency );
			}
		}
    }
    asyncloader.register( 'https://maps.googleapis.com/maps/api/js?key='+maps_api_key, 'google_maps_api' );
    asyncloader.register( "https://player.vimeo.com/api/player.js", 'vimeonew' );

    var tatsu = (function() {

        var $win = jQuery(window),
            $body = jQuery('body'),
            $html = jQuery('html'),
            $pluginUrl = tatsuFrontendConfig.pluginUrl,
            tatsuCallbacks = {},
            didScroll = false,
            animate_wrapper = jQuery('.tatsu-animate, .be-animate'),
            skillsWrap = jQuery( '.be-skill' ),
            animatedHeadings = jQuery('.tatsu-animated-heading-wrap'),
            scrollInterval,
            animateWrapperCount = animate_wrapper.length,
            alreadyVisibleIndex = 0,
            animatedNumberWrap = jQuery('.tatsu-an'),
            totalAnimCount = animate_wrapper.length + animatedNumberWrap.length,

        animatedAnchor = function() {

            jQuery(document).on( 'mouseenter.tatsu mouseleave.tatsu', '.be-animated-anchor', function(e) {
                
                var $this = jQuery( this ),
                    hoverColor,
                    borderColor,
                    color;
                if( 'mouseenter' === e.type ) {
                    hoverColor = $this.attr( 'data-hover-color' ) || '';
                    if( !$this.hasClass( 'be-style1' ) ) {
                        $this.css( 'color', hoverColor );
                        return;
                    }
                    borderColor = $this.attr( 'data-border-color' );
                    $this.css({
                        borderColor : '',
                        backgroundColor : borderColor,
                        color : hoverColor
                    });
                }else{
                    color = $this.attr( 'data-color' ) || '';
                    if( !$this.hasClass( 'be-style1' ) ) {
                        $this.css( 'color', color );
                        return;
                    }
                    borderColor = $this.attr( 'data-border-color' );
                    $this.css({
                        borderColor : borderColor,
                        backgroundColor : '',
                        color : color
                    });
                }

            });

        },

        closeNotification = function() {
            jQuery(document).on('click.tatsu', '.tatsu-notification .close', function (e) {
                e.preventDefault();
                jQuery(this).closest('.tatsu-notification').slideUp(500);
            });
        },

        animatedNumbers = function() {
            if(animatedNumberWrap.length > 0) {
               asyncloader.require( 'countTo', function() {
                    animatedNumberWrap.each(function (i, el) {
                        var el = jQuery(el);
                        if( el.hasClass('animate') ) {
                            if ( el.isVisible(true) || $body.hasClass( 'tatsu-frame' ) ) {
                                el.removeClass('animate');
                                var $endval = Number( el.attr( 'data-number' ) );
                                el.countTo({
                                    from : 0,
                                    to : $endval,
                                    speed : 1500,
                                    refreshInterval : 30
                                });
                                alreadyVisibleIndex ++;
                                if( alreadyVisibleIndex >= totalAnimCount ) {
                                    clearTimeout(scrollInterval);
                                }
                            }
                        }
                    });
                });
            }
        }, 

        builderAnimate = function( animationDetails ) {
            var moduleId = animationDetails.id,
                animation = animationDetails.animation,
                animationDuration = animationDetails.animationDuration,
                animationDelay = animationDetails.animationDelay,
                animationEle = jQuery('.be-pb-observer-' + moduleId);
            if( animationEle.length ) {
                animationEle.removeClass('animated flipInX flipInY fadeIn fadeInDown fadeInLeft fadeInRight fadeInUp slideInDown slideInLeft slideInRight rollIn rollOut bounce bounceIn bounceInUp bounceInDown bounceInLeft bounceInRight fadeInUpBig fadeInDownBig fadeInLeftBig fadeInRightBig flash flip lightSpeedIn pulse rotateIn rotateInUpLeft rotateInDownLeft rotateInUpRight rotateInDownRight shake swing tada wiggle wobble infiniteJump zoomIn none already-visible end-animation');
                setTimeout(function() {
                    animationEle.css( 'animation-delay', animationDelay + 'ms' );
                    animationEle.css( 'animation-duration', animationDuration + 'ms' );
                    animationEle.one('webkitAnimationStart oanimationstart msAnimationStart animationstart',  function(e) {
                        animationEle.addClass("end-animation");
                    });
                    animationEle.addClass( animation );
                }, 10);
            }
        },

        cssAnimate = function( shouldUpdate, moduleId, context ) {
            var filteredElements = null;
            if(animateWrapperCount > 0) {
                if( null != context ) {
                    filteredElements = animate_wrapper.filter( function() {
                        return 0  < jQuery( this ).closest( context ).length;
                    } );
                }else {
                    filteredElements = animate_wrapper;
                }
                filteredElements.each(function (i, el) {     
                    var el = jQuery(el);
                    if(!el.hasClass('already-visible')) {
                        var animationDelay = el.attr('data-animation-delay');
                        var animationDuration = el.attr('data-animation-duration');
                        el.css( 'animation-delay', animationDelay + 'ms' );
                        el.css( 'animation-duration', animationDuration + 'ms' );
                        el.one('webkitAnimationStart oanimationstart msAnimationStart animationstart',  
                            function(e) {
                                el.addClass("end-animation");
                            });
                        // if( null != context ) {

                        // }else {
                            if( el.isVisible(true) && ( $win.innerHeight() - el[0].getBoundingClientRect().top > 40 ) ) {                           
                                el.addClass("already-visible");
                                el.addClass(el.attr('data-animation'));
                                // el.addClass('animated');
                                alreadyVisibleIndex ++;
                                if( alreadyVisibleIndex >= totalAnimCount && !$body.hasClass('tatsu-frame') ) {
                                    clearInterval(scrollInterval);
                                }
                            }
                        // }
                    }
                });
            }
        },

        imgCarouselLightbox = function(){
            if (jQuery('.light_box').length > 0) {
                asyncloader.require( 'magnificpopup', function() {
                        jQuery('.light_box').magnificPopup({ 
                            type: 'image',
                            closeBtnInside: false,
                            closeOnContentClick: false,
                      
                            callbacks: {
                              open: function() {
                                var self = this;
                                self.wrap.on('click.pinhandler', 'img', function() {
                                  self.wrap.toggleClass('mfp-force-scrollbars');
                                });
                              },
                              beforeClose: function() {
                                    this.wrap.off('click.pinhandler');
                                this.wrap.removeClass('mfp-force-scrollbars');
                              }
                            },
                     
                            image: {
                                verticalFit: true
                            },
                            zoom: {
                                enabled: true,
                                duration: 800
                            },
                            gallery: {
                                enabled: true
                            }

                        });
  
                });
            }     
        },

        lightbox = function() {
            if (jQuery('.mfp-image').length > 0) {
                asyncloader.require( 'magnificpopup', function() {

                    var mfpImages = jQuery( '.mfp-image' ),
                        galleryEnabledMfpImages = mfpImages.filter( function() {
                            return 0 == jQuery( this ).closest( '.tatsu-single-image' ).length;
                        
                        } ),
                        galleryDisabledMfpImages = mfpImages.not( galleryEnabledMfpImages );
                    if( 0 < galleryEnabledMfpImages.length ) {
                        galleryEnabledMfpImages.magnificPopup({
                            mainClass: 'mfp-img-mobile my-mfp-zoom-in',
                            closeOnContentClick: true,
                            gallery: {
                                enabled: true
                            },
                            image: {
                                verticalFit: true,
                                titleSrc: 'title'
                            },
                            zoom: {
                                enabled: false,
                                duration: 300
                            },
                            preloader: true,
                            type: 'inline',
                            overflowY: 'auto',
                            removalDelay: 300,
                            callbacks: {
                                afterClose: function () {
                                },
                                open: function () {
                                    jQuery('body').addClass('mfp-active-state');
                                },
                                close: function () {
                                    jQuery('body').removeClass('mfp-active-state');
                                }
                            }
                        });
                    }
                    if( 0 < galleryDisabledMfpImages.length ) {
                        galleryDisabledMfpImages.magnificPopup({
                            mainClass: 'mfp-img-mobile my-mfp-zoom-in',
                            closeOnContentClick: true,
                            gallery: {
                                enabled: false
                            },
                            image: {
                                verticalFit: true,
                                titleSrc: 'title'
                            },
                            zoom: {
                                enabled: false,
                                duration: 300
                            },
                            preloader: true,
                            type: 'inline',
                            overflowY: 'auto',
                            removalDelay: 300,
                            callbacks: {
                                afterClose: function () {
                                },
                                open: function () {
                                    jQuery('body').addClass('mfp-active-state');
                                },
                                close: function () {
                                    jQuery('body').removeClass('mfp-active-state');
                                }
                            }
                        });
                    }
                    
                } );
                
            }
            if(jQuery('.mfp-iframe').length > 0) {
                 asyncloader.require( 'magnificpopup', function() {
                    jQuery('.mfp-iframe').magnificPopup({
                        iframe: {  
                            patterns: {
                                youtube: {
                                  index: 'youtube.com/',
                                  id: 'v=', 
                                  src: '//www.youtube.com/embed/%id%?autoplay=1&rel=0&showinfo=0'
                                },
                                vimeo: {
                                  index: 'vimeo.com/',
                                  id: '/',
                                  src: '//player.vimeo.com/video/%id%?autoplay=1'
                                },
                                gmaps: {
                                  index: '//maps.google.',
                                  src: '%id%&output=embed'
                                }                
                            }
                        }
                    });
                });
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
                            loopVideo = null != curVideo.attr( 'data-loop' ) ? parseInt(curVideo.attr( 'data-loop' )) : false,
                            muted = null != curVideo.attr( 'data-muted' ) ? parseInt(curVideo.attr( 'data-muted' )) : false;
                        if( null != id ) {
                            var curPlayer = new Vimeo.Player( this, {
                                id : id,
                                autoplay : autoplay ? true : false,
                                loop : loopVideo ? true : false,
                                muted : muted ? true : false,
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
        tatsu_fitvids = function(){
            asyncloader.require( 'fitvids',function(){
                if( $('iframe').length ){
                    $('body').fitVids();
                }
            } );
       
        },
        gmaps = function() {
            if(jQuery('.tatsu-gmap').length > 0) {
                 asyncloader.require( 'google_maps_api' , function() {
                    var styles = {
                        black : [{"featureType" : "water", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}, {"lightness" : 17}]}, {"featureType" : "landscape", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}, {"lightness" : 20}]}, {"featureType" : "road.highway", "elementType" : "geometry.fill", "stylers" : [{"color" : "#000000"}, {"lightness" : 17}]}, {"featureType" : "road.highway", "elementType" : "geometry.stroke", "stylers" : [{"color" : "#000000"}, {"lightness" : 29}, {"weight" : 0.2}]}, {"featureType" : "road.arterial", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}, {"lightness" : 18}]}, {"featureType" : "road.local", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}, {"lightness" : 16}]}, {"featureType" : "poi", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}, {"lightness" : 21}]}, {"elementType" : "labels.text.stroke", "stylers" : [{"visibility" : "on"}, {"color" : "#000000"}, {"lightness" : 16}]}, {"elementType" : "labels.text.fill", "stylers" : [{"saturation" : 36}, {"color" : "#000000"}, {"lightness" : 40}]}, {"elementType" : "labels.icon", "stylers" : [{"visibility" : "off"}]}, {"featureType" : "transit", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}, {"lightness" : 19}]}, {"featureType" : "administrative", "elementType" : "geometry.fill", "stylers" : [{"color" : "#000000"}, {"lightness" : 20}]}, {"featureType" : "administrative", "elementType" : "geometry.stroke", "stylers" : [{"color" : "#000000"}, {"lightness" : 17}, {"weight" : 1.2}]}],
                        greyscale: [{"featureType" : "landscape", "stylers" : [{"saturation" : -100}, {"lightness" : 65}, {"visibility" : "on"}]}, {"featureType" : "poi", "stylers" : [{"saturation" : -100}, {"lightness" : 51}, {"visibility" : "simplified"}]}, {"featureType" : "road.highway", "stylers" : [{"saturation" : -100}, {"visibility" : "simplified"}]}, {"featureType" : "road.arterial", "stylers" : [{"saturation" : -100}, {"lightness" : 30}, {"visibility" : "on"}]}, {"featureType" : "road.local", "stylers" : [{"saturation" : -100}, {"lightness" : 40}, {"visibility" : "on"}]}, {"featureType" : "transit", "stylers" : [{"saturation" : -100}, {"visibility" : "simplified"}]}, {"featureType" : "administrative.province", "stylers" : [{"visibility" : "off"}]}, {"featureType" : "water", "elementType" : "labels", "stylers" : [{"visibility" : "on"}, {"lightness" : -25}, {"saturation" : -100}]}, {"featureType" : "water", "elementType" : "geometry", "stylers" : [{"hue" : "#ffff00"}, {"lightness" : -25}, {"saturation" : -97}]}],
                        midnight: [{"featureType" : "water", "stylers" : [{"color" : "#021019"}]}, {"featureType" : "landscape", "stylers" : [{"color" : "#08304b"}]}, {"featureType" : "poi", "elementType" : "geometry", "stylers" : [{"color" : "#0c4152"}, {"lightness" : 5}]}, {"featureType" : "road.highway", "elementType" : "geometry.fill", "stylers" : [{"color" : "#000000"}]}, {"featureType" : "road.highway", "elementType" : "geometry.stroke", "stylers" : [{"color" : "#0b434f"}, {"lightness" : 25}]}, {"featureType" : "road.arterial", "elementType" : "geometry.fill", "stylers" : [{"color" : "#000000"}]}, {"featureType" : "road.arterial", "elementType" : "geometry.stroke", "stylers" : [{"color" : "#0b3d51"}, {"lightness" : 16}]}, {"featureType" : "road.local", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}]}, {"elementType" : "labels.text.fill", "stylers" : [{"color" : "#ffffff"}]}, {"elementType" : "labels.text.stroke", "stylers" : [{"color" : "#000000"}, {"lightness" : 13}]}, {"featureType" : "transit", "stylers" : [{"color" : "#146474"}]}, {"featureType" : "administrative", "elementType" : "geometry.fill", "stylers" : [{"color" : "#000000"}]}, {"featureType" : "administrative", "elementType" : "geometry.stroke", "stylers" : [{"color" : "#144b53"}, {"lightness" : 14}, {"weight" : 1.4}]}],
                        standard: [],
                        bluewater: [{"featureType" : "water", "stylers" : [{"color" : "#46bcec"}, {"visibility" : "on"}]}, {"featureType" : "landscape", "stylers" : [{"color" : "#f2f2f2"}]}, {"featureType" : "road", "stylers" : [{"saturation" : -100}, {"lightness" : 45}]}, {"featureType" : "road.highway", "stylers" : [{"visibility" : "simplified"}]}, {"featureType" : "road.arterial", "elementType" : "labels.icon", "stylers" : [{"visibility" : "off"}]}, {"featureType" : "administrative", "elementType" : "labels.text.fill", "stylers" : [{"color" : "#444444"}]}, {"featureType" : "transit", "stylers" : [{"visibility" : "off"}]}, {"featureType" : "poi", "stylers" : [{"visibility" : "off"}]}],
                        lightdream: [
                            {
                                "featureType": "landscape",
                                "stylers": [
                                    {
                                        "hue": "#FFBB00"
                                    },
                                    {
                                        "saturation": 43.400000000000006
                                    },
                                    {
                                        "lightness": 37.599999999999994
                                    },
                                    {
                                        "gamma": 1
                                    }
                                ]
                            },
                            {
                                "featureType": "road.highway",
                                "stylers": [
                                    {
                                        "hue": "#FFC200"
                                    },
                                    {
                                        "saturation": -61.8
                                    },
                                    {
                                        "lightness": 45.599999999999994
                                    },
                                    {
                                        "gamma": 1
                                    }
                                ]
                            },
                            {
                                "featureType": "road.arterial",
                                "stylers": [
                                    {
                                        "hue": "#FF0300"
                                    },
                                    {
                                        "saturation": -100
                                    },
                                    {
                                        "lightness": 51.19999999999999
                                    },
                                    {
                                        "gamma": 1
                                    }
                                ]
                            },
                            {
                                "featureType": "road.local",
                                "stylers": [
                                    {
                                        "hue": "#FF0300"
                                    },
                                    {
                                        "saturation": -100
                                    },
                                    {
                                        "lightness": 52
                                    },
                                    {
                                        "gamma": 1
                                    }
                                ]
                            },
                            {
                                "featureType": "water",
                                "stylers": [
                                    {
                                        "hue": "#0078FF"
                                    },
                                    {
                                        "saturation": -13.200000000000003
                                    },
                                    {
                                        "lightness": 2.4000000000000057
                                    },
                                    {
                                        "gamma": 1
                                    }
                                ]
                            },
                            {
                                "featureType": "poi",
                                "stylers": [
                                    {
                                        "hue": "#00FF6A"
                                    },
                                    {
                                        "saturation": -1.0989010989011234
                                    },
                                    {
                                        "lightness": 11.200000000000017
                                    },
                                    {
                                        "gamma": 1
                                    }
                                ]
                            }
                        ],
                        wy: [
                            {
                                "featureType": "all",
                                "elementType": "geometry.fill",
                                "stylers": [
                                    {
                                        "weight": "2.00"
                                    }
                                ]
                            },
                            {
                                "featureType": "all",
                                "elementType": "geometry.stroke",
                                "stylers": [
                                    {
                                        "color": "#9c9c9c"
                                    }
                                ]
                            },
                            {
                                "featureType": "all",
                                "elementType": "labels.text",
                                "stylers": [
                                    {
                                        "visibility": "on"
                                    }
                                ]
                            },
                            {
                                "featureType": "landscape",
                                "elementType": "all",
                                "stylers": [
                                    {
                                        "color": "#f2f2f2"
                                    }
                                ]
                            },
                            {
                                "featureType": "landscape",
                                "elementType": "geometry.fill",
                                "stylers": [
                                    {
                                        "color": "#ffffff"
                                    }
                                ]
                            },
                            {
                                "featureType": "landscape.man_made",
                                "elementType": "geometry.fill",
                                "stylers": [
                                    {
                                        "color": "#ffffff"
                                    }
                                ]
                            },
                            {
                                "featureType": "poi",
                                "elementType": "all",
                                "stylers": [
                                    {
                                        "visibility": "off"
                                    }
                                ]
                            },
                            {
                                "featureType": "road",
                                "elementType": "all",
                                "stylers": [
                                    {
                                        "saturation": -100
                                    },
                                    {
                                        "lightness": 45
                                    }
                                ]
                            },
                            {
                                "featureType": "road",
                                "elementType": "geometry.fill",
                                "stylers": [
                                    {
                                        "color": "#eeeeee"
                                    }
                                ]
                            },
                            {
                                "featureType": "road",
                                "elementType": "labels.text.fill",
                                "stylers": [
                                    {
                                        "color": "#7b7b7b"
                                    }
                                ]
                            },
                            {
                                "featureType": "road",
                                "elementType": "labels.text.stroke",
                                "stylers": [
                                    {
                                        "color": "#ffffff"
                                    }
                                ]
                            },
                            {
                                "featureType": "road.highway",
                                "elementType": "all",
                                "stylers": [
                                    {
                                        "visibility": "simplified"
                                    }
                                ]
                            },
                            {
                                "featureType": "road.arterial",
                                "elementType": "labels.icon",
                                "stylers": [
                                    {
                                        "visibility": "off"
                                    }
                                ]
                            },
                            {
                                "featureType": "transit",
                                "elementType": "all",
                                "stylers": [
                                    {
                                        "visibility": "off"
                                    }
                                ]
                            },
                            {
                                "featureType": "water",
                                "elementType": "all",
                                "stylers": [
                                    {
                                        "color": "#46bcec"
                                    },
                                    {
                                        "visibility": "on"
                                    }
                                ]
                            },
                            {
                                "featureType": "water",
                                "elementType": "geometry.fill",
                                "stylers": [
                                    {
                                        "color": "#c8d7d4"
                                    }
                                ]
                            },
                            {
                                "featureType": "water",
                                "elementType": "labels.text.fill",
                                "stylers": [
                                    {
                                        "color": "#070707"
                                    }
                                ]
                            },
                            {
                                "featureType": "water",
                                "elementType": "labels.text.stroke",
                                "stylers": [
                                    {
                                        "color": "#ffffff"
                                    }
                                ]
                            }
                        ],
                        blueessence: [
                            {
                                "featureType": "landscape.natural",
                                "elementType": "geometry.fill",
                                "stylers": [
                                    {
                                        "visibility": "on"
                                    },
                                    {
                                        "color": "#e0efef"
                                    }
                                ]
                            },
                            {
                                "featureType": "poi",
                                "elementType": "geometry.fill",
                                "stylers": [
                                    {
                                        "visibility": "on"
                                    },
                                    {
                                        "hue": "#1900ff"
                                    },
                                    {
                                        "color": "#c0e8e8"
                                    }
                                ]
                            },
                            {
                                "featureType": "road",
                                "elementType": "geometry",
                                "stylers": [
                                    {
                                        "lightness": 100
                                    },
                                    {
                                        "visibility": "simplified"
                                    }
                                ]
                            },
                            {
                                "featureType": "road",
                                "elementType": "labels",
                                "stylers": [
                                    {
                                        "visibility": "off"
                                    }
                                ]
                            },
                            {
                                "featureType": "transit.line",
                                "elementType": "geometry",
                                "stylers": [
                                    {
                                        "visibility": "on"
                                    },
                                    {
                                        "lightness": 700
                                    }
                                ]
                            },
                            {
                                "featureType": "water",
                                "elementType": "all",
                                "stylers": [
                                    {
                                        "color": "#7dcdcd"
                                    }
                                ]
                            }
                        ]


                    };
                    jQuery('.tatsu-gmap').each(function () {
                        var $address = jQuery(this).attr('data-address'), 
                        $zoom = Number( jQuery(this).attr('data-zoom') ), 
                        $lat = jQuery(this).attr('data-latitude'), 
                        $lan = jQuery(this).attr('data-longitude'), 
                        $custom_marker = jQuery(this).attr('data-marker'), 
                        map_style = jQuery(this).attr('data-style'), 
                        mapOptions = {
                            zoom: $zoom,
                            scrollwheel: false,
                            navigationControl: false,
                            mapTypeControl: false,
                            scaleControl: false,
                            streetViewControl: false,
                            center: new google.maps.LatLng(parseFloat($lat), parseFloat($lan)),
                            styles: styles[map_style]
                        }, map = new google.maps.Map(jQuery(this)[0], mapOptions), marker = new google.maps.Marker({
                            position: new google.maps.LatLng(parseFloat($lat), parseFloat($lan)),
                            map: map,
                            title: $address,
                            icon: $custom_marker
                        });
                        marker.setMap(map);
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
                    if ( $this.isVisible(true) ) {
                        if ( $this.closest('.skill_container').hasClass('skill-vertical') ) {
                            $animate_property = 'height';
                        }
                        $this.css( $animate_property, $this.attr( 'data-skill-value' ) );
                    }
                });
            }
        },

        // backgroundVideo = function() {
        //   asyncloader.require( 'resizetoparent', function () {
        //     var bgVideoWrap = jQuery( '.tatsu-bg-video, .be-bg-video' );
        //     if ( bgVideoWrap.length > 0 ) {
        //       bgVideoWrap.each( function() {
        //         jQuery(this).load();
        //         jQuery(this).on("loadedmetadata", function () { 
        //             jQuery(this).css({
        //                 width: this.videoWidth,
        //                 height: this.videoHeight
        //             });
        //             jQuery(this).tatsuResizeMedia();
        //             jQuery(this).css('display', 'block');
        //         });
        //         //jQuery(this).tatsuResizeMedia();
        //       });
        //     }
        //   });            
        // },
        tatsuSection = function() {
           parallax();
        },
        lineAnimate = function() {
            var svgIcons = $( '.tatsu-line-animate' );
            if( 0 < svgIcons.length ) {
                asyncloader.require( 'vivus', function(){
                    svgIcons.each(function(){
                        var curIcon = $(this),
                            svgOptions = {},
                            animDuration = curIcon.attr( 'data-line-animation-duration' ),
                            animTimingFunc = curIcon.attr( 'data-svg-animation' ) || 'EASE',
                            pathTimingFunc = curIcon.attr( 'data-path-animation' ) || 'EASE',
                            svgIconEle = curIcon.find( 'svg' );
                        if( 0 < svgIconEle.length ) {
                            svgIconEle = svgIconEle[0];
                            svgOptions.onReady = function(e) {
                                curIcon.addClass('tatsu-line-animate-ready');
                            };
                            svgOptions.duration = Number( animDuration ) || 80;
                            if( null != animTimingFunc ) {
                               svgOptions.animTimingFunction = Vivus[ animTimingFunc ];
                            }
                            if( null != pathTimingFunc ) {
                                svgOptions.pathTimingFunction = Vivus[ pathTimingFunc ]; 
                            }
                            new Vivus( svgIconEle, 
                                svgOptions,
                                function( vivusObj ) {
                                    curIcon.addClass('tatsu-line-animated');
                                }
                            );
                        }
                    });
                });
            }
        },
        lazyLoadBgImages = function() {
            var bgToLazyLoad = $( '.tatsu-bg-lazyload' );
            if( 0 < bgToLazyLoad.length ) {
                bgToLazyLoad.each(function() {
                    var curEle = $(this),
                        curSrc = curEle.attr( 'data-src' ),
                        dummyImg;
                    if( null != curSrc ) {
                        dummyImg = $(new Image());
                        dummyImg.one('load', function() {
                            curEle.addClass( 'tatsu-bg-lazyloaded' );
                            setTimeout(function() {
                                curEle.parent().find('.tatsu-bg-blur').remove();
                            }, 1000);
                        });
                        dummyImg.attr( 'src', curSrc );
                        if(dummyImg[0].complete) {
                            dummyImg.load();
                        }
                    }
                });
            }
        },
        carousel = function() {
            var carousels = $( '.tatsu-carousel' );
            if( 0 < carousels.length ) {
                asyncloader.require( [ 'flickity', 'tatsuCarousel' ], function() {
                    carousels.each(function() {
                        new TatsuCarousel($(this));
                    });
                });
            }
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
        slider = function() {
            var sliders = $( '.be-slider' ),    
                initOuterArrows = function( slider ) {
                    if( slider instanceof $ && 0 < slider.length && !slider.hasClass( 'be-slider-with-margin' ) && ( 100 < ( $win.width() - slider.outerWidth() ) ) ) {
                        var gutter = !isNaN( slider.attr('data-gutter') ) ? Number( slider.attr('data-gutter') )/2 : 0;
                        slider.css({
                            padding : '0 50px',
                            margin : '0 -' + ( gutter + 50 ) + 'px'
                        });
                    }
                },
                getLazyLoadCount = function(slider){
                    var count = 1;
                    if( slider instanceof $ && 0 < slider.length ) {
                    var cols = !isNaN(Number(slider.attr('data-cols'))) ? Number(slider.attr('data-cols')) : 1;
                        if( 1 < cols ) {
                            count = cols-1;
                        }
                    }
                    return count;
                },
                hideUnneccessaryNav = function( curSlider ) {
                    var navPossible = function( slider ) {
                        var cols,
                            slidesClount;
                        if( slider instanceof $ && 0 < slider.length ) {
                            cols = !isNaN(Number(slider.attr('data-cols'))) ? Number(slider.attr('data-cols')) : 1;
                            slidesClount = slider.find('.be-slide').length;
                            if( 1024 < $win.width() ) {
                                return cols < slidesClount;
                            }else if( 767 < $win.width() ) {
                                return 2 < slidesClount;
                            }else {
                                return 1 < slidesClount;
                            }
                        }
                    };
                    if( !navPossible( curSlider ) ) {
                        curSlider.addClass('be-slider-hide-nav');
                    }
                    $win.on( 'debouncedresize', function() {
                        if( !navPossible(curSlider) ) {
                            curSlider.addClass('be-slider-hide-nav');
                        }else {
                            curSlider.removeClass('be-slider-hide-nav');
                        }
                    });
                },
                equalHeightSlider = function( slider ) {
                    if( slider instanceof $ && 0 < slider.length ) {
                        var maxHeight = 0,
                            slides = slider.find( '.be-slide' );
                        slides.each(function(){
                            var curSlide = $(this);
                            if( maxHeight < curSlide.height() ) {
                                maxHeight = curSlide.height();
                            }
                        });
                        slides.height( maxHeight );
                        slider.addClass( 'be-equal-height-slider' );
                    }
                };
            if( 0 < sliders.length ) {
                asyncloader.require( 'flickity', function() {
                    sliders.each(function() {
                        var curSlider = jQuery(this);
                        if( !curSlider.hasClass( 'flickity-enabled' ) ) {
                            if( '1' == curSlider.attr( 'data-arrows' ) || '1' == curSlider.attr( 'data-dots' ) ) {
                                hideUnneccessaryNav(curSlider);
                            }
                            if( '1' == curSlider.attr('data-arrows') && '1' == curSlider.attr('data-outer-arrows')) {
                                initOuterArrows(curSlider);
                            }
                            if( '1' == curSlider.attr( 'data-equal-height' ) ) {
                                equalHeightSlider(curSlider);
                            }
                            curSlider.flickity({
                                cellAlign : null != curSlider.attr( 'data-cell-align' ) ? curSlider.attr( 'data-cell-align' ) : 'left',
                                contain : true,
                                lazyLoad : '1' == curSlider.attr( 'data-lazy-load' ) ? getLazyLoadCount(curSlider) : false,
                                adaptiveHeight : '1' == curSlider.attr( 'data-adaptive-height' ) ? true : false,
                                pageDots : '1' == curSlider.attr('data-dots') ? true : false,
                                prevNextButtons : '1' == curSlider.attr('data-arrows') ? true : false,
                                asNavFor : null != curSlider.attr('data-as-nav-for') ? curSlider.attr('data-as-nav-for') : false,
                                autoPlay : !isNaN(Number(curSlider.attr('data-auto-play'))) ? Number(curSlider.attr('data-auto-play')) : false,
                                wrapAround : '1' == curSlider.attr('data-infinite') ? true : false,
                            });
                        }
                    });
                });
            }
        },
        grid = function() {
            asyncloader.require( [ 'isotope', 'begrid' ], function() {
                var grids = $( '.be-grid[data-layout = "metro"], .be-grid[data-layout = "masonry"]' );
                grids.each( function() {
                    new BeGrid(this);
                });
            });
        },
        tatsuGallery = function(){
            grid();
        },

        registerCallbacks = function() {
            tatsuCallbacks['tatsu_video'] = tatsu_fitvids;
            tatsuCallbacks['tatsu_gmaps'] = gmaps;
            tatsuCallbacks['tatsu_animated_numbers'] = animatedNumbers;
            tatsuCallbacks[ 'tatsu_section' ] = tatsuSection;
            tatsuCallbacks[ 'tatsu_column' ] = tatsuColumn;
            tatsuCallbacks[ 'tatsu_image' ] = lightbox;
            tatsuCallbacks[ 'tatsu_skills' ] = progressBar;
            tatsuCallbacks[ 'tatsu_row' ] = tatsuRow;
            tatsuCallbacks[ 'tatsu_gallery' ] = tatsuGallery;
            tatsuCallbacks[ 'tatsu_tabs' ] = tatsu_tabs;
            tatsuCallbacks[ 'tatsu_accordion' ] = tatsu_accordion;
            tatsuCallbacks[ 'tatsu_lists' ] = listsTimeline;
            tatsuCallbacks[ 'tatsu_typed_text' ] = typedText;
            tatsuCallbacks[ 'tatsu_animated_heading' ] = animatedHeading;
        },

        parallax = function() {
          var parallaxContainer = jQuery('.tatsu-parallax');
          if( parallaxContainer.length > 0 ) {
            asyncloader.require( 'tatsuParallax', function() {
              parallaxContainer.tatsuParallax({
                speed: 0.3
              });
            });
          }
        },
        tatsuRow = function(){
            stickyColumn();
        },
        columnParallax = function() {
            var columnParallaxContainer = jQuery( '.tatsu-column-parallax' );
            if( columnParallaxContainer.length > 0 ) {
                asyncloader.require( 'tatsuColumnParallax', function(){
                    columnParallaxContainer.tatsuColumnParallax({
                        speed : 7
                    });
                });
            }
        },
        columnTilt = function(shouldUpdate,moduleId){

            var columnTiltContainer = jQuery( '.tatsu-column-effect-tilt > div' );
            asyncloader.require( 'tilt',function(){
            
                if(shouldUpdate){
                        var temp1 = jQuery('.be-pb-observer-'+moduleId);
                    if( temp1.hasClass('tatsu-column-effect-tilt') ){
                        temp1.children().tilt();
                    }else{
                        var newTiltObj = temp1.children().eq(0).tilt();
                        newTiltObj.tilt.destroy.call(newTiltObj);
                    }
                } else {
                    columnTiltContainer.tilt({
                        scale: 1.1,
                        perspective: 1000,
                        speed: 4000,
                        //easing: 'ease',
                        maxTilt: 10,
                    });
                }
            });
        },

        stickyColumn = function() {
            var tatsuStickyColumn = jQuery('.tatsu-column-sticky');
            if( 0 < tatsuStickyColumn.length ) {
                jQuery(window).on( 'load', function(e) {
                    asyncloader.require('stickykit',function(){
                        jQuery('body').trigger("sticky_kit:recalc");
                    });
                });
            }
            return function(shouldUpdate,moduleId){
                tatsuStickyColumn = jQuery('.tatsu-column-sticky');
                if(tatsuStickyColumn.length){
                    asyncloader.require('stickykit',function(){
                        var stickyTopOffset = 0;
                        if(jQuery('#wpadminbar').length){
                            stickyTopOffset = 32;
                        }
                        jQuery.each(tatsuStickyColumn,function(key,element){
                            var stickyWidth = 767;
                            var jQueryObj = jQuery(element);
                            if ( jQueryObj.hasClass('tatsu-column-tablet-no-sticky') || jQueryObj.parent().hasClass('tatsu-column-tablet-no-sticky') ) {
                                stickyWidth = 1024;
                            }
                            if(jQuery(window).width() > stickyWidth && !jQueryObj.closest('.tatsu-eq-cols').length ){
                                jQueryObj.stick_in_parent({parent:'.tatsu-row', offset_top : stickyTopOffset})
                                .on("sticky_kit:stick",function(e){
                                    jQuery(e.target).css( 'transition','none' );
                                });
                                jQueryObj.parent().css('position','static');
                            } else {
                                jQueryObj.trigger( "sticky_kit:detach" );
                            }
                        });
                    });
                }
                var currentColumn = jQuery('.be-pb-observer-'+moduleId + ' .tatsu-column-inner ' );
                if(!currentColumn.hasClass('tatsu-column-sticky')){
                    currentColumn.trigger("sticky_kit:detach");
                }
            }
        }(),
       
        tatsuColumn = function(shouldUpdate,moduleId) {
            columnParallax();
            stickyColumn(shouldUpdate,moduleId);
            columnTilt(shouldUpdate,moduleId);
        },

        lazyLoadImages = function() {
            var tatsuLazyLoadImages = jQuery( '.tatsu-image-lazyload img' ),
                revealImages = function() {
                    var inview = tatsuLazyLoadImages.filter(function() {
                        var $e = $(this);
                        if ($e.is(":hidden")) return;
                        var wt = $win.scrollTop(),
                            wb = wt + $win.height(),
                            et = $e.offset().top,
                            eb = et + $e.height();
                        return eb >= wt - 400 && et <= wb + 400;
                    });
                    inview.each(function() {
                        var currentImage = jQuery( this );
                        currentImage.one( 'load', function() {
                            currentImage.css( 'opacity', '1' );
                            currentImage.closest( '.tatsu-single-image-inner' ).css( 'background-color', '' );
                        });
                        if( null != currentImage.attr( 'data-srcset' ) ) {
                            currentImage.attr( 'srcset', currentImage.attr( 'data-srcset' ) );
                        }else if( null != currentImage.attr( 'data-src' ) ) {
                            currentImage.attr( 'src', currentImage.attr( 'data-src' ) );
                        }
                        if( this.complete ) {
                           currentImage.load();
                        }
                    });
                    tatsuLazyLoadImages = tatsuLazyLoadImages.not(inview);
                };
            $win.on( 'scroll', revealImages ); 
            revealImages();
        },

        cssAnimateScrollCallback = function() {
            if( ( ( animate_wrapper.length > 0 || animatedNumberWrap.length > 0 ) && ( !$body.hasClass( 'be-sticky-sections' ) || 960 >= window.innerWidth ) ) || $body.hasClass('tatsu-frame') ) {
                scrollInterval = setInterval(function() {
                    if ( didScroll ) {
                        didScroll = false;
                        cssAnimate(false, '');      
                        animatedNumbers();
                    }
                }, 100); 
            }
            if( $body.hasClass( 'be-sticky-sections' ) && 960 >= window.innerWidth ){
                cssAnimate(false, '');  
            }        
        },
        tatsu_tabs = function( shouldUpdate,moduleId ) {
            var tabsInner = jQuery( '.be-pb-observer-'+moduleId+' .tatsu-tabs-inner' );
            
            if( !moduleId && !tabsInner.length ){
                tabsInner = jQuery( '.tatsu-tabs-inner' );
            }
     
            if( !shouldUpdate ) {
                if(tabsInner.length > 0) {
                    tabsInner.tabs({
                        fx : {
                            opacity : 'toggle',
                            duration : 200
                        },
                        create:function(e,ui){
                            var activeColors = tabsInner.attr('data-active-colors');
                            if( activeColors ){
                                ui.tab.css( JSON.parse(activeColors) );
                            }
                        },
                        activate:function(e,ui){
                            var activeColors = tabsInner.attr('data-active-colors');
                            var normalColors = tabsInner.attr('data-normal-colors');
                                if( activeColors ){
                                    ui.newTab.css( JSON.parse(activeColors) );
                                }
                                if( normalColors ){
                                    normalColors = JSON.parse( normalColors );
                                } else {
                                    normalColors = {};
                                }
                                ui.oldTab.css( {color:normalColors.color || '' ,background:normalColors.background || ''} );

                        }
                    }).css('opacity', 1);
                }
            }else{
                if( 0 < tabsInner.length ) {
                    tabsInner.tabs( "refresh" );
                }
            }
            var activeColors = tabsInner.attr('data-active-colors');
            var normalColors = tabsInner.attr('data-normal-colors');

            if( normalColors ){
                normalColors = JSON.parse( normalColors );
                tabsInner.find( '.ui-state-default' ).css( {color:normalColors.color || '', background:normalColors.background || ''} );
            }
            if( activeColors ){
                tabsInner.find( '.ui-state-active' ).css( JSON.parse(activeColors) );
            }

        },
        listsTimeline = function() {
            var adjustTimeline = function() {
                    var listsTimelines = $( '.tatsu-lists-timeline' );
                    listsTimelines.each(function(){
                        var curListsItem = $(this),
                            curTimeline = $(this).find('.tatsu-lists-timeline-element'),
                            timelineTop = (curListsItem.find('.tatsu-list-content').first().outerHeight())/2,
                            top,
                            bottom,
                            height;
                        if( curListsItem.hasClass( 'tatsu-list-vertical-align-top' ) ) {
                            top = curListsItem.find('.tatsu-list-content').first().offset().top + 15;
                            bottom = curListsItem.find('.tatsu-list-content').last().offset().top + 15;
                            timelineTop = 15;
                        }else if( curListsItem.hasClass( 'tatsu-list-vertical-align-center' ) ) {
                            timelineTop = (curListsItem.find('.tatsu-list-content').first().outerHeight())/2;
                            top = curListsItem.find('.tatsu-list-content').first().offset().top + (curListsItem.find('.tatsu-list-content').first().outerHeight())/2;
                            bottom = curListsItem.find('.tatsu-list-content').last().offset().top + (curListsItem.find('.tatsu-list-content').last().outerHeight())/2;
                        }else if( curListsItem.hasClass( 'tatsu-list-vertical-align-bottom' ) ) {
                            timelineTop = curListsItem.find('.tatsu-list-content').first().outerHeight() - 15;
                            top = curListsItem.find('.tatsu-list-content').first().offset().top + curListsItem.find('.tatsu-list-content').first().outerHeight() - 15;
                            bottom = curListsItem.find('.tatsu-list-content').last().offset().top + curListsItem.find('.tatsu-list-content').last().outerHeight() - 15;
                        }else {
                            top = curListsItem.find('.tatsu-list-content').first().offset().top + 15;
                            bottom = curListsItem.find('.tatsu-list-content').last().offset().top + 15;
                            timelineTop = 15;
                        }
                        height = bottom - top; 
                        if( height ) {
                            curTimeline.css({'height' : height, 'top' : timelineTop});
                        }
                    });
                };
            $(window).on( 'resize', adjustTimeline );
            return adjustTimeline;
        }(), 
        tatsu_accordion = function( shouldUpdate ) {
            var accordionWrap = jQuery( '.tatsu-accordion-inner' );	
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

        typedText = function( moduleId ){
            var typedText = jQuery( '.tatsu-typed-text-wrap');
            if( typedText.length > 0 ){
                asyncloader.require( 'typed' ,function() {
                    typedText.each( function(){
                        var rotatedText = jQuery(this).attr('data-rotate-text').split(','),
                            textLoop = jQuery(this).attr('data-loop-text'),
                            typedTextId = jQuery(this).find('span').attr('id');
                            if( textLoop === '1' ){
                                textLoop = true;
                            } else {
                                textLoop = false;
                            }
                        new Typed (
                            '#'+typedTextId,
                            { 
                                strings : rotatedText,
                                typeSpeed: 100,
                                backSpeed: 75,
                                backDelay: 500,
                                startDelay: 1000,
                                loop: textLoop, 
                            }
                        );
                    });
                });
            } 
        },
        animatedHeading = function( shouldUpdate, moduleId ){ 
            if( animatedHeadings.length ){
                asyncloader.require( 'anime' ,function() {
                    animatedHeadings.each(function(){
                        var $this = $(this);

                        if( moduleId && !$this.closest('.be-pb-observer-' + moduleId).length ){
                            return;
                        }

                        if( !$this.isVisible(-100) ){
                            return;
                        } else {
                            if( $this.hasClass('tatsu-anime-applied') ){
                                return;
                            } else {
                                $this.addClass('tatsu-anime-applied');
                            }
                        }

                        var headingInner =  $this.find( '.tatsu-animated-heading-inner' ),
                            animationStyle = $this.attr('data-anime-type'),
                            animationDuration = $this.attr('data-anime-duration');

                            if( typeof animationDuration === 'string' ){
                                animationDuration = parseInt(animationDuration);
                            }

                        switch(animationStyle){
                            case 'anime_split_letter' :
                                headingInner.html( headingInner.text().replace(/([^*{1}! ]|\w)/g, "<span class='tatsu-animated-heading-letter'><span>$&</span></span>") );
                                anime.timeline()
                                    .add({
                                        targets: headingInner[0].querySelectorAll('.tatsu-animated-heading-letter span'),
                                        translateY: ["1.1em", 0],
                                        easing: "easeOutExpo",
                                        duration: 750,
                                        delay: function(el, i) {
                                          return ( animationDuration * 4) * (i+1)
                                        }
                                })
                                break;
                            case 'anime_split_word' :
                                headingInner.html( headingInner.text().replace(/(\w+)|\W! /g, "<span class='tatsu-animated-heading-letter'><span>$&</span></span>") );
                                anime.timeline()
                                    .add({
                                        targets: headingInner[0].querySelectorAll('.tatsu-animated-heading-letter span'),
                                        translateY: ["1.1em", 0],
                                        duration: 750,
                                        easing: "easeOutExpo",
                                        delay: function(el, i) {
                                            return ( animationDuration * 12) * i;
                                        }
                                })
                                break;
                                case 'anime_from_right' :
                                    headingInner.html( headingInner.text().replace(/([^*{1}! ]|\w)/g, "<span class='tatsu-animated-heading-letter'>$&</span>") );
                                    anime.timeline()
                                        .add({
                                            targets: headingInner[0].querySelectorAll('.tatsu-animated-heading-letter'),
                                            translateX: [40,0],
                                            translateZ: 0,
                                            opacity: [0,1],
                                            easing: "easeOutExpo",
                                            duration: 1200,
                                            delay: function(el, i) {
                                              return ( animationDuration * 2) * i;
                                            }
                                    })
                                    break;
                                case 'anime_flip_in' :
                                    headingInner.html( headingInner.text().replace(/([^*{1}! ]|\w)/g, "<span class='tatsu-animated-heading-letter'>$&</span>") );
                                    anime.timeline()
                                        .add({
                                            targets: headingInner[0].querySelectorAll('.tatsu-animated-heading-letter'),
                                            rotateY: [-90, 0],
                                            duration: 1300,
                                            delay: function(el, i) {
                                              return ( animationDuration * 2) * i;
                                            }                                        
                                    })
                                    break;
                            case 'anime_top_bottom_lines' :
                                headingInner.html( headingInner.text().replace(/([^*{1}! ]|\w)/g, "<span class='tatsu-animated-heading-letter'>$&</span>") );
                                
                                anime.timeline()
                                .add({
                                    targets: headingInner[0].querySelectorAll('.tatsu-animated-heading-letter'),
                                    scale: [0.3,1],
                                    opacity: [0,1],
                                    translateZ: 0,
                                    easing: "easeOutExpo",
                                    duration: 600,
                                    delay: function(el, i) {
                                        return ( animationDuration * 3) * (i+1)
                                    }
                                }).add({
                                    targets: $this[0].querySelectorAll('.tatsu-animated-heading-line'),
                                    scaleX: [0,1],
                                    opacity: [0.5,1],
                                    easing: 'easeOutExpo',
                                    duration: 900,
                                    delay: function(el, i, l) {
                                        return 80 * (l - i);
                                    }
                                }, '-=900')
                                break;
                                case 'anime_slide_underline' :
                                    headingInner.html( headingInner.text().replace(/([^*{1}! ]|\w)/g, "<span class='tatsu-animated-heading-letter'>$&</span>") );
                                    
                                    anime.timeline()
                                    .add({
                                        targets: $this[0].querySelectorAll('.tatsu-animated-heading-line'),
                                        scaleX: [0,1],
                                        opacity: [0.5,1],
                                        easing: "easeInOutExpo",
                                        duration: 900
                                    })
                                    .add({
                                        targets: headingInner[0].querySelectorAll('.tatsu-animated-heading-letter'),
                                        opacity: [0,1],
                                        translateX: [40,0],
                                        translateZ: 0,
                                        scaleX: [0.3, 1],
                                        easing: "easeOutExpo",
                                        duration: 1000,
                                        delay: function(el, i) {
                                          return ( animationDuration * 8) * i;
                                        }
                                      }, '-=600')
                                    break;
                                case 'anime_slide_cursor' :
                                    headingInner.html( headingInner.text().replace(/([^*{1}! ]|\w)/g, "<span class='tatsu-animated-heading-letter'>$&</span>") );
                                    
                                    anime.timeline()
                                    .add({
                                        targets: $this[0].querySelectorAll('.tatsu-animated-heading-line'),
                                        scaleY: [0,1],
                                        opacity: [0.5,1],
                                        easing: "easeOutExpo",
                                        delay : 400,
                                        duration: 700
                                    })
                                    .add({
                                        targets: $this[0].querySelectorAll('.tatsu-animated-heading-line'),
                                        translateX: [0,headingInner.width()],
                                        easing: "easeOutExpo",
                                        duration: 700,
                                        delay: 100
                                    })
                                    .add({
                                        targets: headingInner[0].querySelectorAll('.tatsu-animated-heading-letter'),
                                        opacity: [0,1],
                                        easing: "easeOutExpo",
                                        duration: 600,
                                        delay: function(el, i) {
                                          return ( animationDuration * 2) * (i+1)
                                        }
                                        }, '-=775')
                                    break;
                            case 'anime_zoom_enter' :
                                headingInner.html( headingInner.text().replace(/([^*{1}! ]|\w)/g, "<span class='tatsu-animated-heading-letter'>$&</span>") );
                                anime.timeline()
                                    .add({
                                        targets: headingInner[0].querySelectorAll('.tatsu-animated-heading-letter'),
                                        scale: [4,1],
                                        opacity: [0,1],
                                        translateZ: 0,
                                        easing: "easeOutExpo",
                                        duration: 950,
                                        delay: function(el, i) {
                                          return ( animationDuration * 3)*i;
                                        }
                                })
                                break;
                            case 'anime_fade_in' :
                                headingInner.html( headingInner.text().replace(/([^*{1}! ]|\w)/g, "<span class='tatsu-animated-heading-letter'>$&</span>") );
                                anime.timeline()
                                    .add({
                                        targets: headingInner[0].querySelectorAll('.tatsu-animated-heading-letter'),
                                        opacity: [0,1],
                                        easing: "easeInOutQuad",
                                        duration: 1500,
                                        delay: function(el, i) {
                                          return ( animationDuration * 6) * (i+1)
                                        }
                                })
                                break;
                        }
                    });
                })
            }
        },

        save_tatsu_form = function() {
            jQuery(document).on('submit', '.tatsu-forms-save .spyro-form', function (e) {
                e.preventDefault(); 
                var $this = jQuery(this);
                
                var formid = $this.parent('.tatsu-forms-save').attr('id');
                    
                var tatsu_form_status =  $this.parent('.tatsu-forms-save').find('.subscribe_status');
                var tatsu_loader = $this.parent('.tatsu-forms-save').find(".exp-subscribe-loader");
                var spyro_required_checkbox = $this.find('.spyro-required-checkbox');
                if(spyro_required_checkbox.length && spyro_required_checkbox.find('input[type="checkbox"]:checked').length<=0){
                    spyro_required_checkbox.find('.error').text('Required field').show().fadeOut(9999);
                    tatsu_form_status.removeClass("tatsu-success").addClass("tatsu-error");
                    tatsu_form_status.html("Required field missing");
                    return false;
                }else if(typeof formid === 'undefined' || formid == null || formid == ''){
                    tatsu_form_status.removeClass("tatsu-success").addClass("tatsu-error");
                    tatsu_form_status.html("Invalid Form").slideDown();
                    console.log('Form id missing');
                }else{
                    formid = formid.split('-');
                    var form_id = formid[1];
                    if(typeof form_id === 'undefined' || form_id == null || form_id == ''){
                        tatsu_form_status.removeClass("tatsu-success").addClass("tatsu-error");
                        tatsu_form_status.html("Invalid Form").slideDown();
                        console.log('Form id missing');
                    }else{
                        var submit_button = $this.find( 'input[type="submit"]' );
                        var is_recaptcha = $this.find( 'input[name="is_recaptcha"]' ).val();
                        submit_button.prop( 'disabled', true );
                        tatsu_loader.fadeIn();
                        var action_after_submit = $this.attr('data-action');
                        var tatsu_formData = new FormData(jQuery(this)[0]);
                        tatsu_formData.append('action', 'tatsu_forms_save');
                        tatsu_formData.append('form_id', form_id);
                        tatsu_formData.append('action_after_submit', action_after_submit);
                        if(action_after_submit=='mailchimp'){
                            var email_address = $this.find('input[data-map_field="email_address"]');
                            if(email_address.length){
                            tatsu_formData.append('email_address',email_address.val());
                            }
                            var fname = $this.find('input[data-map_field="FNAME"]');
                            if(fname.length){
                            tatsu_formData.append('fname',fname.val());
                            }
                            var lname = $this.find('input[data-map_field="LNAME"]');
                            if(lname.length){
                            tatsu_formData.append('lname',lname.val());
                            }
                            var phone = $this.find('input[data-map_field="PHONE"]');
                            if(phone.length){
                            tatsu_formData.append('phone',phone.val());
                            }
                        }
                        if(tatsuFrontendConfig.recaptcha_type=='v3' && typeof is_recaptcha !=='undefined' && is_recaptcha == '1'){
                            grecaptcha.ready(function() {
                                grecaptcha.execute(tatsuFrontendConfig.recaptcha_site_key, {action: 'submit'}).then(function(token) {
                                    tatsu_formData.append('g-recaptcha-response', token);
                                    save_tatsu_form_ajax(tatsu_formData,tatsu_form_status,submit_button,tatsu_loader,$this);
                                });
                            });
                        }else{
                            save_tatsu_form_ajax(tatsu_formData,tatsu_form_status,submit_button,tatsu_loader,$this);
                        }
                        return false;
                    }
               }
            }); 			
        },
        save_tatsu_form_ajax = function(tatsu_formData,tatsu_form_status,submit_button,tatsu_loader,$this){ 
            jQuery.ajax({
                type: "POST",
                url: tatsuFrontendConfig.ajax_url,
                processData: false,
                contentType: false,
                dataType: 'json',
                data: tatsu_formData,
                success    : function (msg) {
                    tatsu_loader.fadeOut();
                    if (msg.status === "error") {
                        tatsu_form_status.removeClass("tatsu-success").addClass("tatsu-error");
                    } else {
                        tatsu_form_status.addClass("tatsu-success").removeClass("tatsu-error");
                        $this.trigger("reset");
                    }
                    tatsu_form_status.html(msg.data).slideDown();
                    submit_button.prop( 'disabled', false );
                },
                error: function () {
                    submit_button.prop( 'disabled', false );
                    tatsu_form_status.html("Please Try Again Later").slideDown();
                }
            });
        },
        ready = function(){

            imgCarouselLightbox();
            lazyLoadBgImages();
            animatedAnchor();
            progressBar();
            listsTimeline();
            video();
            parallax();
            columnParallax();
            columnTilt();
            tatsuColumn();
            lazyLoadImages();
            tatsuGallery();
            closeNotification();
            animatedNumbers();
            carousel();
            carouselIOSFix();
            slider();
            lineAnimate();
            if( !jQuery( 'body' ).hasClass( 'be-sticky-sections' ) ) {
                cssAnimate();
            }
            lightbox();
            gmaps();
            tatsu_tabs();
            typedText();
            tatsu_accordion();
            animatedHeading();
            // backgroundVideo();
            registerCallbacks();
            save_tatsu_form();
            jQuery(window).on( 'tatsu_update.tatsu', function( e, data )  {
                animate_wrapper = jQuery('.tatsu-animate, .be-animate');
                skillsWrap = jQuery( '.be-skill' );
                animatedHeadings = jQuery('.tatsu-animated-heading-wrap');
                animateWrapperCount = animate_wrapper.length;
                animatedNumberWrap = jQuery('.tatsu-an');
                totalAnimCount = animate_wrapper.length + animatedNumberWrap.length;
                if( 'trigger_ready' == data.moduleName ) {
                    animatedNumbers();
                    // typedText();
                    parallax();
                    gmaps();
                    video();
                 //   backgroundVideo();
                    lightbox();
                    tatsuColumn();
                    tatsuGallery();
                    columnParallax();
                    tatsuRow();
                    jQuery(window).trigger('resize');
                } else if( data.moduleName in tatsuCallbacks ) {
                    tatsuCallbacks[data.moduleName]( data.shouldUpdate,data.moduleId );                                         
                } 
                if ( 'csstrigger' === data.type ) {
                  builderAnimate( data.animationDetails );
                }
            });

            jQuery(window).on('scroll', function(){
                didScroll = true;
                progressBar();
                animatedHeading();

            });

            cssAnimateScrollCallback();

            jQuery(window).on( 'resize.tatsu', function() {
               jQuery( '.tatsu-bg-video, .be-bg-video' ).tatsuResizeMedia(); 
               if( $body.hasClass( 'be-sticky-sections' ) ) {
                   if( 960 >= window.innerWidth && null == scrollInterval ) {
                       cssAnimateScrollCallback();
                   }else if( 960 < window.innerWidth && null != scrollInterval ) {
                       clearTimeout( scrollInterval );
                   }
               }
               stickyColumn();
            });
        }
        
        return {
            ready: ready,
            lightbox: lightbox,
            cssAnimate: cssAnimate,
            animatedNumbers : animatedNumbers
        }

    })(); 

    window.tatsu = tatsu;
    jQuery( tatsu.ready );

})( jQuery );