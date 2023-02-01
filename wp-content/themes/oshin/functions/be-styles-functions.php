<?php
/* ---------------------------------------------  */
// Function for finding IE8 alpha from opacity
/* ---------------------------------------------  */

if (! function_exists('be_themes_alpha_level') ){
  function be_themes_alpha_level( $opacity ) {
    $alpha_value =  dechex( $opacity * 255 );
    return $alpha_value;
  }
}

/* ---------------------------------------------  */
// Function for printing background styles
/* ---------------------------------------------  */

if (! function_exists('be_themes_set_backgrounds') ){
  function be_themes_set_backgrounds( $section ) {
    global $be_themes_data;
    
    $background_color = '';
    $background_image = '';
    $background_repeat = '';
    $background_attachment = '';
    $background_position = '';
    

    if( isset( $be_themes_data[$section]['background-color'] ) ) {

      $background_color = $be_themes_data[$section]['background-color'];
    }

    if( isset( $be_themes_data[$section]['background-repeat'] ) ) {
      $background_repeat = $be_themes_data[$section]['background-repeat'];
    }
    if( isset( $be_themes_data[$section]['background-attachment'] ) ) {
      $background_attachment = $be_themes_data[$section]['background-attachment'];
    }
    if( isset( $be_themes_data[$section]['background-size'] ) ) {
      $background_size = $be_themes_data[$section]['background-size'];
    }
    if( isset( $be_themes_data[$section]['background-position'] ) ) {
      $background_position = $be_themes_data[$section]['background-position'];
    }
   if( 'transparent' == $background_color ) {
        echo 'background: none;';
    } 
    elseif( !empty( $be_themes_data[$section]['background-image'] ) ) {
        $background_image=$be_themes_data[$section]['background-image'];
        echo 'background: '.$background_color.' url('.$background_image.') '.$background_repeat.' '.$background_attachment.' '.$background_position.';';
        echo 'background-size: '.$background_size.';' ;
    } 
    else {
        if( !empty( $background_color ) ){
          be_themes_background_colors( $be_themes_data[$section]['background-color'], 1);//$be_themes_data[$section]['opacity'] );
      }
    }  
  } 
}

/* ---------------------------------------------  */
// Function for printing background colors
/* ---------------------------------------------  */

if (! function_exists('be_themes_background_colors') ){
  function be_themes_background_colors( $color, $opacity ) {
    //echo $color . '  ' . $opacity;
    $rgb = be_themes_hexa_to_rgb( $color );
    if ( is_array( $rgb ) && count( $rgb ) >= 3 ) {
      $color = $rgb[0].','.$rgb[1].','.$rgb[2];
      //echo $color;
      echo 'background-color: rgb('.$color.');'; 
      echo 'background-color: rgba('.$color.','.$opacity.');'; 
    }
  }
}

if (! function_exists('be_themes_get_background_colors') ){
  function be_themes_get_background_colors( $color, $opacity ) {
  	$rgb = be_themes_hexa_to_rgb( $color );  
  	$color = $rgb[0].','.$rgb[1].','.$rgb[2];
  	$output = '';
  	$output .= 'background-color: rgb('.$color.');'; 
  	$output .= 'background-color: rgba('.$color.','.$opacity.');';
  	return $output;
  }
}

/* ---------------------------------------------  */
// Function for printing border
/* ---------------------------------------------  */

if (! function_exists('be_themes_borders') ){
  function be_themes_borders( $section , $position ) {
    global $be_themes_data;

    if (array_key_exists($position, $be_themes_data[$section] ) ) {
      $output = $be_themes_data[$section][$position].' '.$be_themes_data[$section]['border-style'].' '.$be_themes_data[$section]['border-color'];
    }elseif (array_key_exists('border-'.$position, $be_themes_data[$section] ) ) {
      // var_dump($be_themes_data[$section]['border-'.$position]);
      $output = $be_themes_data[$section]['border-'.$position].' '.$be_themes_data[$section]['border-style'].' '.$be_themes_data[$section]['border-color'];
    }else {

      $output = '' ;
    }

    return $output;
  }
}

