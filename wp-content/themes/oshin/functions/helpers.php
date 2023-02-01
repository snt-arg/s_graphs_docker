<?php

/* ---------------------------------------------  */
// Function to print pagination 
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_pagination' ) ) :
	function be_themes_pagination( $pages = '', $range = 3 ) {  
		$showitems = ( $range * 2 ) + 1;  
		global $paged;
		if( empty( $paged ) ) { 
			$paged = 1;
		}
		if( $pages == '' ) {
		    global $wp_query;
		    $pages = $wp_query->max_num_pages;
		    if( !$pages ) {
		        $pages = 1;
		    }
		}   
		if( 1 != $pages ) {
		    echo '<div class="pagination secondary_text"><span class="sec-bg sec-color">Page '.$paged.' of '.$pages.'</span>';
		    if( $paged > 2 && $paged > $range+1 && $showitems < $pages ) {
		    	echo "<a href='".get_pagenum_link(1)."' class='sec-bg sec-color'>&laquo; ".__('First','oshin')."</a>";
		    }
		    if( $paged > 1 && $showitems < $pages ) { 
		    	echo "<a href='".get_pagenum_link($paged - 1)."' class='sec-bg sec-color'>&lsaquo; ".__('Prev','oshin')."</a>";
		    }

		    for ( $i=1; $i <= $pages; $i++ ) {
		        if ( 1 != $pages && ( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ) ) {
		            echo ( $paged == $i) ? "<span class='current alt-bg alt-bg-text-color'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive sec-bg sec-color' >".$i."</a>";
		        }
		    }

		    if ( $paged < $pages && $showitems < $pages ) {
		    	echo "<a href='".get_pagenum_link($paged + 1)."' class='sec-bg sec-color'>".__('Next','oshin')." &rsaquo;</a>";  
		    }
		    if ( $paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages ) { 
		    	echo "<a href='".get_pagenum_link($pages)."' class='sec-bg sec-color'>".__('Last','oshin')." &raquo;</a>";
		    }
		    echo "</div>\n";
		}
	}
endif;
/* ---------------------------------------------  */
// Function to customize archives widget
/* ---------------------------------------------  */
if ( ! function_exists( 'be_archives' ) ) :
	function be_archives( $args ) {
		$args['format'] = "custom";
		$args['before'] = "<li class='swap_widget_archive'>";
		$args['after'] = "</li>";
		return $args;
	}
	add_filter( 'widget_archives_args', 'be_archives' );
endif;
/* ---------------------------------------------  */
// Function to trim content to the required characters
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_trim_content' ) ) :
	function be_themes_trim_content( $content, $count ) {
		if(strlen( $content ) > $count ) {
			return substr( $content, 0, $count ).'. . .';
		} else {
			return substr( $content, 0, $count );
		}
	}
endif;

/* ---------------------------------------------  */
// Function to print categories
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_category_list' ) ) :
	function be_themes_category_list( $id ) {
		global $blog_attr, $be_themes_data;
		$category_color = '';
		$category_bg_color = '';
		$cat_list = [];
		foreach( ( get_the_category( $id ) ) as $key => $category ) {
			if ( in_array( $category->cat_ID, $cat_list ) ) {
				continue;
			}
			if($be_themes_data['blog_style'] == 'style8'){
				$category_bg_color = get_term_meta($category->cat_ID,'be_catg_bg_color', true);
				$category_color = get_term_meta($category->cat_ID,'be_catg_color', true);
				if( empty( $category_bg_color ) && !empty($be_themes_data['color_scheme']) ){
					$category_bg_color = $be_themes_data['color_scheme'];
				}else{
					$category_bg_color = "#".$category_bg_color;
				}

				if( empty( $category_color ) && !empty($be_themes_data['alt_bg_text_color'])){
					$category_color = $be_themes_data['alt_bg_text_color'];
				}else{
					$category_color = "#".$category_color;
				}
			}
			echo ( ( $key == 0 ) ? '' : ', ' ) . '<a href="'.get_category_link( $category->cat_ID ).'" style= "color: '.$category_color.';" data-background-color = "'.$category_bg_color.'" title="'.__('View all posts in','oshin').' '.$category->cat_name.'"> '.$category->cat_name.'</a>' ;
			$cat_list[] = $category->cat_ID;
		}
	}
endif;


/* ---------------------------------------------  */
// Function to retrieve footer widgets
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_get_footer_widget' ) ) :
	function be_themes_get_footer_widget( $widget_name ) {
		global $be_themes_data; 

		switch ($widget_name) {
			case 'text1': ?>
				<?php  echo do_shortcode($be_themes_data['footer_text1']); ?><?php
				break;
			
			case 'text2': ?>
				<?php  echo do_shortcode($be_themes_data['footer_text2']); ?><?php
				break;

			case 'text3': ?>
				<?php  echo do_shortcode($be_themes_data['footer_text3']); ?><?php
				break;

			case 'menu': 
				be_themes_get_footer_navigation();
				break;

			default:
				# code...
				break;
		}
	}
endif;
/* ---------------------------------------------  */
// Function to retrieve post slug
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_get_the_slug' ) ) :
	function be_themes_get_the_slug( $post_id ) {
	    $post_data = get_post( $post_id, ARRAY_A );
	    $slug = $post_data['post_name'];
	    return $slug; 
	}
