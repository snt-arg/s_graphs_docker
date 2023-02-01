<?php
/**
 * Master Slider Gallery Extenstion
 *
 * @package   MasterSlider
 * @author    averta [averta.net]
 * @license   LICENSE.txt
 * @link      http://masterslider.com
 * @copyright Copyright © 2014 averta
*/

// no direct access allowed
if ( ! defined('ABSPATH') ) {
    die();
}

/**
 * MSP_Gallery_Extention class.
 *
 * @since 2.6.0
 */
class MSP_Gallery_Extention {

	/**
	 * Constructor
	 */
	public function __construct() {

		add_filter( 'post_gallery', array( $this, 'gallery_output' ), 11, 2 );
	}

	/**
	 * Filter the default gallery shortcode output.
	 *
	 * @see gallery_shortcode()
	 *
	 * @param string $output The gallery output. Default empty.
	 * @param array  $attr   Attributes of the gallery shortcode.
	 */
	public function gallery_output( $output, $attr ) {

		if( ! ( isset( $attr['masterslider'] ) && ( $attr['masterslider'] == 'yes' || $attr['masterslider'] == 'true' ) ) ) {
			return $output;
		}

		$post = get_post();

		// Sanitize orderby
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( ! $attr['orderby'] ) {
				unset( $attr['orderby'] );
			}
		}

		$atts = shortcode_atts( array(
			'order'      		=> 'ASC',
			'orderby'    		=> 'menu_order ID',
			'id'         		=> $post ? $post->ID : 0,
			'width'      		=> '960',
			'height' 	 		=> '540',
			'loop' 				=> 'false',
			'autoplay' 			=> 'false',
			'auto_height' 		=> 'false',
			'skin'          	=> 'ms-skin-default',
			'preload' 			=> 2,
			'include'    		=> '',
			'exclude'    		=> '',
			'link'       		=> '',
			'class' 	 		=> '',
			'target'     		=> '_self',
			'delay'      		=> '3',
			'caption' 			=> 'true',
			'thumbs_type'		=> 'thumbs', // 'thumbs' or 'tabs'
			'thumbs'     		=> 'true',
			'thumbs_align'     	=> 'bottom', // 'bottom', 'top', 'left', 'right'
			'thumbs_width'  	=> 140,      // thumbnail width in pixel
			'thumbs_height' 	=> 80,		 // thumbnail height in pixel
			'thumbs_space'  	=> 2,        // space around each thumbnail
			'thumbs_inset'  	=> 'false',  // display thumbnail in or out of slider
			'thumbs_autohide' 	=> 'false',
			'thumbs_margin'    	=> 2

		), $attr, 'masterslider_gallery' ); // You can filter the following attrs by 'shortcode_atts_masterslider_gallery' filter hook (http://codex.wordpress.org/Function_Reference/shortcode_atts)


		$id = intval( $atts['id'] );

		if ( 'RAND' == $atts['order'] ) {
			$atts['orderby'] = 'none';
		}

		// Collect slider options in $slider_attrs array
		$slider_attrs   		  = array( 'width' => $atts['width'] );
		$slider_attrs['height']   = $atts['height'];
		$slider_attrs['class']    = 'master-slider-gallery '. esc_attr( $atts['class'] );
		$slider_attrs['id']       = 0;
		$slider_attrs['loop']     = $atts['loop'];
		$slider_attrs['autoplay'] = $atts['autoplay'];
		$slider_attrs['slideinfo_margin'] = '0';
		$slider_attrs['slideinfo_height'] = '30';
		$slider_attrs['skin']     = $atts['skin'];
		$slider_attrs['preload']  = $atts['preload'];
		$slider_attrs['auto_height'] = $atts['auto_height'];


		// Whether thumbail is enables or not
		$has_thumb     = 'true' === $atts['thumbs'];
		$has_tab       = ! $has_thumb && 'tabs' === $atts['thumbs_type'];
		$has_slideinfo = 'true' === $atts['caption'];

		// Add thumbnail options id enabled
		if( $has_thumb ){
			$slider_attrs['thumbs'] 	  = $atts['thumbs'];
			$slider_attrs['thumbs_type']  = $atts['thumbs_type'];
			$slider_attrs['thumbs_align'] = $atts['thumbs_align'];
			$slider_attrs['thumbs_width'] = $atts['thumbs_width'];
			$slider_attrs['thumbs_height']= $atts['thumbs_height'];
			$slider_attrs['thumbs_space'] = $atts['thumbs_space'];
			$slider_attrs['thumbs_inset'] = $atts['thumbs_inset'];
			$slider_attrs['thumbs_autohide'] = $atts['thumbs_autohide'];
			$slider_attrs['thumbs_margin']   = $atts['thumbs_margin'];
			if( 'bottom' == $slider_attrs['thumbs_align'] )
				$slider_attrs['slideinfo_margin']= '80';

		} elseif( $has_tab ){
			$slider_attrs['thumbs_type'] = 'tabs';
		}