/* ---------------------------------------------  */
// Function for handling typography options
/* ---------------------------------------------  */

if (! function_exists('be_themes_print_typography') ){
  function be_themes_print_typography( $tag ) {
  	global $be_themes_data;	    
    //$get_font =  get_font( $be_themes_data[$tag]['font-family'] );
    $get_font =  implode('","',explode(",",$be_themes_data[$tag]['font-family'] ) );
    if( isset( $be_themes_data[$tag]['font-weight'] ) ) { 
      $weight = $be_themes_data[$tag]['font-weight']; 
    } 
    if( isset( $be_themes_data[$tag]['font-style'] ) ) { 
      $style = $be_themes_data[$tag]['font-style']; 
    } else { 
      $style = 'normal'; 
    } 
    $size = ( isset( $be_themes_data[$tag]['font-size'] ) ) ? $be_themes_data[$tag]['font-size'] : "" ;
    $color = ( isset( $be_themes_data[$tag]['color'] ) ) ? $be_themes_data[$tag]['color'] : "" ;
    $line_height = isset( $be_themes_data[$tag]['line-height'] )  ? $be_themes_data[$tag]['line-height'] : "" ;
    $letter_spacing = isset( $be_themes_data[$tag]['letter-spacing'] )  ? $be_themes_data[$tag]['letter-spacing'] : "" ;
    $text_transform = isset( $be_themes_data[$tag]['text-transform'] )  ? $be_themes_data[$tag]['text-transform'] : "" ;

    echo 'font: '.$style.' '.$weight.' '.$size.' "'.$get_font.'","Open Sans","Arial",sans-serif; 
    color: '.$color.';
    line-height: '.$line_height.';
    letter-spacing: '.$letter_spacing.';
    text-transform: '.$text_transform.';';
  }
}

/* ---------------------------------------------  */
// Function to obtain font selected
/* ---------------------------------------------  */

if (! function_exists('get_font') ){
  function get_font( $font_family ) {
    $font = explode( '/', $font_family );
    $font_type = $font[0];
    $font_name = $font[1];
    $assign_font = array();

    if( $font_type == 'google' ) {
        $google_font = explode(':',$font_name);
        $assign_font['name'] = $google_font[0];
        if( $font_weight = filter_var( $google_font[1], FILTER_SANITIZE_NUMBER_INT ) ) {
            $assign_font['weight'] =  $font_weight;
        }       
        if( strstr( $google_font[1], 'italic' ) ) {
            $assign_font['style'] = 'italic';
        }
        return $assign_font;  
    } else {
        $assign_font['name'] = $font_name;
        return $assign_font;
    }    
  }
}

if (! function_exists('be_themes_print_typography_special_heading') ){
  function be_themes_print_typography_special_heading( $tag='h1', $size='13px' ) {	
    global $be_themes_data;	    	
    $get_font =  get_font( $be_themes_data[$tag]['family'] );	
    if( isset( $get_font['weight'] ) ) {     
      $weight = $get_font['weight']; 	
    } else { 		
      $weight = $be_themes_data[$tag]['weight']; 	
    }	if( isset( $get_font['style'] ) ) { 		
      $style = $get_font['style']; 	
    } else { 		
      $style = 'normal'; 	
    } 	

    echo 'font: '.$style.' '.$weight.' '.$size.' "'.$get_font["name"].'","Open Sans","Arial",sans-serif;';
  }
}

/* ---------------------------------------------  */
// Function to apply single value styling
/* ---------------------------------------------  */

if(! function_exists('be_themes_apply_styling')){
  function be_themes_apply_styling($attribute, $data_key, $default_value, $suffix){
    global $be_themes_data;
    echo $attribute .':'. ((isset($be_themes_data[$data_key]) && !empty($be_themes_data[$data_key]) ) ? $be_themes_data[$data_key] : $default_value ) . $suffix .';';
  }
}
?>