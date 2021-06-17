/**
 * Created by phelippe on 07/11/16.
 */

$().ready(function() {
	$('#granted_credits_table').DataTable({
		"order": [[0, "asc" ], [1, "asc" ], [2, "asc" ]],
		"paging": false,
		"ordering": true,
		"info": false,
		"filter": false,
		"columnDefs": [
			{"orderable": false, "targets": [4]}
		]
	});

	$("#granted_credits_form").validate({
		rules: {
			teacher: {
				required: true
			},
			group: {
				required: true
			},
			activity: {
				required: true
			},
			credits: {
				required: true,
				number: true
			}
		}
	});

	$("#group").change(function() {
		$("#dynamic_line").remove();
		$.post("{url_groups_activities}",
			{ group: $(this).val() },
			function(response) {
				console.log(response);
				if (response.success) {
					var activity_select = $("#activity");
					activity_select.empty();
					if (response.data.length > 1) {
						activity_select.append('<option value=""></option>');
					}
					for (var i = 0; i < response.data.length; i++) {
						var part2 = ' - ' +response.data[i].amount + '/';
						part2 += response.data[i].maximum ? response.data[i].maximum : '&infin;';
						activity_select.append('<option ' +
							'value="' + response.data[i].id + '" ' +
							'data-credits="'+ response.data[i].credits + '">' + response.data[i].description + part2 + '</option>');
					}
					activity_select.change();
				} else {
					alert(response.message);
				}
			}, "json");
		$("#credits").val("");
	});

	$("#activity").change(function() {

		$("#credits").val($(this).find(':selected').data('credits'));
		$.post("{url_other_field_granted_credits}",
			{ activity: $(this).val() },
			function(response) {
				console.log(response);
				if (response.success) {
					$("#dynamic_line").remove();
					if (response.title) {
						$("#activity_line").closest("tr").after("<tr id='dynamic_line'><td>" + response.title + "</td>" +
							"<td><select id='extra' name='extra'></select></td>"+
							"<td><label id='extra-error' class='error' for='extra'></label></td></tr>");

						var select = $("#extra");
						select.append('<option value=""></option>');
						select.rules("add", {
							required: true
						});

						for (var i = 0; i < response.data.length; i++) {
							select.append('<option value="' + response.data[i].key + '" ' +
								'data-credits="'+ response.data[i].credits + '">' + response.data[i].description + '</option>');
							// select.append('<option value="' + response.data[i].key + '>' + response.data[i].description + '</option>');
						}
					}
				} else {
					alert(response.message);
				}
			}, "json");
	});

	$('body').on('change', '#extra', function() {
		$("#credits").val($(this).find(':selected').data('credits'));
	});



	function formatString (src, obj) {
		for (var key in obj) {
			if (obj.hasOwnProperty(key)) {
				var rx = new RegExp('\\[' + key + '\\]');
				src = src.replace(rx, obj[key]);
			}
		}
		return src;
	}

	$(".bt_remove").click(function () {
		var name = $(this).closest('tr').find('.professor').html();
		var activity = $(this).closest('tr').find('.activity').html();
		var credits = $(this).closest('tr').find('.credits').html();

		var text = $('#dialog_delete > .message').data("format");
		var values = [name, activity, credits];

		var formatted = formatString(text, values);

		$('#dialog_delete > .message').html(formatted);

		$('#dialog_delete').data("id", $(this).data('id'));
		$('#dialog_delete').dialog('open');
	});

	$("#dialog_delete").dialog({
		resizable: false,
		modal: true,
		autoOpen: false,
		position: { my: "center center", at: "center center", of: window },
		buttons: [
			{
				text: "Cancelar",
				click: function() {
					$(this).dialog('close');
				}
			},
			{
				text: "Remover carga",
				click: function() {
					var data = {id: $(this).data('id')};
					$.ajax({
						url: '{url_granted_credits}',
						type: 'DELETE',
						data: JSON.stringify(data),
						contentType: 'application/json',
						dataType: "json",
						processData: true,
						success: function(response) {
							if (response.success) {
								location = location;
							} else {
								alert(response.message);
							}
						},
						error: function(response) {
							console.log(response.responseText);
						}
					});
				}
			}
		]
	});
});