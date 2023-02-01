<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tatsu_Builder {

	private $plugin_name;

	private $version;

	private $post_id;

	private $builder_mode;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	
	public function init() {

		if ( isset( $_GET['id'] ) ) {
			$this->post_id = be_sanitize_text_field($_GET['id']);
		} else if( isset( $_GET['post'] ) ) {
            $this->post_id = be_sanitize_text_field($_GET['post']);
        } else {
			$queried_object = get_queried_object();
			if( is_object( $queried_object ) && isset($queried_object->ID) ) {
				$this->post_id = $queried_object->ID;
			}
        }	

        if( ! $this->is_edit_mode() ) {
            return;
        }

		add_filter( 'show_admin_bar', '__return_false' );

		// Remove all WordPress actions
		remove_all_actions( 'wp_head' );
		remove_all_actions( 'wp_print_styles' );
		remove_all_actions( 'wp_print_head_scripts' );
		remove_all_actions( 'wp_footer' );

		// Handle `wp_head`
		add_action( 'wp_head', 'wp_enqueue_scripts', 1 );
		add_action( 'wp_head', 'wp_print_styles', 8 );
		add_action( 'wp_head', 'wp_print_head_scripts', 9 );
		add_action( 'wp_head', array( $this, 'builder_head' ), 30 );

		// Handle `wp_footer`
		add_action( 'wp_footer', 'wp_print_footer_scripts', 20 );
		add_action( 'wp_footer', 'wp_print_media_templates' );
        add_action( 'wp_footer', array( $this, 'wp_footer' ) );
        
        remove_all_actions( 'wp_enqueue_scripts' );

		// Handle `wp_enqueue_scripts`
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 999999 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 999999 );

		add_filter( 'body_class', array( $this, 'body_class' ) );



		// Set the headers to prevent caching for the different browsers
		nocache_headers();

		// Tell to WP Cache plugins do not cache this request.
		if ( ! defined( 'DONOTCACHEPAGE' ) ) {
			define( 'DONOTCACHEPAGE', true );
		}

		// Load Tatsu Index Page
		$this->builder_html_index();
		exit;
	}

	private function is_edit_mode() {

        if( !tatsu_is_post_editable_by_current_user( $this->post_id ) ) {
            return false;
        }

		//Page Builder
		if ( tatsu_is_valid_edit_action( 'tatsu' ) ) {
            $this->builder_mode = 'tatsu-page-builder';
            return true;  
		}

		// Header Builder
		if( current_theme_supports('tatsu-header-builder') && tatsu_is_valid_edit_action( 'tatsu-header' ) ) {
			$this->builder_mode = 'tatsu-header-builder';
			return true;
		}

		// Footer Builder
		if( current_theme_supports('tatsu-footer-builder') && tatsu_is_valid_edit_action( 'tatsu-footer' ) ) {
			$this->builder_mode = 'tatsu-footer-builder';
			return true;
		}

		// Global Section Builder
		if( current_theme_supports('tatsu-global-sections') && tatsu_is_valid_edit_action( 'tatsu-global' ) ) {
			$this->builder_mode = 'tatsu-global-section';
			return true;
		}

		// Tatsu Forms
		if( current_theme_supports('tatsu-forms') && tatsu_is_valid_edit_action( 'tatsu-forms' ) ) {
			$this->builder_mode = 'tatsu-page-builder';
			return true;
		}

		return false;
	}


	private function builder_html_index() {
		include plugin_dir_path( dirname( __FILE__ ) ).'builder/tatsu-index.php' ;
	}

	private function get_shape_dividers() {
		$top_shape_dividers = glob( TATSU_PLUGIN_DIR . 'includes/icons/shape_divider/top/*.svg' );
		$bottom_shape_dividers = glob( TATSU_PLUGIN_DIR . 'includes/icons/shape_divider/bottom/*.svg' );
		$left_shape_dividers = glob( TATSU_PLUGIN_DIR . 'includes/icons/shape_divider/left/*.svg' );
		$right_shape_dividers = glob( TATSU_PLUGIN_DIR . 'includes/icons/shape_divider/right/*.svg' );
		$named_dividers = array();
		if( !empty( $top_shape_dividers ) ) {
			$named_dividers[ 'top' ] = array();
			foreach( $top_shape_dividers as $top_shape_divider ) {
				$svg_html = file_get_contents( $top_shape_divider );
				if( false !== $svg_html ) {
					$svg_name = basename( $top_shape_divider, '.svg' );
					$named_dividers[ 'top' ][ $svg_name ] = $svg_html;
				}
			}
		}
		if( !empty( $bottom_shape_dividers ) ) {
			$named_dividers[ 'bottom' ] = array();
			foreach( $bottom_shape_dividers as $bottom_shape_divider ) {
				$svg_html = file_get_contents( $bottom_shape_divider );
				if( false !== $svg_html ) {
					$svg_name = basename( $bottom_shape_divider, '.svg' );
					$named_dividers[ 'bottom' ][ $svg_name ] = $svg_html;
				}
			}
		}
		if( !empty( $left_shape_dividers ) ) {
			$named_dividers[ 'left' ] = array();
			foreach( $left_shape_dividers as $left_shape_divider ) {
				$svg_html = file_get_contents( $left_shape_divider );
				if( false !== $svg_html ) {
					$svg_name = basename( $left_shape_divider, '.svg' );
					$named_dividers[ 'left' ][ $svg_name ] = $svg_html;
				}
			}
		}
		if( !empty( $right_shape_dividers ) ) {
			$named_dividers[ 'right' ] = array();
			foreach( $right_shape_dividers as $right_shape_divider ) {
				$svg_html = file_get_contents( $right_shape_divider );
				if( false !== $svg_html ) {
					$svg_name = basename( $right_shape_divider, '.svg' );
					$named_dividers[ 'right' ][ $svg_name ] = $svg_html;
				}
			}
		}
		return !empty( $named_dividers ) ? $named_dividers : false;
	}

	public function enqueue_scripts() {

		global $wp_styles, $wp_scripts;
		$wp_styles = new \WP_Styles();
		$wp_scripts = new \WP_Scripts();
		$current_user = wp_get_current_user();
		$display_name = $current_user->display_name;

		$suffix = '.min';
		if ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || ( defined( 'TATSU_DEBUG' ) && TATSU_DEBUG ) ) {
			$suffix = '';
		}

        $post = get_post( $this->post_id );
        $post_type_object = get_post_type_object( $post->post_type );
        $can_cur_user_publish = current_user_can( $post_type_object->cap->publish_posts, $this->post_id );

		$dashboard_url = '';
		if( 'tatsu-header-builder' === $this->builder_mode || 'tatsu-footer-builder' === $this->builder_mode ) {
			$dashboard_url = esc_url( add_query_arg( 'post_type', get_post_type(), admin_url( 'edit.php' ) ) );
		}else {
			$dashboard_url = esc_url( get_edit_post_link( $this->post_id ) );
        }
        
        if( 'tatsu-header-builder' === $this->builder_mode ) {
            $store = new Tatsu_Header_Store( $this->post_id );
			$content = $store->get_header_store();
			$module_options = $store->get_module_options();
        }else if( 'tatsu-footer-builder' === $this->builder_mode ) {
            $store = new Tatsu_Footer_Store( $this->post_id );
            $content = $store->get_footer_store();
			$module_options = $store->get_module_options();
        }else {
            $store  = new Tatsu_Store( $this->post_id );
			$content = $store->get_page_content();
			$module_options = $store->get_module_options();
			
			if( tatsu_check_if_global() ) {
				$gsection_modules = Tatsu_Global_Module_Options::getInstance()->get_modules();
				$module_options = array_merge( $module_options, $gsection_modules );
			}

        }

		$rest_api_url = remove_query_arg( 'lang', get_rest_url(null, '/tatsu/v1/') );
		wp_register_script(
			'tatsu',
			plugins_url( 'builder/js/bundle'.$suffix.'.js', dirname(__FILE__) ),
			array(),
			$this->version,
			true
        );
        wp_enqueue_media();

		wp_enqueue_script( 'tatsu' );	
		//Builder control js for spyro form clean area and preview of tatsu modules on hover
		wp_enqueue_script( 'tatsu-builder-control', plugins_url( 'admin/js/tatsu-builder-control.js', dirname(__FILE__) ),array('jquery'), $this->version,true);
		wp_localize_script(
			'tatsu-builder-control',
			'tatsuBuilderConfig',
			array(
				'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
				'pro_icon'=> TATSU_PLUGIN_URL . '/builder/svg/pro_icon.svg',
				'module_preview'=>tatsu_module_preview_options($module_options),
				'be_theme_name'=>be_theme_name(),
				'is_tatsu_authorized'=>is_tatsu_authorized(),
				'is_tatsu_standalone'=>is_tatsu_standalone()
			)
		);
		
		wp_enqueue_script( 'webfont-loader', '//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js',array(),$this->version );
		wp_localize_script(
			'tatsu',
			'tatsuConfig',
			array(
				'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
				'shape_dividers' => $this->get_shape_dividers(), 
                'slider_icons'	=> tatsu_get_slider_icons(),
                'theme' => get_option('tatsu_ui_theme','dark'),
				'restapiurl' => esc_url( $rest_api_url ),
				'wp_editor' => $this->get_wp_editor_config(),
				'post_id' => $this->post_id,
				'post_permalink' => correct_url_if_ssl(esc_url( get_the_permalink( $this->post_id ) )),
                'home_url' => get_bloginfo( 'url' ),
                'publishable' => $can_cur_user_publish,
				'post_dashboard_link' => $dashboard_url,
				'nonce' => wp_create_nonce( 'wp_rest' ),
				'svgs' => esc_url( TATSU_PLUGIN_URL.'/builder/svg/tatsu.svg' ),
				'global_colors' => Tatsu_Colors::getInstance()->get_colors(),
				'plugin_url' => esc_url( TATSU_PLUGIN_URL ),
				'transparent_header_list' => tatsu_get_transparent_header_list(),
				'active_header' => current_theme_supports('tatsu-header-builder') ? tatsu_get_active_header_id() : null, 
				'page_url' => tatsu_edit_url($this->post_id),
				'current_user' => esc_html( $display_name ),
				'post_name' => get_the_title($this->post_id),
				'post_status' => get_post_status( $this->post_id ),
                'revision_data' => tatsu_revision_data( $this->post_id ),
                'content' => $content,
                'module_options' => $module_options,
                'custom_css'  => get_post_meta( $this->post_id, 'tatsu_custom_css', true ),
                'custom_js'  => get_post_meta( $this->post_id, 'tatsu_custom_js', true ),
                'mode'  => $this->builder_mode,
				'default_category' => 'basic',
				'categories' => tatsu_module_categories(),
				'fields' => function_exists( 'tatsu_get_custom_fields_group' ) ? tatsu_get_custom_fields_group() : [],
				'dynamic_values' => tatsu_get_dynamic_values(),
				'is_pro' => is_tatsu_pro_active(),
			)
		);
		wp_localize_script (
			'tatsu',
			'tatsuIcons',
			Tatsu_Icons::getInstance()->get_icons()
		);
		wp_localize_script (
			'tatsu',
			'tatsuSvgs',
			Tatsu_Svgs::getInstance()->get_svgs()
		);

		do_action( 'load_typehub_exposed_selectors' );

	}

	public function enqueue_styles() {
		$tatsu_theme = get_option('tatsu_ui_theme','dark');

		wp_enqueue_style( 'tatsu_wp_editor' );		
		wp_register_style(
			'tatsu_css',
			plugins_url( 'builder/css/master.css', dirname(__FILE__) ),
			array(),
			$this->version
		);
		wp_enqueue_style(
			'tatsu_theme',
			plugins_url(  'builder/css/'.$tatsu_theme.'-scheme.css', dirname(__FILE__) ),
			array(),
			$this->version
		);
		wp_enqueue_style(
			'tatsu_css'
		);
		wp_enqueue_style( 'tatsu-roboto-font', '//fonts.googleapis.com/css?family=Roboto:400,700|Montserrat:400', array(), null );
		Tatsu_Icons::getInstance()->enqueue_styles();
	}

	private function get_wp_editor_config() {
		remove_all_actions('before_wp_tiny_mce');
		remove_all_filters('mce_external_plugins');
		remove_all_filters('mce_buttons');
        remove_all_filters('tiny_mce_before_init');
		ob_start();
		$tatsu_theme = get_option('tatsu_ui_theme','dark');
		wp_editor(
			'',
			'tatsu_editor',
			array(
				'editor_class' => 'tatsu_wp_editor',
				'quicktags' => true,
				'media_buttons' => true,
				'height' => 200,
				'textarea_rows' => 15,
				'drag_drop_upload' => true,
				'tinymce' => array(
					'content_css' => $tatsu_theme === 'dark' ? plugins_url( 'builder/css/editor-content-dark.css', dirname(__FILE__) ) : plugins_url( 'builder/css/editor-content-light.css', dirname(__FILE__) ),
                ),
			)
        );
		return ob_get_clean();
	}

	public function builder_head() {
		do_action( 'tatsu_builder_head' );
	}

	public function wp_footer() {
        $admin_load = get_option( 'tatsu_admin_load', false );
        if( !empty( $admin_load ) ) {
            do_action( 'admin_print_footer_scripts' );
        }
		do_action( 'tatsu_builder_footer' );
	}

	public function body_class( $classes ) {

		$tatsu_theme = get_option('tatsu_ui_theme','dark');
		
		$classes[] = $this->builder_mode;
		$classes[] = 'tatsu-theme-' . $tatsu_theme;
		return $classes;
	}

}