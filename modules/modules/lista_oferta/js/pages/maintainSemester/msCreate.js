$().ready(function() {
	$("#create_semester_form").validate({
		rules: {
			year: {
				required: true,
				digits: true
			},
			semester: {
				required: true,
				digits: true
			},
			beginning: {
				required: true,
				dateBR: true
			},
			end: {
				required: true,
				dateBR: true
			},
			clone: {
				required: true
			}
		}
	});

	$.datepicker.setDefaults( $.datepicker.regional[ "pt-BR" ] );

	$("#beginning").datepicker({
		defaultDate: "+3m",
		minDate: "+1d",
		changeMonth: true,
		onClose: function( selectedDate ) {
			$("#end").datepicker( "option", "minDate", selectedDate );
		}
	}).on('change', function() {
		$(this).valid();  // triggers the validation test
		// '$(this)' refers to '$("#datepicker")'
	});

	$("#end").datepicker({
		defaultDate: "+8m",
		changeMonth: true,
		onClose: function( selectedDate ) {
			$("#beginning").datepicker("option", "maxDate", selectedDate);
		}
	}).on('change', function() {
		$(this).valid();  // triggers the validation test
		// '$(this)' refers to '$("#datepicker")'
	});
});
