$().ready(function() {
	$('#courses_table').DataTable({
		"order": [[3, "asc" ], [1, "asc" ]],
		"paging": false,
		"ordering": true,
		"info": false,
		"filter": false,
		"columnDefs": [
			{"orderable": false, "targets": [4]}
		]
	});
});