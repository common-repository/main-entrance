<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//define option page parameters
if(!function_exists('mnnt_option_page_parameters')){
	
	function mnnt_option_page_parameters() {	
					
		add_menu_page(
			'Main Entrance',			//page title
			'Main Entrance',			//menu title
			'manage_options',			//capability
			'mnnt-setup',				//menu slug
			'mnnt_setup',				//function
			'dashicons-migrate'	 		//icon 
		);
		
	}
	
	//option page
	add_action('admin_menu', 'mnnt_option_page_parameters');
	
} else {
	
	error_log('function: "mnnt_option_page_parameters" already exists');
	
}


//setup page content
if(!function_exists('mnnt_setup')){
	
	function mnnt_setup() {

		//check capabilty
		if(!current_user_can('activate_plugins')) return;
		
		global $mnnt_options_array;
		$mnnt_saved_options = $mnnt_options_array;
	
		?>
		
		<div class="wrap">
			<h1 style="margin-bottom:15px; margin-top:5px;"><?php echo __('Main Entrance Setup','main-entrance'); ?></h1>

			<?php

			//initialize custom setting errors
			settings_errors('mnnt-message', true, false);
			settings_errors('mnnt-info', true, false);
			settings_errors('mnnt-error', true, false);
			
			global $wpdb;
			$mnnt_check_main_entrance_forms = $wpdb->get_results("SELECT post_title FROM $wpdb->posts WHERE post_status='publish' AND post_content LIKE '%[main-entrance-form]%'", ARRAY_A );
			$mnnt_count_main_entrance_forms = $wpdb->num_rows;

			if(!empty($mnnt_count_main_entrance_forms) && $mnnt_count_main_entrance_forms >= 1) {	

				?>
				<div class="mnnt-posts-and-pages-check">
					<p>
						<span class="dashicons dashicons-yes-alt mnnt-dashicon-info"></span>

						<?php printf (__('Good! "Main Entrance" shortcode %s was found into the following pages','main-entrance'),'<strong>[main-entrance-form]</strong>'); ?>:
					</p>	
						
					<ul>
					<?php
					foreach($mnnt_check_main_entrance_forms as $mnnt_check_main_entrance_form) {
						
						echo '<li><p><a href="'.$mnnt_check_main_entrance_form['post_title'].'" title="Main Entrance Form" alt="Main Entrance Form" target="_blank" class="button button-primary">'.$mnnt_check_main_entrance_form['post_title'].'</a></p></li>';
						
					}
					?>
					</ul>
					
				</div>
				<?php
							
			} else {
				
				?>
				<div class="mnnt-posts-and-pages-check">
					<p>
						<span class="dashicons dashicons-warning mnnt-dashicon-error"></span>
						<?php printf (__('Please, paste %s shortcode at least into one page or post or click the button below if you want to add a "Login" page','main-entrance'),'<strong>[main-entrance-form]</strong>'); ?>
					</p>
					<p>
						<form id="mnnt-build-login-page-form" method="post">
						<input type="submit" class="button button-primary" type="submit" name="mnnt-build-login-page" id="mnnt-build-login-page" value="<?php echo __('Build Login Page','main-entrance'); ?>">
						<input type="hidden" name="mnnt-build-login-page-nonce" value="<?php echo wp_create_nonce('mnnt-build-login-page-nonce'); ?>">
						</form>
					</p>
				</div>
				<?php
				
			}

			?>
			<form id="mnnt-settings-form" method="post" action="options.php" autocomplete="off">
			<?php
			
			//load form content from the involved page
			require_once plugin_dir_path(__FILE__).'mnnt_options_content.php';
			
			//can't find out if nonce is checked on register_setting, so let's check it "manually"
			$mnnt_options_nonce = wp_create_nonce('mnnt-options-nonce');
			echo '<input type="hidden" name="mnnt-options-nonce" value="'.$mnnt_options_nonce.'">';
			
			?>
			</form>
				
		</div>
		<?php
				
	}
	
} else {
	
	error_log('function: "mnnt_setup" already exists');
	
}

//include page with sanitize and save functions
if(!function_exists('mnnt_register_settings')){

	function mnnt_register_settings() {
		
		//check capabilty
		if(!current_user_can('activate_plugins')) return;

		if(!empty($_POST['mnnt-save-options'])) {
			require_once plugin_dir_path(__FILE__).'mnnt_options_save.php';
		}  
		
		elseif(!empty($_POST['mnnt-build-login-page'])) {
			require_once plugin_dir_path(__FILE__).'mnnt_options_build_login_page.php';
		} 
		
	}
	
	add_action('admin_menu', 'mnnt_register_settings');
	
} else {
	
	error_log('function: "mnnt_register_settings" already exists');
	
}