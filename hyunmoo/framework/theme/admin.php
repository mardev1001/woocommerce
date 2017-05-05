<?php

global $hyunmoo;
require_once( $hyunmoo['kernel'] . DS . 'string.php' );

class HyunmooAdmin {
	private $pagespath;
	private $pages = array();
	private $handlers = array();
	
	public function __construct() {
		$this->pagespath = dirname( __FILE__ ) . DS . 'admin';
		$this->_includeViews();
	}
	
	public function initialize() {
		add_action( 'admin_menu', array( $this, 'adminPages' ) );
		add_action( 'admin_init', array( $this, 'pageHandlers' ) );
		
		//Metaboxes section
		add_action( 'load-post.php', array( $this, 'metaboxes' ) );
		add_action( 'load-post-new.php', array( $this, 'metaboxes' ) );
		add_action( 'wp_ajax_get_page_featured_image', array( $this, 'ajax_get_featured_image' ) );
		add_filter( 'attachment_fields_to_edit', array( $this, 'media_action_button' ), 20, 2 );
		
		//Menus
		register_nav_menu( 'primary', __( 'Primary Menu' ) );
		register_nav_menu( 'primary-mobile', __( 'Mobile Primary Menu' ) );
		//WooCommerce support
		add_theme_support( 'woocommerce' );		
	}
		
	public function adminPages() {
		if( !current_user_can( 'manage_options' ) ) return;
		
		global $hyunmoo;
		$pageid = add_menu_page( __( 'Hyunmoo ' . $hyunmoo['name'] . ' Dashboard', 'hyunmoo' ), __( 'Hyunmoo', 'hyunmoo' ), 'manage_options',
						'hyunmoo-dashboard', array( $this->pages['dashboard'], 'show' ), get_template_directory_uri() . '/images/favicon.png', 3 );
		add_action( 'load-' . $pageid, array( $this->pages['dashboard'], 'addDecorations' ) );
		
		foreach( $this->pages as $id => $page ) {
			$pageid = add_submenu_page( 'hyunmoo-dashboard', $page->pageTitle, $page->menuTitle, 'manage_options', $id, 
						array( $page, 'show' ) );
			add_action( 'load-' . $pageid, array( $page, 'addDecorations' ) );
		}
		
		do_action( 'hyunmoo-submenu-pages' );
	}
	
	public function pageHandlers() {
		if( empty( $_POST ) )
			return;
		$pageid = $_GET['page'];
		$handler = isset( $this->handlers[$pageid] ) ? $this->handlers[$pageid] : null;
		if( $handler != null ) {
			$handler->processRequest();
		}
	}
	
