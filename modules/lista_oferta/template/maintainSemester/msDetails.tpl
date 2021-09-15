<tr>
	<td align="center">
		<table class="form">
			<tr>
				<td class="header" align="center" colspan="3">
					Editar Semestre
				</td>
			</tr>
			<tr>
				<td>
					<label for="beginning">In&iacute;cio</label>
				</td>
				<td>
					<input name="beginning" id="beginning" value="{semester_beginning}">
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
					<input name="end" id="end" value="{semester_end}">
				</td>
				<td>
					<label id="end-error" class="error" for="end"></label>
				</td>
			</tr>
			<!-- tr><td colspan="3"><br></td></tr>
			<tr>
				<td>
					<label for="average_credits">Abatimento de Carga</label>
				</td>
				<td>
					<input name="reduction_credits2" value="{semester_reduction_credits}">
				</td>
				<td>
					<label id="average_credits-error" class="error" for="average_credits"></label>
				</td>
			</tr -->
			<tr><td colspan="3"><br></td></tr>
			<tr><td colspan="3">
				<div class="credits">
					<div class="title master"><div class="content">Carga Existente</div></div>
					<div class="title type"><div class="content">Gradua&ccedil;&atilde;o</div></div>
					<div class="title type"><div class="content">P&oacute;s</div></div>
					<div class="title type"><div class="content">Outros</div></div>
					<div class="title type"><div class="content">Total</div></div>
					<div class="type data"><div class="content">{credits_class_graduation}</div></div>
					<div class="type data"><div class="content">{credits_class_post}</div></div>
					<div class="type data"><div class="content">{credits_other}</div></div>
					<div class="type data"><div class="content">{credits_total}</div></div>
					<div class="clear"></div>
				</div>
				<div class="credits professor">
					<div class="title master"><div class="content">Carga Excedente</div></div>
					<div class="title type t33"><div class="content">Publica&ccedil;&otilde;es</div></div>
					<div class="title type t33"><div class="content">Limiar</div></div>
					<div class="title type t33"><div class="content">Abatimento</div></div>
					<div class="type t33 data">
						<div class="content">{credits_publications_credits_above_threshold}</div>
					</div>
					<div class="type t33 data">
						<div class="content">
							<input name="publications_threshold" value="{semester_publications_threshold}">
							<label id="publications_threshold-error" class="error" for="publications_threshold"></label>
						</div>
					</div>
					<div class="type t33 data">
						<div class="content">
							<input name="reduction_credits" value="{semester_reduction_credits}">
							<label id="reduction_credits-error" class="error" for="reduction_credits"></label>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="credits professor">
					<div class="title type"><div class="content">N&ordm; Prof.</div></div>
					<div class="type"><div class="content">{credits_professors}</div></div>
					<div class="title type"><div class="content">M&eacute;dia</div></div>
					<div id="mean" class="type"><div class="content">{credits_mean}</div></div>
					<div class="clear"></div>
				</div>
			</td></tr>
			<tr><td colspan="3"><br></td></tr>
			<tr>
				<td>
					<label for="average_credits">Carga M&eacute;dia</label>
				</td>
				<td>
					<input name="average_credits" value="{semester_average_credits}">
				</td>
				<td>
					<label id="average_credits-error" class="error" for="average_credits"></label>
				</td>
			</tr>
			<tr><td colspan="3"><br></td></tr>
			<tr>
				<td>
					<label for="status">Etapa</label>
				</td>
				<td>
					<select name="status">
						<!-- BEGIN add_stage -->
						<option value="{stage_id}" <!-- BEGIN stage_selected --> selected="selected" <!-- END stage_selected -->>{stage_description}</option>
						<!-- END add_stage -->
					</select>
				</td>
				<td>
					<label id="status-error" class="error" for="status"></label>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr><td><br></td></tr>
<tr>
	<td align="center">
		<input type="submit" value="Salvar">
	</td>
</tr>