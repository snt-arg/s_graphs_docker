<?php
/**
 *
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


if ( ! class_exists( 'MSP_Main_Widget' ) ) :


class MSP_Main_Widget extends MSP_Widget {

	public $fields   = array(

                            array(
                                'name'    => 'Title',
                                'id'      => 'title',
                                'type'    => 'textbox',
                                'value'   => ''
                            ),
                            array(
                                'name'    => 'Select a Slider :',
                                'id'      => 'id',
                                'type'    => 'select',
                                'value'   => '-1',
                                'options' => array()
                            )

                        );

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * Specifies the classname and description, instantiates the widget,
	 */
	public function __construct() {

		$this->fields['1']['options'] = get_masterslider_names();

		parent::__construct(
			'master-slider-main-widget',
			__( 'Master Slider Widget', MSWP_TEXT_DOMAIN ),
			array(
				'classname'  => 'master-slider-main-widget',
				'description' => __( 'Display a Master Slider', MSWP_TEXT_DOMAIN )
			)
		);

	} // end constructor

	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/

	/**
	 * Outputs the content of the widget on front-end.
	 *
	 * @param array args  The array of form elements
	 * @param array instance The current instance of the widget
	 */
	public function widget( $args, $instance ) {

		extract( $args, EXTR_SKIP );

		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;

		if ( ! empty( $title ) ) { echo $before_title . esc_html( $title ) . $after_title; }

		echo get_masterslider( $instance['id'] );

		echo $after_widget;
	} // end widget


} // end class


endif;

/**
 * Register the main widget
 *
 * @return void
 */
function ms_register_main_widget(){
    register_widget("MSP_Main_Widget");
}

// init the widget
add_action( 'widgets_init', 'ms_register_main_widget' );
