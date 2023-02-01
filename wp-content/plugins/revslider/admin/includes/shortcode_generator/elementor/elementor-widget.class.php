<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();

class RevSliderElementorWidget extends \Elementor\Widget_Shortcode {

	public function get_name() {
		
		return 'slider_revolution';
		
	}

	public function get_title() {
		
		return 'Slider Revolution 6';
		
	}

	public function get_icon() {
		
		return 'eicon-sync';
		
	}

	public function get_categories() {
		
		return array('general');
		
	}

	public function rs_register_controls() {
		
		/*Fallback
		$shortcode = $this->get_settings_for_display( 'text' );
		if(empty($shortcode)) $shortcode = $this->get_settings_for_display( 'shortcode' ); 

		$revslidertitle = $this->get_settings_for_display( 'sliderTitle' );
		if(empty($revslidertitle)) $revslidertitle = $this->get_settings_for_display( 'revslidertitle' ); 

		var_dump($revslidertitle);
		*/

		$this->start_controls_section(
			'content_section',
			array(
				'label' => 'Slider Revolution 6',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		
		$this->add_control(
			'revslidertitle',
			array(
				'label' => __( 'Selected Module:', 'revslider' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'render_type' => 'none',
				'placeholder' => '',
				'default' => '',
				'event' => 'themepunch.selectslider',
			)
		);
		
		$this->add_control(
			'shortcode',
			array(
				//'type' => \Elementor\Controls_Manager::HIDDEN,
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => __( 'Shortcode', 'revslider' ),
				'dynamic' => ['active' => true],
				'placeholder' => '',
				'default' => '',
			)
		);

		$this->add_control(
			'wrapperid',
			array(
				//'type' => \Elementor\Controls_Manager::HIDDEN,
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => __( 'Wrapper ID', 'revslider' ),
				//'dynamic' => ['active' => true],
				'placeholder' => '',
				'default' => '',
			)
		);

		// Advanced 		
		$this->add_control(
			'select_slider',
			array(
				'type' => \Elementor\Controls_Manager::BUTTON,
				'button_type' => 'default',
				'text' => __( '<i type="button" class="material-icons">cached</i> Select Module', 'revslider' ),
				'event' => 'themepunch.selectslider',
			)
		);
		
		$this->add_control(
			'edit_slider',
			array(
				'type' => \Elementor\Controls_Manager::BUTTON,
				'button_type' => 'default',
				'text' => __( '<i type="button" class="material-icons">edit</i> Edit Module', 'revslider' ),
				'event' => 'themepunch.editslider',
			)
		);

		$this->add_control(
			'settings_slider',
			array(
				'type' => \Elementor\Controls_Manager::BUTTON,
				'button_type' => 'default',
				'text' => __( '<i type="button" class="material-icons">tune</i> Block Settings', 'revslider' ),
				'event' => 'themepunch.settingsslider',
			)
		);

		$this->add_control(
			'optimize_slider',
			array(
				'type' => \Elementor\Controls_Manager::BUTTON,
				'button_type' => 'default',
				'text' => __( '<i type="button" class="material-icons">flash_on</i> Optimize File Sizes', 'revslider' ),
				'event' => 'themepunch.optimizeslider',
			)
		);
		$this->end_controls_section();	
	}

	protected function register_controls() {
		$this->rs_register_controls();
	}

	protected function render() {
		global $rs_loaded_by_editor;
		
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) $rs_loaded_by_editor = true;

		$shortcode = $this->get_settings_for_display( 'shortcode' );
		$wrapperid = $this->get_settings_for_display( 'wrapperid' );
		$wrapperid = empty($wrapperid) ? '': 'id="' . $wrapperid . '" ';
		$shortcode = do_shortcode( shortcode_unautop( $shortcode ) );

		$zindex = $this->get_settings_for_display( 'zindex' );
		$style = $zindex ? ' style="z-index:'.$zindex.';"' : '';

		// hack to make sure object library only opens when the user manually adds a slider to the page
		if(empty($shortcode)) {
		?>
		<script>window.parent.elementorSelectRevSlider();</script>
		<?php
		}
		?>

		<div <?php echo $wrapperid; ?>class="wp-block-themepunch-revslider"<?php echo $style;?>><?php echo $shortcode; ?></div>

		<?php

		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) $rs_loaded_by_editor = false;
	}
	
}

/**
 * function _register_controls() is deprecated since 3.1.0 of Elementor
 **/
class RevSliderElementorWidgetPre310 extends RevSliderElementorWidget {
	protected function _register_controls() {
		$this->rs_register_controls();
	}
}
