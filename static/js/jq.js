$(document).ready(function() {
	var pattern_array = {
			email:		'^[a-z0-9][a-z0-9_-]+@[a-z0-9]+\.[a-z]{2,7}$',
			password: [
				'[a-z]',
				'[A-Z]',
				'[0-9]',
				'[-_]',
				'.{8,15}'
			],
			login:		"^[a-z0-9]{7,12}",
			first_name: "^[a-zа-я]{2,30}",
			last_name:	"^[a-zа-я]{2,30}",
	}

	var email = $("input[name='user_email']");
	email.blur(function() {
		var re = new RegExp(pattern_array['email'], "i")
		if (email.val() != '') {
			if (email.val().match(re) != null) {
				email.css("border-bottom", "3px solid #5DD55D")
				console.log("Почта зачёт!")
			} else {
				email.css("border-bottom", "3px solid #FF8080")
				console.log("Почта незачёт!")
			}
		}
	});

	var login = $("input[name='user_login']");
	login.blur(function() {
		var re = new RegExp(pattern_array['login'], "i")
		if (login.val() != '') {
			if (login.val().match(re) != null) {
				login.css("border-bottom", "3px solid #5DD55D")
				console.log("Логин зачёт!")
			} else {
				login.css("border-bottom", "3px solid #FF8080")
				console.log("Логин незачёт!")
			}
		}
	});
	
	var first_name = $("input[name='user_first_name']");
	first_name.blur(function() {
		var re = new RegExp(pattern_array['first_name'], "i")
		if (first_name.val() != '') {
			if (first_name.val().match(re) != null) {
				first_name.css("border-bottom", "3px solid #5DD55D")
				console.log("Имя зачёт!")
			} else {
				first_name.css("border-bottom", "3px solid #FF8080")
				console.log("Имя незачёт!")
			}
		}
	});

	var last_name = $("input[name='user_last_name']");
	login.blur(function() {
		var re = new RegExp(pattern_array['last_name'], "i")
		if (last_name.val() != '') {
			if (last_name.val().match(re) != null) {
				last_name.css("border-bottom", "3px solid #5DD55D")
				console.log("Фамилия зачёт!")
			} else {
				last_name.css("border-bottom", "3px solid #FF8080")
				console.log("Фамилия незачёт!")
			}
		}
	});

	var password = $("input[name='user_password']");
	password.blur(function() {
		if (password.val() != '') {
			$.each(pattern_array['password'], function(name,pattern) {
				var re = new RegExp(pattern)
				if (password.val().match(re) != null) {
					password.css("border-bottom", "3px solid #5DD55D")
					console.log("Пароль зачёт!")
				} else {
					password.css("border-bottom", "3px solid #FF8080")
					console.log("Пароль незачёт!")
					return false
				}
			});
		}
	});

	var password_confirm = $("input[name='user_password_confirm']");
	password_confirm.blur(function() {
		if (password_confirm.val() != '' && password_confirm.val() == password.val()) {
			password_confirm.css("border-bottom", "3px solid #5DD55D")
			console.log("Ещё пароль зачёт!")
		} else {
			password_confirm.css("border-bottom", "3px solid #FF8080")
			console.log("Ещё пароль незачёт!")
		}
			
	});
})




















