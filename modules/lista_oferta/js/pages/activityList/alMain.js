/**
 * Created by phelippe on 24/01/17.
 */

$( function() {
	$("#select").click(function() {
		window.location.href = "./activity_list.php?semester="+$("#semester").val();
	});

	var $toggleAll = $("#toggle_all_professors");
	var $checkboxes = $(".professor_checkbox");

	// Ajusta o texto do botao conforme o estado atual dos checkboxes
	function updateToggleLabel() {
		var allChecked = $checkboxes.length > 0 && $checkboxes.filter(":checked").length === $checkboxes.length;
		$toggleAll.text(allChecked ? "Remover seleção" : "Selecionar todos");
	}

	$toggleAll.click(function() {
		var allChecked = $checkboxes.filter(":checked").length === $checkboxes.length;
		$checkboxes.prop("checked", !allChecked);
		updateToggleLabel();
	});

	$checkboxes.change(updateToggleLabel);
	updateToggleLabel();

	// CSV exporta apenas os professores selecionados
	$("#activity_list_csv").click(function(event) {
		event.preventDefault();

		var ids = $checkboxes.filter(":checked").map(function() {
			return this.value;
		}).get();

		if (ids.length === 0) {
			alert("Selecione ao menos um professor para exportar o CSV.");
			return;
		}

		window.location.href = $(this).attr("href") + "&professors=" + encodeURIComponent(ids.join(","));
	});
});
