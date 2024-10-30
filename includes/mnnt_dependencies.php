<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//LOAD DEPENDENCIES
if(!function_exists('mnnt_dependencies')){

	function mnnt_dependencies() {
		
		//this dependecies need only on frontend pages
		if(is_admin()) {
			
			return;
			
		}
	
		//include shortcode
		require_once plugin_dir_path(__DIR__).'public/includes/mnnt_forms.php';
		
		global $mnnt_options_array;
		
		if(
		
			!empty($mnnt_options_array['icons_nav_bar']) && 
			$mnnt_options_array['icons_nav_bar'] === '1' &&
			!empty($mnnt_options_array['icon_page_id']) && 
			$mnnt_options_array['icon_page_id'] !== '0'
			
		) {
		
			//include user icon
			require_once plugin_dir_path(__DIR__).'public/includes/mnnt_add_user_icon.php';
			
			
			function mnnt_add_dashicons_to_frontend() {

				wp_enqueue_style('dashicons');

			}
			
			add_action('wp_enqueue_scripts', 'mnnt_add_dashicons_to_frontend');
			
		}
			
		
		//include check pages for each form, only if form is posted
		if(!empty($_POST['mnnt-login-button'])) {
		
			require_once plugin_dir_path(__DIR__).'public/includes/mnnt_check_login.php';
			
		}
		
		if(!empty($_POST['mnnt-logout-button'])) {
		
			require_once plugin_dir_path(__DIR__).'public/includes/mnnt_check_logout.php';
			
		}
		
		if(!empty($_POST['mnnt-register-button'])) {
			
			require_once plugin_dir_path(__DIR__).'public/includes/mnnt_check_register.php';
		
		}
		
		if(!empty($_POST['mnnt-lostpassword-button'])) {
			
			require_once plugin_dir_path(__DIR__).'public/includes/mnnt_check_lostpassword.php';
		
		}
		
		if(!empty($_POST['mnnt-resetpassword-button'])) {
			
			require_once plugin_dir_path(__DIR__).'public/includes/mnnt_check_resetpassword.php';
			
		}	
		
		//include check page for resetpassord form, if form is not posted
		if(!empty($_REQUEST['mnnt-action']) && $_REQUEST['mnnt-action'] === 'resetpassword') {
		
			require_once plugin_dir_path(__DIR__).'public/includes/mnnt_resetpassword_form_check.php';
			
		}
		
		//redirect to login page if registration if not allowed
		if(!empty($_REQUEST['mnnt-action']) && $_REQUEST['mnnt-action'] === 'register') {
			
			global $mnnt_options_array;
			
			if(empty($mnnt_options_array['allow_registration']) || $mnnt_options_array['allow_registration'] !== '1') { 
			
				wp_safe_redirect('?mnnt-action=login');
				exit;
				
			}
			
		}
				
	}		
	
} else {
	
	error_log('function: "mnnt_dependencies" already exists');
	
}