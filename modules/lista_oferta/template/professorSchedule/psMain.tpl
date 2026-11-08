<tr><td>
	<div id="container">
		<div id="professors" class="height not_print">
			<!-- BEGIN add_professor -->
			<a href="./professor_schedule.php?professor={professor_professor}">
				<div class="professor<!-- BEGIN professor_selected --> selected<!-- END professor_selected -->" >
					{professor_name} {professor_last_name}
				</div>
			</a>
			<!-- END add_professor -->
			<!-- BEGIN exist_comment --><div class="comment">* Professores que n&atilde;o escolheram disciplinas.</div><!-- END exist_comment -->
		</div>
		<div id="scheduleDiv">
			<div id="scheduleContent">
				<table class="form" class="no-spacing" cellspacing="0">
					<thead>
						<tr>
							<th class="time">Hor&aacute;rio</th>
							<th class="day">Segunda</th>
							<th class="day">Ter&ccedil;a</th>
							<th class="day">Quarta</th>
							<th class="day">Quinta</th>
							<th class="day">Sexta</th>
							<th class="day">S&aacute;bado</th>
						</tr>
					</thead>
					<tbody>
						<!-- BEGIN add_schedule_row --><tr>
							<!-- BEGIN add_schedule_cell -->
							<td<!-- BEGIN schedule_cell_real --> rowspan="2"<!-- END schedule_cell_real -->>{schedule_cell_value}</td><!-- END add_schedule_cell -->
						</tr><!-- END add_schedule_row -->
					</tbody>
				</table>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</td></tr>
