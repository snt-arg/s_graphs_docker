(function( $ ){
	'use strict';

	var $this;
	$.fn.tatsuColumnParallax = function( options ){
		var defaults = {
			speed : 3
		};
		$this = $(this);
		options = $.extend( defaults, options );
		
		var windowHeight = window.innerHeight;

		var update = function(){
			var $window = $( window ),
				$element, top, elementHeight,
				scrollPos = document.documentElement.scrollTop || document.body.scrollTop,
				speed;
			
			$this.each( function(){
				$element = $( this );

				speed = $element.attr( 'data-parallax-speed' ) || options.speed;
				var elementViewportTop =  $element[0].getBoundingClientRect().top;
				
				elementHeight = $element.outerHeight();
				if( elementViewportTop > windowHeight || elementViewportTop + elementHeight < 0) {
					//Outside the view port
					return;
				} else{
					var	columnCenterPointTopDistancewrtViewport = elementViewportTop + elementHeight / 2 ,
						columnCenterPointDistanceFromCenterofViewport =  windowHeight / 2 - columnCenterPointTopDistancewrtViewport,
						transformValue,
						transformFactor,
						transformY;
					if( ( windowHeight / 2 ) > columnCenterPointTopDistancewrtViewport + scrollPos ){
						transformValue = scrollPos;
					} else {
						transformValue = columnCenterPointDistanceFromCenterofViewport;
					}

					//Compute the transform Factor
					var normalizedSpeed = -1 * speed / 10,
						normalizedAbsoluteSpeed = Math.abs( speed / 10 );

					transformFactor = normalizedSpeed / ( 2 - normalizedAbsoluteSpeed );
					transformY = transformValue * transformFactor;
					$element.children( '.tatsu-column-inner' ).css({
						'transform': 'translate3d( 0,' + Math.round( transformY ) + 'px, 0)'
					});

				}
			});
		},

		init = function(){
			$( window ).on( 'resize', function(){
				windowHeight = window.innerHeight;
				update();
			});

			$( window ).on( 'scroll', function(){ 
				requestAnimationFrame( function(){
					update();
				}); 
			});
			
			update();
		}

		init();

		return this;
	};
}( jQuery ));