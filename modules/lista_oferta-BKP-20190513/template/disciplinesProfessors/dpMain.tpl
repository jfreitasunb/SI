<tr><td class="i height">
	<div id="container">
		<div id="disciplines" class="height">
			<!-- BEGIN add_discipline -->
			<a href="disciplines_professors.php?discipline={discipline_id}"><div class="discipline<!-- BEGIN discipline_selected --> selected<!-- END discipline_selected -->">{discipline_name}</div></a>
			<!-- END add_discipline -->
		</div>
		<div id="classes" class="height">
			<table id="classes_table" class="form display">
			<thead>
				<tr>
					<th>Professor</th>
					<th>Turma</th>
					<th>Horário</th>
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN add_class -->
				<tr>
					<td>{class_professor_name} {class_professor_last_name}</td>
					<td>{class_class}</td>
					<td>{class_schedule}</td>
				</tr>
				<!-- END add_class -->
			</tbody>
		</table>
		</div>
		<div class="clear"></div>
	</div>
</td></tr>