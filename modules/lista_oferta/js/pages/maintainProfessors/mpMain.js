$().ready(function() {
	$('#professors_table').DataTable({
		"order": [[0, "asc" ]],
		"paging": false,
		"ordering": true,
		"info": false,
		"filter": false,
		"columnDefs": [
			{"orderable": false, "targets": [1]}
		]
	});
});