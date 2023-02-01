<?php
/*
    Plugin Name: Brankic Photostream Widget
    Plugin URI: http://www.brankic1979.com
    Description: Showing your photostream from Dribbble, Flickr, Pinterest, Instagram in the sidebar
    Author: Brankic1979
    Version: 1.3
    Author URI: http://www.brankic1979.com/
*/
class BraPhotostreamWidget extends WP_Widget {
	function __construct() {
		$widget_options = array(
            'classname'		=>		'bra-photostream-widget',
            'description' 	=>		'Showing photostream from Dribbble, Flickr, Pinterest or Instagram in your sidebar'
		);
		parent::__construct('bra_photostream_widget', 'Brankic Photostream Widget', $widget_options);
	}
	function widget( $args, $instance ) {
		extract ( $args, EXTR_SKIP );
        if (!isset($instance['title'])) $instance['title'] = __('Your Photostream','oshin'); 
        if (!isset($instance['social_network'])) $instance['social_network'] = "";  
        if (!isset($instance['user'])) $instance['user'] = "";  
        if (!isset($instance['limit'])) $instance['limit'] = ""; 
        if (!isset($instance['hover_color'])) $instance['hover_color'] = "#ffffff";   
        $root = plugin_dir_url( __FILE__ );
        $title = ( $instance['title'] ) ? $instance['title'] : __('Your Photostream','oshin');
		$user = ( $instance['user'] ) ? $instance['user'] : 'brankic1979';
        $social_network = ( $instance['social_network'] ) ? $instance['social_network'] : 'instagram'; 
        $limit = ( $instance['limit'] ) ? $instance['limit'] : '9';
        $hover_color = ( $instance['hover_color'] ) ? $instance['hover_color'] : '#ffffff';
		echo $before_widget;
		echo $before_title . $title . $after_title;
        
        $unique_id =  $user . $social_network . $limit ;
        $unique_id = preg_replace("/[^A-Za-z0-9]/", '', $unique_id);
        $source = array (
            'source' => $social_network,
            'account_name' => $user, 
            'count' => $limit,
            'col' => 'three',
            'masonry' => 0
        );
        $images = get_gallery_image_from_source($source,false,'');
        $html = '<div class="photostream clearfix" id="' . $unique_id  .'" data-user="'.$user.'" data-limit="'.$limit.'" data-social-media="'.$social_network.'">';
        $html .= '<ul class="clearfix">';
        $count = 1;
        if( !empty($images['error']) && $images['error'] != '' ){
            $html .= $images['error']; 
        }else{
            if( !empty($images) && is_array($images) ) {
                foreach ($images as $key => $image) {
                    if(($count % 3) == 0) {
                        $class = 'last';
                    } else {
                        $class = '';
                    }
                    $html .= '<li class="'.$class.'">';
                    $html .= '<a href="'.$image['full_image_url'].'" data-href="'.$image['full_image_url'].'" class="thumb-wrap image-popup-vertical-fit '.$image['mfp_class'].'" title="'.$image['caption'].'">';
                    $html .= '<img src="'.$image['thumbnail'].'" alt />';
                    $html .= '</a>';
                    $html .= '</li>';
                    $count++;
                }
            }
        }
        $html .= '</ul>';
        $html .= '</div>';
        echo $html;
		echo $after_widget;
	}        	
	function form( $instance ) {   
        $root = plugin_dir_url( __FILE__ );
        //wp_enqueue_script("miniColors", get_template_directory_uri()."/functions/widgets/brankic-photostream-widget/jquery.miniColors.min.js", array('jquery'));
        //wp_enqueue_style("miniColors", get_template_directory_uri()."/functions/widgets/brankic-photostream-widget/jquery.miniColors.css");
        if (!isset($instance['title'])) $instance['title'] = __('Your Photostream','oshin');  
        if (!isset($instance['user'])) $instance['user'] = "oshine_be";  
        if (!isset($instance['limit'])) $instance['limit'] = "6";  
        if (!isset($instance['social_network'])) $instance['social_network'] = "instagram"; ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                Title: 
                <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" type="text"/>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('user'); ?>">
                Photostream user: 
                <input id="<?php echo $this->get_field_id('user'); ?>" name="<?php echo $this->get_field_name('user'); ?>" value="<?php echo esc_attr( $instance['user'] ); ?>" class="widefat" type="text"/>
            </label>
		</p>
        <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>">
                No of pics displayed: 
                <input id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" value="<?php echo esc_attr( $instance['limit'] ); ?>" class="" size="1"/>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('social_network'); ?>">
                Social Network 
                <select name="<?php echo $this->get_field_name('social_network'); ?>" id="<?php echo $this->get_field_id('social_network'); ?>" class="">
                    <option value="dribbble" <?php if ($instance['social_network'] == "dribbble") echo 'selected="selected"' ?>>Dribbble</option>
                    <option value="pintrest" <?php if ($instance['social_network'] == "pintrest") echo 'selected="selected"' ?>>Pintrest</option>
                    <option value="flickr" <?php if ($instance['social_network'] == "flickr") echo 'selected="selected"' ?>>Flickr</option>
                    <option value="instagram" <?php if ($instance['social_network'] == "instagram") echo 'selected="selected"' ?>>Instagram</option>
                </select>
            </label>
        </p> <?php 
	}
	
}
if ( ! function_exists( 'bra_photostream_widget_init' ) ) {
    function bra_photostream_widget_init() {
	   register_widget("BraPhotostreamWidget");
    }
    add_action('widgets_init','bra_photostream_widget_init');
}