endif;
/* ---------------------------------------------  */
// Function to retrieve post ID from slug
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_get_id_by_slug' ) ) :
	function be_themes_get_id_by_slug( $post_slug ) {
		$args=array(
			'post_type' => 'portfolio',
			'name' => $post_slug,
			'post_status' => 'publish',
			'showposts' => 1,
			'ignore_sticky_posts'=> 1,
		);
		$my_posts = get_posts( $args );
		if( $my_posts )
			return $my_posts[0]->ID;
		else
			return null;
	}
endif;
/* ---------------------------------------------  */
// Functions for like, tweet and plusone buttons 
/* ---------------------------------------------  */
if (!function_exists('be_themes_get_facebook_button')) {
	function be_themes_get_facebook_button( $url ){
		$out = "<iframe src='//www.facebook.com/plugins/like.php?href=".urlencode($url)."&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35&amp;appId=173868296037629' scrolling='no' frameborder='0' style='border:none; overflow:hidden; width:100px; height:20px;' allowTransparency='true'></iframe>";
		return $out;
	}
}

if (!function_exists('be_themes_get_twitter_button')) {
	function be_themes_get_twitter_button( $url ){
		$out = '<iframe allowtransparency="true" data-count="true" frameborder="0" scrolling="no" src="http://platform.twitter.com/widgets/tweet_button.html?url='.$url.'&via=xtapit&text=test" style="width:90px; height:20px;"></iframe>';
		return $out;
	}
}
if (!function_exists('be_themes_get_googleplus_button')) {
	function be_themes_get_googleplus_button( $url ){
		$out = "<iframe src='https://plusone.google.com/_/+1/fastbutton?url='".$url."'&amp;size=medium&amp;count=true&amp;lang='en' scrolling='no' frameborder='0' style='border:none; overflow:hidden; width:65px; height:24px;'></iframe>";
		return $out;
	}
}
/* ---------------------------------------------  */
// Display Next and Previous posts links in blog
/* ---------------------------------------------  */
if ( ! function_exists( 'be_content_nav' ) ) :
	function be_themes_content_nav( $nav_id ) {
		global $wp_query;
		if ( $wp_query->max_num_pages > 1 ) : ?>
			<nav id="<?php echo $nav_id; ?>" class="blog-nav clearfix">
			<div class="nav-previous left"><?php next_posts_link( __( 'Older posts', 'oshin' ) ); ?></div>
			<div class="nav-next right"><?php previous_posts_link( __( 'Newer posts', 'oshin' ) ); ?></div>
			</nav><!-- #nav-above -->
		<?php endif;
	}
endif;
/* ---------------------------------------------  */
//
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_custom_excerpt_length' ) ) :
	function be_themes_custom_excerpt_length( $length ) {
		return 30;
	}
	add_filter( 'excerpt_length', 'be_themes_custom_excerpt_length', 999 );
endif;
/* ---------------------------------------------  */
// HTML5 Search & Comment Forms
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_html5_search_form' ) ) :
	function be_themes_html5_search_form( $form ) {
	    $form = '<form role="search" method="get" class="searchform" action="' . home_url( '/' ) . '" >
	    <input type="text" placeholder="'.__( 'Search ...' , 'oshin' ).'" value="' . get_search_query() . '" name="s" class="s" />
	    <i class="search-icon icon-search font-icon"></i>
	    <input type="submit" class="search-submit" value="" />
	    </form>';

	    return $form;
	}
	add_filter( 'get_search_form', 'be_themes_html5_search_form' );
endif;

//HTML5 comment form
if ( ! function_exists( 'be_themes_comments_form' ) ) :
	function be_themes_comments_form() {
		$req = get_option( 'require_name_email' );
		$fields =  array (
			'author' => '<p class="no-margin"><input id="author" name="author" type="text" value="" aria-required="true" placeholder = "'.__('Name', 'oshin').'"' . ( $req ? ' required' : '' ) . '/></p>',
			'email'  => '<p class="no-margin"><input id="email" name="email" type="text" value="" aria-required="true" placeholder="'.__('Email', 'oshin').'"' . ( $req ? ' required' : '' ) . ' /></p>',
			'url'    => '<p class="no-margin"><input id="url" name="url" type="text" value="" placeholder="'.__('Website', 'oshin').'" /></p>',
		);
		return $fields;
	}
	add_filter( 'comment_form_default_fields', 'be_themes_comments_form' );
endif;
/* ---------------------------------------------  */
// Function to handle blog comments
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_comments' ) ) :
	function be_themes_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
		?>
		<li class="post pingback clearfix">
			<p><?php echo ucfirst( $comment->comment_type ).":  "; comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'oshin' ) , '<span class="edit-link">', '</span>' ); ?></p>
		<?php
				break;
			default :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment sec-border-bottom clearfix">
				<div class="comment-author vcard">
						<div class="comment-author-inner">
						<?php
							$avatar_size = 68;
							if ( '0' != $comment->comment_parent ) {
								$avatar_size = 60;
							}
							echo get_avatar( $comment, $avatar_size ); ?>
							<span class="reply"> <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __('Reply','oshin'), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>
						</div>
				</div><!-- .comment-author .vcard -->
				
				<div class="comment-content">
				
					<footer class="comment-meta">
					<?php

							printf( __('%1$s','oshin'),
								sprintf( '<h6 class="fn">%s</h6>', get_comment_author_link() )
							);
							printf( __('%1$s','oshin'),
								sprintf( '<time datetime="%2$s">%3$s</time>',
									esc_url( get_comment_link( $comment->comment_ID ) ),
									get_comment_time( 'c' ),
									/* translators: 1: date, 2: time */
									sprintf( '%1$s', get_comment_date('d F Y') )
								)
							);
					

						?>

						
					

					<?php if ( $comment->comment_approved == '0' ) : ?>
						<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.','oshin' ); ?></em>
						<br />
					<?php endif; ?>

					</footer>
					<div class="comment_text">
						<?php comment_text(); ?>
					</div>
					<ul class="comment-edit-reply clearfix">
						<?php edit_comment_link( '<i class="font-icon icon-icon_pencil"></i>', '<li class="edit-link">', '</li>' ); ?>
					</ul>
				</div>


			</article><!-- #comment-## -->

		<?php
				break;
		endswitch;
	}
