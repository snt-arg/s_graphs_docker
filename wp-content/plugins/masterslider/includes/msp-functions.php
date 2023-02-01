<?php
/**
 *
 * @package   MasterSlider
 * @author    averta [averta.net]
 * @license   LICENSE.txt
 * @link      http://masterslider.com
 * @copyright Copyright © 2014 averta
 */



/**
 * Displays master slider markup for specific slider ID
 *
 * @param  int      $slider_id   the slider id
 * @return void
 */
if( ! function_exists( 'masterslider' ) ) {

    function masterslider( $slider_id, $args = NULL ){
        echo get_masterslider( $slider_id, $args = NULL );
    }

}


/**
 * Get master slider markup for specific slider by ID or alias
 *
 * @param  int      $slider_id   the slider id or alias
 * @return string   the slider markup
 */
if( ! function_exists( 'get_masterslider' ) ) {

    function get_masterslider( $slider_id, $args = NULL ){
        global $msp_instances, $mspdb;

        if( ! $mspdb->get_slider( $slider_id, 'ID' ) ){
            if( empty( $slider_id ) ){
                return '';
            } elseif( $slider_data = $mspdb->get_slider( $slider_id, 'alias' ) ){
                $slider_id   = $slider_data['ID'];
            } else{
                return __( 'Invalid slider ID or alias.', MSWP_TEXT_DOMAIN );
            }
        }

        // load masterslider script
        wp_enqueue_style ( 'masterslider-main');
        wp_enqueue_script( 'masterslider-core');

        $is_cache_enabled = ( 'on' == msp_get_setting( '_enable_cache', 'msp_general_setting', 'off' ) );

        // try to get cached copy of slider transient output
        if( ! $is_cache_enabled || false === ( $slider_output = msp_get_slider_transient( $slider_id ) ) || empty( $slider_output ) ) {
            $slider_output = msp_generate_slider_output( $slider_id, $is_cache_enabled );

        } elseif( $is_cache_enabled ) {
            $msp_instances = is_array( $msp_instances ) ? $msp_instances : array();
            $msp_instances[ $slider_id ][] = $slider_id;
            // if there was same slider on one page generate new ones
            if( count( $msp_instances[ $slider_id ] ) > 1 ){
                $slider_output = msp_generate_slider_output( $slider_id );
            }
        }

        return apply_filters( 'masterslider_slider_content', $slider_output, $slider_id );
    }
}



/**
 * Get master slider markup for specific slider by slider's title
 *
 * @param  int      $slider_title   the slider title
 * @return string   the slider markup
 */
if( ! function_exists( 'get_masterslider_by_title' ) ) {

    function get_masterslider_by_title( $slider_title = 'Homepage' ){

        global $mspdb;

        $result = $mspdb->get_sliders_list( 0, 0, 'ID', 'DESC', "title='$slider_title'" );
        if( $result && isset( $result[0]['ID'] ) ){
            return get_masterslider( $result[0]['ID'] );
        }

        return sprintf( __( 'Master Slider cannot find "%s" slider.', MSWP_TEXT_DOMAIN ), $slider_title );
    }
}




/**
 * Convert panel data to ms_slider shortcode and return it
 *
 * @param  string    $panel_data   a serialized string containing panel data object
 * @return string    ms_slider shortcode or empty string
 */
function msp_panel_data_2_ms_slider_shortcode( $panel_data, $slider_id = null ){
    if ( ! $panel_data )
        return '';

    $parser = msp_get_parser();
    $parser->set_data( $panel_data, $slider_id );
    $results = $parser->get_results();

    // shortcode generation
    $sf = msp_get_shortcode_factory();
    $sf->set_data( $results );
    $shortcodes = $sf->get_ms_slider_shortcode();
    return $shortcodes;
}


/**
 * Convert panel data to ms_slider shortcode and return it
 *
 * @param  int      $slider_id   The ID of the slider you'd like to get its shortcode
 * @return string   ms_slider shortcode or empty string
 */
function msp_get_ms_slider_shortcode_by_slider_id( $slider_id ){
    // get slider panel data from database
    global $mspdb;
    $panel_data = $mspdb->get_slider_field_val( $slider_id, 'params' );
    $shortcode = msp_panel_data_2_ms_slider_shortcode( $panel_data, $slider_id );
    return $shortcode;
}


/**
 * Convert panel data to ms_slider shortcode (cache it) and return it
 *
 * @param  int      $slider_id   The ID of the slider you'd like to get its output
 * @param  bool     $cache_output Whether to store output in cache or not
 * @return string   The slider output
 */
function msp_generate_slider_output( $slider_id, $cache_output = false ){
    $ms_slider_shortcode = msp_get_ms_slider_shortcode_by_slider_id( $slider_id );
    $slider_output = do_shortcode( $ms_slider_shortcode );
    if( $cache_output )
        msp_set_slider_transient( $slider_id, $slider_output );

    return $slider_output;
}


/**
 * Flush and re-cache slider output if slider cache is enabled
 *
 * @param  int      $slider_id   The ID of the slider you'd like to flush the cache
 * @return bool     True if the cache is flushed and false otherwise
 */
function msp_flush_slider_cache( $slider_id ){

    $is_cache_enabled = ( 'on' == msp_get_setting( '_enable_cache', 'msp_general_setting', 'off' ) );
    if( $is_cache_enabled ){
        msp_generate_slider_output( $slider_id, true );
        return true;
    }
    return false;
}


/**
 * Flush and re-cache all slideres if slider cache is enabled
 *
 * @param  int      $slider_type   The list of slider types that you intent to flush. Empty means flush all sliders types.
 *
 * @return bool     True if the cache is flushed and false otherwise
 */
function msp_flush_all_sliders_cache( $slider_types = array() ){

    $is_cache_enabled = ( 'on' == msp_get_setting( '_enable_cache', 'msp_general_setting', 'off' ) );
    if( ! $is_cache_enabled ){ return false; }

    $all_sliders = get_mastersliders();
    foreach ( $all_sliders as $slider_info ) {
        if( empty( $slider_types ) || ( ! empty( $slider_info['type'] ) && in_array( $slider_info['type'] , $slider_types ) ) ){
            msp_delete_slider_transient( $slider_info['ID'] );
        }
    }

    return true;
}


