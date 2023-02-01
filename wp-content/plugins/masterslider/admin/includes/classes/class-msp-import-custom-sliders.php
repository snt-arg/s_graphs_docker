<?php
/**
 * Master Slider Import Theme's Sliders Class.
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


/**
 * Master Slider Import Theme's Sliders Class.
 *
 * @since 2.5.0
 */
class MSP_Import_Custom_Sliders {


	var $theme_sliders_data = null;

	var $decoded_sliders_data = null;


	function __construct() {

		add_action( 'admin_menu', array( $this, 'admin_init' ), 20 );
	}


	public function admin_init() {

		// check if custom demo sliders are set
		if( $this->theme_sliders_data = msp_get_theme_sliders_data() ){
			$this->parse_sliders_data();
			// add_action( 'admin_notices', array( $this, 'admin_import_notice' ) );
		}
	}

	private function parse_sliders_data(){
		global $ms_importer;

		$this->decoded_sliders_data = $ms_importer->decode_import_data( $this->theme_sliders_data );

		if( $this->decoded_sliders_data ){
			$this->init_import_page();
		}
	}


	private function init_import_page(){

		$ms_theme_sliders_page_title = apply_filters( 'masterslider_import_demo_sliders_page_title', __( "Import Sliders" , MSWP_TEXT_DOMAIN ) );
		$ms_theme_sliders_menu_title = apply_filters( 'masterslider_import_demo_sliders_menu_title', __( "Import Sliders" , MSWP_TEXT_DOMAIN ) );

		add_submenu_page(
            MSWP_SLUG,
            $ms_theme_sliders_page_title,
            $ms_theme_sliders_menu_title,
            apply_filters( 'masterslider_import_theme_sliders_capability', 'manage_options' ),
            MSWP_SLUG . '-import-custom-slider',
            array( $this, 'render_page' )
        );

	}


	public function render_page() {

		$this->header();

		$this->render_form();

		$this->footer();
	}


	private function render_form(){

		if( ! isset( $this->decoded_sliders_data['sliders_data'] ) ){
			_e( 'So slider data found to import!', MSWP_TEXT_DOMAIN );
			return;
		}

		?>
		<form method="post" action="<?php echo admin_url( 'admin.php?import=masterslider-importer&step=2' ); ?>" class="msp_theme_sliders_list">

			<table class="form-table">
				<tbody>

					<tr class="option-site-visibility">
						<th scope="row"><?php _e( 'Select sliders to import', MSWP_TEXT_DOMAIN ); ?></th>
						<td>
							<fieldset>
								<?php wp_nonce_field('msp-im-theme-sliders'); ?>

								<input type="hidden" name="import-theme-sliders" value="1">

								<legend class="screen-reader-text"><span><?php _e( 'Slider Items', MSWP_TEXT_DOMAIN ); ?></span></legend>

								<?php foreach ( $this->decoded_sliders_data['sliders_data'] as $slider_id => $slider_data ): ?>
								<label for="ms_import_theme_slider_ids">
									<input name="ms_import_theme_slider_ids[]" type="checkbox" value="<?php echo $slider_id; ?>" checked >
									<?php echo apply_filters( 'masterslider_import_theme_slider_title', $slider_data['title'], $slider_id ); ?>
								</label><br />
								<?php endforeach ?>

							</fieldset>
						</td>
					</tr>

				</tbody>
			</table>

			<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Import'); ?>"></p>

		</form>
		<?php
	}


	/**
	 * Display import page title
	 */
	function header() {
		echo '<div class="wrap">';
		$ms_theme_sliders_page_title = apply_filters( 'masterslider_import_demo_sliders_page_title', __( "Import Sliders" , MSWP_TEXT_DOMAIN ) );
		echo '<h2>' . $ms_theme_sliders_page_title . '</h2><br />';
	}

	/**
	 * Close div.wrap
	 */
	function footer() {
		echo '</div>';

	}

}


new MSP_Import_Custom_Sliders();