endif;
/* ---------------------------------------------  */
// Filter to handle empty search query
/* ---------------------------------------------  */
// if ( ! function_exists( 'be_themes_request_filter' ) ) :
// 	function be_themes_request_filter( $query_vars ) {
// 	    if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
// 	        $query_vars['s'] = " ";
// 	    }
// 	    return $query_vars;
// 	}
// 	add_filter( 'request', 'be_themes_request_filter' );
// endif;
/* ---------------------------------------------  */
// Filter to remove empty widget title <h> tags
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_empty_widget_title' ) ) :
	function be_themes_empty_widget_title($title) {
	    return $title == '&nbsp;' ? '' : $title;
	}
	add_filter( 'widget_title', 'be_themes_empty_widget_title' ); 
endif;
/* ---------------------------------------------  */
// Filter to execute shortcodes in widgets
/* ---------------------------------------------  */
add_filter( 'widget_text', 'do_shortcode' );
/* ---------------------------------------------  */
// Filter to add custom Tiny MCE buttons
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_tinyplugin_add_button' ) ) :
	function be_themes_tinyplugin_add_button( $buttons ) {
	    // array_push( $buttons, '|', 'tinyplugin', 'linebreak', 'letter-spacing', 'text-shadow' );
	    array_push( $buttons, '|', 'tinyplugin', 'letter-spacing');
		return $buttons;
	}
	add_filter( 'mce_buttons', 'be_themes_tinyplugin_add_button', 0 );
endif;

if ( ! function_exists( 'be_themes_tinyplugin_register' ) ) :
	function be_themes_tinyplugin_register( $plugin_array ) {
	    $url = trim( get_template_directory_uri(), "/" )."/tinymce/editor_plugin_src.js";
	    $plugin_array['tinyplugin'] = $url;
		$plugin_array['letter-spacing'] = $url;
		// $plugin_array['text-shadow'] = $url;
	    return $plugin_array;
	}
	add_filter( 'mce_external_plugins', 'be_themes_tinyplugin_register' );
endif;

if ( ! function_exists( 'be_themes_mce_buttons_2' ) ) :
	function be_themes_mce_buttons_2( $buttons ) {
		array_unshift( $buttons, 'fontsizeselect', 'styleselect' );
		return $buttons;
	}
	add_filter( 'mce_buttons_2', 'be_themes_mce_buttons_2' );
endif;

if ( ! function_exists( 'be_mce_before_init' ) ) :
	function be_mce_before_init( $settings ) {
		$style_formats = array (
			array (
				'title' => '1px',
				'inline' => 'span',
				'styles' => array(
					'letter-spacing' => '1px',
				)
			),
			array (
				'title' => '2px',
				'inline' => 'span',
				'styles' => array(
					'letter-spacing' => '2px',
				)
			),
			array (
				'title' => '3px',
				'inline' => 'span',
				'styles' => array(
					'letter-spacing' => '3px',
				)
			),
			array (
				'title' => '4px',
				'inline' => 'span',
				'styles' => array(
					'letter-spacing' => '4px',
				)
			),
			array (
				'title' => '5px',
				'inline' => 'span',
				'styles' => array(
					'letter-spacing' => '5px',
				)
			),
			array (
				'title' => '6px',
				'inline' => 'span',
				'styles' => array(
					'letter-spacing' => '6px',
				)
			),
			array (
				'title' => '7px',
				'inline' => 'span',
				'styles' => array(
					'letter-spacing' => '7px',
				)
			),
			array (
				'title' => '8px',
				'inline' => 'span',
				'styles' => array(
					'letter-spacing' => '8px',
				)
			),
			array (
				'title' => '9px',
				'inline' => 'span',
				'styles' => array(
					'letter-spacing' => '9px',
				)
			),
			array (
				'title' => '10px',
				'inline' => 'span',
				'styles' => array(
					'letter-spacing' => '10px',
				)
			)
		);
		$settings['style_formats'] = json_encode( $style_formats );
		return $settings;
	}
	add_filter( 'tiny_mce_before_init', 'be_mce_before_init' );
endif;

/* ---------------------------------------------  */
// Filter to adjust tag could font size
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_tag_font' ) ) :
	function be_themes_tag_font( $args ) {
	  $args['smallest'] = 11;
	  $args['largest'] = 11;
	  $args['unit'] =  'px';	  
	  return $args;
	}
	add_filter( 'widget_tag_cloud_args' , 'be_themes_tag_font' );
endif;

