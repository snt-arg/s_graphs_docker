<?php
/**
 * Import Demo Page for standalone only
 */
?>
<span id="tatsu-home-url" style="display:none;">
	<?php 
		echo esc_url( home_url() );		 
	?>
	</span>
<section class="be-start-content">
	<div class="notifyjs"></div>
	<?php 
	/****TATSU IMPORT :START**********/
	if(is_tatsu_standalone()){ ?>
	<div class="nav-content current" id="be-import">
    <h1>Tatsu Demo Import</h1>
		<?php
		do_action( 'tatsu_import_tpl' );
		?>
	</div>
	<?php } 
	/****TATSU IMPORT :END**********/
	?>
</section>
<div class="loader"><span class="circle"></span></div>