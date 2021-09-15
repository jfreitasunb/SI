<tr>
	<td align="center">
		<table id="professors_table" class="form display">
			<thead>
				<tr>
					<th class="header">
						Professor
					</th>
					<th class="header">
						Créditos
					</th>
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN add_professor -->
				<tr>
					<td><label>{professor_description}</label></td>
					<td><input name="user_{professor_id}" value="{professor_credits}"></td>
				</tr>
				<!-- END add_professor -->
			</tbody>
		</table>
	</td>
</tr>
<tr><td><br></td></tr>
<tr>
	<td align="center">
		<input type="submit" value="Salvar">
	</td>
</tr>