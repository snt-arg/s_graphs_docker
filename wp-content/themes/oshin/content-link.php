<?php
global $blog_attr;
// if(($post_format == 'quote' || $post_format == 'link') && !is_single() ){
    $post_card_color =  get_post_meta( get_the_ID(), 'be_themes_post_text_color', true ) ;
    // $post_card_bg =  get_post_meta( get_the_ID(), 'be_themes_thumbnail_bg_color', true ) ;
    $post_card_color = ($post_card_color != '') ? 'color: ' .$post_card_color. ';' : '' ;
    // $post_card_bg = ($post_card_bg != '') ? 'background-color: ' .$post_card_bg. ';' : '' ; 
    $style = 'style= "'.$post_card_color.'"';
// }
$link = get_post_meta(get_the_ID(),'be_themes_link_format',true);
if( !isset( $link ) || empty( $link ) ) {
	$link = '#';
}
if($blog_attr['style'] == 'style8'){?>
	<div class="post-icon-link-wrap">
		<i class="font-icon icon-link"></i>
	</div>
	<div class="post-quote-title-section">
		<?php 
			$quote_author = get_post_meta(get_the_ID(),'be_themes_quote_author',true);
			echo '<h2 class="post-title"><a href="'.$link.'" '.$style.'>'.get_the_title().'</a></h2>';
			echo ( $link != '#' ) ? '<span class="post-link-author post-custom-meta">- '.$link.'</span>' : '';
		?>
	</div> 
<?php } else {?>
	<div class="clearfix post-title-section-wrap">
		<div class="left post-date-wrap">
			<i class="font-icon icon-link"></i>
		</div>
		<div class="left post-title-section">
			<?php
				echo '<h2 class="post-title"><a href="'.$link.'" target="_blank">'.get_the_title().'</a></h2>';
				echo ( $link != '#' ) ? '<span class="post-custom-meta">- '.$link.'</span>' : '';
			?>
		</div>
	</div>
<?php }?>