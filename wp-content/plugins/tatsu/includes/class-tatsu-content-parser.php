<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists('Tatsu_Parser')) {
	class Tatsu_Parser {

		private $content;
		private $tatsu_page_content;
		private $post_id; 
		private $type;
		

		public function __construct( $content = '', $post_id = false, $type = 'content' ) {
			$this->content = $content;
			$this->tatsu_page_content = array();
			$this->tatsu_registered_modules = Tatsu_Module_Options::getInstance()->get_registered_modules();
			$this->tatsu_remapped_modules = Tatsu_Module_Options::getInstance()->get_remapped_modules();
			$this->post_id = $post_id;
			$this->type = $type;
		}

		public function get_tatsu_page_content() { 
			$this->tatsu_page_content = $this->parse( $this->wrap_content( $this->content ) );
			return json_encode( $this->tatsu_page_content );
		}

		public function parse( $content ) {
			global $shortcode_tags;
			if ( empty( $shortcode_tags ) || !is_array( $shortcode_tags ) ) {
				return $this->tatsu_page_content;
			}
			$pattern = get_shortcode_regex();
			
			preg_match_all( "/$pattern/s", $content, $matches );

			if( empty( $matches[0] ) ){
				return array();
			}
			return $this->parse_shortcode( $matches );		
		}



		private function wrap_content( $content ) {
			if( 'header' === $this->type ) {
				return $content;
			}
			$pattern = get_shortcode_regex();

			$content_array = preg_split("/$pattern/s", $content, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_OFFSET_CAPTURE );
			$diff_length = 0;
			for ( $i= 0 ; $i < count($content_array); $i++  ) {
				$old_value = $content_array[$i][0];
				$new_value = '[tatsu_section padding="15px 0px 15px 0px" added_by_parser="1"][tatsu_row layout="1/1"][tatsu_column layout="1/1"][tatsu_text]'.$content_array[$i][0].'[/tatsu_text][/tatsu_column][/tatsu_row][/tatsu_section]';
				$offset = $content_array[$i][1];
				if($i > 0) 
					$diff_length += strlen( $new_value ) - strlen( $old_value );
				if( $offset > 0 ) {
					$offset = $offset + $diff_length;
				}
				$content = substr_replace( $content, $new_value, $offset, strlen( $old_value ) );
			}

			$content = $this->wrap_stray_modules( $content );
			
			return $content;			
		}

		private function wrap_stray_modules( $content ) {
			$pattern = get_shortcode_regex();
			preg_match_all( "/$pattern/s", $content, $matches );
			$content_array = $matches[0];
			if( is_array( $content_array ) ) {
				$count = count( $content_array );
				for ( $i = 0 ; $i < $count; $i++ ) {
					preg_match( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content_array[$i], $match );
					$type = $this->get_module_type( $match[1] );
					if( $type && $type != 'core' ){
						$content_array[$i] = '[tatsu_section padding="15px 0px 15px 0px" added_by_parser="1"][tatsu_row layout="1/1"][tatsu_column layout="1/1"]'.$content_array[$i].'[/tatsu_column][/tatsu_row][/tatsu_section]';
					} elseif ( 'core' ===  $type ) {
						switch ( $match[1] ) {
							case 'tatsu_column':
								$content_array[$i] = '[tatsu_section padding="15px 0px 15px 0px" added_by_parser="1"][tatsu_row layout="1/1"]'.$content_array[$i].'[/tatsu_row][/tatsu_section]';
								break;
							case 'tatsu_row':
								$content_array[$i] = '[tatsu_section padding="15px 0px 15px 0px" added_by_parser="1"]'.$content_array[$i].'[/tatsu_section]';
							default:
								break;
						}
					}
				}
			}
			$content = implode( '', $content_array );
			return $content;
		}


		private function is_post_type_post() {
			if( !$this->post_id ) {
				return false;
			}
			$post_type = get_post_type( $this->post_id );
			if( $post_type && 'post' === $post_type ) {
				return true;
			} else {
				return false;
			}
		}


		private function parse_shortcode( $matches ) {
			$sample = array();
			$pattern = get_shortcode_regex();
			$count = count($matches[0]);
			for($counter = 0;$counter < $count; $counter++ ){
				$tag = $matches[2][$counter];
				if( array_key_exists( $tag, $this->tatsu_remapped_modules ) ) {
					$tag = $this->tatsu_remapped_modules[$tag];
				}
				$atts = $this->parse_atts( $matches[3][$counter] , $tag, $counter, $count );  // do some processing like combining color & opacity atts. 
				$type = $this->get_module_type( $tag );
				$builder_layout = $this->get_builder_layout( $tag );
				$content = $matches[5][$counter];
				$registered_modules = Tatsu_Module_Options::getInstance()->get_modules();
				$should_autop = isset( $registered_modules[$tag]['should_autop'] ) ? $registered_modules[$tag]['should_autop']: true;
				if( empty( $atts['key'] ) ) {
					$key = be_uniqid_base36(true);
				} else {
					$key = $atts['key'];
				}
				$sample[$counter] = array(
							'name' => $tag,
							'id' => $key, //be_uniqid_base36(true), //$key,
							'atts' => $atts,
							'type' => $type,
							'builderLayout' => $builder_layout,
						);
						
				if( $type !== "core" && $type !== 'multi' ) { 
					if( $should_autop ) {
						$sample[$counter]['atts']['content'] = wpautop( $content );
					} else {
						$sample[$counter]['atts']['content'] = $content;
					}				
				}				

				if( $type !== "core" && !$this->is_built_in( $tag ) ) {
					$tatsu_module = new Tatsu_Module( $tag, $atts, $content );
					$sample[$counter]['shortcode_output'] = $tatsu_module->do_shortcode();					
				}

				if( $type != 'single' && $type != 'sub_module') {
					$sample[$counter]['inner'] = $this->parse( $matches[5][$counter] );
				}

				if( 'tatsu_column' === $tag ) {
					$sample[$counter]['layout'] = $atts['layout'];
				}

				if( 'tatsu_row' === $tag ) {
					$sample[$counter]['columnLayout'] = $atts['layout'];
				}				
			}
			return $sample;
		}

		private function is_built_in( $tag ) {
			return Tatsu_Module_Options::getInstance()->is_built_in( $tag );
		}

		private function get_module_type( $tag ) {
			$type = Tatsu_Module_Options::getInstance()->get_module_type( $tag );
			if( $type ) {
				return $type;
			} else {
				return Tatsu_Header_Module_Options::getInstance()->get_module_type( $tag );
			}
		}

		private function get_builder_layout( $tag ) {
			if( 'tatsu_row' == $tag ) {
				return 'column';
			} else {
				return 'list';
			}
		}		

		private function parse_atts( $atts, $tag, $counter, $count ) {
			if( empty($atts) ) {
				$atts = array();
			} else {
				$atts = shortcode_parse_atts( $atts );
				if( !is_array( $atts ) ) {
					$atts = array();
				}
				if( 'tatsu_section' === $tag && !empty( $atts['added_by_parser'] ) ) {
					$is_post = $this->is_post_type_post();
					if( !$is_post && $count === 1 ) {
						$atts['padding'] = '90px 0px 90px 0px';
					} else if ( !$is_post && $count > 1 && $counter === 0 ) {
						$atts['padding'] = '90px 0px 15px 0px';
					} else if( !$is_post && $counter === $count -1 ) {
						$atts['padding'] = '15px 0px 90px 0px';
					}
					unset( $atts['added_by_parser'] );
				}
				
				if( 'tatsu_header_column' === $tag || 'tatsu_column' === $tag || 'tatsu_inner_column' === $tag ){
					if( !isset( $atts[ 'column_width' ] ) ){
						if( $atts['layout'] == '1/1' )
							$atts['column_width'] = '100';
						if( $atts['layout'] == '1/2' )
							$atts['column_width'] = array( 'd' => '50', 'm' => '100' );
						if( $atts['layout'] == '1/3') 
							$atts['column_width'] = array( 'd' => '33.33', 'm' => '100' );
						if( $atts['layout'] == '1/4' ) 
							$atts['column_width'] = array( 'd' => '25', 'm' => '100' );
						if( $atts['layout'] == '1/5' ) 
							$atts['column_width'] = array( 'd' => '20', 'm' => '100' );
						if( $atts['layout'] == '2/3' ) 
							$atts['column_width'] = array( 'd' => '66.67', 'm' => '100' );
						if( $atts['layout'] == '3/4' ) 
							$atts['column_width'] = array( 'd' => '75', 'm' => '100' );
					}
				}
				
				if( 'tatsu_image' === $tag ) {
					$upload_dir_paths = wp_upload_dir();
					if ( false !== strpos( $atts['image'], $upload_dir_paths['baseurl'] ) ) {
						$image_details = wp_get_attachment_image_src( $atts['id'], 'full' );
						if( $image_details ) {
							$atts['image'] = $image_details[0];
							if( !empty( $atts['size'] ) && $atts['size'] !== 'full' ) {
								$image_details = wp_get_attachment_image_src( $atts['id'], $atts['size'] );
								if( $image_details && $image_details[3] ) {
									$atts['image_varying_size_src'] = $image_details[0];
								} else {
									$atts['image_varying_size_src'] = '';
									$atts['size'] = 'full';
								}
							}
						} else {
							$atts['image_varying_size_src'] = '';
							$atts['size'] = 'full';
						}
					} else {
						$atts['id'] = '';
						$atts['size'] = 'full';
						$atts['image_varying_size_src'] = '';
					}
				}

				if( 'gallery' === $tag ) {
					if( !empty( $atts['images'] ) ) {
						$atts['ids'] = $atts['images'];
					} 
					if( !empty( $atts['col'] ) ) {
						if( $atts['col'] == 'one' ) {
							$atts['columns'] = '1';
						} else if( $atts['col'] == 'two' ){
							$atts['columns'] = '2';
						} else if( $atts['col'] == 'three' ){
							$atts['columns'] = '3';
						} else if( $atts['col'] == 'four' ){
							$atts['columns'] = '4';
						} else if( $atts['col'] == 'five' ){
							$atts['columns'] = '5';
						} else {
							$atts['columns'] = '3';
						}
					} else {
						$atts['columns'] = '3';
					}
					unset( $atts['images'] );
					unset( $atts['col'] );
				}

				if( 'tatsu_section' === $tag ){
					if( array_key_exists('full_screen', $atts) && $atts['full_screen'] == '1' ){
						$atts['section_height_type'] = 'full_screen';
						$atts['custom_height'] = '';
					} else if( array_key_exists( 'enable_custom_height',$atts) && $atts['enable_custom_height'] == '1' ){
						$atts['section_height_type'] = 'custom_height';
					}

					if( array_key_exists('offset_section', $atts) && empty( $atts['offset_section'] ) ){
						$atts['offset_value'] = '';
					}

					if( array_key_exists('bg_overlay', $atts) && empty( $atts['bg_overlay'] ) ){
						$atts['overlay_color'] = '';
						$atts['overlay_blend_mode'] = 'none';
					}

					if( array_key_exists( 'bg_video',$atts) && empty( $atts['bg_video'] ) ){
						$atts['bg_video_mp4_src'] = '';
						$atts['bg_video_ogg_src'] = '';
						$atts['bg_video_webm_src'] = '';
					}

					unset( $atts['bg_video'] );
					unset( $atts['full_screen'] );
					unset( $atts['enable_custom_height'] );
					unset( $atts['offset_section'] );
					unset( $atts['bg_overlay'] );
				}

				if( 'tatsu_column' === $tag || 'tatsu_inner_column' === $tag ){
					if( array_key_exists('custom_margin', $atts) && empty( $atts['custom_margin'] ) ){
						$atts['margin'] = '{"d":""}';
					}
					
					if( array_key_exists( 'enable_box_shadow',$atts) && empty( $atts['enable_box_shadow'] ) ){
						$atts['box_shadow_custom'] = '0px 0px 0px 0px rgba(0,0,0,0)';
					}

					if( array_key_exists( 'column_offset',$atts) && empty( $atts['column_offset'] ) ){
						$atts['offset'] = '0px 0px';
					}

					if( array_key_exists('bg_overlay', $atts) && empty( $atts['bg_overlay'] ) ){
						$atts['overlay_blend_mode'] = 'none';
					}

					if( array_key_exists( 'bg_video',$atts) && empty( $atts['bg_video'] ) ){
						$atts['bg_video_mp4_src'] = '';
						$atts['bg_video_ogg_src'] = '';
						$atts['bg_video_webm_src'] = '';
					}

					unset( $atts['bg_video'] );
					unset( $atts['custom_margin'] );
					unset( $atts['enable_box_shadow'] );
					unset( $atts['bg_overlay'] );
					unset( $atts['column_offset'] );
				}

				if( 'tatsu_interactive_box' === $tag ){
					if( array_key_exists( 'overlay',$atts) && empty( $atts['overlay'] ) ){
						$atts['overlay_blend_mode'] = 'none';
					}

					if( array_key_exists( 'custom_height',$atts) && empty( $atts['custom_height'] ) ){
						$atts['height'] = '';
					}

					unset( $atts['overlay'] );
					unset( $atts['custom_height'] );
				}

				if( 'tatsu_image' === $tag ){
					if( array_key_exists( 'enable_margin',$atts) && empty( $atts['enable_margin'] ) ){
						$atts['margin'] = '';
					}
					if( array_key_exists( 'image_offset',$atts) && empty( $atts['image_offset'] ) ){
						$atts['offset'] = '{"d":"0px 0px"}';
					}

					unset( $atts['enable_margin'] );
					unset( $atts['image_offset'] );
				}

				if( array_key_exists( 'animate',$atts) ){
                    if( empty( $atts['animate'] ) ){
                        $atts['animation_type'] = 'none';
                    }
                    $atts['animate'] = '1';
                }

				if( 'tatsu_button' === $tag || 'tatsu_gradient_button' === $tag){
					if( array_key_exists( 'enable_margin',$atts) && empty( $atts['enable_margin'] ) ){
						$atts['margin'] = '';
					}

					unset( $atts['enable_margin'] );
				}

				
				// Parse Responsive Attributes which are in json format
				foreach ( $atts as $att => $value ) {
					if( is_string($value) ){
                        $value = json_decode( $value, true );
                        if( json_last_error() === JSON_ERROR_NONE && is_array( $value ) ) {
                            $atts[$att] = $value;
                        }
                    }
				}
            }
            
            $atts = apply_filters( "tatsu_parse_atts_{$tag}", $atts, $counter, $count );
            return $atts;
		}
	}
}