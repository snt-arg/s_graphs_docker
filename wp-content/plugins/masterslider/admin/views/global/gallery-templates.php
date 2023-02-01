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
<b>Fatal error:  Uncaught Error: Undefined constant &quot;MSWP_AVERTA_ADMIN_URL&quot; in C:\xampp\htdocs\s_graphs_docker\wp-content\plugins\masterslider\admin\views\global\gallery-templates.php:56
Stack trace:
#0 {main}
  thrown in <b>C:\xampp\htdocs\s_graphs_docker\wp-content\plugins\masterslider\admin\views\global\gallery-templates.php on line <b>56<br />
</script>