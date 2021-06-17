<tr>
	<td align="center">
		<table class="form">
			<tr>
				<td class="header" align="center" colspan="3">
					Criar Semestre
				</td>
			</tr>
			<tr>
				<td>
					<label for="year">Ano</label>
				</td>
				<td>
					<input name="year">
				</td>
				<td>
					<label id="year-error" class="error" for="year"></label>
				</td>
			</tr>
			<tr>
				<td>
					<label for="semester">Semestre</label>
				</td>
				<td>
					<input name="semester">
				</td>
				<td>
					<label id="semester-error" class="error" for="semester"></label>
				</td>
			</tr>
			<!-- BEGIN date_beginning_end_semester -->
			<tr>
				<td>
					<label for="beginning">In&iacute;cio</label>
				</td>
				<td>
					<input name="beginning" id="beginning">
				</td>
				<td>
					<label id="beginning-error" class="error" for="beginning"></label>
				</td>
			</tr>
			<tr>
				<td>
					<label for="end">Fim</label>
				</td>
				<td>
					<input name="end" id="end">
				</td>
				<td>
					<label id="end-error" class="error" for="end"></label>
				</td>
			</tr>
			<!-- BEGIN date_beginning_end_semester -->
			<tr><td colspan="3"><br></td></tr>
			<tr>
				<td>
					<label for="clone">Clonar de</label>
				</td>
				<td>
					<select name="clone">
						<option></option>
						<!-- BEGIN add_semester -->
						<option value="{semester_year}/{semester_semester}">{semester_year}/{semester_semester}</option>
						<!-- END add_semester -->
					</select>
				</td>
				<td>
					<label id="clone-error" class="error" for="clone"></label>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr><td><br></td></tr>
<tr>
	<td align="center">
		<input type="submit" value="Criar">
	</td>
</tr>