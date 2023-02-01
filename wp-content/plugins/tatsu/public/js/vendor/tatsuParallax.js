(function( $ ){
	'use strict';

	var $this;
	$.fn.tatsuParallax = function( options ){
		var defaults = {
			speed : 0.4
		};
		$this = $(this);
		options = $.extend( defaults, options );
		
		var windowHeight = window.innerHeight;

		var update = function(){
			var $window = $( window ),
				$element, top, elementHeight,
				scrollPos = $window.scrollTop(),
				speed;
				
			$this.each( function(){
			// $('.tatsu-parallaxed').each( function(){
				$element = $( this );
				if( $element.hasClass( 'tatsu-parallaxed' ) ){
					speed = $element.data( 'speed' ) || options.speed;
					top = $element.offset().top;
					elementHeight = $element.outerHeight( true );

					if( top + elementHeight < scrollPos || top > scrollPos + windowHeight) {
						//Outside the view port
						return;
					} else{
						var difference = ( top - windowHeight ) > 0 ? top - windowHeight : 0;
						$element.find( '.tatsu-parallax-element-wrap' ).css({
							'transform': 'translate3d( 0,' + Math.round(( scrollPos - difference ) * -( speed )) + 'px, 0)'
						});
					}
				}
			});
		},

		setParallaxBackgroundHeight = function( resized, speed ){
			if( resized )
			{
				var parallaxElements = $( '.tatsu-parallaxed' ).find('.tatsu-parallax-element-wrap');
			} else{
				var parallaxElements = $this.find('.tatsu-parallax-element-wrap');
			}
			parallaxElements.each( function(){
				var $element = $( this ),
					elementParent = $element.parent(),
					parallaxContainerHeight = elementParent.outerHeight(),
					parallaxHeight,
					elementParentTop = $element.parent().offset().top,
					documentScrollHeight = document.body.scrollHeight,
					tatsu_parallax_speed;

				if( elementParent.data( 'speed' ) && !speed){
					tatsu_parallax_speed = elementParent.data( 'speed' );
				} else{
					tatsu_parallax_speed = speed;
					elementParent.data( {'speed' : speed} );
				}

				if( documentScrollHeight > ( elementParentTop + parallaxContainerHeight + windowHeight )){
					//Fully Outside the end viewPort 
					parallaxHeight = Math.round(( parallaxContainerHeight + windowHeight ) * tatsu_parallax_speed ) + parallaxContainerHeight;
					if( elementParentTop < windowHeight ){
						parallaxHeight =  parallaxContainerHeight + Math.round(( parallaxContainerHeight + elementParentTop ) * tatsu_parallax_speed );
					}
				} else{
					//Somepart is inside the end viewPort
					var parallaxContainerInnerHeight = $element.parent().innerHeight();
					parallaxHeight =  parallaxContainerInnerHeight + Math.round(( documentScrollHeight - elementParentTop ) * tatsu_parallax_speed );
				
				}
				$element.height(parallaxHeight);
			})
		},

		init = function(){
			$( window ).on( 'resize', function(){
				windowHeight = window.innerHeight;
				setParallaxBackgroundHeight( true );
				update();
			});

			$( window ).on( 'scroll', function(){ 
				requestAnimationFrame( function(){
					update();
				}); 
			});
			
			$this.each( function(){
				if( !( $( this ).hasClass( 'tatsu-parallaxed' ))){
					$( this ).addClass( 'tatsu-parallaxed' );
				}
			})
			setParallaxBackgroundHeight( false, options.speed );
		}

		init();

		return this;
	};
}( jQuery ));