<?php
/***************************************
				TOP SECTION DETAILS			
***************************************/
if ( !function_exists( 'be_themes_top_section_details' ) ) {
	function be_themes_top_section_details() {
		$result = array();
		$post_id = be_get_page_id();
		if(is_singular( 'post' ) && is_single($post_id) && isset($be_themes_data['single_blog_hero_section_from']) && $be_themes_data['single_blog_hero_section_from'] == 'inherit_option_panel') {
			if(!empty($be_themes_data['single_blog_hero_section_position']) && isset($be_themes_data['single_blog_hero_section_position']) && $be_themes_data['single_blog_hero_section_position'] ) {
				$top_section_position = $be_themes_data['single_blog_hero_section_position'];
			} else {
				$top_section_position = 'after';
			}
			if(!empty($be_themes_data['single_blog_header_transparent']) && isset($be_themes_data['single_blog_header_transparent']) && $be_themes_data['single_blog_header_transparent'] ) {
				$header_transparent = $be_themes_data['single_blog_header_transparent'];
			} else {
				$header_transparent = 0;
			}
		} else if((in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_product($post_id)) && isset($be_themes_data['single_shop_hero_section_from']) && $be_themes_data['single_shop_hero_section_from'] == 'inherit_option_panel') {
			if(!empty($be_themes_data['single_shop_hero_section_position']) && isset($be_themes_data['single_shop_hero_section_position']) && $be_themes_data['single_shop_hero_section_position'] ) {
				$top_section_position = $be_themes_data['single_shop_hero_section_position'];
			} else {
				$top_section_position = 'after';
			}
			if(!empty($be_themes_data['single_shop_header_transparent']) && isset($be_themes_data['single_shop_header_transparent']) && $be_themes_data['single_shop_header_transparent'] ) {
				$header_transparent = $be_themes_data['single_shop_header_transparent'];
			} else {
				$header_transparent = 0;
			}
		} else {
			$top_section_position = get_post_meta($post_id, 'be_themes_hero_section_position', true);
			$header_transparent = get_post_meta($post_id, 'be_themes_header_transparent', true);
		}

		$result[ 'top_section_position' ] = $top_section_position;
		$result[ 'header_transparent' ] = $header_transparent;
		return $result;
	}
}

/***************************************
				HELPER FUNC		
***************************************/
if ( !function_exists( 'be_is_special_top_menu' ) ){
	function be_is_special_top_menu( $menu_style = NULL ) {
		//Check if the special menu style is set
		global $be_themes_data;
		//If 'Top' is set in opt-header-type
		if( ('top' == $be_themes_data['opt-header-type'] ) && isset($be_themes_data['opt-header-type']) ){
			$header_style = pathinfo( $be_themes_data['opt-header-style'], PATHINFO_FILENAME );
			//If Style7 - style12 is chosen
			if( isset( $be_themes_data['opt-header-style'] ) && ( ( 'style7' == $header_style ) || ( 'style8' == $header_style ) || ( 'style9' == $header_style ) || ( 'style10' == $header_style ) || ( 'style11' == $header_style ) || ( 'style12' == $header_style )  )  ){
				$menu = pathinfo( $be_themes_data['opt-menu-style'], PATHINFO_FILENAME );
				//If the passed menu style is set
				if( isset( $menu_style ) && isset( $be_themes_data['opt-menu-style'] ) && ( $menu_style == $menu ) ){
					return true;
				}
				//In case $menu_style is not given, check if it is new header style
				if( !isset( $menu_style ) ){
					if( 'overlay-center-align-menu' == $menu || 'overlay-horizontal-menu' == $menu || 'page-stack-left' == $menu || 'page-stack-right' == $menu || 'page-stack-top' == $menu || 'perspective-left' == $menu || 'perspective-right' == $menu || 'special-left-menu' == $menu || 'special-right-menu' == $menu )
					return true;
				}
			}		
		}
		return false;
	}
}

if( !function_exists( 'be_is_special_left_menu' ) ){
	function be_is_special_left_menu( $menu_style = NULL ){
		//Check if the special menu style is set
		global $be_themes_data;
		//If 'Left' is set in opt-header-type
		if( ('left' == $be_themes_data['opt-header-type'] ) && isset($be_themes_data['opt-header-type']) ){
			$menu = basename($be_themes_data['left-header-style'], '.jpg');
			if( isset( $be_themes_data['left-header-style'] ) && ( ( 'left-strip-menu' == $menu ) || ( 'perspective-right' == $menu ) || ( 'overlay-center-align-menu' == $menu ) || ( 'overlay-left-align-menu' == $menu ) || ( 'left-static-menu' == $menu )  ) ){
				//If the passed menu style is set
				if( isset( $menu_style ) && ( $menu_style == $menu ) ){
					return true;
				}
				//In case $menu_style is not given, check if it is new left header style
				if( !isset( $menu_style ) ){
					return true;
				}	
			}		
		}
		return false;
	}
}

/***************************************
				SIDEBAR			
***************************************/
if ( !function_exists( 'be_themes_after_body' ) ) {
	function be_themes_after_body() {
		//If Header style is not new header style, show the sb_slidebar
		if( !be_is_special_top_menu() && !be_is_special_left_menu() && !be_is_special_top_menu( 'menu-animate-fall' ) ){
			global $be_themes_data;
			$sidebar_class = 'sb-right'; 
			if ( isset($be_themes_data['opt-header-type']) && ('left' == $be_themes_data['opt-header-type'] ) ) {
				$sidebar_class = 'sb-left';
			}
			$show_sidebar = 0;
			$header_right_widgets = isset($be_themes_data['opt-header-pos']['right']) ? $be_themes_data['opt-header-pos']['right'] :  array() ;
			if (isset($be_themes_data['opt-header-type'])){
				if ('left' == $be_themes_data['opt-header-type'] ) {
					$show_sidebar = 1;
				}else if ('top' == $be_themes_data['opt-header-type'] ) {
					if( array_key_exists('smenu',$header_right_widgets) || ('top-overlay-menu' == ($be_themes_data['top-menu-style'])) ){
						$show_sidebar = 1;
					}
				}
			}
			if ( $show_sidebar == 1 ) {?>
				<div class="sb-slidebar <?php echo $sidebar_class; ?>">
					<i class="overlay-menu-close font-icon icon-icon_close"></i>
					<div class="display-table">
						<div id="sb-slidebar-content" class="sb-slidebar-content ajaxable">
							<?php 
							if((!isset($be_themes_data['disable_logo']) || empty($be_themes_data['disable_logo'])) || (isset($be_themes_data['disable_logo']) && (0 == $be_themes_data['disable_logo'])) ){		
								$logo_sidebar = get_template_directory_uri().'/img/logo.png';
								if( ! empty( $be_themes_data['logo_sidebar']['url'] )) {
									$logo_sidebar = $be_themes_data['logo_sidebar']['url'];
								}else{
									if( array_key_exists('logo', $be_themes_data) && ! empty( $be_themes_data['logo']['url'] ) ) {
										$logo_sidebar = $be_themes_data['logo']['url'];
									}
								}
							}
								echo '<div id="logo-sidebar"><a href="'.home_url().'"><img class="transparent-logo dark-scheme-logo" src="'.$logo_sidebar.'" alt="'.esc_attr(get_bloginfo('name')).'" /></a></div>';
								be_themes_get_header_sidebar_navigation();
								if (is_active_sidebar( 'sliderbar-area' ) ) {
									dynamic_sidebar( 'sliderbar-area' );
								}
							?>
						</div>
					</div>
				</div>
			<?php }
		}
	}
	add_action( 'after_body', 'be_themes_after_body' );
}
/***************************************
				BE SUB MENU STYLE			
***************************************/
if (!function_exists ('be_themes_get_submenu' ) ){
	function be_themes_get_submenu() {
		global $be_themes_data;
		$sub_menu_type = 'oldMultilevelMenu';
		$header_type = $be_themes_data['opt-header-type'];		
		$new_top_header_styles = array( 'page-stack-top','overlay-center-align-menu','overlay-horizontal-menu','page-stack-left','page-stack-right','page-stack-top','perspective-left','perspective-right','special-left-menu','special-right-menu' );
		$new_left_header_styles = array('left-strip-menu','overlay-center-align-menu','overlay-left-align-menu','perspective-right');
		if($header_type == 'top'){
			$header_style = isset($be_themes_data['opt-menu-style'] ) ? basename($be_themes_data['opt-menu-style'], '.jpg' ) : 'none';
			if(in_array($header_style, $new_top_header_styles)){
				
				$sub_menu_type = 'newMultilevelMenu';
			}
		}elseif ($header_type == 'left'){
			$header_style = isset($be_themes_data['left-header-style'] ) ? basename($be_themes_data['left-header-style'], '.jpg' ) : 'style3';
			if(in_array($header_style, $new_left_header_styles)){
				$sub_menu_type = 'newMultilevelMenu';
			}
		}
		return $sub_menu_type;
	}
}
/***************************************
				BE SIDE MENU			
***************************************/
if ( !function_exists( 'be_sidemenu' ) ) {
	function be_sidemenu() {
		if( be_is_special_top_menu() ){
			global $be_themes_data, $sub_menu_type;

			$header_style = isset($be_themes_data['opt-header-style'] ) ? $be_themes_data['opt-header-style'] : 'style3';
			$new_header_styles = array('style7','style8','style9','style10','style11','style12','style13');
			// $old_header_styles = array('style1','style2','style3','style4','style5','style6');
			$sidebar_class = ''; 
			if ( be_is_special_top_menu( 'page-stack-left' ) ) {
				$sidebar_class = 'be-sidemenu-left be-page-stack-left';
			} elseif( be_is_special_top_menu( 'page-stack-right' ) ){
				$sidebar_class = 'be-sidemenu-right be-page-stack-right';
			} elseif( be_is_special_top_menu( 'special-left-menu' ) || be_is_special_top_menu( 'perspective-right' ) ){
				$sidebar_class = 'be-sidemenu-left';
			} elseif( be_is_special_top_menu( 'special-right-menu' ) || be_is_special_top_menu( 'perspective-left' ) ){
				$sidebar_class = 'be-sidemenu-right';
			}
			?>
				<div class="be-sidemenu <?php echo $sidebar_class; ?>" 
					<?php 
						if( isset( $be_themes_data['top_special_header_menu_animation'] ) && !empty( $be_themes_data['top_special_header_menu_animation'] ) ){
							echo "data-link-animation-direction = '".$be_themes_data['top_special_header_menu_animation']."'";
						}
						if( isset( $be_themes_data['top_special_menu_alignment'] ) && !empty( $be_themes_data['top_special_menu_alignment'] ) ){
							// In case of overly-horizontal-menu and page-stack-top, the menu alignment horizontal field is used to decide the positioning of menu items; for others menu alignment field is used which has values in terms of flex properties
							if( !( be_is_special_top_menu('overlay-horizontal-menu') || be_is_special_top_menu('page-stack-top') ) ){
								echo "data-menu-alignment = '".$be_themes_data['top_special_menu_alignment']."'";
							} else {
								if( 'left' == $be_themes_data['top_special_menu_alignment_horizontal'] ){
									echo "data-menu-alignment = 'flex-start'";
								} else if( 'right' == $be_themes_data['top_special_menu_alignment_horizontal'] ){
									echo "data-menu-alignment = 'flex-end'";
								} else {
									echo "data-menu-alignment = 'center'";
								}
							}
						}
						echo "data-submenu = " . be_themes_get_submenu();
					?>>
						<div id="be-sidemenu-content" class="be-sidemenu-content tatsu-wrap">
							<?php 
							if( !be_is_special_top_menu( 'overlay-center-align-menu' ) && !be_is_special_top_menu( 'overlay-horizontal-menu') && !be_is_special_top_menu( 'page-stack-top') ){
								if((!isset($be_themes_data['disable_logo']) || empty($be_themes_data['disable_logo'])) || (isset($be_themes_data['disable_logo']) && (0 == $be_themes_data['disable_logo'])) ){		
									if( ! empty( $be_themes_data['logo_sidebar']['url'] )) {
										$logo_sidebar = $be_themes_data['logo_sidebar']['url'];
										echo '<div class="special-header-logo"><a href="'.home_url().'"><img class="transparent-logo dark-scheme-logo" src="'.$logo_sidebar.'" alt="'.esc_attr(get_bloginfo('name')).'" /></a></div>';
									}
								}
									
							}
							be_themes_get_header_sidebar_navigation();
							if ( isset($be_themes_data['top_special_header_bottom_text']) && !empty($be_themes_data['top_special_header_bottom_text']) ){?>
								<div class = "special-header-bottom-text">
									<?php echo do_shortcode( $be_themes_data['top_special_header_bottom_text'] ) ; ?>
								</div>
							<?php
								}
							?>
						</div>
					</div>
				</div>
			<?php
		}
	}
	add_action( 'after_body', 'be_sidemenu' );
}


