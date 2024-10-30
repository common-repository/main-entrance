<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//define option page parameters
if(!function_exists('mnnt_check_register')){
	
	function mnnt_check_register() {	
			
		if(!empty($_POST['mnnt-register-button'])) {
						
			global $mnnt_register_error;
			$mnnt_register_error = false;
			
			global $mnnt_register_info;
			$mnnt_register_info = false;
			
			//get and verify nonce
			$mnnt_register_nonce = $_POST['mnnt-register-button'];
			
			if(!wp_verify_nonce($mnnt_register_nonce, 'mnnt-register-nonce')) {
				
				$mnnt_register_error = __('An error occurred','main-entrance').', '.__('please retry','main-entrance');
				return;
				
			}
			
			global $mnnt_options_array;
			
			$mnnt_register_name_posted = null;
			$mnnt_register_surname_posted = null;
			$mnnt_register_genre_posted = null;
			$mnnt_register_date_of_birth_posted = null;
			$mnnt_register_company_name_posted = null;
			$mnnt_register_phone_number_posted = null;
			$mnnt_register_state_posted = null;
			$mnnt_register_country_posted = null;
			$mnnt_register_address_posted = null;
			$mnnt_register_email_posted = null;
			$mnnt_register_password_posted = null;
			$mnnt_register_dafult_acceptance_posted = null;
			$mnnt_register_secondary_acceptance_posted = null;

			if(!empty($_POST['mnnt-register-name'])) {
				
				$mnnt_register_name_posted = sanitize_text_field(ucwords(strtolower(stripslashes_deep($_POST['mnnt-register-name']))));

			} else {
				
				if(
					!empty($mnnt_options_array['name_field_mandatory']) && $mnnt_options_array['name_field_mandatory'] === '1' &&
					!empty($mnnt_options_array['name_field']) && $mnnt_options_array['name_field'] === '1'
				) {
				
					$mnnt_register_error = __('Please enter a valid Name','main-entrance');
					return;
				
				}
				
			}
			
			if(!empty($_POST['mnnt-register-surname'])) {
				
				$mnnt_register_surname_posted = sanitize_text_field(ucwords(strtolower(stripslashes_deep($_POST['mnnt-register-surname']))));

			} else {
				
				if(
					!empty($mnnt_options_array['surname_field_mandatory']) && $mnnt_options_array['surname_field_mandatory'] === '1' &&
					!empty($mnnt_options_array['surname_field']) && $mnnt_options_array['surname_field'] === '1'
				) {
				
					$mnnt_register_error = __('Please enter a valid Surname','main-entrance');
					return;
				
				}
				
			}
			
			if(!empty($_POST['mnnt-register-genre'])) {
				
				$mnnt_register_genre_posted = sanitize_text_field(ucwords(strtolower(stripslashes_deep($_POST['mnnt-register-genre']))));

			} else {
				
				if(
					!empty($mnnt_options_array['genre_field_mandatory']) && $mnnt_options_array['genre_field_mandatory'] === '1' &&
					!empty($mnnt_options_array['genre_field']) && $mnnt_options_array['genre_field'] === '1'
				) {
				
					$mnnt_register_error = __('Please enter a valid genre','main-entrance');
					return;
				
				}
				
			}
			
			if(!empty($_POST['mnnt-register-date-of-birth'])) {
				
				$mnnt_register_date_of_birth_posted = sanitize_text_field(stripslashes_deep($_POST['mnnt-register-date-of-birth']));

			} else {
				
				if(
					!empty($mnnt_options_array['date_of_birth_field_mandatory']) && $mnnt_options_array['date_of_birth_field_mandatory'] === '1' &&
					!empty($mnnt_options_array['date_of_birth_field']) && $mnnt_options_array['date_of_birth_field'] === '1'
				) {
				
					$mnnt_register_error = __('Please enter a valid date of birth','main-entrance');
					return;
				
				}
				
			}
			
			if(!empty($_POST['mnnt-register-company-name'])) {
				
				$mnnt_register_company_name_posted = sanitize_text_field(stripslashes_deep($_POST['mnnt-register-company-name']));
				
			} else {
				
				if(
					!empty($mnnt_options_array['company_name_field_mandatory']) && $mnnt_options_array['company_name_field_mandatory'] === '1' &&
					!empty($mnnt_options_array['company_name_field']) && $mnnt_options_array['company_name_field'] === '1'
				) {
				
					$mnnt_register_error = __('Please enter a valid Company Name','main-entrance');
					return;
				
				}
				
			}
			
			if(!empty($_POST['mnnt-register-phone-number'])) {
				
				if(strlen($_POST['mnnt-register-phone-number']) < 8) {
					
					$mnnt_register_error = __('Please check your phone number','main-entrance');
					return;					
				
				} else {				
				
					$mnnt_register_phone_number_posted = sanitize_text_field($_POST['mnnt-register-phone-number']);
					
				}
				
			} else {
				
				if(
					!empty($mnnt_options_array['phone_number_field_mandatory']) && $mnnt_options_array['phone_number_field_mandatory'] === '1' &&
					!empty($mnnt_options_array['phone_number_field']) && $mnnt_options_array['phone_number_field'] === '1'
				) {
				
					$mnnt_register_error = __('Please enter a valid phone number','main-entrance');
					return;
				
				}
				
			}

			if(!empty($_POST['mnnt-register-state'])) {
				
				$mnnt_register_state_posted = $_POST['mnnt-register-state'];
				
				$mnnt_state_list_array = array(

						"AGRIGENTO", "ALESSANDRIA", "ANCONA", "AOSTA", "AREZZO", "ASCOLI PICENO", "ASTI", "AVELLINO", "BARI", "BARLETTA-ANDRIA-TRANI", "BELLUNO", "BENEVENTO", "BERGAMO", "BIELLA", "BOLOGNA", "BOLZANO", "BRESCIA", "BRINDISI", "CAGLIARI", "CALTANISSETTA", "CAMPOBASSO", "CARBONIA-IGLESIAS", "CASERTA", "CATANIA", "CATANZARO", "CHIETI", "COMO", "COSENZA", "CREMONA", "CROTONE", "CUNEO", "ENNA", "FERMO", "FERRARA", "FIRENZE", "FOGGIA", "FORLI’-CESENA", "FROSINONE", "GENOVA", "GORIZIA", "GROSSETO", "IMPERIA", "ISERNIA", "LA SPEZIA", "L’AQUILA", "LATINA", "LECCE", "LECCO", "LIVORNO", "LODI", "LUCCA", "MACERATA", "MANTOVA", "MASSA-CARRARA", "MATERA", "MEDIO CAMPIDANO", "MESSINA", "MILANO", "MODENA", "MONZA E BRIANZA", "NAPOLI", "NOVARA", "NUORO", "OGLIASTRA", "OLBIA-TEMPIO", "ORISTANO", "PADOVA", "PALERMO", "PARMA", "PAVIA", "PERUGIA", "PESARO E URBINO", "PESCARA", "PIACENZA", "PISA", "PISTOIA", "PORDENONE", "POTENZA", "PRATO", "RAGUSA", "RAVENNA", "REGGIO CALABRIA", "REGGIO EMILIA", "RIETI", "RIMINI", "ROMA", "ROVIGO", "SALERNO", "SASSARI", "SAVONA", "SIENA", "SIRACUSA", "SONDRIO", "TARANTO", "TERAMO", "TERNI", "TORINO", "TRAPANI", "TRENTO", "TREVISO", "TRIESTE", "UDINE", "VARESE", "VENEZIA", "VERBANO-CUSIO-OSSOLA", "VERCELLI", "VERONA", "VIBO VALENTIA", "VICENZA", "VITERBO"

				);
				
				if(!in_array($mnnt_register_state_posted, $mnnt_state_list_array)) { 
				
					$mnnt_register_error = __('Please selectd a valid Country','main-entrance');
					return;
				
				}
				
			} else {
				
				if(
					!empty($mnnt_options_array['state_field_mandatory']) && $mnnt_options_array['state_field_mandatory'] === '1' &&
					!empty($mnnt_options_array['state_field']) && $mnnt_options_array['state_field'] === '1'
					
				) {
				
					$mnnt_register_error = __('Please selectd a valid State','main-entrance');
					return;
				
				}
				
			}
			
			if(!empty($_POST['mnnt-register-country'])) {
				
				$mnnt_register_country_posted = $_POST['mnnt-register-country'];
				
				$mnnt_country_list_array = array(

						"Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas (the)","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia (Plurinational State of)","Bonaire, Sint Eustatius and Saba","Bosnia and Herzegovina","Botswana","Bouvet Island","Brazil","British Indian Ocean Territory (the)","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cabo Verde","Cambodia","Cameroon","Canada","Cayman Islands (the)","Central African Republic (the)","Chad","Chile","China","Christmas Island","Cocos (Keeling) Islands (the)","Colombia","Comoros (the)","Congo (the Democratic Republic of the)","Congo (the)","Cook Islands (the)","Costa Rica","Croatia","Cuba","Curaçao","Cyprus","Czechia","Côte d'Ivoire","Denmark","Djibouti","Dominica","Dominican Republic (the)","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Eswatini","Ethiopia","Falkland Islands (the) [Malvinas]","Faroe Islands (the)","Fiji","Finland","France","French Guiana","French Polynesia","French Southern Territories (the)","Gabon","Gambia (the)","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guernsey","Guinea","Guinea-Bissau","Guyana","Haiti","Heard Island and McDonald Islands","Holy See (the)","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran (Islamic Republic of)","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Korea (the Democratic People's Republic of)","Korea (the Republic of)","Kuwait","Kyrgyzstan","Lao People's Democratic Republic (the)","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macao","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands (the)","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia (Federated States of)","Moldova (the Republic of)","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands (the)","New Caledonia","New Zealand","Nicaragua","Niger (the)","Nigeria","Niue","Norfolk Island","Northern Mariana Islands (the)","Norway","Oman","Pakistan","Palau","Palestine, State of","Panama","Papua New Guinea","Paraguay","Peru","Philippines (the)","Pitcairn","Poland","Portugal","Puerto Rico","Qatar","Republic of North Macedonia","Romania","Russian Federation (the)","Rwanda","Réunion","Saint Barthélemy","Saint Helena, Ascension and Tristan da Cunha","Saint Kitts and Nevis","Saint Lucia","Saint Martin (French part)","Saint Pierre and Miquelon","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Sint Maarten (Dutch part)","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia and the South Sandwich Islands","South Sudan","Spain","Sri Lanka","Sudan (the)","Suriname","Svalbard and Jan Mayen","Sweden","Switzerland","Syrian Arab Republic","Taiwan","Tajikistan","Tanzania, United Republic of","Thailand","Timor-Leste","Togo","Tokelau","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Turks and Caicos Islands (the)","Tuvalu","Uganda","Ukraine","United Arab Emirates (the)","United Kingdom of Great Britain and Northern Ireland (the)","United States Minor Outlying Islands (the)","United States of America (the)","Uruguay","Uzbekistan","Vanuatu","Venezuela (Bolivarian Republic of)","Viet Nam","Virgin Islands (British)","Virgin Islands (U.S.)","Wallis and Futuna","Western Sahara","Yemen","Zambia","Zimbabwe","Åland Islands"

				);
				
				if(!in_array($mnnt_register_country_posted, $mnnt_country_list_array)) { 
				
					$mnnt_register_error = __('Please selectd a valid Country','main-entrance');
					return;
				
				}
				
			} else {
				
				if(
					!empty($mnnt_options_array['country_field_mandatory']) && $mnnt_options_array['country_field_mandatory'] === '1' &&
					!empty($mnnt_options_array['country_field']) && $mnnt_options_array['country_field'] === '1'
					
				) {
				
					$mnnt_register_error = __('Please selectd a valid Country','main-entrance');
					return;
				
				}
				
			}
			
			if(!empty($_POST['mnnt-register-address'])) {
				
				if(strlen($_POST['mnnt-register-address']) < 3) {
					
					$mnnt_register_error = __('Please check your address','main-entrance');
					return;					
				
				} else {				
				
					$mnnt_register_address_posted = sanitize_text_field($_POST['mnnt-register-address']);
					
				}
				
			} else {
				
				if(
					!empty($mnnt_options_array['address_field_mandatory']) && $mnnt_options_array['address_field_mandatory'] === '1' &&
					!empty($mnnt_options_array['address_field']) && $mnnt_options_array['address_field'] === '1'
				) {
				
					$mnnt_register_error = __('Please enter a valid address','main-entrance');
					return;
				
				}
				
			}

			if(!empty($_POST['mnnt-register-email'])) {
				
				$mnnt_register_email_posted = sanitize_email(strtolower($_POST['mnnt-register-email']));
				
			}
			
			if(!empty($_POST['mnnt-register-password'])) {
				
				$mnnt_register_password_posted = trim($_POST['mnnt-register-password']);
				
			}
			
			if(!empty($_POST['mnnt-default-acceptance'])) {
				
				$mnnt_register_dafult_acceptance_posted = absint($_POST['mnnt-default-acceptance']);
				
			}

			if(!empty($_POST['mnnt-secondary-acceptance'])) {
				
				$mnnt_register_secondary_acceptance_posted = absint($_POST['mnnt-secondary-acceptance']);
				
			}			
										
			//check email address
			if($mnnt_register_email_posted === null || !is_email($mnnt_register_email_posted)) {
				
				$mnnt_register_error = __('Please enter a valid email address','main-entrance');
				return;
				
			}	
									
			//check password	
			if($mnnt_register_password_posted === null) {
				
				$mnnt_register_error = __('Please enter a password','main-entrance');
				return;
				
			}
			
			if(strlen($mnnt_register_password_posted) < 5) {
				
				$mnnt_register_error = __('Please enter a password of at least six characters','main-entrance');
				return;
				
			}
							
			if(!preg_match('/[A-Za-z]/', $mnnt_register_password_posted) || !preg_match('/[0-9]/', $mnnt_register_password_posted)) {
				
				$mnnt_register_error = __('Please enter a password with both letters and numbers','main-entrance');
				return;	
				
			}
			
			//check acceptance
			if(is_null($mnnt_register_dafult_acceptance_posted) || $mnnt_register_dafult_acceptance_posted !== 1) {
			
				$mnnt_register_error = __('Please, consent to the processing of your data for the described purposes','main-entrance');
				return;
				
			}	

			//check email exists
			if(/*$mnnt_register_email_posted != null && */email_exists($mnnt_register_email_posted)) {
				
				$mnnt_register_error = __('An account with this email is already registered','main-entrance').': <a href="?mnnt-action=login" title="'.__('Log In','main-entrance').'" alt="'.__('Log In','main-entrance').'">'.__('Log In','main-entrance').'</a> '.__('or','main-entrance').' <a href="?mnnt-action=lostpassword" title="'.__('Get a new password','main-entrance').'" alt="'.__('Get a new password','main-entrance').'">'.__('Get a new password','main-entrance').'</a>';
				return;
				
			}			
						
			//add filter to check custom user fields
            $mnnt_save_custom_fields = false;
            $mnnt_save_custom_fields_result = apply_filters('mnnt_registration_additional_fields_form_checks', false, $mnnt_options_array);
			//check
            if ($mnnt_save_custom_fields_result === false) {
                //no hooks hooked in: just continue execution
            }
            elseif ($mnnt_save_custom_fields_result === true) {
                //no errors occurred so far: set hook to save
                $mnnt_save_custom_fields = true;
            }
            else {
                //an error occurred
                $mnnt_register_error = $mnnt_save_custom_fields_result;
                return;
            }


			$mnnt_register_new_user_arguments = array(
			
				'user_login'	=>	$mnnt_register_email_posted,
				'user_email'	=>	$mnnt_register_email_posted,
				'user_pass'		=>	$mnnt_register_password_posted,
				'role'			=>  'main-entrance-user'

				);
		 
			$mnnt_register_new_user = wp_insert_user($mnnt_register_new_user_arguments);

			if(!is_wp_error($mnnt_register_new_user)){
				
				//hook on successful registration
				do_action('mnnt_user_registration', $mnnt_register_name_posted, $mnnt_register_surname_posted, $mnnt_register_email_posted);
					
				if(!is_null($mnnt_register_name_posted)) {
					
					update_user_meta($mnnt_register_new_user, '_mnnt_name', $mnnt_register_name_posted);
					update_user_meta($mnnt_register_new_user, 'first_name', $mnnt_register_name_posted);
					
				}
				
				if(!is_null($mnnt_register_surname_posted)) {
					
					update_user_meta($mnnt_register_new_user, '_mnnt_surname', $mnnt_register_surname_posted);
					update_user_meta($mnnt_register_new_user, 'last_name', $mnnt_register_surname_posted);
					
				}
				
				if(!is_null($mnnt_register_genre_posted)) {
					
					update_user_meta($mnnt_register_new_user, '_mnnt_genre', $mnnt_register_genre_posted);
					
				}
				
				if(!is_null($mnnt_register_date_of_birth_posted)) {
					
					update_user_meta($mnnt_register_new_user, '_mnnt_date_of_birth', $mnnt_register_date_of_birth_posted);
					
				}
				
				if(!is_null($mnnt_register_company_name_posted)) {
					
					update_user_meta($mnnt_register_new_user, '_mnnt_company_name', $mnnt_register_company_name_posted);
					
				}
				
				if(!is_null($mnnt_register_phone_number_posted)) {
					
					update_user_meta($mnnt_register_new_user, '_mnnt_phone_number', $mnnt_register_phone_number_posted);
					
				}

				if(!is_null($mnnt_register_state_posted)) {
										
					update_user_meta($mnnt_register_new_user, '_mnnt_state', $mnnt_register_state_posted);
					
				}
				
				if(!is_null($mnnt_register_country_posted)) {
										
					update_user_meta($mnnt_register_new_user, '_mnnt_country', $mnnt_register_country_posted);
					
				}
				
				if(!is_null($mnnt_register_address_posted)) {
										
					update_user_meta($mnnt_register_new_user, '_mnnt_address', $mnnt_register_address_posted);
					
				}

				//hook for external plugin to save meta, if needed
                if ($mnnt_save_custom_fields) {
                    do_action('mnnt_registration_additional_fields_form_save', $mnnt_register_new_user, $mnnt_options_array);
                }

				$mnnt_default_acceptance_doc_id = $mnnt_options_array['default_acceptance_doc_id'];
				
				update_user_meta($mnnt_register_new_user, '_mnnt_default_acceptance_doc_id', $mnnt_default_acceptance_doc_id);
				
				if(!is_null($mnnt_register_secondary_acceptance_posted) && $mnnt_register_secondary_acceptance_posted === 1) {
					
					if(!empty($mnnt_options_array['secondary_acceptance_doc_id'])) {
						
						$mnnt_secondary_acceptance_doc_id = $mnnt_options_array['secondary_acceptance_doc_id'];
						update_user_meta($mnnt_register_new_user, '_mnnt_secondary_acceptance_doc_id', $mnnt_secondary_acceptance_doc_id);
						
					}

					//hook on flag on secondary acceptance
					do_action('mnnt_secondary_acceptance', $mnnt_register_email_posted);					

				}
				
				$mnnt_register_involved_user = get_user_by('email',$mnnt_register_email_posted);
				
				if(!is_null($mnnt_register_name_posted)) {
					
					$mnnt_register_involved_user_name_with_space = ' '.esc_html($mnnt_register_name_posted);
					
				} else {
					
					$mnnt_register_involved_user_name_with_space = ' '.esc_html($mnnt_register_involved_user->display_name);				
				
				}
				
				
				$mnnt_login_url = get_permalink().'?mnnt-action=login';
							
				$mnnt_register_email_subject = __('Registration confirmed for','main-entrance').' '.get_bloginfo('name');
				$mnnt_register_email_body = '
					<html>
						<body>
							<p>
								'.__('Hello','main-entrance').$mnnt_register_involved_user_name_with_space.',
							</p>
							<p>
								'.__('Welcome to','main-entrance').' '.get_bloginfo('name').'!
							</p>
							<p>
								'.__('Now you can','main-entrance').' <a href="'.$mnnt_login_url.'" title="'.__('Log In','main-entrance').'" alt="'.__('Log In','main-entrance').'">'.__('Log In','main-entrance').'</a>
							</p>
							<p>
								<small><em>'.__('You consented to the processing of your data for the purposes described into attached disclaimer','main-entrance').'</em></small>
							</p>
						</body>
					</html>';
				$mnnt_register_email_headers = array('Content-Type: text/html; charset=UTF-8'); 
				
				if(!empty($mnnt_secondary_acceptance_doc_id)) {
					
					$mnnt_register_email_attachemnts = array(
						get_attached_file($mnnt_default_acceptance_doc_id),
						get_attached_file($mnnt_secondary_acceptance_doc_id)
					);
				
				} else {
					
					$mnnt_register_email_attachemnts = array(
						get_attached_file($mnnt_default_acceptance_doc_id)
					);					
					
				}
				
				wp_mail($mnnt_register_email_posted, $mnnt_register_email_subject, $mnnt_register_email_body, $mnnt_register_email_headers,$mnnt_register_email_attachemnts);	

				if(
					!empty($mnnt_options_array['notification_address']) 
				) {
				
					$mnnt_notification_email_recipient = $mnnt_options_array['notification_address'];
					
				} else {
					
					$mnnt_notification_email_recipient = get_option('admin_email');
					
				}

				$mnnt_notification_email_subject = __('New user registration','main-entrance').' '.get_bloginfo('name');
				$mnnt_notification_email_body = '
					<html>
						<body>
							<p>
								'.__('Hello','main-entrance').',
							</p>
							<p>
								'.__('a new user has just registered to','main-entrance').' '.get_bloginfo('name').'!
							</p>
							<p>
								'.__('User has filled out the following data','main-entrance').':
								<ul>
							';

						$mnnt_notification_email_body .= '
						
									<li>'.__('Email','main-entrance').': '.$mnnt_register_email_posted.'</li>
						
						';
								
						if(!is_null($mnnt_register_name_posted)) {
							
							$mnnt_notification_email_body .= '
							
									<li>'.__('Name','main-entrance').': '.$mnnt_register_name_posted.'</li>
							
							';
							
						}	
						
						if(!is_null($mnnt_register_surname_posted)) {
							
							$mnnt_notification_email_body .= '
							
									<li>'.__('Surname','main-entrance').': '.$mnnt_register_surname_posted.'</li>
							
							';
							
						}	
						
						if(!is_null($mnnt_register_genre_posted)) {
							
							$mnnt_notification_email_body .= '
							
									<li>'.__('Genre','main-entrance').': '.$mnnt_register_genre_posted.'</li>
							
							';
							
						}	

						if(!is_null($mnnt_register_date_of_birth_posted)) {
							
							$mnnt_notification_email_body .= '
							
									<li>'.__('Date of birth','main-entrance').': '.$mnnt_register_date_of_birth_posted.'</li>
							
							';
							
						}
						
						if(!is_null($mnnt_register_company_name_posted)) {
							
							$mnnt_notification_email_body .= '
							
									<li>'.__('Company Name','main-entrance').': '.$mnnt_register_company_name_posted.'</li>
							
							';
							
						}
						
						if(!is_null($mnnt_register_phone_number_posted)) {
							
							$mnnt_notification_email_body .= '
							
									<li>'.__('Phone Number','main-entrance').': '.$mnnt_register_phone_number_posted.'</li>
							
							';
							
						}

						if(!is_null($mnnt_register_state_posted)) {
							
							$mnnt_notification_email_body .= '
							
									<li>'.__('State','main-entrance').': '.$mnnt_register_state_posted.'</li>
							
							';
							
						}
						
						if(!is_null($mnnt_register_country_posted)) {
							
							$mnnt_notification_email_body .= '
							
									<li>'.__('Country','main-entrance').': '.$mnnt_register_country_posted.'</li>
							
							';
							
						}
						
						if(!is_null($mnnt_register_address_posted)) {
							
							$mnnt_notification_email_body .= '
							
									<li>'.__('Address','main-entrance').': '.$mnnt_register_address_posted.'</li>
							
							';
							
						}


                        //hook for external plugin to print meta in mail, if needed
                        if ($mnnt_save_custom_fields) {
                            $mnnt_notification_email_body .= apply_filters('mnnt_registration_additional_fields_form_email', '', $mnnt_register_new_user, $mnnt_options_array);
                        }

						$mnnt_notification_email_body .= '							
								</ul>
							</p>
							<p>
								'.__('User consented to the processing of his data for the purposes described into attached disclaimer','main-entrance').'
							</p>
						</body>
					</html>';
				$mnnt_notification_email_headers = array('Content-Type: text/html; charset=UTF-8'); 
				
				if(!empty($mnnt_secondary_acceptance_doc_id)) {
					
					$mnnt_notification_email_attachemnts = array(
						get_attached_file($mnnt_default_acceptance_doc_id),
						get_attached_file($mnnt_secondary_acceptance_doc_id)
					);
				
				} else {
					
					$mnnt_notification_email_attachemnts = array(
						get_attached_file($mnnt_default_acceptance_doc_id)
					);					
					
				}
				
				//clean white spaces
				$mnnt_notification_email_recipient = str_replace(' ','',$mnnt_notification_email_recipient);
				
				//check if recipient is a list
				if(strpos($mnnt_notification_email_recipient, ',') !== false){
				
					$mnnt_notification_email_recipient_array = explode(',', $mnnt_notification_email_recipient);
					
					foreach($mnnt_notification_email_recipient_array as $mnnt_notification_email_recipient){
						
						if(is_email($mnnt_notification_email_recipient)){
						
							wp_mail($mnnt_notification_email_recipient, $mnnt_notification_email_subject, $mnnt_notification_email_body, $mnnt_notification_email_headers,$mnnt_notification_email_attachemnts);
							
						}
						
					}
				
				} else {
				
					wp_mail($mnnt_notification_email_recipient, $mnnt_notification_email_subject, $mnnt_notification_email_body, $mnnt_notification_email_headers,$mnnt_notification_email_attachemnts);
					
				}		
				
				$mnnt_register_info = __('Registration completed successfully','main-entrance');
				
				$mnnt_page_id_to_redirect = $mnnt_options_array['redirect_after_registration'];
				
				if(!empty($mnnt_options_array['auto_login']) && $mnnt_options_array['auto_login'] === '1') {
				
					$mnnt_posted_data = array();
					$mnnt_posted_data['user_login'] = $mnnt_register_email_posted;
					$mnnt_posted_data['user_password'] = $mnnt_register_password_posted;
					$mnnt_posted_data['remember'] = true;		
					
					$mnnt_signon = wp_signon($mnnt_posted_data);					
					
					if(is_wp_error($mnnt_signon)){
						
						$mnnt_register_error = __('Auto log in failed, please try to log in manually','main-entrance');
									
					} else {
						
						if(!empty($mnnt_page_id_to_redirect) && is_numeric($mnnt_page_id_to_redirect) && $mnnt_page_id_to_redirect !== '0') {
						
							wp_safe_redirect(get_permalink($mnnt_page_id_to_redirect));
							
						} else {
							
							setcookie('mnnt-generic-success', '1', current_time( 'timestamp', 1 ) + 10);
							
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
						
						exit;
						
					}	

				} else  {
					
					if(!empty($mnnt_page_id_to_redirect) && is_numeric($mnnt_page_id_to_redirect) && $mnnt_page_id_to_redirect !== '0') {
					
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
							
						}

						else {
							
							wp_safe_redirect(get_site_url());
							
						}
						
						exit;
						
					}
					
				}					
				
			} else {
				
				$mnnt_register_error = __('Something went wrong, please try again later','main-entrance');
				
			}
		
	
		}
			
	}
	
	add_action('template_redirect','mnnt_check_register');

	
} else {
	
	error_log('function: "mnnt_check_register" already exists');
	
}