<?php 
    global $be_themes_data;
	extract( be_themes_header_details() );
?>

<header id="header">
	<?php
		get_template_part( 'headers/top/header', 'top-bar' );
	?>
	<div id="header-inner-wrap" class="<?php echo $header_class; echo ' '.$header_style; ?>" <?php echo ' '.$full_screen_header_scheme; ?>>
		<?php
			extract(be_themes_calculate_logo_height());
			if((!empty($header_transparent) && isset($header_transparent) && 'none' != $header_transparent)) {
				$default_header_height = $logo_transparent_height;
			} else {
				$default_header_height = $logo_height;
			}
		?>
            <div id="header-bottom-bar">
                <div id="header-bottom-bar-wrap" class="<?php if($be_themes_data['opt-header-wrap']){?>be-wrap<?php } ?> clearfix">
                    <?php
						get_template_part( 'headers/top/header', 'items4' );
					?>
                </div>
            </div>
			<div id="header-wrap" class="<?php if($be_themes_data['opt-header-wrap']){?>be-wrap<?php } ?> clearfix" data-default-height="<?php echo $default_header_height; ?>" data-sticky-height="<?php echo $logo_sticky_height; ?>">
				<?php
                    if((!isset($be_themes_data['disable_logo']) || empty($be_themes_data['disable_logo'])) || (isset($be_themes_data['disable_logo']) && (0 == $be_themes_data['disable_logo'])) ){?>
                        <div class="logo">
                            <?php be_themes_get_header_logo_image(); ?>
                        </div>
                <?php } ?>
			</div>

			<?php
				be_themes_header_border();
			?>	
				
		<?php
			be_themes_get_header_mobile_navigation();
		?>
	</div>
</header> <!-- END HEADER -->