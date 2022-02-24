var pffttt = 'cdiwj2d9i2mje2'
var pffttt = 'xeiejmx2i9ej1x'
var pffttt = 'xej1i9jmxa0e21'
var pffttt = 'de1ei1j0eijm1i'
var pffttt = 'e21jdie921je21i'
var pffttt = 'd21i9mje3ije'
var pffttt = 'c0meok210ei1ej21i'
$('#zero-config').DataTable({
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
	"ajax": base_url + 'ngadimin/sekolah/get_data?wahyugantengbanget='+pffttt,
	"columns": [
		{ data: 'id' },
		{ data: 'npsn' },
		{ data: 'nama' },
		{ data: 'akreditasi' },
		{ data: 'pembuat' },
		{ data: 'dibuat' },
		{ data: 'opsi' },
	 ],
	 "order": [[ 0, "desc" ]]
});

$("#logo").hide();
$("#pilihlogo").on('click', function () {
    $("#logo").trigger('click');
    $(this).hide();
    $("#logo").show();
});

$('#btn-add-sekolah').on('click', function(event) {
    $('#addSekolahModalTitle').attr('action', base_url + 'ngadimin/sekolah/do_insert')
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
			formData.append("wahyuganteng", "OHYEAH");
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
			xmlhttp.open("POST", base_url + 'ngadimin/sekolah/get_npsn/' + npSN.value, true);
			xmlhttp.send(formData);
		}
	});
}

$(document).on("click", ".linkEdit", function (e, i) {
	e.preventDefault()
	var url = $(this).attr("href");
	var npsn = $(this).attr("npsn");
	var nama = $(this).attr("nama");
	var slug = $(this).attr("slug");
	var alamat = $(this).attr("alamat");
	var akreditasi = $(this).attr("akreditasi");
	var status = $(this).attr("status");
	var jenjang = $(this).attr("jenjang");
	$('#pasUpdateAja').html('Biarkan kosong jika tidak ingin dirubah')
	$('#addSekolahModalTitle').attr('action', url)
	$('#npSN').val(npsn)
	$('#nama').val(nama)
	$('#slug').val(slug)
	$('#alamat').val(alamat)
	$('#akreditasi').val(akreditasi)
	$('#status').val(status)
	$('#jenjang').val(jenjang)
	$('#btn-add').removeAttr('disabled');
	$('#addSekolahModal').modal('show');
})