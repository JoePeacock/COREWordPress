jQuery(document).ready(function($){
	
/*-------------------------------------------------------------------------

	1.	Plugin Init
	2.	Helper Functions
	3.	Shortcode Stuff
	4.	Header + Search
	5.	Page Specific
	6.  Scroll to top
	7.	Cross Browser Fixes


-------------------------------------------------------------------------*/


/*-------------------------------------------------------------------------*/
/*	1.	Plugin Init
/*-------------------------------------------------------------------------*/

/***************** Pretty Photo ******************/

	function prettyPhotoInit(){
		
		$("a.pp").prettyPhoto({
			theme: 'dark_rounded',
			allow_resize: true,
			default_width: 690,
			default_height: 388,
			social_tools: '',
			markup: '<div class="pp_pic_holder"> \
						   <div class="ppt">&nbsp;</div> \
							<div class="pp_details"> \
								<div class="pp_nav"> \
									<a href="#" class="pp_arrow_previous">Previous</a> \
									<p class="currentTextHolder">0/0</p> \
									<a href="#" class="pp_arrow_next">Next</a> \
								</div> \
								<a class="pp_close" href="#">Close</a> \
							</div> \
							<div class="pp_content_container"> \
								<div class="pp_left"> \
								<div class="pp_right"> \
									<div class="pp_content"> \
										<div class="pp_fade"> \
											<div class="pp_hoverContainer"> \
												<a class="pp_next" href="#">next</a> \
												<a class="pp_previous" href="#">previous</a> \
											</div> \
											<div id="pp_full_res"></div> \
										</div> \
									</div> \
								</div> \
								</div> \
							</div> \
						</div> \
						<div class="pp_loaderIcon"></div> \
						<div class="pp_overlay"></div>'
		});
		
	}
	
	prettyPhotoInit();
	

	
/***************** Smooth Scrolling ******************/

	function niceScrollInit(){
		$("html").niceScroll({
			scrollspeed: 60,
			mousescrollstep: 35,
			cursorwidth: 15,
			cursorborder: 0,
			cursorcolor: '#2D3032',
			cursorborderradius: 6,
			autohidemode: false
		});
		
		$('body, body #header-outer').css('padding-right','16px');
	}
	
	var $smoothActive = $('body').attr('data-smooth-scrolling'); 
	if( $smoothActive == 1 && $(window).width() > 690){ niceScrollInit(); }
	
	


/***************** Sliders ******************/

	var sliderAdvanceSpeed = parseInt($('#featured').attr('data-advance-speed'));
	var sliderAnimationSpeed = parseInt($('#featured').attr('data-animation-speed'));
	var sliderAutoplay = parseInt($('#featured').attr('data-autoplay'));
	
	if( isNaN(sliderAdvanceSpeed) ) { sliderAdvanceSpeed = 5500;}
	if( isNaN(sliderAnimationSpeed) ) { sliderAnimationSpeed = 800;}
	
	var $yPos;

	var img_urls=[];
	$('[style*="background"]').each(function() {
	    var style = $(this).attr('style');
	    var pattern = /background.*?url\('(.*?)'\)/g
	    var match = pattern.exec(style);
	    if (match) {        
	        img_urls.push(match[1]);
	    }
	});
	
	var imgArray = [];
	
	for(i=0;i<img_urls.length;i++){
		imgArray[i] = new Image();
		imgArray[i].src = img_urls[i];
	}
	

	$(window).load(function(){
		//home slider
		 $('#featured').orbit({
         	 animation: 'fade',
         	 advanceSpeed: sliderAdvanceSpeed,
         	 animationSpeed: sliderAnimationSpeed, 
         	 timer: sliderAutoplay
    	 });
    	 
    	 $('#featured article .post-title h2 span').show();
    		 
    	////add hover effect to slider nav
    	$('.slider-nav > span').append('<span class="white"></span><span class="shadow"></span>');	
    	

    	////swipe for home slider
    	$('#featured').swipe({
    		swipeLeft : function(e) {
				$('.slider-nav .left').trigger('click');
				e.stopImmediatePropagation();
				return false;
			 },
			 swipeRight : function(e) {
				$('.slider-nav .right').trigger('click');
				e.stopImmediatePropagation();
				return false;
			 }    
    	})
    	
    	customSliderHeight();
		sliderAfterSetup();
		
    	//gallery
    	 $('.flex-gallery').flexslider({
	        animation: 'fade',
	        controlsContainer: '.flexslider',
	        smoothHeight: true, 
	        touch: true
	    });
    	
    	////gallery slider span add
		$('.flex-gallery .flex-direction-nav li a').append('<span>');

	});
	
	
	//home slider height
	var sliderHeight = parseInt($('#featured').attr('data-slider-height'));
	if( isNaN(sliderHeight) ) { sliderHeight = 450 } else { sliderHeight = sliderHeight -12 }; 

	function customSliderHeight(){
		if(!$('body').hasClass('mobile')){
			$('#featured').attr('style', 'height: '+sliderHeight+'px !important');
			$('#featured article').css('height',sliderHeight+'px')
		}
		else {
			$('#featured').attr('style', 'height: '+sliderHeight+'px');
		}
	}
	
	customSliderHeight();
	
	
	//home slider bg color
	if( $('#featured').length > 0 ){
		var sliderBackgroundColor = $('#featured').attr('data-bg-color');
		if( sliderBackgroundColor.length == 0 ) sliderBackgroundColor = '#000000'; 
		
		$('#featured article').css('background-color',sliderBackgroundColor);
	}
	
/***************** Parallax Slider ******************/
	
	//take into account header height when calculating the controls and info positioning 
	var logoHeight = parseInt($('#header-outer').attr('data-logo-height'));
	var headerPadding = parseInt($('#header-outer').attr('data-padding'));
	var headerPadding2 = parseInt($('#header-outer').attr('data-padding'));
	var extraDef = 15;
	var headerResize = $('#header-outer').attr('data-header-resize');
	var extraHeight = ($('#wpadminbar').length > 0) ? 28 : 0; //admin bar
	var usingLogoImage = true;

	if( isNaN(logoHeight) ) { usingLogoImage = false; logoHeight = 30;}
	if( isNaN(headerPadding) ) { headerPadding = 28; headerPadding2 = 28;}
	if( true ) {headerPadding2 = headerPadding*2; extraDef = 0;}

	var $captionPos = (((sliderHeight-70)/2 - $('div.slider-nav span.left span.white').height()/2) + logoHeight + headerPadding*2 + extraHeight) - 40;
	var $controlsPos = (((sliderHeight-70)/2 - $('div.slider-nav span.left span.white').height()/2) + logoHeight + headerPadding*2 + extraHeight) -10;
	
	var $scrollTop;
	
	//inital load
	function sliderAfterSetup(){
		$('body:not(.mobile) .orbit-wrapper #featured .orbit-slide article .container').css('top', $captionPos +"px");
		$('body:not(.mobile) .orbit-wrapper .slider-nav > span').css('top', $controlsPos +"px");	
		$('body:not(.mobile) .orbit-wrapper #featured .slide article').css({'background-position': 'center ' });
	}
	
	//dynamic controls and info positioning
	function controlsAndInfoPos(){
		$scrollTop = $(window).scrollTop();
		
		$('body:not(.mobile) .orbit-wrapper #featured .orbit-slide article .container').css({ 
			'opacity' : 1-($scrollTop/400),
			'top' : ($scrollTop*-0.4) + $captionPos +"px"
		});
		
		$('body:not(.mobile) .orbit-wrapper .slider-nav > span').css({ 
			'opacity' : 1-($scrollTop/400),
			'top' : ($scrollTop*-0.4) + $controlsPos +"px"
		});
	}
	
	if( $('#featured').length > 0 ){
	
		$(window).scroll(function(){
		   
		    controlsAndInfoPos();

			$('body:not(.mobile) .orbit-wrapper #featured .slide article').css({'background-position': 'center ' });	
		});
		
		//disable parallax for mobile
		$(window).resize(function(){
			if($('body').hasClass('mobile')){
				$('.orbit-wrapper #featured article').css('backgroundPosition','center 60%');
			}
			
			else {
				$('.orbit-wrapper #featured article').css('backgroundPosition','center ' + ((- $scrollTop / 5)+logoHeight+headerPadding2+extraHeight-extraDef)  + 'px');
			}
			
			customSliderHeight();
		});
		
	}



/***************** Superfish ******************/

	function initSF(){

		$(".sf-menu").superfish({
			 delay:  100,
			 autoArrows:    true,
			 speed: 'fast',
			 animation:   {opacity:'show'}
		}); 
	}
	
	function addOrRemoveSF(){
		
		if( $(window).width() <= 1000 ){
			$('body').addClass('mobile');
			$('header#top nav').hide();
		}
		
		else {
			$('body').removeClass('mobile');
			$('header#top nav').show();
			$('#mobile-menu').hide();
		}
	}
	
	addOrRemoveSF();
	initSF();
	
	$(window).resize(addOrRemoveSF);
	

	//turn dropdown arrows into font awesome
	$('nav > ul.sf-menu > li').each(function(){
		$(this).find(' > a > .sf-sub-indicator').html('<i class="icon-angle-down"></i>');
	});
	
	function SFArrows(){

		$('nav > ul.sf-menu > li > ul li').each(function(){
			$(this).find(' > a > .sf-sub-indicator').html('<i class="icon-angle-right"></i>');
		});	
	
		//set height of dropdown arrow
		$('.sf-sub-indicator').css('height',$('a.sf-with-ul').height());
	}
	
	SFArrows();
	

	


/***************** Caroufredsel ******************/

    $(window).load(function(){
    	

    	$('.carousel:not(".clients")').each(function(){
	    	var $that = $(this);
	    	var scrollSpeed, easing;
					
			(parseInt($(this).attr('data-scroll-speed'))) ? scrollSpeed = parseInt($(this).attr('data-scroll-speed')) : scrollSpeed = 700;
			($(this).attr('data-easing').length > 0) ? easing = $(this).attr('data-easing') : easing = 'linear';
			
	    	$(this).carouFredSel({
	    		circular: true,
	    		responsive: true,
		        items       : {
					width : 353,
			        visible     : {
			            min         : 1,
			            max         : 3
			        }
			    },
			    swipe       : {
			        onTouch     : true
			    },
			    scroll: {
			    	easing          : easing,
		            duration        : scrollSpeed
			    },
		        prev    : {
			        button  : function() {
			           return $that.parents('.carousel-wrap').prev(".carousel-heading").find('.carousel-prev');
			        }
		    	},
			    next    : {
		       		button  : function() {
			           return $that.parents('.carousel-wrap').prev(".carousel-heading").find('.carousel-next');
			        }
			    },
			    auto    : {
			    	play: false
			    }
		    }).animate({'opacity': 1},1300);
	    });
	    
	    piVertCenter();
	

	     $('.carousel.clients').each(function(){
	    	var $that = $(this);
	    	var columns;
	    	(parseInt($(this).attr('data-max'))) ? columns = parseInt($(this).attr('data-max')) : columns = 5;
	    	if($(window).width() < 690) { columns = 2; $(this).addClass('phone') }
	    	
	    	$(this).carouFredSel({
		    		circular: true,
		    		responsive: true,
			        items       : {
						
						height : $that.find('> div:first').height(),
						width  : $that.find('> div:first').width(),
				        visible     : {
				            min         : 1,
				            max         : columns
				        }
				    },
				    swipe       : {
				        onTouch     : true
				    },
				    scroll: {
				    	items           : 1,
				    	easing          : 'easeInOutCubic',
			            duration        : '800',
			            pauseOnHover    : true
				    },
				    auto    : {
				    	play            : true,
				    	timeoutDuration : 2700
				    }
		    }).animate({'opacity': 1},1300);
	
	    });
	    
	    
	    //cients carousel height
	    if($('.carousel.clients').length>0) {
	  		$(window).resize(function(){
	  			
	  			var tallestImage = 0;
	  			
		    	 $('.carousel.clients').each(function(){
		    	 	
		    	 	$(this).find('> div').each(function(){
						($(this).height() > tallestImage) ? tallestImage = $(this).height() : tallestImage = tallestImage;
					});	
		    	 	
		         	$(this).css('height',tallestImage);
		         	$(this).parent().css('height',tallestImage);
		         });
	   	    });  	
	    }
	    
	    
    
    });

    
    var resizeTimer = null;
    $(window).resize(function() {
        resizeTimer && clearTimeout(resizeTimer); 
        resizeTimer = setTimeout(function() {
          		
             piVertCenter();
                  
        }, 60);
    });
	
	
/*-------------------------------------------------------------------------*/
/*	2.	Helper Functions
/*-------------------------------------------------------------------------*/

	jQuery.fn.setCursorPosition = function(position){
	    if(this.lengh == 0) return this;
	    return $(this).setSelection(position, position);
	}
	
	jQuery.fn.setSelection = function(selectionStart, selectionEnd) {
	    if(this.lengh == 0) return this;
	    input = this[0];
	
	    if (input.createTextRange) {
	        var range = input.createTextRange();
	        range.collapse(true);
	        range.moveEnd('character', selectionEnd);
	        range.moveStart('character', selectionStart);
	        range.select();
	    } else if (input.setSelectionRange) {
	        input.focus();
	        input.setSelectionRange(selectionStart, selectionEnd);
	    }
	
	    return this;
	}
	
	
	$.belowthefold = function(element, settings) {
        var fold = $(window).height() + $(window).scrollTop();
        return fold <= $(element).offset().top - settings.threshold;
    };

    $.abovethetop = function(element, settings) {
        var top = $(window).scrollTop();
        return top >= $(element).offset().top + $(element).height() - settings.threshold;
    };
    
    $.rightofscreen = function(element, settings) {
        var fold = $(window).width() + $(window).scrollLeft();
        return fold <= $(element).offset().left - settings.threshold;
    };
    
    $.leftofscreen = function(element, settings) {
        var left = $(window).scrollLeft();
        return left >= $(element).offset().left + $(element).width() - settings.threshold;
    };
    
    $.inviewport = function(element, settings) {
        return !$.rightofscreen(element, settings) && !$.leftofscreen(element, settings) && !$.belowthefold(element, settings) && !$.abovethetop(element, settings);
    };
    
    $.extend($.expr[':'], {
        "below-the-fold": function(a, i, m) {
            return $.belowthefold(a, {threshold : 0});
        },
        "above-the-top": function(a, i, m) {
            return $.abovethetop(a, {threshold : 0});
        },
        "left-of-screen": function(a, i, m) {
            return $.leftofscreen(a, {threshold : 0});
        },
        "right-of-screen": function(a, i, m) {
            return $.rightofscreen(a, {threshold : 0});
        },
        "in-viewport": function(a, i, m) {
            return $.inviewport(a, {threshold : 0});
        }
    });
	
		
/*-------------------------------------------------------------------------*/
/*	3.	Shortcode Stuff
/*-------------------------------------------------------------------------*/
	
/***************** Tabbed ******************/

	$('.tabbed ul li a').click(function(){
		var $id = $(this).attr('href');
		
		if(!$(this).hasClass('active-tab')){
			$('.tabbed ul li a').removeClass('active-tab');
			$(this).addClass('active-tab');
			
			$('.tabbed > div').hide();
			$('.tabbed > div'+$id).fadeIn(400);	
		}
		return false;
	});
	
	$('.tabbed ul li:first-child a').click();
	
	
/***************** Toggle ******************/

	$('.toggle h3 a').click(function(){
		$(this).parents('.toggle').find('> div').slideToggle(300);
		$(this).parents('.toggle').toggleClass('open');
		return false;
	});
	
	
/***************** Checkmarks ******************/

	$('ul.checks li').prepend('<span></span>');
	
	
	
/***************** 4 Col Grid in iPad ******************/

	$('.col.span_3').each(function(){
		var $currentDiv = $(this);
		var $nextDiv = $(this).next('div');
		if( $nextDiv.hasClass('span_3') && !$currentDiv.hasClass('one-fourths')) {
			$currentDiv.addClass('one-fourths clear-both');
			$nextDiv.addClass('one-fourths right-edge');
		}
	});
	
	
/***************** Bar Graph ******************/
	var animatedCount = 0;
	var barCount = 0;
	
	function animateBar(){

		$('.bar_graph li:in-viewport:not(".animated")').each(function(i){
			var percent = $(this).find('span').attr('data-width');

			$(this).addClass('animated');
			
			$(this).find('span').animate({
				'width' : percent + '%'
			},1700, 'easeOutCirc',function(){
			});
			
			$(this).find('span strong').animate({
				'opacity' : 1
			},1400);	
			
			////100% progress bar 
			if(percent == '100'){
				$(this).find('span strong').addClass('full');
			}
			
			animatedCount++;
			
			if(animatedCount == barCount){
				clearInterval(barAnimation);
			}
			
		});
	
	}
	
	
	
	if( $('.bar_graph').length > 0 ){
		//store the total number of bars that need animating
		$('.bar_graph').each(function(){
			barCount += $(this).find('li').length;
		});
		
		var barAnimation = setInterval(animateBar, 150);
		animateBar();
		
	}	
	

/***************** Pricing Tables ******************/


var $tallestCol;

$('.pricing-table').each(function(){
	
	$tallestCol = 0;
	
	$(this).find('> div .features').each(function(){
		($(this).height() > $tallestCol) ? $tallestCol = $(this).height() : $tallestCol = $tallestCol;
	});	
	
	//set even height
	$(this).find('> div .features').css('height',$tallestCol);
	
});



/***************** External Embed ******************/

//this isn't the for the video shortcode* This is to help any external iframe embed fit & resize correctly 
$('iframe').wrap('<div class="iframe-embed"/>');


//unwrap post and protfolio videos
$('.video-wrap iframe').unwrap();

/*-------------------------------------------------------------------------*/
/*	4.	Header + Search
/*-------------------------------------------------------------------------*/	


/***************** Search ******************/
	var $placeholder = $('#search input[type=text]').attr('data-placeholder');
	var logoHeight = parseInt($('#header-outer').attr('data-logo-height'));
	
	////search box event
	$('#search-btn').mousedown(function(){
		
		$(this).removeClass();
		
		$('#header-outer #search-outer').stop(true).fadeIn(500,'easeOutExpo');
		
		$('#search-outer > #search input[type="text"]').css({
			'top' : $('#search-outer').height()/2 - $('#search-outer > #search input[type="text"]').height()/2
		});
		
		$('#search input[type=text]').focus();
		
		if($('#search input[type=text]').attr('value') == $placeholder){
			$('#search input[type=text]').setCursorPosition(0);	
		}

		return false;
	});
	
	$('#search input[type=text]').keydown(function(){
		if($(this).attr('value') == $placeholder){
			$(this).attr('value', '');
		}
	});
	
	$('#search input[type=text]').keyup(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', $placeholder);
			$(this).setCursorPosition(0);
		}
	});
	
	
	////close search btn event
	$('#close').click(function(){
		
		closeSearch();
		return false;
	});

	//if user clicks away from the search close it
	$('#search-box input[type=text]').blur(function(e){
		closeSearch();
	});
	
	
	function closeSearch(){
		$('#header-outer #search-outer').stop(true).fadeOut(350,'easeOutExpo');
	}
	
	
	//mobile search
	$('#mobile-menu #mobile-search .container a#show-search').click(function(){
		$('#mobile-menu .container > ul').slideUp(500);
		return false;
	});
	
