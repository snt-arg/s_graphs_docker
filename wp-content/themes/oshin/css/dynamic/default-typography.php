<?php
/* Parsed to Typehub - false means 
- Typehub was never activated
- Redux still has the type options and will take care of the default typography

Parsed to Typehub - true 
- Redux will no longer print default typo 
- If typehub is inactivate theme has to print default typo  */

$typography_options = include get_template_directory().'/functions/typography-options.php';
$parsed_to_typehub = get_option( 'oshine_redux_to_typehub' );
if( $typography_options && !class_exists( 'Typehub' ) && !empty( $parsed_to_typehub ) ) {
    $css = '';
    foreach( $typography_options as $category => $fields ) {
        foreach( $fields as $field ) {
            $selector = $field['selector'];
            $options = $field['options'];
            $css_value = '';
            if( !empty( $selector ) ) {
                foreach( $options as $property => $value ) {
                    if( 'font-variant' === $property ) {
                        $value = be_split_unit_value( $value );
                        $weight = ( !empty( $value['value'] ) ) ? $value['value'] : '400';
                        $style = ( !empty( $value['unit'] ) ) ? $value['unit'] : 'normal';
                        $css_value .= 'font-weight:'.$weight.'; font-style:'.$style.';';
                    } elseif ( 'font-family' === $property ) {
                        $value = explode( ':', $value );
                        $family = ( !empty( $value[1] ) ) ? $value[1] : $value[0];
                        $css_value .= 'font-family:'.$family.';';
                    } else {
                        $css_value .= $property.':'.$value.';';
                    }
                }
                $css .= $selector.'{ '.$css_value.' }';
            }
        }
    }
   echo be_minify_css( $css );
}
?>

