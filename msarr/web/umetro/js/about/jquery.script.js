/**
 * @package Site Template
 * @subpackage Increase HTML
 * @since Increase 1.0
 * 
 * Template Scripts
 * Created by CMSMasters
 * 
 */

/*
 * Responsive Content Slider v1.0.1 - jQuery Content Slider
 * 
 * (c) Copyright Steven "cmsmasters" Masters
 * http://cmsmastrs.net/
 * For sale on ThemeForest.net
 */



	/* Popular, Latest and Related Posts */
	(function ($) { 
		$('.related_posts ul li a').click(function (e) { 
			var rposts = $(this).parent().parent().parent(), 
				index = $(this).parent().index();
			
			rposts.find('ul').find('a').removeClass('current');
			$(this).addClass('current');
			
			rposts.find('div.related_posts_content').not('div.related_posts_content:eq(' + index + ')').slideUp();
			rposts.find('div.related_posts_content:eq(' + index + ')').slideDown();
			
			e.preventDefault();
		} );
	} )(jQuery);
	
	
	
	/* Toggle */
	(function ($) { 
		$('.togg a.tog').click(function (i) { 
			var dropDown = $(this).parent().find('.tab_content');
			
			$(this).parent().find('.tab_content').not(dropDown).slideUp();
			
			if ($(this).hasClass('current')) {
				$(this).removeClass('current');
			} else {
				$(this).addClass('current');
			}
			
			dropDown.stop(false, true).slideToggle().css( { 
				display : 'block' 
			} );
			
			i.preventDefault();
		} );
	} )(jQuery);
	
	
	
	/* Accordion */
	(function ($) { 
		$('.accordion a.tog').click(function (j) { 
			var dropDown = $(this).parent().find('.tab_content');
			
			$(this).parent().parent().find('.tab_content').not(dropDown).slideUp();
			
			if ($(this).hasClass('current')) {
				$(this).removeClass('current');
			} else {
				$(this).parent().parent().find('.tog').removeClass('current');
				$(this).addClass('current');
			}
			
			dropDown.stop(false, true).slideToggle().css( { 
				display : 'block' 
			} );
			
			j.preventDefault();
		} );
	} )(jQuery);
	
	
	
	/* Tabs */
	(function ($) { 
		$('.tab ul.tabs li:first-child a').addClass('current');
		$('.tab .tab_content div.tabs_tab:first-child').show();
		
		$('.tab ul.tabs li a').click(function (g) { 
			var tab = $(this).parent().parent().parent(), 
				index = $(this).parent().index();
			
			tab.find('ul.tabs').find('a').removeClass('current');
			$(this).addClass('current');
			
			tab.find('.tab_content').find('div.tabs_tab').not('div.tabs_tab:eq(' + index + ')').slideUp();
			tab.find('.tab_content').find('div.tabs_tab:eq(' + index + ')').slideDown();
			
			g.preventDefault();
		} );
	} )(jQuery);
	
	
	
	/* Tour */
	(function ($) { 
		$('.tour_content ul.tour li:first-child').addClass('current');
		$('.tour_content div.tour_box:first').show();
		
		$('.tour_content ul.tour li a').click(function (f) { 
			var tour = $(this).parent().parent().parent().parent(), 
				index = $('ul.tour li').index($(this).parent());
			
			tour.find('ul.tour').find('li').removeClass('current');
			$(this).parent().addClass('current');
			
			tour.find('div.tour_box').not('div.tour_box:eq(' + index + ')').slideUp();
			tour.find('div.tour_box:eq(' + index + ')').slideDown();
			
			f.preventDefault();
		} );
	} )(jQuery);
	
