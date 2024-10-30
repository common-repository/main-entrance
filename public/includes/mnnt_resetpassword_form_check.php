<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//define option page parameters
if(!function_exists('mnnt_resetpassword_form_check')){
	
	function mnnt_resetpassword_form_check() {
		
		if(empty($_REQUEST['mnnt-email']) || empty($_REQUEST['mnnt-token']) || is_user_logged_in()) {

			setcookie('mnnt-generic-error', '1', current_time( 'timestamp', 1 ) + 10);
			wp_safe_redirect('?mnnt-action=login');
			exit;
		
		}		
		
		$mnnt_resetpassword_email_requested = sanitize_email($_REQUEST['mnnt-email']);
		$mnnt_resetpassword_token_requested = sanitize_text_field($_REQUEST['mnnt-token']);		
			
		if(!is_email($mnnt_resetpassword_email_requested)) {
			
			setcookie('mnnt-generic-error', '1', current_time( 'timestamp', 1 ) + 10);
			wp_safe_redirect('?mnnt-action=login');
			exit;
			
		}
		
		if(!email_exists($mnnt_resetpassword_email_requested)) {

			setcookie('mnnt-generic-error', '1', current_time( 'timestamp', 1 ) + 10);
			wp_safe_redirect('?mnnt-action=login');
			exit;
			
		}	
			

		$mnnt_resetpassword_involved_user = get_user_by('email',$mnnt_resetpassword_email_requested);
		$mnnt_resetpassword_involved_user_id = $mnnt_resetpassword_involved_user->ID;
		
		$mnnt_lostpassword_token = get_user_meta($mnnt_resetpassword_involved_user_id,'_mnnt_lostpassword_token', true);

		if($mnnt_resetpassword_token_requested !== $mnnt_lostpassword_token) {

			setcookie('mnnt-generic-error', '1', current_time( 'timestamp', 1 ) + 10);
			wp_safe_redirect('?mnnt-action=login');
			exit;				
			
		} else {
		
			$mnnt_lostpassword_token_expires = get_user_meta($mnnt_resetpassword_involved_user_id,'_mnnt_lostpassword_token_expires', true);
			
			if(!empty($mnnt_lostpassword_token_expires) && current_time('timestamp', 1) > $mnnt_lostpassword_token_expires) {
				
				global $mnnt_resetpassword_error;
				$mnnt_resetpassword_error = __('Your request is expired','main-entrance').', '.__('please retry','main-entrance');	

				delete_user_meta($mnnt_resetpassword_involved_user_id, '_mnnt_lostpassword_token');
				delete_user_meta($mnnt_resetpassword_involved_user_id, '_mnnt_lostpassword_token_expires');					
				
			} 
			
		}
	
	}
	
	add_action('template_redirect','mnnt_resetpassword_form_check');
	
} else {
	
	error_log('function: "mnnt_resetpassword_form_check" already exists');
	
}