/**
 * Takes a slider ID and returns slider's parsed data in an array
 * You can use this function to access slider data (setting, slides, layers, styles)
 *
 * @param  int        $slider_id   The ID of the slider you'd like to get its parsed data
 * @return array      array containing slider's parsed data
 */
function get_masterslider_parsed_data( $slider_id ){
    // get slider panel data from database
    global $mspdb;
    $panel_data = $mspdb->get_slider_field_val( $slider_id, 'params' );

    if ( ! $panel_data )
        return array();

    $parser = msp_get_parser();
    $parser->set_data( $panel_data, $slider_id );
    return $parser->get_results();
}


/**
 * Load and init parser class on demand
 *
 * @return Object instance of MSP_Parser class
 */
function msp_get_parser() {
    include_once( MSWP_AVERTA_ADMIN_DIR . '/includes/classes/class-msp-parser.php' );

    global $msp_parser;
    if ( is_null( $msp_parser ) )
        $msp_parser = new MSP_Parser();

    return $msp_parser;
}


/**
 * Load and init shortcode_factory class on demand
 *
 * @return Object instance of MSP_Shortcode_Factory class
 */
function msp_get_shortcode_factory () {
    include_once( MSWP_AVERTA_ADMIN_DIR . '/includes/classes/class-msp-shortcode-factory.php' );

    global $mspsf;
    if ( is_null( $mspsf ) )
        $mspsf = new MSP_Shortcode_Factory();

    return $mspsf;
}


/**
 * Load and init post_slider class on demand
 *
 * @return Object instance of MSP_Post_Slider class
 */
function msp_get_post_slider_class() {
    include_once( MSWP_AVERTA_ADMIN_DIR . '/includes/classes/class-msp-post-sliders.php' );

    global $msp_post_slider;
    if ( is_null( $msp_post_slider ) )
        $msp_post_slider = new MSP_Post_Slider();

    return $msp_post_slider;
}


/**
 * Load and init wc_product_slider class on demand
 *
 * @return Object instance of MSP_WC_Product_Slider class
 */
function msp_get_wc_slider_class() {
    include_once( MSWP_AVERTA_ADMIN_DIR . '/includes/classes/class-msp-wc-product-slider.php' );

    global $msp_wc_slider;
    if ( is_null( $msp_wc_slider ) )
        $msp_wc_slider = new MSP_WC_Product_Slider();

    return $msp_wc_slider;
}


/**
 * Update custom_css, custom_fonts and slide num fields in sliders table
 *
 * @param int $slider_id the slider id that is going to be updated
 * @return int|false The number of rows updated, or false on error.
 */
function msp_update_slider_custom_css_and_fonts( $slider_id ) {

    if( ! isset( $slider_id ) || ! is_numeric( $slider_id ) )
        return false;

    // get database tool
    global $mspdb;

    $slider_params = $mspdb->get_slider_field_val( $slider_id, 'params' );

    if( ! $slider_params )
        return false;

    // load and get parser and start parsing data
    $parser = msp_get_parser();
    $parser->set_data( $slider_params, $slider_id );

    // get required parsed data
    $slider_setting       = $parser->get_slider_setting();
    $slides               = $parser->get_slides();
    $slider_custom_styles = $parser->get_styles();

    $fields = array(
        'slides_num'    => count( $slides ),
        'custom_styles' => $slider_custom_styles,
        'custom_fonts'  => $slider_setting[ 'gfonts' ]
    );

    msp_save_custom_styles();

    $mspdb->update_slider( $slider_id, $fields );
}


/**
 * Set/update the value of a slider output transient.
 *
 * @param  int   $slider_id     The slider id
 * @param  mixed $value         Slider transient output
 * @param  int   $cache_period  Time until expiration in hours, default 12
 * @return bool                 False if value was not set and true if value was set.
 */
function msp_set_slider_transient( $slider_id, $value, $cache_period = null ) {
    $cache_period = is_numeric( $cache_period ) ? (float)msp_get_setting( '_cache_period', 'msp_general_setting', 12 ) : $cache_period;
    return set_transient( 'masterslider_output_' . $slider_id , $value, (int)$cache_period * HOUR_IN_SECONDS );
}


/**
 * Get the value of a slider output transient.
 *
 * @param  int     $slider_id     The slider id
 * @return mixed   Value of transient or False If the transient does not exist or does not have a value
 */
function msp_get_slider_transient( $slider_id ) {
    return get_transient( 'masterslider_output_' . $slider_id );
}

/**
 * Remove the value of a slider output transient.
 *
 * @param  int     $slider_id     The slider id
 * @return mixed   true if successful, false otherwise
 */
function msp_delete_slider_transient( $slider_id ) {
    return delete_transient( 'masterslider_output_' . $slider_id );
}


/**
 * Whether it's absolute url or not
 *
 * @param  string $url  The URL
 * @return bool   TRUE if the URL is absolute
 */
function msp_is_absolute_url( $url ){
    return preg_match( "~^(?:f|ht)tps?://~i", $url );
}


/**
 * Whether the URL contains upload directory path or not
 *
 * @param  string $url  The URL
 * @return bool   TRUE if the URL is absolute
 */
function msp_contains_upload_dir( $url ){
    $uploads_dir = wp_upload_dir();
    return strpos( $url, $uploads_dir['baseurl'] ) !== false;
}


/**
 * Print absolute URL for media file event if the URL is relative
 *
 * @param  string $url  The link to media file
 * @return void
 */
function msp_the_absolute_media_url( $url ){
    echo msp_get_the_absolute_media_url( $url );
}

    /**
     * Get absolute URL for media file event if the URL is relative
     *
     * @param  string $url  The link to media file
     * @return string   The absolute URL to media file
     */
    if( ! function_exists( 'msp_get_the_absolute_media_url' ) ){

        function msp_get_the_absolute_media_url( $url ){
            if( empty( $url ) )
                return '';

            if( msp_is_absolute_url( $url ) || msp_contains_upload_dir( $url ) ) return $url;

            $uploads = wp_upload_dir();
            return apply_filters( 'msp_get_the_absolute_media_url', set_url_scheme( $uploads['baseurl'] . $url ) ) ;
        }

    }


