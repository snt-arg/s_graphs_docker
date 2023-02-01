<?php
if( !function_exists( 'tatsu_standalone_register_modules' ) && !class_exists('Tatsu_Pro')) {
    if( !function_exists( 'tatsu_moduless_output' )) {
        function tatsu_moduless_output( $atts, $content, $tag ) {
           return tatsu_pro_ouput();
        }
    }
    add_action( 'tatsu_register_modules', 'tatsu_standalone_register_modules' );
    function tatsu_standalone_register_modules() {
        $controls = array (
            'is_tatsu_pro'=>true,
            'is_js_dependant' => false,
            'type' => 'single',
            'is_built_in' => false,
            'group_atts' => array (),
            'atts' => array(),
        );
        $pro_modules = array();
        $themeName = be_theme_name();
        //not for oshin theme
        if('oshin'!=$themeName){
            $standalone_svg_url = TATSU_PLUGIN_URL . '/builder/svg/oshin-modules.svg';
            $pro_modules = array(
                'animate_icons_style1'=>array('icon' => $standalone_svg_url.'#animated_module',
                'title' => __( 'Fixed Height Animated Module PRO', 'tatsu' )),
                'animate_icon_style2'=>array('icon' => $standalone_svg_url.'#animated_module',
                'title' => __( 'Variable Height Animated Module PRO', 'tatsu' )),
                'chart'=>array('icon' => $standalone_svg_url.'#chart',
                'title' => __( 'Animated Charts PRO', 'tatsu' )),
                'be_slider'=>array('icon' => $standalone_svg_url.'#be_slider',
                'title' => __( 'BE Slider PRO', 'tatsu' )),
                'clients'=>array('icon' => $standalone_svg_url.'#clients',
                'title' => __( 'Clients PRO', 'tatsu' )),
                'content_slider'=>array('icon' => $standalone_svg_url.'#content_slider',
                'title' => __( 'Content Slider PRO', 'tatsu' )),
                'image_slider'=>array('icon' => $standalone_svg_url.'#image_slider',
                'title' => __( 'Image Slider PRO', 'tatsu' )),
                'special_heading'=>array('icon' => $standalone_svg_url.'#special_heading',
                'title' => __( 'Special Title - Style 1 PRO', 'tatsu' )),
                'special_heading2'=>array('icon' => $standalone_svg_url.'#special_heading2',
                'title' => __( 'Special Title - Style 2 PRO', 'tatsu' )),
                'special_heading3'=>array('icon' => $standalone_svg_url.'#special_heading3',
                'title' => __( 'Special Title - Style 3 PRO', 'tatsu' )),
                'special_heading4'=>array('icon' => $standalone_svg_url.'#special_heading4',
                'title' => __( 'Special Title - Style 4 PRO', 'tatsu' )),
                'special_heading5'=>array('icon' => $standalone_svg_url.'#special_heading5',
                'title' => __( 'Special Title - Style 5 PRO', 'tatsu' )),
                'special_subtitle'=>array('icon' => $standalone_svg_url.'#special_subtitle',
                'title' => __( 'Sub Title Module PRO', 'tatsu' )),
                
            );
        }
        //not for spyro theme
        if('spyro'!=$themeName){
            $standalone_svg_url = TATSU_PLUGIN_URL . '/builder/svg/modules.svg';
            $pro_modules = array_merge($pro_modules,array(
                'tabs'=>array('icon' => $standalone_svg_url.'#tabs',
                'title' => __( 'Advance Tabs PRO', 'tatsu' )),
                'fancy_tabs'=>array('icon' => $standalone_svg_url.'#tabs',
                'title' => __( 'Fancy Tabs PRO', 'tatsu' )),
                'tatsu_forms'=>array('icon' => $standalone_svg_url.'#text',
                'title' => __( 'Tatsu forms PRO', 'tatsu' ),
                'preview_image'=>TATSU_PLUGIN_URL . '/builder/img/modules/tatsu-forms.png',
                'description'=>'Create beautiful forms with powerful Tatsu Forms. Integrate mailchimp, recaptcha v2 & v3, email to admin, auto responder, form enteries storage and much more'),
                'image_before_after'=>array('icon' => $standalone_svg_url.'#image',
                'title' => __( 'Image Before After Effect PRO', 'tatsu' )),
                'packages'=>array('icon' => $standalone_svg_url.'#tabs',
                'title' => __( 'Packages PRO', 'tatsu' )),
                'price_switch'=>array('icon' => $standalone_svg_url.'#tabs',
                'title' => __( 'Price Switch PRO', 'tatsu' )),
                'price'=>array('icon' => $standalone_svg_url.'#tabs',
                'title' => __( 'Price PRO', 'tatsu' ))
            ));
        }
        

        
        if(!empty($pro_modules)){
            foreach ($pro_modules as $module_name => $module_control) {
                add_shortcode( 'tatsu_standalone_'.$module_name, 'tatsu_moduless_output' );
                tatsu_register_module( 'tatsu_standalone_'.$module_name,array_merge($module_control, $controls));
            }
        }
    }
}
