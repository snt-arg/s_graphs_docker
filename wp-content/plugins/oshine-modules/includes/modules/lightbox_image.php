<?php
/**************************************
			LIGHTBOX IMAGE
**************************************/
if ( ! function_exists( 'be_lightbox_image' ) ) {
	function be_lightbox_image( $atts, $content ){
		extract( shortcode_atts( array(
			'image'=>'',
			'link'=>'',
		), $atts ) );

		$output = '';
		$full = wp_get_attachment_image_src( $image, 'full' );
		$attachment_thumb_url = $full[0];
		$attachment_full_url = $full[0];
		$video_url = get_post_meta( $image, 'be_themes_featured_video_url', true );
		$mfp_class='mfp-image';
		if( ! empty( $video_url ) ) {
			$attachment_full_url = $video_url;
			$mfp_class = 'mfp-iframe';
		}	

		//GDPR Privacy preference popup logic
		$gdpr_atts = '{}';
		$gdpr_concern_selector = '';
		$tempModalContents = '';
		if( $mfp_class === 'mfp-iframe' ){
			if( function_exists( 'be_gdpr_privacy_ok' ) ){
				$video_details =  be_get_video_details($video_url);
				$key = be_uniqid_base36(true);
				if( !empty( $_COOKIE ) ){
					if( !be_gdpr_privacy_ok($video_details['source'] ) ){
						$mfp_class = 'mfp-popup';
						$attachment_full_url = '#gdpr-alt-lightbox-'.$key;
						$tempModalContents .= be_gdpr_lightbox_for_video($key,$video_details["thumb_url"],$video_details['source']);
					}
				} else {
					$gdpr_atts = array(
						'concern' => $video_details[ 'source' ],
						'add' => array( 
							'class' => array( 'mfp-popup' ),
							'atts'	=> array( 'href' => '#gdpr-alt-lightbox-'.$key ),
						),
						'remove' => array( 
							'class' => array( $mfp_class )
						)
					);
					$gdpr_concern_selector = 'be-gdpr-consent-required';
					$gdpr_atts = json_encode( $gdpr_atts );
					$tempModalContents .= be_gdpr_lightbox_for_video($key,$video_details["thumb_url"],$video_details['source']);
				}
			}
		}


		$output .= '<div class="element-inner oshine-module">';
		$output .='<div class="thumb-wrap"><img src="'.$attachment_thumb_url.'" alt />';
						$output .='<div class="thumb-overlay"><div class="thumb-bg">';
						$output .='<div class="thumb-icons">';
						$output .= ( ! empty( $link ) ) ? '<a href="'.$link.'"><i class="font-icon icon-link"></i></a>' : '' ;
						$output .='<a href="'.$attachment_full_url.'" class="image-popup-vertical-fit '.$mfp_class.' '.$gdpr_concern_selector.'" data-gdpr-atts='.$gdpr_atts.'><i class="font-icon icon-search"></i></a>';
						$output .= $tempModalContents;
						$output .= '</div>'; // end thumb icons								
						$output .='</div></div>';//end thumb overlay & bg
						$output .='</div>';//end thumb wrap
						$output .='</div>';
		return $output;
	}
	add_shortcode('lightbox_image','be_lightbox_image');
}
?>