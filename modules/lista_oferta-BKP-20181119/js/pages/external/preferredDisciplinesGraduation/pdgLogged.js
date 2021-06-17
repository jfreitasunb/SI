$().ready(function() {
	$(".discipline").change(function() {
		var id = $(this).attr('id');
		var val = $(this).val();

		var oldVal = $(this).data("oldVal");
		if (typeof oldVal !== "undefined") {
			$(".discipline option[value='"+oldVal+"']").show().prop('disabled', false);
		}

		if (val.length != 0) {
			$(".discipline:not(#"+id+")  option[value='"+val+"']").hide().prop('disabled', true);
		}
		$(this).data("oldVal", val);
	}).each(function(index, value){
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