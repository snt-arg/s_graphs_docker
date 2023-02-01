<?php
/**
 * This class will make connection with Envato market API and checks the given information from the user
 *
 * @since 1.0
 *
 * @package be
 * @subpackage be-functions
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

class BEUpdater {
	private static $option_group_slug = 'be_register';

	private static $option_name = 'be_register';

	private static $option_section = 'be_start';

	private static $token;

	private static $theme_found = false;

	private static $plugins = [
		'oshine-core/oshine-core.php',
		'oshine-modules/oshine-modules.php'
	];

	protected $core;

	function __construct($core)
	{
		$this->core = $core;
	}

	public function run() {
		// add_filter( 'https_ssl_verify', '__return_false' ); // for local debug
	    // envato_market();
	   	add_filter('plugin_action_links', array($this, 'disable_activation'), 99, 2);
	   	add_filter('pre_update_option_active_plugins', array($this, 'stop_activation'), 99, 2);

		add_action('admin_init',array($this,'settings_field'));
		//add_action('wp_ajax_be_token_check',array($this, 'ajax_check'));
		add_action('wp_ajax_be_save_purchase_code',array($this, 'save_purchase_code'));
		add_action('wp_ajax_be_deactivate_purchase_code',array($this, 'deactivate_purchase_code'));

		add_action( 'wp_ajax_BS_set_memory', array($this, 'ajax_set_memory_limit'), 10, 1 );
		add_action('wp_ajax_be_newsletter_subscribe',array($this, 'be_newsletter_subscribe'));
	}

	public function settings_field() {
		register_setting(self::$option_group_slug, self::$option_name,
			array($this, 'check_token')
		);

		add_settings_field('token',
			esc_html__( 'Token', 'oshin' ),
			array($this, 'render_token_field'),
			self::$option_group_slug
		);

	}

	// public static function check_token($val) {
	// 	$old_val = get_option(self::$option_group_slug)['token'];
	// 	self::$token = $val['token'];
	// 	return $val;
	// }

	// public static function theme_found() {
	// 	global $BECore;
	// 	$themes = envato_market()->api()->themes( 'purchased' );
	// 	$theme_name = $BECore['themeName'];
	// 	foreach ($themes as $slug => $theme) {
	// 		if($theme['name'] == $theme_name) {
	// 			self::$theme_found = true;
	// 		}
	// 	}
	// 	return self::$theme_found;
	// }

	public static function options_group_name() {
		return self::$option_group_slug;
	}

	public static function set_token($val) {
		self::$token = $val;
	}

	public static function get_token() {
		return self::$token;
	}
	// public static function ajax_check() {
	// 	global $beCore;
		
	// 	$token = $_POST['token'];
	// 	update_option( self::options_group_name(), array('token'=>$token ));
	// 	echo self::matched_token();
	// 	wp_die();
	// }

	public function stop_activation( $value, $old_value ) {
        if ( get_option( 'oshin-theme-invalid' ) == '1' ) {
            return array_diff( $value, self::$plugins );
        }
		return $value;
    }

	public function disable_activation( $actions, $plugin_file ) {
        if ( get_option( 'oshin-theme-invalid' ) == '1' ) {
            if ( array_key_exists( 'activate', $actions ) && in_array( $plugin_file, self::$plugins ) ) {
                unset( $actions['activate'] );
            }
        }

        return $actions;
    }

	public static function save_purchase_code_old() {
		if ( ! check_ajax_referer( 'be_save_purchase_code', 'security' ) || empty( $_POST['token'] ) ) {
			echo '<div class="notic notic-warning ">Invalid Nonce / Empty Purchase Code</div>';
			wp_die();
		}		
		$purchase_code_data = array(
			'theme_purchase_code' => $_POST['token']
        );
        echo update_option('be_themes_purchase_data', $purchase_code_data );
		wp_die();
	}

	public static function save_purchase_code() {
		if ( ! check_ajax_referer( 'be_save_purchase_code', 'security' ) || ! isset( $_POST['token'] ) ) {
			wp_send_json( array(
				'res' => false,
				'msg' => '<div class="notic notic-warning ">Invalid Nonce / Empty Purchase Code</div>'
			), 200 );
		}
	
		$res = false;
		$msg = '';

		//newsletter Email
		$email = ( ! empty( $_POST['email'] ) ) ? sanitize_email( $_POST['email'] ) : '';
		if( ! empty( $email ) ) {
			if ( ! is_email( $email ) ) {
				$msg .= '<div class="notic notic-error ">Not a valid email</div>';
			} else {
				//$response = wp_remote_get( "https://www.brandexponents.com/subscribe/be-subscribe.php?email=$email&list_name=$list_name" );
				$response = wp_remote_get( "https://brandexponents.com/api.php?email=$email" );

				$body = wp_remote_retrieve_body( $response );
				$response_data = json_decode( $body );
				if ( isset( $response_data->code ) ) {
					if ( $response_data->code == 'duplicate_parameter' ) {
						$msg .= '<div class="notic notic-warning ">Unable to Save Email or Email Already in use</div>';
					} else {
						update_option( 'oshine_newsletter_email', $email );
						$msg .= '<div class="notic notic-success ">Email Saved Successfully</div>';
					}
				}
			}
		}

		//Purchase code verify
		if ( empty( $_POST['token'] ) ) {
			$msg .= '<div class="notic notic-warning">Purchase code can not be empty</div>';
		} else {
			$purchase_code = trim( sanitize_text_field( $_POST['token'] ) );

			$oshin_purchase_data = get_option( 'be_themes_purchase_data', false );
			if ( empty( $oshin_purchase_data ) || ! be_is_theme_valid() ) {
				$vars = oshin_pk_verify_vars( true );
				$vars = "https://brandexponents.com/wp-json/beepapi/v1/purchase-verifier?verify_pk=1&purchase_key=" . $purchase_code . "&" . $vars;
				
				$response = wp_remote_get( $vars );
				$body = wp_remote_retrieve_body( $response );
				$response_data = json_decode( $body );

				if ( 200 == wp_remote_retrieve_response_code( $response ) ) {
					$purchase_code_data = array(
						'theme_purchase_code' => $purchase_code,
					);
					update_option( 'be_themes_purchase_data', $purchase_code_data );
					update_option( 'oshin-theme-invalid', '' );
					update_option( 'oshin-theme_message', '' );

					$res = true;
					$msg .= '<div class="notic notic-success ">Purchase code saved successfully</div>';
				} else {
					$theme_message = 'Invalid Purchase Code';
					if ( ! empty( $response_data )  && ! empty( $response_data->theme_message ) ) {
						$theme_message = $response_data->theme_message;
					}
					$msg .= '<div class="notic notic-warning ">' . $theme_message . '</div>';
				}
			} else {
				$msg .= '<div class="notic notic-success ">Purchase code is already saved successfully</div>';
			}
		}	
		
		wp_send_json( array(
			'res' => $res,
			'msg' => $msg
		), 200 );
	}

	public static function deactivate_purchase_code() {
		if ( ! check_ajax_referer( 'be_save_purchase_code', 'security' ) || ! isset( $_POST['token'] ) ) {
			wp_send_json( array(
				'res' => false,
				'msg' => '<div class="notic notic-warning ">Invalid Nonce / Empty Purchase Code</div>'
			), 200 );
		}
	
		$res = false;
		$msg = '';

		//Purchase code verify
		if ( empty( $_POST['token'] ) ) {
			$msg .= '<div class="notic notic-warning">Purchase code can not be empty</div>';
		} else {
			$purchase_code = trim( sanitize_text_field( $_POST['token'] ) );
			$oshin_purchase_data = get_option( 'be_themes_purchase_data', false );
			if ( be_is_theme_valid() ) {
				$vars = oshin_pk_verify_vars( true );
				$vars = "https://brandexponents.com/wp-json/beepapi/v1/purchase-verifier?deactivate_license=1&purchase_key=" . $purchase_code . "&" . $vars;
				
				$response = wp_remote_get( $vars );
				$body = wp_remote_retrieve_body( $response );
				$response_data = json_decode( $body );
			
				if ( 200 != wp_remote_retrieve_response_code( $response ) ) {
					if ( isset( $response_data->status ) && 'deactivated' === $response_data->status ) {
						delete_option( 'be_themes_purchase_data' );
						delete_option( 'oshin-theme_message' );
						update_option( 'oshin-theme-invalid', '1' );
						deactivate_plugins( self::$plugins );
						$res = true;
					}
				}

				if ( $res ) {
					$msg .= '<div class="notic notic-success">Purchase Code deactivated successfully</div>';
				} else {
					$msg .= '<div class="notic notic-warning">We can\'t procced your request. Please try again.</div>';
				}
			} else {
				$msg .= '<div class="notic notic-success">Please use a valid Purchase code</div>';
			}
		}	
		
		wp_send_json( array(
			'res' => $res,
			'msg' => $msg
		), 200 );
	}

	public function be_newsletter_subscribe() {
		if ( ! check_ajax_referer( 'subscribe_checker', 'security' ) ) {
			echo '<div class="notic notic-warning ">Invalid Nonce</div>';
			wp_die();
		}
		$email = $_POST['email'];
		$list_name = $_POST['list_name'];
		if( empty( $email ) ) {
			echo '<div class="notic notic-error ">Email cannot be empty</div>';
			wp_die();
		}		
		if( !is_email( $email ) ) {
			echo '<div class="notic notic-error ">Not a valid email</div>';
			wp_die();
		}
		$response = wp_remote_get( "http://brandexponents.com/api.php?email=$email" );

		$body = wp_remote_retrieve_body( $response );

		$response_data = json_decode($body)->code;

		if($response_data == 'duplicate_parameter')
		{
			echo '<div class="notic notic-warning ">Unable to Save Email or Email Already in use</div>';
		}
		else
		{
			echo '<div class="notic notic-success ">Email Saved Successfully</div>';
		}
		wp_die();
	}

	/*public function render_token_field() {
		?>
		<input type="text" name="<?php echo esc_attr(self::$option_name); ?>[token]" class="widefat" value="<?php echo esc_html(self::$token); ?>">
		<?php
	}
	public static function matched_token() {
		global $BECore;
		$themes = envato_market()->api()->themes( 'purchased' );
		$theme_name = $BECore['themeName'];
		$plugins = envato_market()->api()->plugins();
		wp_enqueue_style('jquery-ui-core');
		if(self::$token === '' || !isset(self::$token)) {
			self::$theme_found = flase;
			echo '<div class="notic notic-warning "><p>';

			printf(esc_html__( 'Token filed is empty please enter vaild token', 'oshin' ),$theme_name);
			

			echo '</p></div>';
			return;
		}
		if(empty($themes)) {
			self::$theme_found = true;
			echo '<div class="notic notic-warning "><p>';

			printf(esc_html__( 'Token must be generated from the same themeforest account that purchassed %s', 'oshin' ),$theme_name);
			

			echo '</p></div>';
		} else {
			foreach ($themes as $slug => $theme) {
				if($theme['name'] == $theme_name) {
					echo '<div class="notic notic-success "><p>';printf(esc_html__( 'Thank you for purchasing %s', 'oshin' ),$theme_name);
					
					echo '</p></div>';
					echo envato_market_themes_column('installed');
					
				} else {
					echo '<div class="notic notic-warning "><p>';printf(esc_html__( '%s is not found in your purchase list', 'oshin' ),$theme_name);
					echo '</p></div>';

				}
			}
		}
	}*/

}
?>