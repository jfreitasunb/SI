<?php
require "cabecalho.html";
?>	

<h1>Servidor Administrativo da Matemática</h1>
<p> Este é o servidor administrativo interno do Departamento de Matemática. 
Para entrar no sistema, faça o <i>login</i> abaixo. </p>


<form action="login_vai.php" method="post">
<br><br>
<table>
	<tr>
            <td width="20%"><p>Login:</p></font></td>
            <td><input name="login" type="text"></td>
        </tr><br>
         <tr>
           <td width="20%"><p>Senha:</p></font></td>
           <td><input name="senha" type="password"></td>
        </tr>
</table><br>
<p><input type="submit" value="Entrar"></p>
</div>
<div id="Menu">
	<a><i>Menu</i> Documentos</a><br>
        <a href="">Gerar</a><br>
        <a href="">Editar</a><br>
        <a href="">Buscar</a><br>
</div>
</body></html>
