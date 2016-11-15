$(document).ready(function() {


function check_reg_form(isOk) {
	var elements_for_check = {
		"email" : [
				'^[a-zA-Z0-9-]{2,}@[a-zA-Z0-9]{2,}\.[a-zA-Z]{2,7}$'
			],
		"password": [
				'[a-z]',
				'[A-Z]',
				'[0-9]',
				'[_]',
				'.{8,15}'
			],
		"login" : [
				"^[a-zA-Z0-9]{7,14}$",
			],
		"first_name": [
				"^[a-zA-Zа-яА-Я]{2,30}$",
			],
		"last_name" : [
				"^[a-zA-Zа-яА-Я]{2,30}$",
			],
		"answer" : [
				"^[a-zA-Zа-яА-Я0-9]{2,50}$"
			],
		"password_confirm" :  [
				".{8,15}"
			]
	}

	function mark_input(elem) {
			elem.css("border-left", "3px solid #ff9999");
	}
	function unmark_input(elem) {
			elem.css("border-left", "1px solid #d0d0d0");
	}


	$("input").each(function() {
		elem = $(this);
		n = elem.attr('name');
		unmark_input(elem);
		if (typeof elements_for_check[n] != 'undefined') {
			value = elem.val();
			$.each(elements_for_check[n], function(i,pattern) {
				//Исключение: Проверка поля подтверждения пароля
				if (n == 'password_confirm') {
					psswd = $("input[name='password']");
						if (value != psswd.val()) {
							mark_input(elem);
							isOK = false
							return
						}		
				}
				//Проверка значения элемента согласно регулярному выражению
				var re = new RegExp(pattern)
				if (value.match(re) == null) {
					mark_input(elem);
					isOK = false
					return
				}
			});
		}
	});
}

var isOK
var sendButton = $("#input_post");
sendButton.click(function() {
	isOK = true;
	var response_msg;

	check_reg_form(isOK);
	if (isOK) {
		var Data = $("#form_post :input[group=include]").serializeArray();
		//SHA1-хеширование значения поля password
		$.each(Data, function(nothing, elem) {
			if (elem.name == 'password') {
				elem.value = sha1(elem.value);
			}
		});
		$.ajax({
			type:	"POST",
			url:	sendButton.val(),
			async:	"false",
			data:	Data,
		})
		.done(function(response_msg) {
			var color = "#6699ff";
			data = JSON.parse(JSON.stringify(response_msg))
			if (data.redirect != undefined) {
				window.location.replace(data.redirect);
			}
			if (data.msg != undefined && data.msg != "") {
				if (!data.result) {
					color = "#ff9999";
				}
				elem = $("#div_registration_info");
				elem.empty();
				elem.append('<span class="span_registration_info" style="color:'+color+';">'+data.msg+'</span>');
			}
		});
	}
    console.log(Data)
});

})
