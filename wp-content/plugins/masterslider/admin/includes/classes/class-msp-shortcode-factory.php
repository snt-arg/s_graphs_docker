<?php
/**
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


class MSP_Shortcode_Factory {

	public  $parsed_slider_data = array();
	private $post_id;
	private $post_slider_args   = array();

	function __construct() {

	}

	public function set_data( $parsed_data ) {

		$this->parsed_slider_data = $parsed_data;
	}

	/**
	 * Get generated ms_slider shortcode
	 *
	 * @return string  [ms_slider] shortcode or empty string on error
	 */
	public function get_ms_slider_shortcode( $the_content = '' ){

		if( ! isset( $this->parsed_slider_data['setting'] ) )
			return '';


		$shortcode_name = 'ms_slider';

		// get the parsed slider setting
		$setting = $this->parsed_slider_data['setting'];

		$exclude_attrs = array( 'custom_style' );

		// create ms_slider shortcode
		$attrs = '';
		foreach ( $setting as $attr => $attr_value ) {
			if( in_array( $attr, $exclude_attrs ) ){ continue; }
			$attrs .= sprintf( '%s="%s" ', $attr, esc_attr( $attr_value ) );
		}

		// get ms_slides shortcode(s)
		if( 'post' == $this->parsed_slider_data['setting']['slider_type'] ) {

            // remove the empty overlay slide data while it is not available for dynamic sliders
            if( empty( $this->parsed_slider_data['slides']['0'] ) ){
                array_shift( $this->parsed_slider_data['slides'] );
            }
            $the_content = $this->get_post_slider_ms_slides_shortcode();

		} elseif( 'wc-product' == $this->parsed_slider_data['setting']['slider_type'] ) {

            if ( ! msp_is_plugin_active( 'woocommerce/woocommerce.php' ) )
				return __( 'Please install and activate WooCommerce plugin.', MSWP_TEXT_DOMAIN );

            // remove the empty overlay slide data while it is not available for dynamic sliders
            if( empty( $this->parsed_slider_data['slides']['0'] ) ){
                array_shift( $this->parsed_slider_data['slides'] );
            }

			$the_content = $this->get_wc_slider_ms_slides_shortcode();

		} else {
			$the_content = $this->get_ms_slides_shortcode();
		}

		return sprintf( '[%1$s %2$s]%3$s%4$s[/%1$s]', $shortcode_name, $attrs, "\n", $the_content );
	}



	public function get_ms_slide_shortcode( $slide ){

		if( empty( $slide ) )
			return '';

		$shortcode_name = 'ms_slide';

		// stores shortcode attributes
		$attrs = '';

		// the list of attributes which should be excluded from slide shortcode
		$exclude_slide_attrs = array( 'layers', 'layer_ids', 'ishide', 'info' );

		foreach ( $slide as $attr => $attr_value ) {

			if( in_array( $attr, $exclude_slide_attrs ) ){
				continue;
			}

			if( 'src' == $attr && in_array( $this->parsed_slider_data['setting']['slider_type'], array( "flickr", "facebook", "instagram" ) ) ) {
				$attrs .= sprintf( '%s="%s" ', $attr, '{{image}}' );

			} elseif( 'alt' == $attr || 'title' == $attr ) {

				if( in_array( $this->parsed_slider_data['setting']['slider_type'], array( "flickr", "facebook", "instagram" ) ) ){
					$attrs .= sprintf( '%s="%s" ', $attr, '{{title}}' );
				} else {
					$attrs .= sprintf( '%s="%s" ', $attr, $this->escape_square_brackets( $attr_value ) );
				}

			// encode backets ([]) to prevent any conflict while generating slider shortcode
			} elseif( 'link_title' == $attr || 'link_rel' == $attr ) {
				$attrs .= sprintf( '%s="%s" ', $attr, $this->escape_square_brackets( $attr_value ) );

			} elseif( 'thumb' == $attr && ! empty( $attr_value ) && in_array( $this->parsed_slider_data['setting']['slider_type'], array( "flickr", "facebook", "instagram" ) ) ) {
				$attrs .= sprintf( '%s="%s" ', $attr, '{{thumb}}' );

			} else {
				$attrs .= sprintf( '%s="%s" ', $attr, esc_attr( $attr_value ) );
			}
		}

		if( 'true' == $this->parsed_slider_data['setting']['crop'] ){
			$attrs .= sprintf( '%s="%s" ', 'crop_width' , esc_attr( $this->parsed_slider_data['setting']['width']  ) );
			$attrs .= sprintf( '%s="%s" ', 'crop_height', esc_attr( $this->parsed_slider_data['setting']['height'] ) );
		}

		// collect all shortcode output
		$the_content = '';

		// generate slide_info shortcode if slideinfo control is added
		if( 'image-gallery' == $this->parsed_slider_data['setting']['template'] ||
		    ( isset( $this->parsed_slider_data['setting']['slideinfo'] ) && 'true' == $this->parsed_slider_data['setting']['slideinfo'] )
		   ){
			if( ! empty( $slide['info'] ) )
				$the_content .= $this->get_ms_slide_info_shortcode( $slide['info'] );
			else
				$the_content .= $this->get_ms_slide_info_shortcode( "&nbsp;" );
		}

		$the_content .= $this->get_ms_layers_shortcode( $slide['layers'] );

		return sprintf( '[%1$s %2$s]%4$s%3$s[/%1$s]%4$s', $shortcode_name, $attrs, $the_content, "\n" );
	}



    public function get_ms_overlay_slide_shortcode( $slide ){

        if( empty( $slide ) )
            return '';

        // dont generate overlay slide if the corresponding option is not enabled
        if( 'true' != $this->parsed_slider_data['setting']['enable_overlay_layers'] ){
            return '';
        }

        $the_content = $this->get_ms_layers_shortcode( $slide['layers'] );

        return '[ms_overlay_slide]'.$the_content. '[/ms_overlay_slide]'."\n";
    }



	public function get_ms_slides_shortcode() {

		if( ! isset( $this->parsed_slider_data['slides'] ) )
			return '';

		$slides = $this->parsed_slider_data['slides'];

		$shortcodes = '';

		foreach ( $slides as $slide ) {
			if( ! empty( $slide['ishide'] ) && 'true' != $slide['ishide'] ){
                if( 'true' != $slide['is_overlay_layers'] ){
				    $shortcodes .= $this->get_ms_slide_shortcode( $slide );
                } else {
                    $shortcodes .= $this->get_ms_overlay_slide_shortcode( $slide );
                }
            }
		}

		return $shortcodes;
	}



    public function get_ms_slide_info_shortcode( $the_content = '' ){

        if( empty( $the_content ) )
            return '';

        $css_class = ( "&nbsp;" == $the_content ) ? 'ms-info-empty' : '';

        return sprintf( '[%1$s css_class="%3$s"]%2$s[/%1$s]', 'ms_slide_info', $the_content, $css_class )."\n";
    }



	public function get_ms_layer_shortcode( $layer ){

		if( ! isset( $layer ) || empty( $layer ) )
			return '';

		$shortcode_name = 'ms_layer';

		$attrs = '';
		foreach ( $layer as $attr => $attr_value ) {

			if( 'content' == $attr )
				continue;

			if( 'parallax' == $attr && 'off' == $this->parsed_slider_data['setting']['parallax_mode'] )
				continue;

			// users can add {{original-image}} and {{slide-image}} in layer link to link layer to current slide image
			if( 'link' == $attr ){

				if( in_array( $this->parsed_slider_data['setting']['slider_type'], array( 'post', 'wc-product' ) ) ) {
					$attr_value = preg_replace_callback( '/{{[\w-]+}}/', array( $this, 'do_template_tag' ), $attr_value );

				} elseif( '{{slide-image-url}}' == $attr_value ){
					$factory = msp_get_parser();
					$slide  = $factory->get_parent_of_layer( $layer['id'] );
					$attr_value = msp_get_the_absolute_media_url( $slide['src_full'] );
				}
			}

			$attrs .= sprintf( '%s="%s" ', $attr, esc_attr( $attr_value ) );
		}

		$content = $layer['content'];
		if( in_array( $this->parsed_slider_data['setting']['slider_type'], array( 'post', 'wc-product' ) ) ) {
			$content = preg_replace_callback( '/{{[\w-]+}}/', array( $this, 'do_template_tag' ), $content );
		}

		return sprintf( '[%1$s %2$s]%4$s%3$s[/%1$s]%4$s', $shortcode_name, $attrs, $content, "\n" );
	}



	public function get_ms_layers_shortcode( $layers ){

		if( ! isset( $layers ) || empty( $layers ) )
			return '';

		$shortcodes = '';

		foreach ( $layers as $layer ) {
			$shortcodes .= $this->get_ms_layer_shortcode( $layer );
		}

		return $shortcodes;
	}



	public function escape_square_brackets( $context ){
		if( is_null( $context ) ){
			return $content;
		}

		return str_replace( array('[', ']'), array( "%5B", "%5D" ), $context );
	}


	public function escape_special( $context ){
		if( is_null( $context ) ){
			return $content;
		}

		return str_replace( '"', '&quote;', $this->escape_square_brackets( $context) );
	}


    /**
     * Generates shortcode code base of posts for post slider
     *
     * @return string    Post slider shortcode
     */
	public function get_post_slider_ms_slides_shortcode() {

		if( ! isset( $this->parsed_slider_data['slides'] ) )
			return '';

		$slides = $this->parsed_slider_data['slides'];

		$query = array();

		$query['image_from']      = $this->parsed_slider_data['setting']['ps_image_from'];
        $query['excerpt_length']  = $this->parsed_slider_data['setting']['ps_excerpt_len'];
		$exclude_posts_no_img     = $this->parsed_slider_data['setting']['ps_exclude_no_img'];

		if( ! empty( $this->parsed_slider_data['setting']['ps_post_type'] ) )
			$query['post_type'] = $this->parsed_slider_data['setting']['ps_post_type'];

		$query['orderby'] = $this->parsed_slider_data['setting']['ps_orderby'];

		$query['order']   = $this->parsed_slider_data['setting']['ps_order'];

		$query['posts_per_page'] = $this->parsed_slider_data['setting']['ps_post_count'];

		if( ! empty( $this->parsed_slider_data['setting']['ps_posts_not_in'] ) ) {
			$posts_not_in = explode( ',', $this->parsed_slider_data['setting']['ps_posts_not_in'] );
			$query['post__not_in'] = array_filter( $posts_not_in );
		}

		if( ! empty( $this->parsed_slider_data['setting']['ps_posts_in'] ) ) {
			$posts_in = explode( ',', $this->parsed_slider_data['setting']['ps_posts_in'] );
			$query['post__in'] = array_filter( $posts_in );
		}

		$query['offset'] = $this->parsed_slider_data['setting']['ps_offset'];

		$taxs_data = array();

		if( ! empty( $this->parsed_slider_data['setting']['ps_tax_term_ids'] ) ) {
			$taxs_data = explode( ',', $this->parsed_slider_data['setting']['ps_tax_term_ids'] );
		}

		$tax_query   = array();

		$PS = msp_get_post_slider_class();
		$query['tax_query'] = $PS->get_tax_query( $taxs_data );

        if( 'true' == $this->parsed_slider_data['setting']['crop'] ){
            $query['image_size'] = array( $this->parsed_slider_data['setting']['width'], $this->parsed_slider_data['setting']['width'] );
        } else {
            $query['image_size'] = 'large';
        }

        $query = apply_filters( 'msp_post_slider_query_args', $query, $this->parsed_slider_data );

		$this->post_slider_args = $query;



		$slides_shortcode = '';

		$th_wp_query = $PS->get_query_results( $query );


		if( $th_wp_query->have_posts() ):  while ( $th_wp_query->have_posts() ) : $th_wp_query->the_post();

			$slide_content = '';
			$attrs 		   = '';
			$this->post_id = $th_wp_query->post->ID;

            // get slide image
            if( empty( $this->parsed_slider_data['setting']['ps_slide_bg'] ) ) {
                $the_media = msp_get_auto_post_thumbnail_url( $th_wp_query->post, $query['image_from'], $query['image_size'], true );
            } else {
                $the_media = $this->parsed_slider_data['setting']['ps_slide_bg'];
            }
            // skip this post if it does not have image and $exclude_posts_no_img is enabled
            if( empty( $the_media ) && 'true' == $exclude_posts_no_img ){
                continue;
            }
            $attrs .= sprintf( '%s="%s" ', 'src', esc_attr( $the_media ) );


			// generate slide_info shortcode if slideinfo control is added
			if(  isset( $this->parsed_slider_data['setting']['slideinfo'] ) && 'true' == $this->parsed_slider_data['setting']['slideinfo'] ) {

				if( ! empty( $slides['0']['info'] ) ){
					$slide_info = preg_replace_callback( '/{{[\w-]+}}/', array( $this, 'do_template_tag' ), $slides['0']['info'] );
				} else {
					$slide_info = "&nbsp;";
				}

				$slide_content .= $this->get_ms_slide_info_shortcode( $slide_info );
			}


			if( $this->parsed_slider_data['setting']['ps_link_slide'] ) {
				$attrs .= sprintf( '%s="%s" ', 'link', get_the_permalink( $th_wp_query->post->ID ) );
			}

			$attrs .= sprintf( '%s="%s" ', 'title', $this->escape_square_brackets( get_the_title( $th_wp_query->post->ID ) ) );

			$attrs .= sprintf( '%s="%s" ', 'alt'  , $this->escape_square_brackets( get_the_title( $th_wp_query->post->ID ) ) );

			$attrs .= sprintf( '%s="%s" ', 'target' , $this->parsed_slider_data['setting']['ps_link_target'] );

            $attrs .= sprintf( '%s="%s" ', 'delay' , $slides['0']['delay'] );
			$attrs .= sprintf( '%s="%s" ', 'css_class' , $slides['0']['css_class'].' ms-slide-post-' . $th_wp_query->post->ID );

			// bg color and align for slides
			$attrs .= sprintf( '%s="%s" ', 'bgalign' , $slides['0']['bgalign'] );
			$attrs .= sprintf( '%s="%s" ', 'bgcolor' , $slides['0']['bgcolor'] );


			if( ( 'true' == $this->parsed_slider_data['setting']['thumbs'] ) ){

				if( 'thumbs' == $this->parsed_slider_data['setting']['thumbs_type'] ) {

					if( ! empty( $the_media ) ) {

						// set custom thumb size if slider template is gallery
						if( 'image-gallery' == $this->parsed_slider_data['setting']['template']  )
							$thumb = msp_get_the_resized_image_src( $the_media, 175, 140, true );
						else
							$thumb = msp_get_the_resized_image_src( $the_media, $this->parsed_slider_data['setting']['thumbs_width'], $this->parsed_slider_data['setting']['thumbs_height'], true );

						$thumb = msp_get_the_relative_media_url( $thumb );
						$attrs .= sprintf( '%s="%s" ', 'thumb' , $thumb );

					} else {
						$tab    = '<div class=&quot;ms-thumb-alt&quot;>' . get_the_title( $th_wp_query->post->ID ) . '</div>';
						$attrs .= sprintf( '%s="%s" ', 'tab' , $tab );
					}

				} elseif( 'tabs' == $this->parsed_slider_data['setting']['thumbs_type'] ) {

					// if "insert thumb" option was enabled generate and add the thumbnail
					if( 'true' == $this->parsed_slider_data['setting']['thumbs_in_tab'] ) {
						$thumb_height = $this->parsed_slider_data['setting']['thumbs_height'];
						$tab_thumb    = msp_get_auto_post_thumbnail_url( $th_wp_query->post, 'featured', array( $thumb_height, $thumb_height ), true );

						$attrs .= sprintf( '%s="%s" ', 'tab_thumb' , $tab_thumb );
					}

					if( ! empty( $slides['0']['info'] ) ){
						$tab_context = preg_replace_callback( '/{{[\w-]+}}/', array( $this, 'do_template_tag' ), $slides['0']['info'] );
					} else {
						$tab_context = get_the_title( $th_wp_query->post->ID );
					}

					$attrs .= sprintf( '%s="%s" ', 'tab' , $this->escape_special( $tab_context ) );
				}

			}

            // if( 'true' != $slide['is_overlay_layers'] ){
            //     $shortcodes .= $this->get_ms_slide_shortcode( $slide );
            // } else {
            //     $shortcodes .= $this->get_ms_overlay_slide_shortcode( $slide );
            // }
			$slide_content .= $this->get_ms_layers_shortcode( $slides['0']['layers'] );

			$slides_shortcode .= sprintf( '[%1$s %2$s]%4$s%3$s[/%1$s]%4$s', 'ms_slide', $attrs, $slide_content, "\n" );

			endwhile;
		endif;

		// Restore original Post Data
		wp_reset_postdata();

		return $slides_shortcode;
	}




	public function get_wc_slider_ms_slides_shortcode() {

		if( ! isset( $this->parsed_slider_data['slides'] ) )
			return '';

		$slides = $this->parsed_slider_data['slides'];


		$query = array();

		$query['image_from']     = $this->parsed_slider_data['setting']['ps_image_from'];
		$query['excerpt_length'] = $this->parsed_slider_data['setting']['ps_excerpt_len'];
        $exclude_posts_no_img    = $this->parsed_slider_data['setting']['ps_exclude_no_img'];

		$query['only_featured'] = $this->parsed_slider_data['setting']['wc_only_featured'];
		$query['only_instock']  = $this->parsed_slider_data['setting']['wc_only_instock'];
		$query['only_onsale']   = $this->parsed_slider_data['setting']['wc_only_onsale'];

		if( ! empty( $this->parsed_slider_data['setting']['ps_post_type'] ) )
			$query['post_type'] = $this->parsed_slider_data['setting']['ps_post_type'];

		$query['orderby'] = $this->parsed_slider_data['setting']['ps_orderby'];

		$query['order']   = $this->parsed_slider_data['setting']['ps_order'];

		$query['posts_per_page'] = $this->parsed_slider_data['setting']['ps_post_count'];

		if( ! empty( $this->parsed_slider_data['setting']['ps_posts_not_in'] ) ) {
			$posts_not_in = explode( ',', $this->parsed_slider_data['setting']['ps_posts_not_in'] );
			$query['post__not_in'] = array_filter( $posts_not_in );
		}

		if( ! empty( $this->parsed_slider_data['setting']['ps_posts_in'] ) ) {
			$posts_in = explode( ',', $this->parsed_slider_data['setting']['ps_posts_in'] );
			$query['post__in'] = array_filter( $posts_in );
		}

		$query['offset'] = $this->parsed_slider_data['setting']['ps_offset'];

		$taxs_data = array();

		if( ! empty( $this->parsed_slider_data['setting']['ps_tax_term_ids'] ) ) {
			$taxs_data = explode( ',', $this->parsed_slider_data['setting']['ps_tax_term_ids'] );
		}

		$tax_query   = array();

		$wcs = msp_get_wc_slider_class();
		$query['tax_query'] = $wcs->get_tax_query( $taxs_data );

        $query['image_size'] = 'full';
        $query = apply_filters( 'msp_wc_slider_query_args', $query, $this->parsed_slider_data );

		$this->post_slider_args = $query;


		$slides_shortcode = '';

		$th_wp_query = $wcs->get_query_results( $query );


		if( $th_wp_query->have_posts() ):  while ( $th_wp_query->have_posts() ) : $th_wp_query->the_post();

			$product = get_product( $th_wp_query->post );

			$slide_content = '';
			$attrs 		   = '';
			$this->post_id = $th_wp_query->post->ID;


            if( empty( $this->parsed_slider_data['setting']['ps_slide_bg'] ) ) {
                $the_media = msp_get_auto_post_thumbnail_url( $th_wp_query->post, $query['image_from'] );
            } else {
                $the_media = $this->parsed_slider_data['setting']['ps_slide_bg'];
            }
            // skip this post if it does not have image and $exclude_posts_no_img is enabled
            if( empty( $the_media ) && 'true' == $exclude_posts_no_img ){
                continue;
            }
            $attrs .= sprintf( '%s="%s" ', 'src', esc_attr( $the_media ) );


			// generate slide_info shortcode if slideinfo control is added
			if(  isset( $this->parsed_slider_data['setting']['slideinfo'] ) && 'true' == $this->parsed_slider_data['setting']['slideinfo'] ) {

				if( ! empty( $slides['0']['info'] ) ){
					$slide_info = preg_replace_callback( '/{{[\w-]+}}/', array( $this, 'do_template_tag' ), $slides['0']['info'] );
				} else {
					$slide_info = "&nbsp;";
				}

				$slide_content .= $this->get_ms_slide_info_shortcode( $slide_info );
			}


			if( $this->parsed_slider_data['setting']['ps_link_slide'] ) {
				$attrs .= sprintf( '%s="%s" ', 'link', get_the_permalink( $th_wp_query->post->ID ) );
			}

			$attrs .= sprintf( '%s="%s" ', 'title', $this->escape_square_brackets( get_the_title( $th_wp_query->post->ID ) ) );

			$attrs .= sprintf( '%s="%s" ', 'alt'  , $this->escape_square_brackets( get_the_title( $th_wp_query->post->ID ) ) );

			$attrs .= sprintf( '%s="%s" ', 'target' , $this->parsed_slider_data['setting']['ps_link_target'] );

			$attrs .= sprintf( '%s="%s" ', 'delay' , $slides['0']['delay'] );


			// bg color and align for slides
			$attrs .= sprintf( '%s="%s" ', 'bgalign' , $slides['0']['bgalign'] );
			$attrs .= sprintf( '%s="%s" ', 'bgcolor' , $slides['0']['bgcolor'] );


			if( ( 'true' == $this->parsed_slider_data['setting']['thumbs'] ) ){

				if( 'thumbs' == $this->parsed_slider_data['setting']['thumbs_type'] ) {

					if( ! empty( $the_media ) ) {

						// set custom thumb size if slider template is gallery
						if( 'image-gallery' == $this->parsed_slider_data['setting']['template']  )
							$thumb = msp_get_the_resized_image_src( $the_media, 175, 140, true );
						else
							$thumb = msp_get_the_resized_image_src( $the_media, $this->parsed_slider_data['setting']['thumbs_width'], $this->parsed_slider_data['setting']['thumbs_height'], true );

						$thumb = msp_get_the_relative_media_url( $thumb );
						$attrs .= sprintf( '%s="%s" ', 'thumb' , $thumb );

					} else {
						$tab    = '<div class=&quot;ms-thumb-alt&quot;>' . get_the_title( $th_wp_query->post->ID ) . '</div>';
						$attrs .= sprintf( '%s="%s" ', 'tab' , $tab );
					}

				} elseif( 'tabs' == $this->parsed_slider_data['setting']['thumbs_type'] ) {

					// if "insert thumb" option was enabled generate and add the thumbnail
					if( 'true' == $this->parsed_slider_data['setting']['thumbs_in_tab'] ) {
						$thumb_height = $this->parsed_slider_data['setting']['thumbs_height'];
						$tab_thumb    = msp_get_auto_post_thumbnail_url( $th_wp_query->post, 'featured', array( $thumb_height, $thumb_height ), true );

						$attrs .= sprintf( '%s="%s" ', 'tab_thumb' , $tab_thumb );
					}

					if( ! empty( $slides['0']['info'] ) ){
						$tab_context = preg_replace_callback( '/{{[\w-]+}}/', array( $this, 'do_template_tag' ), $slides['0']['info'] );
					} else {
						$tab_context = get_the_title( $th_wp_query->post->ID );
					}

					$attrs .= sprintf( '%s="%s" ', 'tab' , $this->escape_special( $tab_context ) );
				}

			}


			$slide_content .= $this->get_ms_layers_shortcode( $slides['0']['layers'] );

			$slides_shortcode .= sprintf( '[%1$s %2$s]%4$s%3$s[/%1$s]%4$s', 'ms_slide', $attrs, $slide_content, "\n" );

			endwhile;
		endif;

		// Restore original Post Data
		wp_reset_postdata();

		return $slides_shortcode;
	}



	public function do_template_tag( $matches ){
		if( ! isset( $matches['0'] ) )
			return $matches;

		$tag_name = preg_replace('/[{}]/', '', $matches['0'] );
		$tag_name = msp_get_template_tag_value( $tag_name, $this->post_id, $this->post_slider_args );
		$tag_name = $this->escape_square_brackets( $tag_name );

		return is_array( $tag_name ) ? implode( ',', $tag_name ) : $tag_name;
	}

}
