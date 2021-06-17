<?php

require "conexao.php";

session_start();


$login = isset($_POST["login"]) ? addslashes(trim($_POST["login"])) : FALSE;

$senha = isset($_POST["senha"]) ? addslashes(trim($_POST["senha"])) : FALSE;

// Usuário não forneceu a senha ou o login
if(!$login || !$senha)
{
    echo "
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<title>Servidor Administrativo</title><style type="text/css" media="all">@import "style.css";</style></head>

<body>

<div id="Header"></div>

<div id="Content">
        <h1>Autenticação Inválida</h1>
	<p> Você deve digitar sua senha e login! </p>
        <p><a href="login1.html" title="Layouts to make your own...">&lt; Retornar</a>
	</p>
</div>
</body></html>";
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
        header("Location: index.html");
        exit;
    }
    // Senha inválida
    else
    {
        echo "

	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">

<title>Servidor Administrativo</title><style type="text/css" media="all">@import "style.css";</style></head>

<body>

<div id="Header"></div>

<div id="Content">
        <h1>Autenticação Inválida</h1>
        <p> A senha fornecida é incorreta! </p>
        <p><a href="login1.html" title="Layouts to make your own...">&lt; Retornar</a>
        </p>
</div>
</body></html>";

        exit;
    }
}
// Login inválido
else
{
    echo "
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">

<title>Servidor Administrativo</title><style type="text/css" media="all">@import "style.css";</style></head>

<body>

<div id="Header"></div>

<div id="Content">
        <h1>Autenticação Inválida</h1>
        <p> O login fornecido não existe! </p>
        <p><a href="login1.html" title="Layouts to make your own...">&lt; Retornar</a>
        </p>
</div>
</body></html>";

    exit;
}
?> 
