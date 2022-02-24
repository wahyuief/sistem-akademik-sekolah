$(document).ready(function() {

	checkall('contact-check-all', 'contact-chkbox');

	$('#input-search').on('keyup', function() {
		var rex = new RegExp($(this).val(), 'i');
		$('.searchable-items .items:not(.items-header-section)').hide();
		$('.searchable-items .items:not(.items-header-section)').filter(function() {
			return rex.test($(this).text());
		}).show();
	});
})