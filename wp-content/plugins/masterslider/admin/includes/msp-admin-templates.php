<?php

function msp_get_panel_header(){
?>
	<div id="msp-header">
        <div class="msp-logo">
        	<a href="<?php echo admin_url( 'admin.php?page='.MSWP_SLUG ); ?>">
        		<img src="<?php echo MSWP_AVERTA_ADMIN_URL; ?>/views/slider-panel/images/masterslider.gif">
        	</a>
        </div>
    </div>
<?php
}