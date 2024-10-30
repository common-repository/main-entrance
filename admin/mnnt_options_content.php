<?php
/**
 * @var array $mnnt_saved_options
 */


//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

add_settings_section(
'mnnt_registration_section',
__('Registration and Capabilities','main-entrance'),
'mnnt_registration_section_comment',
'mnnt-section'
);

if(!function_exists('mnnt_registration_section_comment')) {
	
	function mnnt_registration_section_comment(){
		echo '<span class="mnnt-section-comment">'.__('Enable registration through "Main Entrance" form and define what capabilities have to be assigned to "Main Entrance User" role, which is the default role for everyone who registers through "Main Entrance" form', 'main-entrance').'</span>';
	}
	
} else {
	
	error_log('function: "mnnt_registration_section_comment" already exists');
	
}

add_settings_field(
'mnnt-allow-registration',
__('Allow registration','main-entrance'),
'mnnt_allow_registration',
'mnnt-section',
'mnnt_registration_section',
array('mnnt_saved_options' => $mnnt_saved_options, 'class' => 'mnnt-allow-registration')
);

if(!function_exists('mnnt_allow_registration')) {

	function mnnt_allow_registration($mnnt_arguments){
		
		if(!empty($mnnt_arguments['mnnt_saved_options']['allow_registration'])) {
			
			$mnnt_saved_option = $mnnt_arguments['mnnt_saved_options']['allow_registration'];
			
		} else {
			
			$mnnt_saved_option = null;
			
		}
		
		if($mnnt_saved_option === '1') {
			
			$mnnt_allow_registration_checked = 'checked';
			
		} else {
			
			$mnnt_allow_registration_checked = null;
			
		}
		
		?>
		<input type="checkbox" name="_mnnt_options[allow_registration]" class="mnnt-switch" id="mnnt-allow-registration" value="1" <?php echo $mnnt_allow_registration_checked; ?> />
		<label for="mnnt-allow-registration">&nbsp;</label>
		<p><small><?php echo __('If switched on, "Main Entrance User" form will be displayed and registration will be allowed through it, even if WordPress registration is switched off','main-entrance'); ?></small></p>
		<?php
		
	}

} else {
	
	error_log('function: "mnnt_allow_registration" already exists');
	
}

add_settings_field(
'mnnt-default-acceptance-text',
__('Default acceptance text','main-entrance'),
'mnnt_default_acceptance_text',
'mnnt-section',
'mnnt_registration_section',
array('mnnt_saved_options' => $mnnt_saved_options, 'class' => 'mnnt-default-acceptance-text')
);

if(!function_exists('mnnt_default_acceptance_text')) {

	function mnnt_default_acceptance_text($mnnt_arguments){
		
		if(!empty($mnnt_arguments['mnnt_saved_options']['default_acceptance_text'])) {
			
			$mnnt_saved_option = $mnnt_arguments['mnnt_saved_options']['default_acceptance_text'];
			
		} else {
			
			$mnnt_saved_option = __('I consent to the processing of my data for the purposes described in','main-entrance');
			
		}
		
		?>
		<textarea name="_mnnt_options[default_acceptance_text]" class="mnnt-switch" id="mnnt-default-acceptance-text" value="1" cols="40" rows="2"><?php echo $mnnt_saved_option; ?></textarea>
		<label for="mnnt-default-acceptance-text">&nbsp;</label>
		<p><small><?php echo __('Define your default privacy acceptance text, that has to be accepted in order to complete registration','main-entrance'); ?></small></p>
		<?php
		
	}

} else {
	
	error_log('function: "mnnt_default_acceptance_text" already exists');
	
}

add_settings_field(
'mnnt-default-acceptance-doc',  
__('Deafault GDPR and privacy policies information','main-entrance'),
'mnnt_default_acceptance_doc_id',
'mnnt-section',
'mnnt_registration_section',
array('mnnt_saved_options' => $mnnt_saved_options, 'class' => 'mnnt-default-acceptance-doc')
);

if(!function_exists('mnnt_default_acceptance_doc_id')) {

	function mnnt_default_acceptance_doc_id($mnnt_arguments){
					
		if(!empty($mnnt_arguments['mnnt_saved_options']['default_acceptance_doc_id'])) {
			
			$mnnt_saved_option = $mnnt_arguments['mnnt_saved_options']['default_acceptance_doc_id'];
			
		} else {
			
			$mnnt_saved_option = null;
			
		}	
		
		?>
		
		<select name="_mnnt_options[default_acceptance_doc_id]" id="mnnt-default-acceptance-doc">
			<option value="0" selected="selected"><?php echo __('Please, select a PDF file','main-entrance'); ?></option>
		
		<?php
		global $post; 
		$mnnt_get_pdf_attachments_args = array(
			'post_type'      => 'attachment',
			'post_mime_type' => 'application/pdf',
			'numberposts'	 =>	-1
		);

		$mnnt_get_pdf_attachments = get_posts($mnnt_get_pdf_attachments_args);

		foreach ($mnnt_get_pdf_attachments as $mnnt_pdf_attachment) {
		   $mnnt_pdf_attachment_id = $mnnt_pdf_attachment->ID;
		   $mnnt_pdf_attachment_title = $mnnt_pdf_attachment->post_title;
			
			if((int)$mnnt_pdf_attachment_id === (int)$mnnt_saved_option) {
			
				echo '<option value="'.$mnnt_pdf_attachment_id.'" selected="selected">'.$mnnt_pdf_attachment_title.'</option>';
				
			} else {
				
				echo '<option value="'.$mnnt_pdf_attachment_id.'">'.$mnnt_pdf_attachment_title.'</option>';
				
			}

		}
		?>
		</select>		
		<p><small><?php echo __('Select the PDF document containing GDPR and privacy policies of the default acceptance. It will be sent in attachement to the email that confirms to the newly registered user the success of the registration procedure','main-entrance'); ?></small></p>
		
		<?php
	}

} else {
	
	error_log('function: "mnnt_default_acceptance_doc_id" already exists');
	
}

add_settings_field(
'mnnt-secondary-acceptance',
__('Secondary acceptance','main-entrance'),
'mnnt_secondary_acceptance',
'mnnt-section',
'mnnt_registration_section',
array('mnnt_saved_options' => $mnnt_saved_options, 'class' => 'mnnt-secondary-acceptance')
);

if(!function_exists('mnnt_secondary_acceptance')) {

	function mnnt_secondary_acceptance($mnnt_arguments){
		
		if(!empty($mnnt_arguments['mnnt_saved_options']['secondary_acceptance'])) {
			
			$mnnt_saved_option = $mnnt_arguments['mnnt_saved_options']['secondary_acceptance'];
			
		} else {
			
			$mnnt_saved_option = null;
			
		}
		
		if($mnnt_saved_option === '1') {
			
			$mnnt_secondary_acceptance_checked = 'checked';
			
		} else {
			
			$mnnt_secondary_acceptance_checked = __('I consent to the processing of my data for the purposes described in','main-entrance');
			
		}
		
		?>
		<input type="checkbox" name="_mnnt_options[secondary_acceptance]" class="mnnt-switch" id="mnnt-secondary-acceptance" value="1" <?php echo $mnnt_secondary_acceptance_checked; ?> />
		<label for="mnnt-secondary-acceptance">&nbsp;</label>
		<p><small><?php echo __('If switched on, a optional secondary acceptance will be shown','main-entrance'); ?></small></p>
		<?php
		
	}

} else {
	
	error_log('function: "mnnt_secondary_acceptance" already exists');
	
}