if ( ! function_exists( 'be_themes_get_excerpt' ) ) :
	function be_themes_get_excerpt( $post_id, $length=45 ) {
	    $the_post = get_post( $post_id ); //Gets post ID
	    $the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
	    $excerpt_length = $length; //Sets excerpt length by word count
	    $the_excerpt = strip_tags( strip_shortcodes( $the_excerpt ) ); //Strips tags and images
	    $words = explode( ' ', $the_excerpt, $excerpt_length + 1 );

	    if( count( $words ) > $excerpt_length ) :
	        array_pop( $words );
	        array_push( $words, '...' );
	        $the_excerpt = implode( ' ', $words );
	    endif;

	    return $the_excerpt;
	}
endif;
/* ---------------------------------------------  */
// Add Video URL field to media uploader
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_attachment_field_add' ) ) :
	function be_themes_attachment_field_add( $form_fields, $post ) {
		
		$height_checked = ("1" == get_post_meta( $post->ID, 'be_themes_height_wide', true )) ? 'checked="checked"' : '';
		$width_checked = ("1" == get_post_meta( $post->ID, 'be_themes_width_wide', true )) ? 'checked="checked"' : '';

		$form_fields['be-themes-featured-video-url'] = array(
			'label' => 'Youtube/Vimeo/Self-Hosted MP4 Video URL',
			'input' => 'text',
			'value' => get_post_meta( $post->ID, 'be_themes_featured_video_url', true ),
			'helps' => 'Enter a Youtube/Vimeo/Self-Hosted MP4 Video URL to be linked to the featured image',
		);
		$form_fields['be-themes-external-link'] = array(
			'label' => 'Custom Slider Caption To Link',
			'input' => 'text',
			'value' => get_post_meta( $post->ID, 'be_themes_external_link', true ),
			'helps' => '',
		);
		$form_fields['be-themes-double-height'] = array(
			'label' => 'Double Height',
        	'input' => 'html',
        	'html'  => "<br /><input type=\"checkbox\"
            			name=\"attachments[{$post->ID}][be-themes-double-height]\"
            			id=\"attachments[{$post->ID}][be-themes-double-height]\"
            			value=\"1\" {$height_checked}/><br />",            
			'helps' => '',
		);
		$form_fields['be-themes-double-width'] = array(
			'label' => 'Double Width',
        	'input' => 'html',
        	'html'  => "<br /><input type=\"checkbox\"
            			name=\"attachments[{$post->ID}][be-themes-double-width]\"
            			id=\"attachments[{$post->ID}][be-themes-double-width]\"
            			value=\"1\" {$width_checked}/><br />",            
			'helps' => '',
		);
		return $form_fields;
	}
	add_filter( 'attachment_fields_to_edit', 'be_themes_attachment_field_add', 10, 2 );
endif;

if ( ! function_exists( 'be_themes_attachment_field_save' ) ) :
	function be_themes_attachment_field_save( $post, $attachment ) {
		if( isset( $attachment['be-themes-featured-video-url'] ) ) {
			update_post_meta( $post['ID'], 'be_themes_featured_video_url', $attachment['be-themes-featured-video-url'] );
		}

		if( isset( $attachment['be-themes-external-link'] ) ) {
			update_post_meta( $post['ID'], 'be_themes_external_link', $attachment['be-themes-external-link'] );
		}

		if( isset( $attachment['be-themes-double-height'] ) ) {
			update_post_meta( $post['ID'], 'be_themes_height_wide', 1 );
		}else {
			update_post_meta( $post['ID'], 'be_themes_height_wide', 0 );
		}

		if( isset( $attachment['be-themes-double-width'] ) ) {
			update_post_meta( $post['ID'], 'be_themes_width_wide', 1 );
		}else {
			update_post_meta( $post['ID'], 'be_themes_width_wide', 0 );
		}


		return $post;
	}
	add_filter( 'attachment_fields_to_save', 'be_themes_attachment_field_save', 10, 2 );
endif;
/* ---------------------------------------------  */
// Breadcrumbs
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_breadcrumb' ) ) :
	function be_themes_breadcrumb() {
		global $post;
	    $sep = '  /  ';
	    if ( ! is_front_page() ) {
	        echo '<div class="breadcrumbs">';
	        echo '<a href="';
	        echo home_url();
	        echo '">';
	        echo __( 'Home', 'oshin' );
	        echo '</a>' . $sep;
	        if ( ( is_category() || is_single() ) && ! is_singular( 'portfolio' ) ) {
	            the_category( ' / ' );
	        } elseif ( ( is_archive() || is_single() ) && is_singular( 'portfolio' ) ) {
	            if ( is_day() ) {
	                printf( __( '%s', 'oshin' ), get_the_date() );
	            } elseif ( is_month() ) {
	                printf( __( '%s', 'oshin' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'oshin' ) ) );
	            } elseif ( is_year() ) {
	                printf( __( '%s', 'oshin' ), get_the_date( _x( 'Y', 'yearly archives date format', 'oshin' ) ) );
	            } else {
	                _e( 'Portfolio Archives', 'oshin' );
	            }
	        } elseif ( ( is_archive() || is_single() ) && !is_singular( 'portfolio' ) ) {
	            if ( is_day() ) {
	                printf( __( '%s', 'oshin' ), get_the_date() );
	            } elseif ( is_month() ) {
	                printf( __( '%s', 'oshin' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'oshin' ) ) );
	            } elseif ( is_year() ) {
	                printf( __( '%s', 'oshin' ), get_the_date( _x( 'Y', 'yearly archives date format', 'oshin' ) ) );
	            } else {
	                _e( 'Blog Archives', 'oshin' );
	            }
	        }

	        if( is_singular('portfolio') ) {
	            echo get_the_term_list( $post->ID, 'portfolio_categories','','  /  ' ); 
	        }

	        if ( is_single() ) {
	            echo $sep;
	            the_title();
	        }

	        if ( is_page() ) {
	        	$parents = get_ancestors( get_the_ID(),'page' );
	        	$parents_rev = array_reverse($parents);
	        	if( !empty( $parents ) ){
	        		foreach ( $parents as $parent ) {
	        			echo '<a href="'.get_permalink($parent).'">'.get_the_title( $parent ).'</a> / ';
	        		}
	        	}
	            echo the_title();
	        }

	        if ( is_home() ){
	            global $post;
	            $page_for_posts_id = get_option( 'page_for_posts' );
	            if ( $page_for_posts_id ) { 
	                $post = get_page( $page_for_posts_id );
	                setup_postdata( $post );
	                the_title();
	                rewind_posts();
	            }
	        }

	        echo '</div>';
	    }
	}
