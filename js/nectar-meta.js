jQuery(document).ready(function($){
	

/*----------------------------------------------------------------------------------*/
/*	Display post format meta boxes as needed
/*----------------------------------------------------------------------------------*/
	
	
	$('#post-formats-select input').change(checkFormat);
	
	function checkFormat(){
		var format = $('#post-formats-select input:checked').attr('value');
		
		//only run on the posts page
		if(typeof format != 'undefined'){
			
			if(format == 'gallery'){
				$('#poststuff div[id$=slide][id^=post]').stop(true,true).fadeIn(500);
			}
			
			else {
				$('#poststuff div[id$=slide][id^=post]').stop(true,true).fadeOut(500);
			}
			
			$('#post-body div[id^=nectar-metabox-post-]').hide();
			$('#post-body #nectar-metabox-post-'+format+'').stop(true,true).fadeIn(500);
					
		}
	
	}
	
	$(window).load(function(){
		checkFormat();
	})
	
	//default gallery featured image hide
	$('#poststuff div[id$=slide][id^=post]').hide();
	
	
	
	/*----------------------------------------------------------------------------------*/
	/*	Take care of the unnecessary buttons on the slider post type edit page
	/*----------------------------------------------------------------------------------*/
	
	if( $('#nectar-metabox-home-slider').length > 0 ){
		$('#preview-action, #wp-admin-bar-view').hide();
		$('.wrap > #message.updated p').html('Slide Updated.');
	}
		
    
});

