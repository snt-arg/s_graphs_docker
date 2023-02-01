<?php
/**
 * Shopping Cart Widget
 *
 * Displays shopping cart widget
 *
 * @author 		WooThemes
 * @category 	Widgets
 * @package 	WooCommerce/Widgets
 * @version 	2.0.1
 * @extends 	WC_Widget
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Be_Themes_WooCommerce_Widget_Cart extends WC_Widget_Cart {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget_shopping_cart';
		$this->widget_description = __( "Display the user's Cart in the sidebar.", 'oshin' );
		$this->widget_id          = 'woocommerce_widget_cart';
		$this->widget_name        = __( 'WooCommerce Cart', 'oshin' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => __( 'Cart', 'oshin' ),
				'label' => __( 'Title', 'oshin' )
			),
			'hide_if_empty' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Hide if cart is empty', 'oshin' )
			)
		);
		parent::__construct();
	}

	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	public function widget( $args, $instance ) {

		extract( $args );

		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Cart', 'oshin' ) : $instance['title'], $instance, $this->id_base );
		$hide_if_empty = empty( $instance['hide_if_empty'] ) ? 0 : 1;

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;

		if ( $hide_if_empty )
			echo '<div class="hide_cart_widget_if_empty">';

		// Insert cart widget placeholder - code in woocommerce.js will update this on page load
		echo '<div class="widget_shopping_cart_content"></div>';

		if ( $hide_if_empty )
			echo '</div>';

		echo $after_widget;
	}
}

register_widget( 'Be_Themes_WooCommerce_Widget_Cart' );