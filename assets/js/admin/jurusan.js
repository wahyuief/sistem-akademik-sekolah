$('#zero-config').DataTable({
    "oLanguage": {
        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
        "sInfo": "Showing page _PAGE_ of _PAGES_",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Search...",
       "sLengthMenu": "Results :  _MENU_",
    },
    "stripeClasses": []
});

$('#btn-add-jurusan').on('click', function(event) {
    $('#addJurusanModalTitle').attr('action', base_url + 'admin/jurusan/do_insert')
    $('#addJurusanModal').find("input[type=text], input[type=number], input[type=email], input[type=password], textarea").val("")
    $('#addJurusanModal #btn-add').show();
    $('#addJurusanModal #btn-edit').hide();
	$('#addJurusanModal').modal('show');
	$('#btn-add').removeAttr('disabled');
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

$(document).on("click", ".linkEdit", function (e, i) {
	e.preventDefault()
	var url = $(this).attr("href");
	var kode = $(this).attr("kode");
	var nama = $(this).attr("nama");
	$('#addJurusanModalTitle').attr('action', url)
	$('#kode').val(kode)
	$('#nama').val(nama)
	$('#btn-add').removeAttr('disabled');
	$('#addJurusanModal').modal('show');
})