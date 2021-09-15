<tr>
	<td align="center">
		<select class="prof" name="professor" required aria-required="true" style="width: auto" onchange="if (this.value) window.location.href='/teste.php?user='+this.value; else window.location.href='/teste.php';">
			<option></option>
			<!-- BEGIN add_professor -->
			<option value="{professor_id}" <!-- BEGIN professor_selected --> selected="selected" <!-- END professor_selected -->>{professor_name} {professor_last_name}</option>
			<!-- END add_professor -->
		</select>
	</td>
</tr>
<tr>
	<td align="center">
		<table class="form">
			<tr>
				<td class="header" align="center" colspan="2">
					Disciplina
					<input type="hidden" name="alter_disciplines" value="true">
				</td>
				<td class="header" align="center" colspan="2">
					Quantidade
				</td>
			</tr>
			<!-- BEGIN add_option -->
			<tr>
				<td>
					<label for="discipline_{option_number}">Opção {option_number}</label>
				</td>
				<td>
					<select class="discipline" name="discipline_{option_number}" id="discipline_{option_number}" title="É obrigatório o preenchimento da Disciplina {option_number}" required aria-required="true">
						<option></option>
						<!-- BEGIN add_lo_temp -->
						<option value="{lo_temp_period}-{lo_temp_discipline}" <!-- BEGIN exist_lo_temp_selected --> selected="selected" <!-- END exist_lo_temp_selected -->>{lo_temp_period}: {lo_temp_discipline_id}-{lo_temp_discipline_name} ({lo_temp_discipline_credits})</option>
						<!-- END add_lo_temp -->
						<!-- NOTURNO: {discipline_id}-{discipline_name} ({discipline_credits}) ANTIGO {discipline_name} - {discipline_credits}-->
					</select>
				</td>
				<td>
					<input name="quantity_{option_number}" class="quantity_input" id="quantity_{option_number}" value="{option_quantity}" title="É obrigatório o preenchimento da Quantidade {option_number}" required aria-required="true">
				</td>
				<td>
					<label id="discipline_{option_number}-error" class="error" for="discipline_{option_number}"></label>
				</td>
			</tr>
			<!-- END add_option -->
		</table>
	</td>
</tr>
<tr><td><br></td></tr>
<tr>
	<td align="center">
		<input class="submit" type="submit" value="Salvar">
	</td>
</tr>