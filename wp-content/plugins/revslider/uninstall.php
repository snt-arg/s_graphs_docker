<?php 
if(!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')){
	exit();
}

//needs to be deleted so that everything gets checked at a new installation
delete_option('revslider_table_version');
delete_option('revslider_checktables');
delete_option('rs_public_version');