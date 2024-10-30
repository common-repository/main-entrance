<?php
//if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');


add_action( 'show_user_profile', 'mnnt_add_user_fields' );
add_action( 'edit_user_profile', 'mnnt_add_user_fields' );





//ADD USER FILEDS
if(!function_exists('mnnt_add_user_fields')){

	function mnnt_add_user_fields($user) {
		
		//this dependecies need only on admin pages
		if(!is_admin() || !current_user_can('create_users')) {
			
			return;
			
		}
		
		global $mnnt_options_array;
		$mnnt_fields_to_return = array();
		
		$mnnt_field_content_to_return = null;
		
		if(!empty($mnnt_options_array['genre_field']) && $mnnt_options_array['genre_field'] === '1') {

			$mnnt_genre_list_array = array(

					__('Undefined','main-entrance'), __('Male','main-entrance'), __('Female','main-entrance')

			);	
				
			$mnnt_posted_register_genre = esc_attr(get_the_author_meta('_mnnt_genre', $user->ID));

			$mnnt_field_content_to_return .= '
								

				<th><label for="mnnt-register-genre">'.__('Genre','main-entrance').'</label></th>
				<td>
				<select name="mnnt-register-genre" id="mnnt-register-genre" class="mnnt-input mnnt-register-genre">
				
				';
				
				foreach($mnnt_genre_list_array as $mnnt_current_genre){
					
					if(!empty($mnnt_posted_register_genre) && $mnnt_current_genre === $mnnt_posted_register_genre) {
					
						$mnnt_field_content_to_return .= '<option value="'.$mnnt_current_genre.'" selected>'.$mnnt_current_genre.'</option>';
						
					} elseif (empty($mnnt_posted_register_genre) && $mnnt_current_genre === __('Female','main-entrance')) {
						
						$mnnt_field_content_to_return .= '<option value="'.$mnnt_current_genre.'" selected>'.$mnnt_current_genre.'</option>';
							
					} else {
						
						$mnnt_field_content_to_return .= '<option value="'.$mnnt_current_genre.'">'.$mnnt_current_genre.'</option>';
							
					}
					
				}
				
				$mnnt_field_content_to_return .= '
				
				</select>
				</td>

			
			';		

			$mnnt_fields_to_return[] = $mnnt_field_content_to_return;			

		}
		
		$mnnt_field_content_to_return = null;
		
		if(!empty($mnnt_options_array['date_of_birth_field']) && $mnnt_options_array['date_of_birth_field'] === '1') {
				
			$mnnt_posted_register_date_of_birth = esc_attr(get_the_author_meta('_mnnt_date_of_birth', $user->ID));

			$mnnt_field_content_to_return .= '
								

				<th><label for="mnnt-register-date-of-birth">'.__('Date of birth','main-entrance').'</label></th>
				<td>
				<input type="date" name="mnnt-register-date-of-birth" id="mnnt-register-date-of-birth" class="mnnt-input mnnt-register-date-of-birth" value="'.$mnnt_posted_register_date_of_birth.'" autocorrect="off" autocapitalize="none">
				</td>

			';		

			$mnnt_fields_to_return[] = $mnnt_field_content_to_return;			

		}
		
		$mnnt_field_content_to_return = null;
		
		if(!empty($mnnt_options_array['company_name_field']) && $mnnt_options_array['company_name_field'] === '1') {
				
			$mnnt_posted_register_company_name = esc_attr(get_the_author_meta('_mnnt_company_name', $user->ID));

			$mnnt_field_content_to_return .= '
								

				<th><label for="mnnt-register-company-name">'.__('Company name','main-entrance').'</label></th>
				<td>
				<input type="text" name="mnnt-register-company-name" id="mnnt-register-company-name" class="regular-text mnnt-input mnnt-register-company-name" value="'.$mnnt_posted_register_company_name.'" autocorrect="off" autocapitalize="none">
				</td>

			';		

			$mnnt_fields_to_return[] = $mnnt_field_content_to_return;			

		}
		
		$mnnt_field_content_to_return = null;
		
		if(!empty($mnnt_options_array['phone_number_field']) && $mnnt_options_array['phone_number_field'] === '1') {
				
			$mnnt_posted_register_phone_number = esc_attr(get_the_author_meta('_mnnt_phone_number', $user->ID));

			$mnnt_field_content_to_return .= '
								

				<th><label for="mnnt-register-phone-number">'.__('Phone Number','main-entrance').'</label></th>
				<td>
				<input type="text" name="mnnt-register-phone-number" id="mnnt-register-phone-number" class="regular-text mnnt-input mnnt-register-phone-number" value="'.$mnnt_posted_register_phone_number.'" autocorrect="off" autocapitalize="none">
				</td>

			';		

			$mnnt_fields_to_return[] = $mnnt_field_content_to_return;			

		}
		
		$mnnt_field_content_to_return = null;
		
		if(!empty($mnnt_options_array['state_field']) && $mnnt_options_array['state_field'] === '1') {

			$mnnt_state_list_array = array(

					"AGRIGENTO", "ALESSANDRIA", "ANCONA", "AOSTA", "AREZZO", "ASCOLI PICENO", "ASTI", "AVELLINO", "BARI", "BARLETTA-ANDRIA-TRANI", "BELLUNO", "BENEVENTO", "BERGAMO", "BIELLA", "BOLOGNA", "BOLZANO", "BRESCIA", "BRINDISI", "CAGLIARI", "CALTANISSETTA", "CAMPOBASSO", "CARBONIA-IGLESIAS", "CASERTA", "CATANIA", "CATANZARO", "CHIETI", "COMO", "COSENZA", "CREMONA", "CROTONE", "CUNEO", "ENNA", "FERMO", "FERRARA", "FIRENZE", "FOGGIA", "FORLI’-CESENA", "FROSINONE", "GENOVA", "GORIZIA", "GROSSETO", "IMPERIA", "ISERNIA", "LA SPEZIA", "L’AQUILA", "LATINA", "LECCE", "LECCO", "LIVORNO", "LODI", "LUCCA", "MACERATA", "MANTOVA", "MASSA-CARRARA", "MATERA", "MEDIO CAMPIDANO", "MESSINA", "MILANO", "MODENA", "MONZA E BRIANZA", "NAPOLI", "NOVARA", "NUORO", "OGLIASTRA", "OLBIA-TEMPIO", "ORISTANO", "PADOVA", "PALERMO", "PARMA", "PAVIA", "PERUGIA", "PESARO E URBINO", "PESCARA", "PIACENZA", "PISA", "PISTOIA", "PORDENONE", "POTENZA", "PRATO", "RAGUSA", "RAVENNA", "REGGIO CALABRIA", "REGGIO EMILIA", "RIETI", "RIMINI", "ROMA", "ROVIGO", "SALERNO", "SASSARI", "SAVONA", "SIENA", "SIRACUSA", "SONDRIO", "TARANTO", "TERAMO", "TERNI", "TORINO", "TRAPANI", "TRENTO", "TREVISO", "TRIESTE", "UDINE", "VARESE", "VENEZIA", "VERBANO-CUSIO-OSSOLA", "VERCELLI", "VERONA", "VIBO VALENTIA", "VICENZA", "VITERBO"

			);		
				
			$mnnt_posted_register_state = esc_attr(get_the_author_meta('_mnnt_state', $user->ID));

			$mnnt_field_content_to_return .= '
								

				<th><label for="mnnt-register-state">'.__('State','main-entrance').'</label></th>
				<td>
				<select name="mnnt-register-state" id="mnnt-register-state" class="mnnt-input mnnt-register-state">
				
				';
				
				foreach($mnnt_state_list_array as $mnnt_current_state){
					
					if(!empty($mnnt_posted_register_state) && $mnnt_current_state === $mnnt_posted_register_state) {
					
						$mnnt_field_content_to_return .= '<option value="'.$mnnt_current_state.'" selected>'.$mnnt_current_state.'</option>';
						
					} elseif (empty($mnnt_posted_register_state) && $mnnt_current_state === __('COMO','main-entrance')) {
						
						$mnnt_field_content_to_return .= '<option value="'.$mnnt_current_state.'" selected>'.$mnnt_current_state.'</option>';
							
					} else {
						
						$mnnt_field_content_to_return .= '<option value="'.$mnnt_current_state.'">'.$mnnt_current_state.'</option>';
							
					}
					
				}
				
				$mnnt_field_content_to_return .= '
				
				</select>
				</td>

			
			';		

			$mnnt_fields_to_return[] = $mnnt_field_content_to_return;			

		}
		
		$mnnt_field_content_to_return = null;
		
		if(!empty($mnnt_options_array['country_field']) && $mnnt_options_array['country_field'] === '1') {

			$mnnt_country_list_array = array(

					"Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas (the)","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia (Plurinational State of)","Bonaire, Sint Eustatius and Saba","Bosnia and Herzegovina","Botswana","Bouvet Island","Brazil","British Indian Ocean Territory (the)","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cabo Verde","Cambodia","Cameroon","Canada","Cayman Islands (the)","Central African Republic (the)","Chad","Chile","China","Christmas Island","Cocos (Keeling) Islands (the)","Colombia","Comoros (the)","Congo (the Democratic Republic of the)","Congo (the)","Cook Islands (the)","Costa Rica","Croatia","Cuba","Curaçao","Cyprus","Czechia","Côte d'Ivoire","Denmark","Djibouti","Dominica","Dominican Republic (the)","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Eswatini","Ethiopia","Falkland Islands (the) [Malvinas]","Faroe Islands (the)","Fiji","Finland","France","French Guiana","French Polynesia","French Southern Territories (the)","Gabon","Gambia (the)","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guernsey","Guinea","Guinea-Bissau","Guyana","Haiti","Heard Island and McDonald Islands","Holy See (the)","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran (Islamic Republic of)","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Korea (the Democratic People's Republic of)","Korea (the Republic of)","Kuwait","Kyrgyzstan","Lao People's Democratic Republic (the)","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macao","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands (the)","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia (Federated States of)","Moldova (the Republic of)","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands (the)","New Caledonia","New Zealand","Nicaragua","Niger (the)","Nigeria","Niue","Norfolk Island","Northern Mariana Islands (the)","Norway","Oman","Pakistan","Palau","Palestine, State of","Panama","Papua New Guinea","Paraguay","Peru","Philippines (the)","Pitcairn","Poland","Portugal","Puerto Rico","Qatar","Republic of North Macedonia","Romania","Russian Federation (the)","Rwanda","Réunion","Saint Barthélemy","Saint Helena, Ascension and Tristan da Cunha","Saint Kitts and Nevis","Saint Lucia","Saint Martin (French part)","Saint Pierre and Miquelon","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Sint Maarten (Dutch part)","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia and the South Sandwich Islands","South Sudan","Spain","Sri Lanka","Sudan (the)","Suriname","Svalbard and Jan Mayen","Sweden","Switzerland","Syrian Arab Republic","Taiwan","Tajikistan","Tanzania, United Republic of","Thailand","Timor-Leste","Togo","Tokelau","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Turks and Caicos Islands (the)","Tuvalu","Uganda","Ukraine","United Arab Emirates (the)","United Kingdom of Great Britain and Northern Ireland (the)","United States Minor Outlying Islands (the)","United States of America (the)","Uruguay","Uzbekistan","Vanuatu","Venezuela (Bolivarian Republic of)","Viet Nam","Virgin Islands (British)","Virgin Islands (U.S.)","Wallis and Futuna","Western Sahara","Yemen","Zambia","Zimbabwe","Åland Islands"

			);	
				
			$mnnt_posted_register_country = esc_attr(get_the_author_meta('_mnnt_country', $user->ID));

			$mnnt_field_content_to_return .= '
								

				<th><label for="mnnt-register-country">'.__('Country','main-entrance').'</label></th>
				<td>
				<select name="mnnt-register-country" id="mnnt-register-country" class="mnnt-input mnnt-register-country">
				
				';
				
				foreach($mnnt_country_list_array as $mnnt_current_country){
					
					if(!empty($mnnt_posted_register_country) && $mnnt_current_country === $mnnt_posted_register_country) {
					
						$mnnt_field_content_to_return .= '<option value="'.$mnnt_current_country.'" selected>'.$mnnt_current_country.'</option>';
						
					} elseif (empty($mnnt_posted_register_country) && $mnnt_current_country === __('Italy','main-entrance')) {
						
						$mnnt_field_content_to_return .= '<option value="'.$mnnt_current_country.'" selected>'.$mnnt_current_country.'</option>';
							
					} else {
						
						$mnnt_field_content_to_return .= '<option value="'.$mnnt_current_country.'">'.$mnnt_current_country.'</option>';
							
					}
					
				}
				
				$mnnt_field_content_to_return .= '
				
				</select>
				</td>

			
			';		

			$mnnt_fields_to_return[] = $mnnt_field_content_to_return;			

		}
		
		$mnnt_field_content_to_return = null;
		
		if(!empty($mnnt_options_array['address_field']) && $mnnt_options_array['address_field'] === '1') {
				
			$mnnt_posted_register_address = esc_attr(get_the_author_meta('_mnnt_address', $user->ID));

			$mnnt_field_content_to_return .= '
								

				<th><label for="mnnt-register-address">'.__('Address','main-entrance').'</label></th>
				<td>
				<input type="text" name="mnnt-register-address" id="mnnt-register-address" class="regular-text mnnt-input mnnt-register-address" value="'.$mnnt_posted_register_address.'" autocorrect="off" autocapitalize="none">
				</td>

			';		

			$mnnt_fields_to_return[] = $mnnt_field_content_to_return;			

		}

		?>
		
			<h3><?php echo 'Main Entrance '.__('custom user fields', 'main-entrance'); ?></h3>

			<table class="form-table">
			
			<?php
			
				foreach($mnnt_fields_to_return as $mnnt_field_to_return){
					
					?>
					
					<tr>
	
						<?php
						
						echo $mnnt_field_to_return;
						
						?>

					</tr>					
					
					<?php
					

				}
				
				?>

			</table>

		
		<?php	
				
	}		
	
} else {
	
	error_log('function: "mnnt_add_user_fields" already exists');
	
}