add_settings_field(
'mnnt-secondary-acceptance-text',
__('Secondary acceptance text','main-entrance'),
'mnnt_secondary_acceptance_text',
'mnnt-section',
'mnnt_registration_section',
array('mnnt_saved_options' => $mnnt_saved_options, 'class' => 'mnnt-secondary-acceptance-text')
);

if(!function_exists('mnnt_secondary_acceptance_text')) {

	function mnnt_secondary_acceptance_text($mnnt_arguments){
		
		if(!empty($mnnt_arguments['mnnt_saved_options']['secondary_acceptance_text'])) {
			
			$mnnt_saved_option = $mnnt_arguments['mnnt_saved_options']['secondary_acceptance_text'];
			
		} else {
			
			$mnnt_saved_option = null;
			
		}
		
		?>
		<textarea name="_mnnt_options[secondary_acceptance_text]" class="mnnt-switch" id="mnnt-secondary-acceptance-text" value="1" cols="40" rows="2"><?php echo $mnnt_saved_option; ?></textarea>
		<label for="mnnt-secondary-acceptance-text">&nbsp;</label>
		<p><small><?php echo __('Define your secondary privacy acceptance text, that can be optionally accepted during registration','main-entrance'); ?></small></p>
		<?php
		
	}

} else {
	
	error_log('function: "mnnt_secondary_acceptance_text" already exists');
	
}


add_settings_field(
'mnnt-secondary-acceptance-doc',  
__('Secondary GDPR and privacy policies information','main-entrance'),
'mnnt_secondary_acceptance_doc_id',
'mnnt-section',
'mnnt_registration_section',
array('mnnt_saved_options' => $mnnt_saved_options, 'class' => 'mnnt-secondary-acceptance-doc')
);

if(!function_exists('mnnt_secondary_acceptance_doc_id')) {

	function mnnt_secondary_acceptance_doc_id($mnnt_arguments){
					
		if(!empty($mnnt_arguments['mnnt_saved_options']['secondary_acceptance_doc_id'])) {
			
			$mnnt_saved_option = $mnnt_arguments['mnnt_saved_options']['secondary_acceptance_doc_id'];
			
		} else {
			
			$mnnt_saved_option = null;
			
		}	
		
		?>
		
		<select name="_mnnt_options[secondary_acceptance_doc_id]" id="mnnt-secondary-acceptance-doc">
			<option value="0" selected="selected"><?php echo __('Please, select a PDF file','main-entrance'); ?></option>
		
		<?php
		global $post; 
		$mnnt_get_pdf_attachments_args = array(
			'post_type'      => 'attachment',
			'post_mime_type' => 'application/pdf',
			'numberposts'	 =>	-1
		);

		$mnnt_get_pdf_attachments = get_posts($mnnt_get_pdf_attachments_args);

		foreach ($mnnt_get_pdf_attachments as $mnnt_pdf_attachment) {
		   $mnnt_pdf_attachment_id = $mnnt_pdf_attachment->ID;
		   $mnnt_pdf_attachment_title = $mnnt_pdf_attachment->post_title;
			
			if((int)$mnnt_pdf_attachment_id === (int)$mnnt_saved_option) {
			
				echo '<option value="'.$mnnt_pdf_attachment_id.'" selected="selected">'.$mnnt_pdf_attachment_title.'</option>';
				
			} else {
				
				echo '<option value="'.$mnnt_pdf_attachment_id.'">'.$mnnt_pdf_attachment_title.'</option>';
				
			}

		}
		?>
		</select>		
		<p><small><?php echo __('Select the PDF document containing GDPR and privacy policies of the secondary acceptance. If accepted, it will be sent in attachement to the email that confirms to the newly registered user the success of the registration procedure','main-entrance'); ?></small></p>
		
		<?php
	}

} else {
	
	error_log('function: "mnnt_secondary_acceptance_doc_id" already exists');
	
}

add_settings_field(
'mnnt-mnnt-role-slug',  
__('Define capabilities','main-entrance'),
'mnnt_role_slug',
'mnnt-section',
'mnnt_registration_section',
array('mnnt_saved_options' => $mnnt_saved_options, 'class' => 'mnnt-role-slug')
);

if(!function_exists('mnnt_role_slug')) {

	function mnnt_role_slug($mnnt_arguments){
					
		if(!empty($mnnt_arguments['mnnt_saved_options']['role_slug'])) {
			
			$mnnt_saved_option = $mnnt_arguments['mnnt_saved_options']['role_slug'];
			
		} else {
			
			if(!empty(get_option('default_role')) && get_option('default_role') !== 'administrator') {
				
				$mnnt_saved_option = get_option('default_role');
				
			} else {
				
				$mnnt_saved_option = 'subscriber';
				
			}
			
		}		
		
		?>
		<select name="_mnnt_options[role_slug]" id="mnnt-role-slug">
		<?php
		global $wp_roles;
		foreach ($wp_roles->roles as $mnnt_wp_role_slug => $mnnt_wp_role_value) {

			if(!in_array($mnnt_wp_role_slug, ['main-entrance-user'])){
				
				if($mnnt_wp_role_slug === $mnnt_saved_option) {
				
					echo '<option value="'.$mnnt_wp_role_slug.'" selected="selected">'.__($mnnt_wp_role_value['name'],'main-entrance').'</option>';
					
				} else {
					
					echo '<option value="'.$mnnt_wp_role_slug.'">'.__($mnnt_wp_role_value['name'],'main-entrance').'</option>';
					
				}
				
			}
		}
		?>
		</select>
		<p><small><?php echo __('Here you can define which WordPress role, in terms of capabilites, should be assigned to "Main Entrance User" role, which is the default role for all the users that register throught "Main Entrance" registration form','main-entrance'); ?></small></p>
		
		<?php
	}

} else {
	
	error_log('function: "mnnt_role_slug" already exists');
	
}

add_settings_field(
'mnnt-auto-login',
__('Auto login after registration','main-entrance'),
'mnnt_auto_login',
'mnnt-section',
'mnnt_registration_section',
array('mnnt_saved_options' => $mnnt_saved_options, 'class' => 'mnnt-auto-login')
);

if(!function_exists('mnnt_auto_login')) {

	function mnnt_auto_login($mnnt_arguments){
		
		if(!empty($mnnt_arguments['mnnt_saved_options']['auto_login'])) {
			
			$mnnt_saved_option = $mnnt_arguments['mnnt_saved_options']['auto_login'];
			
		} else {
			
			$mnnt_saved_option = null;
			
		}
		
		if($mnnt_saved_option === '1') {
			
			$mnnt_auto_login_checked = 'checked';
			
		} else {
			
			$mnnt_auto_login_checked = null;
			
		}
		
		?>
		<input type="checkbox" name="_mnnt_options[auto_login]" class="mnnt-switch" id="mnnt-auto-login" value="1" <?php echo $mnnt_auto_login_checked; ?> />
		<label for="mnnt-auto-login">&nbsp;</label>
		<p><small><?php echo __('If switched on, at the end of the registration procedure throught "Main Entrance" form the user will be automatically logged in','main-entrance'); ?></small></p>
		<?php
		
	}

} else {
	
	error_log('function: "mnnt_auto_login" already exists');
	
}

