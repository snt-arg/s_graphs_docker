<?php

class RevsliderDiviModule extends ET_Builder_Module {

	public $slug       = 'revslider_divi';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => '',
		'author_uri' => '',
	);

	public function init() {
		$this->name = esc_html__( 'Slider Revolution', 'revslider' );
        $this->icon_path = plugin_dir_path( __FILE__ ) . 'images/rslogo.svg';
	}

    public function get_fields() {
        return array(
            'revslider_divi' => array(
                'label' => '',
                'type' => 'revslider_divi_input',
                'option_category' => 'basic_option',
                'description' => esc_html__('Select Revslider module among all the modules you have created.', 'revslider'),
                'toggle_slug' => 'revslider_divi',
            ),
        );
    }

    public function get_settings_modal_toggles() {
        return array(
            'general' => array(
                'toggles' => array(
                    'revslider_divi' => array(
                        'priority' => 0,
                        'title' => esc_html__( 'Slider Revolution', 'revslider' ),
                    ),
                ),
            ),
        );
    }

    public function get_advanced_fields_config() {
        return array(
            'main_content' => false,
            'link_options' => false,
            'background' => false,
            'borders' => false,
            'box_shadow' => false,
            'button' => false,
            'filters' => false,
            'fonts' => false,
            'margin_padding' => false,
            'max_width' => false,
        );
    }

	public function render( $attrs, $content = null, $render_slug ) {
        return do_shortcode( et_pb_fix_shortcodes( str_replace( array( '&#91;', '&#93;' ), array( '[', ']' ), $this->props['revslider_divi'] ), true ) );
	}
}

new RevsliderDiviModule;