		if( $has_slideinfo ){
			$slider_attrs['slideinfo']       = 'true';
			$slider_attrs['slideinfo_inset'] = 'true';
			$slider_attrs['slideinfo_height']= '30';
		}

		// get attachments
		if ( ! empty( $atts['include'] ) ) {
			$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( ! empty( $atts['exclude'] ) ) {
			$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
		} else {
			$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
		}

		// skip if no attachments found
		if ( empty( $attachments ) ) {
			return '';
		}

		$slides_shortcode = '';


		foreach ( $attachments as $id => $attachment ) {

			$attrs   = '';
			$img_info = wp_get_attachment_image_src( $id, 'large' );

			$img_src = ! empty( $img_info[0] ) ? $img_info[0] : '';

			$attrs  .= sprintf( '%s="%s" ', 'src'     , $img_src );
			$attrs  .= sprintf( '%s="%s" ', 'src_full', $img_src );

			if ( 'file' == $atts['link'] ) {
				$link = $img_src;
			} elseif( 'none' == $atts['link'] ) {
				$link = '';
			} else {
				$link = get_permalink( $id );
			}

			if( ! empty( $link ) ) {
				$attrs .= sprintf( '%s="%s" ', 'link', $link );
			}

			$info     = '';

            $alt_meta = get_post_meta( $id, '_wp_attachment_image_alt', true );

            if( ! empty( $alt_meta ) ){
                $attrs .= sprintf( '%s="%s" ', 'alt'  , $alt_meta );
            } elseif( ! empty( $attachment->post_excerpt ) ){
				$attrs .= sprintf( '%s="%s" ', 'alt'  , $attachment->post_excerpt );
			} else {
				$attrs .= sprintf( '%s="%s" ', 'alt'  , $attachment->post_title   );
			}

            $title_meta = get_post_meta( $id, '_wp_attachment_image_title', true );

            if( ! empty( $title_meta ) ){
                $attrs .= sprintf( '%s="%s" ', 'title'  , $title_meta );
            } else {
                $attrs .= sprintf( '%s="%s" ', 'title'  , $attachment->post_title   );
            }

			if( $has_slideinfo ){
				$caption = $attachment->post_excerpt ? $attachment->post_excerpt : $attachment->post_title;
				$info    = sprintf( '[ms_slide_info]%s[/ms_slide_info]%s', $caption, "\n" );
			}

			$attrs .= sprintf( '%s="%s" ', 'target' , $atts['target'] );
			$attrs .= sprintf( '%s="%s" ', 'delay'  , $atts['delay']  );


			if( $has_thumb ) {
				$thumb = msp_get_the_resized_image_src( $img_src, $atts['thumbs_width'], $atts['thumbs_height'], true );
				$thumb = msp_get_the_relative_media_url( $thumb );
				$attrs .= sprintf( '%s="%s" ', 'thumb' , $thumb );

			} elseif( $has_tab ) {
				$tab    = '<div class=&quot;ms-thumb-alt&quot;>' . $attachment->post_title . '</div>';
				$attrs .= sprintf( '%s="%s" ', 'tab' , $tab );
			}

            $attrs = apply_filters( 'masterslider_gallery_slide_attrs', $attrs );

			$slides_shortcode .= sprintf( '[ms_slide %1$s]%3$s%2$s[/ms_slide]%3$s', $attrs, $info, "\n" );
		}

		/**
		 * Filter slider default attributes. To find full list of slider options, take a look at "msp_masterslider_wrapper_shortcode"
		 * function in /includes/msp-shortcodes.php file
		 *
		 * @var array      List of slider options with values
		 */
		$slider_attrs = apply_filters( 'masterslider_gallery_slider_attrs', $slider_attrs );

		// Convert attrs to string
		$slides_shortcode_attrs = '';
		foreach ( $slider_attrs as $slider_attr => $slider_attr_value ) {
			$slides_shortcode_attrs .= sprintf( '%s="%s" ', $slider_attr, $slider_attr_value );
		}

		// Create slider shortcode
		$gallery_slider_shortcode = sprintf( '[ms_slider %1$s]%2$s%3$s[/ms_slider]', $slides_shortcode_attrs, "\n", $slides_shortcode );


		return do_shortcode( $gallery_slider_shortcode );
	}

}

new MSP_Gallery_Extention();
