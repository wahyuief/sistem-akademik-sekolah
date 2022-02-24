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
	"ajax": base_url + 'ngadimin/users/get_data?wahyugantengbanget='+pffttt,
	"columns": [
		{ data: 'id' },
		{ data: 'fullname' },
		{ data: 'username' },
		{ data: 'email' },
		{ data: 'sekolah' },
		{ data: 'status' },
		{ data: 'last_login' },
		{ data: 'opsi' },
	 ],
	 "order": [[ 0, "desc" ]]
});

$('#btn-add-user').on('click', function(event) {
    $('#addUserModalTitle').attr('action', base_url + 'ngadimin/users/do_insert')
    $('#pasUpdateAja').html('')
    $('#addUserModal').find("input[type=text], input[type=number], input[type=email], input[type=password], textarea").val("")
    $('#addUserModal #btn-add').show();
    $('#addUserModal #btn-edit').hide();
    $('#status').hide()
	$('#status').attr('disabled', 'disabled')
	$('#addUserModal').modal('show');
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
	var fullname = $(this).attr("fullname");
	var username = $(this).attr("username");
	var email = $(this).attr("email");
    var status = $(this).attr("status");
    if (status == '0') {
	    $('#activeUser').attr('selected', 'selected')
    } else {
        $('#bannedUser').attr('selected', 'selected')
    }
	$('#pasUpdateAja').html('Biarkan kosong jika tidak ingin dirubah')
	$('#addUserModalTitle').attr('action', url)
	$('#fullname').val(fullname)
	$('#username').val(username)
	$('#email').val(email)
	$('#status').show()
	$('#status').removeAttr('disabled')
	$('#btn-add').removeAttr('disabled');
	$('#addUserModal').modal('show');
})