<?php
/*
Plugin Name:		Main Entrance
Plugin URI:			https://wordpress.org/plugins/main-entrance/
Description:		Login, register or recover password through an handy and safe form that you can easily place, through shortcode, in every page or post of your WordPress website.
Version:			1.9.4
Author:				Christian Gatti
Author URI:			https://profiles.wordpress.org/christian-gatti/
License:			GPL-2.0+
License URI:		http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain:		main-entrance
Domain Path:		/languages
*/
 
//if this file is called directly, abort.
if(!defined('ABSPATH')) die();

//define a constant to call script and style enqueue
define('MNNT_BASE_URL',plugins_url().'/'.plugin_basename(dirname(__FILE__)));


//ACTIVATION

//plugin activation function
if(!function_exists('mnnt_plugin_activation')){

	function mnnt_plugin_activation() {

		//create e customrole if doesn't exists
		if(!get_role('main-entrance-user')){
		
			//define a custom role and set capability to subscriber
			add_role( 'main-entrance-user', 'Main Entrance User', get_role('subscriber') -> capabilities);
		
		}

	}
	
	//uninstall actions
	register_activation_hook( __FILE__ , 'mnnt_plugin_activation' );
	
}  else {
	
	error_log('function: "mnnt_plugin_activation" already exists');
	
}


//UNINSTALL

//plugin uninstall function
if(!function_exists('mnnt_plugin_uninstallation')){

	function mnnt_plugin_uninstallation() {
				
		//check if role exists
		if(get_role('main-entrance-user')){
			
			//get users with the role abolve
			$mnnt_main_entrance_user_query = new WP_User_Query(array('role' => 'main-entrance-user'));
	
			//if users exist
			if(!empty($mnnt_main_entrance_user_query->get_results())){
				
				$mnnt_options_array = get_option('_mnnt_options');
				
				if(!empty($mnnt_options_array['delete_users']) && $mnnt_options_array['delete_users'] === '1') {
				
					//loop into users ande delete
					foreach($mnnt_main_entrance_user_query->get_results() as $mnnt_main_entrance_user) {
						
						wp_delete_user($mnnt_main_entrance_user->ID);
						
					}
					
				} else {
					
					//loop into users ande change 'main-entrance-user' into 'subscriber' role
					foreach($mnnt_main_entrance_user_query->get_results() as $mnnt_main_entrance_user) {
						
						$mnnt_main_entrance_user_object = new WP_User($mnnt_main_entrance_user->ID);
						$mnnt_main_entrance_user_object->remove_role('main-entrance-user');
						$mnnt_main_entrance_user_object->add_role('subscriber');
						
						unset($mnnt_main_entrance_user_object);
						
					}					
					
				}
				
				unset($mnnt_main_entrance_user_query);
				
			}

			//delete custom role if exists
			remove_role('main-entrance-user');
			
			//delete options
			delete_option('_mnnt_options');
		
		}

	}
	
	//uninstall actions
	register_uninstall_hook( __FILE__ , 'mnnt_plugin_uninstallation' );
	
}  else {
	
	error_log('function: "mnnt_plugin_uninstallation" already exists');
	
}


//STYLES AND SCRIPTS

//public styles and scripts function
if(!function_exists('mnnt_register_public_styles_and_scripts')){
	
	function mnnt_register_public_styles_and_scripts() {
		
		wp_enqueue_style('main-entrance-style', MNNT_BASE_URL .'/public/css/style.css');
		wp_enqueue_script('main-entrance-script', MNNT_BASE_URL .'/public/js/script.js', array('jquery'), '', true );	
		
	}
	
	//load public styles and scripts
	add_action('wp_enqueue_scripts', 'mnnt_register_public_styles_and_scripts');
	
} else {
	
	error_log('function: "mnnt_register_public_styles_and_scripts" already exists');
	
}

//admin styles and scripts function
if(!function_exists('mnnt_register_admin_styles_and_scripts')){
	
	function mnnt_register_admin_styles_and_scripts() {
		
		wp_enqueue_style('main-entrance-style', MNNT_BASE_URL .'/admin/css/style.css');
		wp_enqueue_script('main-entrance-script', MNNT_BASE_URL .'/admin/js/script.js', array('jquery'), '', true );	
		
	}
	
	//load public styles and scripts
	add_action('admin_enqueue_scripts', 'mnnt_register_admin_styles_and_scripts');
	
} else {
	
	error_log('function: "mnnt_register_admin_styles_and_scripts" already exists');
	
}


//GET PLUGIN OPTIONS AND SET THEM GLOBAL

//get all plugin options and store them in global variables, so that get_options query is made only once
if(!function_exists('mnnt_get_options')){

	function mnnt_get_options() {
			
		//set global option variabiles
		global $mnnt_options_array;
		
		//get all options and store them
		$mnnt_options_array = get_option('_mnnt_options');
	
	}

	//load settings and store them in some global valibles
	add_action('plugins_loaded', 'mnnt_get_options');

} else {
	
	error_log('function: "mnnt_get_options" already exists');
	
}


//LOAD DEPENDENCIES

//load dependencies
if(!function_exists('mnnt_load_dependencies')){
	
	function mnnt_load_dependencies() {

		//include page where functions are defined
		require_once plugin_dir_path(__FILE__).'includes/mnnt_dependencies.php';
		mnnt_dependencies();
		
		require_once plugin_dir_path(__FILE__).'includes/mnnt_dependencies_by_settings.php';
		mnnt_dependencies_by_settings();
		
	}
	
	//load dependencies
	add_action('init', 'mnnt_load_dependencies');	
	
} else {
	
	error_log('function: "mnnt_load_dependencies" already exists');
	
}


//LOAD OPTIONS PAGES

//load options pages
if(!function_exists('mnnt_load_options')){
	
	function mnnt_load_options() {

		//return if is_admin is false, since we need this file only into administrative interface page
		if(!is_admin()) return;
		
		//include page where functions are defined
		require_once plugin_dir_path(__FILE__).'admin/mnnt_options.php';
		
	}
	
	//load options pages
	add_action('plugins_loaded', 'mnnt_load_options');
	
} else {
	
	error_log('function: "mnnt_load_options" already exists');
	
}


//USER CUSTOM FIELDS

require_once plugin_dir_path(__FILE__).'admin/includes/mnnt_save_user_fields.php';
add_action('personal_options_update', 'mnnt_save_user_fields');
add_action('edit_user_profile_update', 'mnnt_save_user_fields');

require_once plugin_dir_path(__FILE__).'admin/includes/mnnt_add_user_fields.php';
add_action('show_user_profile', 'mnnt_add_user_fields');
add_action('edit_user_profile', 'mnnt_add_user_fields');


//ADD SETTINGS LINK

//add settings link in plugin list page
function mnnt_add_setting_link ($mnnt_setting_links) {
	

	$mnnt_links_to_add = array(
		'<a href="'.admin_url('admin.php?page=mnnt-setup').'" title="Main Entrance Settings" alt="Main Entrance Settings">'.__('Settings','main-entrance').'</a>'
	,);
			
	return array_merge($mnnt_setting_links, $mnnt_links_to_add);
	
	}
	
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'mnnt_add_setting_link');