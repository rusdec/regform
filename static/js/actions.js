$(document).ready(function() {
	
	$("#input_registration").click(function() {
		var data = $("#form_registration :input[group=include]").serializeArray();
		$.post("/user/create", data)
		console.log(data)
	});
	
});