/**
 * Print relative URL for media file event if the URL is absolute
 *
 * @param  string $url  The link to media file
 * @return void
 */
function msp_the_relative_media_url( $url ){
    echo msp_get_the_relative_media_url( $url );
}

    /**
     * Get relative URL for media file event if the URL is absolute
     *
     * @param  string $url  The link to media file
     * @return string   The absolute URL to media file
     */
    if( ! function_exists( 'msp_get_the_relative_media_url' ) ){

        function msp_get_the_relative_media_url($url){
            if( ! isset( $url ) || empty( $url ) )     return '';

            // if it's not internal absolute url
            if( ! msp_contains_upload_dir( $url ) ) return $url;

            $uploads_dir = wp_upload_dir();
            return str_replace( $uploads_dir['baseurl'], '', $url );
        }

    }


/*-----------------------------------------------------------------------------------*/
/*  Custom functions for resizing images
/*-----------------------------------------------------------------------------------*/


// get resized image by image src ////////////////////////////////////////////////////


function msp_the_resized_image( $img_url = "", $width = null , $height = null, $crop = null , $quality = 100, $alt = '' ) {
    echo msp_get_the_resized_image( $img_url , $width , $height , $crop , $quality, $alt );
}

    function msp_get_the_resized_image( $img_url = "", $width = null , $height = null, $crop = null , $quality = 100, $alt = '' ) {
        $src = msp_aq_resize( $img_url, $width, $height, $crop, $quality );
        if( empty( $src ) ) return '';

        return '<img src="'. $src .'" alt="'. $alt .'" />';
    }
        /**
         * Get resized image by image URL
         *
         * @param  string   $img_url  The original image URL
         * @param  integer  $width    New image Width
         * @param  integer  $height   New image height
         * @param  bool     $crop     Whether to crop image to specified height and width or resize. Default false (soft crop).
         * @param  integer  $quality  New image quality - a number between 0 and 100
         * @return string   new image src
         */
        if( ! function_exists( 'msp_get_the_resized_image_src' ) ){

            function msp_get_the_resized_image_src( $img_url = "", $width = null , $height = null, $crop = null , $quality = 100 ) {
                $resized_img_url = msp_aq_resize( $img_url, $width, $height, $crop, $quality );
                if( empty( $resized_img_url ) )
                    $resized_img_url = $img_url;
                return apply_filters( 'msp_get_the_resized_image_src', $resized_img_url, $img_url );
            }

        }


// get resized image by attachment id /////////////////////////////////////////////////


// echo resized image tag
function msp_the_resized_attachment( $attach_id = null, $width = null , $height = null, $crop = null , $quality = 100 ) {
    echo msp_get_the_resized_attachment( $attach_id, $width , $height, $crop, $quality );
}

    // return resized image tag
    function msp_get_the_resized_attachment( $attach_id = null, $width = null , $height = null, $crop = null , $quality = 100 ) {
        $image_src = msp_get_the_resized_attachment_src( $attach_id, $width , $height, $crop, $quality );

        return $image_src ? '<img src="'.esc_url( $image_src ).'" alt="" />': '';
    }

        /**
         * Get resized image by attachment id
         *
         * @param  string   $attach_id  The attachment id
         * @param  integer  $width    New image Width
         * @param  integer  $height   New image height
         * @param  bool     $crop     Whether to crop image to specified height and width or resize. Default false (soft crop).
         * @param  integer  $quality  New image quality - a number between 0 and 100
         * @return string   new image src
         */
        if( ! function_exists( 'msp_get_the_resized_attachment_src' ) ){

            function msp_get_the_resized_attachment_src( $attach_id = null, $width = null , $height = null, $crop = null , $quality = 100 ) {
                if( is_null( $attach_id ) ) return '';

                $img_url = wp_get_attachment_url( $attach_id ); //get img URL
                return ! empty( $img_url ) ? msp_aq_resize( $img_url, $width, $height, $crop, $quality ) : false;
            }

        }

// get resized image featured by post id ///////////////////////////////////////////////


