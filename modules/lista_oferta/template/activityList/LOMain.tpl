<tr>
    <td align="center" class="not_print">
        <table class="form">
            <tr>
                <td class="header" align="center" colspan="2">
                    Selecionar Semestre
                </td>
            </tr>
            <tr><td colspan="3"><br></td></tr>
            <tr>
                <td>
                    <label>Semestre</label>
                </td>
                <td>
                    <select id="semester">
                        <!-- BEGIN add_semester -->
                        <option <!-- BEGIN semester_selected -->selected<!-- END semester_selected --> value="{semester_year}-{semester_semester}">{semester_year}/{semester_semester}</option>
                        <!-- END add_semester -->
                    </select>
                </td>
            </tr>
            <tr><td colspan="3"><br></td></tr>
            <tr>
                <td align="center" colspan="2">
                    <button id="select">Selecionar</button>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr><td class="not_print"><br></td></tr>
<!-- BEGIN not_empty -->
<tr>
	<td align="center">
		<table id="activity_list">
			<tr>
				<th>Professor</th>
                <th class="activity_part">
                    <table>
                        <th class="activity_activity">Atividade</th>
                        <th class="activity_description">Descri&ccedil;&atilde;o</th>
                        <th class="activity_code">C&oacute;digo</th>
                        <th class="activity_class">Turma</th>
                        <th class="activity_period">Turno</th>
                        <th class="activity_schedule">Hor&aacute;rios</th>
                        <th class="activity_credits">Carga</th>
                    </table>
                </th>
				<th>Total</th>
			</tr>
			<!-- BEGIN add_professor -->
			<tr class="row_class_{activity_professor_row_class}">
				<td class="activity_professor">{activity_professor_name} {activity_professor_last_name}</td>
				<td class="activity_part">
					<table>
                        <!-- BEGIN add_activity -->
                        <tr>
                            <td class="activity_activity">
                                {activity_activity}
                            </td>
                            <td class="activity_description">
                                {activity_description}
                            </td>
                            <td class="activity_code">
                                {activity_code}
                            </td>
                            <td class="activity_class">
                                {activity_class}
                            </td>
                            <td class="activity_period">
                                {activity_period}
                            </td>
                            <td class="activity_schedule">
                                {activity_schedule}
                            </td>
                            <td class="activity_credits">
                                {activity_credits}
                            </td>
                        </tr>
                        <!-- END add_activity -->
                    </table>
				</td>
				<td class="activity_credits_total">{activity_professor_credits_total}</td>
			</tr>
			<!-- END add_professor -->
		</table>
	</td>
</tr>
<!-- END not_empty -->
<!-- BEGIN empty -->
<tr>
    <td align="center">Lista de atividades não disponível para o semestre {empty_semester_year}/{empty_semester_semester}.</td>
</tr>
<!-- END empty -->