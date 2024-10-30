<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//define option page parameters
if(!function_exists('mnnt_register_form')){
	
	function mnnt_register_form($mnnt_form_to_diplay) {

		global $mnnt_options_array;
		$mnnt_content_to_return = null;
		$mnnt_default_acceptance_doc_name =	null;
		$mnnt_default_acceptance_doc_url = null;	
		
		if(!empty($mnnt_options_array['default_acceptance_doc_id'])) {
			
			$mnnt_default_acceptance_doc_name = get_the_title($mnnt_options_array['default_acceptance_doc_id']);
			$mnnt_default_acceptance_doc_url = wp_get_attachment_url($mnnt_options_array['default_acceptance_doc_id']);
			
		}
		
		//if registration if not allowed, return a null content (even if registration page is not reachable because of a redirection set in mnnt_dependencies file)
		if(empty($mnnt_options_array['allow_registration']) || $mnnt_options_array['allow_registration'] !== '1') { 
		
			return $mnnt_content_to_return;
			
		}	
		
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
			
				<h2 id="mnnt-form-title" class="mnnt-form-title">'.__('Register','main-entrance').'</h2>
				
				<div id="mnnt-error-container" class="mnnt-error-container">

				';
				
				global $mnnt_register_error;
				global $mnnt_register_info;
				
				if(!empty($mnnt_register_error)) {
					
					$mnnt_content_to_return .= '
						
					<div id="mnnt-error" class="mnnt-error">
					
					<p>
					
					';				
						
						
					$mnnt_content_to_return .= $mnnt_register_error;
						
					$mnnt_content_to_return .= '
		
					</p>
					
					</div>
					
					';				
						
				}
				
				$mnnt_content_to_return .= '

				</div>

				<div id="mnnt-info-container" class="mnnt-info-container">
				
				';

				
				if(!empty($mnnt_register_info)) {
					
					$mnnt_content_to_return .= '
						
					<div id="mnnt-info" class="mnnt-info">
					
					<p>
					
					';				
						
						
					$mnnt_content_to_return .= $mnnt_register_info;
						
					$mnnt_content_to_return .= '
		
					</p>
					
					</div>
					
					';				
						
				}
				
				if(!empty($_POST['mnnt-register-email'])) {
					
					$mnnt_posted_register_email = sanitize_email(strtolower($_POST['mnnt-register-email']));
					
				} else {
					
					$mnnt_posted_register_email = null;
					
				}
								
				$mnnt_content_to_return .= '
										
				</div>					

				<form method="post" action="">';
				
					if(!empty($mnnt_options_array['name_field']) && $mnnt_options_array['name_field'] === '1') {
						
						if(!empty($_POST['mnnt-register-name'])) {
							
							$mnnt_posted_register_name = sanitize_text_field(ucwords(strtolower(stripslashes_deep($_POST['mnnt-register-name']))));
							
						} else {
							
							$mnnt_posted_register_name = null;
							
						}	

						$mnnt_content_to_return .= '
											
						<p>
							<label for="mnnt-register-name">'.__('Name','main-entrance').'</label>
							<input type="text" name="mnnt-register-name" id="mnnt-register-name" class="mnnt-input mnnt-register-name" value="'.$mnnt_posted_register_name.'" autocorrect="off" autocapitalize="none">
							
						</p>
						
						';							
						
						if(!empty($mnnt_options_array['name_field_mandatory']) && $mnnt_options_array['name_field_mandatory'] === '1') {
						
							$mnnt_name_field_is_mandatory = true;
						
						}
						
					}

					if(!empty($mnnt_options_array['surname_field']) && $mnnt_options_array['surname_field'] === '1') {
						
						if(!empty($_POST['mnnt-register-surname'])) {
							
							$mnnt_posted_register_surname = sanitize_text_field(ucwords(strtolower(stripslashes_deep($_POST['mnnt-register-surname']))));
							
						} else {
							
							$mnnt_posted_register_surname = null;
							
						}	

						$mnnt_content_to_return .= '
											
						<p>
							<label for="mnnt-register-surname">'.__('Surname','main-entrance').'</label>
							<input type="text" name="mnnt-register-surname" id="mnnt-register-surname" class="mnnt-input mnnt-register-surname" value="'.$mnnt_posted_register_surname.'" autocorrect="off" autocapitalize="none">
							
						</p>
						
						';							
						
						if(!empty($mnnt_options_array['name_field_mandatory']) && $mnnt_options_array['name_field_mandatory'] === '1') {
						
							$mnnt_name_field_is_mandatory = true;
						
						}
						
					}	

					if(!empty($mnnt_options_array['genre_field']) && $mnnt_options_array['genre_field'] === '1') {

						$mnnt_genre_list_array = array(

								__('Undefined','main-entrance'), __('Male','main-entrance'), __('Female','main-entrance')

						);	

						
						if(!empty($_POST['mnnt-register-genre'])) {
							
							$mnnt_posted_register_genre = sanitize_text_field($_POST['mnnt-register-genre']);
							
						} else {
							
							$mnnt_posted_register_genre = null;
							
						}	

						$mnnt_content_to_return .= '
											
						<p>
							<label for="mnnt-register-genre">'.__('Genre','main-entrance').'</label>
							
							<select name="mnnt-register-genre" id="mnnt-register-genre" class="mnnt-input mnnt-register-genre">
							
							';
							
							foreach($mnnt_genre_list_array as $mnnt_current_genre){
								
								if(!is_null($mnnt_posted_register_genre) && $mnnt_current_genre === $mnnt_posted_register_genre) {
								
									$mnnt_content_to_return .= '<option value="'.$mnnt_current_genre.'" selected>'.$mnnt_current_genre.'</option>';
									
								} elseif (is_null($mnnt_posted_register_genre) && $mnnt_current_genre === __('Female','main-entrance')) {
									
									$mnnt_content_to_return .= '<option value="'.$mnnt_current_genre.'" selected>'.$mnnt_current_genre.'</option>';
										
								} else {
									
									$mnnt_content_to_return .= '<option value="'.$mnnt_current_genre.'">'.$mnnt_current_genre.'</option>';
										
								}
								
							}
							
							
							$mnnt_content_to_return .= '
							
							</select>
							
						</p>
						
						';							

					}

					if(!empty($mnnt_options_array['date_of_birth_field']) && $mnnt_options_array['date_of_birth_field'] === '1') {
						
						if(!empty($_POST['mnnt-register-date-of-birth'])) {
							
							$mnnt_posted_register_date_of_birth = sanitize_text_field(ucwords(strtolower(stripslashes_deep($_POST['mnnt-register-date-of-birth']))));
							
						} else {
							
							$mnnt_posted_register_date_of_birth = null;
							
						}	

						$mnnt_content_to_return .= '
											
						<p>
							<label for="mnnt-register-date-of-birth">'.__('Date of birth','main-entrance').'</label>
							<input type="date" name="mnnt-register-date-of-birth" id="mnnt-register-date-of-birth" class="mnnt-input mnnt-register-date-of-birth" value="'.$mnnt_posted_register_date_of_birth.'" autocorrect="off" autocapitalize="none">
							
						</p>
						
						';							
						
						if(!empty($mnnt_options_array['name_field_mandatory']) && $mnnt_options_array['name_field_mandatory'] === '1') {
						
							$mnnt_name_field_is_mandatory = true;
						
						}
						
					}					

					if(!empty($mnnt_options_array['company_name_field']) && $mnnt_options_array['company_name_field'] === '1') {
										
						if(!empty($_POST['mnnt-register-company-name'])) {
							
							$mnnt_posted_register_company_name = sanitize_text_field(stripslashes_deep($_POST['mnnt-register-company-name']));
							
						} else {
							
							$mnnt_posted_register_company_name = null;
							
						}	

						$mnnt_content_to_return .= '
											
						<p>
							<label for="mnnt-register-company-name">'.__('Company Name','main-entrance').'</label>
							<input type="text" name="mnnt-register-company-name" id="mnnt-register-company-name" class="mnnt-input mnnt-register-company-name" value="'.$mnnt_posted_register_company_name.'" autocorrect="off" autocapitalize="none">
							
						</p>
						
						';							
						
					}			

					if(!empty($mnnt_options_array['phone_number_field']) && $mnnt_options_array['phone_number_field'] === '1') {
						
						
						if(!empty($_POST['mnnt-register-phone-number'])) {
							
							$mnnt_posted_register_phone_number = sanitize_text_field($_POST['mnnt-register-phone-number']);
							
						} else {
							
							$mnnt_posted_register_phone_number = null;
							
						}	

						$mnnt_content_to_return .= '
											
						<p>
							<label for="mnnt-register-phone-number">'.__('Phone Number','main-entrance').'</label>
							<input type="text" name="mnnt-register-phone-number" id="mnnt-register-phone-number" class="mnnt-input mnnt-register-phone-number" value="'.$mnnt_posted_register_phone_number.'" autocorrect="off" autocapitalize="none">
							
						</p>
						
						';							
						
					}	

					if(!empty($mnnt_options_array['state_field']) && $mnnt_options_array['state_field'] === '1') {

						$mnnt_state_list_array = array(

								"AGRIGENTO", "ALESSANDRIA", "ANCONA", "AOSTA", "AREZZO", "ASCOLI PICENO", "ASTI", "AVELLINO", "BARI", "BARLETTA-ANDRIA-TRANI", "BELLUNO", "BENEVENTO", "BERGAMO", "BIELLA", "BOLOGNA", "BOLZANO", "BRESCIA", "BRINDISI", "CAGLIARI", "CALTANISSETTA", "CAMPOBASSO", "CARBONIA-IGLESIAS", "CASERTA", "CATANIA", "CATANZARO", "CHIETI", "COMO", "COSENZA", "CREMONA", "CROTONE", "CUNEO", "ENNA", "FERMO", "FERRARA", "FIRENZE", "FOGGIA", "FORLI’-CESENA", "FROSINONE", "GENOVA", "GORIZIA", "GROSSETO", "IMPERIA", "ISERNIA", "LA SPEZIA", "L’AQUILA", "LATINA", "LECCE", "LECCO", "LIVORNO", "LODI", "LUCCA", "MACERATA", "MANTOVA", "MASSA-CARRARA", "MATERA", "MEDIO CAMPIDANO", "MESSINA", "MILANO", "MODENA", "MONZA E BRIANZA", "NAPOLI", "NOVARA", "NUORO", "OGLIASTRA", "OLBIA-TEMPIO", "ORISTANO", "PADOVA", "PALERMO", "PARMA", "PAVIA", "PERUGIA", "PESARO E URBINO", "PESCARA", "PIACENZA", "PISA", "PISTOIA", "PORDENONE", "POTENZA", "PRATO", "RAGUSA", "RAVENNA", "REGGIO CALABRIA", "REGGIO EMILIA", "RIETI", "RIMINI", "ROMA", "ROVIGO", "SALERNO", "SASSARI", "SAVONA", "SIENA", "SIRACUSA", "SONDRIO", "TARANTO", "TERAMO", "TERNI", "TORINO", "TRAPANI", "TRENTO", "TREVISO", "TRIESTE", "UDINE", "VARESE", "VENEZIA", "VERBANO-CUSIO-OSSOLA", "VERCELLI", "VERONA", "VIBO VALENTIA", "VICENZA", "VITERBO"

						);	

						
						if(!empty($_POST['mnnt-register-state'])) {
							
							$mnnt_posted_register_state = sanitize_text_field($_POST['mnnt-register-state']);
							
						} else {
							
							$mnnt_posted_register_state = null;
							
						}	

						$mnnt_content_to_return .= '
											
						<p>
							<label for="mnnt-register-state">'.__('State','main-entrance').'</label>
							
							<select name="mnnt-register-state" id="mnnt-register-state" class="mnnt-input mnnt-register-state">
							
							';
							
							foreach($mnnt_state_list_array as $mnnt_current_state){
								

								if(!is_null($mnnt_posted_register_state) && $mnnt_current_state === $mnnt_posted_register_state) {
								
									$mnnt_content_to_return .= '<option value="'.$mnnt_current_state.'" selected>'.$mnnt_current_state.'</option>';
									
								} elseif (is_null($mnnt_posted_register_state) && $mnnt_current_state === 'COMO') {
									
									$mnnt_content_to_return .= '<option value="'.$mnnt_current_state.'" selected>'.$mnnt_current_state.'</option>';
										
								} else {
									
									$mnnt_content_to_return .= '<option value="'.$mnnt_current_state.'">'.$mnnt_current_state.'</option>';
										
								}
								
							}
							
							
							$mnnt_content_to_return .= '
							
							</select>
							
						</p>
						
						';							

					}					

					if(!empty($mnnt_options_array['country_field']) && $mnnt_options_array['country_field'] === '1') {

						$mnnt_country_list_array = array(

								"Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas (the)","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia (Plurinational State of)","Bonaire, Sint Eustatius and Saba","Bosnia and Herzegovina","Botswana","Bouvet Island","Brazil","British Indian Ocean Territory (the)","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cabo Verde","Cambodia","Cameroon","Canada","Cayman Islands (the)","Central African Republic (the)","Chad","Chile","China","Christmas Island","Cocos (Keeling) Islands (the)","Colombia","Comoros (the)","Congo (the Democratic Republic of the)","Congo (the)","Cook Islands (the)","Costa Rica","Croatia","Cuba","Curaçao","Cyprus","Czechia","Côte d'Ivoire","Denmark","Djibouti","Dominica","Dominican Republic (the)","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Eswatini","Ethiopia","Falkland Islands (the) [Malvinas]","Faroe Islands (the)","Fiji","Finland","France","French Guiana","French Polynesia","French Southern Territories (the)","Gabon","Gambia (the)","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guernsey","Guinea","Guinea-Bissau","Guyana","Haiti","Heard Island and McDonald Islands","Holy See (the)","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran (Islamic Republic of)","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Korea (the Democratic People's Republic of)","Korea (the Republic of)","Kuwait","Kyrgyzstan","Lao People's Democratic Republic (the)","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macao","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands (the)","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia (Federated States of)","Moldova (the Republic of)","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands (the)","New Caledonia","New Zealand","Nicaragua","Niger (the)","Nigeria","Niue","Norfolk Island","Northern Mariana Islands (the)","Norway","Oman","Pakistan","Palau","Palestine, State of","Panama","Papua New Guinea","Paraguay","Peru","Philippines (the)","Pitcairn","Poland","Portugal","Puerto Rico","Qatar","Republic of North Macedonia","Romania","Russian Federation (the)","Rwanda","Réunion","Saint Barthélemy","Saint Helena, Ascension and Tristan da Cunha","Saint Kitts and Nevis","Saint Lucia","Saint Martin (French part)","Saint Pierre and Miquelon","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Sint Maarten (Dutch part)","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia and the South Sandwich Islands","South Sudan","Spain","Sri Lanka","Sudan (the)","Suriname","Svalbard and Jan Mayen","Sweden","Switzerland","Syrian Arab Republic","Taiwan","Tajikistan","Tanzania, United Republic of","Thailand","Timor-Leste","Togo","Tokelau","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Turks and Caicos Islands (the)","Tuvalu","Uganda","Ukraine","United Arab Emirates (the)","United Kingdom of Great Britain and Northern Ireland (the)","United States Minor Outlying Islands (the)","United States of America (the)","Uruguay","Uzbekistan","Vanuatu","Venezuela (Bolivarian Republic of)","Viet Nam","Virgin Islands (British)","Virgin Islands (U.S.)","Wallis and Futuna","Western Sahara","Yemen","Zambia","Zimbabwe","Åland Islands"

						);	

						
						if(!empty($_POST['mnnt-register-country'])) {
							
							$mnnt_posted_register_country = sanitize_text_field($_POST['mnnt-register-country']);
							
						} else {
							
							$mnnt_posted_register_country = null;
							
						}	

						$mnnt_content_to_return .= '
											
						<p>
							<label for="mnnt-register-country">'.__('Country','main-entrance').'</label>
							
							<select name="mnnt-register-country" id="mnnt-register-country" class="mnnt-input mnnt-register-country">
							
							';
							
							foreach($mnnt_country_list_array as $mnnt_current_country){
								

								if(!is_null($mnnt_posted_register_country) && $mnnt_current_country === $mnnt_posted_register_country) {
								
									$mnnt_content_to_return .= '<option value="'.$mnnt_current_country.'" selected>'.$mnnt_current_country.'</option>';
									
								} elseif (is_null($mnnt_posted_register_country) && $mnnt_current_country === 'Italy') {
									
									$mnnt_content_to_return .= '<option value="'.$mnnt_current_country.'" selected>'.$mnnt_current_country.'</option>';
										
								} else {
									
									$mnnt_content_to_return .= '<option value="'.$mnnt_current_country.'">'.$mnnt_current_country.'</option>';
										
								}
								
							}
							
							
							$mnnt_content_to_return .= '
							
							</select>
							
						</p>
						
						';							

					}
					
					if(!empty($mnnt_options_array['address_field']) && $mnnt_options_array['address_field'] === '1') {
						
						
						if(!empty($_POST['mnnt-register-address'])) {
							
							$mnnt_posted_register_address = sanitize_text_field($_POST['mnnt-register-address']);
							
						} else {
							
							$mnnt_posted_register_address = null;
							
						}	

						$mnnt_content_to_return .= '
											
						<p>
							<label for="mnnt-register-address">'.__('Address','main-entrance').'</label>
							<input type="text" name="mnnt-register-address" id="mnnt-register-address" class="mnnt-input mnnt-register-address" value="'.$mnnt_posted_register_address.'" autocorrect="off" autocapitalize="none">
							
						</p>
						
						';							
						
					}

					//add filter to provide more fields in the registration form
                    $mnnt_content_to_return .= apply_filters('mnnt_registration_additional_fields_render', '', $mnnt_options_array);
				
					$mnnt_content_to_return .= '
										
					<p>
						<label for="mnnt-register-email">'.__('Email','main-entrance').'</label>
						<input type="email" name="mnnt-register-email" id="mnnt-register-email" class="mnnt-input mnnt-register-email" value="'.$mnnt_posted_register_email.'" autocorrect="off" autocapitalize="none">
						
					</p>
					
					<p>
						<label for="mnnt-register-password">'.__('Password','main-entrance').'</label>
						<input type="password" name="mnnt-register-password" id="mnnt-register-password" class="mnnt-input mnnt-register-password">
						
					</p>
					
					<p class="mnnt-acceptance">
						<input type="checkbox" name="mnnt-default-acceptance" id="mnnt-default-acceptance" class="mnnt-default-acceptance" value="1">
						<label for="mnnt-default-acceptance-text">'.$mnnt_options_array['default_acceptance_text'].'
						<a href="'.$mnnt_default_acceptance_doc_url.'" title="'.__('GDPR and privacy information','main-entrance').'" alt="'.__('GDPR and privacy information','main-entrance').'" target="_blank">'.$mnnt_default_acceptance_doc_name.'</a>
						</label>
					
					
					';
					
					if(
						!empty($mnnt_options_array['secondary_acceptance']) && 
						$mnnt_options_array['secondary_acceptance'] === '1' &&
						!empty($mnnt_options_array['secondary_acceptance_text']) &&
						!empty($mnnt_options_array['secondary_acceptance_doc_id']) && 
						$mnnt_options_array['secondary_acceptance_doc_id'] !== '0' && 
						get_post_status($mnnt_options_array['secondary_acceptance_doc_id']) === 'publish'
					) {
						
						$mnnt_secondary_acceptance_doc_name = get_the_title($mnnt_options_array['secondary_acceptance_doc_id']);
						$mnnt_secondary_acceptance_doc_url = wp_get_attachment_url($mnnt_options_array['secondary_acceptance_doc_id']);
						
						$mnnt_content_to_return .= '


							<br>
							<input type="checkbox" name="mnnt-secondary-acceptance" id="mnnt-secondary-acceptance" class="mnnt-input mnnt-secondary-acceptance" value="1">
							<label for="mnnt-secondary-acceptance-text">'.$mnnt_options_array['secondary_acceptance_text'].'
							<a href="'.$mnnt_secondary_acceptance_doc_url.'" title="'.__('GDPR and privacy information','main-entrance').'" alt="'.__('GDPR and privacy information','main-entrance').'" target="_blank">'.$mnnt_secondary_acceptance_doc_name.'</a>
							</label>
						
						';
						
					}
					
					$mnnt_content_to_return .= '
					
					</p>
					<p>
						<button name="mnnt-register-button" id="mnnt-register-buton" class="button primary-button mnnt-button mnnt-register-button" value="'.wp_create_nonce('mnnt-register-nonce').'">'.__('Register','main-entrance').'</button>
					</p>
					
					
				</form>
				
			</div>
					
		
		</div>
		
		';
				
		return $mnnt_content_to_return;
	
	}
	
} else {
	
	error_log('function: "mnnt_register_form" already exists');
	
}