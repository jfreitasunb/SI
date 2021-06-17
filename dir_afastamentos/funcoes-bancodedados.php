<?php
error_reporting(E_ALL ^E_WARNING ^E_NOTICE);
function conexao()
	{	
		$banco 		='unb_si';
		$usuario 	= 'root';
		$senha 		= '';
		$host 		= 'localhost';  
		$conn = mysql_connect($host,$usuario,$senha) or die('Erro na rotina de conexão: '.mysql_error());
		mysql_select_db($banco) or die ('Erro na Escolha do Banco de Dados: '.mysql_error());
		mysql_query("SET NAMES 'utf8'");
        mysql_query('SET character_set_connection=utf8');
        mysql_query('SET character_set_client=utf8');
        mysql_query('SET character_set_results=utf8');
	}

function inserir($sql)
	{
//		if (mysql_query($sql))
		if (pg_query($sql)) 
		{return TRUE;}
		else 
		{return FALSE;}
	}
	

function selecionar($sql)
	{
//	return mysql_query($sql);	
	return pg_query($sql);
	}
?>