endif;

if ( ! function_exists( 'get_be_themes_breadcrumb' ) ) :
	function get_be_themes_breadcrumb() {
		global $post;
	    $sep = '  /  ';
		$output = '';
	    if ( ! is_front_page() ) {
	        $output .= '<div class="breadcrumbs">';
	        $output .= '<a href="';
	        $output .= home_url();
	        $output .= '">';
	        $output .= __( 'Home', 'oshin' );
	        $output .= '</a>' . $sep;
	        if ( ( is_category() ) && ! is_singular( 'portfolio' ) ){
	            $output .= be_themes_get_category_list( get_the_ID() );
				$output .= $sep;
	        } else if( is_singular( 'post' ) ) {
				$blog_page_id = get_option( 'page_for_posts');
				if($blog_page_id) {
					$output .= '<a href="'.get_permalink($blog_page_id).'">'.__( 'Blog', 'oshin' ).'</a>';
					$output .= $sep;
				}
			} else if( is_singular( 'product' ) ) {
				$shop_page_id = wc_get_page_id( 'shop' );
				if($shop_page_id) {
					$output .= '<a href="'.get_permalink($shop_page_id).'">'.__( 'Shop', 'oshin' ).'</a>';
					$output .= $sep;
				}
			}  elseif ( ( is_archive() || is_single() ) && (is_tax( 'portfolio_categories' ) || is_tax( 'portfolio_tags' ))) {
				global $wp_query;
				$term =	$wp_query->queried_object;
	            if ( is_day() ) {
	                $output .= get_the_date();
	            } elseif ( is_month() ) {
	                $output .= get_the_date( _x( 'F Y', 'monthly archives date format', 'oshin' ) ) ;
	            } elseif ( is_year() ) {
	                $output .=  get_the_date( _x( 'Y', 'yearly archives date format', 'oshin' ) );
	            } elseif(is_tax( 'portfolio_categories' )) {
					$output .= __('Portfolio Category / ','oshin').'<a href="'.get_term_link($term->term_id, 'portfolio_categories').'" >'.$term->name.'</a>';
	            } elseif(is_tax( 'portfolio_tags' )) {
					$output .= __('Portfolio Tag / ','oshin').'<a href="'.get_term_link($term->term_id, 'portfolio_tags').'" >'.$term->name.'</a>';
				} else {
					$output .= __('Portfolio Archives','oshin');
				}
	        } elseif ( ( is_archive() || is_single() ) && ! is_singular( 'portfolio' ) ) {
	            if ( is_day() ) {
	                $output .= get_the_date();
	            } elseif ( is_month() ) {
	                $output .= __( get_the_date( _x( 'F Y', 'monthly archives date format', 'oshin' ) ) );
	            } elseif ( is_year() ) {
	                $output .= __( get_the_date( _x( 'Y', 'yearly archives date format', 'oshin' ) ) );
	            } else {
	                $output .= __( 'Blog Archives', 'oshin' );
	            }
	        }
	        if( is_singular('portfolio') ) {
	            $output .= get_the_term_list( $post->ID, 'portfolio_categories','','  /  ' ); 
				$output .= $sep;
	        }
	        if ( is_single() ) {
	            $output .= __( 'Here', 'oshin' );
	        }
	        if ( is_page() ) {
	        	$parents = get_ancestors( get_the_ID(),'page' );
	        	if( !empty( $parents ) ){
	        		foreach ( $parents as $parent ) {
	        			$output .= '<a href="'.get_permalink($parent).'">'.get_the_title( $parent ).'</a> / ';
	        		}
	        	}
	            $output .= '<a href="'.get_permalink(get_the_ID()).'">'.get_the_title().'</a>';
	        }
	        if ( is_home() ) {
	            global $post;
	            $page_for_posts_id = get_option( 'page_for_posts' );
	            if ( $page_for_posts_id ) { 
	                $post = get_page( $page_for_posts_id );
	                setup_postdata( $post );
	                get_the_title();
	                rewind_posts();
	                $output .= __( get_the_title(), 'oshin' );;
	            }
	        }
	        $output .= '</div>';
	    }
		return $output;
	}
endif;

/* ---------------------------------------------  */
// Function to get image id from src url
/* ---------------------------------------------  */
if ( ! function_exists( 'get_attachment_id_from_src' ) ) :
	function get_attachment_id_from_src( $image_src ) {
	    global $wpdb;
	    $query = $wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE guid=%s", $image_src);
	    $id = $wpdb->get_var( $query );
	    return $id;
	}
