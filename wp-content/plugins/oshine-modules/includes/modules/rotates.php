<?php
/**************************************
			ROTATES
**************************************/
if ( ! function_exists( 'be_rotates' ) ) {
	function be_rotates( $atts, $content ) {
		extract( shortcode_atts( array (
			'animation' => 'fade',
			'speed' => 1000,
	    ),$atts ) );
	    $animation = (empty($animation)) ? 'fade' : $animation ; 
		$speed = (empty($speed)) ? 1000 : $speed ;  
		
		return '<span class="rotates" data-animation="'.$animation.'" data-speed="'.$speed.'" >'.do_shortcode( $content ).'</span>';
	}
	add_shortcode( 'rotates', 'be_rotates' );
}

if ( ! function_exists( 'be_rotate' ) ) {
	function be_rotate( $atts, $content ) {
		extract( shortcode_atts( array (
			'rotate_text' => '',
	    ),$atts ) );
		return ' '.$content.'||';
	}
	add_shortcode( 'rotate', 'be_rotate' );
}
?>