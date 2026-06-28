const password = document.getElementById("password");
const confirmPassword = document.getElementById("confirmPassword");
const showPassword = document.getElementById("showPassword");
const showConfirmPassword = document.getElementById("showConfirmPassword");

showPassword.addEventListener("click", event => {
	event.preventDefault();
	showPass(showPassword, password);
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

/*const menu = document.getElementById("menu");
const menuBtn = document.querySelectorAll(".menuBtn");

menuBtn.forEach(btn => {
	btn.addEventListener("click", event => {
		console.log(btn.target.classList);
	});
});*/