<div class="post-thumb">
	<div class="thumb-wrap">
		<?php 
			$video_url = get_post_meta(get_the_ID(),'be_themes_video_url',true);
			if(!empty($video_url)) {
				echo be_carousel_video( $video_url );		
			}
		?>
	</div>
</div>