/***************************************
			BE LEFT SIDE MENU			
***************************************/
if ( !function_exists( 'be_left_sidemenu' ) ) {
	function be_left_sidemenu() {
		if( be_is_special_left_menu() ){
			global $be_themes_data;
			$sidebar_class = 'be-sidemenu-left';
			if( be_is_special_left_menu( 'overlay-left-align-menu' ) || be_is_special_left_menu( 'overlay-center-align-menu' ) || be_is_special_left_menu( 'left-static-menu' ) ){
				$sidebar_class = '';
            }
            if( be_is_special_left_menu( 'left-static-menu' ) && !empty( $be_themes_data['left_header_alignment_horizontal'] ) ) {
                $sidebar_class .= ' be-sidemenu-align-' . $be_themes_data['left_header_alignment_horizontal'];
            }
			?>
				<div class="be-sidemenu <?php echo $sidebar_class; ?>" 
                    <?php 
                        if( !be_is_special_left_menu( 'left-static-menu' ) ) {
                            if( isset( $be_themes_data['left_special_header_menu_animation'] ) && !empty( $be_themes_data['left_special_header_menu_animation'] ) ){
                                echo "data-link-animation-direction = '".$be_themes_data['left_special_header_menu_animation']."'";
                            }
                            if( isset( $be_themes_data['left_special_menu_alignment'] ) && !empty( $be_themes_data['left_special_menu_alignment'] ) ){
                                echo "data-menu-alignment = '".$be_themes_data['left_special_menu_alignment']."'";
                            }
                        }
						echo "data-submenu = ". be_themes_get_submenu();
					?>
                >
					<?php
						if( be_is_special_left_menu( 'overlay-center-align-menu' ) || be_is_special_left_menu( 'overlay-left-align-menu' ) ){
							echo "<i class='be-overlay-menu-close font-icon icon-icon_close'></i>";
						}
						$tatsu_wrap_class = be_is_special_left_menu( 'left-static-menu' ) ? '' : 'tatsu-wrap';
					?>
						<div id="be-sidemenu-content" class="be-sidemenu-content <?php echo esc_attr( $tatsu_wrap_class ); ?>">
							<?php 
                                if( ( empty( $be_themes_data['disable_logo'] ) && !empty( $be_themes_data['logo_sidebar']['url'] ) ) || be_is_special_left_menu( 'left-static-menu' ) ){
                                    $logo_sidebar_html = !empty( $be_themes_data['logo_sidebar']['url'] ) ? '<img class="transparent-logo dark-scheme-logo" src="'. $be_themes_data['logo_sidebar']['url'] .'" alt="'.esc_attr(get_bloginfo('name')).'" />' : '';
									echo '<div class="special-header-logo"><a href="'.home_url().'">' . $logo_sidebar_html . '</a></div>';
								}
								be_themes_get_header_sidebar_navigation();
								if ( !empty($be_themes_data['left_special_header_bottom_text']) || be_is_special_left_menu( 'left-static-menu' ) ){?>
									<div class = "special-header-bottom-text">
										<?php echo !empty($be_themes_data['left_special_header_bottom_text']) ? do_shortcode( $be_themes_data['left_special_header_bottom_text'] ) : '' ; ?>
									</div>
							<?php
								}
							?>
						</div>
					</div>
				</div>
			<?php
		}
	}
	add_action( 'after_body', 'be_left_sidemenu' );
}


