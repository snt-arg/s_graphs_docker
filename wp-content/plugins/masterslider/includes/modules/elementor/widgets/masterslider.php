<?php
namespace MasterSlider\Modules\Elementor\Elements;

use Elementor\Plugin;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Group_Control_Border;


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor 'MasterSlider' widget.
 *
 * Elementor widget that displays an 'MasterSlider' with lightbox.
 *
 * @since 1.0.0
 */
class MasterSlider extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve 'MasterSlider' widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'aux_masterslider';
    }

    /**
     * Get widget title.
     *
     * Retrieve 'MasterSlider' widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Master Slider', MSWP_TEXT_DOMAIN );
    }

    /**
     * Get widget icon.
     *
     * Retrieve 'MasterSlider' widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-slider-device auxin-badge';
    }

    /**
     * Get forms list.
     *
     * Retrieve 'MasterSlider' widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_forms() {
        $options = array( '0' => __( 'Select slider', MSWP_TEXT_DOMAIN ) ) ;

        $masterslider_names = get_masterslider_names( 'alias' );

        foreach ( $masterslider_names as $alias => $title ) {
            $title = empty( $alias ) ? $title .' '. __('(slider alias is not defined)', MSWP_TEXT_DOMAIN ) : $title;
            $options[ $alias ] = $title;
         }

        return $options;
    }

    /**
     * Get widget categories.
     *
     * Retrieve 'MasterSlider' widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_categories() {
        $categories = Plugin::$instance->elements_manager->get_categories();
        $category_to_append_to = ! empty( $categories['auxin-core'] ) ? 'auxin-core' : 'general';

        return array( $category_to_append_to );
    }

    /**
     * Register 'MasterSlider' widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {

        $this->start_controls_section(
            'sliders_section',
            array(
                'label' => __('Slider', MSWP_TEXT_DOMAIN )
            )
        );

        $this->add_control(
            'alias',
            array(
                'label'       => __( 'Master Slider', MSWP_TEXT_DOMAIN ),
                'label_block' => true,
                'type'        => Controls_Manager::SELECT,
                'options'     => $this->get_forms(),
                'default'     => 0,
            )
        );

        $this->end_controls_section();
    }

   /**
    * Render MasterSlider widget output on the frontend.
    *
    * Written in PHP and used to generate the final HTML.
    *
    * @since 1.0.0
    * @access protected
    */
    protected function render() {
        $settings = $this->get_settings_for_display();
        echo get_masterslider( $settings['alias'] );
    }

}
