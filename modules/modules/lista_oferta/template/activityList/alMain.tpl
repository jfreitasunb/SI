<tr>
	<td align="center">
		<table id="activity_list">
			<tr>
				<th>Professor</th>
				<th>Atividade</th>
				<th>Descrição</th>
				<th>Código</th>
				<th>Turma</th>
				<th>Turno</th>
				<th>Horários</th>
				<th>Carga</th>
				<th>Total</th>
			</tr>
			<!-- BEGIN add_activity -->
			<tr class="row_class_{activity_professor_row_class}">
				<!-- BEGIN add_professor -->
				<td rowspan="{activity_professor_activity_count}">{activity_professor_name} {activity_professor_last_name}</td>
				<!-- END add_professor -->
				<td>{activity_activity}</td>
				<td>{activity_description}</td>
				<td>{activity_code}</td>
				<td>{activity_class}</td>
				<td>{activity_period}</td>
				<td>{activity_schedule}</td>
				<td>{activity_credits}</td>
				<!-- BEGIN add_total -->
				<td rowspan="{activity_professor_activity_count}">{activity_professor_credits_total}</td>
				<!-- END add_total -->
			</tr>
			<!-- END add_activity -->
		</table>
	</td>
</tr>