<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://brandexponents.com
 * @since      1.0.0
 *
 * @package    Be_Gdpr
 * @subpackage Be_Gdpr/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Be_Gdpr
 * @subpackage Be_Gdpr/public
 * @author     Swaminathan ganesan <help@brandexponents.com>
 */
class Be_Gdpr_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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
		wp_enqueue_style( 'gdprmagnificpopup', plugin_dir_url( __FILE__ ) . 'css/magnific-popup.css', array(), $this->version, 'all' );

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/be-gdpr-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_script('gdprmagnificpopup', 
			plugin_dir_url( __FILE__ ).'js/magnificpopup'.$suffix.'.js', dirname(__FILE__) ,
			array( 'jquery' ),
			$this->version,
			false
		);
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/be-gdpr-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script(
            'be-gdpr',
            'beGdprConcerns',
            Be_Gdpr_Options::getInstance()->get_options()
        );
	}

	public function print_privacy_elements() {

		$popup_classes = "mfp-hide";
		$popup_classes = apply_filters('be_gdpr_popup_classes', $popup_classes);

		ob_start();
		?>
			<div id="gdpr-popup" class="be-gdpr-popup <?php echo $popup_classes; ?> " data-rel="gdpr-popup-gallery" >
				<div  class="be-gdpr-modal" >
				<div class="be-modal-content-wrapper" >
					<div class="be-gdpr-modal-heading" ><?php echo get_option( 'be_gdpr_popup_title_text', 'Privacy Settings' ); ?></div>

					<div class="be-gdpr-modal-desc" > <?php echo do_shortcode( get_option( 'be_gdpr_popup_intro_content', 'We use cookies to enhance your experience while using our website. If you are using our Services via a browser you can restrict, block or remove cookies through your web browser settings. We also use content and scripts from third parties that may use tracking technologies. You can selectively provide your consent below to allow such third party embeds. For complete information about the cookies we use, data we collect and how we process them, please check our [be_gdpr_privacy_policy_page]')); ?> </div>
					<div class="be-gdpr-modal-items" >
						<?php

						$options = Be_Gdpr_Options::getInstance()->get_options();

						foreach($options as $option => $value){
							echo '<div class="be-gdpr-modal-item" >
								<div class="be-gdpr-modal-item-head" >'. $value['label'] .'</div>
								<div class="be-gdpr-modal-item-desc" >'. do_shortcode( str_replace('[be_gdpr_api_name]','[be_gdpr_api_name api='.$value['label'].' ]', get_option( 'be_gdpr_consent_desc', 'Consent to display content from [be_gdpr_api_name]' ))).' </div>
								<div class="be-gdpr-modal-item-switch">
									<label class="switch be-modal-switch">
										<input class="be-gdpr-switch-input" value="'.$option.'" type="checkbox">
										<span class="slider round"></span>
					  				</label></div>
								</div>';
						}
					?>
					</div>
					</div>
					<div class="be-gdpr-modal-footer" >
						<div class="be-gdpr-modal-save-btn" onClick="gdprSaveBtnClick(event);" ><?php echo get_option( 'be_gdpr_popup_save_btn_text', 'Save' ); ?></div>
					</div>
				</div>
			</div>
			<?php 
			if( ( !array_key_exists('be_gdpr_cookie_accept',$_COOKIE) || $_COOKIE['be_gdpr_cookie_accept'] === "0" ) && get_option( 'be_gdpr_show_cookie_notice_bar', '' ) === 'on' ){
			
				echo '<div class="be-gdpr-cookie-notice-bar">
						<div class="be-gdpr-cookie-notice-wrap">
							<div class="be-gdpr-cookie-notice-bar-text">'.  do_shortcode( get_option( 'be_gdpr_cookie_privacy_content', $default = 'We use cookies to enhance your experience while using our website. To learn more about the cookies we use and the data we collect, please check our [be_gdpr_privacy_popup].' )).'</div>
							<div class="be-gdpr-cookie-notice-actions">
							<div class="be-gdpr-cookie-notice-button">'. get_option( 'be_gdpr_accept_btn_text', 'I Accept' ) .'</div>
							</div>
						</div>
					 </div>';
			}
			?> 
		<?php 
		$popup = ob_get_clean();
		echo $popup;
	}

}
