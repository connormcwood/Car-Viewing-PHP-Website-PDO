$(function() {
	$.validator.addMethod('lowerCapNumPassword', function(value, element){
		return this.optional(element)
		|| value.length >= 8
		&& /\d/.test(value)
		&& /[A-z]/i.test(value);
	}, 'Your Password Must Have Atleast Eight Characters In Length And Have Numbers Within')
	$("#login").validate({
			rules: {
				username: {
					required: true					
				},
				password: {
					required: true
				}
			},
			messages: {
				username: {
					required: "<div class='error'><p>Please Enter Your Username</div>"
				},
				password: {
					required: "<div class='error'><p>Please Enter Your Password</div>"
				}
			}
	});
	$("#registration").validate({
			rules: {
				//username, password, password2, first_name, surname, address
				username: {
					required: true,
					nowhitespace: true
				},
				password: {
					required: true,
					lowerCapNumPassword: true
				},
				password2: {
					required: true,
					equalTo: "#password"
				},
				first_name: {
					required: true,
					nowhitespace: true,
					lettersonly: true
				}, 
				surname: {
					required: true,
					lettersonly: true
				},
				email: {
					required: true,
					email: true	
				},
				address: {
					required: true
				}
				
			},
			messages: {
				password: {
					required: "<div class='error'><p>Please Enter A Password!</div>",
					lowerCapNumPassword: "<div class='error'><p>Password Must Have A Length Of Atleast Eight, Include Numbers And Have Upper And Lowercase Characters</div>"
				},
				password2: {
					required: "<div class='error'><p>You Are Required To Enter A Password</p></div>",
					equalTo:"<div class='error'><p>Your Passwords Do Not Match!</p></div>"
				},
				first_name: {
					required: "<div class='error'><p>You Are Required To Enter A First Name</p></div>",
					nowhitespace:  "<div class='error'><p>White Space Is Not Allowed In Your Fist Name</p></div>",
					lettersonly:  "<div class='error'><p>Letters Are Only Allowed In Your First Name</p></div>"
				},
				surname: {
					required:  "<div class='error'><p>You Are Required To Enter A Surname</p></div>",
					lettersonly:  "<div class='error'><p>You Are Only Allowed Letters In Your Surname</p></div>"
				},
				username: {
					required:"<div class='error'><p>Please Enter A Unique Username!</p></div>",
					nowhitespace:"<div class='error'><p>You're Not Allowed Any Spaces Within Your Username!</p></div>"
				},			
				email: {
					required: "<div class='error'><p>Please Enter A Email Address</p></div>",
					email: "<div class='error'><p>Please Enter A Valid Email Address</p></div>"
				},
				address: {
					required:  "<div class='error'><p>You Are Required To Enter An Address</p></div>"
				}
			}
});
	});
