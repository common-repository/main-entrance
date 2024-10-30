<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//define option page parameters
if(!function_exists('mnnt_login_form')){
	
	function mnnt_login_form($mnnt_form_to_diplay) {

		global $mnnt_options_array;
		$mnnt_content_to_return = null;
		
		if(is_user_logged_in()) {
			
			$mnnt_current_user_object = wp_get_current_user();
			$mnnt_current_name_with_space = ' '.esc_html($mnnt_current_user_object->display_name);
			
			$mnnt_content_to_return .= '
			
			<div id="mnnt-main-container" class="mnnt-main-container">
				
					<h2 id="mnnt-form-title" class="mnnt-form-title">'.__('Log Out','main-entrance').'</h2>
					
					';
					
					//this piece of code is for interacting with Restricted Media plugin and to print an error on login page
					if(
					
						(
					
						!empty($_COOKIE['rsmd_not_allowed_role']) 
						&& $_COOKIE['rsmd_not_allowed_role'] === '1'
						
						) || (
						
						!empty($_COOKIE['nfprct_not_allowed_role']) 
						&& $_COOKIE['nfprct_not_allowed_role'] === '1'
						
						)
						
					) {
																	
						$mnnt_content_to_return .='
						
						<div id="mnnt-error-container" class="mnnt-error-container">

							<div id="mnnt-error" class="mnnt-error">
							
							<p>
							
							'.__('You are not allowed to view this content, please contact the site owner','main-entrance').'
				
							</p>
							
							</div>
						

						</div>
						
						';
						
					}

					
					$mnnt_content_to_return .='
		
					<p>

						'.__('Hello','main-entrance').$mnnt_current_name_with_space.',<br>'.__('you are currently logged in','main-entrance').'!
						
					</p>
					
					<p>

						'.__('Click on the button below if you want to log out','main-entrance').'.
						
					</p>
					
					<p>
						<form method="post">
						
							<button name="mnnt-logout-button" id="mnnt-logout-buton" class="button primary-button mnnt-button mnnt-logout-button" value="'.wp_create_nonce('mnnt-logout-nonce').'">'.__('Log Out','main-entrance').'</button>
						
						</form>
						
					</p>	
			
			</div>
			
			';
					
			return $mnnt_content_to_return;			
			
		}

		$mnnt_content_to_return .= '
		
		<div id="mnnt-main-container" class="mnnt-main-container">
		
		';
				
		if(!empty($mnnt_options_array['allow_registration']) && $mnnt_options_array['allow_registration'] === '1') { 
					
			$mnnt_content_to_return .= '
			
			<div id="mnnt-menu-container" class="mnnt-menu-container">
			
				<div id="mnnt-menu" class="mnnt-menu">
				
				';
				
				if(empty($mnnt_form_to_diplay) || $mnnt_form_to_diplay === 'login') {
					
					$mnnt_content_to_return .= 
										
					__('Log In','main-entrance').' | <a href="?mnnt-action=register">'.__('Register','main-entrance').'</a></p>
					
					';
				}
				
				elseif($mnnt_form_to_diplay === 'register') {
					
					$mnnt_content_to_return .= '
	
					<a href="?mnnt-action=login">'.__('Log In','main-entrance').'</a> | '.__('Register','main-entrance')
					
					;	
					
				} else {
					
					$mnnt_content_to_return .= '
					
					<a href="?mnnt-action=login">'.__('Log In','main-entrance').'</a> | <a href="?mnnt-action=register">'.__('Register','main-entrance').'</a>
					
					';					
					
				}
				
				
				$mnnt_content_to_return .= '
				
				</div>
			
			</div>
			
			';
			
		}
		
			$mnnt_content_to_return .= '
		
			<div id="mnnt-form-container" class="mnnt-form-container">
			
				<h2 id="mnnt-form-title" class="mnnt-form-title">'.__('Log In','main-entrance').'</h2>
				
				<div id="mnnt-error-container" class="mnnt-error-container">

				';
				
				global $mnnt_login_error;
				global $mnnt_login_info;
				
				if(!empty($_COOKIE['mnnt-generic-error']) && $_COOKIE['mnnt-generic-error'] === '1') {
					
					$mnnt_login_error = __('An error occurred','main-entrance').', '.__('please retry','main-entrance');
					
				}
				
				if(!empty($_COOKIE['mnnt-generic-success']) && $_COOKIE['mnnt-generic-success'] === '1') {
					
					$mnnt_login_info = __('Operation completed successfully','main-entrance').', '.__('now you can Log In','main-entrance');
					
				}		
				
				if(!empty($mnnt_login_error)) {
					
					$mnnt_content_to_return .= '
						
					<div id="mnnt-error" class="mnnt-error">
					
					<p>
					
					';				
						
						
					$mnnt_content_to_return .= $mnnt_login_error;
						
					$mnnt_content_to_return .= '
		
					</p>
					
					</div>
					
					';				
						
				}
				
				$mnnt_content_to_return .= '

				</div>

				<div id="mnnt-info-container" class="mnnt-info-container">
				
				';

				
				if(!empty($mnnt_login_info)) {
					
					$mnnt_content_to_return .= '
						
					<div id="mnnt-info" class="mnnt-info">
					
					<p>
					
					';				
						
						
					$mnnt_content_to_return .= $mnnt_login_info;
						
					$mnnt_content_to_return .= '
		
					</p>
					
					</div>
					
					';				
						
				}
				
				if(!empty($_POST['mnnt-login-username'])) {
					
					$mnnt_posted_login_username = sanitize_text_field(strtolower($_POST['mnnt-login-username']));
					
				} else {
					
					$mnnt_posted_login_username = null;
					
				}
				
				$mnnt_content_to_return .= '
										
				</div>					

				<form method="post">
					
					<p>
						<label for="mnnt-login-username">'.__('Username or Email Address','main-entrance').'</label>
						<input type="text" name="mnnt-login-username" id="mnnt-login-username" class="mnnt-input mnnt-login-username" value="'.$mnnt_posted_login_username.'" autocorrect="off" autocapitalize="none">
						
					</p>
					
					<p>
						<label for="mnnt-login-password">'.__('Password','main-entrance').'</label>
						<input type="password" name="mnnt-login-password" id="mnnt-login-password" class="mnnt-input mnnt-login-password" autocorrect="off" autocapitalize="none">
						
					</p>
					
					<p>
						<button name="mnnt-login-button" id="mnnt-login-buton" class="button primary-button mnnt-button mnnt-login-button" value="'.wp_create_nonce('mnnt-login-nonce').'">'.__('Log In','main-entrance').'</button>
					</p>
					
					<p id="mnnt-login-recover" class="mnnt-login-recover"><a href="?mnnt-action=lostpassword">'.__('Lost Password','main-entrance').'</a></p>
					
				</form>
				
			</div>
					
		
		</div>
		
		';
				
		return $mnnt_content_to_return;
	
	}
	
} else {
	
	error_log('function: "mnnt_login_form" already exists');
	
}