endif;

if (!function_exists('be_themes_toggle_post_formats')) {
	function be_themes_page_menu_args( $args ) {
		if ( ! isset( $args['show_home'] ) ) {
			$args['show_home'] = true;
			$args['menu_class'] = 'menu';
		}
		return $args;
	}
	add_filter( 'wp_page_menu_args', 'be_themes_page_menu_args' );
}


if (!function_exists('be_flickity_thumb_carousel')) {
	function be_flickity_thumb_carousel($mobile_view){
		$show_carousel_bar = get_post_meta( get_the_ID(), 'be_themes_single_show_carousel_bar', true );
		$carousel_device_opt = get_post_meta( get_the_ID(), 'be_themes_swiper_carousel_bar_device_opt', true );
		$carousel_bar_style = get_post_meta( get_the_ID(), 'be_themes_swiper_carousel_bar_style', true );
		if($show_carousel_bar != 1) {
			return false;
		}
		$attachments = get_post_meta(get_the_ID(),'be_themes_single_portfolio_slider_images'); ?>	
		<div class="single-portfolio-slider carousel_bar_area clearfix <?php echo $carousel_device_opt.' '.$mobile_view.'-thumb';?>">
			<div class="carousel_bar_dots"></div>
			<div class="be-flickity-thumb carousel_bar_wrap <?php echo $carousel_bar_style;?> ">
				<?php
				$count = 0;
				if(!empty($attachments)) {
					foreach ( $attachments as $attachment_id ) {
						$attach_img = wp_get_attachment_image_src($attachment_id,'carousel-thumb');
						$video_url = get_post_meta($attachment_id, 'be_themes_featured_video_url', true);
						if($video_url) {
							$data_source = '<img width="75" height="50"  src="'.get_template_directory_uri().'/img/video-placeholder.jpg" class="attachment-carousel-thumb" alt="hanging_on_reduced">';
						} else {
							$data_source = '<img width="'.$attach_img[1].'" height="'.$attach_img[2].'" src="'.$attach_img[0].'" class="attachment-carousel-thumb" alt="hanging_on_reduced">';
						}
						echo $data_source;
						$count++;
					}
				}
				?>
			</div>
		</div> <?php
	}
}
if (!function_exists('be_slider_carousel')) {
	function be_slider_carousel( $video=true ) {
		$show_carousel_bar = get_post_meta( get_the_ID(), 'be_themes_single_show_carousel_bar', true );
		if($show_carousel_bar != 1) {
			return false;
		}
		$attachments = get_post_meta(get_the_ID(),'be_themes_single_portfolio_slider_images'); 
		$carousel_bar_style = get_post_meta( get_the_ID(), 'be_themes_swiper_carousel_bar_style', true );?>
		<div class="single-portfolio-slider carousel_bar_area clearfix">
			<div class="carousel_bar_dots"></div>
			<div class="be-carousel-thumb carousel_bar_wrap <?php echo $carousel_bar_style;?>">
				<?php
				$count = 0;
				if(!empty($attachments)) {
					foreach ( $attachments as $attachment_id ) {
						$attach_img = wp_get_attachment_image_src($attachment_id, 'carousel-thumb');
						$video_url = get_post_meta($attachment_id, 'be_themes_featured_video_url', true);
						if($video_url && $video) {
							$data_source = '<img width="75" height="50" src="'.get_template_directory_uri().'/img/video-placeholder.jpg" class="attachment-carousel-thumb" alt="hanging_on_reduced">';
						} else {
							$data_source = '<img width="'.$attach_img[1].'" height="'.$attach_img[2].'" src="'.$attach_img[0].'" class="attachment-carousel-thumb" alt="hanging_on_reduced">';
						}
						echo '<a href="#" class="gallery-thumb" data-target="'.$count.'">'.$data_source.'</a>';
						$count++;
					}
				}
				?>
			</div>
		</div> <?php
	}
}

if (!function_exists( 'be_get_page_id' )) {
	function be_get_page_id() {
		global $post;
		if( !is_object($post) ) {
	        return;
	    }			
		if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && function_exists('is_shop') && is_shop() ) {
			$post_id = get_option('woocommerce_shop_page_id');
		} else if(is_home()) {
			$post_id = get_option( 'page_for_posts' );
		} else if(is_search() || is_tag() || is_archive() || is_category()) {
			$post_id = 0;
		} else {
			$post_id = get_the_ID();
		} 
		return $post_id;
	}
}
	
if (!function_exists( 'be_get_id_by_slug' )) {
	function be_get_id_by_slug( $page_slug ) {
		$page = get_page_by_path($page_slug);
		if ($page) {
			return $page->ID;
		} else {
			return null;
		}
	}
}

if (!function_exists( 'be_excerpt_more' )) {
	function be_excerpt_more( $output ) {
		global $more_text, $be_themes_data;
		$read_more_button_style = ((!isset($be_themes_data['blog_read_more_style'])) || empty($be_themes_data['blog_read_more_style'])) ? 'style1' : $be_themes_data['blog_read_more_style'];
		
	    return $output . '<p><a href="'. get_permalink() . '" class="more-link '.$read_more_button_style.'-button">'.__('Read More','oshin').'</a></p>';
	}
	add_filter('the_excerpt', 'be_excerpt_more');
}

