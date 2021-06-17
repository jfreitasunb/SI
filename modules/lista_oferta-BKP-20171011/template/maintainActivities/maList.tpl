<tr>
	<td align="center">
		<table id="activities_table" class="form display">
			<thead>
				<tr>
					<th>Responsável</th>
					<th>Grupo</th>
					<th>Atividade</th>
					<th>Carga</th>
					<th>Quantidade Permitida</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN add_activity -->
				<tr>
					<td>{activity_responsible}</td>
					<td>{activity_group}</td>
					<td>{activity_description}</td>
					<td>{activity_credits}</td>
					<td>{activity_maximum}</td>
					<td>
						<a href="{activity_link_edit}"><button class="edit_activity">Editar</button></a>
					</td>
				</tr>
				<!-- END add_activity -->
			</tbody>
		</table>
	</td>
</tr>
<tr><td><br></td></tr>
<tr>
	<td align="center">
		<a href="{link_new_activity}"><button class="new_activity">Nova atividade</button></a>
	</td>
</tr>