// echo resized image tag
function msp_the_post_thumbnail( $post_id = null, $size = array( null, null ), $crop = null , $quality = 100 ) {
    echo msp_get_the_post_thumbnail( $post_id, $size, $crop, $quality);
}

    // return resized image tag
    function msp_get_the_post_thumbnail( $post_id = null, $size = array( null, null ), $crop = null , $quality = 100 ) {
        $image_atts = msp_get_the_post_thumbnail_src( $post_id, $size, $crop, $quality );
        return $image_atts ? '<img src="'.$image_atts[0].'" width="'.$image_atts[1].'" height="'.$image_atts[2].'" alt="" />' : '';
    }

        /**
         * Get resized image by post id
         *
         * @param  mixed    $post_id  The post id or post object
         * @param  int|string|array $size Optional. Image size. Accepts any valid image size, an array of width and
         *                               height values in pixels (in that order), 0, or 'none'. 0 or 'none' will
         *                               default to 'post_title' or `$text`. Default 'thumbnail'.
         * @param  bool     $crop     Whether to crop image to specified height and width or resize. Default false (soft crop).
         * @param  integer  $quality  New image quality - a number between 0 and 100
         * @return array    An array containing:
         *                                  [0] => url
         *                                  [1] => width
         *                                  [2] => height
         *                                  [3] => boolean: true if $url is a resized image, false if it is the original or if no image is available.
         */
        if( ! function_exists( 'msp_get_the_post_thumbnail_src' ) ){

            function msp_get_the_post_thumbnail_src( $post_id = null, $size = array( null, null ), $crop = null , $quality = 100 ) {

                if( ! $the_post = get_post( $post_id ) ){
                    return false;
                }

                $post_id = $the_post->ID;

                // Get the featured image attachment ID
                $featured_image_id = get_post_thumbnail_id( $post_id );

                if( is_string( $size ) ){
                    $image_attrs = wp_get_attachment_image_src( $featured_image_id, $size );
                    return apply_filters( 'msp_get_the_post_thumbnail_src', $image_attrs, $featured_image_id, $size, $crop, $quality );
                }

                $image_attrs = wp_get_attachment_image_src( $featured_image_id, 'full' ); //get img URL
                if( is_array( $image_attrs ) ){
                    // update the src attribute with the resized image
                    $image_attrs[0] = msp_aq_resize( $image_attrs[0], $size[0], $size[1], $crop, $quality );
                    return apply_filters( 'msp_get_the_post_thumbnail_src', $image_attrs, $featured_image_id, $size, $crop, $quality );
                }

                return false;
            }

        }



   /**
     * Returns a cropped post image (featured image or first image in content) from a post id
     *
     * @param  integer $post_id      The post id to get post image of
     * @param  string  $image_from   where to look for post image. possible values are : auto, featured, first. Default to 'auto'
     * @param  int|string|array $size Optional. Image size. Accepts any valid image size, an array of width and
     *                               height values in pixels (in that order), 0, or 'none'. 0 or 'none' will
     *                               default to 'post_title' or `$text`. Default 'thumbnail'.
     * @param  bool     $crop        Whether to crop image to specified height and width or resize. Default false (soft crop).
     * @param  integer  $quality     New image quality - a number between 0 and 100
     *
     * @return string  Returns a  image tag or empty string on failure.
     */
    if( ! function_exists( 'msp_get_auto_post_thumbnail' ) ){

        function msp_get_auto_post_thumbnail( $post_id = null, $image_from = 'auto', $size = 'full', $crop = null , $quality = 100 ) {
            $post  = get_post( $post_id );
            $image = msp_get_auto_post_thumbnail_src( $post->ID, $image_from, $size, $crop, $quality );

            return isset( $image[0] ) && ! empty( $image[0] ) ? '<img src="'.$image[0].'" alt="'.$post->post_title.'" />' : '';
        }

    }

        if( ! function_exists( 'msp_get_auto_post_thumbnail_url' ) ){

            function msp_get_auto_post_thumbnail_url( $post_id = null, $image_from = 'auto', $size = 'full', $crop = null , $quality = 100 ) {
                $image = msp_get_auto_post_thumbnail_src( $post_id, $image_from, $size, $crop, $quality );
                return isset( $image[0] ) && ! empty( $image[0] ) ? $image[0] : false;
            }

        }

        /**
         * Get full URI of a post image (featured image or first image in content) for a post id
         *
         * @param  integer $post_id      The post id to get post image of
         * @param  string  $image_from   where to look for post image. possible values are : auto, featured, first. Default to 'auto'
         * @param  int|string|array $size Optional. Image size. Accepts any valid image size, an array of width and
         *                               height values in pixels (in that order), 0, or 'none'. 0 or 'none' will
         *                               default to 'post_title' or `$text`. Default 'thumbnail'.
         * @param  bool     $crop        Whether to crop image to specified height and width or resize. Default false (soft crop).
         * @param  integer  $quality     New image quality - a number between 0 and 100
         *
         * @return string  Returns a full URI for post image or empty string on failure.
         */
        if( ! function_exists( 'msp_get_auto_post_thumbnail_src' ) ){

            function msp_get_auto_post_thumbnail_src( $post_id = null, $image_from = 'auto', $size = 'full', $crop = null , $quality = 100 ) {

                $post  = get_post( $post_id );
                $image = false;

                if( empty( $post ) ) return '';

                if ( 'auto' == $image_from || 'featured' == $image_from ) {
                    $image = has_post_thumbnail( $post->ID ) ? msp_get_the_post_thumbnail_src( $post->ID, $size ) : false;
                }

                if( 'auto' == $image_from ) {

                    if( ! $image || ! isset( $image[0] ) ) {
                        $img_src = msp_get_first_image_src_from_string( $post->post_content );
                        if( ! is_array( $size ) || ! isset( $size[1] ) ){
                            $size = array( null, null);
                        }
                        $img_src = msp_aq_resize( $img_src, $size[0], $size[1], $crop, $quality );
                        $image   = array( $img_src, $size[0], $size[1] );
                    }

                } elseif ( 'first' == $image_from ) {
                    $img_src = msp_get_first_image_src_from_string( $post->post_content );
                    if( ! is_array( $size ) || ! isset( $size[1] ) ){
                        $size = array( null, null);
                    }
                    $img_src = msp_aq_resize( $img_src, $size[0], $size[1], $crop, $quality );
                    $image   = array( $img_src, $size[0], $size[1] );
                }

                return $image;
            }

        }


///// extract image from content ////////////////////////////////////////////////////

/**
 * Get first image tag from string
 *
 * @param  string $content  The content to extract image from
 * @return string           First image tag on success and empty string if nothing found
 */
function msp_get_first_image_from_string( $content ){
    $images = msp_extract_string_images( $content );
    return ( $images && count( $images[0]) ) ? $images[0][0] : '';
}

/**
 * Get first image src from content
 *
 * @param  string $content  The content to extract image from
 * @return string           First image URL on success and empty string if nothing found
 */
function msp_get_first_image_src_from_string( $content ){
    $images = msp_extract_string_images( $content );
    return ( $images && count( $images[1]) ) ? $images[1][0] : '';
}

    /**
     * Extract all images from content
     *
     * @param  string $content   The content to extract images from
     * @return array             List of images in array
     */
    if( ! function_exists( 'msp_extract_string_images' ) ){

        function msp_extract_string_images( $content ){
            preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', $content, $matches );
            return isset( $matches ) && count( $matches[0] ) ? $matches : false;
        }

    }


/*-----------------------------------------------------------------------------------*/


