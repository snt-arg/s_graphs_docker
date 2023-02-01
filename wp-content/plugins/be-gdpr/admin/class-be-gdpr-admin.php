<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://brandexponents.com
 * @since      1.0.0
 *
 * @package    Be_Gdpr
 * @subpackage Be_Gdpr/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Be_Gdpr
 * @subpackage Be_Gdpr/admin
 * @author     Swaminathan ganesan <help@brandexponents.com>
 */
class Be_Gdpr_Admin {

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
		 * defined in Be_Gdpr_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Be_Gdpr_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/be-gdpr-admin.css', array(), $this->version, 'all' );

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
		 * defined in Be_Gdpr_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Be_Gdpr_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/be-gdpr-admin.js', array( 'jquery' ), $this->version, false );

	}
	public function add_submenu_GDPR() {
		
		add_submenu_page("options-general.php", __( "BE GDPR Settings", "be-gdpr"), "BE GDPR", "manage_options", "be_gdpr",'show_settings'); 
	
		function show_settings(){
			?>
			<div class="wrap">
			<h1>BE GDPR Settings</h1>

			<form method="post" action="options.php">
			
				<?php settings_fields( 'be_gdpr' ); ?>
				<?php do_settings_sections( 'be_gdpr' ); ?>
					<div class="be-settings-page-option" >
						<label class="be-settings-page-option-label" ><?php esc_html_e("Show Cookie Notice Bar", "be-gdpr"); ?></label>
						<div class="gdpr-settings" ><label class="switch be-modal-switch">
								<input class="be-gdpr-switch-input" name="be_gdpr_show_cookie_notice_bar" <?php echo get_option( 'be_gdpr_show_cookie_notice_bar' ) === 'on' ? "checked" : ''; ?> type="checkbox"> 
								<span class="slider round"></span>
					  		</div>
					</div>
					<div class="be-settings-page-option" >
						<label class="be-settings-page-option-label" ><?php esc_html_e("Cookie Notice Bar Content", "be-gdpr"); ?></label>
						<div><textarea name="be_gdpr_cookie_privacy_content" rows="4" cols="50" ><?php echo get_option( 'be_gdpr_cookie_privacy_content' ) ; ?></textarea></div>
					</div>
					<div class="be-settings-page-option" >
						<label class="be-settings-page-option-label" ><?php esc_html_e("Accept Button Text", "be-gdpr"); ?></label>
						<div><input type="text" name="be_gdpr_accept_btn_text" value="<?php echo get_option( 'be_gdpr_accept_btn_text' ) ; ?>" /></div>
					</div>
					<div class="be-settings-page-option" >
						<label class="be-settings-page-option-label" ><?php esc_html_e("Popup Title Text", "be-gdpr"); ?></label>
						<div><input type="text" name="be_gdpr_popup_title_text" value="<?php echo get_option( 'be_gdpr_popup_title_text' ) ; ?>" /></div>
					</div>
					<div class="be-settings-page-option" >
						<label class="be-settings-page-option-label" ><?php esc_html_e("Popup Intro Content", "be-gdpr"); ?> </label>
						<div><textarea name="be_gdpr_popup_intro_content"  rows="4" cols="50" ><?php echo get_option( 'be_gdpr_popup_intro_content' ) ; ?></textarea></div>
					</div>
					<div class="be-settings-page-option" >
						<label class="be-settings-page-option-label" ><?php esc_html_e("Privacy Policy Link Text", "be-gdpr"); ?></label>
						<div><input type="text" name="be_gdpr_privacy_policy_link_text" value="<?php echo get_option( 'be_gdpr_privacy_policy_link_text' ) ; ?>" /></div>
					</div>
					<div class="be-settings-page-option" >
						<label class="be-settings-page-option-label" ><?php esc_html_e("Popup Save Button Text", "be-gdpr"); ?></label>
						<div><input type="text" name="be_gdpr_popup_save_btn_text" value="<?php echo get_option( 'be_gdpr_popup_save_btn_text' ) ; ?>" /></div>
					</div>
					<div class="be-settings-page-option" >
						<label class="be-settings-page-option-label" ><?php esc_html_e("Consent Description", "be-gdpr"); ?> </label>
						<div><textarea name="be_gdpr_consent_desc" rows="4" cols="50"  ><?php echo get_option( 'be_gdpr_consent_desc' ) ; ?></textarea></div>
					</div>
					<div class="be-settings-page-option" >
						<label class="be-settings-page-option-label" ><?php esc_html_e("Text on overlay over blocked content", "be-gdpr"); ?> </label>
						<div><textarea name="be_gdpr_text_on_overlay" rows="4" cols="50" ><?php echo get_option( 'be_gdpr_text_on_overlay' ) ; ?></textarea></div>
					</div>
				<?php submit_button(); ?>
			</form>

			<div class="be-gdpr-disclaimer" >
			DISCLAIMER:

This plugin is meant to assist you in making some of the features ( such as Youtube, Vimeo and Google Map embeds ) available in the themes and plugins created by Brand Exponents, compatible with GDPR. Using this plugin does not guarantee that an organisation is successfully meeting its responsibilities and obligations of GDPR. Organisations should assess their unique responsibilities and ensure extra measures are taken to meet any obligations required by law. The pre-filled content in the consent popup and cookie notice bar, are just samples for your reference. We recommend that you consult a legal expert to formulate the exact text copy depending on the needs of your website.
			</div>

		</div>
		<?php
		}
	}

	public function add_cookie_privacy_content() {
  
		$options_to_be_registered = array(	
			'be_gdpr_cookie_privacy_content' =>  'We use cookies to enhance your experience while using our website. To learn more about the cookies we use and the data we collect, please check our [be_gdpr_privacy_popup].',
			'be_gdpr_show_cookie_notice_bar' =>'',
			'be_gdpr_accept_btn_text' => 'I Accept',
			'be_gdpr_popup_title_text' => 'Privacy Settings',
			'be_gdpr_popup_intro_content' =>  'We use cookies to enhance your experience while using our website. If you are using our Services via a browser you can restrict, block or remove cookies through your web browser settings. We also use content and scripts from third parties that may use tracking technologies. You can selectively provide your consent below to allow such third party embeds. For complete information about the cookies we use, data we collect and how we process them, please check our [be_gdpr_privacy_policy_page]',
			'be_gdpr_privacy_policy_link_text' => 'Privacy Policy',
			'be_gdpr_popup_save_btn_text' => 'Save',
			'be_gdpr_consent_desc' =>  'Consent to display content from - [be_gdpr_api_name]',
			'be_gdpr_text_on_overlay' =>  'Your consent is required to display this content from [be_gdpr_api_name] - [be_gdpr_privacy_popup]' ,
		);

		foreach( $options_to_be_registered as $option => $value ){
		register_setting( 'be_gdpr', $option, array('default' => $value) ); 
		}


	}

}
