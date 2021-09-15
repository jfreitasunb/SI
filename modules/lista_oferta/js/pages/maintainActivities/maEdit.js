/**
 * Created by Phelippe on 10/12/16.
 */

$().ready(function() {
	$("#activity_form").validate({
		rules: {
			group_key: {
				required: true
			},
			description: {
				required: true
			},
			credits: {
				number: true
			},
			maximum: {
				digits: true
			}
		}
	});
});