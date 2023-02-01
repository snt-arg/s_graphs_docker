	<!-- Masterslider Gallery View -->
	<script type="text/html" id="tmpl-editor-master-gallery">
		<# if ( data.attachments['0'] ) { #>
			<div class="tinymc-masterslider-gallery">
					<div class="master-gallery-controls">
						<span class="ms-gallery-arrow-right">
						<span class="ms-gallery-arrow-left">
						<span class="ms-gallery-arrow-center">
					
					<div class="master-overlay-gallery">
					<div class="master-bg-view">
						<# if ( data.attachments['0'].url ) { #>
							<img src="{{ data.attachments['0'].url }}" />
						<# } #>
					
			
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
					background: url( <br />
<b>Warning:  Use of undefined constant MSWP_AVERTA_ADMIN_URL - assumed 'MSWP_AVERTA_ADMIN_URL' (this will throw an Error in a future version of PHP) in <b>/opt/lampp/htdocs/s_graphs_docker/wp-content/plugins/masterslider/admin/views/global/gallery-templates.php on line <b>56<br />
MSWP_AVERTA_ADMIN_URL/assets/images/gallery/right-arrow.png ) no-repeat center center;
				}
				.master-gallery-controls .ms-gallery-arrow-left{
					left:30px;
					background: url( <br />
<b>Warning:  Use of undefined constant MSWP_AVERTA_ADMIN_URL - assumed 'MSWP_AVERTA_ADMIN_URL' (this will throw an Error in a future version of PHP) in <b>/opt/lampp/htdocs/s_graphs_docker/wp-content/plugins/masterslider/admin/views/global/gallery-templates.php on line <b>60<br />
MSWP_AVERTA_ADMIN_URL/assets/images/gallery/left-arrow.png ) no-repeat center center;
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
					background: url( <br />
<b>Warning:  Use of undefined constant MSWP_AVERTA_ADMIN_URL - assumed 'MSWP_AVERTA_ADMIN_URL' (this will throw an Error in a future version of PHP) in <b>/opt/lampp/htdocs/s_graphs_docker/wp-content/plugins/masterslider/admin/views/global/gallery-templates.php on line <b>71<br />
MSWP_AVERTA_ADMIN_URL/assets/images/gallery/center-logo.png ) no-repeat center center;
				}
			

		<# } else { #>
			<div class="wpview-error">
				<div class="dashicons dashicons-format-gallery"><p><br />
<b>Fatal error:  Uncaught Error: Call to undefined function _e() in /opt/lampp/htdocs/s_graphs_docker/wp-content/plugins/masterslider/admin/views/global/gallery-templates.php:77
Stack trace:
#0 {main}
  thrown in <b>/opt/lampp/htdocs/s_graphs_docker/wp-content/plugins/masterslider/admin/views/global/gallery-templates.php on line <b>77<br />
</script>