/***************************************
				HEADER DETAILS			
***************************************/
if ( !function_exists( 'be_themes_header_details' ) ) {
	function be_themes_header_details() {
		global $be_themes_data;
		$result = array(); 
		$post_id = be_get_page_id();
		$post = get_post( $post_id );
		if( is_singular( 'post' ) && is_single($post_id) && isset( $be_themes_data[ 'single_blog_style' ] ) && !empty( $be_themes_data[ 'single_blog_style' ] ) ) {
			if( !empty( $be_themes_data[ 'single_wide_header_transparent' ] ) && isset( $be_themes_data[ 'single_wide_header_transparent' ] ) && 'none' != $be_themes_data[ 'single_wide_header_transparent' ] ) {
				$header_transparent = $be_themes_data['single_wide_header_transparent'];
			}else{
				$header_transparent = 0;
			}
			if( !empty( $be_themes_data[ 'single_wide_navigation_color_scheme' ] ) && isset( $be_themes_data[ 'single_wide_navigation_color_scheme' ] ) ) {
				$color_scheme = $be_themes_data[ 'single_wide_navigation_color_scheme' ];	
			}else{
				$color_scheme = 'light';
			}
			$hero_section = 1;
		}else if(is_singular( 'post' ) && is_single($post_id) && isset($be_themes_data['single_blog_hero_section_from']) && $be_themes_data['single_blog_hero_section_from'] == 'inherit_option_panel') {
			if(!empty($be_themes_data['single_blog_header_transparent']) && isset($be_themes_data['single_blog_header_transparent']) && 'none' != $be_themes_data['single_blog_header_transparent'] ) {
				$header_transparent = $be_themes_data['single_blog_header_transparent'];
			} else {
				$header_transparent = 0;
			}
			if(!empty($be_themes_data['single_blog_header_transparent_color_scheme']) && isset($be_themes_data['single_blog_header_transparent_color_scheme']) && 'none' != $be_themes_data['single_blog_header_transparent_color_scheme'] ) {
				$color_scheme = $be_themes_data['single_blog_header_transparent_color_scheme'];
			} else {
				$color_scheme = '';
			}
			$hero_section = $be_themes_data['single_blog_hero_section'];
		} else if((in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_product($post_id)) && isset($be_themes_data['single_shop_hero_section_from']) && $be_themes_data['single_shop_hero_section_from'] == 'inherit_option_panel') {
			if(!empty($be_themes_data['single_shop_header_transparent']) && isset($be_themes_data['single_shop_header_transparent']) && ('none' !=  $be_themes_data['single_shop_header_transparent']) ) {
				$header_transparent = $be_themes_data['single_shop_header_transparent'];
			} else {
				$header_transparent = 0;
			}
			if(!empty($be_themes_data['single_shop_header_transparent_color_scheme']) && isset($be_themes_data['single_shop_header_transparent_color_scheme']) && ('none' !=  $be_themes_data['single_shop_header_transparent_color_scheme']) ) {
				$color_scheme = $be_themes_data['single_shop_header_transparent_color_scheme'];
			} else {
				$color_scheme = '';
			}
			$hero_section = $be_themes_data['single_shop_hero_section'];
		} else {
			$header_transparent = get_post_meta($post_id, 'be_themes_header_transparent', true);
			$hero_section = get_post_meta($post_id, 'be_themes_hero_section', true);
			$color_scheme = get_post_meta($post_id, 'be_themes_header_transparent_color_scheme', true);
			$sticky_sections = get_post_meta($post_id, 'be_themes_sticky_sections', true);
			if( isset( $sticky_sections ) && !empty( $sticky_sections ) ) {
				$hero_section = 'none';
			}
		}
		/*****Single Post Transparent Header settings saved in particular post************/
		$post_header_transparent = get_post_meta($post_id, 'be_themes_header_transparent', true);
		if(!empty($post_header_transparent) && $post_header_transparent !== $header_transparent && $post_header_transparent != 'none'){
			$header_transparent = $post_header_transparent;
		}

		if ( 'left' === $be_themes_data['opt-header-type'] ) {
			$header_transparent = 0;
		}

		$header_class = $full_screen_header_scheme = '';

		if(!empty($header_transparent) && isset($header_transparent) && 'none' != $header_transparent) {
			if($be_themes_data['layout'] == 'layout-border-header-top' ) {
				$header_class = 'no-transparent';
			} elseif ('transparent' == $header_transparent) {
				$header_class = 'transparent';
			} elseif ('semitransparent' == $header_transparent) {
				$header_class = 'semi-transparent transparent';
			}
		}
		//this is where you have to add the logic for first section color scheme
		if((!empty($header_transparent) && isset($header_transparent) && 'none' != $header_transparent ) ) {
			if( !empty($hero_section) && isset($hero_section) && $hero_section != 'none' ) {
				if(!empty($color_scheme) && isset($color_scheme) && $color_scheme) {
					if($color_scheme == 'dark') {
						$header_class .= ' background--light';
						$full_screen_header_scheme = 'data-headerscheme="background--light"';
					} elseif($color_scheme == 'light') {
						$header_class .= ' background--dark';
						$full_screen_header_scheme = 'data-headerscheme="background--dark"';
					}
				}
			}else{
				$pattern = get_shortcode_regex();
				$scheme_post_content = $post->post_content;
				if( current_theme_supports('tatsu-global-sections') ){
					$global_section_id = null;

					$global_section_post_meta = get_post_meta($post_id, 'tatsu_global_section_data',true);
					
					if( !empty($global_section_post_meta['top']) && $global_section_post_meta['top'] !== 'inherit' ){
						if( $global_section_post_meta['top'] !== 'none' ){
							$global_section_id = $global_section_post_meta['top'];
						}
					} else {
						$post_type = get_post_type( $post_id );

						$global_section_data = get_option( 'tatsu_global_section_data', array() );
						if( gettype( $global_section_data ) === 'string' ){
							$global_section_data = json_decode( $global_section_data,true );
						}
						$post_settings = '';
						if( array_key_exists('post_settings',$global_section_data) ){
							$post_settings = $global_section_data['post_settings'];
						}else{
							$post_settings = array();
						}
						if( array_key_exists( $post_type,$post_settings ) ){
							if( $post_settings[ $post_type ]['top'] !== 'none' ){
								$global_section_id = (int) $post_settings[ $post_type ]['top'];
							}
						}
					}

					if( $global_section_id !== null ){
						$global_section_post = get_post( $global_section_id );
						$scheme_post_content = $global_section_post->post_content;
					}

				}
				if (  preg_match_all( '/'. $pattern .'/s', $scheme_post_content , $matches ) && array_key_exists( 2, $matches ) && in_array( 'tatsu_section', $matches[2] ) && isset( $matches[ 3 ] ) && !empty( $matches[ 3 ] ) ) {
					// shortcode is being used
					$shortcode_atts = shortcode_parse_atts( $matches[3][0] );
					//var_dump( $shortcode_atts );
					if( !empty( $shortcode_atts ) && array_key_exists( 'full_screen_header_scheme', $shortcode_atts ) ) {
						$first_section_header_background_scheme = $shortcode_atts[ 'full_screen_header_scheme' ];
						$header_class .= ' ' . $first_section_header_background_scheme;
						$full_screen_header_scheme .= 'data-headerscheme = "' . $first_section_header_background_scheme . '"';
					}
				}
			}	
		}
		
		if ( isset($be_themes_data['opt-header-type']) && ('top' == $be_themes_data['opt-header-type'] ) ) { 
			$header_style = basename($be_themes_data['opt-header-style'],'.png') ;
		} else {
			$header_style = '';
		}
		if ( isset($be_themes_data['mobile_menu_icon_bg']) && !empty($be_themes_data['mobile_menu_icon_bg']['alpha']) && 'left' !== $be_themes_data['opt-header-type'] ){
			$header_class .= ' exclusive-mobile-bg';
		}
		$result[ 'header_transparent' ] = $header_transparent;
		$result[ 'color_scheme' ] = $color_scheme;
		$result[ 'header_class' ] = $header_class;
		$result[ 'full_screen_header_scheme' ] = $full_screen_header_scheme;
		$result[ 'header_style' ] = $header_style;
		return $result;
	}
}

