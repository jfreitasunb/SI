<tr>
	<td align="center">
		<table class="form">
			<tr>
				<td class="header" align="center" colspan="3">
					Atividade
				</td>
			</tr>
			<tr>
				<td>
					<label for="group_key">Grupo</label>
				</td>
				<td>
					<select name="group_key">
						<option></option>
						<!-- BEGIN add_group -->
						<option value="{group_short_value}" <!-- BEGIN group_selected --> selected="selected" <!-- END group_selected -->>{group_long_value}</option>
						<!-- END add_group -->
					</select>
					<input type="hidden" name="id" value="{activity_id}">
				</td>
				<td>
					<label id="group_key-error" class="error" for="group_key"></label>
				</td>
			</tr>
			<tr>
				<td>
					<label for="description">Atividade</label>
				</td>
				<td>
					<input name="description" value="{activity_description}">
				</td>
				<td>
					<label id="description-error" class="error" for="description"></label>
				</td>
			</tr>
			<tr>
				<td>
					<label for="credits">Carga</label>
				</td>
				<td>
					<input name="credits" value="{activity_credits}">
				</td>
				<td>
					<label id="credits-error" class="error" for="credits"></label>
				</td>
			</tr>
			<tr>
				<td>
					<label for="maximum">Quantidade Permitida</label>
				</td>
				<td>
					<input name="maximum" value="{activity_maximum}">
				</td>
				<td>
					<label id="maximum-error" class="error" for="maximum"></label>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr><td><br></td></tr>
<tr>
	<td align="center">
		<input class="submit" type="submit" value="Salvar">
	</td>
</tr>