$().ready(function() {
	$("#detail_semester_form").validate({
		rules: {
			beginning: {
				required: true,
				dateBR: true
			},
			end: {
				required: true,
				dateBR: true
			},
			average_credits: {
				number: true
			},
			status: {
				required: true
			}
		}
	});

	$.datepicker.setDefaults( $.datepicker.regional[ "pt-BR" ] );

	$("#beginning").datepicker({
		changeMonth: true,
		onClose: function( selectedDate ) {
			$("#end").datepicker( "option", "minDate", selectedDate );
		}
	}).on('change', function() {
		$(this).valid();
	});

	$("#end").datepicker({
		changeMonth: true,
		onClose: function( selectedDate ) {
			$("#beginning").datepicker("option", "maxDate", selectedDate);
		}
	}).on('change', function() {
		$(this).valid();
	});
});
