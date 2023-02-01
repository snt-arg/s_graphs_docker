<?php
/**************************************
			Html
**************************************/
if (!function_exists('be_html')) {
	function be_html( $atts, $content ) {
		extract( shortcode_atts( array (
	        'scroll_to_animate' => 0,
	        'animate' => 0,
	        'animation_type' => 'fadeIn',
	    ),$atts ) );

	    $output = '';
	    $bool = false;
		if( isset( $animate ) && 1 == $animate ) {
			$animate = 'be-animate';
			$bool = true;
		} else {
			$animate = '';
		}
		if( isset( $scroll_to_animate ) && 1 == $scroll_to_animate ) {
	    	$scroll_to_animate = 'scrollToFade';
	    	$bool = true;
	    } else {
			$scroll_to_animate = '';
		}
		$output .= ( true === $bool ) ? '<div class="be-text-block '.$animate.' '.$scroll_to_animate.'" data-animation="'.$animation_type.'">' : '' ;
		$output .= $content;
	    $output .= ( true ===  $bool ) ? '</div>' : '' ;
	    
	    return $output;
	}
	add_shortcode( 'html', 'be_html' );
}
?>