/***************************************
				SITE LOGO			
***************************************/
if ( !function_exists( 'be_themes_get_header_logo_image' ) ) {
	function be_themes_get_header_logo_image() {
		global $be_themes_data;
		$logo_alt_text = esc_attr(get_bloginfo('name'));
		$logo = get_template_directory_uri().'/img/logo.png';
		if( ! empty( $be_themes_data['logo']['url'] ) ) {
			$logo = be_themes_protocol_based_urls( $be_themes_data['logo']['url'] );
		}
		if( ! empty( $be_themes_data['logo_sticky']['url'] ) ) {
			$logo_sticky = be_themes_protocol_based_urls( $be_themes_data['logo_sticky']['url'] );
		} else {
			$logo_sticky = $logo;
		}
		if( ! empty( $be_themes_data['logo_transparent']['url'] )) {
			$logo_transparent = be_themes_protocol_based_urls( $be_themes_data['logo_transparent']['url'] );
		} else {
			$logo_transparent = $logo;
		}
		if( ! empty( $be_themes_data['logo_transparent_light']['url'] )) {
			$logo_transparent_light = be_themes_protocol_based_urls( $be_themes_data['logo_transparent_light']['url'] );
		} else {
			$logo_transparent_light = $logo_transparent;
		}
		echo '<a href="'.home_url().'">';
			$post_id = be_get_page_id();
			if(is_singular( 'post' ) && is_single($post_id) && isset($be_themes_data['single_blog_hero_section_from']) && $be_themes_data['single_blog_hero_section_from'] == 'inherit_option_panel') {
				$header_transparent = $be_themes_data['single_blog_header_transparent'];
			} else if((in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_product($post_id)) && isset($be_themes_data['single_shop_hero_section_from']) && $be_themes_data['single_shop_hero_section_from'] == 'inherit_option_panel') {
				$header_transparent = $be_themes_data['single_shop_header_transparent'];
			} else {
				$header_transparent = get_post_meta($post_id, 'be_themes_header_transparent', true);
			}
			// if(!empty($header_transparent) && isset($header_transparent) && ('none' != $header_transparent)) {
				echo '<img class="transparent-logo dark-scheme-logo" src="'.apply_filters('be_themes_dark_scheme_logo', $logo_transparent ).'" alt="'.$logo_alt_text.'" />';
				echo '<img class="transparent-logo light-scheme-logo" src="'.apply_filters('be_themes_light_scheme_logo', $logo_transparent_light ).'" alt="'.$logo_alt_text.'" />';
				echo '<img class="normal-logo" src="'.apply_filters('be_themes_normal_logo', $logo ).'" alt="'.$logo_alt_text.'" />';
				echo '<img class="sticky-logo" src="'.apply_filters('be_themes_sticky_logo', $logo_sticky ).'" alt="'.$logo_alt_text.'" />';
			// } else {
			// 	echo '<img class="normal-logo" src="'.apply_filters('be_themes_normal_logo', $logo ).'" alt="'.$logo_alt_text.'" />';
			// 	echo '<img class="sticky-logo" src="'.apply_filters('be_themes_sticky_logo', $logo_sticky ).'" alt="'.$logo_alt_text.'" />';
			// }
		echo '</a>';
	}
}
/***************************************
			Header Top Bar Widgets
***************************************/
if ( ! function_exists( 'be_themes_get_topbar_widgets' ) ) {
	function be_themes_get_topbar_widgets( $widget_type  ) {
		global $be_themes_data;

		switch ($widget_type) {
			case 'phone': ?>
				<span class="top-bar-widgets"><?php echo $be_themes_data['opt-phone-topbar']; ?></span><?php
				break;
			
			case 'email': ?>
				<span class="top-bar-widgets"><?php echo $be_themes_data['opt-email-topbar']; ?></span><?php
				break;

			case 'headertext': ?>
				<span class="top-bar-widgets"><?php echo $be_themes_data['opt-header-left-text']; ?></span><?php
				break;

			case 'menu': 
				be_themes_get_topbar_navigation();
				break;

			case 'search':
				$widget_style = (isset($be_themes_data['seach_widget_style']) && !empty($be_themes_data['seach_widget_style'])) ? $be_themes_data['seach_widget_style'] : 'style1-header-search-widget';
				if($widget_style == 'style2-header-search-widget') {
					be_themes_get_header_search_form_widget( true, false);
				} else {
					be_themes_get_header_search_form_widget( true, true);
				}
				break;

			case 'cart':	
				be_themes_get_header_woocommerce_cart_widget();
				break;

			case 'socialmedia': ?>
				<div class="top-bar-widgets"><?php
				echo do_shortcode( $be_themes_data['opt-smedia-topbar'] ) ;?>
				</div><?php
				break;
	
			default:
				# code...
				break;
		}
	}
}
/***************************************
			Main Header Widgets
***************************************/
if ( ! function_exists( 'be_themes_get_header_widgets' ) ) {
	function be_themes_get_header_widgets( $widget_type  ) {
		global $be_themes_data;

		switch ($widget_type) {
			case 'phone': ?>
				<span class="header-widgets"><?php echo  $be_themes_data['opt-phone-header']; ?></span><?php
				break;
			
			case 'email': ?>
				<span class="header-widgets"><?php echo $be_themes_data['opt-email-header']; ?></span><?php
				break;

			case 'headertext': ?>
				<span class="header-widgets"><?php echo $be_themes_data['opt-text-header']; ?></span><?php
				break;

			case 'menu': 
				be_themes_get_topbar_navigation();
				break;

			case 'search':
				$widget_style = (isset($be_themes_data['seach_widget_style']) && !empty($be_themes_data['seach_widget_style'])) ? $be_themes_data['seach_widget_style'] : 'style1-header-search-widget';
				if($widget_style == 'style2-header-search-widget') {
					be_themes_get_header_search_form_widget( true, false);
				} else {
					be_themes_get_header_search_form_widget( true, true);
				}
				break;

			case 'cart':	
				be_themes_get_header_woocommerce_cart_widget();
				break;

			case 'smenu':?>
				<!-- <div class="menu-controls sliderbar-menu-controller" title="Sidebar Menu Controller"><div class="font-icon custom-font-icon"><span class="menu-icon menu-icon-first"></span><span class="menu-icon menu-icon-second"></span><span class="menu-icon menu-icon-third"></span></div></div>--> 
				<div class="sliderbar-nav-controller-wrap"><div class="menu-controls sliderbar-menu-controller" title="Sidebar Menu Controller"><?php get_template_part( 'headers/header','hamburger' ); ?></div></div><?php
				break;

			case 'socialmedia': ?>
				<div class="header-code-widgets"><?php
				echo do_shortcode( $be_themes_data['opt-header-social-media'] ) ; ?>
				</div><?php
				break;
			default:
				# code...
				break;
		}
	}
}
/***************************************
			Header Cart Widget
***************************************/
if ( ! function_exists( 'be_themes_get_header_woocommerce_cart_widget' ) ) {
	function be_themes_get_header_woocommerce_cart_widget() {
		global $be_themes_data;
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {//&& $be_themes_data['header_cart_widget'] ) {
			global $woocommerce; ?>
			<div class="header-cart-controls">
				<a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'oshin'); ?>">
					<i class ="font-icon icon-icon_bag_alt"></i>
					<?php if ($woocommerce->cart->cart_contents_count) {?>
						<span><?php echo $woocommerce->cart->cart_contents_count;?></span><?php
					}?>
				</a>
				<div class="widget_shopping_cart_wrap">
					<?php the_widget('Be_Themes_WooCommerce_Widget_Cart'); ?>
				</div>
			</div> <?php
		}
	}
}
/***************************************
			Header Cart Widget
***************************************/
if ( ! function_exists( 'be_themes_get_left_header_woocommerce_cart_widget' ) ) {
	function be_themes_get_left_header_woocommerce_cart_widget() {
		global $be_themes_data;
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			global $woocommerce; ?>
			<div class="header-cart-controls">
				<a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'oshin'); ?>">
					<i class ="font-icon icon-icon_bag_alt"></i>
					<?php if ($woocommerce->cart->cart_contents_count) {?>
						<span><?php echo $woocommerce->cart->cart_contents_count;?></span><?php
					}?>
				</a>
			</div> <?php
		}
	}
}
/***************************************
			Header Search Widget
***************************************/
if ( ! function_exists( 'be_themes_get_header_search_form_widget' ) ) {
	function be_themes_get_header_search_form_widget( $icon = true, $widget = true) {
		global $be_themes_data; 
		$widget_style = (isset($be_themes_data['seach_widget_style']) && !empty($be_themes_data['seach_widget_style'])) ? $be_themes_data['seach_widget_style'] : 'style1-header-search-widget';
		if($icon) {
			echo '<div class="header-search-controls">';
			echo '<i class="search-button icon-search font-icon"></i>';
		}
		if($widget) {
			echo '<div class="search-box-wrapper '.esc_attr( $widget_style ).'">
				<a href="#" class="header-search-form-close"><i class="icon-icon_close font-icon"></i></a>
				<div class="search-box-inner1">
					<div class="search-box-inner2">';
						get_search_form();
			echo '</div>
				</div>
			</div>';
		}
		if($icon) {
			echo '</div>';
		}
	}
}

/**************** Check if a header widget position has a valid header widget *****************/

if( !function_exists( 'be_widget_array_has_active_widget' ) ) {
	function be_widget_array_has_atleast_one_active_widget( $widget_array ) {

		global $be_themes_data;	
		$header_style = isset( $be_themes_data[ 'opt-header-style' ] ) && !empty( $be_themes_data[ 'opt-header-style' ] ) ? $be_themes_data[ 'opt-header-style' ] : '';
		$new_header_styles = array('style7','style8','style9','style10','style11','style12','style13');
		$return = false;
		if( isset( $widget_array ) && !empty( $widget_array ) ) {
			foreach( $widget_array as $w_key => $w_value ) {
				switch( $w_key ) {
					case 'cart' : 
						if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
							$return = true;
							break 2;
						}
						break;
					case 'smenu' :
						if( !in_array( $header_style, $new_header_styles ) ) {
							$return = true;
							break 2;
						}
						break;
					case 'search' : 
						$return = true;
						break 2;
					case 'socialmedia' : 
						if( isset( $be_themes_data[ 'opt-header-social-media' ] ) && !empty( $be_themes_data[ 'opt-header-social-media' ] ) ) {
							$return = true;
							break 2;
						}
						break;
					case 'email' : 
						if( isset( $be_themes_data[ 'opt-email-header' ] ) && !empty( $be_themes_data[ 'opt-email-header' ] ) ) {
							
							$return = true;
							break 2;
						}
						break;
					case 'phone' :
						if( isset( $be_themes_data[ 'opt-phone-header' ] ) && !empty( $be_themes_data[ 'opt-phone-header' ] ) ) {
							
							$return = true;
							break 2;
						}
						break;
				}
			}
		}
		return $return;
		
	}
}

/********************************************************
			Check if header widget is empty 
*********************************************************/
if( !function_exists( 'be_top_has_active_widgets' ) ) {
	function be_top_has_active_widgets( $position = NULL ) {

		global $be_themes_data;
		$header_widgets_array = $be_themes_data[ 'opt-header-pos' ];
		$result = false;
		if( isset( $header_widgets_array ) 
		&& !empty( $header_widgets_array ) 
		&& array_key_exists( 'right', $header_widgets_array ) 
		&& array_key_exists( 'left', $header_widgets_array )
		&& isset( $header_widgets_array[ 'left' ] )
		&& isset( $header_widgets_array[ 'right' ] ) ) {
			$left_widget_array = $header_widgets_array[ 'left' ];
			$right_widget_array = $header_widgets_array[ 'right' ];
			if( is_null( $position ) ) {
				if( ( 1 < count( $left_widget_array ) && be_widget_array_has_atleast_one_active_widget( $left_widget_array ) ) || ( 1 < count( $right_widget_array ) && be_widget_array_has_atleast_one_active_widget( $right_widget_array ) ) ) {
					$result = true;
				}
			}else if( 'right' == $position ){
				if( 1 < count( $right_widget_array ) && be_widget_array_has_atleast_one_active_widget( $right_widget_array ) ) {
					$result = true;
				}
			}else if( 'left' == $position ) {
				if( 1 < count( $left_widget_array ) && be_widget_array_has_atleast_one_active_widget( $left_widget_array )  ) {
					$result = true;
				}
			}
		}
		return $result;

	}
}
/***************************************
			Header Border
***************************************/
if ( ! function_exists( 'be_themes_header_border' ) ) {
	function be_themes_header_border() {
		global $be_themes_data;
		if ( isset($be_themes_data['opt-header-type']) && ($be_themes_data['opt-header-border-color']['border-style'] != 'none') && ('top' == $be_themes_data['opt-header-type'] ) ) { ?>
			<span class="header-border <?php echo (($be_themes_data['opt-header-border-wrap']) ? 'be-wrap ' : '' );?>"></span><?php
		}
	}
}

