<?php

global $hyunmoo;
require_once( $hyunmoo['kernel'] . DS . 'records.php' );

class AdminSliders extends HyunmooRecords {
	public $pageTitle;
	public $menuTitle;
	
	public function __construct() {
		parent::__construct( 'slider' );
		$this->pageTitle = 'Hyunmoo Slider';
		$this->menuTitle = 'Sliders';
		$this->setForm();
		
		add_action( 'before-hyunmoo-records', array( $this, 'updateSliders' ) );
	}
	public function setForm() {
		$file = dirname( __FILE__ ) . DS . 'form.php';
		if( file_exists( $file ) ) {
			require_once( $file );
			if( class_exists( 'HyunmooSlidersForm' ) )
				$this->_form = new HyunmooSlidersForm;
		}
		return true;
	}
	public function updateSliders() {
		global $wpdb, $hyunmoo;
		$folder = $hyunmoo['framework'] . DS . 'config' . DS . 'records' . DS;
		$pattern = $folder . 'slider.*.conf';
		$files = glob( $pattern );
		$sliders = array();
		foreach( $files as $file ) {
			$name = basename( $file, '.conf' );
			$slider = explode( '.', $name );
			$sliders[] = $slider[1];
		}
		
		if( empty( $sliders ) ) {
			$sql = "DELETE {$wpdb->prefix}hyunmoo_records WHERE `type` = 'slider'";
			$wpdb->query( $sql );
		}
		else {
			foreach( $sliders as $slider ) {
				$slider = strtolower( sanitize_file_name( $slider ) );
				$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}hyunmoo_records WHERE `type` = 'slider' AND `name` = '$slider'";
				$exists = $wpdb->get_var( $sql );
				if( !$exists ) {
					$atts = json_encode( array( 'modified' => date( 'm-d-Y H:i:s' ) ) );
					$sql = "INSERT INTO {$wpdb->prefix}hyunmoo_records (`id`, `name`, `title`, `type`, `attributes`, `status`) VALUES  (NULL, '$slider', '$slider', 'slider', '$atts', 'public')";
					$wpdb->query( $sql );
				}
			}
		}
	}
	public function records() {
		ob_start();
?>
<div class="wrap">
	<div class="icon32" id="icon-themes">&nbsp;</div>
	<h2>
		<?php _e( 'Hyunmoo Sliders', 'hyunmoo' ); ?>
		<a class="button add-new-h2" href="?page=sliders&amp;action=new">Add New</a>
	</h2>
	<br>
	<?php do_action( 'before-hyunmoo-records' ); ?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('a.confirm').click(function(e) {
			var sure = confirm("Are you sure to delete this record?");
			if(sure == false)
				e.preventDefault();
		});
	});
	</script>
	<table class="widefat fixed">
		<thead>
			<tr>
				<th style="width:35px;" scope="col"></th>
				<th style="width:250px" scope="col">Name</th>
				<th scope="col">Title</th>
				<th style="width:200px;" scope="col">Modified</th>
				<th style="text-align:center;width:150px;" scope="col">Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php
			foreach( $this->data as $id => $record ):
		?>
			<tr>
				<td style="padding-left:10px;"><?php echo $id + 1 ?>.</td>
				<td>
					<a href="?page=sliders&amp;action=edit&amp;id=<?php echo $record['id'] ?>"><?php echo $record['name'] ?></a>
				</td>
				<td>
					<?php echo $record['title']; ?>
				</td>
				<td>
					<?php echo $record['attributes']->modified; ?>
				</td>
				<td style="text-align: center">
					<a href="?page=sliders&amp;action=edit&amp;id=<?php echo $record['id'] ?>"><span class="img-edit"></span></a>
					<a class="confirm" href="?page=sliders&amp;action=delete&amp;id=<?php echo $record['id'] ?>"><span class="img-delete"></span></a>
				</td>
			</tr>
		<?php
			endforeach;
		?>
		</tbody>
	</table>
	<?php do_action( 'after-hyunmoo-records' ); ?>
</div>
<?php
		$view = ob_get_contents();
		ob_end_clean();
		$view = apply_filters( 'hyunmoo-records-view', $view );
		echo $view;
	}
	public function newRecord() {
		if( !$this->_form )
			die( 'Invalid form' );
		
		$this->_form->show();
	}
	public function editRecord( $record ) {
		if( !$this->_form )
			die( 'Invalid form' );
		
		global $wpdb;
		$sql = "SELECT `name` FROM {$wpdb->prefix}hyunmoo_records WHERE `id` = '$record'";
		$name = $wpdb->get_var( $sql );
		$config = Hyunmoo::getConfig( 'slider.' . $name, 'records' );
		$this->_form->setConfig( $config );
		$this->_form->show();
	}
	public function addDecorations() {
		$path = get_template_directory_uri();
		
		wp_enqueue_style( 'hyunmoo-admin-style', $path . '/css/admin.css' );
		wp_enqueue_style( 'hyunmoo-records-style', $path . '/css/admin-records.css' );
		if( isset( $_GET['action'] ) ) {
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'media-upload' ); // needed for image upload
			wp_enqueue_script( 'thickbox' ); // needed for image upload
			wp_enqueue_style( 'thickbox' ); // needed for image upload
			
			wp_enqueue_script( 'form-validator', $path . '/js/jquery-validate.js', array( 'jquery' ) );
			wp_enqueue_script( 'admin-scripts', $path . '/js/admin-scripts.js' );
			wp_enqueue_script( 'tooltip-script', $path . '/js/jquery.tipsy.js' );
			
			wp_enqueue_style( 'hyunmoo-form-style', $path . '/css/admin-form.css' );
			wp_enqueue_style( 'tooltip-style', $path . '/css/tipsy.css' );
		}
	}
}