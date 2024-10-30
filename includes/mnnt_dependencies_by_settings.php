<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('mnnt_dependencies_by_settings')) {
	
	function mnnt_dependencies_by_settings() {
		
		global $mnnt_options_array;
		
		if(
			(!empty($mnnt_options_array['hide_dashboard']) && $mnnt_options_array['hide_dashboard'] === '1') ||
			(!empty($mnnt_options_array['hide_admin_bar']) && $mnnt_options_array['hide_admin_bar'] === '1')
			
		) {
		
			$mnnt_get_current_user = wp_get_current_user();
			$mnnt_get_current_user_role = $mnnt_get_current_user -> roles;
			
			if(!empty($mnnt_options_array['hide_admin_bar']) && $mnnt_options_array['hide_admin_bar'] === '1') {
			
				if(in_array('main-entrance-user', $mnnt_get_current_user_role)) {
							   
					add_filter( 'show_admin_bar', '__return_false' );
					
				}
				
			}
			
			if(!empty($mnnt_options_array['hide_dashboard']) && $mnnt_options_array['hide_dashboard'] === '1') {
				
				if(in_array('main-entrance-user', $mnnt_get_current_user_role) && is_admin() && wp_doing_ajax() === false){

					wp_safe_redirect(site_url());
					exit;
					
				}				
				
			}
			
		}
		
		if((!empty($mnnt_options_array['hide_wp_login']) && $mnnt_options_array['hide_wp_login'] === '1')) {
			
			//check if page is wp-login or wp-register
			if($GLOBALS['pagenow'] === 'wp-login.php' || $GLOBALS['pagenow'] === 'wp-register.php') {
					
				//check none of admitted action is set
				if(
				
					(empty($_REQUEST['loggedout']) || (!empty($_REQUEST['loggedout']) && sanitize_text_field($_REQUEST['loggedout']) !== 'true')) &&
					(empty($_REQUEST['action']) || (!empty($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) !== 'logout' && sanitize_text_field($_REQUEST['action']) !== 'postpass'))
				
				) {			
								
					//check if at least one page contains Main Entrace shorctode
					global $wpdb;
					$mnnt_check_main_entrance_form = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->posts WHERE post_status='publish' AND post_content LIKE '%[main-entrance-form]%'");

					if(!empty($mnnt_check_main_entrance_form) && $mnnt_check_main_entrance_form >= 1) {
						
						//show 404 page
						global $wp_query;
						$wp_query->set_404();
						status_header(404);
						
						if(get_404_template()) {
							

							include(get_404_template());	
						
						} else {
							
							wp_safe_redirect(get_bloginfo('url'));
							
						}
						
						die;
						
					}
							
				}			

			}
			
		}
		
	}
	
	
} else {
	
	error_log('function: "mnnt_dependencies_by_settings" already exists');
	
}