/***************** Nav ******************/
	
	var logoHeight = parseInt($('#header-outer').attr('data-logo-height'));
	var headerPadding = parseInt($('#header-outer').attr('data-padding'));
	var usingLogoImage = $('#header-outer').attr('data-using-logo');
	
	if( isNaN(headerPadding) || headerPadding.length == 0 ) { headerPadding = 28; }
	if( isNaN(logoHeight) || usingLogoImage.length == 0 ) { usingLogoImage = false; logoHeight = 30;}
	
	//inital calculations
	function headerInit() {
			
		$('#header-outer #logo img').css({
			'height' : logoHeight,				
		});	
		
		$('#header-outer').css({
			'padding-top' : headerPadding
		});	
		
		$('header#top nav > ul > li > a').css({
			'padding-bottom' : ((logoHeight/2) - ($('header#top nav > ul > li > a').height()/2)) + headerPadding,
			'padding-top' : (logoHeight/2) - ($('header#top nav > ul > li > a').height()/2)
		});	
		
		$('header#top nav > ul li#search-btn').css({
			'padding-bottom' : (logoHeight/2) - ($('header#top nav > ul li#search-btn a').height()/2),
			'padding-top' : (logoHeight/2) - ($('header#top nav > ul li#search-btn a').height()/2)
		});	
		
		
		$('header#top .sf-menu > li > ul, header#top .sf-menu > li.sfHover > ul').css({
			'top' : $('header#top nav > ul > li > a').outerHeight() 
		});	
		
		$('#header-space').css('height', $('#header-outer').outerHeight() + 33 );
		
		$('#header-outer .container').css('visibility','visible');
		
		
		$('#search-outer').css({
			'height' : logoHeight + headerPadding*2
		});	
		
		$('#search-outer > #search input[type="text"]').css({
			'font-size'  : 43,
			'top' : ((logoHeight + headerPadding*2)/2) - $('#search-outer > #search input[type="text"]').height()/2
		});
		
		$('#search-outer > #search #close a').css({
			'top' : ((logoHeight + headerPadding*2)/2) - 8
		});	
		
		
		//if no image is being used
		if(usingLogoImage == false) $('header#top #logo').css('margin-top','4px');
		
	}
	
	
	//is header resize on scroll enabled?
	var headerResize = $('#header-outer').attr('data-header-resize');
	if( headerResize == 1 ){
		
		headerInit();
		
		$(window).bind('scroll',smallNav);
		
		//if user starts in mobile but resizes to large, don't break the nav
		if($('body').hasClass('mobile')){
			$(window).resize(headerInit);
		}
		
	}
	
	else {
		headerInit();
	}
		

	function smallNav(){
		var $offset = $(window).scrollTop();
		var $windowWidth = $(window).width();
		var shrinkNum = 6;
		
		if (logoHeight >= 40 && logoHeight < 60) shrinkNum = 8;
		else if (logoHeight >= 60 && logoHeight < 80) shrinkNum = 10;
		else if (logoHeight >= 80 ) shrinkNum = 14;
		
		if($offset > 0 && $windowWidth >= 1000) {
			
			$('#header-outer #logo img').stop(true,true).animate({
				'height' : logoHeight - shrinkNum
			},{queue:false, duration:250, easing: 'easeOutCubic'});	
				
			$('#header-outer').stop(true,true).animate({
				'padding-top' : headerPadding / 1.8
			},{queue:false, duration:450, easing: 'easeOutExpo'});	
			
			$('header#top nav > ul > li > a').stop(true,true).animate({
				'padding-bottom' : (((logoHeight-shrinkNum)/2) - ($('header#top nav > ul > li > a').height()/2)) + headerPadding / 1.8,
				'padding-top' : ((logoHeight-shrinkNum)/2) - ($('header#top nav > ul > li > a').height()/2)
			},{queue:false, duration:450, easing: 'easeOutExpo'});	
			
			$('header#top nav > ul li#search-btn').stop(true,true).animate({
				'padding-bottom' : ((logoHeight-shrinkNum)/2) - ($('header#top nav > ul li#search-btn a').height()/2),
				'padding-top' : ((logoHeight-shrinkNum)/2) - ($('header#top nav > ul li#search-btn a').height()/2)
			},{queue:false, duration:450, easing: 'easeOutExpo'});	
			
			$('header#top .sf-menu > li > ul, header#top .sf-menu > li.sfHover > ul').stop(true,true).animate({
				'top' : Math.floor($('header#top nav > ul > li > a').height() + (((logoHeight-shrinkNum)/2) - ($('header#top nav > ul > li > a').height()/2))*2 + headerPadding / 1.8),
			},{queue:false, duration:450, easing: 'easeOutExpo'});	
			
		

			$('#search-outer').stop(true,true).animate({
				'height' : (logoHeight-shrinkNum) + headerPadding
			},{queue:false, duration:450, easing: 'easeOutExpo'});	
			
			$('#search-outer > #search input[type="text"]').stop(true,true).animate({
				'font-size'  : 30,
				'line-height' : '30px',
				'top' : ((logoHeight-shrinkNum+headerPadding+5)/2) - ($('#search-outer > #search input[type="text"]').height()-15)/2
			},{queue:false, duration:450, easing: 'easeOutExpo'});	
			

			
			$('#search-outer > #search #close a, #search-outer > #search #close span').stop(true,true).animate({
				'top' : ((logoHeight-shrinkNum + headerPadding+5)/2) - 8
			},{queue:false, duration:450, easing: 'easeOutExpo'});	
			
			
			//if no image is being used
			if(usingLogoImage == false) $('header#top #logo').stop(true,true).animate({
				'margin-top' : 0
			},{queue:false, duration:450, easing: 'easeOutExpo'});	
			
			$(window).unbind('scroll',smallNav);
			$(window).bind('scroll',bigNav);
		}
	}
	
	function bigNav(){
		var $offset = $(window).scrollTop();
		var $windowWidth = $(window).width();
		if($offset == 0 && $windowWidth >= 1000) {
			
			$('#header-outer #logo img').stop(true,true).animate({
				'height' : logoHeight,				
			},{queue:false, duration:450, easing: 'easeOutExpo'});	
			

			$('#header-outer').stop(true,true).animate({
				'padding-top' : headerPadding 
			},{queue:false, duration:450, easing: 'easeOutExpo'});	
			
			$('header#top nav > ul > li > a').stop(true,true).animate({
				'padding-bottom' : ((logoHeight/2) - ($('header#top nav > ul > li > a').height()/2)) + headerPadding,
				'padding-top' : (logoHeight/2) - ($('header#top nav > ul > li > a').height()/2)
			},{queue:false, duration:450, easing: 'easeOutExpo'});	
			
			$('header#top nav > ul li#search-btn').stop(true,true).animate({
				'padding-bottom' : (logoHeight/2) - ($('header#top nav > ul li#search-btn a').height()/2),
				'padding-top' : (logoHeight/2) - ($('header#top nav > ul li#search-btn a').height()/2)
			},{queue:false, duration:450, easing: 'easeOutExpo'});	
			
			
			$('header#top .sf-menu > li > ul, header#top .sf-menu > li.sfHover > ul').stop(true,true).animate({
				'top' : $('header#top nav > ul > li > a').height() + (((logoHeight)/2) - ($('header#top nav > ul > li > a').height()/2))*2 + headerPadding,
			},{queue:false, duration:450, easing: 'easeOutExpo'});	
			
			
			
			$('#search-outer').stop(true,true).animate({
				'height' : logoHeight + headerPadding*2
			},{queue:false, duration:450, easing: 'easeOutExpo'});	
			
			$('#search-outer > #search input[type="text"]').stop(true,true).animate({
				'font-size'  : 43,
				'line-height' : '43px',
				'top' : ((logoHeight + headerPadding*2)/2) - 30
			},{queue:false, duration:450, easing: 'easeOutExpo'});	
			
			
			$('#search-outer > #search #close a, #search-outer > #search #close span').stop(true,true).animate({
				'top' : ((logoHeight + headerPadding*2)/2) - 8
			},{queue:false, duration:450, easing: 'easeOutExpo'});	
			
			//if no image is being used
			if(usingLogoImage == false) $('header#top #logo').stop(true,true).animate({
				'margin-top' : 4
			},{queue:false, duration:450, easing: 'easeOutExpo'});	
		
			$(window).unbind('scroll',bigNav);
			$(window).bind('scroll',smallNav);
		}
	}
	
	
	
	//responsive nav
	$('#toggle-nav').click(function(){
		
		$('#mobile-menu').stop(true,true).slideToggle(500);
		return false;
	});
	
	////append dropdown indicators / give classes
	$('#mobile-menu .container ul li').each(function(){
		if($(this).find('> ul').length > 0) {
			 $(this).addClass('has-ul');
			 $(this).find('> a').append('<span class="sf-sub-indicator"><i class="icon-angle-down"></i></span>');
		}
	});
	
	////events
	$('#mobile-menu .container ul li:has(">ul") > a').click(function(){
		$(this).parent().toggleClass('open');
		$(this).parent().find('> ul').stop(true,true).slideToggle();
		return false;
	});
	
	
	
	
