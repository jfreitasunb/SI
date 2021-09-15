<tr>
	<td align="center">
		<table class="form">
			<tr>
				<td class="header" align="center" colspan="3">
					Disciplina
				</td>
			</tr>
			<tr>
				<td>
					<label for="id">Código</label>
				</td>
				<td>
					<input name="id" title="O campo código é obrigatório" required aria-required="true" value="{course_id}">
					<!-- BEGIN is_discipline_update --><input name="update" type="hidden" value="true"><!-- END is_discipline_update -->
				</td>
				<td>
					<label id="id-error" class="error" for="id"></label>
				</td>
			</tr>
			<tr>
				<td>
					<label for="name">Nome</label>
				</td>
				<td>
					<input name="name" title="O campo nome é obrigatório" required aria-required="true" value="{course_name}">
				</td>
				<td>
					<label id="name-error" class="error" for="name"></label>
				</td>
			</tr>
			<tr>
				<td>
					<label for="credits">Créditos</label>
				</td>
				<td>
					<input name="credits" title="O campo créditos é obrigatório" required aria-required="true" value="{course_credits}">
				</td>
				<td>
					<label id="credits-error" class="error" for="credits"></label>
				</td>
			</tr>
			<tr>
				<td>
					<label for="type_key">Tipo</label>
				</td>
				<td>
					<select name="type_key" title="O campo tipo é obrigatório" required aria-required="true">
						<option></option>
						<!-- BEGIN add_type -->
						<option value="{type_short_value}" <!-- BEGIN type_selected --> selected="selected" <!-- END type_selected -->>{type_value}</option>
						<!-- END add_type -->
					</select>
				</td>
				<td>
					<label id="type_key-error" class="error" for="type_key"></label>
				</td>
			</tr>
			<tr>
				<td>
					<br>
				</td>
			</tr>
			<tr><td>
					<label for="password">Senha</label>
				</td>
				<td>
					<input name="password" type="password" title="A senha é obrigatória" required aria-required="true">
				</td>
				<td>
					<label id="password-error" class="error" for="password"></label>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr><td><br></td></tr>
<tr>
	<td align="center">
		<input class="submit" type="submit" value="{save_label}">
	</td>
</tr>