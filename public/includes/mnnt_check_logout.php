<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//define option page parameters
if(!function_exists('mnnt_check_logout')){
	
	function mnnt_check_logout() {	
			
		if(!empty($_POST['mnnt-logout-button'])) {
						
			//get and verify nonce
			$mnnt_logout_nonce = $_POST['mnnt-logout-button'];
			
			if(!wp_verify_nonce($mnnt_logout_nonce, 'mnnt-logout-nonce')) {
				
				$mnnt_logout_error = __('An error occurred','main-entrance').', '.__('please retry','main-entrance');
				return;
				
			}
			
			wp_logout();
			
			global $mnnt_options_array;
			$mnnt_page_id_to_redirect = $mnnt_options_array['redirect_after_logout'];
			
			if(!empty($mnnt_page_id_to_redirect) && is_numeric($mnnt_page_id_to_redirect) && $mnnt_page_id_to_redirect !== '0') {
							   
				wp_safe_redirect(get_permalink($mnnt_page_id_to_redirect));
				exit;

				
			} else {
				
				wp_safe_redirect(get_site_url());
				exit;
				
			}
			
		}
			
	}
	
	add_action('template_redirect','mnnt_check_logout');

	
} else {
	
	error_log('function: "mnnt_check_logout" already exists');
	
}