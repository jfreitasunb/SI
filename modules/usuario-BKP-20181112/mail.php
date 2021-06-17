<?php

//Recebendo os dados do formul?rio.

$nome = $_POST["nome"];
$email = $_POST["email"];
$assunto = $_POST["assunto"];
$mensagem=$_POST["mensagem"];

//Setando o restante das vari?veis para o disparo do email

$destinatario = "seu_email";
$formato = "\nContent-type: text/html\n";

//Incluindo os campos nome e email no corpo da mensagem.

$msg = "- Nome: ".$nome."<br>- Assunto: ".$assunto."<br>- Mensagem: ".$mensagem;

//Enviando o email

mail("$destinatario","$assunto","$msg","from: ".$email.$formato);

//Criando a mensagem de confirma??o de envio de email.

echo "Mensagem enviada com sucesso! Aguarde um retorno. Clique <a href='contato.html'> aqui </a> para retornar.";

?>