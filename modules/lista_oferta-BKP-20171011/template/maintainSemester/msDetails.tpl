<tr>
	<td align="center">
		<table class="form">
			<tr>
				<td class="header" align="center" colspan="3">
					Editar Semestre
				</td>
			</tr>
			<tr>
				<td>
					<label for="beginning">Início</label>
				</td>
				<td>
					<input name="beginning" id="beginning" value="{semester_beginning}">
				</td>
				<td>
					<label id="beginning-error" class="error" for="beginning"></label>
				</td>
			</tr>
			<tr>
				<td>
					<label for="end">Fim</label>
				</td>
				<td>
					<input name="end" id="end" value="{semester_end}">
				</td>
				<td>
					<label id="end-error" class="error" for="end"></label>
				</td>
			</tr>
			<tr><td colspan="3"><br></td></tr>
			<tr>
				<td>
					<label for="average_credits">Carga Média</label>
				</td>
				<td>
					<input name="average_credits" value="{semester_average_credits}">
				</td>
				<td>
					<label id="average_credits-error" class="error" for="average_credits"></label>
				</td>
			</tr>
			<tr><td colspan="3"><br></td></tr>
			<tr>
				<td>
					<label for="status">Etapa</label>
				</td>
				<td>
					<select name="status">
						<!-- BEGIN add_stage -->
						<option value="{stage_id}" <!-- BEGIN stage_selected --> selected="selected" <!-- END stage_selected -->>{stage_description}</option>
						<!-- END add_stage -->
					</select>
				</td>
				<td>
					<label id="status-error" class="error" for="status"></label>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr><td><br></td></tr>
<tr>
	<td align="center">
		<input type="submit" value="Salvar">
	</td>
</tr>