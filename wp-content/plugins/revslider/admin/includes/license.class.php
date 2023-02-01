<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2020 ThemePunch
 * @since	  6.2.0
 */

if(!defined('ABSPATH')) exit();

class RevSliderLicense extends RevSliderFunctions {
	/**
	 * Activate the Plugin through the ThemePunch Servers
	 * @before 6.0.0: RevSliderOperations::checkPurchaseVerification();
	 * @before 6.2.0: RevSliderAdmin::activate_plugin();
	 **/
	public function activate_plugin($code){
		$rslb = RevSliderGlobals::instance()->get('RevSliderLoadBalancer');
		$data = array('code' => urlencode($code), 'version'	=> urlencode(RS_REVISION), 'product' => urlencode(RS_PLUGIN_SLUG));
		
		$response	  = $rslb->call_url('activate.php', $data, 'updates');
		$version_info = wp_remote_retrieve_body($response);
		
		if(is_wp_error($version_info)) return false;
		
		if($version_info == 'valid'){
			update_option('revslider-valid', 'true');
			update_option('revslider-code', $code);
			update_option('revslider-trustpilot', 'true');
			update_option('revslider-deregister-popup', 'false');

			return true;
		}elseif($version_info == 'exist'){
			return 'exist';
		}elseif($version_info == 'banned'){
			return 'banned';
		}
		
		return false;
	}
	
	
	/**
	 * Deactivate the Plugin through the ThemePunch Servers
	 * @before 6.0.0: RevSliderOperations::doPurchaseDeactivation();
	 * @before 6.2.0: RevSliderAdmin::deactivate_plugin();
	 **/
	public function deactivate_plugin(){
		$rslb = RevSliderGlobals::instance()->get('RevSliderLoadBalancer');
		$code = get_option('revslider-code', '');
		$data = array('code' => urlencode($code), 'product' => urlencode(RS_PLUGIN_SLUG));
		
		$res = $rslb->call_url('deactivate.php', $data, 'updates');
		$vi	 = wp_remote_retrieve_body($res);
		
		if(is_wp_error($vi)) return false;

		if($vi == 'valid'){
			update_option('revslider-valid', 'false');
			update_option('revslider-code', '');
			update_option('revslider-trustpilot', 'false');
			update_option('revslider-deregister-popup', 'true');

			return true;
		}
		
		return false;
	}
}