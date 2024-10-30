jQuery(document).ready(function() {
			
	/*auothide error messages*/
	var mnntErrorHeight = jQuery('#mnnt-error').height();
	var mnntInfoHeight = jQuery('#mnnt-info').height();
	
	if(mnntErrorHeight > 0) {
		jQuery('#mnnt-error').delay(6000).fadeTo(100 , 0, function() {
			jQuery('#mnnt-error').slideUp( mnntErrorHeight, function() {
				jQuery('#mnnt-error').remove();
			});
		});
	} 
	
	if(mnntInfoHeight > 0) {
		jQuery('#mnnt-info').delay(6000).fadeTo(100 , 0, function() {
			jQuery('#mnnt-info').slideUp( mnntInfoHeight, function() {
				jQuery('#mnnt-info').remove();
			});
		});
	} 
		
	
});