if (!function_exists( 'be_read_more_link' )) {
	function be_read_more_link() {
		global $more_text, $be_themes_data;
		$read_more_button_style = ((!isset($be_themes_data['blog_read_more_style'])) || empty($be_themes_data['blog_read_more_style'])) ? 'style1' : $be_themes_data['blog_read_more_style'];
		
		return '<a href="' . get_permalink() . '" class="more-link '.$read_more_button_style.'-button">'.__('Read More','oshin').'</a>';
	}
	add_filter( 'the_content_more_link', 'be_read_more_link' );
}

if (!function_exists( 'be_themes_exclude_woo_from_ajax' )) {
	function be_themes_exclude_woo_from_ajax() {
		global $woocommerce;
		global $order_id;
			echo '<script>
					var no_ajax_pages = [];
				</script>';
		if($woocommerce) { 	
			$order = new WC_Order($order_id);
			echo '<script>
					no_ajax_pages.push("'.wc_get_cart_url().'");
					no_ajax_pages.push("'.wc_get_checkout_url().'");
					no_ajax_pages.push("'.get_permalink( wc_get_page_id( 'shop' ) ).'");';
					if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
						echo 'no_ajax_pages.push("'.$order->get_checkout_payment_url().'");
						no_ajax_pages.push("'.$order->get_checkout_order_received_url().'");';
					} else {
						echo 'no_ajax_pages.push("'.get_permalink( wc_get_page_id( 'pay' ) ).'");';
					}
					
					$args = array (
						'post_type' => 'product',
						'posts_per_page' => -1
					);
					$loop = new WP_Query( $args );
					if ( $loop->have_posts() ) {
						while ( $loop->have_posts() ) : $loop->the_post(); 
							echo 'no_ajax_pages.push("'.get_permalink( get_the_ID() ).'");';
						endwhile; 
					}
			echo '</script>';
		}	
	}
	//add_action( 'wp_footer', 'be_themes_exclude_woo_from_ajax' );
}

if ( ! function_exists( 'get_blog_pagination' ) ) :
	function get_blog_pagination($blog_attr, $portfolio_pagination_style) {
		global $wp_query;
		$items_per_page = get_option( 'posts_per_page' );
		if( ( $blog_attr['style'] == 'style3' || 'style8' == $blog_attr[ 'style' ] ) && $blog_attr['pagination_style'] == 'infinite' && (($wp_query->found_posts-$items_per_page) > 0) && (!(is_category() || is_archive() || is_tag() || is_search()))) {
			echo '<div class="trigger_infinite_scroll blog_infinite_scroll" data-total-items="'.($wp_query->found_posts).'" data-type="blog"></div>';
		} elseif( ( $blog_attr['style'] == 'style3' || 'style8' == $blog_attr[ 'style' ] ) && $blog_attr['pagination_style'] == 'loadmore' && (($wp_query->found_posts-$items_per_page) > 0) && (!(is_category() || is_archive() || is_tag() || is_search()))) {
			echo '<div class="trigger_load_more blog_load_more" data-total-items="'.($wp_query->found_posts-$items_per_page).'" '.$portfolio_pagination_style.' data-type="blog"><a class="mediumbtn be-button tatsu-button rounded" href="#">'.__('Load More', 'oshin').'</a></div>';
		} else {
			echo '<div class="pagination_parent '.$blog_attr['style'].'-blog" '.$portfolio_pagination_style.'>'.get_be_themes_pagination().'</div>';
		}
	}
endif;

if ( ! function_exists( 'be_get_blog_loop_style' ) ) :
	function be_get_blog_loop_style( $blog_style = 'style1' ) {
		return $blog_style;
	}
endif;

/**
 * Check if attachments has vimeo video attached
 */
if( !function_exists( 'be_has_vimeo' ) ) {
	function be_has_vimeo( $attachments = '' ) {
		if( !empty( $attachments ) ) {
			foreach( $attachments as $attachment ) {
				$video_url = get_post_meta($attachment, 'be_themes_featured_video_url', true);
				if( false !== strpos($video_url, 'vimeo') ) {
					return true;
				}
			}
		}
		return false;
	}
}

/* ---------------------------------------------- */
// Function to check if fixed footer is possible 
/* ---------------------------------------------- */
if( !function_exists( 'be_is_fixed_footer_possible' ) ) {
	function be_is_fixed_footer_possible() {
		$post_id = be_get_page_id();
		$return = true;
		$sticky_sections = get_post_meta( $post_id, 'be_themes_sticky_sections', true );
		if( is_singular( 'portfolio' ) ) {
			$portfolio_single_style = get_post_meta( get_the_ID(), 'be_themes_portfolio_single_page_style', true );
			$rebels = array( 'style1', 'style2', 'style3', 'style4', 'be-ribbon-carousel', 'be-center-carousel' );
			if( in_array( $portfolio_single_style, $rebels ) ) {
				$return = false;
			}
		}else if( is_singular( 'page' ) ) {
			$page_template = get_page_template_slug( get_the_ID() );
			$page_template_without_ext = !empty( $page_template ) ? basename( $page_template, '.php' ) : '';		
			$rebels = array ( 'gallery', 'portfolio' );
			if( in_array( $page_template_without_ext, $rebels ) || ( isset( $sticky_sections ) && !empty( $sticky_sections ) ) ) {
				$return = false;
			}
		}
		return $return;
	}
}

/**
 * Helper functions from color hub
 * TODO - Use composer for sharing helpers 
 */
