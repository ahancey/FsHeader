// jQuery(document).ready(function ($) {

	// move the main-header to the top of the page
	var h = document.getElementById('main-header');
	// desktop insertion point
	var a = document.getElementById('mw-page-base');
	var isMobile = false;
	var isApi = false;
	if ( a == null ) {
		// mobile insertion point
		a = document.getElementById('mw-mf-viewport');
		isMobile = true;
		if ( a == null ) {
			isMobile = false;
			isApi = true;
		}
	}
	if ( isApi ) {
		var body = document.querySelector('body');
		body.prepend(h);
	} else {
		a.prepend(h);
	}

	// change the footer layout for mobile
    if ( isMobile ) {
		$('#fs-footer').css({"width":"80%", "left":"1.25rem", "padding-bottom":"1.5rem"});

	}


	var mobile_menus = $(".mobile_nav .menu-item-has-children .sub-menu").hide();

	//on page resize re-calculate the left padding on the nav menu
	jQuery(window).on("load resize", function () {

		sticky_footer();
		//find the width of the logo container and use that to left pad the nav menu
		var logo_width = 10 + jQuery(".logo_container:first").width();
		jQuery("#et-top-navigation").css("padding-left", logo_width + "px !important");
	});

	jQuery(".mobile_nav").on("click", "#top-menu > .menu-item-has-children > a", function(e) {

		e.stopPropagation();
		e.preventDefault();
		//hide all the mobile menus
		mobile_menus.slideUp();
		var parent_element = jQuery(this).parent();

		if(jQuery(parent_element).hasClass("expand")) {
				jQuery(parent_element).removeClass("expand");
		} else {
				jQuery(".menu-item-has-children").removeClass("expand");
				jQuery(parent_element).addClass("expand");
				jQuery(parent_element).find(".sub-menu").slideDown();
				return false;
		}
	});

	jQuery(".mobile_menu_bar_toggle").on("click", function (e) {
		e.stopPropagation();
		e.preventDefault();
		jQuery(".mobile_nav").toggleClass("closed");
		jQuery(".mobile_nav").toggleClass("opened");
		console.log("mobile-menu-open");
		jQuery("html").toggleClass("mobile-menu-open");
	});

	//sticky footer
	function sticky_footer() {
		var th = jQuery('#top-header').height();
		var bm = jQuery('#familysearch-blog-menu').height();
		var hh = jQuery('#main-header').height();
		var fh = jQuery('#fs-footer').height();
		var wh = jQuery(window).height();
		var ch = wh - (th + bm + hh + fh);

		var selector = "#main-content";

		//is this an error page or no search results page?
		//if so add the min-height to #familysearch-blog, else add min-height to #main-content
		if (jQuery("body.search-no-results").length || jQuery("body[class*='error']").length) {
		selector = "#familysearch-blog";
		}

		jQuery(selector).css('min-height', ch);
	}


	//if there is a click on 'body' while the mobile menu is opened close it
	jQuery("html").on("click", "body", function () {
		if ($("html").hasClass("mobile-menu-open")) {
			jQuery("html").removeClass("mobile-menu-open");
		}
	});

// });



// We use this function to determine the current wiki based on path
// parseUri 1.2.2
// (c) Steven Levithan <stevenlevithan.com>
// MIT License

function parseUri (str) {
	var	o   = parseUri.options,
		m   = o.parser[o.strictMode ? "strict" : "loose"].exec(str),
		uri = {},
		i   = 14;

	while (i--) uri[o.key[i]] = m[i] || "";

	uri[o.q.name] = {};
	uri[o.key[12]].replace(o.q.parser, function ($0, $1, $2) {
		if ($1) uri[o.q.name][$1] = $2;
	});

	return uri;
};

parseUri.options = {
	strictMode: false,
	key: ["source","protocol","authority","userInfo","user","password","host","port","relative","path","directory","file","query","anchor"],
	q:   {
		name:   "queryKey",
		parser: /(?:^|&)([^&=]*)=?([^&]*)/g
	},
	parser: {
		strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
		loose:  /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/
	}
};
