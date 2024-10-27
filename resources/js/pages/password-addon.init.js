/*
Template Name: WBMAHALCRM - Customer Relationship Management Application
Author: WebMahal.com
Website: https://WebMahal.com.in/
Contact: WebMahal.com.in@gmail.com
File: password addon Js File
*/

// password addon
document.getElementById('password-addon').addEventListener('click', function () {
	var passwordInput = document.getElementById("password-input");
	if (passwordInput.type === "password") {
		passwordInput.type = "text";
	} else {
		passwordInput.type = "password";
	}
});
