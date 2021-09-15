<?php
  include("head_manager.php");

  if (isset($_GET['idmod']))
  {
     //$modul=new c_module();
     //$modul->get_module($_GET['idmod']);
     $query="select name from module where idmodule=".$_GET['idmod'];
     $result=pg_query($query);
     $tab=pg_fetch_array($result,0);
    
?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">    
  </header>
  <body>
    <table class=big>
    <tr>
      <td class=header align=center>
        <h1>Adi&ccedil;&atilde;o das funcionalidades</h1>
        para o m&oacute;dulo : <?php echo $tab[0]  ?> 
      </td>
    </tr>
    <tr>
      <td align=center>
      <font color=red style=bolder> 
<?php
         if($_POST['prec']==51)
         {
              if (empty($_POST['name'])||empty($_POST['url']))
                echo "INSER&Ccedil;&Atilde;O ANULADA : Informe todos os campos por favor.";
              else
              {
                $query="select * from functions where idmodule=".$_GET['idmod']." and funcname='".$_POST['name']."'";
                $result=pg_query($query);
                $count=pg_num_rows($result);  
                if ($count!=0)
                  echo "INSER&Ccedil;&Atilde;O ANULADA : j&aacute; existe uma fun&ccedil;&atilde;o com este nome. Escolha um outro nome, ou utilize a interface de modifica&ccedil;&atilde;o.";
                else
                {
                  $query2="insert into functions values ('".$_GET['idmod']."', '".$_POST['name']."', '".$_POST['url']."')";
                  $result2=pg_query($query2);
                  if ($_POST['add']=="adicionar")
                    echo "Inser&ccedil;&atilde,o da funcionalidade efetuada com sucesso.";
                  if ($_POST['add']=="adicionar/sair")
                  {
?>
                     <script language=javascript>
                       opener.location.reload();
                       window.close();
                     </script>
<?php
         } } }    }
         else 
           echo "&nbsp";

        $modul=new c_module();
        $modul->get_module($_GET['idmod']);

?>
      </font>
      </td>
    </tr>
    <tr>
      <td>
        <table class=form align=center>
          <tr>
            <td colspan=2 class=header align=center>
              Funcionalidades existentes :
            </td>
          </tr>
          <tr>
            <td align=center>
              <b>Nome da fun&ccedil;&atilde;o :</b>
            </td>
            <td align=center>
              <b>Url desta fun&ccedil;&atilde;o :</b>
            </td>
          </tr>
<?php
   if (empty($modul->funcarray))
     echo "<tr><td colspan=2>N&atilde;o h&aacute; fun&ccedil;&otilde;es existentes neste m&oacute;dulo.</td></tr>";
   else
   {
     foreach($modul->get_func() as $array)
     {
?>
       <tr>
         <td>
           <input type=text size=30 maxlength="60" readonly value='<?php echo $array[0]; ?>' name=funcname[]>
         </td>
         <td>
           <input type=text size=40 maxlength="60" readonly value='<?php echo $array[1]; ?>' name=funcurl[]>
         </td>
       </tr>
<?php
     }
   }
?>
          </table>
      </td>
    </tr> 
    <tr> 
      <td>
        <form method=POST action="add_functions.php?idmod=<?php echo $_GET['idmod']  ?>">
          <input type=hidden name=prec value=51>
          <table class=form align=center>
          <tr>
            <td class=header align=center colspan=2>
               Formul&aacute;rio de adi&ccedil;&atilde;o :
            </td>
          </tr>
          <tr>
            <td>
              Nome da funcionalidade : 
            </td>
            <td>
              <input type=text size=50 maxlength=60 name=name> 
            </td>
          </tr>
          <tr>
            <td>
              Url da p&aacute;gina : 
            </td>
            <td>
              <input type=text size=50 maxlength=60 name=url>
            </td>
          </tr>
<?php
          if ($_SESSION['permission']==2)
          {
?>
          <tr>
            <td colspan=2 align=center>
              <input type=submit value=adicionar name=add>
              <input type=submit value='adicionar/sair' name=add> 
            </td> 
          </tr>
<?php
          }
?>
          </table>
        </form>
      </td> 
    </tr>
    <tr>
      <td align=center>
        <input type=button value=sair onclick="opener.location.reload();window.close();">
      </td>
    </tr>
    <table>
  </body>
</html>
<?php
  }
  else
  { 
    error ("Vous n'avez pas acceder a cette page de maniere conventionnelle.<br>Assurez vous de bien posseder les droits pour cette fonction, et servez vous de línteerface pour y acceder.");
  } 
  pg_close($idconn);
?>
