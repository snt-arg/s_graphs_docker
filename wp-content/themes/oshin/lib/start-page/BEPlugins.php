<?php
/**
 * Handle plugin installing and activation
 *
 * Most of this class methods are from https://github.com/dtbaker/envato-wp-theme-setup-wizard
 *
 * @package oshine
 * @author be
 * @see  BEAdminMenu, tgmpa 
 * @since 0.1
 **/
 class BEPlugins
 {
 	/**
		 * Relative plugin path
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		protected $plugin_path = '';

		private $plugins_order = array();

		/**
		 * Relative plugin url for this plugin folder, used when enquing scripts
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		protected $plugin_url = '';

		/**
		 * The slug name to refer to this menu
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		protected $page_slug;

		/**
		 * TGMPA instance storage
		 *
		 * @var object
		 */
		protected $tgmpa_instance;

		/**
		 * TGMPA Menu slug
		 *
		 * @var string
		 */
		protected $tgmpa_menu_slug = 'install-required-plugins';

		/**
		 * TGMPA Menu url
		 *
		 * @var string
		 */
		protected $tgmpa_url = 'themes.php?page=install-required-plugins';

		private static $instance = null;
 	
 	function __construct($core)
 	{
 		$this->core = $core;
		$this->theme_name = $core['themeName'];
		$this->plugins_order = array( 'oshine-core', 'tatsu', 'oshine-modules', 'be-portfolio-post', 'be-gdpr', 'contact-form-7', 'meta-box', 'meta-box-conditional-logic', 'meta-box-show-hide', 'meta-box-tabs', 'masterslider', 'revslider' );
 	}

 	public function run() {
 		if ( class_exists( 'TGM_Plugin_Activation' ) && isset( $GLOBALS['tgmpa'] ) ) {
			add_action( 'init', array( $this, 'get_tgmpa_instanse' ), 30 );
			add_action( 'init', array( $this, 'set_tgmpa_url' ), 40 );
		}
		add_filter( 'tgmpa_load', array($this, 'tgmpa_load'), 10, 1);
 		add_action( 'wp_ajax_be_handle_plugins', array($this, 'ajax_plugins'));
 		add_action( 'admin_enqueue_scripts', array($this, 'plugin_sctipts'));

	}
	
	public function update_plugins_order() {
		$plugins = $this->_get_plugins();
		$needed_plugins_count = count( $plugins[ 'all' ] );
		$plugins_config_count = count( $this->plugins_order );
		if( $needed_plugins_count > $plugins_config_count ) {
			foreach( $plugins[ 'all' ] as $slug => $plugin ) {
				if( !in_array( $slug, $this->plugins_order ) ) {
					$this->plugins_order[] = $slug;
				}
			}
		}
	}

 	public function _get_plugins() {
 		
			$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
			$plugins  = array(
				'all'      => array(), // Meaning: all plugins which still have open actions.
				'install'  => array(),
				'update'   => array(),
				'activate' => array(),
			);

			foreach ( $instance->plugins as $slug => $plugin ) {
				if ( $instance->is_plugin_active( $slug ) && false === $instance->does_plugin_have_update( $slug ) ) {
					// No need to display plugins if they are installed, up-to-date and active.
					continue;
				} else {
					$plugins['all'][ $slug ] = $plugin;

					if ( ! $instance->is_plugin_installed( $slug ) ) {
						$plugins['install'][ $slug ] = $plugin;
					} else {
						if ( false !== $instance->does_plugin_have_update( $slug ) ) {
							$plugins['update'][ $slug ] = $plugin;
						}

						if ( $instance->can_plugin_activate( $slug ) ) {
							$plugins['activate'][ $slug ] = $plugin;
						}
					}
				}
			}

			return $plugins;
		}

		/**
		 * Register and enqueue class assets
		 */
		public function plugin_sctipts(){
			if(isset($_GET['page']) && $_GET['page'] == BEAdminMenu::$settings['menu-slug']) {
				wp_enqueue_script( 'be-plugin-manager', get_template_directory_uri().'/lib/admin-tpl/assets/js/plugin-manager.js', array( 'jquery' ), false, false );

				wp_localize_script( 'be-plugin-manager', 'envato_setup_params', array(
				'tgm_plugin_nonce' => array(
					'update'  => wp_create_nonce( 'tgmpa-update' ),
					'install' => wp_create_nonce( 'tgmpa-install' ),
				),
				'tgm_bulk_url'     => admin_url( $this->tgmpa_url ),
				'ajaxurl'          => admin_url( 'admin-ajax.php' ),
				'wpnonce'          => wp_create_nonce( 'envato_setup_nonce' ),
				'verify_text'      => esc_html__( '...verifying', 'oshin' ),
			) );
		}
			
		}
		public function ajax_plugins() {

			if ( ! check_ajax_referer( 'envato_setup_nonce', 'wpnonce' ) || empty( $_POST['slug'] ) ) {
				wp_send_json_error( array( 'error' => 1, 'message' => esc_html__( 'No Slug Found', 'oshin' ) ) );
			}
			$json = array();
			
			// send back some json we use to hit up TGM
			
			$plugins = $this->_get_plugins();
			// what are we doing with this plugin?

			foreach ( $plugins['activate'] as $slug => $plugin ) {
				if ( $_POST['slug'] == $slug ) {
					$json = array(
						'url'           => admin_url( $this->tgmpa_url ),
						'plugin'        => array( $slug ),
						'tgmpa-page'    => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
						'action'        => 'tgmpa-bulk-activate',
						'action2'       => - 1,
						'message'       => esc_html__( 'Activating Plugin', 'oshin' ),
					);
					break;
				}
			}
			
			foreach ( $plugins['install'] as $slug => $plugin ) {
				if ( $_POST['slug'] == $slug ) {
					$json = array(
						'url'           => admin_url( $this->tgmpa_url ),
						'plugin'        => array( $slug ),
						'tgmpa-page'    => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
						'action'        => 'tgmpa-bulk-install',
						'action2'       => - 1,
						'message'       => esc_html__( 'Installing Plugin', 'oshin' ),
					);
					break;
				}
			}

			if ( $json ) {
				$json['hash'] = md5( serialize( $json ) ); // used for checking if duplicates happen, move to next plugin
				wp_send_json( $json );
			} else {
				//wp_send_json( $json );
				wp_send_json( array( 'done' => 1, 'message' => esc_html__( 'Success', 'oshin' ) ) );
			}
			exit;

		}
	    /**
		 * Page setup
		 */
		public function envato_setup_default_plugins() {

			tgmpa_load_bulk_installer();
			// install plugins with TGM.
			if ( ! class_exists( 'TGM_Plugin_Activation' ) || ! isset( $GLOBALS['tgmpa'] ) ) {
				die( 'Failed to find TGM' );
			}
			$url     = wp_nonce_url( add_query_arg( array( 'plugins' => 'go' ) ), 'envato-setup' );
			$plugins = $this->_get_plugins();

			// copied from TGM

			$method = ''; // Leave blank so WP_Filesystem can populate it as necessary.
			$fields = array_keys( $_POST ); // Extra fields to pass to WP_Filesystem.

			if ( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, $fields ) ) ) {
				return true; // Stop the normal page form from displaying, credential request form will be shown.
			}

			// Now we have some credentials, setup WP_Filesystem.
			if ( ! WP_Filesystem( $creds ) ) {
				// Our credentials were no good, ask the user for them again.
				request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, $fields );

				return true;
			}

			/* If we arrive here, we have the filesystem */
			$this->update_plugins_order();
			?>
			<h2><?php esc_html_e( 'Default Plugins', 'oshin' ); ?></h2>
			<form method="post">
				<?php
				$plugins = $this->_get_plugins();				
				if ( count( $plugins['all'] ) ) {
					?>
					<p><?php esc_html_e( 'Your website needs a few essential plugins. The following plugins will be installed or updated:', 'oshin' ); ?></p>
					<ul class="envato-wizard-plugins">
						<?php foreach( $this->plugins_order as $slug ) {
							if( array_key_exists( $slug, $plugins[ 'all' ] ) ) {
								$plugin = $plugins[ 'all' ][ $slug ];
						?>
							<li data-slug="<?php echo esc_attr( $slug ); ?>">
								<?php echo esc_html( $plugin['name'] ); ?>
								<span>
									<?php
									$keys = array();
									if ( isset( $plugins['install'][ $slug ] ) ) {
										$keys[] = 'Installation';
									}
									
									if ( isset( $plugins['activate'][ $slug ] ) ) {
										$keys[] = 'Activation';
									}
									echo implode( ' and ', $keys ) . ' required';
									?>
								</span>
								<div class="loader"><span class="circle"></span></div>
								<span class="checkmark">
									<div class="checkmark_stem"></div>
									<div class="checkmark_kick"></div>
								</span>
							</li>
						<?php }
							}
						?>
					</ul>
					<?php
				} else {
					echo '<div class="notic notic-success ">';
					echo '<p><strong>' . esc_html__( 'Good news! All plugins are already installed and up to date. Please continue.', 'oshin' ) . '</strong></p>';
					echo '</div>';
				} ?>
				<?php if ( count( $plugins['all'] ) ) { ?>
				<p><?php esc_html_e( 'You can add and remove plugins later on from within WordPress.', 'oshin' ); ?></p>

				
					<input data-callback="install_plugins" type="submit" name="install" id="handle-plugins" class="panel-save button-primary" value="<?php esc_html_e( 'Install & Activate', 'oshin' ); ?>">
					<?php wp_nonce_field( 'envato-setup' ); ?>
				<?php } ?>
				
			</form>
			<?php
		}

		/**
		 * Get configured TGMPA instance
		 *
		 * @access public
		 * @since 1.0.0
		 */
		public function get_tgmpa_instanse() {
			$this->tgmpa_instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
		}

		/**
		 * Let TGMPA work on ajax also 
		 *
		 * @access public
		 * @since 1.0.0
		 */
		public function tgmpa_load( $status ) {
			return is_admin() && current_user_can( 'install_themes' );
		}

		/**
		 * Update $tgmpa_menu_slug and $tgmpa_parent_slug from TGMPA instance
		 *
		 * @access public
		 * @since 1.0.0
		 */
		public function set_tgmpa_url() {

			$this->tgmpa_menu_slug = ( property_exists( $this->tgmpa_instance, 'menu' ) ) ? $this->tgmpa_instance->menu : $this->tgmpa_menu_slug;
			$this->tgmpa_menu_slug = apply_filters( $this->theme_name . '_theme_setup_wizard_tgmpa_menu_slug', $this->tgmpa_menu_slug );

			$tgmpa_parent_slug = ( property_exists( $this->tgmpa_instance, 'parent_slug' ) && $this->tgmpa_instance->parent_slug !== 'themes.php' ) ? 'admin.php' : 'themes.php';

			$this->tgmpa_url = apply_filters( $this->theme_name . '_theme_setup_wizard_tgmpa_url', $tgmpa_parent_slug . '?page=' . $this->tgmpa_menu_slug );

		}

 }

if(!function_exists('BE_get_Plugins')) {
	function BE_get_Plugins() {
		global $BECore;
		return new BEPlugins($BECore);
	}
}
?>