add_settings_field(
'mnnt-redirect-after-registration',  
__('Redirect after registration','main-entrance'),
'mnnt_redirect_after_registration',
'mnnt-section',
'mnnt_registration_section',
array('mnnt_saved_options' => $mnnt_saved_options, 'class' => 'mnnt-redirect-after-registration')
);

if(!function_exists('mnnt_redirect_after_registration')) {

	function mnnt_redirect_after_registration($mnnt_arguments){
					
		if(!empty($mnnt_arguments['mnnt_saved_options']['redirect_after_registration'])) {
			
			$mnnt_saved_option = $mnnt_arguments['mnnt_saved_options']['redirect_after_registration'];
			
		} else {
			
			$mnnt_saved_option = null;
			
		}	
	
		$mnnt_registered_post_types_args = array(
		
			'exclude_from_search' => false,
			'public'   => true,
			'_builtin' => false,
			'public' => true,
			'publicly_queryable' => true
			
		);
			
		$mnnt_registered_post_types = get_post_types($mnnt_registered_post_types_args);
	
		$mnnt_post_types_to_search = array('post','page');
		
		foreach($mnnt_registered_post_types as $mnnt_registered_post_type){
			
			$mnnt_post_types_to_search[] = $mnnt_registered_post_type;
			
		}
		
		$mnnt_home_page_id = get_option('page_on_front');
		
		echo '<select name="_mnnt_options[redirect_after_registration]" id="mnnt-redirect-after-registration">';
		
		//if restricted media is installed
		if(
			defined('RSMD_BASE_PATH')
			|| defined('NFPRCT_BASE_PATH')
			
		){
			
			echo '<option value="" selected>'.__('Bring back to the origin page','main-entrance').'</option>';
			
		}
		
		if(!empty($mnnt_home_page_id)) {
			
			if((int)$mnnt_home_page_id === (int)$mnnt_saved_option) {
			
				echo '<option value="'.$mnnt_home_page_id.'" selected>Homepage (id: '.$mnnt_home_page_id.')</option>';
				
			} else {
				
				echo '<option value="'.$mnnt_home_page_id.'">Homepage (id: '.$mnnt_home_page_id.')</option>';
				
			}
			
		}
		
		$mnnt_pages_query_args = array(
		
			'post_type' => $mnnt_post_types_to_search,
			'post_status' => array('publish'),
			'post__not_in' => array($mnnt_home_page_id),
			'orderby' => 'post_title',
			'order' => 'asc',
			'posts_per_page' => -1,	
						
		);
		 
		$mnnt_pages_query = new WP_Query($mnnt_pages_query_args);
		 
		if($mnnt_pages_query->have_posts()){

			while($mnnt_pages_query->have_posts()) {
				
				$mnnt_pages_query->the_post();
				
				$mnnt_page_id = get_the_ID();
				$mnnt_page_title = get_the_title();
				
				if((int)$mnnt_page_id === (int)$mnnt_saved_option) {
				
					echo '<option value="'.get_the_ID().'" selected>'.get_the_title().' (id: '.get_the_ID().')</option>';
					
				} else {
					
					echo '<option value="'.get_the_ID().'">'.get_the_title().' (id: '.get_the_ID().')</option>';
				}
				
			}
			
		} 
		
		wp_reset_postdata();
						
		?>
		
		</select>
		
		<p><small><?php echo __('Select the page you want to redirect a user to after registration through "Main Entrance" form','main-entrance'); ?></small></p>
		
		<?php
		
	}

} else {
	
	error_log('function: "mnnt_redirect_after_registration" already exists');
	
}

add_settings_field(
'mnnt-registration-additional-fields',  
__('Registration form additional fields','main-entrance'),
'mnnt_registration_additional_fields',
'mnnt-section',
'mnnt_registration_section',
array('mnnt_saved_options' => $mnnt_saved_options, 'class' => 'mnnt-registration-additional-fields')
);

