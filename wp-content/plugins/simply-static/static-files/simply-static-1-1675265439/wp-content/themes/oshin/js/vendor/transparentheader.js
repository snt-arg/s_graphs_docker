/**Transparent and Sticky Header**/

;(function( $ ) {
	var $window = $(window),
		$header = jQuery( '#header' ),
		$headerInnerWrap = jQuery( '#header-inner-wrap' ),
		$headerWrap = jQuery( '#header-wrap' ),
		$main = jQuery( '#main' ),
		$body = jQuery( 'body' ),
		$wpAdminbar = jQuery( '#wpadminbar' ),
		$heroSection = jQuery('.header-hero-section'),
		update_transparent,
		didScroll = false;
    $.fn.Transparent = function() {
		var $this = $(this),
		Number_or_zero = function(num){
			num = Number(num);
			if(isNaN(num)){
				num = 0;
			}
			return num;
		}		
		update_transparent = function() {

			var $border_length = 2;
			if( $body.hasClass( 'be-themes-layout-layout-border-header-top' ) ) {
				$border_length = 1;
			}
            if( $main.hasClass( 'layout-border-header-top' ) ) {
            	var $header_inner_height = $headerInnerWrap.innerHeight();
            	$header.height($header_inner_height);
				$headerInnerWrap.addClass('no-transparent').removeClass('transparent');
				jQuery('.style2-header-search-widget').css('padding-top', $header_inner_height+jQuery('#wpadminbar').height());
				jQuery('.overlay-menu-close, .header-search-form-close').css('top', $header_inner_height);
			}else if( ( $body.hasClass( 'transparent-sticky' ) || $body.hasClass( 'sticky-header' ) ) && !$body.hasClass( 'perspectiveview' ) && !$body.hasClass( 'page-stack-top-opened' ) ) {
				var animatePosition = ( $body.hasClass( 'transparent-sticky' ) && ( $heroSection.length > 0 ) ) ? ( (Number_or_zero( $heroSection.offset().top ) + Number_or_zero( $heroSection.height() ) ) - ( Number_or_zero( $wpAdminbar.innerHeight() ) + Number_or_zero( $headerWrap.attr('data-default-height') ) + Number_or_zero(jQuery('#header-bottom-bar').innerHeight()) + Number_or_zero( jQuery('#header-top-bar-wrap').innerHeight() ) ) ) : ((Number_or_zero($header.offset().top)+Number_or_zero($headerWrap.attr('data-default-height'))+Number_or_zero(jQuery('#header-top-bar-wrap').innerHeight())+Number_or_zero(jQuery('#header-bottom-bar').innerHeight()))-Number_or_zero($wpAdminbar.height()+jQuery('.layout-box-bottom').innerHeight()));
				
				if( animatePosition <= 0 ) {
					$animate_position = (Number_or_zero($headerWrap.attr('data-default-height'))+Number_or_zero(jQuery('#header-top-bar-wrap').innerHeight())+Number_or_zero(jQuery('#header-bottom-bar').innerHeight()));
				}
				
				if( animatePosition <= Math.ceil( $window.scrollTop() ) ) {
					if( $body.hasClass( 'sticky-header' ) ) {
						$header.height( Number_or_zero( $headerWrap.attr( 'data-default-height' ) ) + Number_or_zero( jQuery( '#header-top-bar-wrap' ).innerHeight() ) + Number_or_zero( jQuery( '#header-bottom-bar' ).innerHeight() ) );
					}
					$headerInnerWrap.addClass( 'no-transparent' ).removeClass( 'transparent' );
					setTimeout( function() {

						$headerInnerWrap.addClass( 'top-animate' );
						$body.addClass( 'be-sticky-active' );

					}, 10 );
				}else{
					$headerInnerWrap.removeClass( 'no-transparent' ).removeClass( 'top-animate' );
					if( $body.hasClass( 'sticky-header' ) ) {
						$header.height( 'auto' );
					}else{
						$headerInnerWrap.addClass( 'transparent' );
					}
					$body.removeClass( 'be-sticky-active' );
				}
			}
           
		}
		$window.on('scroll', function(){
			didScroll = true;
		});

		setInterval(function(){
			if( didScroll ){
				didScroll = false;
				update_transparent();
			}
		},250);
		
		$window.on('resize', update_transparent);
		update_transparent();
    };
}( jQuery ));