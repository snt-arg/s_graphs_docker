<?php
if ( ! function_exists( 'tatsu_gmaps' ) ) {
	function tatsu_gmaps( $atts, $content, $tag ) {
		$atts =  shortcode_atts( array(
			'address'=>'',
			'latitude'=>'',
			'longitude'=>'',
			'height'=>'300',
			'zoom'=>'14',
			'style'=>'default',
			'marker' => '',
			'animate'=>0,
			'animation_type'=>'none',
			'key' => be_uniqid_base36(true),
		), $atts, $tag  );

		extract( $atts );
		$custom_style_tag = be_generate_css_from_atts( $atts, 'tatsu_gmaps', $atts['key'] );
		$unique_class_name = 'tatsu-'.$atts['key'];
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts );
		$animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? 'tatsu-animate' : '' ; 
		$data_animations = be_get_animation_data_atts( $atts );
		$output = '';
		
		$address = tatsu_parse_custom_fields( $address );
		$latitude = tatsu_parse_custom_fields( $latitude );
		$longitude = tatsu_parse_custom_fields( $longitude );
		
		$maps_api_key = Tatsu_Config::getInstance()->get_google_maps_api_key();
		if( !empty( $maps_api_key ) ) {
			if(!empty($latitude) && !empty($longitude)) {
				$map_error = false;
			} 
			else if( ! empty( $address ) ) {
				$map_error = false;
				$transient_var = be_generate_slug($address, 10);
				$transient_result = get_transient( $transient_var );
				if(!$transient_result ) {
					$response = wp_remote_get('https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) );
					if ( is_wp_error( $response ) ) {
						$map_error = true;
						delete_transient( $transient_var );
					} else {
						$coordinates = wp_remote_retrieve_body( $response );
						if ( is_wp_error( $coordinates ) ) {
							$map_error = true;
							delete_transient( $transient_var );
						} else {
							$coordinates_check = json_decode($coordinates);
							if( $coordinates_check->status == 'OK' ) {					
								$latitude = $coordinates_check->results[0]->geometry->location->lat;
								$longitude = $coordinates_check->results[0]->geometry->location->lng;
								set_transient( $transient_var, $coordinates, 24 * HOUR_IN_SECONDS );
								
							} else {
								$map_error = true;
								delete_transient( $transient_var );
							}
						}
					}
				} else {
					$coordinates_check = json_decode($transient_result);
					$latitude = $coordinates_check->results[0]->geometry->location->lat;
					$longitude = $coordinates_check->results[0]->geometry->location->lng;
				}
				
			} else {
				$map_error = true;
			}

			if(  true === $map_error ) {
				$output .= '<div '.$css_id.' class="tatsu-module tatsu-notification tatsu-error '.$unique_class_name.'">'.__('Your Server is Unable to connect to the Google Geocoding API, kindly visit <a href="http://www.latlong.net/convert-address-to-lat-long.html" target="_blank">THIS LINK </a>, find out the latitude and longitude of your address and enter it manually in the Google Maps Module of the Page Builder ', 'tatsu').$custom_style_tag.'</div>';
			} else {
				if( !function_exists( 'be_gdpr_privacy_ok' ) ){
					$output .= '<div '.$css_id.' class="tatsu-module tatsu-gmap-wrapper be-gdpr-consent-required '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.' '.$animate.'" data-gdpr-concern="gmaps" '.$data_animations.'><div class="tatsu-gmap map_960" data-address="'.$address.'" data-zoom="'.$zoom.'" data-latitude="'.$latitude.'" data-longitude="'.$longitude.'" data-marker="'.$marker.'" data-style="'.$style.'"></div>'.$custom_style_tag.'</div>';

				}else{
					$static_map_api_url = 'https://maps.googleapis.com/maps/api/staticmap?markers=size:mid%7C'.$latitude.','.$longitude.'&zoom=13&size=600x300&apikey='.$maps_api_key;

					if( !empty($_COOKIE) ){

						if( !be_gdpr_privacy_ok('gmaps')  ){
							$classes = array( $animate, $unique_class_name, $css_classes );
							$output .= be_gdpr_maps_alt_content( $static_map_api_url, $classes, $data_animations, $custom_style_tag );

						} else {
							$output .= '<div '.$css_id.' class="tatsu-module tatsu-gmap-wrapper '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.' '.$animate.'" '.$data_animations.'><div class="tatsu-gmap map_960" data-address="'.$address.'"  data-zoom="'.$zoom.'" data-latitude="'.$latitude.'" data-longitude="'.$longitude.'" data-marker="'.$marker.'" data-style="'.$style.'"></div>'.$custom_style_tag.'</div>';
						}
					}else{
						$output .= '<div '.$css_id.' class="tatsu-module tatsu-gmap-wrapper be-gdpr-consent-replace '.$unique_class_name.' '.$visibility_classes.' '.$css_classes.' '.$animate.'" data-gdpr-concern="gmaps" '.$data_animations.'><div class="tatsu-gmap map_960" data-address="'.$address.'"  data-zoom="'.$zoom.'" data-latitude="'.$latitude.'" data-longitude="'.$longitude.'" data-marker="'.$marker.'" data-style="'.$style.'"></div>'.$custom_style_tag.'</div>';

						$classes = array( $animate, $unique_class_name, $css_classes );
						$output .= be_gdpr_maps_alt_content( $static_map_api_url, $classes, $data_animations, $custom_style_tag );

					}
				}
			}
		} else {
			$output = '<div '.$css_id.' class="tatsu-module tatsu-notification tatsu-error '.$unique_class_name.'">'.esc_html__( 'Google Maps API KEY is missing', 'tatsu' ).$custom_style_tag.'</div>';
		}
		return $output;
	}
	add_shortcode( 'tatsu_gmaps', 'tatsu_gmaps' );
}

