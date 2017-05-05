<?php
/**
 * Adds Style_Widget widget.
 * This widget is shown on the toolbox sidebar.
 */
class HyunmooStyleWidget extends WP_Widget {
/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'style', // Base ID
			'Hyunmoo: Toolbox Style Widget', // Name
			array( 'description' => __( 'Theme Style Widget - Users will be able to change the look of the theme in the toolbox', 'hyunmoo' ) ) // Args
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
			echo '<div class="tool-title">' . $title . '</div>';	
?>

<div class="tool-content style">
	<p>
	Layout :
	<span class="layout input-radio"><input name="_layout" type="radio" id="round" class="input-radio" /><i class="fa radiobox fa-circle-o" style="color:#6684d8 !important;font-size:18px;"></i></span>Round 
	<span class="layout input-radio"><input name="_layout" type="radio" id="angular" class="input-radio" /><i class="fa radiobox fa-circle-o" style="color:#6684d8 !important;font-size:18px;"></i></span>Angular
	</p>
	<p>
	Skin :
	<span id="skin0" class="skin"><i class="fa fa-circle fa-lg" style="color:#3F549F"></i>&nbsp;<i class="fa fa-circle fa-lg" style="color:#75ad5e"></i></span>
	<span id="skin1" class="skin"><i class="fa fa-circle fa-lg" style="color:#f75083"></i>&nbsp;<i class="fa fa-circle fa-lg" style="color:#5BA0D0"></i></span>
	<span id="skin2" class="skin"><i class="fa fa-circle fa-lg" style="color:#84bd4e"></i>&nbsp;<i class="fa fa-circle fa-lg" style="color:#46A5E3"></i></span>
	</p>
	<p>
	Background :
	<span id="bg0" class="bg"><i class="fa fa-circle fa-2x" style="color:#EEF0F3"></i></span>
	<span id="bg1" class="bg"><i class="fa fa-circle fa-2x" style="color:#ebe5d1"></i></span>
	<span id="bg2" class="bg"><i class="fa fa-circle fa-2x" style="color:#d5c8b8"></i></span>
	<span id="bg3" class="bg"><i class="fa fa-circle-o fa-2x" style="color:#555"></i></span>
	<span id="bg4" class="bg bgimg">&nbsp;</span>
	<span id="bg5" class="bg bgimg">&nbsp;</span>
	<span id="bg6" class="bg bgimg">&nbsp;</span>
	<span id="bg7" class="bg bgimg">&nbsp;</span>
	</p>
	<p>
	<input id="usebgimg" class="input-checkbox" type="checkbox" value="1" /><i class="fa checkbox skin-secondary-text fa-check-square-o" style="position:relative;font-size:18px;margin-left:-20px;color:#6684d8 !important;"></i><label for="usebgimg">&nbsp;Use Image Background</label>
	</p>
	<p>
	<div class="input-group input-group-sm">
		<input type="url" id="bgurl" class="form-control" placeholder="Image URL" style="border-radius: 0px" />
		<span class="input-group-addon"><i rel="parallax" style="cursor:pointer;color:#2f5bcf;" class="fa fa-eye">!</i></span>
	</div>
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
			$title = __( 'Style', 'hyunmoo' );
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