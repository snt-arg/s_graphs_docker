<?php
if(!function_exists('be_check_import_requires')) {
	function be_check_import_requires() {
		$max_execution_time_cur = @ini_get( 'max_execution_time' );
		$max_execution_time_sug = 90;
		$memory_limit_cur = @ini_get( 'memory_limit' ); //WP_MAX_MEMORY_LIMIT;
		$memory_limit_sug = 128;
	?>
	<div class="table-php-requirements-container">
		<table class="table-php-requirements">
			<thead>
				<tr>
					<td colspan="4">
						<p>In order to successfully import a demo, please ensure your server meets the following PHP configurations. Your hosting provider will help you modify server configurations, if required.</p>
					</td>
				</tr>
				<tr>
					<th>Directive</th>
					<th>Priority</th>
					<th>Least Suggested Value</th>
					<th>Current Value</th>
				</tr>
				<tr class="spacer"></tr>
			</thead>
			<tbody>
				<tr>
					<td>DOMDocument</td>
					<td>High</td>
					<td class="bold">Supported</td>
					<td class="bold <?php echo class_exists( 'DOMDocument' ) ? 'ok' : 'notok'; ?>"><?php echo class_exists( 'DOMDocument' ) ? 'Supported' : 'Not Supported'; ?></td>
				</tr>
				<tr>
					<td>memory_limit</td>
					<td>High</td>
					<td class="bold"><?php echo $memory_limit_sug; ?>M</td>
					<td class="bold <?php echo intval($memory_limit_cur) >= $memory_limit_sug ? 'ok' : 'notok'; ?>"><?php echo $memory_limit_cur; ?></td>
				</tr>
				<tr>
					<td>max_execution_time<sup><small>*</small></sup></td>
					<td>Medium</td>
					<td class="bold"><?php echo $max_execution_time_sug; ?></td>
					<td class="bold <?php echo $max_execution_time_cur >= $max_execution_time_sug ? 'ok' : 'notok'; ?>"><?php echo $max_execution_time_cur; ?></td>
				</tr>

			</tbody>
			<?php if( intval($memory_limit_cur) < $memory_limit_sug || $max_execution_time_cur < $max_execution_time_sug ): ?>
			<tfoot>
			<tr class="spacer"></tr>
				<tr>
					<td colspan="4" class="small">
						To change PHP directives you need to modify <strong>php.ini</strong> file, more information about this you can <a href="http://goo.gl/I9f74U" target="_blank">search here</a> or contact your hosting provider.
						<br>
						<small><em>* Even if your current value of "max execution time" is lower than recommended, demo content can still be imported in most cases.</em></small>
					</td>
				</tr>
			</tfoot>
			<?php endif; ?>
		</table>
	</div>
	<?php
	}
}
if( !defined('ENVATO_HOSTED_SITE')  ) {
	add_action( 'be_import_tpl', 'be_check_import_requires', 10, 1 );
}

function be_require_plugin_notic() {
	if(!class_exists('BECore')) {
		echo '<div class="notic notic-warning "><p>Please go to <a href="#" data-tab="be-plugins">install plugins</a> and activate the require plugins first.</p></div>';
	}
}
add_action('be_import_tpl', 'be_require_plugin_notic');
add_action('be_systatus_tpl', 'be_require_plugin_notic');

function be_support_tab() {
	echo '<a href="#" data-tab="be-support" class="nav-tab">';
	esc_html_e( 'Help & Support', 'oshin' );
	echo '</a>';
}
//add_action( 'be_start_tabs', 'be_support_tab', 10, 1 );

function be_support_tab_content() {
	echo '<div class="nav-content" id="be-support">';
	echo '<p>For support please contact us throw themeforest</p>';
	echo '<a href="https://themeforest.net/user/brandexponents#contact" class="button-primary">Contact us</a>';
	echo '</div>';
}
//add_action( 'be_tabs_content', 'be_support_tab_content', 10, 1 );
?>