/***************************************
			Add Body Class
***************************************/
if ( ! function_exists( 'be_themes_add_body_class' ) ) {
	function be_themes_add_body_class( $classes ) {
		global $post;		
		global $be_themes_data;
		
		$post_id = be_get_page_id();
		$sticky_sections = get_post_meta( $post_id, 'be_themes_sticky_sections', true );
		if( is_singular( 'post' ) && is_single($post_id) && isset( $be_themes_data[ 'single_blog_style' ] ) && !empty( $be_themes_data[ 'single_blog_style' ] ) ) {
			if( !empty( $be_themes_data[ 'single_wide_header_transparent' ] ) && isset( $be_themes_data[ 'single_wide_header_transparent' ] ) && 'none' != $be_themes_data[ 'single_wide_header_transparent' ] ) {
				$header_transparent = $be_themes_data[ 'single_wide_header_transparent' ];
			}else{
				$header_transparent = 0;
			}
			$header_sticky = get_post_meta($post_id, 'be_themes_sticky_header', true);
			$classes[] = 'be-wide-single-post';
		}else if(is_singular( 'post' ) && is_single($post_id) && isset($be_themes_data['single_blog_hero_section_from']) && $be_themes_data['single_blog_hero_section_from'] == 'inherit_option_panel') {
			if(!empty($be_themes_data['single_blog_header_transparent']) && isset($be_themes_data['single_blog_header_transparent']) && $be_themes_data['single_blog_header_transparent'] ) {
				$header_transparent = $be_themes_data['single_blog_header_transparent'];
				$header_sticky = $be_themes_data['single_blog_header_sticky'];
			} else {
				$header_transparent = 0;
				$header_sticky = 0;
			}
		} else if((in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_product($post_id)) && isset($be_themes_data['single_shop_hero_section_from']) && $be_themes_data['single_shop_hero_section_from'] == 'inherit_option_panel') {
			if(!empty($be_themes_data['single_shop_header_transparent']) && isset($be_themes_data['single_shop_header_transparent']) && $be_themes_data['single_shop_header_transparent'] ) {
				$header_transparent = $be_themes_data['single_shop_header_transparent'];
				$header_sticky = $be_themes_data['single_shop_header_sticky'];
			} else {
				$header_transparent = 0;
				$header_sticky = 0;
			}
		} else {
			$header_transparent = get_post_meta($post_id, 'be_themes_header_transparent', true);
			$header_sticky = get_post_meta($post_id, 'be_themes_sticky_header', true);
		}

		/*****Single Post Transparent Header settings saved in particular post************/
		$post_header_transparent = get_post_meta($post_id, 'be_themes_header_transparent', true);
		$post_header_sticky = get_post_meta($post_id, 'be_themes_sticky_header', true);
		if(!empty($post_header_transparent) && $post_header_transparent !== $header_transparent && $post_header_transparent != 'none'){
			$header_transparent = $post_header_transparent;
		}
		if(!empty($post_header_sticky) && $post_header_sticky !== $header_sticky && $post_header_sticky != 'inherit'){
			$header_sticky = $post_header_sticky;
		}

		if ( isset($be_themes_data['opt-header-type']) && ('top' == $be_themes_data['opt-header-type'] ) && empty( $sticky_sections ) ){
			if($header_sticky == 'inherit' || empty($header_sticky)) {
				if(!empty($header_transparent) && isset($header_transparent) && ('none' != $header_transparent) )  {
					if( isset( $be_themes_data['sticky_header'] ) && 1 == $be_themes_data['sticky_header'] )  {
						$classes[] = 'transparent-sticky';
					}
				} else {
					if( isset( $be_themes_data['sticky_header'] ) && 1 == $be_themes_data['sticky_header'] )  {
						$classes[] = 'sticky-header';
					}
				}
			} else if($header_sticky == 'yes') {
				if(!empty($header_transparent) && isset($header_transparent) && ('none' != $header_transparent)) {
					$classes[] = 'transparent-sticky';
				} else {
					$classes[] = 'sticky-header';
				}
			}			
		}
		if ( isset($be_themes_data['opt-header-type']) && ('top' == $be_themes_data['opt-header-type'] ) && empty( $sticky_sections ) ){
			if($post_id == 0) {
				if( (isset( $be_themes_data['sticky_header'] ) && 1 == $be_themes_data['sticky_header'] ) ) {
					$classes[] = 'sticky-header';
				}
			}
		}
		if(!empty($header_transparent) && isset($header_transparent)) {
			if( 'top' == $be_themes_data['opt-header-type'] ){
				if ('transparent' == $header_transparent){
					$classes[] = 'header-transparent';
				}
				if ('semitransparent' == $header_transparent){
					$classes[] = 'header-transparent';
					$classes[] = 'semi';
				}
			}
			if( 'none' == $header_transparent ){
				$classes[] = 'header-solid';
			}
		} else {
			$classes[] = 'header-solid';
		}
		$section_scroll = get_post_meta($post_id, 'be_themes_section_scroll', true);
		if( isset( $sticky_sections ) && !empty( $sticky_sections ) ) {
			$section_scroll = false;
		}
		if(!empty($section_scroll) && isset($section_scroll) && $section_scroll ) {
			$classes[] = 'section-scroll';
		} else {
			$classes[] = 'no-section-scroll';
		}
		$single_page_version = get_post_meta($post_id, 'be_themes_single_page_version', true);
		if( isset( $sticky_sections ) && !empty( $sticky_sections ) ) {
			$single_page_version = false;
		}
		if(!empty($single_page_version) && isset($single_page_version) && $single_page_version) {
			$classes[] = 'single-page-version';
		}
		if ( isset($be_themes_data['opt-header-type']) && ('left' == $be_themes_data['opt-header-type'] ) ) {
			$classes[] = 'left-header';
			$left_header_style = basename($be_themes_data['left-header-style'],'.jpg');
			if ( isset($be_themes_data['left-header-style']) && ('strip' == $left_header_style ) ) {
				$classes[] = 'left-sliding';
				$classes[] = 'left-bar-menu';
			}elseif ( isset($be_themes_data['left-header-style']) && ('overlay' == $left_header_style ) ) {
				$classes[] = 'left-sliding';
				$classes[] = 'left-overlay-menu';
			}
			elseif ( isset($be_themes_data['left-header-style']) && ('static' == $left_header_style ) ){
				$classes[] = 'left-static';
			}
			elseif ( be_is_special_left_menu() ) {
				$classes[] = $left_header_style;
			}
		}elseif ( isset($be_themes_data['opt-header-type']) && ('top' == $be_themes_data['opt-header-type'] ) ) { 
				$classes[] = 'top-header';
			if( !be_is_special_left_menu() && !be_is_special_top_menu() && !be_is_special_top_menu( 'menu-animate-fall' ) ){
				if ( isset($be_themes_data['top-menu-style']) && !empty($be_themes_data['top-menu-style']) ) {
					$classes[] = $be_themes_data['top-menu-style'];
				} else{
					$classes[] = 'top-right-sliding-menu';	
				}
			}
			if ( isset( $be_themes_data['opt-menu-style'] ) && !empty($be_themes_data['opt-menu-style']) && ( be_is_special_top_menu() || be_is_special_top_menu( 'menu-animate-fall' ) ) ){
				$classes[] = basename($be_themes_data['opt-menu-style'],'.jpg');
			}
		}
		if ( is_singular( 'portfolio' ) || is_page_template( 'gallery.php' ) || is_page_template( 'portfolio.php' )) {
			$single_portfolio_style = get_post_meta(get_the_ID(), 'be_themes_portfolio_single_page_style', true);
			if ($single_portfolio_style == 'style1' || $single_portfolio_style == 'style2' || $single_portfolio_style == 'style3' || $single_portfolio_style == 'style4') {
				$classes[] = 'custom-gallery-page';
			}
		}
		if( is_singular( 'portfolio' ) ) {
			$portfolio_single_style = get_post_meta( $post->ID, 'be_themes_portfolio_single_page_style', true );
			if( isset( $portfolio_single_style ) && !empty( $portfolio_single_style ) && ( 'fixed-left' == $portfolio_single_style || 'fixed-right' == $portfolio_single_style || 'fixed-overflow-left' == $portfolio_single_style || 'fixed-overflow-right' == $portfolio_single_style ) ) {
				$classes[] = 'be-single-portfolio-fixed';
			}
		}
		if( isset( $be_themes_data['all_ajax'] ) && 1 == $be_themes_data['all_ajax'] && !(in_array( 'revslider/revslider.php', apply_filters( 'active_plugins', get_option( 'active_plugins' )))) && !(in_array( 'masterslider/masterslider.php', apply_filters( 'active_plugins', get_option( 'active_plugins' )))) ) {
			$classes[] = 'all-ajax-content';
		}
		if(isset($be_themes_data['layout']) && !empty($be_themes_data['layout'])) {
			//Only wide layout is allowed for the new header styles. Hence check and allow other layouts for old styles alone.
			if( be_is_special_left_menu() || be_is_special_top_menu() || be_is_special_top_menu( 'menu-animate-fall' ) ){
				$classes[] = 'be-themes-layout-layout-wide';
			} else {
				if('left' == $be_themes_data['opt-header-type'] && 'layout-box' == $be_themes_data['layout']){
					$classes[] = 'be-themes-layout-layout-wide'; //Overriding Box Layout setting for Left Header 
				}else{
					$classes[] = 'be-themes-layout-'.$be_themes_data['layout'];
				}
			}
		}
		if(isset($be_themes_data['rev_slider_bg_check']) && !empty($be_themes_data['rev_slider_bg_check']) && 1 == $be_themes_data['rev_slider_bg_check']) {
			$classes[] = 'disable_rev_slider_bg_check';
		}
		if(isset($be_themes_data['disable_css_animation_mobile']) && !empty($be_themes_data['disable_css_animation_mobile']) && 1 == $be_themes_data['disable_css_animation_mobile']) {
			$classes[] = 'disable-css-animation-mobile';
		}
		if(isset($be_themes_data['button_shape']) && !empty($be_themes_data['button_shape']) && $be_themes_data['button_shape'] != 'none' ) {
			$classes[] = 'button-shape-'.$be_themes_data['button_shape'];
		}
		if( !$be_themes_data['site_status'] ) {
			$classes[] = 'opt-panel-cache-off';
		}else{
			$classes[] = 'opt-panel-cache-on';
		}
		if( be_is_special_top_menu( 'special-left-menu' ) || be_is_special_top_menu( 'special-right-menu' ) ){
			if( isset( $be_themes_data['side_menu_style'] ) && !empty( $be_themes_data['side_menu_style'] ) ){
				$classes[] = $be_themes_data['side_menu_style'];
			}
		}
		if( be_is_special_left_menu( 'left-strip-menu' ) ){
			if( isset( $be_themes_data['left-strip-animation'] ) && !empty( $be_themes_data['left-strip-animation'] ) ){
				$classes[] = $be_themes_data['left-strip-animation'];
			}
		}
		if( be_is_special_top_menu( 'overlay-center-align-menu' ) || be_is_special_top_menu( 'overlay-horizontal-menu' ) || be_is_special_top_menu( 'page-stack-top' ) ){
			if( !empty( $be_themes_data['menu_and_widget_color_top_menu_open']  ) && isset( $be_themes_data['menu_and_widget_color_top_menu_open'] ) ){
				$classes[] = 'be-menu-scheme-'.$be_themes_data['menu_and_widget_color_top_menu_open'];
			} else {
				$classes[] = 'be-menu-scheme-light';
			}
		}
		//Fixed footer
		if( isset( $be_themes_data[ 'fixed-footer' ] ) && !empty( $be_themes_data[ 'fixed-footer' ] ) && be_is_fixed_footer_possible() ) {
			$classes[] = 'be-fixed-footer';
		}
		//Sticky Sections
		$sticky_sections = get_post_meta($post_id, 'be_themes_sticky_sections', true);
		if( isset( $sticky_sections ) && !empty( $sticky_sections ) ) {
			$classes[] = 'be-sticky-sections';
		}
		return $classes;
	}
	add_filter('body_class','be_themes_add_body_class');
}
/* ---------------------------------- */
// Get Image Dimension 
/* ---------------------------------- */
if (!function_exists( 'be_themes_get_image_dimension' )) {
 function be_themes_get_image_dimension($src){
	$image_id = get_attachment_id_from_src($src);
	$filetype = wp_check_filetype($src);
	$image_dimension = array();
	if(!empty($filetype['ext']) && $filetype['ext']=='svg'){
		$image_meta = get_metadata('post',$image_id,'_wp_attachment_metadata',true);
		if(!empty($image_meta) && !empty($image_meta['width']) && !empty($image_meta['height'])){
			$image_dimension = array($src,$image_meta['width'],$image_meta['height']);
		}
	}

	if(empty($image_dimension)){
		$image_dimension = wp_get_attachment_image_src($image_id, 'full');
	}
	return $image_dimension;
 }
}
/* ---------------------------------- */
// Calculate Logo Height 
/* ---------------------------------- */

