<?php
/**************************************
			ANIMATED TEXT
**************************************/
if ( ! function_exists( 'be_animate_typed' ) ) {
	function be_animate_typed( $atts, $content ) {
		return '<span class="typed">'.do_shortcode( $content ).'</span>';
	}
	add_shortcode( 'typed', 'be_animate_typed' );
}

if ( ! function_exists( 'be_animate_type' ) ) {
	function be_animate_type( $atts, $content ) {
		extract( shortcode_atts( array (
			'rotate_text' => '',
	    ),$atts ) );
		return ' '.$content.'||';
	}
	add_shortcode( 'type', 'be_animate_type' );
}
?>