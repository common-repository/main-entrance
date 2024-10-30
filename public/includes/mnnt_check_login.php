<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//define option page parameters
if(!function_exists('mnnt_check_login')){
	
	function mnnt_check_login() {	
			
		if(!empty($_POST['mnnt-login-button'])) {
			
			global $mnnt_login_error;
			$mnnt_login_error = false;
			
			global $mnnt_login_info;
			$mnnt_login_info = false;
			
			//get and verify nonce
			$mnnt_login_nonce = $_POST['mnnt-login-button'];
			
			if(!wp_verify_nonce($mnnt_login_nonce, 'mnnt-login-nonce')) {
				
				$mnnt_login_error = __('An error occurred','main-entrance').', '.__('please retry','main-entrance');
				return;
				
			}
			
			if(empty($_POST['mnnt-login-username']) || empty($_POST['mnnt-login-password'])) {
			
				$mnnt_login_error = __('All fields are required','main-entrance');
				return;
			
			}		
			
			$mnnt_posted_data = array();
			$mnnt_posted_data['user_login'] = sanitize_user($_POST['mnnt-login-username']);
			$mnnt_posted_data['user_password'] = trim($_POST['mnnt-login-password']);
			$mnnt_posted_data['remember'] = true;		
			
			//check user with wp_signon
			$mnnt_signon = wp_signon($mnnt_posted_data);
			if(is_wp_error($mnnt_signon)){
				
				global $ptnns_secure_options_array;	
				
				//deal with wp_signon errors and add Optenhanse custom errors, if it is installed and if they are set
				switch($mnnt_signon->get_error_code()) {
					
					case ('invalid_username'):
					
					if (!empty($ptnns_secure_options_array['invalid_username_login_errors'])){
						
						$mnnt_login_error = wp_kses_post($ptnns_secure_options_array['invalid_username_login_errors']);
						
					} else {
						
						$mnnt_login_error = __('The entered values are not valid','main-entrance').', '.__('please retry','main-entrance');
					}
					
					break;
					
					case ('invalid_email'):
					
					if (!empty($ptnns_secure_options_array['invalid_email_login_errors'])){
						
						$mnnt_login_error = wp_kses_post($ptnns_secure_options_array['invalid_email_login_errors']);
						
					} else {
						
						$mnnt_login_error = __('The entered values are not valid','main-entrance').', '.__('please retry','main-entrance');
						
					}
					
					break;
					
					case ('incorrect_password'):
					
					if (!empty($ptnns_secure_options_array['incorrect_password_login_errors'])){
						
						$mnnt_login_error = wp_kses_post($ptnns_secure_options_array['incorrect_password_login_errors']);
						
					} else {
						
						$mnnt_login_error = __('The entered values are not valid','main-entrance').', '.__('please retry','main-entrance');
						
					}
					
					break;

					
					default:
					$mnnt_login_error = __('The entered values are not valid','main-entrance').', '.__('please retry','main-entrance');
					break;
				}
				
				//append message if Optenhanse check_login is enabled or display lock and ban messages if they are set
				if(!empty($ptnns_secure_options_array['check_login']) && esc_attr($ptnns_secure_options_array['check_login']) === '1') {
					
					//deal again with login errors
					if (
						$mnnt_signon->get_error_code() === 'invalid_username' ||
						$mnnt_signon->get_error_code() === 'invalid_email' ||
						$mnnt_signon->get_error_code() === 'incorrect_password' ||
						$mnnt_signon->get_error_code() === 'authentication_failed'
					){
						
						global $ptnns_get_attempts_left;
						global $ptnns_do_things_on_signon_fail;
												
						if(
							!empty($ptnns_secure_options_array['login_warn']) && 
							$ptnns_secure_options_array['login_warn'] === '1' &&
							$ptnns_get_attempts_left > 0
						){
							$mnnt_login_error = $mnnt_login_error.'<br>'.__('Be careful','ptnnslang').': '.__('you have only','ptnnslang').' '.$ptnns_get_attempts_left.' '.__('attempts left','ptnnslang');
								
						} 
						
						elseif(
							!empty($ptnns_secure_options_array['lock_down_message']) &&
							$ptnns_get_attempts_left <= 0
						){
							
							if($ptnns_do_things_on_signon_fail === 'ban') {

								$mnnt_login_error = esc_attr($ptnns_secure_options_array['ban_message']);
								//prevent from further authentication
								remove_filter('authenticate','wp_authenticate_username_password',20,3);							
								
							}
							
							elseif($ptnns_do_things_on_signon_fail === 'lock') {
								
								$mnnt_login_error = esc_attr($ptnns_secure_options_array['lock_down_message']);
								//prevent from further authentication
								remove_filter('authenticate','wp_authenticate_username_password',20,3);
													
							}
	
						} 
						
					}
				
				}					

			} else {
									
				$mnnt_login_info = __('You have logged in successfully','main-entrance').'! '.__('Please wait','main-entrance').'.';
				
				$mnnt_current_user_roles = $mnnt_signon->roles;

				global $mnnt_options_array;

				if(in_array('main-entrance-user', $mnnt_current_user_roles, true)) {

					$mnnt_page_id_to_redirect = $mnnt_options_array['redirect_after_login_meu'];

				} else {
					
					$mnnt_page_id_to_redirect = $mnnt_options_array['redirect_after_login_all'];				

					if($mnnt_page_id_to_redirect === 'dashboard') {
						
						wp_safe_redirect(get_admin_url());
						exit;
						
					}
					
				}			

				if(!empty($mnnt_page_id_to_redirect) && is_numeric($mnnt_page_id_to_redirect) && $mnnt_page_id_to_redirect !== '0' && get_post_status($mnnt_page_id_to_redirect) === 'publish') {

					wp_safe_redirect(get_permalink($mnnt_page_id_to_redirect));
					exit;
					
				} else {
					
					if(isset($_COOKIE['rsmd_redirect_start']) && !empty($_COOKIE['rsmd_redirect_start'])){
						
						$mnnt_page_id_to_redirect = esc_url(base64_decode($_COOKIE['rsmd_redirect_start']));
						setcookie('rsmd_redirect_start', '0', current_time( 'timestamp', 1 ) - 3600);
						wp_safe_redirect($mnnt_page_id_to_redirect);
					
					}

					elseif(isset($_COOKIE['nfprct_redirect_start']) && !empty($_COOKIE['nfprct_redirect_start'])){
						
						$mnnt_page_id_to_redirect = esc_url(base64_decode($_COOKIE['nfprct_redirect_start']));
						setcookie('nfprct_redirect_start', '0', current_time( 'timestamp', 1 ) - 3600);
						wp_safe_redirect($mnnt_page_id_to_redirect);
						
					} else {
						
						wp_safe_redirect(get_site_url());
						
					}
					
					exit;
					
				}

				
			}
		
		
		}
			
	}
	
	add_action('template_redirect','mnnt_check_login');

	
} else {
	
	error_log('function: "mnnt_check_login" already exists');
	
}