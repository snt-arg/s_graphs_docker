<?php
/**
 * called from revslider-front.class.php
 * @since: 6.1.6
 */

if(!defined('ABSPATH')) exit();

class RevSliderWpbakeryShortcode {

    public static function visual_composer_include(){

        // VC is enabled
        if(defined('WPB_VC_VERSION') && function_exists('vc_map')){
            vc_map(
                array(
                    'name' => __('Slider Revolution 6', 'revslider'),
                    'base' => 'rev_slider',
                    'icon' => 'icon-wpb-revslider',
                    'category' => __('Content', 'revslider'),
                    'show_settings_on_create' => false,
                    'js_view' => 'VcSliderRevolution',
                    'admin_enqueue_js' => RS_PLUGIN_URL.'admin/assets/js/shortcode_generator/vc.js',
                    'front_enqueue_js' => RS_PLUGIN_URL.'admin/assets/js/shortcode_generator/vc.js',
                    'params' => array(
                        array(
                            'type' => 'rev_slider_shortcode',
                            'heading' => __('Modal', 'revslider'),
                            'param_name' => 'modal',
                            'admin_label' => false,
                            'value' => ''
                        ),
                        array(
                            'type' => 'rev_slider_shortcode',
                            'heading' => __('Popup', 'revslider'),
                            'param_name' => 'popup',
                            'admin_label' => false,
                            'value' => ''
                        ),
                        array(
                            'type' => 'rev_slider_shortcode',
                            'heading' => __('Title', 'revslider'),
                            'param_name' => 'slidertitle',
                            'admin_label' => true,
                            'value' => ''
                        ),
                        array(
                            'type' => 'rev_slider_shortcode',
                            'heading' => __('Alias', 'revslider'),
                            'param_name' => 'alias',
                            'admin_label' => true,
                            'value' => ''
                        ),
                        array(
                            'type' => 'rev_slider_shortcode',
                            'heading' => __('Offset', 'revslider'),
                            'param_name' => 'offset',
                            'admin_label' => false,
                            'value' => ''
                        ),
                        array(
                            'type' => 'rev_slider_shortcode',
                            'heading' => __('Layout', 'revslider'),
                            'param_name' => 'layout',
                            'admin_label' => false,
                            'value' => ''
                        ),
                        array(
                            'type' => 'rev_slider_shortcode',
                            'heading' => __('z-Index', 'revslider'),
                            'param_name' => 'zindex',
                            'admin_label' => false,
                            'value' => ''
                        ),
                        array(
                            'type' => 'rev_slider_shortcode',
                            'heading' => __('Usage', 'revslider'),
                            'param_name' => 'usage',
                            'admin_label' => false,
                            'value' => ''
                        ),
                    )
                )
            );
        }
    }
}