/***************** Page Headers ******************/

var pageHeaderHeight = parseInt($('#page-header-bg').attr('data-height'));

//set the user defined height
$('#page-header-bg').css('height',pageHeaderHeight+'px');
	
function pageHeader(){
	
	if(!$('body').hasClass('mobile')){
		
		//recalc
		pageHeaderHeight = parseInt($('#page-header-bg').attr('data-height'));
		$('#page-header-bg .container > .row').css('top',0);
		
		//center the heading
		var pageHeadingHeight = $('#page-header-bg .col.span_6').height();
		$('#page-header-bg .col.span_6').css('top', (pageHeaderHeight/2) - (pageHeadingHeight/2) + 18);
		
		//center portfolio filters
		$('#page-header-bg #portfolio-filters').css('top', (pageHeaderHeight/2) + 2);	
	}
	
	else {
		//recalc
		pageHeaderHeight = parseInt($('#page-header-bg').attr('data-height'));
		
		//center the heading
		var pageHeadingHeight = $('#page-header-bg .container > .row').height();
		$('#page-header-bg .container > .row').css('top', (pageHeaderHeight/2) - (pageHeadingHeight/2) + 12);
		
	}
	
	$('#page-header-bg .container > .row').css('visibility','visible');
}

pageHeader();
$(window).resize(pageHeader);





	
/*-------------------------------------------------------------------------*/
/*	5.	Page Specific
/*-------------------------------------------------------------------------*/	

	//recent work
	function piVertCenter() {
		$('.portfolio-items  > .col').each(function(){
			var $colHeight = $(this).find('.work-item').height();
			var $infoHeight = $(this).find('.vert-center').height();
			
			//30px away from being centered so we can transition to center point on hover
			$(this).find('.work-info .vert-center').css('margin-top', (($colHeight / 2) - ($infoHeight / 2 )) - 30 );
		});	
	}
	
	$(window).load(function(){
	 	 piVertCenter();
	});
	 
	$(window).resize(function(){
		 piVertCenter();
	});
	
	//portfolio item hover effect
	$('.portfolio-items .col .work-item').hover(function(){
		$(this).find('.work-info .vert-center').stop().animate({
			'padding-top' : 30
		},380,'easeOutCubic');
		$(this).find('.work-info').stop().animate({
			'opacity' : 1
		},380,'easeOutCubic');
		$(this).find('.work-info-bg').stop().animate({
			'opacity' : 0.9
		},380,'easeOutCubic');
	},function(){
		$(this).find('.work-info .vert-center').stop().animate({
			'padding-top' : 0
		},380,'easeOutCubic');
		$(this).find('.work-info').stop().animate({
			'opacity' : 0
		},380,'easeOutCubic');
		$(this).find('.work-info-bg').stop().animate({
			'opacity' : 0
		},380,'easeOutCubic');
	});
	
	//portfolio sort
	$('#portfolio-filters').hover(function(){
		$(this).find('ul').stop(true,true).slideToggle(600,'easeOutExpo');
	});
	
	//mobile sort menu fix
	if($('body').hasClass('mobile')){
		$('#portfolio-filters').unbind('mouseenter mouseleave');
		$('#portfolio-filters > a').click(function(){
			$(this).parent().find('ul').stop(true,true).slideToggle(600,'easeOutExpo');
		});
	}
	
	//blog love center
	function centerLove(){
		$('.post').each(function(){
			
			var $loveWidth = $(this).find('.post-meta .nectar-love').outerWidth();
			var $loveWrapWidth = $(this).find('.post-meta  .nectar-love-wrap').width();
			
			//center
			$(this).find('.post-meta .nectar-love').css('margin-left', $loveWrapWidth/2 - $loveWidth/2 + 'px' );
			$(this).find('.nectar-love-wrap').css('visibility','visible');
		});
	}
	
	$('.nectar-love').on('click',function(){
		centerLove();
	});
	
	centerLove();	
	
	
	//portfolio single comment order
	function portfolioCommentOrder(){
		
		if($('body').hasClass('mobile') && $('body').hasClass('single-portfolio') && $('#respond').length > 0){
			$('#sidebar').insertBefore('.comments-section');
		}
		
		else if($('body').hasClass('single-portfolio') && $('#respond').length > 0) {
			$('#sidebar').insertAfter('#post-area');
		}
		
	}
	
	$(window).resize(portfolioCommentOrder);
	 portfolioCommentOrder();
	 
	
	
	//portfolio sidebar follow
	
	var sidebarFollow = $('.single-portfolio #sidebar').attr('data-follow-on-scroll');
	
	if( $('body.single-portfolio').length > 0 && sidebarFollow == 1 && !$('body').hasClass('mobile') && parseInt($('#sidebar').height()) + 50 <= parseInt($('#post-area').height())) {
		
		 $('#sidebar').addClass('fixed-sidebar');
		 
		 var $footer = '#footer-outer';
		 if( $('#call-to-action').length > 0 ) $footer = '#call-to-action';
		 
		 $('#sidebar').stickyMojo({footerID: $footer, contentID: '#post-area'});
		 
		 
	}
	
	

