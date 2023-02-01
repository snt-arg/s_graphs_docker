<?php
// Change linebreak to tatsu_empty_space in parser
if (!function_exists('tatsu_empty_space')) {
	function tatsu_empty_space( $atts, $content, $tag) {
		$atts = shortcode_atts( array(
			'height'=>'50',
			'css_classes' => '',
			'key' => be_uniqid_base36(true),
	    ),$atts, $tag);

		extract($atts);

		$custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'] );
		$custom_class_name = 'tatsu-'.$atts['key'];
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 

	    $class = '';
		//Handle Resposive Visibility controls
		if( !empty( $hide_in ) ) {
			$hide_in = explode(',', $hide_in);
			foreach ( $hide_in as $device ) {
				$class .= ' tatsu-hide-'.$device;
			}
		}	
		$output = '';
		$output .= '<div '.$css_id.' class="tatsu-empty-space '.$class." ". $custom_class_name .' '. $visibility_classes.' " >'.$custom_style_tag.'</div>';
		return $output;
	}
	add_shortcode( 'tatsu_empty_space', 'tatsu_empty_space' );
	add_shortcode( 'linebreak', 'tatsu_empty_space' );
}

add_action('tatsu_register_modules', 'tatsu_register_empty_space', 9);
function tatsu_register_empty_space()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#empty_space',
		'title' => esc_html__('Extra Spacing', 'tatsu'),
		'is_js_dependant' => false,
		'type' => 'single',
		'is_built_in' => true,
		'drag_handle' => true,
		'atts' => array(
			array(
				'att_name' => 'height',
				'type' => 'number',
				'label' => esc_html__('Height', 'tatsu'),
				'options' => array(
					'unit' => 'px',
				),
				'default' => '',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}.tatsu-empty-space' => array(
						'property' => 'height',
						'append' => 'px'
					),
				),
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'height' => '30'
				),
			)
		),
	);
	tatsu_remap_modules(array('tatsu_empty_space', 'linebreak'), $controls, 'tatsu_empty_space');
}

?>