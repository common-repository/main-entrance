<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//define option page parameters
if(!function_exists('mnnt_add_user_icon')){
	
	function mnnt_add_user_icon($mnnt_menu_entries, $mnnt_menu_arguments) {	
	
		global $mnnt_options_array;
	
		if(!empty($mnnt_options_array['icon_page_id']) && $mnnt_options_array['icon_page_id'] !== '0' /*&& $mnnt_menu_arguments->theme_location === 'primary'*/) {
			
			if(is_user_logged_in()) { 

				$mnnt_menu_entry_to_add = '<li id="mnnt-user-icon" class="menu-item"><a href="'.get_permalink($mnnt_options_array['icon_page_id']).'"><span class="dashicons dashicons-admin-users"></span></a></li>';
				$mnnt_menu_entries = $mnnt_menu_entries.$mnnt_menu_entry_to_add;
						
			
			} else {
				
				$mnnt_menu_entry_to_add = '<li id="mnnt-user-icon" class="menu-item"><a href="'.get_permalink($mnnt_options_array['icon_page_id']).'"><span class="dashicons dashicons-admin-users"></span></a></li>';
				$mnnt_menu_entries = $mnnt_menu_entries.$mnnt_menu_entry_to_add;		
				
			}
			
		}
		
		return $mnnt_menu_entries;
	
	}
	
	add_filter('wp_nav_menu_items', 'mnnt_add_user_icon', 10, 2);

	
} else {
	
	error_log('function: "mnnt_add_user_icon" already exists');
	
}