/**
 * Get list of created slider IDs and names in an array
 *
 * @param  bool    $pair_fields If <code>id-title</code> returns slider ID as array key and slider name as value , reverse on <code>title-id</code>
 * @param  int     $limit       Maximum number of sliders to return - 0 means no limit
 * @param  int     $offset      The offset of the first row to return
 * @param  string  $orderby     The field name to order results by
 * @param  string  $sort        The sort type. 'DESC' or 'DESC'
 *
 * @return array   An array containing sliders ID as array key and slider name as value
 *
 * @example   $pair_fields = 'id-title' :
 *            array(
 *                '12' => 'Slider sample title 1',
 *                '13' => 'Slider sample title 2'
 *            )
 *
 *            $pair_fields = 'title-id' :
 *            array(
 *                'Slider sample title 1' => '12',
 *                'Slider sample title 2' => '13'
 *            )
 *
 *            $pair_fields = 'alias-title' :
 *            array(
 *                'ms-2' => 'Slider sample title 2',
 *                'ms-3' => 'Slider sample title 3'
 *            )
 *
 */
function get_masterslider_names( $pair_fields = 'id-title', $limit = 0, $offset  = 0, $orderby = 'ID', $sort = 'DESC' ){
    global $mspdb;

    // replace 0 with max numbers od records you need
    if ( $sliders_data = $mspdb->get_sliders_list( $limit = 0, $offset  = 0, $orderby = 'ID', $sort = 'DESC' ) ) {
        // stores sliders 'ID' and 'title'
        $sliders_name_list = array();

        // backward compatibility for legacy arguments
        if( true === $pair_fields ){
            $pair_fields = 'id-title';
        } elseif( false === $pair_fields ){
            $pair_fields = 'title-id';
        } elseif( 'alias' === $pair_fields ){
            $pair_fields = 'alias-title';
        }

        $pair_fields  = strtolower( $pair_fields );
        $option_value = explode( '-', $pair_fields );

        foreach ( $sliders_data as $slider_data ) {
            if( 'id-title' === $pair_fields ){
                $sliders_name_list[ $slider_data['ID'] ]    = $slider_data['title'];
            } elseif( 'title-id' === $pair_fields ){
                $sliders_name_list[ $slider_data['title'] ] = $slider_data['ID'];
            } else{
                $sliders_name_list[ $slider_data[ $option_value['0'] ] ] = $slider_data[ $option_value['1'] ];
            }
        }

        return $sliders_name_list;
    }

    return array();
}


/**
 * Get an array containing row results (unserialized) from sliders table (with all slider table fields)
 *
 * @param  int $limit       Maximum number of records to return
 * @param  int $offset      The offset of the first row to return
 * @param  string $orderby  The field name to order results by
 * @param  string $sort     The sort type. 'DESC' or 'ASC'
 * @param  string $where    The sql filter to get results by
 * @return array            Slider data in array
 */
function get_mastersliders( $limit = 0, $offset = 0, $orderby = 'ID', $sort = 'DESC', $where = "status='published'" ) {
    global $mspdb;

    $sliders_array = $mspdb->get_sliders( $limit, $offset, $orderby, $sort, $where );
    return is_null( $sliders_array ) ? array() : $sliders_array;
}


/**
 * Get option value
 *
 * @param   string  $option_name a unique name for option
 * @param   string  $default_value  a value to return by function if option_value not found
 * @return  string  option_value or default_value
 */
function msp_get_option( $option_name, $default_value = '' ) {
    global $mspdb;
    return $mspdb->get_option( $option_name, $default_value );
}


/**
 * Update option value in options table, if option_name does not exist then insert new option
 *
 * @param   string $option_name a unique name for option
 * @param   string $option_value the option value
 *
 * @return int|false ID number for new inserted row or false if the option can not be updated.
 */
function msp_update_option( $option_name, $option_value = '' ) {
    global $mspdb;
    return $mspdb->update_option( $option_name, $option_value );
}


/**
 * Remove a specific option name from options table
 *
 * @param   string $option_name a unique name for option
 * @return bool True, if option is successfully deleted. False on failure.
 */
function msp_delete_option( $option_name ) {
    global $mspdb;
    return $mspdb->delete_option( $option_name );
}


/**
 * Get the value of a settings field
 *
 * @param string  $option  settings field name
 * @param string  $section the section name this field belongs to
 * @param string  $default default text if it's not found
 * @return string
 */
function msp_get_setting( $option, $section, $default = '' ) {

    $options = get_option( $section );

    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }

    return $default;
}

/*-----------------------------------------------------------------------------------*/
/*  Get trimmed string
/*-----------------------------------------------------------------------------------*/

function msp_the_trimmed_string( $string, $max_length = 1000, $more = ' ...' ){
    echo msp_get_trimmed_string( $string, $max_length, $more );
}

    /**
     * Trim string by character length
     *
     * @param string  $string  The string to trim
     * @param integer $max_length  The width of the desired trim.
     * @param $string $more  A string that is added to the end of string when string is truncated.
     * @return string The trimmed string
     */
    if( ! function_exists( 'msp_get_trimmed_string') ){

        function msp_get_trimmed_string( $string, $max_length = 1000, $more = ' ...' ){
            $trimmed = function_exists( 'mb_strimwidth' ) ? mb_strimwidth( $string, 0, $max_length, $more ) : substr( $string, 0, $max_length ) . $more;
            return wp_kses_post( $trimmed );
        }

    }

/*-----------------------------------------------------------------------------------*/
/*  Shortcode enabled excerpts trimmed by character length
/*-----------------------------------------------------------------------------------*/

