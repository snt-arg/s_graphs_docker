<?php

// Start
ob_start();

// Define
define( 'CUZTOM_VERSION', '1.6.1' );
if( ! defined( 'CUZTOM_URL' ) ) define( 'CUZTOM_URL', '' );
if( ! defined( 'CUZTOM_TEXTDOMAIN' ) ) define( 'CUZTOM_TEXTDOMAIN', 'be-themes' ); 
if( ! defined( 'CUZTOM_JQUERY_UI_STYLE' ) ) define( 'CUZTOM_JQUERY_UI_STYLE', 'cuztom' );

// Include
/**
 * General class with main methods and helper methods
 *
 * @author 	Gijs Jorissen
 * @since 	0.2
 *
 */
class Cuztom {
	var $url = array();
	
	// WordPress reserved terms
	static $_reserved = array( 'attachment', 'attachment_id', 'author', 'author_name', 'calendar', 'cat', 'category','category__and', 'category__in', 'category__not_in', 
		'category_name', 'comments_per_page', 'comments_popup', 'cpage', 'day', 'debug', 'error', 'exact', 'feed', 'hour', 'link_category', 
		'm', 'minute', 'monthnum', 'more', 'name', 'nav_menu', 'nopaging', 'offset', 'order', 'orderby', 'p', 'page', 'page_id', 'paged', 'pagename', 'pb', 
		'perm', 'post', 'post__in', 'post__not_in', 'post_format', 'post_mime_type', 'post_status', 'post_tag', 'post_type', 
		'posts', 'posts_per_archive_page', 'posts_per_page', 'preview', 'robots', 's', 'search', 'second', 'sentence', 'showposts', 
		'static', 'subpost', 'subpost_id', 'tag', 'tag__and', 'tag__in','tag__not_in', 'tag_id', 'tag_slug__and', 'tag_slug__in', 'taxonomy', 
		'tb', 'term', 'type', 'w', 'withcomments', 'withoutcomments', 'year' );

	/**
	 * Contructs the Cuztom class
	 * Adds actions
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.3
	 *
	 */
	function __construct() {
		$this->_determine_cuztom_url( dirname( __FILE__ ) );
	}
	
	
	/**
	 * Localizes scripts
	 * 
	 * @author 	Gijs Jorissen
	 * @since 	1.1.1
	 *
	 */
	function localize_scripts() {
		wp_localize_script( 'cuztom_js', 'Cuztom', array(
			'home_url'			=> get_home_url(),
			'ajax_url'			=> admin_url( 'admin-ajax.php' ),
			'date_format'		=> get_option( 'date_format' ),
			'remove_image'		=> __( 'Remove current image', CUZTOM_TEXTDOMAIN ),
			'remove_file'		=> __( 'Remove current file', CUZTOM_TEXTDOMAIN )
		) );
	}
	
	
	/**
	 * Beautifies a string. Capitalize words and remove underscores
	 *
	 * @param 	string 			$string
	 * @return 	string
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.1
	 *
	 */
	static function beautify( $string ) {
		return apply_filters( 'cuztom_beautify', ucwords( str_replace( '_', ' ', $string ) ) );
	}
	
	
	/**
	 * Uglifies a string. Remove underscores and lower strings
	 *
	 * @param 	string 			$string
	 * @return 	string
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.1
	 *
	 */
	static function uglify( $string ) {
		return apply_filters( 'cuztom_uglify', str_replace( '-', '_', sanitize_title( $string ) ) );
	}
	
	
	/**
	 * Makes a word plural
	 *
	 * @param 	string 			$string
	 * @return 	string
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.1
	 *
	 */
	static function pluralize( $string ) {
		$last = $string[strlen( $string ) - 1];
		
		if( $last != 's' )
		{
			if( $last == 'y' )
			{
				$cut = substr( $string, 0, -1 );
				//convert y to ies
				$string = $cut . 'ies';
			}
			else
			{
				// just attach a s
				$string = $string . 's';
			}
		}
		
		return apply_filters( 'cuztom_pluralize', $string );
	}


	function _is_wp_callback( $callback ) {
		return ( ! is_array( $callback ) ) || ( is_array( $callback ) && ( ( isset( $callback[1] ) && ! is_array( $callback[1] ) && method_exists( $callback[0], $callback[1] ) ) || ( isset( $callback[0] ) && ! is_array( $callback[0] ) && class_exists( $callback[0] ) ) ) );
	}
	
	
	/**
	 * Recursive method to determine the path to the Cuztom folder
	 *
	 * @param 	string 			$path
	 * @return 	string
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.4.1
	 *
	 */
	function _determine_cuztom_url( $path = __FILE__ ) {
		if( defined( 'CUZTOM_URL' ) && CUZTOM_URL != '' )
		{
			$this->url = CUZTOM_URL;
		}
		else
		{
			$path = dirname( $path );
			$path = str_replace( '\\', '/', $path );
			$explode_path = explode( '/', $path );
			
			$current_dir = $explode_path[count( $explode_path ) - 1];
			array_push( $this->url, $current_dir );
			
			if( $current_dir == 'wp-content' )
			{
				// Build new paths
				$path = '';
				$directories = array_reverse( $this->url );
				
				foreach( $directories as $dir )
				{
					$path = $path . '/' . $dir;
				}

				$this->url = $path;
			}
			else
			{
				return $this->_determine_cuztom_url( $path );
			}
		}
	}
	
	static function is_reserved_term( $term ) {
	    if( ! in_array( $term, self::$_reserved ) ) return false;
	    
	    return new WP_Error( 'reserved_term_used', __( "Use of a reserved term", CUZTOM_TEXTDOMAIN ) );
	}
}

include( 'post_type.class.php' );
include( 'taxonomy.class.php' );

// Init
$cuztom = new Cuztom();