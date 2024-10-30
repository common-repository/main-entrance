<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//setup page content
if(!function_exists('mnnt_build_login_page')){
	
	function mnnt_build_login_page() {

		//check capabilty
		//if(!current_user_can('activate_plugins')) return;
		
		if(!empty($_POST['mnnt-build-login-page'])) {
			
			if(!current_user_can('activate_plugins')) {return;}
						
			if(!empty($_POST['mnnt-build-login-page-nonce']) && wp_verify_nonce($_POST['mnnt-build-login-page-nonce'], 'mnnt-build-login-page-nonce')) {
			
				if(!post_exists('Login')){ 
				
					$mnnt_build_login_page = array(
					
						'post_type'    	=> 'Page',
						'post_title'    => 'Login',
						'post_name' 	=> 'Login',
						'post_content'  => '[main-entrance-form]',
						'post_status'   => 'publish',
						'post_author'   => get_current_user_id()
						
					);
					
					wp_insert_post($mnnt_build_login_page);
					
				} else {

					//info message
					$mnnt_message_text = __('The "Login" page already exists, it is not possible to build another one','main-entrance').'!';
					$mnnt_message_type = 'warning';
								
					add_settings_error(
						'mnnt-info',
						'mnnt-info',
						$mnnt_message_text,
						$mnnt_message_type				
					);				
					
				}
				
			} else {
				
				echo 'check nonce';
				die;
				
			}
			
		}
		
	}
	
	add_action('admin_init', 'mnnt_build_login_page');
	
} else {
	
	error_log('function: "mnnt_build_login_page" already exists');
	
}