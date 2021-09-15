<html>
  <header>
    <script language=javascript src="function_js.js">
    </script>
    <script language=javascript src="formu.js">
    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
  </header>
  <body>
      <table class=big>
      <tr><td class=header align=center>
      <h1>Controle de Documentos</h1></td></tr>
      <tr>
        <td align=center>
          <table class=form>
          <tr>
            		<?php
				$editar="editar";
				$buscar="buscar";
					echo "  <div id='Menu'>
                			<a href='index1.php'>Início</a><br>
                			<a href='gerar1.php'>Gerar</a><br>
                			<a href='buscador.php?variavel=$editar'>Editar</a><br>
                			<a href='buscador.php?variavel=$buscar'>Buscar</a><br>
					<a href='inserir_doc_antigo.php'>Documentos Antigos</a><br>
                			<a href='sair.php'>Sair</a><br>
        				</div>";
			?>
	</table>
</table>
</body>
</html>";