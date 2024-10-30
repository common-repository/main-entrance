<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//define option page parameters
if(!function_exists('mnnt_check_lostpassword')){
	
	function mnnt_check_lostpassword() {	
			
		if(!empty($_POST['mnnt-lostpassword-button'])) {
			
			global $mnnt_lostpassword_error;
			$mnnt_lostpassword_error = false;
			
			global $mnnt_lostpassword_info;
			$mnnt_lostpassword_info = false;
			
			//get and verify nonce
			$mnnt_lostpassword_nonce = $_POST['mnnt-lostpassword-button'];
			
			if(!wp_verify_nonce($mnnt_lostpassword_nonce, 'mnnt-lostpassword-nonce')) {
				
				$mnnt_lostpassword_error = __('An error occurred','main-entrance').', '.__('please retry','main-entrance');
				return;
				
			}
			
			$mnnt_lostpassword_email_posted = null;
			
			if(!empty($_POST['mnnt-lostpassword-email'])) {
				
				$mnnt_lostpassword_email_posted = sanitize_email(strtolower($_POST['mnnt-lostpassword-email']));
				
			}
			
			
			if(is_null($mnnt_lostpassword_email_posted)) {
			
				$mnnt_lostpassword_error = __('Please enter your email','main-entrance');
				return;
			
			}		
			
			
			if(!is_email($mnnt_lostpassword_email_posted)) {
				
				$mnnt_lostpassword_error = __("Please enter a valid email address","main-entrance");
				
				return;
			}
			
			
			if(!email_exists($mnnt_lostpassword_email_posted)) {
				
				$mnnt_lostpassword_error = __("Please provide a registered user email address","main-entrance");
				
				return;
			}	

			$mnnt_lostpassword_involved_user = get_user_by('email',$mnnt_lostpassword_email_posted);
			$mnnt_lostpassword_involved_user_id = $mnnt_lostpassword_involved_user->ID;
			$mnnt_lostpassword_involved_user_name_with_space = ' '.esc_html($mnnt_lostpassword_involved_user->display_name);
			
			$mnnt_lostpassword_token = wp_generate_password(48, false, false);
			$mnnt_lostpassword_token_expires = current_time( 'timestamp', 1 ) + 600;
			
			update_user_meta( $mnnt_lostpassword_involved_user_id, '_mnnt_lostpassword_token', $mnnt_lostpassword_token);
			update_user_meta( $mnnt_lostpassword_involved_user_id, '_mnnt_lostpassword_token_expires', $mnnt_lostpassword_token_expires);
			
			$mnnt_resetpassword_url = get_permalink().'?mnnt-action=resetpassword&mnnt-email='.$mnnt_lostpassword_email_posted.'&mnnt-token='.$mnnt_lostpassword_token;
						
			$mnnt_lostpassword_email_subject = __('Reset password request for','main-entrance').' '.get_bloginfo('name');
			$mnnt_lostpassword_email_body = '
				<html>
					<body>
						<p>
							'.__('Hello','main-entrance').$mnnt_lostpassword_involved_user_name_with_space.',
						</p>
						<p>
							'.__('In order to reset your password for log in to','main-entrance').' <strong>'.get_bloginfo('name').'</strong>, '.__('please click on the below link within ten minutes','main-entrance').'.
						</p>
						<p>
							<a href="'.$mnnt_resetpassword_url.'" title="'.__('Reset Password','main-entrance').'" alt="'.__('Reset Password','main-entrance').'">'.__('Reset Password','main-entrance').'</a>
						</p>
					</body>
				</html>';
			$mnnt_lostpassword_email_headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail($mnnt_lostpassword_email_posted, $mnnt_lostpassword_email_subject, $mnnt_lostpassword_email_body, $mnnt_lostpassword_email_headers);			
			
			$mnnt_lostpassword_info = __('In order to reset your password, please follow the instructions provided by email','main-entrance');
			
		}
			
	}
	
	add_action('template_redirect','mnnt_check_lostpassword');

	
} else {
	
	error_log('function: "mnnt_check_lostpassword" already exists');
	
}