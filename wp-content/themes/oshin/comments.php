<?php
/**
 * The template for displaying Comments.
 */
?>
	<div id="comments">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php echo __('This post is password protected. Enter the password to view any comments.','oshin'); ?></p>
	</div><!-- #comments -->
	<?php
			return;
		endif;
	?>
	<?php if ( have_comments() ) : ?>
		<h5 id="comments-title">
			<?php
				printf( _n( 'One Comment', '%1$s Comments', get_comments_number(), 'oshin' ),
					number_format_i18n( get_comments_number() ) );
			?>
		</h5>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above">
			<h1 class="assistive-text"><?php _e('Comment navigation','oshin'); ?></h1>
			<div class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments','oshin')); ?></div>
			<div class="nav-next"><?php next_comments_link( __('Newer Comments &rarr;','oshin')); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<ol class="commentlist">
			<?php
				wp_list_comments( array( 'callback' => 'be_themes_comments' ) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below">
		<h1 class="assistive-text"><?php _e('Comment navigation','oshin'); ?></h1>
			<div class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments','oshin')); ?></div>
			<div class="nav-next"><?php next_comments_link( __('Newer Comments &rarr;','oshin')); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

	<?php
		elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
	<p class="nocomments"><?php _e('Comments are closed.','oshin'); ?></p>
	<?php endif; ?>
	<?php 
	$fields =  array(
		'author' =>  '<p class="comment-form-author"><input placeholder="'.__('Name','oshin').'" id="author" name="author" type="text" aria-required="true"/></p>',
		'email' =>  '<p class="comment-form-email"><input placeholder="'.__('Email','oshin').'" id="email" name="email" type="text" aria-required="true"/></p>',
		'url' =>  '<p class="comment-form-url"><input placeholder="'.__('Website','oshin').'" id="url" name="url" type="text" aria-required="true"/></p>'
	);
	$defaults = array(
		'fields' => $fields,
		'label_submit' => __('Submit','oshin'),
		'comment_field' =>  '<p class="comment-form-comment"><textarea placeholder="'.__('Comment','oshin').'" id="comment" name="comment" cols="45" rows="15" aria-required="true"></textarea></p>',
	);
	comment_form($defaults); 
	?>
</div><!-- #comments -->