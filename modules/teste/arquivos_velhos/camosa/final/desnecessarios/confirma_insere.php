<?php

require "verifica.php";

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">

<title>Servidor Administrativo</title><style type="text/css" media="all">@import "style.css";</style></head>



<body>

<div id="Header"></div>

<div id="Content">
	<h1>Confirmação</h1>
<p> Deseja inserir o seguinte documento? </p>

      <p><a>Tipo de Documento: </a><?php=$id_tipo;?></p>
      <p><a>Destino: </a><?php=$id_departamentos;?></p>
      <p><a>Assunto: </a><?php=$assunto;?></p>
      <p><a>Vocativo: </a><?php=$vocativo;?></p>
      <p><a>Mensagem: </a><?php=$mensagem;?></p>
      <p><a>Desfecho: </a><?php=$desfecho;?></p>
      <p><a>Assinatura: </a><?php=$assinatura;?></p>
  <br>
<form name="form1" method="post" action="operacao.php">
  <div align="center">
    <input name='id_tipo' type='hidden' value='<?php=$id_tipo?>'>
    <input name='id_departamentos' type='hidden' value='<?php=$id_departamentos?>'>
    <input name='assunto' type='hidden' value='<?php=$assunto?>'>
    <input name='vocativo' type='hidden' value='<?php=$vocativo?>'>
    <input name='mensagem' type='hidden' value='<?php=$mensagem?>'>
    <input name='desfecho' type='hidden' value='<?php=$desfecho?>'>
    <input name='assinatura' type='hidden' value='<?php=$assinatura?>'>
    <input name='acao' type='hidden' value='<?php=$acao?>'>
    <input type="submit" name="Submit" value="Confirmar">

</div>

<div id="Menu">
	<a href="exercicio_insere.php">Preencher Formulário</a><br>
        <a href="exercicio_edita_lista.php">Buscar Documentos</a><br>
        <a href="sair.php">Sair</a><br>

</div>
</body></html>
