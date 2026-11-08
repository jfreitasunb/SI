<tr>
	<td align="center"><h3>{professor_count_total} Professores ({professor_count_total_de} DE / {professor_count_total_sb} Substitutos)</h3>
	<h3>{professor_count_actives} Ativos ({professor_count_actives_de} DE / {professor_count_actives_sb} Substitutos)</h3></td>
</tr>
<tr>
	<td align="center">
		<table id="professors_table" class="form display">
			<thead>
				<tr>
					<th>Nome</th>
					<th>Tipo de Contrato</th>
					<th>Ativo</th>
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN add_professor -->
				<tr>
					<td>{professor_name} {professor_last_name}</td>
					<td>{professor_contract_type}</td>
					<td>
						<input type="hidden" name="status_{professor_professor}" value="0" />
						<input name="status_{professor_professor}" type="checkbox"<!-- BEGIN professor_status_enable --> checked<!-- END professor_status_enable -->  value="1">
					</td>
				</tr>
				<!-- END add_professor -->
			</tbody>
		</table>
	</td>
</tr>
<tr><td><br></td></tr>
<tr>
	<td align="center">
		<input class="submit" type="submit" value="Salvar">
	</td>
</tr>