if (!function_exists( 'be_themes_calculate_logo_height' )) {
	function be_themes_calculate_logo_height(){
		global $be_themes_data, $post;
		$padding = ('' != $be_themes_data['opt-logo-padding']) ? 2*(str_replace('px', '', $be_themes_data['opt-logo-padding']) ) : 40;
		$result = array();
		$logo_height = $logo_sticky_height = $logo_transparent_height = $logo_dark_height = $logo_light_height = 50;
		
		if((!isset($be_themes_data['disable_logo']) || empty($be_themes_data['disable_logo'])) || (isset($be_themes_data['disable_logo']) && (0 == $be_themes_data['disable_logo'])) ){
			$logo_src = (isset($be_themes_data['logo']['url']) && !empty($be_themes_data['logo']['url'])) ? $be_themes_data['logo']['url'] : get_template_directory_uri().'/img/logo.png';
			$logo_sticky_src = (isset($be_themes_data['logo_sticky']['url']) && !empty($be_themes_data['logo_sticky']['url'])) ? $be_themes_data['logo_sticky']['url'] : $logo_src;
			$header_transparent_color_scheme = '';
			if( !empty( $post ) ) {
				$hero_section = get_post_meta($post->ID, 'be_themes_hero_section', true);
				$sticky_sections = get_post_meta($post->ID, 'be_themes_sticky_section', true);
				if( isset( $sticky_sections ) && !empty( $sticky_sections ) ) {
					$hero_section = 'none';
				}
				if( is_singular( 'post' ) && is_single($post->ID) && isset( $be_themes_data[ 'single_blog_style' ] ) && !empty( $be_themes_data[ 'single_blog_style' ] ) ) {
					if( !empty( $be_themes_data[ 'single_wide_navigation_color_scheme' ] ) && isset( $be_themes_data[ 'single_wide_navigation_color_scheme' ] ) ) {
						$header_transparent_color_scheme = $be_themes_data[ 'single_wide_navigation_color_scheme' ];
					}else{
						$header_transparent_color_scheme = 'dark';
					}
				}else if( isset( $hero_section ) && !empty( $hero_section ) && 'none' != $hero_section ) {
					$header_transparent_color_scheme = get_post_meta( $post->ID , 'be_themes_header_transparent_color_scheme', true);
				}else {
					$pattern = get_shortcode_regex();
					if (  preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches ) && array_key_exists( 2, $matches ) && in_array( 'tatsu_section', $matches[2] ) && isset( $matches[ 3 ] ) && !empty( $matches[ 3 ] ) ) {
						$shortcode_atts = shortcode_parse_atts( $matches[3][0] );
						if( !empty( $shortcode_atts ) && array_key_exists( 'full_screen_header_scheme', $shortcode_atts ) ) {
							$first_section_header_background_scheme = $shortcode_atts[ 'full_screen_header_scheme' ];
							if( 'background--light' == $first_section_header_background_scheme ) {
								$header_transparent_color_scheme = 'dark';
							}else if( 'background--dark' == $first_section_header_background_scheme ) {
								$header_transparent_color_scheme = 'light';
							}
						}
					}				
				}
			}
			if( 'dark' == $header_transparent_color_scheme ){
				$logo_transparent_src = (isset($be_themes_data['logo_transparent']['url']) && !empty($be_themes_data['logo_transparent']['url'])) ? $be_themes_data['logo_transparent']['url'] : $logo_src;
			} else if ( 'light' == $header_transparent_color_scheme ){
				$logo_transparent_src = (isset($be_themes_data['logo_transparent_light']['url']) && !empty($be_themes_data['logo_transparent_light']['url'])) ? $be_themes_data['logo_transparent_light']['url'] : $logo_src;
			} else if( empty( $header_transparent_color_scheme ) || 'none' == $header_transparent_color_scheme ){
				$logo_transparent_src = $logo_src;
			}
			$logo_dark_src = (isset($be_themes_data['logo_transparent']['url']) && !empty($be_themes_data['logo_transparent']['url'])) ? $be_themes_data['logo_transparent']['url'] : $logo_src;
			$logo_light_src = (isset($be_themes_data['logo_transparent_light']['url']) && !empty($be_themes_data['logo_transparent_light']['url'])) ? $be_themes_data['logo_transparent_light']['url'] : $logo_src;

			if((!empty($be_themes_data['opt-logo-max-width']) && is_numeric($be_themes_data['opt-logo-max-width'])) || (!empty($be_themes_data['opt-logo-max-width-mobile']) && is_numeric($be_themes_data['opt-logo-max-width-mobile']))){ 
				$logo = be_themes_get_image_dimension($logo_src);
				$logo_sticky = be_themes_get_image_dimension($logo_sticky_src);
				$logo_transparent = be_themes_get_image_dimension($logo_transparent_src);
				$logo_dark = be_themes_get_image_dimension( $logo_dark_src );
				$logo_light = be_themes_get_image_dimension( $logo_light_src );
			}else{
				$logo_id = get_attachment_id_from_src($logo_src);
				$logo = wp_get_attachment_image_src($logo_id, 'full');
				$logo_sticky_id = get_attachment_id_from_src($logo_sticky_src);
				$logo_sticky = wp_get_attachment_image_src($logo_sticky_id, 'full');
				$logo_transparent_id = get_attachment_id_from_src($logo_transparent_src);
				$logo_dark_id = get_attachment_id_from_src( $logo_dark_src );
				$logo_dark = wp_get_attachment_image_src( $logo_dark_id, 'full' );
				$logo_light_id = get_attachment_id_from_src( $logo_light_src );
				$logo_light = wp_get_attachment_image_src( $logo_light_id, 'full' );
				$logo_transparent = wp_get_attachment_image_src($logo_transparent_id, 'full');
			}
			if( isset( $logo[2] ) || !empty( $logo[2] ) ) {
			  $logo_height = $logo[2];
			  $logo_width = $logo[1];
			}
			if( isset( $logo_dark[2] ) || !empty( $logo_dark[2] ) ) {
				$logo_dark_height = $logo_dark[ 2 ];
				$logo_dark_width = $logo_dark[ 1 ];
			}
			if( isset( $logo_light[ 2 ] ) || !empty( $logo_light[ 2 ] ) ) {
				$logo_light_height = $logo_light[ 2 ];
				$logo_light_width = $logo_light[ 1 ];
			}
			if( isset( $logo_sticky[2] ) || !empty( $logo_sticky[2] ) ) {
			  $logo_sticky_height = $logo_sticky[2];
			  $logo_sticky_width  = $logo_sticky[1];
			}
			if( isset( $logo_transparent[2] ) || !empty( $logo_transparent[2] ) ) {
			  $logo_transparent_height = $logo_transparent[2];
			  $logo_transparent_width = $logo_transparent[1];
			}
		}else{
			$nav_text_height = isset($be_themes_data['navigation_text']['font-size']) ? $be_themes_data['navigation_text']['font-size'] : 0;
			$logo_height = $logo_sticky_height = $logo_transparent_height = intval($nav_text_height);
		}

		//Calculate logo height and reinitialize if admin set logo max width for mobile
		if(!empty($be_themes_data['opt-logo-max-width-mobile']) && is_numeric($be_themes_data['opt-logo-max-width-mobile'])){ 
			$logo_max_width = intval($be_themes_data['opt-logo-max-width-mobile']);
			$result['logo_max_width_mobile'] =$logo_max_width;
			$result['logo_height_mobile'] = $padding + $logo_height;
			$result['logo_sticky_height_mobile'] = $padding + $logo_sticky_height;
			$result['logo_transparent_height_mobile'] = $padding + $logo_transparent_height;
			$result[ 'logo_light_height_mobile' ] = $padding + $logo_light_height;
			$result[ 'logo_dark_height_mobile' ] = $padding + $logo_dark_height;
			if(!empty($logo_height) && !empty($logo_width) && $logo_width>$logo_max_width){
				$result['logo_height_mobile'] = $padding + intval($logo_max_width*($logo_height/$logo_width));
			}
			if(!empty($logo_sticky_height) && !empty($logo_sticky_width) && $logo_sticky_width>$logo_max_width){
				$result['logo_sticky_height_mobile'] = $padding + intval($logo_max_width*($logo_sticky_height/$logo_sticky_width));
			}
			if(!empty($logo_transparent_height) && !empty($logo_transparent_width) && $logo_transparent_width>$logo_max_width){
				$result['logo_transparent_height_mobile'] =$padding + intval($logo_max_width*($logo_transparent_height/$logo_transparent_width));
			}
			if(!empty($logo_light_height) && !empty($logo_light_width) && $logo_light_width>$logo_max_width){
				$result['logo_light_height_mobile'] =$padding + intval($logo_max_width*($logo_light_height/$logo_light_width));
			}
			if(!empty($logo_dark_height) && !empty($logo_dark_width) && $logo_dark_width>$logo_max_width){
				$result['logo_dark_height_mobile'] =$padding + intval($logo_max_width*($logo_dark_height/$logo_dark_width));
			}	
			
		}
		
		//Calculate logo height and reinitialize if admin set logo max width
		if(!empty($be_themes_data['opt-logo-max-width']) && is_numeric($be_themes_data['opt-logo-max-width'])){ 
			$logo_max_width = intval($be_themes_data['opt-logo-max-width']);
			if(!empty($logo_height) && !empty($logo_width) && $logo_width>$logo_max_width){
				$logo_height =intval($logo_max_width*($logo_height/$logo_width));
			}
			if(!empty($logo_sticky_height) && !empty($logo_sticky_width) && $logo_sticky_width>$logo_max_width){
				$logo_sticky_height =intval($logo_max_width*($logo_sticky_height/$logo_sticky_width));
			}
			if(!empty($logo_transparent_height) && !empty($logo_transparent_width) && $logo_transparent_width>$logo_max_width){
				$logo_transparent_height =intval($logo_max_width*($logo_transparent_height/$logo_transparent_width));
			}
			if(!empty($logo_light_height) && !empty($logo_light_width) && $logo_light_width>$logo_max_width){
				$logo_light_height =intval($logo_max_width*($logo_light_height/$logo_light_width));
			}
			if(!empty($logo_dark_height) && !empty($logo_dark_width) && $logo_dark_width>$logo_max_width){
				$logo_dark_height =intval($logo_max_width*($logo_dark_height/$logo_dark_width));
			}	
			
		}
		
		$result['logo_sticky_height'] = $padding + $logo_sticky_height;
		$result['logo_height'] = $padding + $logo_height;
		$result['logo_height_original'] = $logo_height;
		$result['logo_transparent_height'] = $padding + $logo_transparent_height;
		$result[ 'logo_light_height' ] = $padding + $logo_light_height;
		$result[ 'logo_dark_height' ] = $padding + $logo_dark_height;
		return $result;
	}
}

