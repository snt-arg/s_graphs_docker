<?php
/**
 * Tatsu Builder Update via Licence Checker 
 * 
 */

if ( !class_exists('TatsubuilderUpdateChecker', false) ):
class TatsubuilderUpdateChecker{
    protected $updater_check;
    public function __construct(){
        add_action('plugins_loaded', array($this, 'check_plugin_update'));
    }

    public function check_plugin_update() {

		if ( ! is_admin() ) {
			return;
		}

		require_once dirname(__FILE__) . '/class-tatsu-check.php';

		$this->updater_check = new Tatsu_Check(
			'https://tatsubuilder.com',
			TATSU_PLUGIN_FILE,
			array(
				'version' => TATSU_VERSION,
				'license' => trim(get_option('tatsu_license_key')),
				'item_id' => get_option( 'tatsu_license_item_id' ),
				'author' => 'Brand Exponents',
				'url' => home_url()
			)
        );
        
	}
}
endif;
