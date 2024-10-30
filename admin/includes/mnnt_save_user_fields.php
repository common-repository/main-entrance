<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//SAVE USER FIELDS
if(!function_exists('mnnt_save_user_fields')){

	function mnnt_save_user_fields($user_id) {
		
		//this dependecies need only on admin pages
		if(!is_admin() || !current_user_can('create_users')) {
			
			return;
			
		}
	
		global $mnnt_options_array;
		
		if(!empty($mnnt_options_array['genre_field']) && $mnnt_options_array['genre_field'] === '1') {
			
			update_user_meta($user_id, '_mnnt_genre', sanitize_text_field($_POST['mnnt-register-genre']));
			
		}
	
		if(!empty($mnnt_options_array['date_of_birth_field']) && $mnnt_options_array['date_of_birth_field'] === '1') {
		
			update_user_meta($user_id, '_mnnt_date_of_birth', sanitize_text_field($_POST['mnnt-register-date-of-birth']));
			
		}
		
		if(!empty($mnnt_options_array['company_name_field']) && $mnnt_options_array['company_name_field'] === '1') {
		
			update_user_meta($user_id, '_mnnt_company_name', sanitize_text_field($_POST['mnnt-register-company-name']));
			
		}
		
		if(!empty($mnnt_options_array['phone_number_field']) && $mnnt_options_array['phone_number_field'] === '1') {
		
			update_user_meta($user_id, '_mnnt_phone_number', sanitize_text_field($_POST['mnnt-register-phone-number']));
			
		}
		
		if(!empty($mnnt_options_array['state_field']) && $mnnt_options_array['state_field'] === '1') {
		
			update_user_meta($user_id, '_mnnt_state', sanitize_text_field($_POST['mnnt-register-state']));
		
		}
		
		if(!empty($mnnt_options_array['country_field']) && $mnnt_options_array['country_field'] === '1') {
		
			update_user_meta($user_id, '_mnnt_country', sanitize_text_field($_POST['mnnt-register-country']));
		
		}
		
		if(!empty($mnnt_options_array['address_field']) && $mnnt_options_array['address_field'] === '1') {
		
			update_user_meta($user_id, '_mnnt_address', sanitize_text_field($_POST['mnnt-register-address']));
		
		}
				
	}		
	
} else {
	
	error_log('function: "mnnt_save_user_fields" already exists');
	
}