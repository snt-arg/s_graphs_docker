<?php 
/**
 * Simple class to add help tabs on top of admin pages
 *
 * @package   Axiom
 * @author    averta [averta.net]
 * @license   LICENSE.txt
 * @link      http://averta.net
 * @copyright Copyright © 2014 averta
 */
 

if( ! class_exists( 'Axiom_Screen_Help' ) ) :

/**
 * Simple class to add help tabs on top of admin pages
 */
class Axiom_Screen_Help {
	
    /**
     * variable that holds tabs list
     * @var array
     */
    public $tabs = array();

    /**
     * A perfix to make tabs data filterable and extendable
     * @var string
     */
    public $filter_prefix = '';

    /**
     * __construct, assign screen hooks to display help tabs on target screens
     * 
     * @param array $tabs   an array containing help tabs list
     * @param string|array  $allowed_screen_ids  the screens id(s) that help tabs should be displayed on. 
     *                      Default value is 'all' that means help tabs will be displayed across all admin page
     */
	public function __construct( $tabs = '', $allowed_screen_ids = 'all', $prefix = 'axiom_help_tab_' ) {
	    
        // store passed tabs and prefix
        $this->tabs = (array)$tabs;
        $this->filter_prefix = $prefix;


        if( 'all' == $allowed_screen_ids ) {
            add_action( 'in_admin_header' , array( $this, 'display_help_panel' ), 10, 3 );
            return;
        }

        foreach ( (array)$allowed_screen_ids as $screen_id ) {
            add_action( 'load-' . $screen_id , array( $this, 'display_help_panel' ), 10, 3 );
        }
        
	}
    
    /**
     * Display output in panel
     * @return [type] [description]
     */
    public function display_help_panel() {
        
        $screen = get_current_screen();
        
        foreach ($this->tabs as $tab ) {
            
            if( empty( $tab ) )
                continue;

            if( !isset( $tab['id'] ) ) {
                _e( 'The help tab id is not valid.' );
                continue;
            }

            // Add help panel
            $screen->add_help_tab( apply_filters( $this->filter_prefix . $tab['id'] ,  $tab ) );
        }
    }

    /**
     * Store all tabs in $this->tabs 
     * @param array  an array containing list of all tabs
     */
    public function set_tabs( $tabs ){
        $this->tabs = $tabs;
    }

    /**
     * Add a tab to help tabs list
     * @example          array('id'        => 'the-tab-name-id',
     *                         'title'     => __( 'Tab Title' ),
     *                         'content'   => 'Tab contant' 
     *                        )
     * @param array  array containing tab data according to example
     */
    public function add_tab( $tab ){
        $this->tabs[] = $tab;
    }
    
}

endif;