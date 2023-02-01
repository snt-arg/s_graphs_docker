<?php 
if( !function_exists( 'oshine_animated_anchor' ) ) {
    function oshine_animated_anchor( $atts, $content ) {

        extract( shortcode_atts( array(
            'color'             => '',
            'hover_color'       => '',
            'style'             => 'style7',
            'border_color'    => '',
            'href'              => '',
            'new_tab'           => 0
        ), $atts ) );   
        $color = (isset($color) && !empty($color)) ? $color : '';
        $hover_color = (isset($hover_color) && !empty($hover_color)) ? $hover_color : '';        
        $style = (isset($style) && !empty($style)) ? $style : 'style1';         
        $href = (isset($href) && !empty($href)) ? $href : '';
        $new_tab = (isset($new_tab) && !empty($new_tab)) ? 1 : 0;
        $output = '';
        $wrapper_style = '';
        $color_style = ( '' != $color ) ? ( 'color:' . $color . ';' ) : '';
        $output .= '<a'. ( ( 1 == $new_tab ) ? ' target = "_blank" ' : ' ' ) .'class = "be-animated-anchor ' . ( ( '' != $style ) ? ( 'be-' . $style . '"' ) : '"' ) .' href = "'. $href .'" ' . ( ( '' != $color || 'style1' == $style ) ? ( 'style = "'. ( ( '' != $color ) ? ( 'color:' . $color . ';' ) : '' ) . ( ( 'style1' == $style ) ? ( 'border-color : '.$border_color.';' ) : '' ) . '"' ) : '' ) . ( ( '' != $hover_color ) ? ( ' data-hover-color = "'. $hover_color . '"' ) : '' ) . ( ( '' != $color ) ? ( ' data-color = "'. $color . '"' ) : '' )  . ( ( '' != $border_color ) ? ( ' data-border-color = "'. $border_color . '"' ) : '' ) .' >';
        $output .= ( 'style1' != $style ) ? '<span class = "be-anchor-overlay"' . ( ( '' != $border_color ) ? ( 'style = "background:' . $border_color . ';"' ) : '' ) .  '></span>' : '';
        $output .= $content;
        $output .= '</a>';
        return $output;
    }
    add_shortcode( 'oshine_animated_anchor', 'oshine_animated_anchor' );
}
?>