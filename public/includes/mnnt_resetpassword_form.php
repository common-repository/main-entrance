<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//define option page parameters
if(!function_exists('mnnt_resetpassword_form')){
	
	function mnnt_resetpassword_form($mnnt_form_to_diplay) {

		global $mnnt_options_array;
		$mnnt_content_to_return = null;
		
		if(is_user_logged_in()) {
			
			$mnnt_current_user_object = wp_get_current_user();
			$mnnt_current_name_with_space = ' '.esc_html($mnnt_current_user_object->display_name);
			
			$mnnt_content_to_return .= '
			
			<div id="mnnt-main-container" class="mnnt-main-container">
				
					<h2 id="mnnt-form-title" class="mnnt-form-title">'.__('Log Out','main-entrance').'</h2>
		
					<p>

						'.__('Hello','main-entrance').$mnnt_current_name_with_space.',<br>'.__('you are currently logged in','main-entrance').'!
						
					</p>
					
					<p>

						'.__('logout','main-entrance').'.
						
					</p>
					
					<p>
					
						<a href="'.wp_logout_url(site_url()).'" title="'.__('Log Out','main-entrance').'" alt="'.__('Log Out','main-entrance').'" class="mnnt-logout-link">'.__('Log Out','main-entrance').'</a>
						
					</p>	
			
			</div>
			
			';
					
			return $mnnt_content_to_return;			
			
		}
		
		global $mnnt_resetpassword_error;
		global $mnnt_resetpassword_info;
		
		$mnnt_resetpassword_email_requested = sanitize_email($_REQUEST['mnnt-email']);
		$mnnt_resetpassword_token_requested = sanitize_text_field($_REQUEST['mnnt-token']);
	
		if(empty($mnnt_resetpassword_error)) {
			
			$mnnt_resetpassword_info = __('Enter a new alphanumeric and at least six characters password for your account','main-entrance').' '.$mnnt_resetpassword_email_requested;
			
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
			
				<h2 id="mnnt-form-title" class="mnnt-form-title">'.__('Enter New Password','main-entrance').'</h2>
				
				<div id="mnnt-error-container" class="mnnt-error-container">

				';
								
				if(!empty($mnnt_resetpassword_error)) {
					
					$mnnt_content_to_return .= '
						
					<div id="mnnt-error" class="mnnt-error">
					
					<p>
					
					';				
						
						
					$mnnt_content_to_return .= $mnnt_resetpassword_error;
						
					$mnnt_content_to_return .= '
		
					</p>
					
					</div>
					
					';				
						
				}
				
				$mnnt_content_to_return .= '

				</div>

				<div id="mnnt-info-container" class="mnnt-info-container">
				
				';

				
				if(!empty($mnnt_resetpassword_info)) {
					
					$mnnt_content_to_return .= '
						
					<div id="mnnt-info" class="mnnt-info">
					
					<p>
					
					';				
						
						
					$mnnt_content_to_return .= $mnnt_resetpassword_info;
						
					$mnnt_content_to_return .= '
		
					</p>
					
					</div>
					
					';				
						
				}
				
				$mnnt_content_to_return .= '
										
				</div>					

				<form method="post" action="">
					
					<p>
						<label for="mnnt-resetpassword-password">'.__('Password').'</label>
						<input type="password" name="mnnt-resetpassword-password" id="mnnt-resetpassword-password" class="mnnt-input mnnt-resetpassword-password">
						<input type="hidden" name="mnnt-resetpassword-email" id="mnnt-resetpassword-email" class="mnnt-input mnnt-resetpassword-email" value="'.$mnnt_resetpassword_email_requested.'">
						<input type="hidden" name="mnnt-resetpassword-token" id="mnnt-resetpassword-token" class="mnnt-input mnnt-resetpassword-token" value="'.$mnnt_resetpassword_token_requested.'">
						
					</p>
					
					<p>
						<button name="mnnt-resetpassword-button" id="mnnt-resetpassword-buton" class="button primary-button mnnt-button mnnt-resetpassword-button" value="'.wp_create_nonce('mnnt-resetpassword-nonce').'">'.__('Save New Password','main-entrance').'</button>
					</p>
					
					<p id="mnnt-resetpassword-cancel" class="mnnt-resetpassword-cancel"><a href="?mnnt-action=login">'.__('Cancel','main-entrance').'</a></p>
					
				</form>
				
			</div>
					
		
		</div>
		
		';
				
		return $mnnt_content_to_return;
	
	}
	
} else {
	
	error_log('function: "mnnt_resetpassword_form" already exists');
	
}