/*
 * debouncedresize: special jQuery event that happens once after a window resize
 *
 * latest version and complete README available on Github:
 * https://github.com/louisremi/jquery-smartresize
 *
 * Copyright 2012 @louis_remi
 * Licensed under the MIT license.
 */
(function($) {
	"use strict";

    var $event = $.event,
        $special,
        resizeTimeout;
    
    $special = $event.special.debouncedresize = {
        setup: function() {
            $( this ).on( "resize", $special.handler );
        },
        teardown: function() {
            $( this ).off( "resize", $special.handler );
        },
        handler: function( event, execAsap ) {
            // Save the context
            var context = this,
                args = arguments,
                dispatch = function() {
                    // set correct event type
                    event.type = "debouncedresize";
                    $event.dispatch.apply( context, args );
                };
    
            if ( resizeTimeout ) {
                clearTimeout( resizeTimeout );
            }
    
            execAsap ?
                dispatch() :
                resizeTimeout = setTimeout( dispatch, $special.threshold );
        },
        threshold: 150
    };
    
})(jQuery);


/**
 * Simple throttle function
 */
(function($) {
	"use strict";

    $.throttle = function(cb, threshold) {
        var last = null,
            threshold = threshold || 200;
        return function() {
            if( null == last ) {
                last = +new Date;
                cb.call(this, arguments);
            }else {
                var now = +new Date;
                if( last + threshold < now ) {
                    last = now;
                    cb.call(this, arguments);
                }
            }
        }
    }
})(jQuery);


/**
 * Simple Debounce function
 */
(function($) {
	"use strict";

    $.debounce = function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };
})(jQuery);

/**
 * youtube player api
 */
(function($) {
	"use strict";
	
    if( jQuery('.be-youtube-embed').length ){
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


/**
 * Checks if element is inside viewport
 */
(function( $ ) {
    "use strict";
    var $window = $(window);
    $.fn.isVisible = function( threshold ) {
        var $el = $(this),
            wt = $window.scrollTop(),
            wb = wt + window.innerHeight,
            et = $el.offset().top,
            eb = et + $el.height(),
            topThreshold = wt - threshold,
            bottomThreshold = wb + threshold;
        return ( eb >= topThreshold && eb <= bottomThreshold ) || ( et <= bottomThreshold && et >= topThreshold );
    };
})( jQuery );

/**
 * Lazy load
 */
(function( $ ){
	"use strict";
    var imagesToLoad = $( '.be-lazy-load' ),
        add = function( images ) {
            if( null != images && 0 < images.length ) {
                imagesToLoad = imagesToLoad.add( images );
            }
        },
        lazyLoad = function() {
            if( 0 < imagesToLoad.length ) {
                var visibleImages = imagesToLoad.filter( function(i, el) {
                    return $(this).isVisible( 200 );
                });
                if( 0 < visibleImages.length ) {
                    visibleImages.one( 'load', function() {
                        $(this).addClass( 'be-lazy-loaded' );
                    }).each( function( el ) {
                        var curEl = $(this);
                        curEl.attr( 'src', curEl.attr( 'data-src' ) );
                    });
                    imagesToLoad = imagesToLoad.not( visibleImages );
                }
            }
        };
    $(window).on( 'scroll', function() {
        lazyLoad();
    });
    window.BeLazyLoad =  {
        add : add,
        lazyLoad : lazyLoad
    };
    $(function(){
        imagesToLoad = $( '.be-lazy-load' );
        lazyLoad();
    });
}(jQuery))