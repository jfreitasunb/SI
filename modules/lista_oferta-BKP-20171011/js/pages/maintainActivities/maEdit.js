/**
 * Created by Phelippe on 10/12/16.
 */

$().ready(function() {
	$("#activity_form").validate({
		rules: {
			group: {
				required: true
			},
			activity: {
				required: true
			},
			credits: {
				digits: true
			},
			maximum: {
				digits: true
			}
		}
	});
});