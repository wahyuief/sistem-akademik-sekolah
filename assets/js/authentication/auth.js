var openPassword = document.getElementById("open-password");
var closePassword = document.getElementById("close-password");
var submitForm = document.getElementById("submit-form");

if (openPassword) {
	openPassword.addEventListener('click', function() {
		document.getElementById("password").type = "text";
		openPassword.style.display = 'none';
		closePassword.style.display = 'block';
	});
}

if (closePassword) {
	closePassword.addEventListener('click', function() {
		document.getElementById("password").type = "password";
		openPassword.style.display = 'block';
		closePassword.style.display = 'none';
	});
}

if (submitForm) {
	submitForm.addEventListener('click', function() {
		this.setAttribute("disabled", "disabled");
		var form = document.getElementsByTagName("form")[0];
		var formData = new FormData(form);
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
				var r = JSON.parse(this.responseText);
				if (r.status == 'success') {
					window.location.replace(r.redirect_to)
				} else {
					submitForm.removeAttribute("disabled");
					alert(r.message)
				}
			}
		};
		xmlhttp.open("POST", form.getAttribute("action"), true);
		xmlhttp.send(formData);
	});
}