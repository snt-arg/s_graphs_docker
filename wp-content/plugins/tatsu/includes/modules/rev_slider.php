<?php
if( !function_exists( 'tatsu_rev_slider' ) ) {
    function tatsu_rev_slider( $atts, $content ) {
        $atts = shortcode_atts( array(
            'rev_slider_alias' => '',
            'key'  => be_uniqid_base36(true),
        ), $atts );
        extract( $atts );

        $custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_rev_slider', $atts['key'] );
        $custom_class_name = ' tatsu-'.$atts['key'];
        $shortcode_str = sprintf( '[rev_slider alias = "%s"]', $rev_slider_alias );
        ob_start();
?>
            <div class = "tatsu-rev-slider-wrap tatsu-module <?php echo $custom_class_name; ?>">
                <?php echo do_shortcode( $shortcode_str ); ?>
            </div>
<?php
        return ob_get_clean();
    }
}


if( !function_exists( 'tatsu_rev_slider_output_filter' ) ) {
    add_filter( 'tatsu_tatsu_rev_slider_shortcode_output_filter', 'tatsu_rev_slider_output_filter', 10, 3 );
    function tatsu_rev_slider_output_filter($content, $tag, $atts ) {
        $output = sprintf( '<div class="tatsu-module tatsu-notification tatsu-rev-slider-placeholder tatsu-error">Slider Revolution Module - %s - Preview Not Available, Please check the output in the front end</div>', array_key_exists( 'rev_slider_alias', $atts ) ? $atts[ 'rev_slider_alias' ] : '' );
        return $output;
    }
}

if (!function_exists('tatsu_register_rev_slider')) {
	add_action('tatsu_register_modules', 'tatsu_register_rev_slider');
	function tatsu_register_rev_slider()
	{
		if (class_exists('RevSlider')) {
			global $wpdb;
			$query = sprintf('select alias, title from %srevslider_sliders r', $wpdb->prefix);
			$sliders = $wpdb->get_results($query);
			$sliders_option = array();
			if (is_array($sliders)) {
				foreach ($sliders as $slider) {
					if (is_object($slider)) {
						$sliders_option[$slider->alias] = $slider->title;
					}
				}
			}
			$controls = array(
				'icon' => '',
				'title' => esc_html__('Slider Revolution', 'tatsu'),
				'is_js_dependant' => false,
				'type' => 'single',
				'is_built_in' => false,
				'atts' => array(
					array(
						'att_name' => 'rev_slider_alias',
						'type' => 'select',
						'label' => esc_html__('Slider Name', 'tatsu'),
						'options' => $sliders_option,
						'tooltip'	=> '',
					),
				)
			);
			tatsu_register_module('tatsu_rev_slider', $controls, 'tatsu_rev_slider');
		}
	}
}