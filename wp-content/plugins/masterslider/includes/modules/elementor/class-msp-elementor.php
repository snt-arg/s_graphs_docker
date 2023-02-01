<?php
namespace MasterSlider\Modules\Elementor;


/**
 * Elementor Element
 *
 * Custom Elementor extension.
 *
 * // @echo HEADER
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

/**
 * Main Elementor Elements Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Elements {

    /**
     * Plugin Version
     *
     * @since 1.0.0
     *
     * @var string The plugin version.
     */
    const VERSION = '1.0.0';

    /**
     * Minimum Elementor Version
     *
     * @since 1.0.0
     *
     * @var string Minimum Elementor version required to run the plugin.
     */
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    /**
     * Minimum PHP Version
     *
     * @since 1.0.0
     *
     * @var string Minimum PHP version required to run the plugin.
     */
    const MINIMUM_PHP_VERSION = '5.4.0';

    /**
     * Default elementor dir path
     *
     * @since 1.0.0
     *
     * @var string The defualt path to elementor dir on this plugin.
     */
    private $dir_path = '';


    /**
     * Default elementor dir url
     *
     * @since 1.0.0
     *
     * @var string The defualt url to elementor dir on this plugin.
     */
    private $dir_url = '';


    /**
     * Plugin version
     *
     * @since 1.0.0
     *
     * @var string The current version of the plugin.
     */
    private $version = '1.0.0';


    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     *
     * @var MasterSlider_Elementor The single instance of the class.
    */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     *
     * @access public
     * @static
     *
     * @return MasterSlider_Elementor An instance of the class.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
          self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init' ) );
    }

    /**
     * Initialize the plugin
     *
     * Load the plugin only after Elementor (and other plugins) are loaded.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.0.0
     *
     * @access public
    */
    public function init() {

        // Check if Elementor installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            return;
        }

        // Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
            return;
        }

        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
            return;
        }

        // Define elementor dir path
        $this->dir_path = MSWP_AVERTA_INC_DIR . '/modules/elementor';
        $this->dir_url  = MSWP_AVERTA_INC_URL . '/modules/elementor';

        $this->version  = MSWP_AVERTA_VERSION;

        // Include core files
        $this->includes();

        // Add required hooks
        $this->hooks();
    }

    /**
     * Include Files
     *
     * Load required core files.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function includes() {}

    /**
     * Add hooks
     *
     * Add required hooks for extending the Elementor.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function hooks() {

        // Register controls, widgets, and categories
        // add_action( 'elementor/elements/categories_registered' , array( $this, 'register_categories' ), 14 );
        add_action( 'elementor/widgets/widgets_registered'     , array( $this, 'register_widgets'    ), 14 );

        // Register Widget Styles
        // add_action( 'elementor/frontend/after_enqueue_styles'  , array( $this, 'widget_styles' ) );

        // Register Widget Scripts
        add_action( 'elementor/frontend/after_register_scripts', array( $this, 'widget_scripts' ) );

        // Register Editor Scripts
        // add_action( 'elementor/editor/before_enqueue_scripts'  , array( $this, 'editor_scripts' ) );
    }

    /**
     * Register widgets
     *
     * Register all auxin widgets which are in widgets list.
     *
     * @access public
     */
    public function register_widgets( $widgets_manager ) {

        include_once( $this->dir_path . '/widgets/masterslider.php' );
        $class_name = __NAMESPACE__ . '\\Elements\\' . 'MasterSlider';
        $widgets_manager->register_widget_type( new $class_name() );
    }

    /**
     * Register categories
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function register_categories( $categories_manager ) {
        // $categories = $categories_manager->get_categories();
        // $category_to_append_to = ! empty( $categories['auxin-core'] ) ? 'auxin-core' : 'general';
    }

    /**
     * Enqueue styles.
     *
     * Enqueue all the frontend styles.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function widget_styles() {
        // Add auxin custom styles
        // wp_enqueue_style( 'masterslider-elementor-widgets' , $this->dir_url . '/assets/css/elementor-widgets.css', null, $this->version );
    }

    /**
     * Enqueue scripts.
     *
     * Enqueue all the frontend scripts.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function widget_scripts() {
        wp_enqueue_script( 'masterslider-elementor-widgets' , $this->dir_url . '/assets/js/elementor-widgets.js' , array( 'jquery' ), $this->version );
    }

    /**
     * Enqueue scripts.
     *
     * Enqueue all the backend scripts.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function editor_scripts() {
        // Elementor Custom Style
        // wp_register_style(  'masterslider-elementor-editor', $this->dir_url . '/assets/css/elementor-editor.css', null, $this->version );
        // Elementor Custom Scripts
        // wp_register_script( 'masterslider-elementor-editor', $this->dir_url . '/assets/js/elementor-editor.js', null, $this->version );
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_minimum_elementor_version() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $message = sprintf(
          esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', MSWP_TEXT_DOMAIN ),
          '<strong>' . esc_html__( 'Master Slider Pro', MSWP_TEXT_DOMAIN ) . '</strong>',
          '<strong>' . esc_html__( 'Elementor', MSWP_TEXT_DOMAIN ) . '</strong>',
           self::MINIMUM_ELEMENTOR_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_minimum_php_version() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $message = sprintf(
          /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
          esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', MSWP_TEXT_DOMAIN ),
          '<strong>' . esc_html__( 'Master Slider Pro', MSWP_TEXT_DOMAIN ) . '</strong>',
          '<strong>' . esc_html__( 'PHP', MSWP_TEXT_DOMAIN ) . '</strong>',
           self::MINIMUM_PHP_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

}

Elements::instance();
