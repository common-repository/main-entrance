<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');


if(!function_exists('mnnt_sanitize_entries')) {

    function mnnt_sanitize_entries($mnnt_posted_values) {

        //prepare array for saving sanitized data
        $mnnt_values_to_save = array();

        //introduce some varibles to control errors
        $mnnt_erros_found = 0;
        $mnnt_severe_erros_found = 0;
        $mnnt_secondary_acceptance_enabled = false;
        $mnnt_registration_is_allowed = false;

        //loop into posted data
        foreach($mnnt_posted_values as $mnnt_posted_key => $mnnt_posted_value){

            //filter by key
            switch($mnnt_posted_key) {

                //deal with allow_registration
                case 'allow_registration':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;
                        $mnnt_erros_found++;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                        $mnnt_registration_is_allowed = true;
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['allow_registration'] = $mnnt_posted_value;

                    break;

                //deal with default_acceptance_text
                case 'default_acceptance_text':

                    //check value
                    if(empty($mnnt_posted_value)){

                        $mnnt_posted_value = __('I consent to the processing of my data for the purposes described in','main-entrance');
                        $mnnt_erros_found++;

                    } else {
                        $mnnt_wp_kses_allowed_html = array(
                            'a' => array(
                                'href' => array(),
                                'title' => array(),
                                'alt' => array()
                            ),
                            'p' => array(),
                            'br' => array(),
                            'em' => array(),
                            'strong' => array(),
                        );
                        $mnnt_posted_value = wp_kses($mnnt_posted_value, $mnnt_wp_kses_allowed_html);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['default_acceptance_text'] = $mnnt_posted_value;

                    break;

                //deal with default_acceptance_doc_id
                case 'default_acceptance_doc_id':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || (get_post_status($mnnt_posted_value) !== 'publish' && $mnnt_posted_value !== '0')){

                        $mnnt_posted_value = 0;
                        $mnnt_erros_found++;

                        if($mnnt_registration_is_allowed === true) {

                            $mnnt_severe_erros_found++;
                            $mnnt_values_to_save['allow_registration'] = '0';

                        }

                    } else {

                        if($mnnt_registration_is_allowed === true && $mnnt_posted_value === '0') {

                            $mnnt_severe_erros_found++;
                            $mnnt_values_to_save['allow_registration'] = '0';

                        }

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['default_acceptance_doc_id'] = $mnnt_posted_value;

                    break;

                //deal with secondary_acceptance
                case 'secondary_acceptance':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;
                        $mnnt_erros_found++;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                        $mnnt_secondary_acceptance_enabled = true;
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['secondary_acceptance'] = $mnnt_posted_value;

                    break;

                //deal with secondary_acceptance_text
                case 'secondary_acceptance_text':

                    //check value
                    if(empty($mnnt_posted_value)){

                        $mnnt_posted_value = __('I consent to the processing of my data for the purposes described in','main-entrance');
                        $mnnt_erros_found++;

                    } else {
                        $mnnt_wp_kses_allowed_html = array(
                            'a' => array(
                                'href' => array(),
                                'title' => array(),
                                'alt' => array()
                            ),
                            'p' => array(),
                            'br' => array(),
                            'em' => array(),
                            'strong' => array(),
                        );
                        $mnnt_posted_value = wp_kses($mnnt_posted_value, $mnnt_wp_kses_allowed_html);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['secondary_acceptance_text'] = $mnnt_posted_value;

                    break;

                //deal with secondary_acceptance_doc_id
                case 'secondary_acceptance_doc_id':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || (get_post_status($mnnt_posted_value) !== 'publish' && $mnnt_posted_value !== '0')){

                        $mnnt_posted_value = 0;
                        $mnnt_erros_found++;

                        if($mnnt_registration_is_allowed === true && $mnnt_secondary_acceptance_enabled === true) {

                            $mnnt_severe_erros_found++;
                            $mnnt_values_to_save['allow_registration'] = '0';

                        }

                    } else {

                        if($mnnt_registration_is_allowed === true && $mnnt_posted_value === '0' && $mnnt_secondary_acceptance_enabled === true) {

                            $mnnt_severe_erros_found++;
                            $mnnt_values_to_save['allow_registration'] = '0';

                        }

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['secondary_acceptance_doc_id'] = $mnnt_posted_value;

                    break;

                //deal with role_slug
                case 'role_slug':

                    //check value
                    global $wp_roles;
                    if(!$wp_roles->is_role($mnnt_posted_value) || $mnnt_posted_value === 'main-entrance-user') {

                        $mnnt_posted_value = 'subscriber';
                        $mnnt_erros_found++;

                    }

                    //rebuild role and get capabilities from the role selected
                    if(get_role('main-entrance-user')){

                        remove_role('main-entrance-user');
                        $mnnt_new_capabilities = get_role($mnnt_posted_value) -> capabilities;
                        add_role( 'main-entrance-user', 'Main Entrance User', $mnnt_new_capabilities);

                    }

                    //add  value to array to save
                    $mnnt_values_to_save['role_slug'] = $mnnt_posted_value;

                    break;

                //deal with auto_login
                case 'auto_login':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;
                        $mnnt_erros_found++;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['auto_login'] = $mnnt_posted_value;

                    break;

                //deal with redirect_after_registration
                case 'redirect_after_registration':

                    //check value
					if(empty($mnnt_posted_value)) {
						
						$mnnt_posted_value = 0;
						
					}
					
                    else if(!is_numeric($mnnt_posted_value) || (get_post_status($mnnt_posted_value) !== 'publish' && $mnnt_posted_value !== '0')){

                        $mnnt_posted_value = 0;
                        $mnnt_erros_found++;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['redirect_after_registration'] = $mnnt_posted_value;

                    break;

                //deal with name_field
                case 'name_field':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['name_field'] = $mnnt_posted_value;

                    break;

                //deal with name_field_mandatory
                case 'name_field_mandatory':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['name_field_mandatory'] = $mnnt_posted_value;

                    break;

					
                //deal with surname_field
                case 'surname_field':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['surname_field'] = $mnnt_posted_value;

                    break;

                //deal with surname_field_mandatory
                case 'surname_field_mandatory':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['surname_field_mandatory'] = $mnnt_posted_value;

                    break;
					
                //deal with genre_field
                case 'genre_field':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['genre_field'] = $mnnt_posted_value;

                    break;

                //deal with genre_field_mandatory
                case 'genre_field_mandatory':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['genre_field_mandatory'] = $mnnt_posted_value;

                    break;
					
                //deal with date_of_birth_field
                case 'date_of_birth_field':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['date_of_birth_field'] = $mnnt_posted_value;

                    break;

                //deal with date_of_birth_field_mandatory
                case 'date_of_birth_field_mandatory':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['date_of_birth_field_mandatory'] = $mnnt_posted_value;

                    break;

                //deal with company_name_field
                case 'company_name_field':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['company_name_field'] = $mnnt_posted_value;

                    break;

                //deal with company_name_field_mandatory
                case 'company_name_field_mandatory':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['company_name_field_mandatory'] = $mnnt_posted_value;

                    break;

                //deal with phone_number_field
                case 'phone_number_field':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['phone_number_field'] = $mnnt_posted_value;

                    break;

                //deal with phone_number_field_mandatory
                case 'phone_number_field_mandatory':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['phone_number_field_mandatory'] = $mnnt_posted_value;

                    break;

                //deal with state_field
                case 'state_field':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['state_field'] = $mnnt_posted_value;

                    break;

                //deal with state_field_mandatory
                case 'state_field_mandatory':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['state_field_mandatory'] = $mnnt_posted_value;

                    break;

                //deal with country_field
                case 'country_field':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['country_field'] = $mnnt_posted_value;

                    break;

                //deal with country_field_mandatory
                case 'country_field_mandatory':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['country_field_mandatory'] = $mnnt_posted_value;

                    break;

				//deal with address_field
                case 'address_field':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['address_field'] = $mnnt_posted_value;

                    break;

                //deal with address_field_mandatory
                case 'address_field_mandatory':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['address_field_mandatory'] = $mnnt_posted_value;

                    break;

                //deal with notification_address
                case 'notification_address':

                    //check a valid value is set
                    if(empty($mnnt_posted_value)) {

                        $mnnt_posted_value = null;
                        $mnnt_erros_found++;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['notification_address'] = $mnnt_posted_value;

                    break;

                //deal with icons_nav_bar
                case 'icons_nav_bar':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;
                        $mnnt_erros_found++;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['icons_nav_bar'] = $mnnt_posted_value;

                    break;

                //deal with icon_page_id
                case 'icon_page_id':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || (get_post_status($mnnt_posted_value) !== 'publish' && $mnnt_posted_value !== '0')){

                        $mnnt_posted_value = 0;
                        //$mnnt_erros_found++;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['icon_page_id'] = $mnnt_posted_value;

                    break;

                //deal with hide_admin_bar
                case 'hide_admin_bar':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;
                        $mnnt_erros_found++;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['hide_admin_bar'] = $mnnt_posted_value;

                    break;

                //deal with hide_dashboard
                case 'hide_dashboard':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;
                        $mnnt_erros_found++;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['hide_dashboard'] = $mnnt_posted_value;

                    break;

                //deal with redirect_after_login_meu
                case 'redirect_after_login_meu':

                    //check value
					if(empty($mnnt_posted_value)) {
						
						$mnnt_posted_value = 0;
						
					}
					
                    else if(!is_numeric($mnnt_posted_value) || (get_post_status($mnnt_posted_value) !== 'publish' && $mnnt_posted_value !== '0')) {

                        $mnnt_posted_value = 0;
                        $mnnt_erros_found++;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['redirect_after_login_meu'] = $mnnt_posted_value;

                    break;

                //deal with redirect_after_login_all
                case 'redirect_after_login_all':

                    //check value
                    if(empty($mnnt_posted_value)) {
						
						$mnnt_posted_value = 0;
						
					}
					
                    else if((!is_numeric($mnnt_posted_value) && $mnnt_posted_value !== 'dashboard') || (get_post_status($mnnt_posted_value) !== 'publish' && $mnnt_posted_value !== '0' && $mnnt_posted_value !== 'dashboard')) {

                        $mnnt_posted_value = 0;
                        $mnnt_erros_found++;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['redirect_after_login_all'] = $mnnt_posted_value;

                    break;

                //deal with redirect_after_logout
                case 'redirect_after_logout':

                    //check value
                    if(empty($mnnt_posted_value)) {
						
						$mnnt_posted_value = 0;
						
					}
					
                    else if(!is_numeric($mnnt_posted_value) || (get_post_status($mnnt_posted_value) !== 'publish' && $mnnt_posted_value !== '0')){

                        $mnnt_posted_value = 0;
                        $mnnt_erros_found++;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['redirect_after_logout'] = $mnnt_posted_value;

                    break;

                //deal with hide_wp_login
                case 'hide_wp_login':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;
                        $mnnt_erros_found++;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['hide_wp_login'] = $mnnt_posted_value;

                    break;


                //deal with delete_users
                case 'delete_users':

                    //check value
                    if(!is_numeric($mnnt_posted_value) || ($mnnt_posted_value !== '0' && $mnnt_posted_value !== '1')){

                        $mnnt_posted_value = 0;
                        $mnnt_erros_found++;

                    } else {

                        $mnnt_posted_value = sanitize_text_field($mnnt_posted_value);
                    }

                    //add sanitized value to array to save
                    $mnnt_values_to_save['delete_users'] = $mnnt_posted_value;

                    break;

                //deal with custom fields
                default:
				
                    $mnnt_checks_result = apply_filters('mnnt_registration_additional_fields_settings_checks', true, $mnnt_posted_key, $mnnt_posted_value);
                    if ($mnnt_checks_result === false) {
                        //errors occurred!
                        $mnnt_erros_found++;
                        //value is rejected
                        $mnnt_values_to_save[$mnnt_posted_key] = null;
                    }
                    elseif ($mnnt_checks_result === true) {
                        //no checks performed (no hooks for current key were available)
                    }
                    else {
                        //check ok: add sanitized value to array to save
                        $mnnt_values_to_save[$mnnt_posted_key] = $mnnt_posted_value;
                    }

            }

        }

        if($mnnt_severe_erros_found > 0) {

            //info message
            $mnnt_message_text = __('Registration can not be allowed since you did not provide a valid GDPR and privacy policies information document','main-entrance').'!';
            $mnnt_message_type = 'error';

            add_settings_error(
                'mnnt-error',
                'mnnt-error',
                $mnnt_message_text,
                $mnnt_message_type
            );

        }

        if($mnnt_erros_found > 0) {

            //info message
            $mnnt_message_text = __('One or more values entered were not accepted, so they were set to a default value. Please check it out','main-entrance').'!';
            $mnnt_message_type = 'warning';

            add_settings_error(
                'mnnt-info',
                'mnnt-info',
                $mnnt_message_text,
                $mnnt_message_type
            );

        }

        //return array to save
        return $mnnt_values_to_save;

    }

}


if(!function_exists('mnnt_register_settings_action')) {
	
	function mnnt_register_settings_action() {

		if(!empty($_POST['mnnt-save-options'])) {
			
			if(!current_user_can('activate_plugins')) {return;}
			
			//can't find out if nonce is checkd on register_setting, so let's check it "manually"
			if(!empty($_POST['mnnt-options-nonce']) && wp_verify_nonce($_POST['mnnt-options-nonce'], 'mnnt-options-nonce')) {
				
				//create an empty option first, otherwise register_setting acts twice
				update_option('_mnnt_options', '', false);
				
				//register settings
				$mnnt_register_options_args = array(
					'type' => 'string', 
					'sanitize_callback' => 'mnnt_sanitize_entries',
					);
					
				register_setting('mnnt-section', '_mnnt_options', $mnnt_register_options_args); 
				
				//update message
				$mnnt_message_text = __( 'Settings saved', 'main-entrance' ).'!';
				$mnnt_message_type = 'updated';
						
				add_settings_error(
					'mnnt-message',
					'mnnt-message',
					$mnnt_message_text,
					$mnnt_message_type
				);
				
			}
			

		}

	}
	
	add_action('admin_init', 'mnnt_register_settings_action');

} else {
	
	error_log('function: "mnnt_register_settings_action" already exists');
	
}