$(document).ready(function() {


function check_reg_form(isOk) {
	var elements_for_check = {
		email:		{
			name:	"email",
			pttrn:	[
				'^[a-z0-9][a-z0-9_-]+@[a-z0-9]+\.[a-z]{2,7}$'
			],
		},
		password: 	{
			name:	"password",
			pttrn:	[
				'[a-z]',
				'[A-Z]',
				'[0-9]',
				'[-_]',
				'.{8,15}'
			],
		},
		login:		{
			name: 	"login",
			pttrn:	[
				"^[a-zA-Z0-9]{7,14}$",
				"[^\s]"
			],
		},
		first_name: {
			name:	"first_name",
			pttrn:	[
				"^[a-zA-Zа-яА-Я]{2,30}$",
				"[^\s]"
			],
		},
		last_name:	{
			name:	"last_name",
			pttrn:	[
				"^[a-zA-Zа-яА-Я]{2,30}$",
				"[^\s]"
			],
		},
		answer:		{
			name:	"answer",
			pttrn:	[
				"^[a-zA-Zа-яА-Я0-9]{1,50}$"
			],
		},
		password_c:	{
			name:	"password_confirm",
			pttrn:	[
				".{8,15}"
			]
		}
	}

	function mark_input(elem) {
			elem.css("border-left", "3px solid #ff9999");
	}
	function unmark_input(elem) {
			elem.css("border-left", "1px solid #d0d0d0");
	}

	function check_elem(elem_array) {
		var elem = $("input[name='"+elem_array['name']+"']");
		unmark_input(elem);
		$.each(elem_array['pttrn'], function(i,pattern) {
			//Проверка поля подтверждения пароля
			if (elem.attr('name') == 'password_confirm') {
				psswd = $("input[name='password']");
				if (elem.val() != psswd.val()) {
					mark_input(elem);
					isOK = false
					return
				}		
			}
			//Проверка значения элемента согласно регулярному выражению
			var re = new RegExp(pattern)
			if (elem.val().match(re) == null) {
				mark_input(elem);
				isOK = false
				return
			}
		});
	}		
	
	$.each(elements_for_check, function(el, data) {
		check_elem(elements_for_check[el]);
	});
	
}

var isOK
$("#input_registration").click(function() {
	var sec	= 5
	isOK = true;
	var response_msg;

	check_reg_form(isOK);
	if (isOK) {
		var Data = $("#form_registration :input[group=include]").serializeArray();
		$.ajax({
			type:	"POST",
			url:	"/user/create",
			async:	"false",
			data:	Data,
		})
		.done(function(response_msg) {
			var color = "#6699ff";
			data = JSON.parse(JSON.stringify(response_msg))
			if (!data.result) {
				color = "#ff9999";
			}
			elem = $("#div_registration_info");
			elem.empty();
			elem.append('<span class="span_registration_info" style="color:'+color+';">'+data.msg+'</span>');
		});
	} else {
		alert ("Заполни формы");
	}
    console.log(Data)
});

})
