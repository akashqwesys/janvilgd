// gallery js

jQuery(window).load(function() {

	jQuery("section img").click(function() {
		jQuery(".lightbox").fadeIn(300);
		jQuery(".lightbox").append("<img src='" + jQuery(this).attr("src") + "' alt='" + jQuery(this).attr("alt") + "' />");
		jQuery(".filter").css("background-image", "url(" + jQuery(this).attr("src") + ")");
		/*jQuery(".title").append("<h1>" + jQuery(this).attr("alt") + "</h1>");*/
		jQuery("html").css("overflow", "hidden");
		if (jQuery(this).is(":last-child")) {
			jQuery(".arrowr").css("display", "none");
			jQuery(".arrowl").css("display", "block");
		} else if (jQuery(this).is(":first-child")) {
			jQuery(".arrowr").css("display", "block");
			jQuery(".arrowl").css("display", "none");
		} else {
			jQuery(".arrowr").css("display", "block");
			jQuery(".arrowl").css("display", "block");
		}
	});

	jQuery(".close").click(function() {
		jQuery(".lightbox").fadeOut(300);
		jQuery("h1").remove();
		jQuery(".lightbox img").remove();
		jQuery("html").css("overflow", "auto");
	});

	jQuery(document).keyup(function(e) {
		if (e.keyCode == 27) {
			jQuery(".lightbox").fadeOut(300);
			jQuery(".lightbox img").remove();
			jQuery("html").css("overflow", "auto");
		}
	});

	jQuery(".arrowr").click(function() {
		var imgSrc = jQuery(".lightbox img").attr("src");
		var search = jQuery("section").find("img[src$='" + imgSrc + "']");
		var newImage = search.next().attr("src");
		/*jQuery(".lightbox img").attr("src", search.next());*/
		jQuery(".lightbox img").attr("src", newImage);
		jQuery(".filter").css("background-image", "url(" + newImage + ")");

		if (!search.next().is(":last-child")) {
			jQuery(".arrowl").css("display", "block");
		} else {
			jQuery(".arrowr").css("display", "none");
		}
	});

	jQuery(".arrowl").click(function() {
		var imgSrc = jQuery(".lightbox img").attr("src");
		var search = jQuery("section").find("img[src$='" + imgSrc + "']");
		var newImage = search.prev().attr("src");
		/*jQuery(".lightbox img").attr("src", search.next());*/
		jQuery(".lightbox img").attr("src", newImage);
		jQuery(".filter").css("background-image", "url(" + newImage + ")");

		if (!search.prev().is(":first-child")) {
			jQuery(".arrowr").css("display", "block");
		} else {
			jQuery(".arrowl").css("display", "none");
		}
	});

});


