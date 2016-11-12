$(document).ready(function() {
	var elements_for_check = {
			email:		{
				name:	"user_email",
				pttrn:	[
					'^[a-z0-9][a-z0-9_-]+@[a-z0-9]+\.[a-z]{2,7}$'
				]
			},
			password: 	{
				name:	"user_password",
				pttrn:	[
					'[a-z]',
					'[A-Z]',
					'[0-9]',
					'[-_]',
					'.{8,15}'
				]
			},
			login:		{
				name: 	"user_login",
				pttrn:	[
					"^[a-z0-9]{7,12}",
					"[^\s]"
				]
			},
			first_name: {
				name:	"first_name",
				pttrn:	[
					"^[a-zа-я]{2,30}"
				]
			},
			last_name:	{
				name:	"last_name",
				pttrn:	[
					"^[a-zа-я]{2,30}"
				]
			}
	}

	function check_elem(elem_array) {
		var elem = $("input[name='"+elem_array['name']+"']");
		elem.blur(function() {
			$.each(elem_array['pttrn'], function(i,pattern) {
				var re = new RegExp(pattern)
				if (elem.val().match(re) != null) {
					elem.css("border-bottom", "3px solid #5DD55D")
					console.log("Зачёт!")
				} else {
					elem.css("border-bottom", "3px solid #FF8080")
					console.log("Незачёт!")
					return false
				}
			});
		});
	}
	
	check_elem(elements_for_check['email'])
	check_elem(elements_for_check['password'])
	check_elem(elements_for_check['login'])
	check_elem(elements_for_check['first_name'])
	check_elem(elements_for_check['last_name'])
})




