/*-------------------------------------------------------------------------*/
/*	6.	Scroll to top
/*-------------------------------------------------------------------------*/	

var $scrollTop = $(window).scrollTop();

//starting bind
if( $('#to-top').length > 0 && $(window).width() > 1020) {
	
	if($scrollTop > 350){
		$(window).bind('scroll',hideToTop);
	}
	else {
		$(window).bind('scroll',showToTop);
	}
}


function showToTop(){
	
	if( $scrollTop > 350 ){

		$('#to-top').stop(true,true).animate({
			'bottom' : '17px'
		},350,'easeInOutCubic');	
		
		$(window).unbind('scroll',showToTop);
		$(window).bind('scroll',hideToTop);
	}

}

function hideToTop(){
	
	if( $scrollTop < 350 ){

		$('#to-top').stop(true,true).animate({
			'bottom' : '-30px'
		},350,'easeInOutCubic');	
		
		$(window).unbind('scroll',hideToTop);
		$(window).bind('scroll',showToTop);	
		
	}
}

//to top color
if( $('#to-top').length > 0 ) {
	
	var $windowHeight, $pageHeight, $footerHeight, $ctaHeight;
	
	function calcToTopColor(){
		$scrollTop = $(window).scrollTop();
		$windowHeight = $(window).height();
		$pageHeight = $('body').height();
		$footerHeight = $('#footer-outer').height();
		$ctaHeight = ($('#call-to-action').length > 0) ? $('#call-to-action').height() : 0;
		
		if( ($scrollTop-35 + $windowHeight) >= ($pageHeight - $footerHeight) ){
			$('#to-top').addClass('dark');
		}
		
		else {
			$('#to-top').removeClass('dark');
		}
	}
	
	//calc on scroll
	$(window).scroll(calcToTopColor);
	
	//calc on resize
	$(window).resize(calcToTopColor);

}

