<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//define option page parameters
if(!function_exists('mnnt_check_resetpassword')){
	
	function mnnt_check_resetpassword() {	
	
		echo '<script>console.log("included")</script>';
			
		if(!empty($_POST['mnnt-resetpassword-button'])) {
			
			global $mnnt_resetpassword_error;
			$mnnt_resetpassword_error = false;
			
			global $mnnt_resetpassword_info;
			$mnnt_resetpassword_info = false;
			
			//get and verify nonce
			$mnnt_resetpassword_nonce = $_POST['mnnt-resetpassword-button'];
			
			if(!wp_verify_nonce($mnnt_resetpassword_nonce, 'mnnt-resetpassword-nonce')) {
				
				$mnnt_resetpassword_error = __('An error occurred','main-entrance').', '.__('please retry','main-entrance');
				return;
				
			}
			
			if(empty($_POST['mnnt-resetpassword-email'])) { 
			
				$mnnt_resetpassword_error = __('An error occurred','main-entrance').', '.__('please retry','main-entrance');
				return;
			
			}
			
			if(empty($_POST['mnnt-resetpassword-token'])) { 
			
				$mnnt_resetpassword_error = __('An error occurred','main-entrance').', '.__('please retry','main-entrance');
				return;
			
			}
			
			$mnnt_resetpassword_password_posted = trim($_POST['mnnt-resetpassword-password']);
			
			if(strlen($mnnt_resetpassword_password_posted) < 5) {
				
				$mnnt_resetpassword_error = __('Please enter a password of at least six characters','main-entrance');
				return;
				
			}
							
			if(!preg_match('/[A-Za-z]/', $mnnt_resetpassword_password_posted) || !preg_match('/[0-9]/', $mnnt_resetpassword_password_posted)) {
				
				$mnnt_resetpassword_error = __('Please enter a password with both letters and numbers','main-entrance');
				return;	
				
			}	
			
			$mnnt_resetpassword_email_posted = sanitize_email($_POST['mnnt-resetpassword-email']);
			$mnnt_resetpassword_token_posted = sanitize_text_field($_POST['mnnt-resetpassword-token']);

			$mnnt_resetpassword_involved_user = get_user_by('email',$mnnt_resetpassword_email_posted);
			$mnnt_resetpassword_involved_user_id = $mnnt_resetpassword_involved_user->ID;
					
			$mnnt_lostpassword_token = get_user_meta($mnnt_resetpassword_involved_user_id,'_mnnt_lostpassword_token', true);
			$mnnt_lostpassword_token_expires = get_user_meta($mnnt_resetpassword_involved_user_id,'_mnnt_lostpassword_token_expires', true);

			if(
				empty($mnnt_lostpassword_token) || 
				empty($mnnt_lostpassword_token_expires) || 
				$mnnt_resetpassword_token_posted !== $mnnt_lostpassword_token
			) {
				
				$mnnt_resetpassword_error = __('An error occurred','main-entrance').', '.__('please retry','main-entrance');	
				return;				
				
			} else {
				
				if(current_time('timestamp', 1) > $mnnt_lostpassword_token_expires) {
					
					$mnnt_resetpassword_error = __('Your request is expired','main-entrance').', '.__('please retry','main-entrance');
					return;					
					
				} 
				
			}			
			
			$mnnt_resetpassword_involved_user_name_with_space = ' '.esc_html($mnnt_resetpassword_involved_user->display_name);
			
			wp_set_password($mnnt_resetpassword_password_posted, $mnnt_resetpassword_involved_user_id);
			delete_user_meta($mnnt_resetpassword_involved_user_id, '_mnnt_lostpassword_token');
			delete_user_meta($mnnt_resetpassword_involved_user_id, '_mnnt_lostpassword_token_expires');			
			
			$mnnt_resetpassword_url = get_permalink().'?mnnt-action=login';
						
			$mnnt_resetpassword_email_subject = __('Reset password confirmation for','main-entrance').' '.get_bloginfo('name');
			$mnnt_resetpassword_email_body = '
				<html>
					<body>
						<p>
							'.__('Hello','main-entrance').$mnnt_resetpassword_involved_user_name_with_space.',
						</p>
						<p>
							'.__('Your password had been reset successfully','main-entrance').', '.__('now you can','main-entrance').' <a href="'.$mnnt_resetpassword_url.'" title="'.__('Log In','main-entrance').'" alt="'.__('Log In','main-entrance').'">'.__('Log In','main-entrance').'</a>
						</p>
					</body>
				</html>';
			$mnnt_resetpassword_email_headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail($mnnt_resetpassword_email_posted, $mnnt_resetpassword_email_subject, $mnnt_resetpassword_email_body, $mnnt_resetpassword_email_headers);			
			
			setcookie('mnnt-generic-success', '1', current_time( 'timestamp', 1 ) + 10);
			wp_safe_redirect('?mnnt-action=login');
			exit;	
		
		}
			
	}
	
	add_action('template_redirect','mnnt_check_resetpassword');

	
} else {
	
	error_log('function: "mnnt_check_resetpassword" already exists');
	
}