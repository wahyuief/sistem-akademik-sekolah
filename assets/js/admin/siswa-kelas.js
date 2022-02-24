$('#zero-config').DataTable({
    "oLanguage": {
        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
        "sInfo": "Showing page _PAGE_ of _PAGES_",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Search...",
       "sLengthMenu": "Results :  _MENU_",
    },
    "stripeClasses": [],
});

$('#daftar-siswa').DataTable({
    "oLanguage": {
        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
        "sInfo": "Showing page _PAGE_ of _PAGES_",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Search...",
       "sLengthMenu": "Results :  _MENU_",
    },
    "stripeClasses": [],
	"serverSide": true,
	"serverMethod": 'post',
	"ajax": base_url + 'admin/kelas/data_siswa/' + kelas_id,
	"columns": [
		{ data: 'id' },
		{ data: 'username' },
		{ data: 'fullname' },
		{ data: 'kelas' },
		{ data: 'opsi' },
	 ],
	 "order": [[ 0, "desc" ]],
	 "ordering": false
});

$('#btn-add-siswa').on('click', function(event) {
    $('#addSiswaModalTitle').attr('action', base_url + 'admin/kelas/do_insert_siswa')
    $('#pasUpdateAja').html('')
    $('#addSiswaModal').find("input[type=text], input[type=number], input[type=email], input[type=password], textarea").val("")
    $('#addSiswaModal #btn-add').show();
    $('#addSiswaModal #btn-edit').hide();
    $('#status').hide()
	$('#status').attr('disabled', 'disabled')
	$('#addSiswaModal').modal('show');
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

$(document).on("click", ".tambah-siswa", function (e, i) {
	e.preventDefault()
	var xmlhttp = new XMLHttpRequest();
	var kelas = $(this).attr("kelas");
	var siswa = $(this).attr("siswa");
	var element = this;
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
			var r = JSON.parse(this.responseText);
			if (r.status == 'success') {
				element.remove()
				$('#namaKelas'+siswa).html(r.kelas)
			} else {
				alert(r.message)
			}
		}
	};
	xmlhttp.open("GET", base_url + 'admin/kelas/tambah_siswa?kelas=' + kelas + '&siswa=' + siswa, true);
	xmlhttp.send();
})

$(document).on("click", ".pindah-siswa", function (e, i) {
	e.preventDefault()
	var xmlhttp = new XMLHttpRequest();
	var id = $(this).attr("dataid");
	var kelas = $(this).attr("kelas");
	var siswa = $(this).attr("siswa");
	var element = this;
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
			var r = JSON.parse(this.responseText);
			if (r.status == 'success') {
				element.remove()
				$('#namaKelas'+siswa).html(r.kelas)
			} else {
				alert(r.message)
			}
		}
	};
	xmlhttp.open("GET", base_url + 'admin/kelas/pindah_siswa?id=' + id + '&kelas=' + kelas + '&siswa=' + siswa, true);
	xmlhttp.send();
})