if(!function_exists('mnnt_registration_additional_fields')) {

	function mnnt_registration_additional_fields($mnnt_arguments){

		$mnnt_name_field_checked = null;
		$mnnt_name_field_mandatory_checked = null;
					
		if(!empty($mnnt_arguments['mnnt_saved_options']['name_field']) && $mnnt_arguments['mnnt_saved_options']['name_field'] === '1') {
			
			$mnnt_name_field_checked = 'checked';
			
			if(!empty($mnnt_arguments['mnnt_saved_options']['name_field_mandatory']) && $mnnt_arguments['mnnt_saved_options']['name_field_mandatory'] === '1') {
				
				$mnnt_name_field_mandatory_checked = 'checked';
				
			}
			
		}

		?>
		<div style="margin-bottom:20px">
		<p>
		<input type="checkbox" name="_mnnt_options[name_field]" class="mnnt-switch" id="mnnt-name-field" value="1" <?php echo $mnnt_name_field_checked; ?> />
		<label for="mnnt-name-field">&nbsp;</label><span style="margin-left: 20px"><?php echo __('Name','main-entrance');?></span>
		</p><p>
		<input type="checkbox" name="_mnnt_options[name_field_mandatory]" class="mnnt-switch" id="mnnt-name-field-mandatory" value="1" <?php echo $mnnt_name_field_mandatory_checked; ?> />
		<label for="mnnt-name-field-mandatory">&nbsp;</label><span style="margin-left: 20px"><?php printf(__('%sName%s field is mandatory', 'main-entrance' ), '<em>', '</em>' );?></span>
		</p>
		</div>
		<?php
		
		$mnnt_surname_field_checked = null;
		$mnnt_surname_field_mandatory_checked = null;
					
		if(!empty($mnnt_arguments['mnnt_saved_options']['surname_field']) && $mnnt_arguments['mnnt_saved_options']['surname_field'] === '1') {
			
			$mnnt_surname_field_checked = 'checked';
			
			if(!empty($mnnt_arguments['mnnt_saved_options']['surname_field_mandatory']) && $mnnt_arguments['mnnt_saved_options']['surname_field_mandatory'] === '1') {
				
				$mnnt_surname_field_mandatory_checked = 'checked';
				
			}
			
		}

		?>
		<div style="margin-bottom:20px">
		<p>
		<input type="checkbox" name="_mnnt_options[surname_field]" class="mnnt-switch" id="mnnt-surname-field" value="1" <?php echo $mnnt_surname_field_checked; ?> />
		<label for="mnnt-surname-field">&nbsp;</label><span style="margin-left: 20px"><?php echo __('Surname','main-entrance');?></span>
		</p><p>
		<input type="checkbox" name="_mnnt_options[surname_field_mandatory]" class="mnnt-switch" id="mnnt-surname-field-mandatory" value="1" <?php echo $mnnt_surname_field_mandatory_checked; ?> />
		<label for="mnnt-surname-field-mandatory">&nbsp;</label><span style="margin-left: 20px"><?php printf(__('%sSurname%s field is mandatory', 'main-entrance' ), '<em>', '</em>' );?></span>
		</p>
		</div>
		<?php
		
		$mnnt_genre_field_checked = null;
		$mnnt_genre_field_mandatory_checked = null;
					
		if(!empty($mnnt_arguments['mnnt_saved_options']['genre_field']) && $mnnt_arguments['mnnt_saved_options']['genre_field'] === '1') {
			
			$mnnt_genre_field_checked = 'checked';
			
			if(!empty($mnnt_arguments['mnnt_saved_options']['genre_field_mandatory']) && $mnnt_arguments['mnnt_saved_options']['genre_field_mandatory'] === '1') {
				
				$mnnt_genre_field_mandatory_checked = 'checked';
				
			}
			
		}

		?>
		<div style="margin-bottom:20px">
		<p>
		<input type="checkbox" name="_mnnt_options[genre_field]" class="mnnt-switch" id="mnnt-genre-field" value="1" <?php echo $mnnt_genre_field_checked; ?> />
		<label for="mnnt-genre-field">&nbsp;</label><span style="margin-left: 20px"><?php echo __('Genre','main-entrance');?></span>
		</p><p>
		<input type="checkbox" name="_mnnt_options[genre_field_mandatory]" class="mnnt-switch" id="mnnt-genre-field-mandatory" value="1" <?php echo $mnnt_genre_field_mandatory_checked; ?> />
		<label for="mnnt-genre-field-mandatory">&nbsp;</label><span style="margin-left: 20px"><?php printf(__('%sGenre%s field is mandatory', 'main-entrance' ), '<em>', '</em>' );?></span>
		</p>
		</div>
		<?php

		$mnnt_date_of_birth_field_checked = null;
		$mnnt_date_of_birth_field_mandatory_checked = null;
					
		if(!empty($mnnt_arguments['mnnt_saved_options']['date_of_birth_field']) && $mnnt_arguments['mnnt_saved_options']['date_of_birth_field'] === '1') {
			
			$mnnt_date_of_birth_field_checked = 'checked';
			
			if(!empty($mnnt_arguments['mnnt_saved_options']['date_of_birth_field_mandatory']) && $mnnt_arguments['mnnt_saved_options']['date_of_birth_field_mandatory'] === '1') {
				
				$mnnt_date_of_birth_field_mandatory_checked = 'checked';
				
			}
			
		}

		?>
		<div style="margin-bottom:20px">
		<p>
		<input type="checkbox" name="_mnnt_options[date_of_birth_field]" class="mnnt-switch" id="mnnt-date-of-birth-field" value="1" <?php echo $mnnt_date_of_birth_field_checked; ?> />
		<label for="mnnt-date-of-birth-field">&nbsp;</label><span style="margin-left: 20px"><?php echo __('Date of birth','main-entrance');?></span>
		</p><p>
		<input type="checkbox" name="_mnnt_options[date_of_birth_field_mandatory]" class="mnnt-switch" id="mnnt-date-of-birth-field-mandatory" value="1" <?php echo $mnnt_date_of_birth_field_mandatory_checked; ?> />
		<label for="mnnt-date-of-birth-field-mandatory">&nbsp;</label><span style="margin-left: 20px"><?php printf(__('%sDate of Birth%s field is mandatory', 'main-entrance' ), '<em>', '</em>' );?></span>
		</p>
		</div>
		<?php	
				
		$mnnt_company_name_field_checked = null;
		$mnnt_company_name_field_mandatory_checked = null;
					
		if(!empty($mnnt_arguments['mnnt_saved_options']['company_name_field']) && $mnnt_arguments['mnnt_saved_options']['company_name_field'] === '1') {
			
			$mnnt_company_name_field_checked = 'checked';
			
			if(!empty($mnnt_arguments['mnnt_saved_options']['company_name_field_mandatory']) && $mnnt_arguments['mnnt_saved_options']['company_name_field_mandatory'] === '1') {
				
				$mnnt_company_name_field_mandatory_checked = 'checked';
				
			}
			
		}

		?>
		<div style="margin-bottom:20px">
		<p>
		<input type="checkbox" name="_mnnt_options[company_name_field]" class="mnnt-switch" id="mnnt-company-name-field" value="1" <?php echo $mnnt_company_name_field_checked; ?> />
		<label for="mnnt-company-name-field">&nbsp;</label><span style="margin-left: 20px"><?php echo __('Company','main-entrance');?></span>
		</p><p>
		<input type="checkbox" name="_mnnt_options[company_name_field_mandatory]" class="mnnt-switch" id="mnnt-company-name-field-mandatory" value="1" <?php echo $mnnt_company_name_field_mandatory_checked; ?> />
		<label for="mnnt-company-name-field-mandatory">&nbsp;</label><span style="margin-left: 20px"><?php printf(__('%sCompany%s field is mandatory', 'main-entrance' ), '<em>', '</em>' );?></span>
		</p>
		</div>
		<?php			

		$mnnt_phone_number_field_checked = null;
		$mnnt_phone_number_field_mandatory_checked = null;
					
		if(!empty($mnnt_arguments['mnnt_saved_options']['phone_number_field']) && $mnnt_arguments['mnnt_saved_options']['phone_number_field'] === '1') {
			
			$mnnt_phone_number_field_checked = 'checked';
			
			if(!empty($mnnt_arguments['mnnt_saved_options']['phone_number_field_mandatory']) && $mnnt_arguments['mnnt_saved_options']['phone_number_field_mandatory'] === '1') {
				
				$mnnt_phone_number_field_mandatory_checked = 'checked';
				
			}
			
		}

		?>
		<div style="margin-bottom:20px">
		<p>
		<input type="checkbox" name="_mnnt_options[phone_number_field]" class="mnnt-switch" id="mnnt-phone-number-field" value="1" <?php echo $mnnt_phone_number_field_checked; ?> />
		<label for="mnnt-phone-number-field">&nbsp;</label><span style="margin-left: 20px"><?php echo __('Phone Number','main-entrance');?></span>
		</p><p>
		<input type="checkbox" name="_mnnt_options[phone_number_field_mandatory]" class="mnnt-switch" id="mnnt-phone-number-field-mandatory" value="1" <?php echo $mnnt_phone_number_field_mandatory_checked; ?> />
		<label for="mnnt-phone-number-field-mandatory">&nbsp;</label><span style="margin-left: 20px"><?php printf(__('%sPhone Number%s field is mandatory', 'main-entrance' ), '<em>', '</em>' );?></span>
		</p>
		</div>
		<?php	

		$mnnt_state_field_checked = null;
		$mnnt_state_field_mandatory_checked = null;
					
		if(!empty($mnnt_arguments['mnnt_saved_options']['state_field']) && $mnnt_arguments['mnnt_saved_options']['state_field'] === '1') {
			
			$mnnt_state_field_checked = 'checked';
			
			if(!empty($mnnt_arguments['mnnt_saved_options']['state_field_mandatory']) && $mnnt_arguments['mnnt_saved_options']['state_field_mandatory'] === '1') {
				
				$mnnt_state_field_mandatory_checked = 'checked';
				
			}
			
		}

		?>
		<div style="margin-bottom:20px">
		<p>
		<input type="checkbox" name="_mnnt_options[state_field]" class="mnnt-switch" id="mnnt-state-field" value="1" <?php echo $mnnt_state_field_checked; ?> />
		<label for="mnnt-state-field">&nbsp;</label><span style="margin-left: 20px"><?php echo __('State','main-entrance');?></span>
		</p><p>
		<input type="checkbox" name="_mnnt_options[state_field_mandatory]" class="mnnt-switch" id="mnnt-state-field-mandatory" value="1" <?php echo $mnnt_state_field_mandatory_checked; ?> />
		<label for="mnnt-state-field-mandatory">&nbsp;</label><span style="margin-left: 20px"><?php printf(__('%sState%s field is mandatory', 'main-entrance' ), '<em>', '</em>' );?></span>
		</p>
		</div>
        <?php

		$mnnt_country_field_checked = null;
		$mnnt_country_field_mandatory_checked = null;
					
		if(!empty($mnnt_arguments['mnnt_saved_options']['country_field']) && $mnnt_arguments['mnnt_saved_options']['country_field'] === '1') {
			
			$mnnt_country_field_checked = 'checked';
			
			if(!empty($mnnt_arguments['mnnt_saved_options']['country_field_mandatory']) && $mnnt_arguments['mnnt_saved_options']['country_field_mandatory'] === '1') {
				
				$mnnt_country_field_mandatory_checked = 'checked';
				
			}
			
		}

		?>
		<div style="margin-bottom:20px">
		<p>
		<input type="checkbox" name="_mnnt_options[country_field]" class="mnnt-switch" id="mnnt-country-field" value="1" <?php echo $mnnt_country_field_checked; ?> />
		<label for="mnnt-country-field">&nbsp;</label><span style="margin-left: 20px"><?php echo __('Country','main-entrance');?></span>
		</p><p>
		<input type="checkbox" name="_mnnt_options[country_field_mandatory]" class="mnnt-switch" id="mnnt-country-field-mandatory" value="1" <?php echo $mnnt_country_field_mandatory_checked; ?> />
		<label for="mnnt-country-field-mandatory">&nbsp;</label><span style="margin-left: 20px"><?php printf(__('%sCountry%s field is mandatory', 'main-entrance' ), '<em>', '</em>' );?></span>
		</p>
		</div>
        <?php
		
		$mnnt_address_field_checked = null;
		$mnnt_address_field_mandatory_checked = null;
					
		if(!empty($mnnt_arguments['mnnt_saved_options']['address_field']) && $mnnt_arguments['mnnt_saved_options']['address_field'] === '1') {
			
			$mnnt_address_field_checked = 'checked';
			
			if(!empty($mnnt_arguments['mnnt_saved_options']['address_field_mandatory']) && $mnnt_arguments['mnnt_saved_options']['address_field_mandatory'] === '1') {
				
				$mnnt_address_field_mandatory_checked = 'checked';
				
			}
			
		}

		?>
		<div>
		<p>
		<input type="checkbox" name="_mnnt_options[address_field]" class="mnnt-switch" id="mnnt-address-field" value="1" <?php echo $mnnt_address_field_checked; ?> />
		<label for="mnnt-address-field">&nbsp;</label><span style="margin-left: 20px"><?php echo __('Address','main-entrance');?></span>
		</p><p>
		<input type="checkbox" name="_mnnt_options[address_field_mandatory]" class="mnnt-switch" id="mnnt-address-field-mandatory" value="1" <?php echo $mnnt_address_field_mandatory_checked; ?> />
		<label for="mnnt-address-field-mandatory">&nbsp;</label><span style="margin-left: 20px"><?php printf(__('%sAddress%s field is mandatory', 'main-entrance' ), '<em>', '</em>' );?></span>
		</p>
		</div>
        <?php

        //hook into this action to add more custom fields
        do_action('mnnt_registration_additional_fields_settings', $mnnt_arguments['mnnt_saved_options']);

        ?>
		<p><small><?php echo __('The above selected optional fields will be displayed into registration form, together with email field and to password field; the ones set as mandatory are required to complete the registration process','main-entrance'); ?></small></p>
		<?php

	}

} else {
	
	error_log('function: "mnnt_registration_additional_fields" already exists');
	
}

