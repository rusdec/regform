$(document).ready(function() {
	var elements_for_check = {
			email:		{
				name:	"user_email",
				pttrn:	[
					'^[a-z0-9][a-z0-9_-]+@[a-z0-9]+\.[a-z]{2,7}$'
				],
				is_ok:	false
			},
			password: 	{
				name:	"user_password",
				pttrn:	[
					'[a-z]',
					'[A-Z]',
					'[0-9]',
					'[-_]',
					'.{8,15}'
				],
				is_ok:	false
			},
			login:		{
				name: 	"user_login",
				pttrn:	[
					"^[a-zA-Z0-9]{7,14}$",
					"[^\s]"
				],
				is_ok:	false
			},
			first_name: {
				name:	"user_first_name",
				pttrn:	[
					"^[a-zA-Zа-яА-Я]{2,30}$",
					"[^\s]"
				],
				is_ok:	false
			},
			last_name:	{
				name:	"user_last_name",
				pttrn:	[
					"^[a-zA-Zа-яА-Я]{2,30}$",
					"[^\s]"
				],
				is_ok:	false
			},
			answer:		{
				name:	"user_answer",
				pttrn:	[
					".{1,50}"
				],
				is_ok:	false
			}
	}

	function check_elem(elem_array) {
		var elem = $("input[name='"+elem_array['name']+"']");
		elem.blur(function() {
			if (elem.val() != '') {
				$.each(elem_array['pttrn'], function(i,pattern) {
					var re = new RegExp(pattern)
					if (elem.val().match(re) != null) {
						elem.css("border", "2px solid #5DD55D")
						elem_array['is_ok'] = true
						console.log("Зачёт!")
					} else {
						elem.css("border", "2px solid #FF8080")
						elem['is_ok'] = false
						console.log("Незачёт!")
						return false
					}
				});
			}
		});
	}
	
	check_elem(elements_for_check['email'])
	check_elem(elements_for_check['password'])
	check_elem(elements_for_check['login'])
	check_elem(elements_for_check['first_name'])
	check_elem(elements_for_check['last_name'])
	check_elem(elements_for_check['answer'])


})




















