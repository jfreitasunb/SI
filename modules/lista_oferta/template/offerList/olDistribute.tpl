<div id="logout" class="right">
	<form method="post" id="clean_form">
		<input type="submit" value="Remover distribui&ccedil;&otilde;es">
		<input type="hidden" value="true" name="clean">
	</form>
	<button id="distribute">Distribuir</button>
</div>

<div class="left">
	<button id="hide_unselected_professors">Esconder n&atilde;o escolhidos</button>
	<button id="hide_classes_with_professor">Esconder turmas com professores</button>
</div>

<div id="dialog_clean">
	<p>
		Deseja realmente remover as distribui&ccedil;&otilde;es?
	</p>
</div>

<div id="dialog_distribute">
	<p>
		Nesta distribuição existem {credits_professors} professores de DE ativos
	</p>
	<p>
		A carga média calculada pelo sistema é de: {credits_system}
	</p>
	<p>
		A carga média inserida pelo coordenador é de: {credits_coordinator}
	</p>
</div>