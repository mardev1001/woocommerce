<?php
/**
 * Adds Blog_Widget widget.
 * This widget is shown on the toolbox sidebar.
 */
class HyunmooBlogWidget extends WP_Widget {
/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'blog', // Base ID
			'Hyunmoo: Toolbox Blog Widget', // Name
			array( 'description' => __( 'Theme Blog Widget - Users will be given rich options when exploring posts and pages in the toolbox', 'hyunmoo' ) ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		if ( ! empty( $title ) )
			echo '<div class="tool-title"><i class="fa fa-pencil fa-lg">&nbsp;</i>' . $title . '</div>';	
?>
<div class="tool-content">
	<p>
	Layout :
	<span class="layout input-radio"><input name="_layout" type="radio" id="round" class="input-radio" /></span>Round 
	<span class="layout input-radio"><input name="_layout" type="radio" id="angular" class="input-radio" /></span>Angular
	</p>
	
</div>
<?php
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Blog', 'hyunmoo' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
}
?>