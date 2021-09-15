<?php

require "conexao.php";

session_start();


$login = isset($_POST["login"]) ? addslashes(trim($_POST["login"])) : FALSE;

$senha = isset($_POST["senha"]) ? MD5(trim($_POST["senha"])) : FALSE;

// Usuário não forneceu a senha ou o login
if(!$login || !$senha)
{
   	header("Location: login_nao_forneceu.php");
	 exit;
}

$SQL = "SELECT nome,senha 
        FROM usuarios
        WHERE login = '$login'";
$result_id = pg_query($SQL) or die("Erro no banco de dados!");
$total = pg_num_rows($result_id);

// Caso o usuário tenha digitado um login válido o número de linhas será 1..
if($total)
{
    // Obtém os dados do usuário, para poder verificar a senha e passar os demais dados para a sessão
    $dados = pg_fetch_array($result_id);

    // Agora verifica a senha
    if(!strcmp($senha, $dados["senha"]))
    {
        // TUDO OK! Agora, passa os dados para a sessão e redireciona o usuário
        $_SESSION["nome_usuario"] = stripslashes($dados["login"]);
        header("Location: index1.php");
        exit;
    }
    // Senha inválida
    else
    {
	header("Location: senha_invalida.php");
        exit;
    }
}
// Login inválido
else
{
	header("Location: login_invalido.php");		
    exit;
}
?>
