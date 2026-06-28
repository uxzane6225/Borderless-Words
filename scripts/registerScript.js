const password = document.getElementById("password");
const confirmPassword = document.getElementById("confirmPassword");
const showPassword = document.getElementById("showPassword");
const showConfirmPassword = document.getElementById("showConfirmPassword");

showPassword.addEventListener("click", event => {
	event.preventDefault();
	showPass(showPassword, password);
});

showConfirmPassword.addEventListener("click", event => {
	event.preventDefault();
	showPass(showConfirmPassword, confirmPassword);
});

function showPass(showPass,pass) {
	if (pass.type == "password") {
		pass.type = "text";
		showPass.innerHTML = "Hide";
	}
	else {
		pass.type = "password";
		showPass.innerHTML = "Show";
	}
}