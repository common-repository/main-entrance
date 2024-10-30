<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//define option page parameters
if(!function_exists('mnnt_lostpassword_form')){
	
	function mnnt_lostpassword_form($mnnt_form_to_diplay) {

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
			
				<h2 id="mnnt-form-title" class="mnnt-form-title">'.__('Lost Password','main-entrance').'</h2>
				
				<div id="mnnt-error-container" class="mnnt-error-container">

				';
				
				global $mnnt_lostpassword_error;
				global $mnnt_lostpassword_info;
				
				if(!empty($mnnt_lostpassword_error)) {
					
					$mnnt_content_to_return .= '
						
					<div id="mnnt-error" class="mnnt-error">
					
					<p>
					
					';				
						
						
					$mnnt_content_to_return .= $mnnt_lostpassword_error;
						
					$mnnt_content_to_return .= '
		
					</p>
					
					</div>
					
					';				
						
				}
				
				$mnnt_content_to_return .= '

				</div>

				<div id="mnnt-info-container" class="mnnt-info-container">
				
				';

				
				if(!empty($mnnt_lostpassword_info)) {
					
					$mnnt_content_to_return .= '
						
					<div id="mnnt-info" class="mnnt-info">
					
					<p>
					
					';				
						
						
					$mnnt_content_to_return .= $mnnt_lostpassword_info;
						
					$mnnt_content_to_return .= '
		
					</p>
					
					</div>
					
					';				
						
				}
				
				$mnnt_content_to_return .= '
										
				</div>					

				<form method="post">
					
					<p>
						<label for="mnnt-lostpassword-email">'.__('Email').'</label>
						<input type="email" name="mnnt-lostpassword-email" id="mnnt-lostpassword-email" class="mnnt-input mnnt-lostpassword-email" autocorrect="off" autocapitalize="none">
						
					</p>
					
					<p>
						<button name="mnnt-lostpassword-button" id="mnnt-lostpassword-buton" class="button primary-button mnnt-button mnnt-lostpassword-button" value="'.wp_create_nonce('mnnt-lostpassword-nonce').'">'.__('Get New Password','main-entrance').'</button>
					</p>
					
					<p id="mnnt-lostpassword-cancel" class="mnnt-lostpassword-cancel"><a href="?mnnt-action=login">'.__('Cancel','main-entrance').'</a></p>
					
				</form>
				
			</div>
					
		
		</div>
		
		';
				
		return $mnnt_content_to_return;
	
	}
	
} else {
	
	error_log('function: "mnnt_lostpassword_form" already exists');
	
}