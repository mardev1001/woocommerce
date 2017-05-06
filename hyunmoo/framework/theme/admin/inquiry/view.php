<?php

global $hyunmoo;
require_once( $hyunmoo['kernel'] . DS . 'records.php' );

class AdminInquiry extends HyunmooRecords {
	public $pageTitle;
	public $menuTitle;
	
	public function __construct() {
		parent::__construct( 'slider' );
		$this->pageTitle = 'Customer Inquiry';
		$this->menuTitle = 'Inquiry';
	}
	
	public function showRecords() {
		ob_start();
?>
<div id="popupbg"></div>
<div class="wrap">
	<div class="icon32" id="icon-themes">&nbsp;</div>
	<h2>
		<?php _e( 'Customer Inquiry', 'hyunmoo' ); ?>
	</h2>
	<br>
	<?php do_action( 'before-hyunmoo-records' ); ?>
	<div id="tabs">
		<ul class="group">
			<li class="active" rel="">All</li>
			<li rel="solved">Solved</li>
			<li rel="unsolved">Unsolved</li>
		</ul>
	</div>
	<div style="clear:both;">&nbsp;</div>
	<div id="main">
		<div class="popupdiag">
			<div class="ptitle">
				Reply
				<div class="pclose">&times;</div>
			</div>
			<div class="pmain" align="center">
				<p>Reply To: </p>
				<input id="to" type="text" class="ptextbox" />
				<p>Email Subject : </p>
				<input id="subject" type="text" class="ptextbox" />
				<p>Customer Inquiry : <p>
				<textarea id="inquiry" class="ptextarea"></textarea>
				<p>Your Response : <p>
				<textarea id="response" class="ptextarea"></textarea>
				<input type="button" id="reply" value="Reply">
			</div>
		</div>
	</div>
	<?php do_action( 'after-hyunmoo-records' ); ?>
</div>
<?php
		$view = ob_get_contents();
		ob_end_clean();
		$view = apply_filters( 'hyunmoo-records-view', $view );
		echo $view;
	}
	
	public function addDecorations() {
		$path = get_template_directory_uri();
		
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-masonry' );
			
		wp_enqueue_script( 'form-validator', $path . '/js/jquery-validate.js', array( 'jquery' ) );
		wp_enqueue_script( 'admin-scripts', $path . '/js/admin-scripts.js' );
		wp_enqueue_script( 'tooltip-script', $path . '/js/jquery.tipsy.js' );
		wp_enqueue_script( 'inquiry-script', $path . '/js/admin-inquiry.js' );
			
		wp_enqueue_style( 'hyunmoo-form-style', $path . '/css/admin-form.css' );
		wp_enqueue_style( 'tooltip-style', $path . '/css/tipsy.css' );
		wp_enqueue_style( 'hyunmoo-admin-style', $path . '/css/admin.css' );
		wp_enqueue_style( 'hyunmoo-records-style', $path . '/css/admin-records.css' );
	}
}
