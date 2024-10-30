<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//define option page parameters
if(!function_exists('mnnt_forms')){
	
	function mnnt_forms() {	
		
		if(!empty($_REQUEST['mnnt-action'])) {
			
			$mnnt_action_retrieved = filter_var($_REQUEST['mnnt-action'], FILTER_SANITIZE_URL);
			$mnnt_accepted_actions = array('login','register','lostpassword','resetpassword');
			
			if(in_array($mnnt_action_retrieved, $mnnt_accepted_actions)) {
				
				$mnnt_form_to_diplay = $mnnt_action_retrieved;	
				
			} else {
				
				$mnnt_form_to_diplay = 'login';
			}
		
		} else {
			
			$mnnt_form_to_diplay = 'login';
		}
		
	
		switch($mnnt_form_to_diplay) {

			//login case
			case 'login':
			
				require_once plugin_dir_path(__FILE__).'mnnt_login_form.php';
				return mnnt_login_form($mnnt_form_to_diplay);
			
			break;
			
			//register case
			case 'register':
			
				require_once plugin_dir_path(__FILE__).'mnnt_register_form.php';
				return mnnt_register_form($mnnt_form_to_diplay);
			
			break;
			
			//lost password case
			case 'lostpassword':
			
				require_once plugin_dir_path(__FILE__).'mnnt_lostpassword_form.php';
				return mnnt_lostpassword_form($mnnt_form_to_diplay);
			
			break;
			
			//recovering case
			case 'resetpassword':
			
				require_once plugin_dir_path(__FILE__).'mnnt_resetpassword_form.php';
				return mnnt_resetpassword_form($mnnt_form_to_diplay);
			
			break;
			
			//default case
			default:
			
				mnnt_login_form();
			
			break;
			
			
		}

		
	}
	
	//option page
	add_shortcode('main-entrance-form', 'mnnt_forms');
	
} else {
	
	error_log('function: "mnnt_forms" already exists');
	
}