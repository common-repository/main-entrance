jQuery(document).ready(function() {
			
	/*auothide messages*/
	var mnntSettingErrorHeight = jQuery('#setting-error-mnnt-message').height();
	
	if(mnntSettingErrorHeight > 0) {
		jQuery('#setting-error-mnnt-message').delay(2000).fadeTo( 100 , 0, function() {
			jQuery('#setting-error-mnnt-message').slideUp( mnntSettingErrorHeight, function() {
				jQuery('#setting-error-mnnt-message').remove();
			});
		});
	} 
	
	/*auothide waringns*/
	var mnntSettingInfoHeight = jQuery('#setting-error-mnnt-info').height();
	
	if(mnntSettingInfoHeight > 0) {
		jQuery('#setting-error-mnnt-info').delay(5000).fadeTo( 100 , 0, function() {
			jQuery('#setting-error-mnnt-info').slideUp( mnntSettingInfoHeight, function() {
				jQuery('#setting-error-mnnt-info').remove();
			});
		});
	} 
		
	/*prevent user to change page with unsaved changes*/
 	mnntFormChange = false; 
	window.onbeforeunload = function() {

		if (mnntFormChange) {
			return "Your unsaved data will be lost."; 
		};
		
	};
 
	jQuery("#mnnt-save-options").click(function() {
		mnntFormChange = false;
	});
 
	jQuery("#mnnt-settings-form").change(function() {
		mnntFormChange = true;
	});


	/*display secondary acceptance details only if option is set*/
	function checkSecondaryEnabled() {
		
		if(jQuery('#mnnt-secondary-acceptance').prop('checked')) {
			jQuery('.mnnt-secondary-acceptance-text').css('display','table-row')
			jQuery('.mnnt-secondary-acceptance-doc').css('display','table-row')
		} else {
			jQuery('.mnnt-secondary-acceptance-text').css('display','none')
			jQuery('.mnnt-secondary-acceptance-doc').css('display','none')
		}
		
	}	
	
	checkSecondaryEnabled();
	
	jQuery('#mnnt-secondary-acceptance').click(function() {
		
		checkSecondaryEnabled();
		
	});		
	
	/*display registrations options only if registration is enabled*/
	function checkRegistrationEnabled() {
		
		if (jQuery('#mnnt-allow-registration').prop('checked')) {
			jQuery('.mnnt-default-acceptance-text').css('display','table-row')
			jQuery('.mnnt-default-acceptance-doc').css('display','table-row')
			jQuery('.mnnt-secondary-acceptance').css('display','table-row')
			if(jQuery('#mnnt-secondary-acceptance').prop('checked')) {
				jQuery('.mnnt-secondary-acceptance-text').css('display','table-row')
				jQuery('.mnnt-secondary-acceptance-doc').css('display','table-row')
			} else {
				jQuery('.mnnt-secondary-acceptance-text').css('display','none')
				jQuery('.mnnt-secondary-acceptance-doc').css('display','none')
			}
			jQuery('.mnnt-role-slug').css('display','table-row')
			jQuery('.mnnt-auto-login').css('display','table-row')
			jQuery('.mnnt-redirect-after-registration').css('display','table-row')
			jQuery('.mnnt-registration-additional-fields').css('display','table-row')
			jQuery('.mnnt-notification-address').css('display','table-row')
			
		} else {
			jQuery('.mnnt-default-acceptance-text').css('display','none')
			jQuery('.mnnt-default-acceptance-doc').css('display','none')
			jQuery('.mnnt-secondary-acceptance').css('display','none')
			jQuery('.mnnt-secondary-acceptance-text').css('display','none')
			jQuery('.mnnt-secondary-acceptance-doc').css('display','none')
			jQuery('.mnnt-role-slug').css('display','none')
			jQuery('.mnnt-auto-login').css('display','none')
			jQuery('.mnnt-redirect-after-registration').css('display','none')
			jQuery('.mnnt-registration-additional-fields').css('display','none')
			jQuery('.mnnt-notification-address').css('display','none')
		}
		
	}	
	
	checkRegistrationEnabled();
	
	jQuery('#mnnt-allow-registration').click(function() {
		
		checkRegistrationEnabled();
		
	});	
	
	//show form hidden by css
	jQuery('#mnnt-settings-form').css('display','block');
	
	
	/*display page options only if icon is enabled*/
	function checkIconEnabled() {
		
		if (jQuery('#mnnt-icons-nav-bar').prop('checked')) {
			jQuery('.mnnt-icon-page-id').css('display','table-row')
		} else {
			jQuery('.mnnt-icon-page-id').css('display','none')
		}
		
	}	
	
	checkIconEnabled();
	
	jQuery('#mnnt-icons-nav-bar').click(function() {
		
		checkIconEnabled();
		
	});	
	
	//show form hidden by css
	jQuery('#mnnt-settings-form').css('display','block');
	
});