$().ready(function() {

	var selectedDisciplineMap = new Map();
	<!-- BEGIN add_lo_temp_selected -->
	//noinspection JSAnnotator,JSUnresolvedVariable
	selectedDisciplineMap.set("{lo_temp_number}", "{lo_temp_id}");
	//noinspection JSAnnotator,JSUnresolvedVariable
	selectedDisciplineMap.set("{lo_temp_id}", "{lo_temp_number}");
	<!-- END add_lo_temp_selected -->

	$(".discipline").change(function() {
		var id = $(this).attr('id');
		var val = $(this).val();

		var oldVal = selectedDisciplineMap.get(id);
		if (typeof oldVal !== "undefined") {
			selectedDisciplineMap.delete(oldVal);

			$(".discipline option[value='"+oldVal+"']").show();
		}

		if (val.length == 0) {
			selectedDisciplineMap.delete(id);
		} else {
			selectedDisciplineMap.set(id, val);
			selectedDisciplineMap.set(val, id);

			$(".discipline:not(#"+id+")  option[value='"+val+"']").hide();
		}
	});

	$('.discipline').each(function(index, value){
	      $(this).change();
	});

	// validate signup form on keyup and submit
	$("#disciplines_form").validate();

	$('#granted_credits_table').DataTable({
		"paging": false,
		"ordering": true,
		"info": false,
		"filter": false
	});
});