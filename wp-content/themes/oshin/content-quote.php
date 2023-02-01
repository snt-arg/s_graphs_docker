<?php
global $blog_attr;
// if(($post_format == 'quote' || $post_format == 'link') && !is_single() ){
    $post_card_color =  get_post_meta( get_the_ID(), 'be_themes_post_text_color', true ) ;
    // $post_card_bg =  get_post_meta( get_the_ID(), 'be_themes_thumbnail_bg_color', true ) ;
    $post_card_color = ($post_card_color != '') ? 'color: ' .$post_card_color. ';' : '' ;
    // $post_card_bg = ($post_card_bg != '') ? 'background-color: ' .$post_card_bg. ';' : '' ; 
    $style = 'style= "'.$post_card_color.'"';
// }
if($blog_attr['style'] == 'style8'){?>
	<div class="post-icon-quote-wrap">
		<i class="font-icon icon-quote"></i>
	</div>
	<div class="post-quote-title-section">
		<?php 
			$quote_author = get_post_meta(get_the_ID(),'be_themes_quote_author',true);
			echo '<h2 class="post-title" '.$style.'>'.get_the_title().'</h2>';
			echo ( isset($quote_author) && !empty($quote_author) ) ? '<span class="post-quote-author post-custom-meta">- '.$quote_author.'</span>' : '';
		?>
	</div> 
<?php } else {?>
<div class="clearfix post-title-section-wrap">
	<div class="left post-date-wrap">
		<i class="font-icon icon-quote"></i>
	</div>
	<div class="left post-title-section">
		<?php 
			$quote_author = get_post_meta(get_the_ID(),'be_themes_quote_author',true);
			echo '<h2 class="post-title"><a href="#">'.get_the_title().'</a></h2>';
			echo ( isset($quote_author) && !empty($quote_author) ) ? '<span class="post-quote-author post-custom-meta">- '.$quote_author.'</span>' : '';
		?>
	</div>
</div>
<?php } ?>