function msp_the_trim_excerpt( $post_id = null, $char_length = null, $exclude_strip_shortcode_tags = null ){
    echo msp_get_the_trim_excerpt( $post_id, $char_length, $exclude_strip_shortcode_tags );
}

    if( ! function_exists( 'msp_get_the_trim_excerpt' ) ){

        // make shortcodes executable in excerpt
        function msp_get_the_trim_excerpt( $post_id = null, $char_length = null, $exclude_strip_shortcode_tags = null ) {
            $post = get_post( $post_id );
            if( ! isset( $post ) ) return "";


            $excerpt = $post->post_content;
            $raw_excerpt = $excerpt;
            $excerpt = apply_filters( 'the_content', $excerpt );
            // If char length is defined use it, otherwise use default char length
            $char_length  = empty( $char_length ) ? apply_filters( 'masterslider_excerpt_char_length', 250 ) : $char_length;
            $excerpt_more = apply_filters('excerpt_more', ' ...');
            $excerpt_more = apply_filters('masterslider_excerpt_more', $excerpt_more );

            // Clean post content
            $excerpt = strip_tags( msp_strip_shortcodes( $excerpt, $exclude_strip_shortcode_tags ) );
            $text = msp_get_trimmed_string( $excerpt, $char_length, $excerpt_more );

            $text = apply_filters( 'wp_trim_excerpt', $text, $raw_excerpt );
            return wp_kses_post( $text );
        }

    }

/*-----------------------------------------------------------------------------------*/
/*  Get excerpt by post ID
/*-----------------------------------------------------------------------------------*/

function msp_the_excerpt_by_id( $post_id = null, $char_length = null ){
    echo msp_get_the_excerpt_by_id( $post_id, $char_length );
}

    if( ! function_exists( 'msp_get_the_excerpt_by_id' ) ){

        /**
         * Get excerpt by post ID
         * @param  int|object $post_id     Tge post id or post object
         * @param  int        $char_length Maximum excerpt char length limit
         * @return string                  The excerpt
         */
        function msp_get_the_excerpt_by_id( $post_id = null, $char_length = null ) {
            $post = get_post( $post_id );
            if( ! isset( $post ) ) return "";


            $excerpt      = apply_filters( 'the_excerpt', get_post_field( 'post_excerpt', $post->ID ) );
            $excerpt_more = apply_filters( 'excerpt_more', ' ...');

            // If post have excerpt, return it
            if( ! empty( $excerpt ) ){
                // if the max char limit was set, trim the excerpt
                if( $char_length ){
                    $excerpt = msp_get_trimmed_string( $excerpt, $char_length, $excerpt_more );
                }
                return $excerpt;
            }

            // If the excerpt was not created, generate the excerpt by post content
            return msp_get_the_trim_excerpt( $post, $char_length );
        }

    }

/*-----------------------------------------------------------------------------------*/
/*  Remove just shortcode tags from the given content but keep content of shortcodes
/*-----------------------------------------------------------------------------------*/

function msp_strip_shortcodes( $content, $exclude_strip_shortcode_tags = null ) {
    if( ! $content ) return $content;

    if( ! $exclude_strip_shortcode_tags )
        $exclude_strip_shortcode_tags = msp_exclude_strip_shortcode_tags();

    if( empty( $exclude_strip_shortcode_tags ) || !is_array( $exclude_strip_shortcode_tags ) )
        return preg_replace( '/\[[^\]]*\]/', '', $content );

    $exclude_codes = join( '|', $exclude_strip_shortcode_tags );
    return preg_replace( "~(?:\[/?)(?!(?:$exclude_codes))[^/\]]+/?\]~s", '', $content );
}


/*-----------------------------------------------------------------------------------*/
/*  The list of shortcode tags that should not be removed in msp_strip_shortcodes
/*-----------------------------------------------------------------------------------*/

function msp_exclude_strip_shortcode_tags(){
    return apply_filters( 'msp_exclude_strip_shortcode_tags', array() );
}

/**
 * Get all custom post types
 * @return array  List of all custom post types
 */
function msp_get_custom_post_types(){
	$custom_post_types = get_post_types( array( '_builtin' => false ), 'objects' );
	return apply_filters( 'masterslider_get_custom_post_types', $custom_post_types );
}


/**
 * Whether a plugin is active or not
 * @param  string $plugin_basename  plugin directory name and mail file address
 * @return bool                  True if plugin is active and FALSE otherwise
 */
function msp_is_plugin_active( $plugin_basename ){
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    return is_plugin_active( $plugin_basename );
}


