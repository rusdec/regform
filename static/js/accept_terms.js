$(document).ready(function() {
	accept	= $("input[name=accept_terms]");
	bttn 	= $("button[id=input_post]");

	if (accept.prop("checked")) {
		accept.prop("checked", false);
		disable_button();
	}

	accept.click(function() {
		if (accept.prop("checked")) {
			enable_button()
		} else {
			disable_button()
		}
	});

	function disable_button() {
		bttn.prop("disabled", true);
		bttn.removeClass("input_submit_registration_enabled");
		bttn.addClass("input_submit_registration");
	}
	function enable_button() {
		bttn.prop("disabled", false);
		bttn.removeClass("input_submit_registration");
		bttn.addClass("input_submit_registration_enabled");
	}
});
