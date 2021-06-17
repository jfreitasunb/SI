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
      <form method="POST" name="formu" action="add_user2.php" onsubmit="return controle_choix()">
      <tr>
        <td class=header align=center>
          <h1>Controle de Equipamento</h1>Informa&ccedil;&otilde;es sobre os equipamentos
        </td>
      </tr>
      <tr>
        <td align=center>
          <table class=form>
          <tr>
            <td colspan=4 class=header align=center>
              Descri&ccedil;&atilde;o da Inclus&atilde;o :
            </td>
          </tr>
          <tr>
            <td> Codigo : </td>
            <td>
              <input type=text name='codigo' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)" >
            </td>
            <td> Nome :</td>
            <td>
              <input type=text name='nome' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)" >
            </td>
          </tr>
          <tr>
            <td>Descri&ccedil;&atilde; :</td>
            <td colspan=3>
              <input type=text name='endereco' maxlength=100>
            </td>
          </tr>
          <tr>
             <td>Patrimonio :</td>
             <td>
               <input type=text name='preco' maxlength=10 onkeypress="return verif_touche(event);" >
             </td>
             <td>Quantidade :</td>
             <td>
               <input type=text name='quantidade' maxlength=20 onblur="this.value= prem_lettre_majuscule(this.value)">
             </td>
          </tr>
          <tr><td colspan=4><hr></td></tr>
          <tr>
            <td>Categoria :</td>
            <td>
              <input type=text name='categoria' maxlength=15 onkeypress="return verif_touche(event);">
            </td>
            </tr>
          </table>
        </td>
      </tr>
       <tr>
        <td align=center>
          <input type=submit>
        </td>
      </tr>
      </form>
      </table>
  </body>
</html>