function msp_get_template_tag_value( $tag_name, $post = null, $args = null ){
	$post  = get_post( $post );
	$value = '{{' . $tag_name . '}}';


	switch ( $tag_name ) {

		case 'title':
			$value = $post->post_title;
			break;

        case 'linked_title':
            $value = sprintf( '<a href="%s" >%s</a>', $post->guid, $post->post_title );
            break;

		case 'content':
			$value = $post->post_content;
			break;

		case 'excerpt':
            $excerpt_length = isset( $args['excerpt_length'] ) ? (int)$args['excerpt_length'] : 80;
            $value = msp_get_the_excerpt_by_id( $post->ID, $excerpt_length );
            break;

		case 'permalink':
			$value = get_permalink( $post );
			break;

        case 'author':
            $value = get_the_author_meta( 'display_name', (int)$post->post_author );
            break;

		case 'author-avatar':
            $user_email = get_the_author_meta( 'user_email', (int)$post->post_author );
			$value = get_avatar( $user_email );
			break;

		case 'post_id':
			$value = $post->ID;
			break;

        case 'categories':
            $taxonomy_objects = get_object_taxonomies( $post, 'objects' );
            $value = '';
            foreach ( $taxonomy_objects as $tax_name => $tax_info ) {
                if( 1 == $tax_info->hierarchical ){
                    $term_list = wp_get_post_terms($post->ID, $tax_name, array("fields" => "names") );
                    $value .= implode( ' / ' , $term_list );
                }
            }
            $value = rtrim( $value, ' / ' );
            break;

        case 'tags':
            $taxonomy_objects = get_object_taxonomies( $post, 'objects' );
            $value = '';
            foreach ( $taxonomy_objects as $tax_name => $tax_info ) {
                if( 1 !== $tax_info->hierarchical ){
                    $term_list = wp_get_post_terms($post->ID, $tax_name, array("fields" => "names") );
                    $value .= implode( ' / ' , $term_list ) . ' / ';
                }
            }
            $value = rtrim( $value, ' / ' );
            break;

		case 'image':
			$value = msp_get_auto_post_thumbnail( $post, 'featured' );
			break;

		case 'image-url':
        case 'slide-image-url':
            $value = msp_get_auto_post_thumbnail_url( $post, 'auto' );
            break;

        case 'image-alt':
            $attachment_id = get_post_thumbnail_id( $post->ID );
            $value = ! empty( $attachment_id ) ? get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) : '';
            break;

        case 'image-title':
            $attachment_id = get_post_thumbnail_id( $post->ID );
            $value = ! empty( $attachment_id ) ? get_post_meta( $attachment_id, '_wp_attachment_image_title', true ) : '';
            break;

        case 'thumbnail':
            $value = msp_get_auto_post_thumbnail( $post, 'featured', 150, 150 );
            break;

        case 'thumbnailurl':
            $value = msp_get_auto_post_thumbnail_url( $post, 'auto', array(150, 150) );
            break;

		case 'year':
			$value = strtotime( $post->post_date );
			$value = date_i18n( 'Y', $value );
			break;

		case 'daynum':
			$value = strtotime( $post->post_date );
			$value = date_i18n( 'j', $value );
			break;

		case 'day':
			$value = strtotime( $post->post_date );
			$value = date_i18n( 'l', $value );
			break;

		case 'monthnum':
			$value = strtotime( $post->post_date );
			$value = date_i18n( 'm', $value );
			break;

		case 'month':
			$value = strtotime( $post->post_date );
			$value = date_i18n( 'F', $value );
			break;

		case 'time':
			$value = strtotime( $post->post_date );
			$value = date_i18n( 'g:i A', $value );
			break;

		case 'date-published':
			$value = mysql2date( get_option( 'date_format' ), $post->post_date );
			break;

		case 'date-modified':
			$value = mysql2date( get_option( 'date_format' ), $post->post_modified );
			break;

		case 'commentnum':
			$value = $post->comment_count;
			break;

		case 'wc_price':
			if ( ! msp_is_plugin_active( 'woocommerce/woocommerce.php' ) ) break;
			$value = '';
            if( $post ){
                $product = wc_get_product( $post );
                if( $product instanceof WC_Product ){
                    $value = wc_price( $product->get_price(), 2 );
                }
            }
			break;

		case 'wc_regular_price':
			if ( ! msp_is_plugin_active( 'woocommerce/woocommerce.php' ) ) break;
			$value = '';
            if( $post ){
                $product = wc_get_product( $post );
                if( $product instanceof WC_Product ){
                    $value = wc_price( $product->get_regular_price() );
                }
            }
			break;

		case 'wc_sale_price':
			if ( ! msp_is_plugin_active( 'woocommerce/woocommerce.php' ) ) break;
			$value = '';
            if( $post ){
                $product = wc_get_product( $post );
                if( $product instanceof WC_Product ){
                    $value = $product->get_sale_price() ? wc_price( $product->get_sale_price() ) : '';
                }
            }
            break;

		case 'wc_stock_status':
			if ( ! msp_is_plugin_active( 'woocommerce/woocommerce.php' ) ) break;
			$value = '';
            if( $post ){
                $product = wc_get_product( $post );
                if( $product instanceof WC_Product ){
                    $value = $product->is_in_stock() ? __( 'In Stock', MSWP_TEXT_DOMAIN ) : __( 'Out of Stock', MSWP_TEXT_DOMAIN );
                }
            }
			break;

		case 'wc_stock_quantity':
			if ( ! msp_is_plugin_active( 'woocommerce/woocommerce.php' ) ) break;
            $value = '';
            if( $post ){
                $product = wc_get_product( $post );
                if( $product instanceof WC_Product ){
                    $value = (int) $product->get_stock_quantity();
                }
            }
            break;

		case 'wc_weight':
			if ( ! msp_is_plugin_active( 'woocommerce/woocommerce.php' ) ) break;
			$value = '';
            if( $post ){
                $product = wc_get_product( $post );
                if( $product instanceof WC_Product ){
                    $value = $product->get_weight() ? wc_format_decimal( $product->get_weight(), 2 ) : '';
                }
            }
            break;

		case 'wc_product_cats':
			if ( ! msp_is_plugin_active( 'woocommerce/woocommerce.php' ) ) break;
			$value = '';
            if( $post ){
                $product = wc_get_product( $post );
                if( $product instanceof WC_Product ){
                    $value = wp_get_post_terms( $product->id, 'product_cat', array( 'fields' => 'names' ) );
                }
            }
            break;

		case 'wc_product_tags':
			if ( ! msp_is_plugin_active( 'woocommerce/woocommerce.php' ) ) break;
			$value = '';
            if( $post ){
                $product = wc_get_product( $post );
                if( $product instanceof WC_Product ){
                    $value = wp_get_post_terms( $product->id, 'product_tag', array( 'fields' => 'names' ) );
                }
            }
            break;

		case 'wc_total_sales':
			if ( ! msp_is_plugin_active( 'woocommerce/woocommerce.php' ) ) break;
			$value = '';
            if( $post ){
                $product = wc_get_product( $post );
                if( $product instanceof WC_Product ){
                    $value = metadata_exists( 'post', $product->id, 'total_sales' ) ? (int) get_post_meta( $product->id, 'total_sales', true ) : 0;
                }
            }
            break;

		case 'wc_average_rating':
			if ( ! msp_is_plugin_active( 'woocommerce/woocommerce.php' ) ) break;
			$value = '';
            if( $post ){
                $product = wc_get_product( $post );
                if( $product instanceof WC_Product ){
                    $value = wc_format_decimal( $product->get_average_rating(), 2 );
                }
            }
            break;

		case 'wc_rating_count':
			if ( ! msp_is_plugin_active( 'woocommerce/woocommerce.php' ) ) break;
			$value = '';
            if( $post ){
                $product = wc_get_product( $post );
                if( $product instanceof WC_Product ){
                    $value = (int) $product->get_rating_count();
                }
            }
            break;

        case 'wc_add_to_cart_link':
            if ( ! msp_is_plugin_active( 'woocommerce/woocommerce.php' ) ) break;
            $value = get_permalink( $post ) . '?add-to-cart=' . $post->ID;
            break;

        case 'wc_add_to_cart':
            if ( ! msp_is_plugin_active( 'woocommerce/woocommerce.php' ) ) break;
            $value = '';
            if( $post ){
                $product = wc_get_product( $post );
                if( $product instanceof WC_Product ){
                    $link    = get_permalink( $post ) . '?add-to-cart=' . $post->ID;
                    $label   = $product->add_to_cart_text();
                    $value   = sprintf( '<a href="%s">%s</a>', $link, $label );
                }
            }
            break;

		default:

            // if the tag is {{content-150}} with dynamic length
            if ( strpos( $tag_name, 'content-' ) !== false ) {

                preg_match( "/([\d]{1,})/", $tag_name, $matches );

                if( isset( $matches[0] ) && is_numeric( $matches[0] ) ){
                    $excerpt_length = (int) $matches[0];
                    $value = msp_get_the_trim_excerpt( $post->ID, $excerpt_length );
                    break;
                }

            // if the tag is {{wc_price-2}} with dynamic points length
            } elseif( strpos( $tag_name, 'title-' ) !== false ){
                preg_match( "/([\d]{1,})/", $tag_name, $matches );

                if( isset( $matches[0] ) && is_numeric( $matches[0] ) ){
                    $excerpt_length = (int) $matches[0];
                    $value = wp_trim_words( $post->post_title, $excerpt_length );
                    break;
                }
            } elseif( strpos( $tag_name, 'wc_price-' ) !== false ){

                if ( ! msp_is_plugin_active('woocommerce/woocommerce.php') ) break;

                preg_match( "/([\d]{1,})/", $tag_name, $matches );

                if( isset( $matches[0] ) && is_numeric( $matches[0] ) ){
                    $points_length = (int) $matches[0];
                    if( $post ){
                        $product = wc_get_product( $post );
                        if( $product instanceof WC_Product ){
                            $value = wc_price( $product->get_price(), array( 'decimals' => $points_length ) );
                        }
                    }
                    break;
                }

            // if the tag is {{thumbnail-150x150}} with dynamic dimensions
            } elseif( strpos( $tag_name, 'image-' ) !== false ){

                preg_match_all( "/([\d]{1,})/", $tag_name, $matches );

                if( isset( $matches[0] ) ){
                    $image_width  = isset( $matches[0][0] ) && is_numeric( $matches[0][0] ) ? (int) $matches[0][0] : null;
                    $image_height = isset( $matches[0][1] ) && is_numeric( $matches[0][1] ) ? (int) $matches[0][1] : null;

                    $value = msp_get_auto_post_thumbnail_url( $post, 'featured', array( $image_width, $image_height ), true );

                    if( ! empty( $value ) ){
                        $value = sprintf( '<img class="ms-custom-image" src="%s" alt="%s" />', $value, $post->post_title );
                    }
                    break;
                }

            // if the tag is {{thumbnail-150x150}} with dynamic dimensions
            } elseif( strpos( $tag_name, 'thumbnail-' ) !== false ){

                preg_match_all( "/([\d]{1,})/", $tag_name, $matches );

                if( isset( $matches[0] ) ){
                    $thumb_width  = isset( $matches[0][0] ) && is_numeric( $matches[0][0] ) ? (int) $matches[0][0] : null;
                    $thumb_height = isset( $matches[0][1] ) && is_numeric( $matches[0][1] ) ? (int) $matches[0][1] : null;

                    $value = msp_get_auto_post_thumbnail_url( $post, 'featured', array( $thumb_width, $thumb_height ), true );

                    if( ! empty( $value ) ){
                        $value = sprintf( '<img class="ms-dyna-thumb" src="%s" alt="%s" />', $value, $post->post_title );
                    }
                    break;
                }

            // if the tag is {{thumbnail-url-150x150}} with dynamic dimensions
            } elseif( strpos( $tag_name, 'thumbnailurl-' ) !== false ){

                preg_match_all( "/([\d]{1,})/", $tag_name, $matches );

                if( isset( $matches[0] ) ){
                    $thumb_width  = isset( $matches[0][0] ) && is_numeric( $matches[0][0] ) ? (int) $matches[0][0] : null;
                    $thumb_height = isset( $matches[0][1] ) && is_numeric( $matches[0][1] ) ? (int) $matches[0][1] : null;

                    $value = msp_get_auto_post_thumbnail_url( $post, 'featured', array( $thumb_width, $thumb_height ), true );
                    break;
                }

            }


            $value = get_post_meta(  $post->ID, $tag_name, true );
			break;
	}

	return apply_filters( 'masterslider_get_template_tag_value', $value, $tag_name, $post, $args );
}


