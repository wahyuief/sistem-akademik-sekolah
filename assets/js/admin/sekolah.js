$("#logo").hide();
$("#pilihlogo").on('click', function () {
    $("#logo").trigger('click');
    $(this).hide();
    $("#logo").show();
});

$('#btn-add-sekolah').on('click', function(event) {
    $('#addSekolahModalTitle').attr('action', base_url + 'admin/dashboard/do_insert')
    $('#pasUpdateAja').html('')
    $('#addSekolahModal').find("input[type=text], input[type=number], textarea").val("")
    $('#addSekolahModal #btn-add').show();
    $('#addSekolahModal #btn-edit').hide();
	$('#btn-add').removeAttr('disabled');
    $('#addSekolahModal').modal('show');
})

var submitForm = document.getElementById("btn-add");
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

var npSN = document.getElementById("npSN");
if (npSN) {
	npSN.addEventListener('keyup', function() {
		if (npSN.value.length > 7) {
			var formData = new FormData();
			formData.append("wahyuganteng", "0HYE4H");
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
					var r = JSON.parse(this.responseText);
					if (r.status !== 'error') {
						document.getElementById("nama").value = r.nama
						document.getElementById("slug").value = r.slug
						document.getElementById("alamat").value = r.alamat
						document.getElementById("akreditasi").value = r.akreditasi
						document.getElementById("status").value = r.status
						document.getElementById("jenjang").value = r.jenjang
					} else {
						npSN.value = ''
					}
				}
			};
			xmlhttp.open("POST", base_url + 'admin/dashboard/get_npsn/' + npSN.value, true);
			xmlhttp.send(formData);
		}
	});
}