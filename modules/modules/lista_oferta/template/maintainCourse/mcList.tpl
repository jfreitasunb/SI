<tr>
	<td align="center">
		<table id="courses_table" class="form display">
			<thead>
				<tr>
					<th>Código</th>
					<th>Nome</th>
					<th>Créditos</th>
					<th>Tipo</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN add_course -->
				<tr>
					<td>{course_id}</td>
					<td>{course_name}</td>
					<td>{course_credits}</td>
					<td>{course_type}</td>
					<td>
						<a href="{course_link_edit}"><button class="edit_course">Editar</button></a>
					</td>
				</tr>
				<!-- END add_course -->
			</tbody>
		</table>
	</td>
</tr>