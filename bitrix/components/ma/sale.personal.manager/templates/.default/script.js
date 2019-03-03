"use strict";

$(document).on("ready", function() {
	var title = $(".b-personal-manager-title");
	var block = $(".b-personal-manager");

	title.on("click", function() {
	    block.toggleClass("b-personal-manager-open");
	});
})

