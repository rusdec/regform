$(document).ready(function() {
sendButton = $("#button_signout");
sendButton.click(function() {
	$.ajax({
		type:	"GET",
		url:	"/signout",
		async:	"false",
	})
	.done(function(response_msg) {
		data = JSON.parse(JSON.stringify(response_msg));
		if (data.redirect != undefined) {
			window.location.replace(data.redirect);
		}
	});
});

})
