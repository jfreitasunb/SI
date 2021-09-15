<tr>
	<td align="center">
		<table id="disciplines_table" class="form display">
			<thead>
				<tr>
					<th rowspan="2">Disciplina</th>
					<th colspan="2">Cr&eacute;ditos</th>
					<th rowspan="2"></th>
					<th rowspan="2"></th>
					<th rowspan="2"></th>
				</tr>
				<tr>
					<th>Teoria</th>
					<th>Exerc&iacute;cios</th>
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN add_discipline -->
				<tr id="line_{discipline_id}">
					<td id="discipline_name_{discipline_id}" data-discipline="{discipline_discipline}">{discipline_name} ({discipline_credits})</td>
					<td id="theory_quantity_{discipline_id}">{discipline_theory_quantity}</td>
					<td id="exercises_quantity_{discipline_id}">{discipline_exercises_quantity}</td>
					<td>
						<button id="edit_{discipline_id}" class="edit_magisterial_discipline">Editar</button>
					</td>
					<td><button id="delete_{discipline_id}" class="delete_magisterial_discipline">Excluir</button></td>
					<td><a href="?discipline={discipline_discipline}"><button>Grupos Teoria</button></a></td>
				</tr>
				<!-- END add_discipline -->
			</tbody>
		</table>
	</td>
</tr>