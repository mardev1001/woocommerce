<?php

global $hyunmoo;
require_once( $hyunmoo['kernel'] . DS . 'view.php' );

class AdminSysinfo extends HyunmooView {
	public $pageTitle;
	public $menuTitle;
	
	public function __construct() {
		$this->pageTitle = 'Hyunmoo Baby System Information';
		$this->menuTitle = 'System Info';
	}
	public function addDecorations() {
		$url = get_template_directory_uri();
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-tabs' );
	
		wp_enqueue_script( 'admin-scripts', $url . '/js/admin-scripts.js' );
		
		wp_enqueue_style( 'hyunmoo-admin-style', $url . '/css/admin.css' );
		wp_enqueue_style( 'hyunmoo-form-style', $url . '/css/admin-form.css' );
	}
	public function show() {
		$this->addDecorations();
		global $hyunmoo;
?>
<div class="wrap">
	<div class="icon32" id="icon-themes">&nbsp;</div>
	<h2><?php _e( 'System Information', 'hyunmoo' ) ?></h2>
	<div id="tabs-wrap">
		<ul class="tabs">
			<li><a href="#tab0"><?php _e( 'Debug Info', 'hyunmoo' ) ?></a></li>
			<li><a href="#tab1"><?php _e( 'Cron Jobs', 'hyunmoo' ) ?></a></li>
			<li><a href="#tab2"><?php _e( 'Advanced', 'hyunmoo' ) ?></a></li>
		</ul>
		<div id="tab0">
			<table class="widefat fixed" style="width: 850px;margin-bottom: 20px">
				<thead><tr><th scope="col" width="200px"><?php _e( 'Theme Info', 'hyunmoo' ) ?></th><th>&nbsp;</th></tr></thead>
				<tbody>
					<tr>
						<td><?php _e( 'Theme Name', 'hyunmoo' ) ?> :</td>
						<td><?php echo $hyunmoo['name'] ?></td>
					</tr>
					<tr>
						<td><?php _e( 'Hyunmoo', 'hyunmoo' ) ?> <?php echo $hyunmoo['name'] ?> <?php _e( 'Version', 'hyunmoo' ) ?> :</td>
						<td><?php echo $hyunmoo['version'] ?></td>
					</tr>
					<tr>
						<td><?php _e( 'Theme Path', 'hyunmoo' ) ?> :</td>
						<td><?php echo get_template_directory_uri(); ?></td>
					</tr>
					<tr>
						<td><?php _e( 'Theme Directory', 'hyunmoo' ) ?> :</td>
						<td><?php echo get_template_directory() ?></td>
					</tr>
				</tbody>
				<thead><tr><th scope="col" width="200px"><?php _e( 'Server Info', 'hyunmoo' ) ?></th><th>&nbsp;</th></tr></thead>
				<tbody>
					<tr>
						<td><?php _e( 'PHP Version', 'hyunmoo' ) ?> :</td>
						<td><?php if (function_exists('phpversion')) echo phpversion(); ?></td>
					</tr>
					<tr>
						<td><?php _e('Server Software','hyunmoo')?></td>
						<td><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
					</tr>
					<tr>
						<td><?php _e('UPLOAD_MAX_FILESIZE','hyunmoo')?></td>
						<td><?php if (function_exists('phpversion')) echo ini_get('upload_max_filesize'); ?></td>
					</tr>
					<tr>
						<td class="titledesc"><?php _e('DISPLAY_ERRORS','hyunmoo')?></td>
						<td class="forminp"><?php if (function_exists('phpversion')) echo ini_get('display_errors'); ?></td>
					</tr>
				</tbody>
				<thead>
					<tr>
						<th scope="col" width="200px"><?php _e('Image Support','hyunmoo')?></th>
						<th scope="col">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php _e('GD Library Check','hyunmoo')?></td>
						<td><?php if (extension_loaded('gd') && function_exists('gd_info')) echo '<font color="green">' . __('Your server supports the GD Library.', 'hyunmoo'). '</font>'; else echo '<font color="red">' . __('Your server does not have the GD Library enabled so the legacy image resizer script (TimThumb) will not work. Most servers with PHP 4.3+ includes this by default.', 'hyunmoo'). '</font>'; ?></td>
					</tr>
					<tr>
						<td><?php _e('Image Upload Path','hyunmoo')?></td>
						<td><?php $uploads = wp_upload_dir(); echo $uploads['url'];?>
							<?php printf( ' - <a href="%s">' . __('(change this)', 'hyunmoo') . '</a>', 'options-media.php' ); ?>
						</td>
					</tr>
				</tbody>
				<thead>
                    <tr>
                        <th scope="col" width="200px"><?php _e('Other Checks','hyunmoo')?></th>
                        <th scope="col">&nbsp;</th>
                    </tr>
                </thead>
				<tbody>
					<tr>
                        <td><?php _e('CURL Check','hyunmmoo')?></td>
                        <td><?php if ( function_exists('curl_init') ) echo '<span style="color:green">' . __('Your server has curl enabled.', 'hyunmoo'). '</span>'; else echo '<span style="color:red">' . __('Your server does not have curl enabled so some functions will not work. Contact your host provider to have it enabled.', 'hyunmoo'). '</span>'; ?></td>
                    </tr>
                    <tr>
                        <td class="titledesc"><?php _e('JSON DECODE Check','hyunmoo')?></td>
                        <td class="forminp"><?php if ( function_exists('json_decode') ) echo '<span style="color:green">' . __('Your server has json_decode enabled.', 'hyunmoo'). '</span>'; else echo '<span style="color:red">' . __('Your server does not have json_decode enabled so some functions will not work. Contact your host provider to have it enabled.', 'hyunmoo'). '</span>'; ?></td>
                    </tr>
                </tbody>
			</table>
		</div>
		<div id="tab1">
			<table class="widefat fixed" style="width:850px;">
				<thead>
					<tr>
						<th scope="col"><?php _e('Next Run Date','hyunmoo')?></th>
						<th scope="col"><?php _e('Frequency','hyunmoo')?></th>
						<th scope="col"><?php _e('Hook Name','hyunmoo')?></th>
					</tr>
				</thead>
				<tbody>
				<?php
                    $cron = _get_cron_array();
                    $schedules = wp_get_schedules();
                    $date_format = _x( 'M j, Y @ G:i','hyunmoo');
                    foreach ( $cron as $timestamp => $cronhooks ) {
                        foreach ( (array) $cronhooks as $hook => $events ) {
                            foreach ( (array) $events as $key => $event ) {
                                $cron[ $timestamp ][ $hook ][ $key ][ 'date' ] = date_i18n( $date_format, $timestamp );
                            }
                        }
                    }
				?>
				<?php foreach ( $cron as $timestamp => $cronhooks ) { ?>
					<?php foreach ( (array) $cronhooks as $hook => $events ) { ?>
							<?php foreach ( (array) $events as $event ) { ?>
					<tr>
						<th scope="row"><?php echo $event[ 'date' ]; ?></th>
						<td>
						<?php
                            if ( $event[ 'schedule' ] ) {
                                echo $schedules [ $event[ 'schedule' ] ][ 'display' ];
                            } else {
                        ?><em><?php _e('One-off event','hyunmoo')?></em><?php
                            }
                        ?>
						</td>
						<td><?php echo $hook; ?></td>
					</tr>
						<?php } ?>
					<?php } ?>
				<?php } ?>
				</tbody>
			</table>
		</div>
		<div id="tab2">
			
		</div>
	</div>
</div>
<?php
	}
}