add_settings_field(
'mnnt-notification-address',  
__('Registration notification address','main-entrance'),
'mnnt_notification_address',
'mnnt-section',
'mnnt_registration_section',
array('mnnt_saved_options' => $mnnt_saved_options, 'class' => 'mnnt-notification-address')
);

if(!function_exists('mnnt_notification_address')) {

	function mnnt_notification_address($mnnt_arguments){
		
		if(!empty($mnnt_arguments['mnnt_saved_options']['notification_address'])) {
			
			$mnnt_saved_option = sanitize_text_field($mnnt_arguments['mnnt_saved_options']['notification_address']);
			
		} else {
			
			$mnnt_saved_option = sanitize_text_field(get_bloginfo('admin_email'));
			
		}
	
		?>
		<input type="text" size="45" name="_mnnt_options[notification_address]" id="mnnt-notification-address" value="<?php echo $mnnt_saved_option; ?>">
		<p><small><?php echo __('Define where registration notifications has to be sent','main-entrance'); ?> (<?php echo __('a single email address or a comma separated list of email addresses','main-entrance'); ?>)</small></p>
		<?php
		
	}

} else {
	
	error_log('function: "mnnt_notification_address" already exists');
	
}


add_settings_section(
'mnnt_icons_section',
__('Add Icon to Nav Menu','main-entrance'),
'mnnt_icons_section_comment',
'mnnt-section'
);

if(!function_exists('mnnt_icons_section_comment')) {
	
	function mnnt_icons_section_comment(){
		echo '<span class="mnnt-section-comment">'.__('Add an user icon just after the main navigation menu to reach easily the login/logout page and define wich page with the "Main Entrace" shortcode should be linked', 'main-entrance').'</span>';
	}
	
} else {
	
	error_log('function: "mnnt_icons_section_comment" already exists');
	
}

add_settings_field(
'mnnt-icons-nav-bar',
__('Show icon into main navigation menu','main-entrance'),
'mnnt_icons_nav_bar',
'mnnt-section',
'mnnt_icons_section',
array('mnnt_saved_options' => $mnnt_saved_options, 'class' => 'mnnt-icons-nav-bar')
);

if(!function_exists('mnnt_icons_nav_bar')) {

	function mnnt_icons_nav_bar($mnnt_arguments){
		
		if(!empty($mnnt_arguments['mnnt_saved_options']['icons_nav_bar'])) {
			
			$mnnt_saved_option = $mnnt_arguments['mnnt_saved_options']['icons_nav_bar'];
			
		} else {
			
			$mnnt_saved_option = null;
			
		}
		
		if($mnnt_saved_option === '1') {
			
			$mnnt_icons_nav_bar_checked = 'checked';
			
		} else {
			
			$mnnt_icons_nav_bar_checked = null;
			
		}
		
		?>
		<input type="checkbox" name="_mnnt_options[icons_nav_bar]" class="mnnt-switch" id="mnnt-icons-nav-bar" value="1" <?php echo $mnnt_icons_nav_bar_checked; ?> />
		<label for="mnnt-icons-nav-bar">&nbsp;</label>
		<p><small><?php echo __('If switched on, a login/logout icon will be shown as an additional element of the main navigation menu','main-entrance'); ?></small></p>
		<?php
		
	}

} else {
	
	error_log('function: "mnnt_icons_nav_bar" already exists');
	
}

add_settings_field(
'mnnt-icon-page-id',  
__('Define login page','main-entrance'),
'mnnt_icon_page_id',
'mnnt-section',
'mnnt_icons_section',
array('mnnt_saved_options' => $mnnt_saved_options, 'class' => 'mnnt-icon-page-id')
);

