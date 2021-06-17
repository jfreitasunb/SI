<div id="edit_insert_dialog" title="Alterar turma">
	<p class="validateTips">Todos os campos são obrigatórios menos a sala.</p>

	<form id="edit_insert_form">
		<fieldset>
			<div>
				<label for="dialog_edit_discipline">Disciplina:</label>
				<select name="discipline" id="dialog_edit_discipline" class="ui-widget-content ui-corner-all"
					title="É obrigatório selecionar a disciplina" required aria-required="true">
					<option></option>
					<!-- BEGIN add_discipline -->
					<option value="{discipline_id}">{discipline_name}</option>
					<!-- END add_discipline -->
				</select>
			</div>
			<div>
				<label for="dialog_edit_class">Turma:</label>
				<input type="text" name="class" id="dialog_edit_class" class="ui-widget-content ui-corner-all"
					title="É obrigatório selecionar a turma" required aria-required="true">
			</div>
			<div>
				<label for="dialog_edit_period">Período:</label>
				<select name="period" id="dialog_edit_period" class="ui-widget-content ui-corner-all"
					title="É obrigatório selecionar o período" required aria-required="true">
					<option></option>
					<!-- BEGIN add_period -->
					<option value="{period_short_value}">{period_value}</option>
					<!-- END add_period -->
				</select>
			</div>
			<div>
				<label for="dialog_edit_schedule">Hor&aacute;rio:</label>
				<input type="text" name="schedule" id="dialog_edit_schedule" class="ui-widget-content ui-corner-all"
					title="É obrigatório selecionar a hor&aacute;rio" required aria-required="true">
			</div>
			<div>
				<label for="dialog_edit_classromm">Sala:</label>
				<input type="text" name="classromm" id="dialog_edit_classroom" class="ui-widget-content ui-corner-all">
			</div>

			<!-- Allow form submission with keyboard without duplicating the dialog button -->
			<input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
		</fieldset>
	</form>
</div>
<div id="delete_confirmation_dialog" title="Exclusão de turma.">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span id="delete_confirmation_dialog_description"></span></p>
</div>

<div class="right">
	<button class="new_class">Nova turma</button>
</div>