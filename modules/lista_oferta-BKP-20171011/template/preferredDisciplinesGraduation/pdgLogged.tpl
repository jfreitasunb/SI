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
					<input name="quantity_{option_number}" <!-- BEGIN quantity_is_hidden -->type="hidden"<!-- END quantity_is_hidden --> class="quantity_input" id="quantity_{option_number}" value="{option_quantity}" title="É obrigatório o preenchimento da Quantidade {option_number}" required aria-required="true">
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
<!-- BEGIN exist_granted_credit -->
<tr>
	<td align="center">
		<table id="granted_credits_table" class="form display">
			<thead>
			<tr>
				<th colspan="3" class="title">Carga Concedida</th>
			</tr>
			<tr>
				<th>Grupo</th>
				<th>Atividade</th>
				<th>Carga</th>
			</tr>
			</thead>
			<tfoot>
			<tr>
				<th colspan="2">Total</th>
				<th class="total">{granted_credit_total}</th>
			</tr>
			</tfoot>
			<tbody>
			<!-- BEGIN add_granted_credit -->
			<tr>
				<td>{granted_credit_group_description}</td>
				<td class="activity">{granted_credit_activity_description}</td>
				<td class="credits">{granted_credit_credits}</td>
			</tr>
			<!-- END add_granted_credit -->
			</tbody>
		</table>
	</td>
</tr>
<tr><td><br></td></tr>
<!-- END exist_granted_credit -->
<tr>
	<td align="center">
		<input class="submit" type="submit" value="Salvar">
	</td>
</tr>