if(!function_exists('mnnt_icon_page_id')) {

	function mnnt_icon_page_id($mnnt_arguments){
		
		global $wpdb;
		$mnnt_check_main_entrance_forms = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE post_status='publish' AND post_content LIKE '%[main-entrance-form]%'", ARRAY_A );
		$mnnt_count_main_entrance_forms = $wpdb->num_rows;

		if(!empty($mnnt_count_main_entrance_forms) && $mnnt_count_main_entrance_forms >= 1) {	
						
			if(!empty($mnnt_arguments['mnnt_saved_options']['icon_page_id'])) {
				
				$mnnt_saved_option = $mnnt_arguments['mnnt_saved_options']['icon_page_id'];
				
			} else {
				
				$mnnt_saved_option = $mnnt_check_main_entrance_forms[0]['ID'];
				
			}		
			
			?>
			<select name="_mnnt_options[icon_page_id]" id="mnnt-icon-page-id">
			<?php
			global $wp_roles;
			foreach ($mnnt_check_main_entrance_forms as $mnnt_check_main_entrance_form) {
				
				if($mnnt_check_main_entrance_form['ID'] === $mnnt_saved_option) {
				
					echo '<option value="'.$mnnt_check_main_entrance_form['ID'].'" selected="selected">'.$mnnt_check_main_entrance_form['post_title'].'</option>';
					
				} else {
					
					echo '<option value="'.$mnnt_check_main_entrance_form['ID'].'">'.$mnnt_check_main_entrance_form['post_title'].'</option>';
					
				}
						
			}
			
			?>
			</select>
			<?php
		
		} else {
			
			?>
			<select name="_mnnt_options[icon_page_id]" id="mnnt-icon-page-id">
				<option value="0"><?php echo __('none','main-entrance'); ?></option>
			</select>
			<?php
			
		}
		
		?>
		<p><small><?php echo __('Set the page that you want users to be redirected to when they click on the icons added to main navigation menu','main-entrance'); ?></small></p>
		
		<?php
	}

} else {
	
	error_log('function: "mnnt_icon_page_id" already exists');
	
}


add_settings_section(
'mnnt_hide_section',
__('Hide Backend','main-entrance'),
'mnnt_hide_section_comment',
'mnnt-section'
);

if(!function_exists('mnnt_hide_section_comment')) {
	
	function mnnt_hide_section_comment(){
		echo '<span class="mnnt-section-comment">'.__('Hide admin bar and prevent dashboard access to everyone who has registered through "Main Entrance" form and who therefore has "Main Entrance User" role', 'main-entrance').'</span>';
	}
	
} else {
	
	error_log('function: "mnnt_hide_section_comment" already exists');
	
}

add_settings_field(
'mnnt-hide-admin-bar',
__('Hide admin bar','main-entrance'),
'mnnt_hide_admin_bar',
'mnnt-section',
'mnnt_hide_section',
array('mnnt_saved_options' => $mnnt_saved_options, 'class' => 'mnnt-hide-admin-bar')
);

if(!function_exists('mnnt_hide_admin_bar')) {

	function mnnt_hide_admin_bar($mnnt_arguments){
		
		if(!empty($mnnt_arguments['mnnt_saved_options']['hide_admin_bar'])) {
			
			$mnnt_saved_option = $mnnt_arguments['mnnt_saved_options']['hide_admin_bar'];
			
		} else {
			
			$mnnt_saved_option = null;
			
		}
		
		if($mnnt_saved_option === '1') {
			
			$mnnt_hide_admin_bar_checked = 'checked';
			
		} else {
			
			$mnnt_hide_admin_bar_checked = null;
			
		}
		
		?>
		<input type="checkbox" name="_mnnt_options[hide_admin_bar]" class="mnnt-switch" id="mnnt-hide-admin-bar" value="1" <?php echo $mnnt_hide_admin_bar_checked; ?> />
		<label for="mnnt-hide-admin-bar">&nbsp;</label>
		<p><small><?php echo __('If switched on, WordPress admin bar will be hidden to everyone who has registered through "Main Entrance" form and who therefore has "Main Entrance User" role','main-entrance'); ?></small></p>
		<?php
		
	}

} else {
	
	error_log('function: "mnnt_hide_admin_bar" already exists');
	
}

add_settings_field(
'mnnt-hide-dashboard',
__('Hide dashboard','main-entrance'),
'mnnt_hide_dashboard',
'mnnt-section',
'mnnt_hide_section',
array('mnnt_saved_options' => $mnnt_saved_options, 'class' => 'mnnt-hide-dashboard')
);

if(!function_exists('mnnt_hide_dashboard')) {

	function mnnt_hide_dashboard($mnnt_arguments){
		
		if(!empty($mnnt_arguments['mnnt_saved_options']['hide_dashboard'])) {
			
			$mnnt_saved_option = $mnnt_arguments['mnnt_saved_options']['hide_dashboard'];
			
		} else {
			
			$mnnt_saved_option = null;
			
		}
		
		if($mnnt_saved_option === '1') {
			
			$mnnt_hide_dashboard_checked = 'checked';
			
		} else {
			
			$mnnt_hide_dashboard_checked = null;
			
		}
		
		?>
		<input type="checkbox" name="_mnnt_options[hide_dashboard]" class="mnnt-switch" id="mnnt-hide-dashboard" value="1" <?php echo $mnnt_hide_dashboard_checked; ?> />
		<label for="mnnt-hide-dashboard">&nbsp;</label>
		<p><small><?php echo __('If switched on, everyone who has registered through "Main Entrance" form and who therefore has "Main Entrance User" role will be prevented from entering the WordPress dashboard','main-entrance'); ?></small></p>
		<?php
		
	}

} else {
	
	error_log('function: "mnnt_hide_dashboard" already exists');
	
}


add_settings_section(
'mnnt_login_section',
__('Redirect After Login','main-entrance'),
'mnnt_login_section_comment',
'mnnt-section'
);

if(!function_exists('mnnt_login_section_comment')) {
	
	function mnnt_login_section_comment(){
		echo '<span class="mnnt-section-comment">'.__('Define where to redirect users after successful login through "Main Entrance" login form', 'main-entrance').'</span>';
	}
	
} else {
	
	error_log('function: "mnnt_login_section_comment" already exists');
	
}

add_settings_field(
'mnnt-redirect-after-login-meu', 
__('Redirect page for users with "Main Entrance Users" role','main-entrance'),
'mnnt_redirect_after_login_meu',
'mnnt-section',
'mnnt_login_section',
array('mnnt_saved_options' => $mnnt_saved_options, 'class' => 'mnnt-redirect-after-login-meu')
);