//scroll up event
$('#to-top').click(function(){
	$('body,html').stop().animate({
		scrollTop:0
	},800,'easeOutCubic')
	return false;
});

/*-------------------------------------------------------------------------*/
/*	7.	Cross Browser Fixes
/*-------------------------------------------------------------------------*/	
	
	//Fix current class in menu
	if ($("body").hasClass("single-portfolio") || $('body').hasClass("error404") || $('body').hasClass("search-results")) {   
		$("li").removeClass("current_page_parent");   
	}
	
	//fix for IE8 nth-child
	$('.recent_projects_widget div a:nth-child(3n+3), #sidebar #flickr div:nth-child(3n+3) a, #footer-outer #flickr div:nth-child(3n+3) a').css('margin-right','0px');
	
	//remove br's from code tag
	$('code').find('br').remove();	
	
	//if a clear is the last div, remove the padding
	if($('.container.main-content > .row > div:last-child').hasClass('clear')) {
		$('.container.main-content > .row > div:last-child').css('padding-bottom','0');
	}
	
	//homepage recent blog for IE8
	$('.home-wrap .blog-recent > div:last-child').addClass('col_last');
	
	//contact form
	$('.wpcf7-form p:has(input[type=submit])').css('padding-bottom','0px');
	
});


function resizeIframe() {
	var element = document.getElementById("pp_full_res").getElementsByTagName("iframe");
	var height = element[0].contentWindow.document.body.scrollHeight;
    
    //iframe height
    element[0].style.height = height + 'px';
	
	//pp height
	document.getElementsByClassName("pp_content_container")[0].style.height = height+40+ 'px';
	document.getElementsByClassName("pp_content")[0].style.height = height+40+ 'px';
	
}