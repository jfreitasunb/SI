$().ready(function() {
	$('#activities_table').DataTable({
		"order": [[0, "asc" ], [1, "asc" ], [2, "asc" ]],
		"paging": false,
		"ordering": true,
		"info": false,
		"filter": false,
		"columnDefs": [
			{"orderable": false, "targets": [5]}
		]
	});
});