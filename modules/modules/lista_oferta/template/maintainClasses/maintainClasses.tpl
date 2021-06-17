<tr>
	<td align="center">
		<table id="classes_table" class="form display">
			<thead>
				<tr>
					<th>Disciplina</th>
					<th>Turma</th>
					<th>Período</th>
					<th>Hor&aacute;rio</th>
					<th>Sala</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN add_class -->
				<tr id="line_{class_id}">
					<td id="discipline_name_{class_id}">{class_discipline_name}</td>
					<td id="class_{class_id}">{class_class}</td>
					<td id="period_{class_id}">{class_period}</td>
					<td id="schedule_{class_id}">{class_schedule}</td>
					<td id="classroom_{class_id}">{class_classroom}</td>
					<td>
						<button id="edit_{class_id}" class="edit_class">Editar</button>
						<input type="hidden" id="discipline_id_{class_id}" value="{class_discipline_id}">
					</td>
					<td><button id="delete_{class_id}" class="delete_class">Excluir</button></td>
				</tr>
				<!-- END add_class -->
			</tbody>
		</table>
	</td>
</tr>