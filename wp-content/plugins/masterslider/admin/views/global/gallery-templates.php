	<!-- Masterslider Gallery View -->
	<script type="text/html" id="tmpl-editor-master-gallery">
		<# if ( data.attachments['0'] ) { #>
			<div class="tinymc-masterslider-gallery">
					<div class="master-gallery-controls">
						<span class="ms-gallery-arrow-right"></span>
						<span class="ms-gallery-arrow-left"></span>
						<span class="ms-gallery-arrow-center"></span>
					</div>
					<div class="master-overlay-gallery"></div>
					<div class="master-bg-view">
						<# if ( data.attachments['0'].url ) { #>
							<img src="{{ data.attachments['0'].url }}" />
						<# } #>
					</div>
			</div>
			<style>
				.tinymc-masterslider-gallery {
					position:relative;
				}
				.tinymc-masterslider-gallery .master-overlay-gallery {
					max-height: 350px;
					overflow: hidden;
				}
				.tinymc-masterslider-gallery .master-bg-view {
					max-height: 350px;
					overflow: hidden;
				}
				.tinymc-masterslider-gallery .master-bg-view img{
					width:100%;
					height:auto;
				}
				.tinymc-masterslider-gallery .master-overlay-gallery {
					position:absolute;
					width:100%;
					height:100%;
					background: rgba(240, 255, 255, 0.45);
				}
				.tinymc-masterslider-gallery .master-gallery-controls {
					position:absolute;
					width:100%;
					height:100%;
					z-index:2;
				}
				.master-gallery-controls .ms-gallery-arrow-right,
				.master-gallery-controls .ms-gallery-arrow-left {
					display:inline-block;
					width:50px;
					height:50px;
					position:absolute;
					top:50%;
					margin-top:-25px;
				}
				.master-gallery-controls .ms-gallery-arrow-right{
					right:30px;
					background: url( <?php echo MSWP_AVERTA_ADMIN_URL . '/assets/images/gallery/right-arrow.png'; ?> ) no-repeat center center;
				}
				.master-gallery-controls .ms-gallery-arrow-left{
					left:30px;
					background: url( <?php echo MSWP_AVERTA_ADMIN_URL . '/assets/images/gallery/left-arrow.png'; ?> ) no-repeat center center;
				}
				.master-gallery-controls .ms-gallery-arrow-center{
					display:inline-block;
					position:absolute;
					width:201px;
					height:235px;
					top:50%;
					margin-top:-118px;
					left:50%;
					margin-left:-100px;
					background: url( <?php echo MSWP_AVERTA_ADMIN_URL . '/assets/images/gallery/center-logo.png'; ?> ) no-repeat center center;
				}
			</style>

		<# } else { #>
			<div class="wpview-error">
				<div class="dashicons dashicons-format-gallery"></div><p><?php _e( 'No items found.' ); ?></p>
			</div>
		<# } #>

	</script>


	<script type="text/html" id="tmpl-gallery-master-settings">
		<div class="msas-gallery-sep"></div><hr />

		<h3><?php _e( 'Master Slider Settings', MSWP_TEXT_DOMAIN ); ?></h3>

		<label class="setting msas-gallery-item msas-gallery-masterslider">
			<span><?php _e( 'Display Images as Slider?', MSWP_TEXT_DOMAIN ); ?></span>
			<input type="checkbox" data-setting="masterslider" />
		</label>

		

		<label class="setting msas-gallery-item msas-gallery-autoplay msas-toggle">
			<span><?php _e( 'Enable AutoPlay?', MSWP_TEXT_DOMAIN ); ?></span>
			<input type="checkbox" data-setting="autoplay" />
		</label>

		<label class="setting msas-gallery-item msas-gallery-loop msas-toggle">
			<span><?php _e( 'Enable Continues Sliding?', MSWP_TEXT_DOMAIN ); ?></span>
			<input type="checkbox" data-setting="loop" />
		</label>

		<label class="setting msas-gallery-item msas-gallery-thumbs msas-toggle">
			<span><?php _e( 'Display Thumbails?', MSWP_TEXT_DOMAIN ); ?></span>
			<input type="checkbox" data-setting="thumbs" />
		</label>

		<label class="setting msas-gallery-item msas-gallery-thumbs_align msas-toggle">
			<span><?php _e( 'Thumbnails Alignment', MSWP_TEXT_DOMAIN ); ?></span>
			<select data-setting="thumbs_align" >
				<option value="bottom" ><?php _e( 'Bottom', MSWP_TEXT_DOMAIN ); ?></option>
				<option value="top" ><?php _e( 'Top', MSWP_TEXT_DOMAIN ); ?></option>
				<option value="left" ><?php _e( 'Left', MSWP_TEXT_DOMAIN ); ?></option>
				<option value="right" ><?php _e( 'Right', MSWP_TEXT_DOMAIN ); ?></option>
			</select>
		</label>

		<label class="setting msas-gallery-item msas-gallery-caption msas-toggle">
			<span><?php _e( 'Display Image Caption?', MSWP_TEXT_DOMAIN ); ?></span>
			<input type="checkbox" data-setting="caption" />
		</label>

		<label class="setting msas-gallery-item msas-gallery-auto_height msas-toggle">
			<span><?php _e( 'Enable Auto Height?', MSWP_TEXT_DOMAIN ); ?></span>
			<input type="checkbox" data-setting="auto_height" />
		</label>

		<label class="setting msas-gallery-item msas-gallery-skin msas-toggle">
			<span><?php _e( 'Slider Skin', MSWP_TEXT_DOMAIN ); ?></span>
			<select data-setting="skin" >
			<?php $skins = msp_get_skins(); 
				foreach ( $skins as $skin ) {
					printf( '<option value="%s" >%s</option>', $skin['class'], $skin['label'] );
				}
			?>
			</select>
		</label>

		<label class="setting msas-gallery-item msas-gallery-class msas-toggle">
			<span><?php _e( 'Extra css class', MSWP_TEXT_DOMAIN ); ?></span>
			<input type="input" class="msas-textbox" data-setting="class" />
		</label>

		<div class="msas-gallery-sep"></div><hr />

	</script>