if( !function_exists( 'be_gdpr_maps_alt_content' ) ){
	function be_gdpr_maps_alt_content( $static_map_api_url, $classes, $data_animations, $custom_style_tag ){
		$result = '';
		$response = wp_remote_get( $static_map_api_url ,
						array( 'timeout' => 10,
						'headers' => array( 'Content-Type' => 'image/png') 
						));

		if( !is_wp_error( $response ) ){
			$result .= '<div class="tatsu-module tatsu-gmap-wrapper be-gdpr-consent-message '. join(' ',$classes) .' " '.$data_animations.' style="background-position:center;background-size:cover;background-image:url(data:image/png;base64,'.base64_encode( $response['body']).');" >  
			'.$custom_style_tag.'
			<div class="static-map-overlay">
			<div class="static-map-content">' . do_shortcode( str_replace('[be_gdpr_api_name]','[be_gdpr_api_name api="google maps"]', get_option( 'be_gdpr_text_on_overlay', 'Your consent is required to display this content from [be_gdpr_api_name] - [be_gdpr_privacy_popup] ' ))) .'</div>
			</div>
			</div>';
		} else {
			$result .= do_shortcode( str_replace( '[be_gdpr_api_name]','[be_gdpr_api_name api="google maps"]', get_option( 'be_gdpr_text_on_overlay', 'Your consent is required to display this content from [be_gdpr_api_name] - [be_gdpr_privacy_popup] ' ) ) );
		}
		return $result;
	}
}

add_action('tatsu_register_modules', 'tatsu_register_gmaps', 6);
function tatsu_register_gmaps()
{
	$controls = array(
		'icon' => TATSU_PLUGIN_URL . '/builder/svg/modules.svg#gmaps',
		'title' => esc_html__('Google Maps', 'tatsu'),
		'is_js_dependant' => true,
		'type' => 'single',
		'is_built_in' => false,
		'is_dynamic' => true,
		'group_atts'			=> array(
			array(
				'type'		=> 'tabs',
				'style'		=> 'style1',
				'group'		=> array(
					//Tab1
					array(
						'type' => 'tab',
						'title' => esc_html__('Content', 'tatsu'),
						'group'	=> array(
							'address',
							'latitude',
							'longitude',
						),
					),
					//Tab2
					array(
						'type' => 'tab',
						'title' => esc_html__('Style', 'tatsu'),
						'group'	=> array(
							'height',
							'zoom',
							'style',
							'marker',
						),
					),
					//Tab3
					array(
						'type' => 'tab',
						'title' => esc_html__('Advanced', 'tatsu'),
						'group'	=> array(
							array( //Video source accordion
								'type' => 'accordion',
								'active' => 'none',
								'group' => array(
								),
							),
						),
					),
				),
			),
		),
		'atts' => array(
			array(
				'att_name' => 'address',
				'type' => 'text',
				'label' => esc_html__('Address', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'latitude',
				'type' => 'text',
				'label' => esc_html__('Latitude', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'longitude',
				'type' => 'text',
				'label' => esc_html__('Longitude', 'tatsu'),
				'default' => '',
				'tooltip' => ''
			),
			array(
				'att_name' => 'height',
				'type' => 'number',
				'is_inline' => true,
				'label' => esc_html__('Height', 'tatsu'),
				'options' => array(
					'unit' => array( 'px', 'vh' ),
					'add_unit_to_value' => false,
				),
				'default' => '300',
				'tooltip' => '',
				'responsive' => true,
				'css' => true,
				'selectors' => array(
					'.tatsu-{UUID}' => array(
						'property' => 'height',
						'append' => 'px'
					)
				),
			),
			array(
				'att_name' => 'zoom',
				'type' => 'slider',
				'label' => esc_html__('Zoom', 'tatsu'),
				'options' => array(
					'min' => '1',
					'max' => '25',
					'step' => '1',
				),
				'default' => '14',
				'tooltip' => ''
			),
			array(
				'att_name' => 'style',
				'type' => 'select',
				'label' => esc_html__('Style', 'tatsu'),
				'options' => array(
					'standard' => 'Standard',
					'greyscale' => 'Greyscale',
					'bluewater' => 'Bluewater',
					'midnight' => 'Midnight',
					'black' => 'Black',
					'lightdream' => 'Light Dream',
					'wy' => 'Pale Green',
					'blueessence' => 'Blue Essence',
				),
				'default' => 'standard',
				'tooltip' => ''
			),
			array(
				'att_name' => 'marker',
				'type' => 'single_image_picker',
				'label' => esc_html__('Custom Marker Pin', 'tatsu'),
				'tooltip' => '',
			),
		),
		'presets' => array(
			'default' => array(
				'title' => '',
				'image' => '',
				'preset' => array(
					'latitude' => '13.043442',
					'longitude' => '80.273681'
				),
			)
		),
	);
	tatsu_register_module('tatsu_gmaps', $controls);
}

?>