	public function metaboxes() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post_meta' ) );
	}
	public function add_meta_boxes( $post_type ) {
		$post_types = array( 'post', 'page' );
		if( !in_array( $post_type, $post_types ) )
			return;			//Meta boxes just for page and post
		
		//Metaboxes for posts only
		add_meta_box(
			'hyunmoo_meta_slider',
			__( 'Featured Hyunmoo post slider', 'hyunmoo' ),
			array( $this, 'render_post_metabox' ),
			'post',
			'side'
		);
		//Metaboxes for pages only
		add_meta_box(
			'hyunmoo_meta_op_scroll',
			__( 'Onepage Scroll', 'hyunmoo' ),
			array( $this, 'render_page_metabox' ),
			'page',
			'advanced'
		);
	}
	public function save_post_meta( $post_id ) {
		if( get_post_type( $post_id ) == 'page' ) {
			$this->save_page_meta( $post_id );	//Save meta for pages only
			return $post_id;
		}
		
		// Check if our nonce is set.
		if ( ! isset( $_POST['hyunmoo_custom_post_meta_nonce'] ) )
			return $post_id;

		$nonce = $_POST['hyunmoo_custom_post_meta_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'hyunmoo_custom_post_meta' ) )
			  return $post_id;

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if( 'post' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		/* OK, its safe for us to save the data now. */
		
		// Sanitize the user input.
		$slider = sanitize_text_field( $_POST['hyunmoo_slider'] );
		
		// Update the meta field.
		update_post_meta( $post_id, '_hyunmoo_featured_slider', $slider );
	}
	public function save_page_meta( $page_id ) {
		
		// Check if our nonce is set.
		if ( ! isset( $_POST['hyunmoo_page_section_meta_nonce'] ) )
			return $page_id;

		$nonce = $_POST['hyunmoo_page_section_meta_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'hyunmoo_page_section_meta' ) )
			  return $page_id;

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $page_id;
		// Check the user's permissions.
		if ( ! current_user_can( 'edit_page', $page_id ) )
			return $page_id;
		
		/* Check if any sections uploaded */
		if( !isset( $_POST['sections'] ) || empty( $_POST['sections'] ) )
			return $page_id;
			
		/* OK, its safe for us to save the data now. */
		$sections = $_POST['sections'];
		usort( $sections, array( $this, 'sectionSort' ) );
		update_post_meta( $page_id, '_hyunmoo_onepage_sections', $sections );
	}
	public function sectionSort( $a, $b ) {
		$order1 = $a['order'];
		$order2 = $b['order'];
		return ($order1 < $order2) ? -1 : 1;
	}
	public function render_post_metabox( $post ) {
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'hyunmoo_custom_post_meta', 'hyunmoo_custom_post_meta_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$slider = get_post_meta( $post->ID, '_hyunmoo_featured_slider', true );

		// Display the form, using the current value.
		echo '<label for="myplugin_new_field">';
		_e( 'Hyunmoo slider : ', 'hyunmoo' );
		echo '</label> ';
		
		global $wpdb;
		$sql = "SELECT `name`, `title` FROM {$wpdb->prefix}hyunmoo_records WHERE `type` = 'slider' AND `status` = 'public'";
		
		$results = $wpdb->get_results( $sql );
		$sliders = array();
		foreach( $results as $row )
			$sliders[$row->name] = $row->title;
			
		echo '<select id="hyunmoo_slider" name="hyunmoo_slider">';
		echo '<option value="">Select a slider</option>';
		foreach( $sliders as $name => $title ) {
			$selected = '';
			if( $slider == esc_attr( $name ) )
				$selected = ' selected="selected"';
			echo '<option value="' . esc_attr( $name ) . '"' . $selected . '>' . $title . '</option>';
		}
		echo '</select>';
	}
	public function render_page_metabox( $page ) {
		// Add an nonce field so we can check for it later.
		$path = get_template_directory_uri();
		wp_nonce_field( 'hyunmoo_page_section_meta', 'hyunmoo_page_section_meta_nonce' );
		
		$sections = get_post_meta( $page->ID, '_hyunmoo_onepage_sections', true );
		
		wp_enqueue_style( 'colorpicker-style', $path . '/css/colorpicker.css' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'colorpicker-script', $path . '/js/colorpicker.js' );
		wp_enqueue_script( 'page-metaboxes-script', $path . '/js/admin-metaboxes.js' );
		
		echo '<label for="section_pages">';
		_e( 'Pages : ', 'hyunmoo' );
		echo '</label>';
		wp_dropdown_pages();
?>

&nbsp;<a class="button" id="addnew" href="#"> + Add new section</a>&nbsp;
<small>Drag &amp; drop each section to change orders</small>
<br><br>
<table id="sections" class="widefat">
	<thead><tr><th>Page Sections</th><th>&nbsp;</th></tr></thead>
	<tbody>
<?php
	if( is_array( $sections ) ) :
		foreach( $sections as $order => $section ) :
			$background = $section['background'];
			$image = '';
			if( $background == 'url' ) {
				$imgurl = $section['url'];
				$image = '<img src="' . $imgurl . '" style="max-width:250px;" />';
			}
			elseif( $background == 'featured' ) {
				$image = get_the_post_thumbnail( $section['page'], 'large' );
			}
			
?>
		<tr><td class="imgcontainer" style="width:250px;border-right:1px solid #ccc;cursor:move;"><?php echo $image ?></td><td class="config">
			<h3 style="border:1px solid #ccc;"><i>Choose background for this section</i></h3><br>
			
			<p><input type="radio" name="sections[<?php echo $order ?>][background]" value="featured" <?php if( $background == 'featured' ) echo 'checked'; ?> /> Featured Image</p>
			
			<p><input type="radio" name="sections[<?php echo $order ?>][background]" value="color" <?php if( $background == 'color' ) echo 'checked'; ?> /> Background Color : <input type="text" name="sections[<?php echo $order ?>][color]" class="color" size="6" value="<?php echo $section['color'] ?>" /></p>
			
			<p><input type="radio" name="sections[<?php echo $order ?>][background]" value="url" <?php if( $background == 'url' ) echo 'checked'; ?> /> Custom Image : <input type="text" name="sections[<?php echo $order ?>][url]" class="url" style="width:400px;margin-left:18px;" value="<?php echo $section['url'] ?>" /><!-- <input type="button" class="button upload" value="Choose Image" />--></p>
			
			<p><input type="radio" name="sections[<?php echo $order ?>][background]" value="none" <?php if( $background == 'none' ) echo 'checked'; ?> /> None</p>
			
			<input type="hidden" class="order" name="sections[<?php echo $order ?>][order]" value="<?php echo $order ?>" />
			<input type="hidden" name="sections[<?php echo $order ?>][page]" value="<?php echo $section['page'] ?>" />
			
			<p class="right"><input type="button" class="button remove" value="Remove section" /></p>
		</td></tr>
<?php
		endforeach;
	endif;
?>
	</tbody>
</table>
<?php
	}
	public function ajax_get_featured_image() {
		$page = intval( $_POST['pageid'] );
		echo get_the_post_thumbnail( $page, 'large' );
		die;
	}
	public function media_action_button( $form_fields, $post ) {
		$page = $_GET['referer'];
		if( $page != 'sections' )
			return $form_fields;
			
		$send = "<input type='submit' class='button' name='send[$post->ID]' value='" . esc_attr__( 'Add to section' ) . "' />";
 
		$form_fields['buttons'] = array('tr' => "\t\t<tr class='submit'><td></td><td class='savesend'>$send</td></tr>\n");
		return $form_fields;
	}
	
	protected function _includeViews() {
		if( $handle = opendir( $this->pagespath ) ) {
			while( ( $folder = readdir( $handle ) ) ) {
				if( $folder != '.' && $folder != '..' && !is_file( $folder ) ) {
					$path = $this->pagespath . DS . $folder . DS . 'view.php';
					$id = HyunmooString::sanitize( $folder );;
					if( file_exists( $path ) ) {
						require_once $path;
						$class = 'Admin' . ucfirst( strtolower( $id ) );
						$this->pages[$id] = & new $class;
					}
					$path = $this->pagespath . DS . $folder . DS . 'handler.php';
					if( file_exists( $path ) ) {
						require_once $path;
						$class = 'Admin' . ucfirst( strtolower( $id ) ) . 'Handler';
						$this->handlers[$id] = & new $class;
					}
				}
			}
		}
	}
}
?>