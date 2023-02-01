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
					<td class="bold"><?php echo esc_html( $memory_limit_sug ); ?>M</td>
					<td class="bold <?php echo esc_html( intval($memory_limit_cur) >= $memory_limit_sug ? 'ok' : 'notok' ); ?>"><?php echo esc_html( $memory_limit_cur ); ?></td>
				</tr>
				<tr>
					<td>max_execution_time<sup><small>*</small></sup></td>
					<td>Medium</td>
					<td class="bold"><?php echo esc_html( $max_execution_time_sug ); ?></td>
					<td class="bold <?php echo esc_html( $max_execution_time_cur >= $max_execution_time_sug ? 'ok' : 'notok' ); ?>"><?php echo esc_html( $max_execution_time_cur ); ?></td>
				</tr>

			</tbody>
			<?php if( intval($memory_limit_cur) < $memory_limit_sug || $max_execution_time_cur < $max_execution_time_sug ): ?>
			<tfoot>
			<tr class="spacer"></tr>
				<tr>
					<td colspan="4" class="small">
						To change PHP directives you need to modify <strong>php.ini</strong> file, more information about this you can <a href=" <?php esc_url('http://goo.gl/I9f74U') ?>" target="_blank">search here</a> or contact your hosting provider.
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

add_action( 'tatsu_import_tpl', 'be_check_import_requires', 10, 1 );


function be_require_plugin_notic() {
	if(!class_exists('ExponentDemosCore')) {
		echo '<div class="notic notic-warning "><p>Please go to <a href="#" data-tab="be-plugins">install plugins</a> and activate the require plugins first.</p></div>';
	}
}
add_action('tatsu_import_tpl', 'be_require_plugin_notic');
add_action('tatsu_systatus_tpl', 'be_require_plugin_notic');


?>