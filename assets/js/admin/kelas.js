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

$('#btn-add-kelas').on('click', function(event) {
    $('#addKelasModalTitle').attr('action', base_url + 'admin/kelas/do_insert')
    $('#addKelasModal').find("select, input[type=text], input[type=number], input[type=email], input[type=password], textarea").val("")
    $('#addKelasModal #btn-add').show();
    $('#addKelasModal #btn-edit').hide();
	$('#addKelasModal').modal('show');
	$('#btn-add').removeAttr('disabled');
	$('.removeBtn').hide();
})

var addForm = document.getElementById("btn-add");
if (addForm) {
	addForm.addEventListener('click', function() {
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
					addForm.removeAttribute("disabled");
					alert(r.message)
				}
			}
		};
		xmlhttp.open("POST", form.getAttribute("action"), true);
		xmlhttp.send(formData);
	});
}

var removeForm = document.getElementById("btn-remove");
if (removeForm) {
	removeForm.addEventListener('click', function() {
		this.setAttribute("disabled", "disabled");
		var form = document.getElementsByTagName("form")[0];
		var formData = new FormData(form);
		var xmlhttp = new XMLHttpRequest();
		var actionUrl = form.action;
		var removeUrl = actionUrl.replace('do_update', 'do_remove');
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
				var r = JSON.parse(this.responseText);
				if (r.status == 'success') {
					window.location.replace(r.redirect_to)
				} else {
					removeForm.removeAttribute("disabled");
					alert(r.message)
				}
			}
		};
		xmlhttp.open("POST", removeUrl, true);
		xmlhttp.send(formData);
	});
}

$(document).on("click", ".linkEdit", function (e, i) {
	e.preventDefault()
	var url = $(this).attr("href");
	var kelas = $(this).attr("kelas");
	var kurikulum = $(this).attr("kurikulum");
	var walikelas = $(this).attr("walikelas");
	$('#addKelasModalTitle').attr('action', url)
	$('#kelas').val(kelas)
	$('#kurikulum').val(kurikulum)
	$('#walikelas').val(walikelas)
	$('#btn-add').removeAttr('disabled');
	$('#addKelasModal').modal('show');
	$('.removeBtn').show();
})