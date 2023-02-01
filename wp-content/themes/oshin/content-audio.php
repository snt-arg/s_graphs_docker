<div class="post-thumb">
	<?php
		$audio_embed = get_post_meta( get_the_ID(), 'be_themes_audio_url', true );
		if( !empty( $audio_embed ) ) {
			echo $audio_embed; //apply_filters( 'the_content', $audio_embed );		
		}	
	?>
</div>