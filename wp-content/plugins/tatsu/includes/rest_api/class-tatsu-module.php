<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Module {

	private $atts;
	private $content;
	private $tag;
	private $type;
	private $module;
	private $shortcode;

	public function __construct( $tag = '', $atts = array(), $content = '' ) {
		$this->tag = $tag;
		$this->atts = $atts;
		$this->content = $content;
		$this->module = array();
		$this->type = 'single';
	}	

	public function do_shortcode() { 
 
			$shortcode = $this->get_shortcode();

			$shortcode = apply_filters('tatsu_before_do_shortcode', $shortcode );
			
			$output = apply_filters( 'tatsu_'.$this->tag.'_shortcode_output_filter', do_shortcode( $shortcode ) , $this->tag, $this->atts, $this->content );

			// Lazy Fix. Change oshine modules to use this filter.
			$content_filter = ( 'contact_form' !== $this->tag && 'oshine_newsletter' !== $this->tag ) ? true : false;
			$content_filter = apply_filters( 'tatsu_shortcode_output_content_filter', $content_filter, $this->tag );
			if( $content_filter ) {
				$output = apply_filters('the_content', $output );
			}

		return $output;
	}

	/* Callback for a REST Request */

	public function get_module_shorcode_output( WP_REST_Request $request ) {
		$parameters = json_decode(  $request->get_param('module'), true );

		// TODO - validate if shortcode exists & later after parsing, check if module is registered with Tatsu
		$this->tag = $parameters['name'];
		$this->atts = $parameters['atts'];
		if( array_key_exists( 'content', $parameters['atts'] ) ) {
			$this->content = $parameters['atts']['content'];
		}
		$this->type = $parameters['type'];
		$this->module = array( $parameters );
		return $this->do_shortcode();
	}


	/* Callback for a Admin Ajax Request */

	public function ajax_get_module_shorcode_output() {

		if( !array_key_exists( 'nonce', $_POST ) || !wp_verify_nonce( $_POST['nonce'], 'wp_rest' ) ) {
			return false;
		}

		$parameters = json_decode( stripslashes( $_POST['module'] ) , true );


		// TODO - validate if shortcode exists & later after parsing, check if module is registered with Tatsu
		$this->tag = $parameters['name'];
		$this->atts = $parameters['atts'];
		if( array_key_exists( 'content', $parameters['atts'] ) ) {
			$this->content = $parameters['atts']['content'];
		}
		$this->type = $parameters['type'];
		$this->module = array( $parameters );
		echo $this->do_shortcode();
		die();
	}


	public function get_shortcode() {
		if( 'multi' == $this->type ) {
			return tatsu_shortcodes_from_content( $this->module );
		} else {
			$this->shortcode = '['.$this->tag;
			if( is_array( $this->atts) ) {
				foreach ($this->atts as $att => $value) {
					if( 'content' !== $att ) {
						if( is_array( $value ) ) {
							foreach( $value as $device => $val ) {
								if( null === $val ) {
									unset( $value[$device] );
								}
							}
							$value = json_encode( $value );
							$this->shortcode .= " ".$att."= '".$value."'";
						}
						else {
							$this->shortcode .= ' '.$att.'= "'.$value.'"';
						}
					}
				}
			}
			$this->shortcode .= ']'.shortcode_unautop( stripslashes_deep( $this->content ) ).'[/'.$this->tag.']';
			return $this->shortcode;
		}
	}

}