function msp_maybe_base64_decode ( $data ) {
    $decoded_data = base64_decode( $data );
    return base64_encode( $decoded_data ) === $data ? $decoded_data : $data;
}


function msp_maybe_base64_encode ( $data ) {
    $encoded_data = base64_encode( $data );
    return base64_decode( $encoded_data ) === $data ? $encoded_data : $data;
}


function msp_escape_tag( $tag_name ){
    return tag_escape( $tag_name );
}


function msp_is_true($value) {
	return strtolower( $value ) === 'true' ? 'true' : 'false';
}


function msp_is_true_e( $value ) {
	echo msp_is_true( $value );
}


function msp_is_key_true( $array, $key, $default = 'true' ) {
    if( isset( $array[ $key ] ) ) {
        return $array[ $key ] ? 'true' : 'false';
    } else {
        return $default;
    }
}

function msp_make_html_attributes( $attrs = array() ){

    if( ! is_array( $attrs ) ){
        trigger_error( sprintf( __( 'Input value for "%s" function should be array.', MSWP_TEXT_DOMAIN ), __FUNCTION__ ) );
        return '';
    }

    $attributes_string = '';

    foreach ( $attrs as $attr => $value ) {
        $value = is_array( $value ) ? join( ' ', array_unique( $value ) ) : $value;
        if( is_null( $value ) ){
            continue;
        }
        $attributes_string .= sprintf( '%s="%s" ', $attr, esc_attr( trim( $value ) ) );
    }

    return $attributes_string;
}