if(!function_exists('mnnt_redirect_after_login_meu')) {

	function mnnt_redirect_after_login_meu($mnnt_arguments){
					
		if(!empty($mnnt_arguments['mnnt_saved_options']['redirect_after_login_meu'])) {
			
			$mnnt_saved_option = $mnnt_arguments['mnnt_saved_options']['redirect_after_login_meu'];
			
		} else {
			
			$mnnt_saved_option = null;
			
		}	

		$mnnt_registered_post_types_args = array(
		
			'exclude_from_search' => false,
			'public'   => true,
			'_builtin' => false,
			'public' => true,
			'publicly_queryable' => true
			
		);
			
		$mnnt_registered_post_types = get_post_types($mnnt_registered_post_types_args);
	
		$mnnt_post_types_to_search = array('post','page');
		
		foreach($mnnt_registered_post_types as $mnnt_registered_post_type){
			
			$mnnt_post_types_to_search[] = $mnnt_registered_post_type;
			
		}
		
		$mnnt_home_page_id = get_option('page_on_front');
		
		echo '<select name="_mnnt_options[redirect_after_login_meu]" id="redirect-after-login-meu">';
		
		//if restricted media is installed
		if(
			defined('RSMD_BASE_PATH')
			|| defined('NFPRCT_BASE_PATH')
			
		){
			
			echo '<option value="" selected>'.__('Bring back to the origin page','main-entrance').'</option>';
			
		}
		
		if(!empty($mnnt_home_page_id)) {
			
			if((int)$mnnt_home_page_id === (int)$mnnt_saved_option) {
			
				echo '<option value="'.$mnnt_home_page_id.'" selected>Homepage (id: '.$mnnt_home_page_id.')</option>';
				
			} else {
				
				echo '<option value="'.$mnnt_home_page_id.'">Homepage (id: '.$mnnt_home_page_id.')</option>';
				
			}
			
		}
		
		$mnnt_pages_query_args = array(
		
			'post_type' => $mnnt_post_types_to_search,
			'post_status' => array('publish'),
			'post__not_in' => array($mnnt_home_page_id),
			'orderby' => 'post_title',
			'order' => 'asc',
			'posts_per_page' => -1,	
						
		);
		 
		$mnnt_pages_query = new WP_Query($mnnt_pages_query_args);
		 
		if($mnnt_pages_query->have_posts()){

			while($mnnt_pages_query->have_posts()) {
				
				$mnnt_pages_query->the_post();
				
				$mnnt_page_id = get_the_ID();
				$mnnt_page_title = get_the_title();
				
				if((int)$mnnt_page_id === (int)$mnnt_saved_option) {
				
					echo '<option value="'.get_the_ID().'" selected>'.get_the_title().' (id: '.get_the_ID().')</option>';
					
				} else {
					
					echo '<option value="'.get_the_ID().'">'.get_the_title().' (id: '.get_the_ID().')</option>';
				}
				
			}
			
		} 
		
		wp_reset_postdata();

		?>
		
		</select>

		<p><small><?php echo __('Select the page you want to redirect to after a successful login of a user who has registered through "Main Entrance" form and who therefore has "Main Entrance User" role','main-entrance'); ?></small></p>
		
		<?php
	}

} else {
	
	error_log('function: "mnnt_redirect_after_login_meu" already exists');
	
}

add_settings_field(
'mnnt-redirect-after-login-all', 
__('Redirect page for other user roles','main-entrance'),
'mnnt_redirect_after_login_all',
'mnnt-section',
'mnnt_login_section',
array('mnnt_saved_options' => $mnnt_saved_options, 'class' => 'mnnt-redirect-after-login-all')
);

if(!function_exists('mnnt_redirect_after_login_all')) {

	function mnnt_redirect_after_login_all($mnnt_arguments){
					
		if(!empty($mnnt_arguments['mnnt_saved_options']['redirect_after_login_all'])) {
			
			$mnnt_saved_option = $mnnt_arguments['mnnt_saved_options']['redirect_after_login_all'];
			
		} else {
			
			$mnnt_saved_option = null;
			
		}	

		$mnnt_registered_post_types_args = array(
		
			'exclude_from_search' => false,
			'public'   => true,
			'_builtin' => false,
			'public' => true,
			'publicly_queryable' => true
			
		);
			
		$mnnt_registered_post_types = get_post_types($mnnt_registered_post_types_args);
	
		$mnnt_post_types_to_search = array('post','page');
		
		foreach($mnnt_registered_post_types as $mnnt_registered_post_type){
			
			$mnnt_post_types_to_search[] = $mnnt_registered_post_type;
			
		}
		
		$mnnt_home_page_id = get_option('page_on_front');
		
		echo '<select name="_mnnt_options[redirect_after_login_all]" id="redirect-after-login-all">';
		
		//if restricted media is installed
		if(
			defined('RSMD_BASE_PATH')
			|| defined('NFPRCT_BASE_PATH')
			
		){
			
			echo '<option value="" selected>'.__('Bring back to the origin page','main-entrance').'</option>';
			
		}
		
		if(!empty($mnnt_home_page_id)) {
			
			if((int)$mnnt_home_page_id === (int)$mnnt_saved_option) {
			
				echo '<option value="'.$mnnt_home_page_id.'" selected>Homepage (id: '.$mnnt_home_page_id.')</option>';
				
			} else {
				
				echo '<option value="'.$mnnt_home_page_id.'">Homepage (id: '.$mnnt_home_page_id.')</option>';
				
			}
			
		}
		
		$mnnt_pages_query_args = array(
		
			'post_type' => $mnnt_post_types_to_search,
			'post_status' => array('publish'),
			'post__not_in' => array($mnnt_home_page_id),
			'orderby' => 'post_title',
			'order' => 'asc',
			'posts_per_page' => -1,
						
		);
		 
		$mnnt_pages_query = new WP_Query($mnnt_pages_query_args);
		 
		if($mnnt_pages_query->have_posts()){

			while($mnnt_pages_query->have_posts()) {
				
				$mnnt_pages_query->the_post();
				
				$mnnt_page_id = get_the_ID();
				$mnnt_page_title = get_the_title();
				
				if((int)$mnnt_page_id === (int)$mnnt_saved_option) {
				
					echo '<option value="'.get_the_ID().'" selected>'.get_the_title().' (id: '.get_the_ID().')</option>';
					
				} else {
					
					echo '<option value="'.get_the_ID().'">'.get_the_title().' (id: '.get_the_ID().')</option>';
				}
				
			}
			
		} 
		
		wp_reset_postdata();
				
		?>
		
		</select>

		<p><small><?php echo __('Select the page you want to redirect to after a successful login of all users that do not have "Main Entrance User" role','main-entrance'); ?></small></p>
		
		<?php
	}

} else {
	
	error_log('function: "mnnt_redirect_after_login_all" already exists');
	
}


add_settings_section(
'mnnt_logout_section',
__('Redirect After Logout','main-entrance'),
'mnnt_logout_section_comment',
'mnnt-section'
);

if(!function_exists('mnnt_logout_section_comment')) {
	
	function mnnt_logout_section_comment(){
		echo '<span class="mnnt-section-comment">'.__('Define where to redirect users after successful logout through "Main Entrance" logout button', 'main-entrance').'</span>';
	}
	
} else {
	
	error_log('function: "mnnt_logout_section_comment" already exists');
	
}

add_settings_field(
'mnnt-redirect-after-logout', 
__('Page to redirect to','main-entrance'),
'mnnt_redirect_after_logout',
'mnnt-section',
'mnnt_logout_section',
array('mnnt_saved_options' => $mnnt_saved_options, 'class' => 'mnnt-redirect-after-logout')
);

