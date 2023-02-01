<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if(!defined('ABSPATH')) exit();

if( ! class_exists( 'RevSliderGutenberg' ) ) {

	class RevSliderGutenberg {
		
		private $prefix;
		
		public function __construct($pre) {
			global $wp_version;
			
			$this->prefix = $pre;
			
			// add ThemePunch block category
			if(version_compare($wp_version, '5.8', '>=')){
				add_filter('block_categories_all', array($this, 'create_block_category'), 10, 2);
			}else{ //block_categories is deprecated since 5.8.0
				add_filter('block_categories', array($this, 'create_block_category'), 10, 2);
			}
			
			// Hook: Frontend assets.
			add_action( 'enqueue_block_assets', array( $this, 'revslider_gutenberg_cgb_block_assets' ) );
			
			// Hook: Editor assets.
			add_action( 'enqueue_block_editor_assets', array( $this, 'revslider_gutenberg_cgb_editor_assets' ) );
			
		}
		
		/**
		 * Check Array for Value Recursive
		 */
		private function in_array_r($needle, $haystack, $strict = false){
			if(is_array($haystack) && !empty($haystack)){
				foreach($haystack as $item){
					if(($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $strict))){
						return true;
					}
				}
			}
		
			return false;
		}
		
		/**
		 * Add ThemePunch Gutenberg Block Category
		 */
		public function create_block_category($categories, $post) {
			
			if($this->in_array_r('themepunch', $categories)){
				return $categories;
			}

			return array_merge($categories, array(array('slug' => 'themepunch', 'title' => __('ThemePunch', 'revslider'))));
		}

		/**
		 * Enqueue Gutenberg block assets for both frontend + backend.
		 *
		 * @uses {wp-editor} for WP editor styles.
		 * @since 1.0.0
		 */
		public function revslider_gutenberg_cgb_block_assets() { // phpcs:ignore
			// Styles.
			wp_enqueue_style(
				'revslider_gutenberg-cgb-style-css', // Handle.
				plugins_url( $this->prefix . 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
				array( 'wp-editor' ) // Dependency to include the CSS after it.
				// filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
			);
		}

		/**
		 * Enqueue Gutenberg block assets for backend editor.
		 *
		 * @uses {wp-blocks} for block type registration & related functions.
		 * @uses {wp-element} for WP Element abstraction — structure of blocks.
		 * @uses {wp-i18n} to internationalize the block's text.
		 * @uses {wp-editor} for WP editor styles.
		 * @since 1.0.0
		 */
		public function revslider_gutenberg_cgb_editor_assets() { // phpcs:ignore
			// Scripts.
			wp_enqueue_script(
				'revslider_gutenberg-cgb-block-js', // Handle.
				plugins_url( $this->prefix . 'dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
				array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), // Dependencies, defined above.
				// filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: File modification time.
				true // Enqueue the script in the footer.
			);

			// Styles.
			wp_enqueue_style(
				'revslider_gutenberg-cgb-block-editor-css', // Handle.
				plugins_url( $this->prefix . 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
				array( 'wp-edit-blocks' ) // Dependency to include the CSS after it.
				// filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
			);
		}
		
	}
	
}