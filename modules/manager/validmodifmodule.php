<?php
    include("head_manager.php");
?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
  </header>
  <body>
  <form name='formuval' method=POST action="modif_module.php?idmod=<?php echo $_POST['modid'];  ?>">
<?php
    echo "<input type='hidden' name='mod_name' value='".$_POST['mod_name']."'>";
    echo "<input type='hidden' name='mod_url' value='".$_POST['mod_url']."'>";
    echo "<input type='hidden' name='descr' value='".$_POST['descr']."'>";

  $bool=true;
  $i=0;
  if (!empty($_POST['funcname']))
  {
    foreach($_POST['funcname'] as $tab)
    {
      // We verify that the variables aren't empty
      if (empty($tab)) $bool=false;
      if (empty($_POST['funcurl'][$i]))$bool=false;
      //We build the function's array 
      $funcarray[$i][0]=$tab;
      $funcarray[$i][1]=$_POST['funcurl'][$i];
      //we get the datas to return to the precedente page
echo "<input type='hidden' name='tabname[]' value='".$funcarray[$i][0]."'>";
echo "<input type='hidden' name='taburl[]' value='".$funcarray[$i][1]."'>";
      $i+=1;
    }
  }

  //We verify that the module's name or url doesn't exist again
  $bool3=true;
  $query3="select name,url from module where (name='".$_POST['mod_name']."' or url='".$_POST['mod_url']."') and idmodule<>".$_POST['modid'];
  $result3=pg_query($query3);
  $count3=pg_num_rows($result3);
  if ($count3!=0) $bool3=false; 

  //foreach function in the database, we verify that its name doesn't exist more than 1time in the array
  $bool2=true;
  $query="select funcname from functions where idmodule=".$_POST['modid'];
  $result=pg_query($query);
  $count=pg_num_rows($result);
  for($i=0;$i<$count;$i++)
  {
    $cpt=0;
    $rang=pg_fetch_array($result,$i);
    foreach ($funcarray as $obj)
    {
      if ($obj[0]==$rang['funcname'])
        $cpt+=1;
    }  
    if ($cpt>1)$bool2=false;
  } 
?>
    <table class=big>
    <tr>
      <td class=header align=center>
        <h1>Confirma&ccedil;&atilde;o de modifica&ccedil;&atilde;o do m&oacute;dulo</h1>
      </td>
    </tr>
    <tr>
      <td>
<?php
        if ($bool)
        {
          if ($bool2)
          {
            if ($bool3)
            {
              $mod= new c_module;
              $mod->set_module($_POST['modid'], $_POST['mod_name'],$_POST['mod_url'],$_POST['descr'],$funcarray);
              $mod->update_module();
            
              echo "<tr><td align=center valign=top><font color='#ff0000'><b>O m&oacute;dulo foi modificado com sucesso.</b></font></td></tr>";
              echo "<tr><td align=center valign=top><b>Para alterar as permiss&otilde;es deste m&oacute;dulo, clique </b>";
?>
     <a href="#" onclick="window.open('modif_rights.php?idmod=<?php echo $mod->get_idmodule() ?>','pop1','width=600,height=600');"><b>aqui</b></a>
     </td></tr>
<?php 
              echo "<tr><td align=center><b>Para voltar &agrave; p&aacute;gina principal e atualizar o menu, clique </b><a href='../../index.php'><b>aqui</b></a></td></tr>";
            }
            else
            {
               echo "<tr><td align=center valign=top><font color='#ff0000'><b>O m&oacute;dulo N&Atilde;O foi modificado com sucesso.</b></font></td></tr>";
               echo "<tr><td align=center valign=top><b>O nome ou a url deste m&oacute;dulo est&aacute; sendo utilizado por outro m&oacute;dulo. Escolha outro nome, por favor.</b></td></tr>";
            }
          }
          else 
          {
             echo "<tr><td align=center valign=top><font color='#ff0000'><b>O m&oacute;dulo N&Atilde;O foi modificado com sucesso.</b></font></td></tr>"; 
             echo "<tr><td align=center valign=top><b>Outro m&oacute;dulo est&aacute; usando j&aacute; usando fun&ccvedil;&otilde;es com o mesmo nome de uma ou mais fun&ccedil;&otilde;es inseridas. Escolha outro nome, por favor.</b></td></tr>";
          } 
        }
        else
        {
             echo "<tr><td align=center valign=top><font color='#ff0000'><b>O m&oacute;dulo N&Atilde;O foi modificado com sucesso.</b></font></td></tr>";
             echo "<tr><td align=center valign=top><b>Uma ou mais campos de nome de fun&ccedil;&atilde;o est&aacute; vazio.. Tente novamente.</b></td></tr>";
        }
        if (!($bool && $bool2 && $bool3))
        {
             echo "<tr><td align=center><b>Para voltar para o formul&aacute;rio de modifica&ccedil;&atilde;o <a href='#' onclick='document.forms.formuval.submit();'>clique aqui</a>.</b> </td></tr>";
        }
?>
      </td>
    </tr>
   <tr><td align=center>
          <b>Selecione outro m&oacute;dulo para modific&aacute;-lo :</b>
          <select onchange="document.location.href='modif_module.php?idmod='+this.value;">
            <option value=''>Selecionar um m&oacute;dulo</option>
<?php
             $result7=pg_query("select * from module");
             $count7=pg_num_rows($result7);
             $i=0;
             while($i<$count7)
             {
               $array=pg_fetch_array($result7,$i);
               echo "<option value='".$array['idmodule']."'>".$array['name']."</option>";
               $i+=1;
             }
             pg_free_result($result7);
?>
          </select>
     </td></tr>    
    </table>
  </form>
  </body>
</html>
<?php
   pg_close($idconn);
?>