if(!function_exists('mnnt_redirect_after_logout')) {

	function mnnt_redirect_after_logout($mnnt_arguments){
					
		if(!empty($mnnt_arguments['mnnt_saved_options']['redirect_after_logout'])) {
			
			$mnnt_saved_option = $mnnt_arguments['mnnt_saved_options']['redirect_after_logout'];
			
		} else {
			
			$mnnt_saved_option = null;
			
		}	
		
		$mnnt_registered_post_types_args = array(
		
			'exclude_from_search' => false,
			'public'   => true,
			'_builtin' => false,
			'public' => true,
			'publicly_queryable' => true
			
		);
			
		$mnnt_registered_post_types = get_post_types($mnnt_registered_post_types_args);
	
		$mnnt_post_types_to_search = array('post','page');
		
		foreach($mnnt_registered_post_types as $mnnt_registered_post_type){
			
			$mnnt_post_types_to_search[] = $mnnt_registered_post_type;
			
		}
		
		$mnnt_home_page_id = get_option('page_on_front');
		
		echo '<select name="_mnnt_options[redirect_after_logout]" id="redirect-after-logout">';
		
		if(!empty($mnnt_home_page_id)) {
			
			if((int)$mnnt_home_page_id === (int)$mnnt_saved_option) {
			
				echo '<option value="'.$mnnt_home_page_id.'" selected>Homepage (id: '.$mnnt_home_page_id.')</option>';
				
			} else {
				
				echo '<option value="'.$mnnt_home_page_id.'">Homepage (id: '.$mnnt_home_page_id.')</option>';
				
			}
			
		}
		
		$mnnt_pages_query_args = array(
		
			'post_type' => $mnnt_post_types_to_search,
			'post_status' => array('publish'),
			'post__not_in' => array($mnnt_home_page_id),
			'orderby' => 'post_title',
			'order' => 'asc',
			'posts_per_page' => -1,
			'meta_query' => array(
			
			   'relation' => 'OR',
			   
				array(
				
				 'key' => '_rsmd_is_restricted',
				 'compare' => 'NOT EXISTS',
				 
				),
				
				array(
				
				 'key' => '_rsmd_is_restricted',
				 'value' => '1',
				 'compare' => '!=',
				 
				)
				
			)			
						
		);
		 
		$mnnt_pages_query = new WP_Query($mnnt_pages_query_args);
		 
		if($mnnt_pages_query->have_posts()){

			while($mnnt_pages_query->have_posts()) {
				
				$mnnt_pages_query->the_post();
				
				$mnnt_page_id = get_the_ID();
				$mnnt_page_title = get_the_title();
				
				if((int)$mnnt_page_id === (int)$mnnt_saved_option) {
				
					echo '<option value="'.get_the_ID().'" selected>'.get_the_title().' (id: '.get_the_ID().')</option>';
					
				} else {
					
					echo '<option value="'.get_the_ID().'">'.get_the_title().' (id: '.get_the_ID().')</option>';
				}
				
			}
			
		}	

		wp_reset_postdata();		
		
		/*$mnnt_page_id_dropdown_args = array(
			'post_type'			=> 'page',
			'post_status'		=> ['publish'],
			'name'				=> '_mnnt_options[redirect_after_logout]',
			'id'				=> 'mnnt-redirect-after-logout',
			'sort_column'		=> 'menu_order, post_title',
			'echo'				=> 1,
			'show_option_none'  => __('Homepage','main-entrance'),
			'option_none_value' => '0',
			'selected'			=> $mnnt_saved_option,
		);
		
		wp_dropdown_pages($mnnt_page_id_dropdown_args);
		
		*/
		?>
		
		</select>

		<p><small><?php echo __('Select the page you want to redirect a user to after successful logout','main-entrance'); ?></small></p>
		
		<?php
	}

} else {
	
	error_log('function: "mnnt_redirect_after_logout" already exists');
	
}


add_settings_section(
'mnnt_hide_wp_login_section',
__('Hide WordPress Login Page','main-entrance'),
'mnnt_hide_wp_login_section_comment',
'mnnt-section'
);

if(!function_exists('mnnt_hide_wp_login_section_comment')) {
	
	function mnnt_hide_wp_login_section_comment(){
		echo '<span class="mnnt-section-comment">'.__('In this section you can decide to hide WordPress Login Page and let users to login, logut, register or recover password only through "Main Entrance" forms', 'main-entrance').'</span>';
	}
	
} else {
	
	error_log('function: "mnnt_hide_wp_login_section_comment" already exists');
	
}

add_settings_field(
'mnnt-hide-wp-login',
__('Hide wp-login.php','main-entrance'),
'mnnt_hide_wp_login',
'mnnt-section',
'mnnt_hide_wp_login_section',
array('mnnt_saved_options' => $mnnt_saved_options, 'class' => 'mnnt-hide-wp-login')
);

if(!function_exists('mnnt_hide_wp_login')) {

	function mnnt_hide_wp_login($mnnt_arguments){
		
		if(!empty($mnnt_arguments['mnnt_saved_options']['hide_wp_login'])) {
			
			$mnnt_saved_option = $mnnt_arguments['mnnt_saved_options']['hide_wp_login'];
			
		} else {
			
			$mnnt_saved_option = null;
			
		}
		
		if($mnnt_saved_option === '1') {
			
			$mnnt_hide_wp_login_checked = 'checked';
			
		} else {
			
			$mnnt_hide_wp_login_checked = null;
			
		}
		
		?>
		<input type="checkbox" name="_mnnt_options[hide_wp_login]" class="mnnt-switch" id="mnnt-hide-wp-login" value="1" <?php echo $mnnt_hide_wp_login_checked; ?> />
		<label for="mnnt-hide-wp-login">&nbsp;</label>
		<p><small><?php echo __('If switched on, wp-login.php will be hidden to everyone and the only way to login, logut, register or recover password will be through the "Main Entrance" forms','main-entrance'); ?></small></p>
		<?php
		
	}

} else {
	
	error_log('function: "mnnt_hide_wp_login" already exists');
	
}


add_settings_section(
'mnnt_plugin_uninstallation_section',
__('Plugin Uninstallation','main-entrance'),
'mnnt_plugin_uninstallation_section_comment',
'mnnt-section'
);

if(!function_exists('mnnt_plugin_uninstallation_section_comment')) {
	
	function mnnt_plugin_uninstallation_section_comment(){
		echo '<span class="mnnt-section-comment">'.__('Define what to do after plugin unsinstallation with users registered through "Main Entrance" form and with users that have "Main Entrance Users" role', 'main-entrance').'</span>';
	}
	
} else {
	
	error_log('function: "mnnt_plugin_uninstallation_section_comment" already exists');
	
}

add_settings_field(
'mnnt-delete-users',
__('Delete users on plugin uninstallation','main-entrance'),
'mnnt_delete_users',
'mnnt-section',
'mnnt_plugin_uninstallation_section',
array('mnnt_saved_options' => $mnnt_saved_options, 'class' => 'mnnt-delete-users')
);

if(!function_exists('mnnt_delete_users')) {

	function mnnt_delete_users($mnnt_arguments){
		
		if(!empty($mnnt_arguments['mnnt_saved_options']['delete_users'])) {
			
			$mnnt_saved_option = $mnnt_arguments['mnnt_saved_options']['delete_users'];
			
		} else {
			
			$mnnt_saved_option = null;
			
		}
		
		if($mnnt_saved_option === '1') {
			
			$mnnt_delete_users_checked = 'checked';
			
		} else {
			
			$mnnt_delete_users_checked = null;
			
		}
		
		?>
		<input type="checkbox" name="_mnnt_options[delete_users]" class="mnnt-switch" id="mnnt-delete-users" value="1" <?php echo $mnnt_delete_users_checked; ?> />
		<label for="mnnt-delete-users">&nbsp;</label>
		<p><small><?php echo __('If switched on, on plugin uninstallation the users registered through "Main Entrance" plugin and the users with role of "Main Entrance Users" will be deleted. If switched off, no user will be deleted and "Main Entrance Users" role will be turned to the related WordPress role defined above','main-entrance'); ?></small></p>
		<?php
		
	}

} else {
	
	error_log('function: "mnnt_delete_users" already exists');
	
}


settings_fields("mnnt-section");
do_settings_sections("mnnt-section");

submit_button('Save Settings', 'primary', 'mnnt-save-options');
