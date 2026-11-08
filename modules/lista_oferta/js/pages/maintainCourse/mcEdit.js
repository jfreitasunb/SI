/**
 * Created by phelippe on 19/10/16.
 */

$(document).ready(function() {
	var form = $("#course_form");
	form.on('submit', function(e) {
		$.ajax({
			type: "POST",
			url: "{url_validate_password}",
			data: form.serialize(),
			success: function(data) {
				var response = jQuery.parseJSON(data);
				if (response.success) {
					form.off('submit').submit();
				} else {
					alert(response.message);
				}
			}
		});
		e.preventDefault();
	});
});