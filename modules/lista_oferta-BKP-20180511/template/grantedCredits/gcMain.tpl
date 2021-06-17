<tr>
	<td align="center">
		<form id="granted_credits_form" method="post" style="height: 100%;">
			<table style="height: 100%;">
				<tr>
					<td>
						<table id="table_fields" class="form">
							<tr>
								<td class="header" align="center" colspan="3">
									Concess&atilde;o de Carga
								</td>
							</tr>
							<tr>
								<td>
									<label for="teacher">Professor</label>
								</td>
								<td>
									<select name="teacher">
										<option></option>
										<!-- BEGIN add_teacher -->
										<option value="{teacher_id}">{teacher_name} {teacher_last_name}</option>
										<!-- END add_teacher -->
									</select>
								</td>
								<td>
									<label id="teacher-error" class="error" for="teacher"></label>
								</td>
							</tr>
							<tr>
								<td>
									<label for="group">Grupo</label>
								</td>
								<td>
									<select id="group" name="group">
										<option></option>
										<!-- BEGIN add_group -->
										<option value="{group_short_value}">{group_value}</option>
										<!-- END add_group -->
									</select>
								</td>
								<td>
									<label id="group-error" class="error" for="group"></label>
								</td>
							</tr>
							<tr id="activity_line">
								<td>
									<label for="activity">Atividade</label>
								</td>
								<td>
									<select id="activity" name="activity">
										<option></option>
										<!-- BEGIN add_activity -->
										<option value="{activity_id}">{activity_value}</option>
										<!-- END add_activity -->
									</select>
								</td>
								<td>
									<label id="activity-error" class="error" for="activity"></label>
								</td>
							</tr>
							<tr>
								<td>
									<label for="credits">Carga</label>
								</td>
								<td>
									<input id="credits" name="credits">
								</td>
								<td>
									<label id="credits-error" class="error" for="credits"></label>
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
				<tr><td><br></td></tr>
			</table>
		</form>
	</td>
</tr>
<tr>
	<td align="center">
		<table id="granted_credits_table" class="form display">
			<thead>
			<tr>
				<th>Professor</th>
				<th>Grupo</th>
				<th>Atividade</th>
				<th>Carga</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<!-- BEGIN add_granted_credit -->
			<tr>
				<td class="professor">{granted_credit_teacher_name} {granted_credit_teacher_last_name}</td>
				<td>{granted_credit_group_description}</td>
				<td class="activity">{granted_credit_activity_description}</td>
				<td class="credits">{granted_credit_credits}</td>
				<td>
					<button class="bt_remove" data-id="{granted_credit_id}">Remover</button>
				</td>
			</tr>
			<!-- END add_granted_credit -->
			</tbody>
		</table>
	</td>
</tr>