<?php
/**
 * Adds Contact_Widget widget.
 * This widget is shown on the toolbox sidebar.
 */
class HyunmooContactWidget extends WP_Widget {
/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'contact', // Base ID
			'Hyunmoo: Contact Us Widget', // Name
			array( 'description' => __( 'Theme Contact Widget - Users will be able to submit their messages', 'hyunmoo' ) ) // Args
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
		if( is_user_logged_in() ) {
			get_currentuserinfo();
			global $current_user;
			$user = $current_user;
		}
?>
<div id="contactusform">
<div class="skin-primary" id="formheading">Contact Us!<span class="arrow"></span></div>
<div id="formcontent">
	<input type="text" class="form-control contactinput" id="contactname" value="<?php if( isset( $user ) ) echo $user->data->display_name; ?>" placeholder='Name' />
	<input type="text" class="form-control contactinput" id="contactemail" value="<?php if( isset( $user ) ) echo $user->data->user_email; ?>" placeholder="Email" />
	<input type="text" class="form-control contactinput" id="subject" placeholder="Subject" />
	<textarea class="form-control contactinput" id="inquiry" placeholder='Leave us your inquiry here.'></textarea>
	<a href='#' class="skin-primary" id="send">Send</a>
</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('#contactusform a#send').click(function(event) {
			var name = $('#contactusform #contactname').val();
			var email = $('#contactusform #contactemail').val();
			var subject = $('#contactusform #subject').val();
			var inquiry = $('#contactusform #inquiry').val();
			if( name.trim()=='' || email.trim()=='' || subject.trim()=='' || inquiry.trim()=='' ) {
				alert("You must fill all fields.");
				return;
			}
			var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
			var test = $('#contactusform #contactemail').val().match(regex);
			if( test == undefined || test == null || test[0] == '' ) {
				alert("Email field is invalid.");
				return;
			}
			
			$('#contactusform a#send').text('Sending ..');
			$.ajax({
				type: "POST",
				url: window.ajaxurl,
				data: {
					action: 'send_note',
					name: name,
					email: email,
					subject: subject,
					inquiry: inquiry
				},
				success:function(response) {
					$('#contactusform a#send').text('Send');
				}
			});
			event.preventDefault();
		});
	});
</script>
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
		
	}
}
?>