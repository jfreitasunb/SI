<div id="edit_insert_dialog" title="Alterar Disciplina Magistral">
	<p class="validateTips">Todos os campos s&atilde;o obrigat&oacute;rios.</p>

	<form id="edit_insert_form">
		<fieldset>
			<div>
				<label for="dialog_edit_discipline">Disciplina:</label>
				<select name="discipline" id="dialog_edit_discipline" class="ui-widget-content ui-corner-all">
					<option></option>
					<!-- BEGIN add_discipline -->
					<option value="{discipline_id}" data-credits="{discipline_credits}">{discipline_name} ({discipline_credits})</option>
					<!-- END add_discipline -->
				</select>
				<label id="dialog_edit_discipline-error" class="error" for="dialog_edit_discipline"></label>
			</div>
			<div>
				<label>Cr&eacute;ditos:</label>
			</div>
			<div class="credits">
				<label for="dialog_edit_theory">Teoria:</label>
				<input type="text" name="theory" id="dialog_edit_theory" class="ui-widget-content ui-corner-all credits_input">
				<label id="dialog_edit_theory-error" class="error" for="dialog_edit_theory"></label>
			</div>
			<div class="credits">
				<label for="dialog_edit_exercice">Exerc&iacute;cios:</label>
				<input type="text" name="exercice" id="dialog_edit_exercice" class="ui-widget-content ui-corner-all credits_input">
				<label id="dialog_edit_exercice-error" class="error" for="dialog_edit_exercice"></label>
			</div>
			<!-- Allow form submission with keyboard without duplicating the dialog button -->
			<input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
		</fieldset>
	</form>
</div>

<div id="delete_confirmation_dialog" title="Exclus&atilde;o de turma.">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span id="delete_confirmation_dialog_description"></span></p>
</div>

<div class="right">
	<button class="new_discipline">Nova disciplina</button>
</div>