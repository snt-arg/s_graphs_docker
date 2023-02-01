<?php
	class BE_Widget_Recent_Posts extends WP_Widget {
		function __construct() {
			$widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( "The most recent posts on your site",'oshin') );
			parent::__construct('be-recent-posts', __('BE Recent Posts','oshin'), $widget_ops);
			$this->alt_option_name = 'widget_recent_entries';

			// add_action( 'save_post', array(&$this, 'flush_widget_cache') );
			// add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
			// add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
		}

		function widget($args, $instance) {
			$cache = wp_cache_get('widget_recent_posts', 'widget');

			if ( !is_array($cache) )
				$cache = array();

			if ( ! isset( $args['widget_id'] ) )
				$args['widget_id'] = $this->id;

			if ( isset( $cache[ $args['widget_id'] ] ) ) {
				echo $cache[ $args['widget_id'] ];
				return;
			}

			ob_start();
			extract($args);
			$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts','oshin') : $instance['title'], $instance, $this->id_base);
			if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
				$number = 10;

			// $r = new WP_Query(array('posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true));
			$r = wp_get_recent_posts(array('numberposts' => $number, 'post_status' => 'publish'));
			
			echo $before_widget; 
			if ( $title ) echo $before_title . $title . $after_title; ?>
			<ul class="recent_post_container">
				<?php
				foreach( $r as $recent_post ){
					$post_id = $recent_post["ID"];
					$permalink = get_permalink( $post_id );
					if( !$permalink ) {
						$permalink = '#';
					}
					$post_title = $recent_post["post_title"]; ?>
					<li class="recent_posts clearfix sec-border-bottom">
						<?php if(has_post_thumbnail($post_id)){ ?>
						<div class="recent_post_img">
							<a href="<?php echo esc_url($permalink); ?>" title="<?php echo esc_attr($post_title ? $post_title : $post_id); ?>">
								<?php echo get_the_post_thumbnail($post_id, array( 50, 50 )); ?>
							</a>
						</div>
						<?php } ?>
						<div class="recent_post_content">
							<a href="<?php echo esc_url($permalink); ?>" title="<?php echo esc_attr($post_title ? $post_title : $post_id); ?>">
							<?php echo be_themes_trim_content($post_title,100); ?></a>
							<span class="recent-post-date"><?php echo get_the_date('F j,Y', $post_id);?></span>
						</div>
					</li><?php
				}?>
			</ul>
			<?php echo $after_widget; 
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();
			$cache[$args['widget_id']] = ob_get_flush();
			wp_cache_set('widget_recent_posts', $cache, 'widget');
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['number'] = (int) $new_instance['number'];
			//$this->flush_widget_cache();

			$alloptions = wp_cache_get( 'alloptions', 'options' );
			if ( isset($alloptions['widget_recent_entries']) )
				delete_option('widget_recent_entries');

			return $instance;
		}

		// function flush_widget_cache() {
		// 	wp_cache_delete('widget_recent_posts', 'widget');
		// }

		function form( $instance ) {
			$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
			$number = isset($instance['number']) ? absint($instance['number']) : 5;
			?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','oshin'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

			<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:','oshin'); ?></label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
		<?php
		}
	}
function Recent_Posts_init() {
	register_widget('BE_Widget_Recent_Posts');
}
add_action('widgets_init', 'Recent_Posts_init');
?>