if( !function_exists( 'be_gradient_color' ) ) {
	function be_gradient_color( $color_arr ){
		$color_value = ''; 
		$first_color_stop = '';
		$i = 0;
		$color_value = 'linear-gradient(';
		$color_value .= $color_arr['angle'].'deg';
		$colorPositions = $color_arr['colorPositions'];
		foreach( $colorPositions as $colorPos => $colorCode ){
			$color_value .= ', '. $colorCode .' '. $colorPos.'%';
			if( $i == 0 ){
				$first_color_stop = $colorCode;
			}
			$i++;
		}
		$color_value .= ')';
		return array( $color_value, $first_color_stop, 'gradient' );
	}
}

if( !function_exists( 'be_get_accent_color' ) ) {
	function be_get_accent_color() {
		global $be_themes_data;
		$colors = array (
			'color_scheme' => '',
			'alt_bg_text_color' => ''
		);
		//include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if( function_exists( 'colorhub_get_palette' ) ) {
			$palette_primary_color = colorhub_get_palette( 0 );
			$palette_secondary_color = colorhub_get_palette( 1 );
			if( is_array( $palette_primary_color ) ) {
				$gradient_data = be_gradient_color( $palette_primary_color );
				$colors[ 'color_scheme' ] = apply_filters( 'be_mod_color_scheme', $gradient_data[1], $palette_primary_color );
			}else {
				$colors[ 'color_scheme' ] = $palette_primary_color;
			}
			if( is_array( $palette_secondary_color ) ) {
				$gradient_data = be_gradient_color( $palette_secondary_color );
				$colors[ 'alt_bg_text_color' ] = apply_filters( 'be_mod_comp_color', $gradient_data[1], $palette_secondary_color );
			}else {
				$colors[ 'alt_bg_text_color' ] = $palette_secondary_color;
			}
		}else if( get_option( 'colorhub_data' ) ) {
			$colorhub_data = get_option( 'colorhub_data' );
			$palettes = $colorhub_data[ 'palettes' ];
			$currentPalette = $palettes[ 'allPalettes' ][ $palettes[ 'currentPalette' ] ];
			$palette_primary_color = $currentPalette[0];
			$palette_secondary_color = $currentPalette[1];
			if( is_array( $palette_primary_color ) ) {
				$gradient_data = be_gradient_color( $palette_primary_color );
				$colors[ 'color_scheme' ] = apply_filters( 'be_mod_color_scheme', $gradient_data[1], $palette_primary_color );
			}else {
				$colors[ 'color_scheme' ] = $palette_primary_color;
			}
			if( is_array( $palette_secondary_color ) ) {
				$gradient_data = be_gradient_color( $palette_secondary_color );
				$colors[ 'alt_bg_text_color' ] = apply_filters( 'be_mod_comp_color', $gradient_data[1], $palette_secondary_color );
			}else {
				$colors[ 'alt_bg_text_color' ] = $palette_secondary_color;
			}
		}else {
			$colors[ 'color_scheme' ] = !empty( $be_themes_data[ 'color_scheme' ] ) ? $be_themes_data[ 'color_scheme' ] : '#e0a240';
			$colors[ 'alt_bg_text_color' ] = !empty( $be_themes_data[ 'alt_bg_text_color' ] ) ? $be_themes_data[ 'alt_bg_text_color' ] : '#ffffff';
		}
		return $colors;
	}
}

function oshine_typehub_default_values() {
	$typography_options = include get_template_directory().'/functions/typography-options.php';
	$typehub_default_saved_values = array();
	if( $typography_options ) {
		foreach( $typography_options as $category => $fields ) {
			foreach( $fields as $id => $field ) {
				foreach( $field['options'] as $property => $value ) {
					if( 'font-size' === $property || 'line-height' === $property || 'letter-spacing' === $property ) {
						$value = be_split_unit_value( $value );
					} 
					$typehub_default_saved_values[$id][$property] = $value; 
				}
			}
		}
	}
	return $typehub_default_saved_values;
}

if( !function_exists( 'oshine_get_all_pages' ) ) {
	function oshine_get_all_pages() {
		$pages_array = array();

		$pages = get_posts(array( 'post_type' => 'page', 'numberposts' => -1) );
		if( $pages ) {
			foreach( $pages as $page ) {
				$pages_array[ (string) $page->ID ] =  $page->post_title;
			}
			wp_reset_postdata();
		}

		return $pages_array;
	}
}

/**
 * Check if WooCommerce is activated
 * @source - https://docs.woocommerce.com/document/query-whether-woocommerce-is-activated/
 */
if ( ! function_exists( 'be_themes_is_woocommerce_activated' ) ) {
	function be_themes_is_woocommerce_activated() {
		if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
	}
}

if( !function_exists( 'oshine_sticky_sections_fixed_wrapper_start' ) ) {
    function oshine_sticky_sections_fixed_wrapper_start() {
		global $be_themes_data;
        $sticky_sections = get_post_meta( get_the_ID(), 'be_themes_sticky_sections', true );
        if( $be_themes_data['opt-header-type'] == 'builder' && !empty( $sticky_sections ) ) :
        ?>  
            <div id = "be-sticky-section-fixed-wrap">
        <?php
        endif;
    }
    add_action( 'after_body', 'oshine_sticky_sections_fixed_wrapper_start' );
}

if( !function_exists('oshin_get_font_family')){
	function oshin_get_font_family( $font ){
		$family = be_get_font_family( $font );
		if ( !empty( $family['value'] ) ){
			return $family['value'];
		}
		return $family;
	}
}

?>
