/**
 * Created by phelippe on 21/10/18.
 */

$( function() {
	var table = $('#night_shift_table').DataTable({
		"order": [[0, "asc" ]],
		"paging": false,
		"ordering": true,
		"info": false,
		"filter": false
	});
});
