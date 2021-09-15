<?php
  include("head_account.php");
?>
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
      <form method="POST" name="formu" action="add_livre.php" onsubmit="return controle_choix()">
      <tr>
        <td class=header align=center>
          <h1>Livros</h1>Cadastro de Dados
        </td>
      </tr>
      <tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Relativo ao Livro :
            </td>
          </tr>
          <tr>
            <td> identificador: </td>
            <td>
              <input type=text name='identificador' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)" >
            </td>
            <td>Titulo:</td>
            <td>
              <input type=text name='titulo' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)" >
            </td>
          </tr>
          <tr>
            <td>Tema:</td>
            <td>
              <input type=text name='tema' maxlength=100>
            </td>
           <td>Autor:</td>
             <td>
               <input type=text name='autor' maxlength=10>
             </td>
          </tr>
          </table>
	   <tr>
        <td align=center>
          <input type=submit value="Enviar">
        </td>
      </tr>
</body>
</html>
<?php
  pg_close($idconn);
?>
