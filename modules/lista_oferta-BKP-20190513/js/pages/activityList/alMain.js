/**
 * Created by phelippe on 24/01/17.
 */

$( function() {
	$("#select").click(function() {
		window.location.href = "./activity_list.php?semester="+$("#semester").val();
	});
});
