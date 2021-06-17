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
<form name="utilisateur"> 
      <tr>
        <td class=header align=center>
          <h1>Emprestimo de Livros</h1>Informa&ccedil;&otilde;es sobre o livro
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>livros</title>

	<table class=form>
        <tr>
          <td colspan=4 class=header align=center>
            Dados do Livro :
          </td>
        </tr>
        <tr>
          <td> Identificador do Livro : </td>
          <td>
            <input type=text name='id_livro' maxlength=60>
          </td>
          <td>Título :</td>
          <td>
            <input type=text name='titulo' maxlength=60 >
          </td>
        </tr>
        <tr>
          <td> Autor : </td>
          <td>
            <input type=text name='autor' maxlength=60 >
          </td>
          <td>Tema :</td>
          <td>
            <input type=text name='tema' maxlength=60 >
          </td>
        </tr>
         </table>
<tr>
      <td colspan=2 align=center>
        <table class=form>
        <tr>
          <td colspan=4 class=header align=center>
            Emprestimo :
          </td>
        </tr>
        <tr>
          <td> Identificador do Usuario : </td>
          <td>
            <input type=text name='cod_user' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)">
          </td>
          <td>Data de Emprestimo :</td>
          <td>
            <input type=text name='data_emprestimo' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)" >
          </td>
        </tr>
        <tr>
          <td> Reserva : </td>
          <td>
            <input type=text name='reserva' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)">
          </td>
          <td>Data de Devolucao :</td>
          <td>
            <input type=text name='data_devolucao' maxlength=60 onblur="this.value= prem_lettre_majuscule(this.value)" >
          </td>
        </tr>

         </table>
 <td align=center>

     <tr>
       <td align=center>
         <input type=button name='rights' value='Cadastrar Livro' onclick="window.open('cada_livr.php?idmod=<?php echo $_GET['idmod'] ?>','pop1','width=600,height=600');">
	 <input type=submit value=Enviar>
         <input type=button value=Modificar>
         <input type=button value=Fechar>
	 </td>
     </tr>
  </form>
  <table>
    </body>
</html>