if (!function_exists( 'be_themes_calculate_logo_width' )) {
	function be_themes_calculate_logo_width(){
		global $be_themes_data;
		$result = array();
		$logo_src = (! empty($be_themes_data['logo']['url'])) ? $be_themes_data['logo']['url'] : get_template_directory_uri().'/img/logo.png';;
		//$logo_transparent_src = $be_themes_data['logo_transparent']['url'];
		if( array_key_exists( 'logo_transparent', $be_themes_data ) ) {
			$logo_transparent_src = $be_themes_data['logo_transparent']['url'];
		}
		if( empty( $logo_transparent_src ) ) {
			$logo_transparent_src = $logo_src;
		}
		$logo_id = get_attachment_id_from_src($logo_src);
		$logo_transparent_id = get_attachment_id_from_src($logo_transparent_src);
		$logo = wp_get_attachment_image_src($logo_id, 'full');
		$logo_transparent = wp_get_attachment_image_src($logo_transparent_id, 'full');
		$logo_width = $logo_transparent_width = 250;
		$logo_attachment_flag = 0;
		if( isset( $logo[1] ) || !empty( $logo[1] ) ) {
		  $logo_width = $logo[1];
		  $logo_attachment_flag = 1;
		}
		if( isset( $logo_transparent[1] ) || !empty( $logo_transparent[1] ) ) {
		  $logo_transparent_width = $logo_transparent[1];
		}

		if(empty($logo_width) && ((!empty($be_themes_data['opt-logo-max-width-mobile']) && is_numeric($be_themes_data['opt-logo-max-width-mobile'])) || (!empty($be_themes_data['opt-logo-max-width']) && is_numeric($be_themes_data['opt-logo-max-width']))) ){
			$logo = be_themes_get_image_dimension($logo_src);
			if( isset( $logo[1] ) || !empty( $logo[1] ) ) {
				$logo_width = $logo[1];
				$logo_attachment_flag = 1;
			}
		}
		//Reinitialize logo width if admin set logo max width
		if(!empty($be_themes_data['opt-logo-max-width']) && is_numeric($be_themes_data['opt-logo-max-width'])){ 
			$logo_max_width = intval($be_themes_data['opt-logo-max-width']);
			$logo_width = ($logo_width>$logo_max_width)?$logo_max_width:$logo_width;
			$logo_transparent_width = ($logo_transparent_width>$logo_max_width)?$logo_max_width:$logo_transparent_width;
		}
		$result['logo_attachment_flag'] = $logo_attachment_flag;
		$result['logo_width'] = $logo_width;
		$result['logo_transparent_width'] = $logo_transparent_width;
		return $result;
	}
}

