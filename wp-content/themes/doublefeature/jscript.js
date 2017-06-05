jQuery(document).ready(function($) {
	// Enable run_scripts function in functions.php first.
	// Place normal jQuery (supports $) here.

	$('#menu-primary-menu').click(function() {

		if ($('#access .menu-header li').is(":hidden")) {
			$('#access .menu-header li').slideDown(200, function() { });
		} else {
				$('#access .menu-header li').slideUp(100,function() {});
		}

	});

	$('li#search-2.widget-container.widget_search').click(function() {

		if ($('div#ajaxsearchlite1.wpdreams_asl_container').is(":hidden")) {
			$('div#ajaxsearchlite1.wpdreams_asl_container').slideDown(200, function() { });
		} else {
				$('div#ajaxsearchlite1.wpdreams_asl_container').slideUp(100,function() {});
		}

	});

})
