<?php
/**
 * Master Slider Pointers Class.
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



class MSP_Pointers {
	
    /*  */
    public $pointers     = array();
    public $seen_ids     = array();
    public $not_seen_pointers = array();
    public $version_file = '';
    
    /**
     * Set theme or plugine file path to get version from
     * @param string $version_file   a path to plugin or theme file to get and compare version with it
     */
	function __construct( $version_file = '' ) {
        $this->version_file = $version_file;
    }
    
    
    
    public function add( $options = array() ){
        // return if no data passed
        if( empty( $options ) || ! is_array( $options ) ) return false;
        
        $options = array_merge( $this->default_point(), $options );
        // add pointer to pointers list
        $this->pointers[] = $options;
        
        return true;
    }
    
    
    
    
    public function init(){
        global $wp_version;

        if ( version_compare( $wp_version, '3.4', '<' ) )
            return false;
        
        if( ! count( $this->pointers) ) return "No Point Available.";
        
        add_action( 'admin_enqueue_scripts'     , array( $this, 'add_hooks' ) );
        add_action( 'admin_print_footer_scripts', array( $this, 'print_pointer_scripts' ) );
        return true;
    }
    
    
    
    
    
    public function add_hooks(){
        if ( ! current_user_can( 'manage_options' ) ) return;
        
        if( ! count( $this->pointers ) ) return false;
        
        $this->seen_ids = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
        
        foreach ( $this->pointers as $key => $pointer_data ) {
            if( ! in_array( $pointer_data["id"], $this->seen_ids ) )
                $this->not_seen_pointers[] = $pointer_data;
        }
        
        if( count( $this->not_seen_pointers ) ) {
            /* Load wp-pointer scripts and styles */
            wp_enqueue_style ( 'wp-pointer' );
            wp_enqueue_script( 'wp-pointer' );
            
            add_action( 'admin_print_footer_scripts', array( $this, 'print_pointer_scripts' ) );
        }
        
        return true;
    }
    
    
    
    
    
    
    public function print_pointer_scripts() {
        if ( ! current_user_can( 'manage_options' ) ) return;
        
        global $hook_suffix;

        $info = empty( $this->version_file ) ? wp_get_theme() : get_plugin_data( $this->version_file );
        
        foreach ( $this->not_seen_pointers as $key => $pointer_data ) {
            // check if we are on correct page to display pointer
            if( ! empty( $pointer_data["hook_suffix"] ) && $pointer_data["hook_suffix"] != $hook_suffix ) continue;
            // display pointer for specified theme version and above
            if( version_compare( $info["Version"], $pointer_data["version"], '<' ) ) continue;
?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            if( typeof(jQuery().pointer) != 'undefined' ) {
                $('<?php echo $pointer_data["target"]; ?>').pointer({
                    content: '<?php printf('<h3>%s</h3><p>%s</p>', $pointer_data["title"],$pointer_data["content"]); ?>',
                    pointerClass: '<?php echo $pointer_data["id"]; ?>',
                    pointerWidth: <?php echo isset( $pointer_data["width"] ) ? (int) $pointer_data["width"] : 320; ?>,
                    position: {
                        edge: '<?php echo $pointer_data["position"]["edge"]; ?>',
                        align: '<?php echo $pointer_data["position"]["align"]; ?>'
                    },
                    close: function() {
                        $.post( ajaxurl, {
                            pointer: '<?php echo $pointer_data["id"]; ?>',
                            action: 'dismiss-wp-pointer'
                        });
                    }
                }).pointer('open');
            }
        });
    </script>
<?php
        if( isset( $pointer_data["css"] ) )
            printf( '<style>%s</style>', $pointer_data["css"] );
        }
    }
    
    
    
    
    public function default_point(){
        return array(
                    'id'         => 'mspo',        // Unique id for pointer
                    'hook_suffix'=> '',            // Screen hook suffix to show pointer on [empty means display every where on admin] (dashboard : index.php)
                    'target'     => '#menu-settings',// CSS selector to hang the pointer to that element
                    'version'    => '1',           // The theme or plugin version to display tooltip on
                    'title'      => '',            // Tooltip title
                    'content'    => '',            // Tooltip description
                    'position'   =>  array( 
                                         'edge'  => 'left',  //top, bottom, left, right
                                         'align' => 'middle' //top, bottom, left, right, middle
                                        )
                    );
    }
}


/*-----------------------------------------------------------------------------------*/
/*  Display Admin Pointers
/*-----------------------------------------------------------------------------------*/

function msp_add_custom_pointers(){
    
    // admin pointers /////////////////////////////////////////////////////////
    $msp_pointers = new MSP_Pointers( MSWP_AVERTA_DIR . '/masterslider.php' );
    $msp_pointers->add( array(
                            'id'         => 'master_1_0_view_help',         // Unique id for pointer
                            'hook_suffix'=> 'toplevel_page_masterslider',   // Screen hook suffix to show pointer on [empty means display every where on admin] (dashboard : index.php)
                            'target'     => '#contextual-help-link',        // CSS selector to hang the pointer to that element
                            'version'    => '1.0.0',                        // The theme or plugin version to display tooltip on
                            'title'      => __( 'Do you need any help on Master Slider?', MSWP_TEXT_DOMAIN ),  // Tooltip title
                            'content'    => sprintf( __( 'Please open contextual help panel (click the %s button at top right side of this page)', MSWP_TEXT_DOMAIN ), '<strong style="color:#1D86AC;">'.__( 'Help', MSWP_TEXT_DOMAIN ).'</strong>' ), // Tooltip description
                            'width'      => 370,
                            'css'        => '.master_1_0_view_help { left:auto !important; right:20px !important; } .master_1_0_view_help .wp-pointer-arrow { left:auto !important; right:25px; }',
                            'position'   => array( 
                                                'edge'  => 'top',   //top, bottom, left, right
                                                'align' => 'middle' //top, bottom, left, right, middle
                                                )
                            )
                       );
    
    
    $msp_pointers->add( array(
                            'id'         => 'msp_1_4_3__25samples',   // Unique id for pointer
                            'hook_suffix'=> 'toplevel_page_masterslider',       // Screen hook suffix to show pointer on [empty means display every where on admin] (dashboard : index.php)
                            'target'     => '#msp-add-slider',      // CSS selector to hang the pointer to that element
                            'version'    => '1.5.0',                            // The theme or plugin version to display tooltip on
                            'title'      => __( 'Start with 33 Ready to Use Sample Sliders', MSWP_TEXT_DOMAIN ),  // Tooltip title
                            'content'    => __( 'You can create your slider from scratch or use one of 33 ready to use sample sliders to start', MSWP_TEXT_DOMAIN ), // Tooltip description
                            'width'      => 370,
                            'css'        => '.msp_1_4_3__25samples { left:182px !important; } ',
                            'position'   =>  array( 
                                                 'edge'  => 'top',   //top, bottom, left, right
                                                 'align' => 'middle' //top, bottom, left, right, middle
                                                )
                            )
                       );
                          
    $msp_pointers->init();
    
}

msp_add_custom_pointers();

?>