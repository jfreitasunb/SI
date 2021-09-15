<?php

	if(!isset($_POST["login"]))
	{
	echo"
	<html>
	<head><title>Autenticação: formulário</title></head>
	<body>
	<form action='usuarios.php' method='post'>
	Preencha os campos abaixo corretamente.<br>
	Nome: <input type='text' name='nome'><br>
	Login: <input type='text' name='login'><br>
	Senha: <input type='password' name='senha1'><br>
	Repetir senha: <input type='password' name='senha2'><br>
	<input type='submit' value='Efetuar'>
	</form>
	</body></html>";

	}
	else if(!$nome || !$login || !$senha1 || !$senha2)
	{
	echo "
	É necessário o preenchimento de todos os campos. Queira retornar.";
	echo"<p><a href='javascript:history.back();'> Retornar</a></p>";
	}
	
	else if(strcmp($senha1,$senha2))
	{
	echo"As senhas não conferem. Queira retornar.";
	echo"<p><a href='javascript:history.back();'> Retornar</a></p>";
	}
	
	else
	{
	require "conexao.php";
	$c_senha=MD5("$senha1");
	$inserir=pg_query("INSERT INTO usuarios (id_usuario,nome,login,senha) VALUES (default,'$nome','$login','$c_senha')")
	or die("Não foi possível acrescentar o usuário ao banco de dados.");
	echo"Usuário inserido com sucesso. Não esqueça de efetuar as permissões posteriormente.";
	echo"<p><a href='usuarios.php'> Nova inserção</a></p>";
	}
?>

		
