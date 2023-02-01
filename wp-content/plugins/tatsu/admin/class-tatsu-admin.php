<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.brandexponents.com
 * @since      1.0.0
 *
 * @package    Tatsu
 * @subpackage Tatsu/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tatsu
 * @subpackage Tatsu/admin
 * @author     Brand Exponents Creatives Pvt Ltd <swami@brandexponents.com>
 */
class Tatsu_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tatsu_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tatsu_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tatsu-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'semantic-dropdown', plugin_dir_url( __FILE__ ) . 'css/semantic-dropdown.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tatsu_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tatsu_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tatsu-admin.js', array( 'jquery' ), $this->version, true );
		wp_localize_script(
			$this->plugin_name,
			'tatsuAdminConfig',
			array(
				'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
				'nonce' => wp_create_nonce( 'wp_rest' ),
				'is_tatsu_authorized' => is_tatsu_authorized(),
				'is_tatsu_standalone'=> is_tatsu_standalone(),
				'redirectForLicense'=>admin_url( '?page=tatsu_settings'),
				'pro_icon'=> TATSU_PLUGIN_URL . '/builder/svg/pro_icon.svg',
				'tatsu_pro_url'=>TATSU_PRO_URL
			)
		);
		wp_enqueue_script( 'semantic-dropdown', plugin_dir_url( __FILE__ ) . 'js/semantic-dropdown.js', array( 'jquery' ), $this->version, true );

		$temp_localized_array = tatsu_get_global_sections_localize_data(); 
		wp_localize_script( $this->plugin_name, 'tatsu_global_section_data', $temp_localized_array  );

	}

	public function add_body_class( $classes ) {
		global $post_id;
		$edited_with = get_post_meta( $post_id, '_edited_with', true );
		if( empty( $edited_with ) ) {
			$edited_with = 'editor';
		}
		$classes .= ' edited_with_'.$edited_with;
		return $classes;
	}

	public function edit_with_tatsu_button() {
        global $post_id;
        if( !tatsu_is_post_editable_by_current_user( $post_id ) ) {
            return;
        }
		$edited_with = get_post_meta( $post_id, '_edited_with', true );
		if( empty( $edited_with ) ) {
			$edited_with = 'editor';	
		}?>
		<input type="hidden" id="tatsu_edited_with" name="_edited_with" value="<?php echo esc_attr($edited_with); ?>" /> 
		<div id="tatsu_buttons">
			<a href="<?php echo tatsu_edit_url( $post_id ); ?>" id="edit_with_tatsu_button" class="tatsu_edit_button"><?php esc_html_e('Edit with Tatsu' , 'tatsu');?></a>
			<a href="#" id="edit_with_wordpress_editor" class="tatsu_edit_button"><?php esc_html_e('Switch To Wordpress Editor' , 'tatsu');?></a>
		</div>
		<div id="tatsu_edit_post_wrap">
			<a href="<?php echo tatsu_edit_url( $post_id ); ?>">
				<span id="tatsu_edit_dragon_wrap">
                    <svg width="120px" height="35px" viewBox="0 0 233 68" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <!-- Generator: Sketch 48.1 (47250) - http://www.bohemiancoding.com/sketch -->
                        <title>Tatsu</title>
						<desc><?php esc_html_e('Created with Sketch.' , 'tatsu');?></desc>
                        <defs></defs>
                        <g id="Artboard" stroke="none" stroke-width="1" fill-rule="evenodd" transform="translate(-484.000000, -295.000000)">
                            <g id="Tatsu" transform="translate(483.000000, 267.000000)" >
                                <path d="M1.953125,28.8378906 L58.4472656,28.8378906 L58.984375,45.8300781 L56.5917969,45.8300781 C55.419916,40.4915098 53.9306731,37.0166096 52.1240234,35.4052734 C50.3173738,33.7939373 46.5169561,32.9882812 40.7226562,32.9882812 L35.15625,32.9882812 L35.15625,84.1601562 C35.15625,88.0338735 35.7584575,90.4345657 36.9628906,91.3623047 C38.1673237,92.2900437 40.8040161,92.9003892 44.8730469,93.1933594 L44.8730469,95 L15.7226562,95 L15.7226562,93.1933594 C19.9544482,92.8678369 22.5911406,92.1679741 23.6328125,91.09375 C24.6744844,90.0195259 25.1953125,87.31773 25.1953125,82.9882812 L25.1953125,32.9882812 L19.6289062,32.9882812 C14.0950244,32.9882812 10.3271584,33.7857993 8.32519531,35.3808594 C6.32323218,36.9759194 4.81771338,40.4589575 3.80859375,45.8300781 L1.3671875,45.8300781 L1.953125,28.8378906 Z M87.7636719,67.9492188 C84.0201636,69.1862041 80.9277466,70.5533779 78.4863281,72.0507812 C73.7988047,74.9479312 71.4550781,78.2356587 71.4550781,81.9140625 C71.4550781,84.8763169 72.4316309,87.0572847 74.3847656,88.4570312 C75.6543032,89.3684941 77.0703047,89.8242188 78.6328125,89.8242188 C80.7812607,89.8242188 82.8401594,89.2220112 84.8095703,88.0175781 C86.7789812,86.813145 87.7636719,85.2832124 87.7636719,83.4277344 L87.7636719,67.9492188 Z M62.7636719,85.2832031 C62.7636719,80.5631274 65.1236743,76.6243647 69.84375,73.4667969 C72.8385566,71.5136621 78.8118042,68.8606938 87.7636719,65.5078125 L87.7636719,61.3574219 C87.7636719,58.0370928 87.4381543,55.725918 86.7871094,54.4238281 C85.680333,52.2428276 83.3854341,51.1523438 79.9023438,51.1523438 C78.2421792,51.1523438 76.6634189,51.5755166 75.1660156,52.421875 C73.6686123,53.3007856 72.9199219,54.5052007 72.9199219,56.0351562 C72.9199219,56.4257832 73.0013013,57.0849563 73.1640625,58.0126953 C73.3268237,58.9404343 73.4082031,59.5345039 73.4082031,59.7949219 C73.4082031,61.6178477 72.8059956,62.8873662 71.6015625,63.6035156 C70.9179653,64.0266948 70.1041714,64.2382812 69.1601562,64.2382812 C67.6953052,64.2382812 66.5722695,63.7581428 65.7910156,62.7978516 C65.0097617,61.8375603 64.6191406,60.7714902 64.6191406,59.5996094 C64.6191406,57.3209521 66.0270042,54.9365359 68.8427734,52.4462891 C71.6585427,49.9560422 75.784478,48.7109375 81.2207031,48.7109375 C87.5358389,48.7109375 91.816395,50.7616982 94.0625,54.8632812 C95.2669331,57.1093862 95.8691406,60.3808379 95.8691406,64.6777344 L95.8691406,84.2578125 C95.8691406,86.1458428 95.9993477,87.4479131 96.2597656,88.1640625 C96.6829448,89.4336001 97.5618423,90.0683594 98.8964844,90.0683594 C99.645186,90.0683594 100.263669,89.9544282 100.751953,89.7265625 C101.240237,89.4986968 102.086583,88.9453169 103.291016,88.0664062 L103.291016,90.6054688 C102.249344,91.8750063 101.126308,92.9166626 99.921875,93.7304688 C98.0989492,94.9674541 96.243499,95.5859375 94.3554688,95.5859375 C92.141916,95.5859375 90.5387419,94.8697988 89.5458984,93.4375 C88.5530549,92.0052012 88.007813,90.2962339 87.9101562,88.3105469 C85.4361855,90.4589951 83.3203213,92.0540313 81.5625,93.0957031 C78.6002456,94.8535244 75.7845186,95.7324219 73.1152344,95.7324219 C70.3157412,95.7324219 67.8906353,94.7477312 65.8398438,92.7783203 C63.7890522,90.8089094 62.7636719,88.310562 62.7636719,85.2832031 Z M133.925781,49.9804688 L133.925781,53.4960938 L123.964844,53.4960938 L123.867188,81.6210938 C123.867188,84.0950645 124.078774,85.9667905 124.501953,87.2363281 C125.283207,89.4824331 126.81314,90.6054688 129.091797,90.6054688 C130.263678,90.6054688 131.28092,90.3287788 132.143555,89.7753906 C133.006189,89.2220024 133.99088,88.343105 135.097656,87.1386719 L136.367188,88.2128906 L135.292969,89.6777344 C133.600252,91.9563916 131.809905,93.5677036 129.921875,94.5117188 C128.033845,95.4557339 126.210946,95.9277344 124.453125,95.9277344 C120.61196,95.9277344 118.007819,94.2187671 116.640625,90.8007812 C115.891923,88.9453032 115.517578,86.3737144 115.517578,83.0859375 L115.517578,53.4960938 L110.195312,53.4960938 C110.032551,53.398437 109.910482,53.3007817 109.829102,53.203125 C109.747721,53.1054683 109.707031,52.9752612 109.707031,52.8125 C109.707031,52.4869775 109.780273,52.2347014 109.926758,52.0556641 C110.073243,51.8766267 110.537105,51.4615918 111.318359,50.8105469 C113.564464,48.9550688 115.183914,47.44955 116.176758,46.2939453 C117.169601,45.1383406 119.50519,42.0866133 123.183594,37.1386719 C123.606773,37.1386719 123.859049,37.1712236 123.94043,37.2363281 C124.02181,37.3014326 124.0625,37.5455708 124.0625,37.96875 L124.0625,49.9804688 L133.925781,49.9804688 Z M146.445313,79.6191406 L148.056641,79.6191406 C148.805342,83.3300967 149.814447,86.1783755 151.083984,88.1640625 C153.362642,91.8099141 156.699197,93.6328125 161.09375,93.6328125 C163.535168,93.6328125 165.46386,92.9573635 166.879883,91.6064453 C168.295906,90.2555271 169.003906,88.5058701 169.003906,86.3574219 C169.003906,84.9902275 168.597009,83.6718813 167.783203,82.4023438 C166.969397,81.1328062 165.53712,79.8958394 163.486328,78.6914062 L158.017578,75.5664062 C154.013652,73.417958 151.067718,71.2532661 149.179688,69.0722656 C147.291657,66.8912651 146.347656,64.3196763 146.347656,61.3574219 C146.347656,57.7115703 147.649727,54.7168086 150.253906,52.3730469 C152.858086,50.0292852 156.129538,48.8574219 160.068359,48.8574219 C161.793628,48.8574219 163.689768,49.1829395 165.756836,49.8339844 C167.823904,50.4850293 168.987629,50.8105469 169.248047,50.8105469 C169.833987,50.8105469 170.25716,50.7291675 170.517578,50.5664062 C170.777996,50.403645 171.005858,50.143231 171.201172,49.7851562 L172.373047,49.7851562 L172.714844,63.4082031 L171.201172,63.4082031 C170.550127,60.2506353 169.671229,57.7929775 168.564453,56.0351562 C166.546214,52.7799316 163.632832,51.1523438 159.824219,51.1523438 C157.545562,51.1523438 155.755215,51.8522065 154.453125,53.2519531 C153.151035,54.6516997 152.5,56.2955635 152.5,58.1835938 C152.5,61.1784004 154.746071,63.8476445 159.238281,66.1914062 L165.683594,69.6582031 C172.617222,73.4342637 176.083984,77.828751 176.083984,82.8417969 C176.083984,86.6829619 174.643569,89.8242065 171.762695,92.265625 C168.881822,94.7070435 165.113956,95.9277344 160.458984,95.9277344 C158.50585,95.9277344 156.29233,95.6022168 153.818359,94.9511719 C151.344389,94.300127 149.87956,93.9746094 149.423828,93.9746094 C149.033201,93.9746094 148.691408,94.1129543 148.398438,94.3896484 C148.105467,94.6663425 147.877605,94.999998 147.714844,95.390625 L146.445313,95.390625 L146.445313,79.6191406 Z M200.664062,49.7851562 L200.664062,81.0351562 C200.664062,83.248709 200.973304,85.0227798 201.591797,86.3574219 C202.79623,88.8313926 205.00975,90.0683594 208.232422,90.0683594 C210.445975,90.0683594 212.610667,89.3359448 214.726562,87.8710938 C215.930996,87.0572876 217.151687,85.934252 218.388672,84.5019531 L218.388672,57.7441406 C218.388672,55.2376177 217.900396,53.5937539 216.923828,52.8125 C215.947261,52.0312461 213.994155,51.5592456 211.064453,51.3964844 L211.064453,49.7851562 L226.835938,49.7851562 L226.835938,84.1601562 C226.835938,86.373709 227.234697,87.8955037 228.032227,88.7255859 C228.829757,89.5556682 230.51431,89.9218755 233.085938,89.8242188 L233.085938,91.1914062 C231.295564,91.6796899 229.977218,92.0458972 229.130859,92.2900391 C228.284501,92.5341809 226.8685,92.9817676 224.882812,93.6328125 C224.036454,93.9257827 222.181004,94.6256455 219.316406,95.7324219 C219.153645,95.7324219 219.05599,95.6591804 219.023438,95.5126953 C218.990885,95.3662102 218.974609,95.1953135 218.974609,95 L218.974609,87.1386719 C216.761057,89.7754038 214.742848,91.7285093 212.919922,92.9980469 C210.152981,94.9511816 207.223323,95.9277344 204.130859,95.9277344 C201.298814,95.9277344 198.62957,94.9186299 196.123047,92.9003906 C193.583972,90.9147036 192.314453,87.5781484 192.314453,82.890625 L192.314453,57.5488281 C192.314453,54.9446484 191.761073,53.2031294 190.654297,52.3242188 C189.938147,51.7708306 188.408215,51.3802095 186.064453,51.1523438 L186.064453,49.7851562 L200.664062,49.7851562 Z"></path>
                            </g>
                        </g>
                    </svg>
					<span><?php echo esc_html__('Edit With Tatsu' , 'tatsu'); ?></span>
				</span>
			</a>			
		</div>	
	<?php	
	}

	public function add_edit_in_dashboard( $post_actions, $post ) {
		if( is_edited_with_tatsu($post->ID) && tatsu_is_post_editable_by_current_user($post->ID) ) {
			$post_actions['edit_with_tatsu'] = sprintf(
				'<a href="%1$s">%2$s</a>',
				tatsu_edit_url( $post->ID ),
				esc_html__( 'Edit with Tatsu', 'tatsu' )
			);
		}
		return $post_actions;
	}

	public function add_tatsu_post_state( $post_states, $post ) {
		if( is_edited_with_tatsu($post->ID) ) {
			$post_states['tatsu'] = 'Tatsu';
		}
		if( TATSU_HEADER_CPT_NAME === $post->post_type ) {
			$active_header_id = tatsu_get_active_header_id();
			if( !empty( $active_header_id ) && $active_header_id === $post->ID ) {
				$post_states['tatsu_active_header'] = 'Tatsu Header';
			}
		}else if( TATSU_FOOTER_CPT_NAME === $post->post_type ) {
			$active_footer_id = tatsu_get_active_footer_id();
			if( !empty( $active_footer_id ) && $active_footer_id === $post->ID ) {
				$post_states['tatsu_active_footer'] = 'Tatsu Footer';
			}
		}
		return $post_states;
	}

	public function tatsu_create_new_post() {
        if ( empty( $_GET['post_type'] ) ) {
			$post_type = 'post';
		} else {
			$post_type = be_sanitize_text_field($_GET['post_type']);
        }
        
        if( !tatsu_is_post_type_editable_by_current_user( $post_type ) ) {
            return;
        }

		if( post_type_exists( $post_type ) ) {
			$post_data = array(
				'post_type'		=> $post_type,
				'post_status'	=> 'publish',
			);
			if( TATSU_HEADER_CPT_NAME === $post_type ) {
				$post_data['post_title'] = 'Tatsu Header';
			}else if( TATSU_FOOTER_CPT_NAME === $post_type ) {
				$post_data['post_title'] = 'Tatsu Footer';
			}else  if( 'post' === $post_type ) {
				$post_data['post_title'] = 'Tatsu';
			}else{
				$post_type_obj = get_post_type_object($post_type);
				$post_data['post_title'] = sprintf(
					'Tatsu %s', $post_type_obj->labels->singular_name
				);
			}

			$post_id = wp_insert_post($post_data);
			if( !empty( $post_id ) ) {
				$post_data['ID'] = $post_id;
				$post_data['post_title'] .= ' #' . $post_id;
				wp_update_post($post_data);
				wp_redirect( tatsu_edit_url( $post_id ) );
			}
			exit;
		}else {
			wp_die( sprintf( 'Type %s does not exist.', $post_type ) );
		}
	}

	public function tatsu_admin_menu() {
		add_menu_page('Tatsu', 'Tatsu', 'manage_options', 'tatsu_settings',array($this,'tatsuwelcome_dashboard'),'data:image/svg+xml;base64,'.base64_encode('<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M19 6.93027H15.4194V2.72261H12.0129V16.292H16.0194V19H4.01935V16.292H8.00645V2.72261H4.56129V6.93027H1V0H19V6.93027Z" fill="#9DA1A7"/></svg>'));
		
		add_submenu_page('tatsu_settings', 'Dashboard', 'Dashboard', 'manage_options', 'tatsu_settings',array($this,'tatsuwelcome_dashboard'));
		add_submenu_page('tatsu_settings', 'Settings', 'Settings', 'manage_options', 'tatsu_global_settings', 'tatsu_settings_page');
		add_submenu_page('tatsu_settings', 'Global Sections', 'Global Sections', 'manage_options', 'edit.php?post_type=tatsu_gsections');
		
		//Add colorhub Menu
		remove_menu_page('colorhub');
		add_submenu_page('tatsu_settings', 'Color Hub', 'Color Hub', 'manage_options', 'colorhub',array($this,'colorhub_dashboard'));

		//Add typehub Menu
		remove_menu_page('typehub');
		add_submenu_page('tatsu_settings', 'Type Hub', 'Type Hub', 'manage_options', 'typehub',array($this,'typehub_dashboard'));

		if( current_theme_supports( 'tatsu-header-builder' ) ) {
			add_submenu_page('tatsu_settings', 'Headers', 'Headers', 'manage_options', 'edit.php?post_type=' . TATSU_HEADER_CPT_NAME);
		}
		if( current_theme_supports( 'tatsu-footer-builder' ) ) {
			add_submenu_page('tatsu_settings', 'Footer', 'Footer', 'manage_options', 'edit.php?post_type=' . TATSU_FOOTER_CPT_NAME);
		}

		if( current_theme_supports('tatsu-forms') ){
			//Forms
			add_submenu_page('tatsu_settings', 'Tatsu Forms', 'Forms', 'manage_options', 'edit.php?post_type=tatsu_forms');
			//Submit form enteries 
			add_submenu_page('tatsu_settings', 'Tatsu Form Entries', 'Form Entries', 'manage_options', 'tatsu-forms-entries','tatsu_forms_entries_display_table');
			//Form Integrations 
			add_submenu_page('tatsu_settings', 'Tatsu Form Settings', 'Form settings', 'manage_options', 'tatsu-forms-settings','tatsu_form_settings');
			
		}
		
		//Demo Import
		if(is_tatsu_standalone()){
		add_submenu_page('tatsu_settings', 'Demo Import', 'Demo Import', 'manage_options', 'tatsu_demo_import',array($this,'tatsu_demo_import_dashboard'));
		}
	}

	public function colorhub_dashboard(){
		echo '<div id="color-hub"></div>';
	}

	public function typehub_dashboard(){
		echo '<div id="root"></div>';
	}

	public function tatsuwelcome_dashboard(){
		require_once TATSU_PLUGIN_DIR. 'includes/demo-import/admin-tpl/start-page.php';
	}

	public function tatsu_demo_import_dashboard(){
		require_once TATSU_PLUGIN_DIR. 'includes/demo-import/admin-tpl/demo-import-page.php';
	}

	public function tatsu_forms_post_type(){
		if( current_theme_supports('tatsu-forms') ){
			$labels = array( 
				'name' => esc_html__( 'Tatsu Forms', 'tatsu' ),
				'singular_name' => esc_html__( 'Tatsu Forms', 'tatsu' ),
				'add_new' => _x( 'Add New Form', 'Tatsu Forms', 'tatsu' ),
				'all_items' => esc_html__( 'All Forms', 'tatsu' ),
				'add_new_item' => esc_html__( 'Add New Form', 'tatsu' ),
				'edit_item' => esc_html__( 'Edit Form', 'tatsu' ),
				'new_item' => esc_html__( 'New Form', 'tatsu' ),
				'view_item' => esc_html__( 'View Form', 'tatsu' ),
				'search_item' => esc_html__( 'Search Form', 'tatsu' ),
				'not_found' => esc_html__( 'No Form Found', 'tatsu' ),
				'no_item_found_in_trash' => esc_html__( 'No Form Found In Trash', 'tatsu' ),
				'parent_item_colon' => esc_html__( 'Parent Section:', 'tatsu' ),
			);
			$args = array( 
				'labels' => $labels,
				'public' => true,
				'has_achive' => true,
				'publicly_queryable' => true,
				'query_var' => true,
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'supports' => array( 
					'title',
					'editor',
					'thumbnail',
					'revisions'
				),
				'menu_position' => 5,
				'exclude_from_search' =>  false,
				'show_in_menu' => false
			);
			register_post_type( 'tatsu_forms',$args );
		}
	}

	public function tatsu_global_section_post_type(){
		if( current_theme_supports('tatsu-global-sections') ){
			$labels = array( 
				'name' => esc_html__( 'Tatsu Global Sections', 'tatsu' ),
				'singular_name' => esc_html__( 'Tatsu Global Section', 'tatsu' ),
				'add_new' => _x( 'Add Section', 'Tatsu Global Section', 'tatsu' ),
				'all_items' => esc_html__( 'All Section', 'tatsu' ),
				'add_new_item' => esc_html__( 'Add New Section', 'tatsu' ),
				'edit_item' => esc_html__( 'Edit Section', 'tatsu' ),
				'new_item' => esc_html__( 'New Section', 'tatsu' ),
				'view_item' => esc_html__( 'View Section', 'tatsu' ),
				'search_item' => esc_html__( 'Search Section', 'tatsu' ),
				'not_found' => esc_html__( 'No Sections Found', 'tatsu' ),
				'no_item_found_in_trash' => esc_html__( 'No Section Found In Trash', 'tatsu' ),
				'parent_item_colon' => esc_html__( 'Parent Section:', 'tatsu' ),
			);
			$args = array( 
				'labels' => $labels,
				'public' => true,
				'has_achive' => true,
				'publicly_queryable' => true,
				'query_var' => true,
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'supports' => array( 
					'title',
					'editor',
					'thumbnail',
					'revisions'
				),
				'menu_position' => 5,
				'exclude_from_search' =>  false,
				'show_in_menu' => false
			);
			register_post_type( 'tatsu_gsections',$args );
		}
	}

	public function tatsu_header_register_post_type() {
		if( current_theme_supports( 'tatsu-header-builder' ) ) {
			$labels = array( 
				'name' => esc_html__( 'Tatsu Headers', 'tatsu' ),
				'singular_name' => esc_html__( 'Tatsu Header', 'tatsu' ),
				'add_new' => _x( 'Add Header', 'Tatsu Header', 'tatsu' ),
				'all_items' => esc_html__( 'All Headers', 'tatsu' ),
				'add_new_item' => esc_html__( 'Add New Header', 'tatsu' ),
				'edit_item' => esc_html__( 'Edit Header', 'tatsu' ),
				'new_item' => esc_html__( 'New Header', 'tatsu' ),
				'view_item' => esc_html__( 'View Header', 'tatsu' ),
				'search_item' => esc_html__( 'Search Header', 'tatsu' ),
				'no_item_found_in_trash' => esc_html__( 'No Headers Found In Trash','tatsu' ),
			);
			$args = array( 
				'labels' => $labels,
				'public' => true,
				'has_achive' => false,
				'publicly_queryable' => true,
				'query_var' => TATSU_HEADER_CPT_NAME,
				'capability_type' => 'post',
				'hierarchical' => false,
				'supports' => array( 
					'title',
					'editor',
					'thumbnail',
					'revisions'
				),
				'menu_position' => 4,
				'exclude_from_search' =>  true,
				'show_in_menu' => false
			);
			register_post_type( TATSU_HEADER_CPT_NAME, $args );
		}
	}

	public function tatsu_footer_register_post_type() {
		if( current_theme_supports( 'tatsu-footer-builder' ) ) {
			$labels = array( 
				'name' => esc_html__( 'Tatsu Footers', 'tatsu' ),
				'singular_name' => esc_html__( 'Tatsu Footer', 'tatsu' ),
				'add_new' => _x( 'Add Footer', 'Tatsu Footer', 'tatsu' ),
				'all_items' => esc_html__( 'All Footers', 'tatsu' ),
				'add_new_item' => esc_html__( 'Add New Footer', 'tatsu' ),
				'edit_item' => esc_html__( 'Edit Footer', 'tatsu' ),
				'new_item' => esc_html__( 'New Footer', 'tatsu' ),
				'view_item' => esc_html__( 'View Footer', 'tatsu' ),
				'search_item' => esc_html__( 'Search Footer', 'tatsu' ),
				'no_item_found_in_trash' => esc_html__( 'No Footers Found In Trash','tatsu' ),
			);
			$args = array( 
				'labels' => $labels,
				'public' => true,
				'has_achive' => false,
				'publicly_queryable' => true,
				'query_var' => TATSU_FOOTER_CPT_NAME,
				'capability_type' => 'post',
				'hierarchical' => false,
				'supports' => array( 
					'title',
					'editor',
					'thumbnail',
					'revisions'
				),
				'menu_position' => 5,
				'exclude_from_search' =>  true,
				'show_in_menu' => false
			);
			register_post_type( TATSU_FOOTER_CPT_NAME, $args );
		}
	}

	public function redirect_tatsu_header_footer_builder() {
        $screen = get_current_screen();
        $admin_load = get_option( 'tatsu_admin_load', false );
		if ( TATSU_HEADER_CPT_NAME == $screen->id || TATSU_FOOTER_CPT_NAME == $screen->id ) {
            global $post;
			$post_id = be_sanitize_text_field($_GET[ 'post' ]);
            if( !tatsu_is_post_editable_by_current_user( $post_id ) ) {
                return;
            }
            if( $admin_load && ( tatsu_is_valid_edit_action( 'tatsu-header' ) || tatsu_is_valid_edit_action( 'tatsu-footer' ) ) ) {
                return;
            }
			if( !empty( $post_id ) ) {
				wp_redirect( tatsu_edit_url( $post_id ) );
			}
		}
	}
	
	public function add_media_edit_options($form_fields, $post) {
		$height_checked = ("1" == get_post_meta( $post->ID, 'be_themes_height_wide', true )) ? 'checked="checked"' : '';
		$width_checked = ("1" == get_post_meta( $post->ID, 'be_themes_width_wide', true )) ? 'checked="checked"' : '';
		$form_fields['be-themes-double-height'] = array(
			'label' => 'Double Height',
			'input' => 'html',
			'html'  => "<input type=\"checkbox\"
						name=\"attachments[{$post->ID}][be-themes-double-height]\"
						id=\"attachments[{$post->ID}][be-themes-double-height]\"
						value=\"1\" {$height_checked}/>",            
			'helps' => '',
		);
		$form_fields['be-themes-double-width'] = array(
			'label' => 'Double Width',
			'input' => 'html',
			'html'  => "<input type=\"checkbox\"
						name=\"attachments[{$post->ID}][be-themes-double-width]\"
						id=\"attachments[{$post->ID}][be-themes-double-width]\"
						value=\"1\" {$width_checked}/>",            
			'helps' => '',
		);
		return $form_fields;
	}

	public function add_media_save_options($post, $attachment) {
		if( isset( $attachment['be-themes-double-height'] ) ) {
			update_post_meta( $post['ID'], 'be_themes_height_wide', 1 );
		}else {
			update_post_meta( $post['ID'], 'be_themes_height_wide', 0 );
		}

		if( isset( $attachment['be-themes-double-width'] ) ) {
			update_post_meta( $post['ID'], 'be_themes_width_wide', 1 );
		}else {
			update_post_meta( $post['ID'], 'be_themes_width_wide', 0 );
		}

		return $post;
	}

	public function tatsu_add_customizer_options( $wp_customize ) {

        require_once TATSU_PLUGIN_DIR . 'includes/customizer-controls.php';

		$section_name = apply_filters( 'tatsu_global_options_section', '' );
		$section = $wp_customize->get_section( $section_name );
		if( empty( $section ) ) {
			$section_name = 'tatsu_global_options';
			$wp_customize->add_section( $section_name, array(
				'title' => esc_html__( 'Global Tatsu Settings', 'tatsu' ),
			) );
		}
		do_action( 'tatsu_register_customizer_controls', $wp_customize );
		$wp_customize->add_setting( 'tatsu_google_map_id', array (
			'type'				=> 'option',
			'capability'		=> 'manage_options',
			'default' 			=> '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'tatsu_google_map_id', array (
			'type'				=> 'text',
			'section'			=> $section_name,
			'label'				=> esc_html__( 'Google Map API Key', 'tatsu' ),
			'description'		=> esc_html__( 'Please enter your Google Maps API Key', 'tatsu' ),
		) );
		$wp_customize->add_setting( 'tatsu_lazyload_bg', array (
			'type'				=> 'option',
			'capability'		=> 'manage_options',
			'default' 			=> '',
		) );
		$wp_customize->add_control( 'tatsu_lazyload_bg', array (
			'type'				=> 'checkbox',
			'section'			=> $section_name,
			'label'				=> esc_html__( 'Lazy Load Section and Column Background Images', 'tatsu' ),
		) );
        
        if ( ! function_exists( 'get_editable_roles' ) ) {
            require_once ABSPATH . 'wp-admin/includes/user.php';
        }
        $roles = get_editable_roles();
        $choices = array();
        foreach( $roles as $slug => $role_details ) {
            if( 'administrator' === $slug ) {
                continue;
            }
            $choices[$slug] = $role_details['name'];
        }
        $wp_customize->add_setting( 'tatsu_provide_access', array (
            'type'  => 'option',
            'default' => 'editor',
            'capability' => 'manage_options',
        ) );
        $wp_customize->add_control( new Tatsu_Dropdown_Custom_Control( $wp_customize, 'tatsu_provide_access', array(
            'label' => __( 'Provide Access to', 'tatsu' ),
            'description' => __( 'The selected user roles will have access to Tatsu. Administrator and Editor has access by default', 'tatsu' ),
            'section' => $section_name,
            'input_attrs' => array(
                'placeholder' => __( 'Please select the roles', 'tatsu' ),
            ),
            'choices' => $choices,
        ) ) );        

		$wp_customize->add_setting( 'tatsu_lazyload_bg_color', array (
			'type'				=> 'option',
			'capability'		=> 'manage_options',
			'default' 			=> '#323232',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 
			'tatsu_lazyload_bg_color', 
			array(
				'label'      => esc_html__( 'Lazy Load Section/Column Placeholder Color', 'tatsu' ),
				'section'    => $section_name,
				'settings'   => 'tatsu_lazyload_bg_color',
			) ) 
        );
        
		if( current_theme_supports('tatsu-header-builder') ) {
            $headers_list = tatsu_get_headers_list();
            $headers_list_prepend = array();
            $headers_list_prepend['none'] = esc_html__( 'None', 'tatsu' );
            $headers_list = $headers_list_prepend + $headers_list;
			$wp_customize->add_setting( 'tatsu_active_header', array (
				'type'				=> 'option',
				'capability'		=> 'manage_options',
				'default' 			=> '',
			) );
			$wp_customize->add_control( 'tatsu_active_header', array(
				'label'    => esc_html__( 'Active Header', 'tatsu' ),
				'type'     => 'select',
				'section'  => $section_name,
				'choices'  => $headers_list,
			));
        }
        
		if( current_theme_supports('tatsu-footer-builder') ) {
			$footers = get_posts(array (
				'post_type' => TATSU_FOOTER_CPT_NAME,
				'post_status' => 'publish',
				'numberposts' => -1
			));
			$footers_list[ 'none' ] = esc_html__( 'None', 'tatsu' );
			foreach($footers as $footer) {
				$footers_list[$footer->post_name] = $footer->post_title;
			}
			$wp_customize->add_setting( 'tatsu_active_footer', array (
				'type'				=> 'option',
				'capability'		=> 'manage_options',
				'default' 			=> '',
			) );
			$wp_customize->add_control( 'tatsu_active_footer', array(
				'label'    => esc_html__( 'Active Footer', 'tatsu' ),
				'type'     => 'select',
				'section'  => $section_name,
				'choices'  => $footers_list,
			));
        }
        
		$wp_customize->add_setting( 'tatsu_ui_theme', array (
			'type'				=> 'option',
			'capability'		=> 'manage_options',
			'default'			=> 'dark',
		) );
		$wp_customize->add_control( 'tatsu_ui_theme', array (
			'type'				=> 'select',
			'choices'			=> array( 
										'dark' => 'Dark',
										'light' => 'Light',
			),
			'section'			=> $section_name,
			'label'				=> esc_html__( 'Tatsu UI Theme', 'tatsu' ),
        ) );
        
        $wp_customize->add_setting( 'tatsu_admin_load', array (
            'type'  => 'option',
            'capability'  => 'manage_options',
            'default' => '',
        ) );
        $wp_customize->add_control( 'tatsu_admin_load', array (
            'type'  => 'checkbox',
            'section'  => $section_name,
            'label' => esc_html__( 'Admin Side Loading', 'tatsu' ),
            'description' => esc_html__( 'Debug/Plugin Compatibility Mode', 'tatsu' ),
        ) );
	}

	public function tatsu_global_section_settings(){

		if( current_theme_supports('tatsu-global-sections') ){
			add_submenu_page("options-general.php", 'Tatsu Global Sections', 'Tatsu Global Sections', 'manage_options', 'tatsu_global_section_settings' , 'tatsu_global_section_settings_options' );
		}
	}

	public function tatsu_register_setting() {
		register_setting('tatsu_settings', 'tatsu_active_header');
		register_setting('tatsu_settings', 'tatsu_active_footer');
		register_setting('tatsu_settings', 'tatsu_global_section_data');
	}

	public function tatsu_add_global_section_settings() {
		if( current_theme_supports('tatsu-global-sections') ){
			register_setting( 'tatsu_global_section_settings', 'tatsu_global_section_data' );
		}
    }

	public function tatsu_add_gsection_meta_box_to_posts(){
        global $post;
        $post_id = $post->ID;
		if( current_theme_supports('tatsu-global-sections') && tatsu_is_post_editable_by_current_user( $post_id ) ){
			
			$post_type_array = tatsu_get_custom_post_types();

			foreach( $post_type_array as $post_type => $value ){

				add_meta_box( 
					'tatsu_global_section_on_posts',
					'Tatsu Global Section Settings',
					'tatsu_global_section_settings_on_posts_callback',
					$post_type
				);

			}
		}

	}
	


	public function tatsu_save_global_section_settings_on_posts( $post_id ) {
		
		if( current_theme_supports('tatsu-global-sections') ){
		
			// Check if our nonce is set.
			if ( ! isset( $_POST['tatsu_global_settings_on_post_nonce'] ) ) {
				return;
			}
		
			// Verify that the nonce is valid.
			if ( ! wp_verify_nonce( $_POST['tatsu_global_settings_on_post_nonce'], 'tatsu_global_settings_on_post_nonce' ) ) {
				return;
			}
		
			// If this is an autosave, our form has not been submitted, so we don't want to do anything.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
		
			// Check the user's permissions.
			if( !tatsu_is_post_editable_by_current_user( $post_id ) ) {
                return;
            }
		
		

			// Sanitize user input.
			$my_data = array();
			$my_data['top'] = be_sanitize_text_field( $_POST['position_top'] );
			$my_data['penultimate'] = be_sanitize_text_field( $_POST['position_penultimate'] );
			$my_data['bottom'] = be_sanitize_text_field( $_POST['position_bottom'] );

			// Update the meta field in the database.
			update_post_meta( $post_id, '_tatsu_global_section_on_post', $my_data );
		}
	}

	//For Header Builder
	public function tatsu_header_options_metabox() {
        global $post;
        $post_id = $post->ID;
		if( current_theme_supports('tatsu-header-builder') && tatsu_is_post_editable_by_current_user( $post_id ) ) {
			add_meta_box(
				'tatsu_header_options', // $id
				'Header Options', // $title
				'tatsu_print_header_options' //$callback
			);
			if( !function_exists( 'tatsu_print_header_options' ) ){
				function tatsu_print_header_options(){
					global $post;  
					$meta = get_post_meta( $post->ID, '_tatsu_header_options' , true ); 
					$header_style = ( $meta && array_key_exists( 'tatsu_page_header_style' , $meta ) ) ? $meta['tatsu_page_header_style'] : '';
					$header_scheme = ( $meta && array_key_exists( 'tatsu_page_header_scheme' , $meta ) ) ? $meta['tatsu_page_header_scheme'] : '';
					$header_sticky = ( $meta && array_key_exists( 'tatsu_page_header_sticky' , $meta ) ) ? $meta['tatsu_page_header_sticky'] : '';
					$header_smart_sticky = ( $meta && array_key_exists( 'tatsu_page_header_smart' , $meta ) ) ? $meta['tatsu_page_header_smart'] : '';
					$header_auto_pad = ( $meta && array_key_exists( 'tatsu_header_auto_pad' , $meta ) ) ? $meta['tatsu_header_auto_pad'] : '';
                    $header_single_page_site = ( $meta && array_key_exists( 'tatsu_header_single_page_site' , $meta ) ) ? $meta['tatsu_header_single_page_site'] : 0;
                    $active_header_override = ( $meta && !empty( $meta['tatsu_active_header_override'] ) ) ? $meta['tatsu_active_header_override'] : 'inherit';
                    
                    $headers_list = tatsu_get_headers_list();
                    $headers_list_prepend = array();
                    $headers_list_prepend[ 'inherit' ] = esc_html__( 'Inherit from Customizer', 'tatsu' );
                    $headers_list = $headers_list_prepend + $headers_list;
					?>

						<input type="hidden" name="tatsu_header_options" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">
						<p class = "tatsu-header-active-override" >
							<label for="tatsu_active_header_override"><strong>Active Header</strong></label>
							<select name="tatsu_active_header_override" id="tatsu_active_header_override">
								<?php foreach( $headers_list as $header_name => $header_title ) : ?>
									<option value = "<?php echo $header_name; ?>" <?php selected( $active_header_override, $header_name ); ?>><?php echo esc_html($header_title); ?></option>
                                <?php endforeach; ?>
							</select>
						</p>
						<p class = "tatsu-header-metabox" >
							<label for="tatsu_page_header_style"><strong>Select Header Style:</strong></label>
							
							<select name="tatsu_page_header_style" id="tatsu_page_header_style">
									<option value="inherit" <?php selected( $header_style, 'inherit' ); ?>>Inherit Global Setting</option>
									<option value="default" <?php selected( $header_style, 'default' ); ?>>Solid</option>
									<option value="transparent" <?php selected( $header_style, 'transparent' ); ?>>Transparent</option>
							</select>
						</p>
						<p>
							<label for="tatsu_page_header_scheme"><strong>Select Scheme:</strong></label>
							
							<select name="tatsu_page_header_scheme" id="tatsu_page_header_scheme">
									<option value="inherit" <?php selected( $header_scheme, 'inherit' ); ?>>Inherit Global Setting</option>
									<option value="light" <?php selected( $header_scheme, 'light' ); ?>>Light</option>
									<option value="dark" <?php selected( $header_scheme, 'dark' ); ?>>Dark</option>
							</select>
						</p>
						<p>
							<label for="tatsu_header_auto_pad"><strong>Transparent Padding:</strong></label>
							<select name="tatsu_header_auto_pad" id="tatsu_header_auto_pad">
									<option value="yes" <?php selected( $header_auto_pad, 'yes' ); ?>>Yes</option>
									<option value="no" <?php selected( $header_auto_pad, 'no' ); ?>>No</option>
							</select>
							<div class = "description"> This setting works only when transparent header is used</div>
						</p>
						<p>
							<label for="tatsu_header_single_page_site"><strong>Single Page Site:</strong>  <input type="checkbox" name="tatsu_header_single_page_site" id="tatsu_header_single_page_site" value="1" <?php checked( $header_single_page_site, 1 ); ?> /></label>
							<div class = "description"> Turn this on if the menu has links that all point to different sections of the same page.</div>
						</p>						
				<?php
				}
			}
		}

	}

	public function tatsu_save_header_options( $post_id ) {   
		// verify nonce
		if ( !array_key_exists( 'tatsu_header_options', $_POST ) || !wp_verify_nonce( $_POST['tatsu_header_options'], basename(__FILE__) ) ) {
			return $post_id; 
		}
		// check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		// check permissions
		if( !tatsu_is_post_editable_by_current_user( $post_id ) ) {
            return $post_id;
        }

        $my_data = array();
        $my_data['tatsu_active_header_override'] = be_sanitize_text_field($_POST['tatsu_active_header_override']);
		$my_data['tatsu_page_header_style'] = be_sanitize_text_field($_POST['tatsu_page_header_style']);
		$my_data['tatsu_page_header_scheme'] = be_sanitize_text_field($_POST['tatsu_page_header_scheme']);
		$my_data[ 'tatsu_header_auto_pad' ] = be_sanitize_text_field($_POST['tatsu_header_auto_pad']);
		$my_data[ 'tatsu_header_single_page_site' ] = be_sanitize_text_field($_POST['tatsu_header_single_page_site']);

		update_post_meta( $post_id, '_tatsu_header_options', $my_data );
	}

	public function tatsu_admin_notice(){
		if ( ! function_exists( 'get_current_screen' ) ) { 
			require_once ABSPATH . '/wp-admin/includes/screen.php'; 
		} 
 		$current_screen = get_current_screen();
		if ( ! in_array( $current_screen->parent_file, [ 'index.php', 'themes.php', 'plugins.php', 'tatsu_settings' ] ) ) {
			return;
		}

		$tatsu_admin_dismiss_notices = get_option( 'tatsu_admin_dismiss_notices', array() );
		if ( ! is_array( $tatsu_admin_dismiss_notices ) ) {
			return;
		}

		if ( ! in_array( 'tatsu-typehub-colorhub-info-notice', $tatsu_admin_dismiss_notices ) ) { ?>
			<div id="tatsu-typehub-colorhub-info-notice" class="notice tatsu-admin-notice notice-info is-dismissible">
				<h3><?php esc_html_e( 'Typehub and Colorhub are now included in Tatsu', 'tatsu' ); ?></h3>
				<p><?php esc_html_e( 'Typehub and Colorhub settings are avilable inside Tatsu menu. Please deactivate Typehub and Colorhub plugins.', 'tatsu' ); ?></p>
			</div>
		<?php }

		if ( ! in_array( 'tatsu-spyro-info-notice', $tatsu_admin_dismiss_notices ) && 'tatsu_settings' === $current_screen->parent_file ) {
			echo '<div id="tatsu-spyro-info-notice" class="notice tatsu-admin-notice notice-info is-dismissible">
				<h3>'.esc_html__( 'Newly Launched - Spyro WordPress Theme - A BrandExponents Product', 'tatsu' ).'</h3>
				<p>'.esc_html__( 'Introducing powerful landing pages builder, Spyro. A Front-end & Fully Responsive WP Builder that comes with 15+ Premade Demos, Premium Plugins, and High-Quality Templates. Dedicated to new-age businesses with a strong emphasis on conversions.', 'tatsu' ).'</p>
				<p><strong>'.esc_html__("What's More?", 'tatsu' ).'</strong></p>
				<ul style="padding-left:20px;list-style-type:disc">
				<li>'.esc_html__( "Modern and 100% Responsive Designs", 'tatsu' ).'</li>
				<li>'.esc_html__( "Tatsu Builder (New Module - Spyro Forms is bundled)
				", 'tatsu' ).'</li>
				<li>'.esc_html__( "GDPR Compliant Design + WPML Compatible", 'tatsu' ).'</li>
				<li>'.esc_html__( "WooCommerce Ready", 'tatsu' ).'</li>
				<li>'.esc_html__( "24x7 Quick Customer support, and much more.", 'tatsu' ).'</li>
				</ul>
				<p><strong>'.esc_html__("Sneak peek of our popular pre-built demos:", 'tatsu' ).'</strong></p>
				<div class="notice-spyro-demos-list" style="display:flex;gap:15px">
				<a href="'.esc_url('https://spyrowptheme.com/saas-clickthrough-new/').'" title="SaaS – Clickthrough" target="_blank">
				<img src="'.esc_url('https://spyrowptheme.com/wp-content/uploads/2021/05/spyro-demos-saas-click-thumbnail.png').'" alt="SaaS – Clickthrough" width="100" height="100" /></a>
				<a href="'.esc_url('https://spyrowptheme.com/shop/').'" title="Shop" target="_blank">
				<img src="'.esc_url('https://spyrowptheme.com/wp-content/uploads/2021/10/shop.png').'" alt="Shop" width="100" height="100" /></a>
				<a href="'.esc_url('https://spyrowptheme.com/seo-agency/').'" title="SEO Agency" target="_blank">
				<img src="'.esc_url('https://spyrowptheme.com/wp-content/uploads/2021/10/seo-agency.png').'" alt="SEO Agency" width="100" height="100" /></a>
				<a href="'.esc_url('https://spyrowptheme.com/finance-advisor/').'" title="Finance Advisor" target="_blank">
				<img src="'.esc_url('https://spyrowptheme.com/wp-content/uploads/2021/10/finance.png').'" alt="Finance Advisor" width="100" height="100" /></a>
				<a href="'.esc_url('https://spyrowptheme.com/hair-treatment/').'" title="Hair Treatment" target="_blank">
				<img src="'.esc_url('https://spyrowptheme1.wpengine.com/wp-content/uploads/2021/05/Mask-Group.png').'" alt="Hair Treatment" width="100" height="100" /></a>
				</div>

				<div class="notice-button" style="display:flex;gap:15px; padding:10px 0px;">
				<a href="'.esc_url('https://themeforest.net/item/spyro-marketing-landing-page-theme-for-wordpress/31694851').'" target="_blank" class="button-primary">'.esc_html__("Buy Now", 'tatsu' ).'</a>
				<a href="'.esc_url('https://preview.themeforest.net/item/spyro-marketing-landing-page-theme-for-wordpress/full_screen_preview/31694851').'" target="_blank" class="button-primary">'.esc_html__("View all Demos", 'tatsu' ).'</a>
				</div>
			</div>';
		}
	}
}