/***************************************
			Navigations
***************************************/
// MAIN NAVIGATION
if ( ! function_exists( 'be_themes_get_header_navigation' ) ) {
	function be_themes_get_header_navigation() {
		$be_themes_enable_main_nav = apply_filters('be_themes_enable_main_nav', true );
		if( $be_themes_enable_main_nav ) {
			global $be_themes_data;
			$nav_link_style = (isset($be_themes_data['nav_link_style']) && !empty($be_themes_data['nav_link_style'])) ? $be_themes_data['nav_link_style'] : '';

			$menu_depth = (isset($be_themes_data['opt-menu-level']) && !empty($be_themes_data['opt-menu-level'])) ? $be_themes_data['opt-menu-level'] : 3;

			$menu_class = 'clearfix ' . $nav_link_style ;
			$defaults = array (
				'theme_location'=>'main_nav',
				'depth'=>$menu_depth,
				'container_class'=>'menu',
				'menu_id' => 'menu',
				'menu_class' => $menu_class,
				'echo' => true,
				'fallback_cb' => 'be_themes_fallback_nav_menu',
				'walker' => new Be_Themes_Walker_Nav_Menu()
			);
			wp_nav_menu( $defaults );
		}
	}
}
// CENTER LOGO MAIN NAVIGATION - LEFT
if ( ! function_exists( 'be_themes_get_header_left_navigation' ) ) {
	function be_themes_get_header_left_navigation() {
		$be_themes_enable_left_nav = apply_filters('be_themes_enable_left_nav', true );
		if( $be_themes_enable_left_nav ) {
			global $be_themes_data;
			$nav_link_style = (isset($be_themes_data['nav_link_style']) && !empty($be_themes_data['nav_link_style'])) ? $be_themes_data['nav_link_style'] : '';
			$menu_depth = (isset($be_themes_data['opt-menu-level']) && !empty($be_themes_data['opt-menu-level'])) ? $be_themes_data['opt-menu-level'] : 3;

			$menu_class = 'clearfix ' . $nav_link_style ;
			$defaults = array (
				'theme_location'=>'main_left_nav',
				'depth'=>$menu_depth,
				'container_class'=>'menu',
				'menu_id' => 'left-menu',
				'menu_class' => $menu_class,
				'echo' => true,
				'fallback_cb' => 'be_themes_fallback_nav_menu',
				'walker' => new Be_Themes_Walker_Nav_Menu()
			);
			wp_nav_menu( $defaults );
		}
	}
}
// CENTER LOGO MAIN NAVIGATION - RIGHT
if ( ! function_exists( 'be_themes_get_header_right_navigation' ) ) {
	function be_themes_get_header_right_navigation() {
		$be_themes_enable_right_nav = apply_filters('be_themes_enable_right_nav', true );
		if( $be_themes_enable_right_nav ) {
			global $be_themes_data;
			$nav_link_style = (isset($be_themes_data['nav_link_style']) && !empty($be_themes_data['nav_link_style'])) ? $be_themes_data['nav_link_style'] : '';
			$menu_depth = (isset($be_themes_data['opt-menu-level']) && !empty($be_themes_data['opt-menu-level'])) ? $be_themes_data['opt-menu-level'] : 3;
			$menu_class = 'clearfix ' . $nav_link_style ;
			$defaults = array (
				'theme_location'=>'main_right_nav',
				'depth'=>$menu_depth,
				'container_class'=>'menu',
				'menu_id' => 'right-menu',
				'menu_class' => $menu_class,
				'echo' => true,
				'fallback_cb' => 'be_themes_fallback_nav_menu',
				'walker' => new Be_Themes_Walker_Nav_Menu()
			);
			wp_nav_menu( $defaults );
		}
	}
}
// LEFT AND RIGHT SIDEBAR MENU
if ( ! function_exists( 'be_themes_get_header_sidebar_navigation' ) ) {
	function be_themes_get_header_sidebar_navigation() {
		global $be_themes_data;
		$menu_depth = (isset($be_themes_data['opt-menu-level']) && !empty($be_themes_data['opt-menu-level'])) ? $be_themes_data['opt-menu-level'] : 3;
		$menu_loc = 'sidebar_nav'; 
		$menu_class = 'clearfix ';
		$container_class = 'menu';
		$fallback_cb = '';
		if (('left' == $be_themes_data['opt-header-type'] )  || (( 'top' == $be_themes_data['opt-header-type'] ) && ($be_themes_data['top-menu-style'] != 'none') ) || ( be_is_special_top_menu() ) ) {
			$menu_loc = 'main_nav';
		}
		if( be_is_special_top_menu() || be_is_special_left_menu() ){
			$container_class = 'special-header-menu';
			$menu_class = 'menu-container';
			$fallback_cb = 'be_themes_fallback_nav_menu';
		}
		$defaults = array (
			'theme_location'=> $menu_loc,
			'depth'=> $menu_depth,
			'container_class'=> $container_class,
			'menu_id' => 'slidebar-menu',
			'menu_class' => $menu_class,
			'fallback_cb' => $fallback_cb,
			'walker' => new Be_Themes_Walker_Nav_Menu()
		);
		wp_nav_menu( $defaults );
	}
}
// MOBILE MENU
if ( ! function_exists( 'be_themes_get_header_mobile_navigation' ) ) {
	function be_themes_get_header_mobile_navigation() {
		global $be_themes_data;
		$menu_depth = (isset($be_themes_data['opt-menu-level']) && !empty($be_themes_data['opt-menu-level'])) ? $be_themes_data['opt-menu-level'] : 3;
		echo "<div class='header-mobile-navigation clearfix'>";
		if(basename($be_themes_data['opt-header-style'], '.png') == 'style6' ) {
			$defaults = array (
				'theme_location'=>'main_left_nav',
				'depth'=> $menu_depth,
				'container_class'=> 'mobile-menu left-mobile-menu',
				'menu_id' => 'mobile-menu',
				'menu_class' => 'clearfix',
				'fallback_cb' => '',
				'walker' => new Be_Themes_Walker_Mobile_Menu()
			);
			wp_nav_menu( $defaults );
			$defaults = array (
				'theme_location'=>'main_right_nav',
				'depth'=> $menu_depth,
				'container_class'=> 'mobile-menu right-mobile-menu',
				'menu_id' => 'mobile-menu',
				'menu_class' => 'clearfix',
				'fallback_cb' => '',
				'walker' => new Be_Themes_Walker_Mobile_Menu()
			);
			wp_nav_menu( $defaults );
		} else {
			$defaults = array (
				'theme_location'=> 'main_nav',
				'depth'=> $menu_depth,
				'container_class'=> 'mobile-menu',
				'menu_id' => 'mobile-menu',
				'menu_class' => 'clearfix',
				'fallback_cb' => '',
				'walker' => new Be_Themes_Walker_Mobile_Menu()
			);
			wp_nav_menu( $defaults );
		}
		echo "</div>";
	}
}
// TOPBAR MENU
if ( ! function_exists( 'be_themes_get_topbar_navigation' ) ) {
	function be_themes_get_topbar_navigation() {
		$menu_depth = (isset($be_themes_data['opt-menu-level']) && !empty($be_themes_data['opt-menu-level'])) ? $be_themes_data['opt-menu-level'] : 3;
		$defaults = array (
			'theme_location'=> 'topbar_nav',
			'depth'=> $menu_depth,
			'container_class'=> 'topbar-menu-container',
			'menu_id' => 'topbar-menu',
			'menu_class' => 'clearfix',
			'fallback_cb' => '',
			'walker' => new Be_Themes_Walker_Nav_Menu()
		);
		wp_nav_menu( $defaults );
	}
}
// FOOTER MENU
if ( ! function_exists( 'be_themes_get_footer_navigation' ) ) {
	function be_themes_get_footer_navigation() {
		$menu_depth = (isset($be_themes_data['opt-menu-level']) && !empty($be_themes_data['opt-menu-level'])) ? $be_themes_data['opt-menu-level'] : 3;

		$defaults = array (
			'theme_location'=> 'footer_nav',
			'depth'=> $menu_depth,
			'container_class'=> 'footer-menu-container',
			'menu_id' => 'footer-menu',
			'menu_class' => 'clearfix',
			'fallback_cb' => '',
			'walker' => new Be_Themes_Walker_Nav_Menu()
			//'link_after' => '<span class="mobile-sub-menu-controller"><i class="icon-icon_plus"></i></span>'
		);
		wp_nav_menu( $defaults );
	}
}
if (!function_exists( 'be_themes_fallback_nav_menu' )) {
	function be_themes_fallback_nav_menu(){
		// $args = array (
		// 	'sort_column' => 'menu_order, post_title',
		// 	'menu_class'  => 'menu left',
		// 	'include'     => '',
		// 	'exclude'     => '',
		// 	'echo'        => true,
		// 	'show_home'   => false,
		// 	'link_before' => '',
		// 	'link_after'  => '' 
		// );
		// wp_page_menu($args);
		echo '<a href="'.admin_url("nav-menus.php").'">SET THE MAIN MENU</a>';
	}
}

if ( !class_exists('Be_Themes_Walker_Nav_Menu') ) {
    class Be_Themes_Walker_Nav_Menu extends Walker_Nav_Menu {
		function start_lvl(&$output, $depth=0, $args=array()) {
			$indent = str_repeat("\t", $depth);
			global $be_themes_data;
			// if( ( be_is_special_top_menu() && ( 'newMultilevelMenu' == basename( $be_themes_data['top-header-submenu-style'], '.png' ) ) ) || ( be_is_special_left_menu() && ( 'newMultilevelMenu' == basename( $be_themes_data['left-header-submenu-style'], '.png' ) ) ) || be_is_special_top_menu( 'page-stack-top' ) || be_is_special_top_menu( 'overlay-horizontal-menu' ) ){
			if( ( be_is_special_top_menu() && ( 'newMultilevelMenu' == be_themes_get_submenu() ) ) || ( be_is_special_left_menu() && ( 'newMultilevelMenu' == be_themes_get_submenu() ) ) || be_is_special_top_menu( 'page-stack-top' ) || be_is_special_top_menu( 'overlay-horizontal-menu' ) ){
				$output .= "\n$indent<span class=\"sub-menu-controller\"><i class=\"icon-multi-menu\"></i></span><ul class=\"sub-menu\">\n";
			} else {
				$output .= "\n$indent<span class=\"mobile-sub-menu-controller\"><i class=\"icon-icon_plus\"></i></span><ul class=\"sub-menu clearfix\">\n";
			}
		}
	}
}
if ( !class_exists('Be_Themes_Walker_Mobile_Menu') ) {
    class Be_Themes_Walker_Mobile_Menu extends Walker_Nav_Menu {
		function start_lvl(&$output, $depth=0, $args=array()) {
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<span class=\"mobile-sub-menu-controller\"><i class=\"icon-arrow-right5\"></i></span><ul class=\"sub-menu clearfix\">\n";
		}
	}
}
// if ( !class_exists('Be_Themes_Walker_Nav_Mobile_Menu') ) {
//     class Be_Themes_Walker_Nav_Mobile_Menu extends Walker_Nav_Menu {
// 		function start_lvl(&$output, $depth=0, $args=array()) {
// 			$indent = str_repeat("\t", $depth);
// 			$output .= "\n$indent<span class=\"mobile-sub-menu-controller\"><i class=\"icon-arrow-right5\"></i></span><ul class=\"sub-menu clearfix\">\n";
// 		}
// 	}
// }
if (!function_exists( 'be_themes_change_wp_title' )) {
	function be_themes_change_wp_title( $title, $sep ) {
		global $paged, $page;
		if ( is_feed() )
			return $title;
		// Add the site name.
		$title .= get_bloginfo( 'name' );
		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";
		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', 'oshin' ), max( $paged, $page ) );
		return $title;
	}
	add_filter( 'wp_title', 'be_themes_change_wp_title', 10, 2 );
}

if( !function_exists('be_themes_protocol_based_urls') ) {
	function be_themes_protocol_based_urls( $url ) {
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https:" : "http:";
		return $protocol. str_replace( array( 'http:', 'https:' ), '', $url );
	}
}
?>