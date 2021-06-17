<?php
  include("head_manager.php");

  //We test if the module doesn't exist in the database.
  $query="select * from module where name='".$_POST['mod_name']."' or url='".$_POST['mod_url']."'";
  $result=pg_query($query)or die(error());
  $count=pg_num_rows($result);
  pg_free_result($result);
?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
  </header> 
  <body>

  <form method=POST action="add_module.php" name='formuval'>

    <table class=big>
    <tr>
      <td align=center class=header>   
        <h1>Confirma&ccedil;&atilde;o de adi&ccedil;&atilde;o de um m&oacute;dulo</h1>
      </td>
    </tr>   
    <tr>
      <td align=center>
        <br>  
        <table class=form>
        <tr>
          <td colspan=4 class=header align=center>
            <h2>Dados informados :</h2>
          </td>
        </tr>
        <tr>
          <td><b>M&oacute;dulo :</b></td>           
          <td colspan=3><?php echo stripslashes($_POST['mod_name']) ?></td>
        </tr>
        <tr>
          <td><b>Url :</b></td>
          <td colspan=3><?php echo stripslashes($_POST['mod_url']) ?></td> 
        </tr>
        <tr>
          <td>
            <b> Descri&ccedil;&atilde;o do m&oacute;dulo :</b>
          </td>
        </tr>
        <tr>
          <td colspan=4>
            <?php echo stripslashes($_POST['descr']) ?> 
          </td>
        </tr>
<?php
  //We build the function's array.
  $pair=0;
  $impair=0;
  $bool=true; 
  for ($i=1;$i<=$_POST['nbadd'];$i++)
  {
?>
        <tr>
          <td>
            <b>Nome da fun&ccedil;&atilde;o <?php echo $i; ?> :</b>
          </td>
<?php
    if ($i % 2==0) 
    {
      echo "<td> ".stripslashes($_POST['nameo'][$impair])."</td>";
      echo "<td> ---> </td><td>".stripslashes($_POST['urlo'][$impair]).'</td></tr>';
      $array[$i-1][0]=stripslashes($_POST['nameo'][$impair]);
      $array[$i-1][1]=stripslashes($_POST['urlo'][$impair]);
      $impair++;
      //We verifie that each function is unique and doesn't exist in the database.
      for ($j=0;$j<$i-1;$j++)
      {
        if ($array[$i-1][0]==$array[$j][0]) 
          $bool=false;
      }
    }
    else
    {
     echo "<td>".stripslashes($_POST['name'][$pair])."</td>";
     echo "<td>  ---> </td><td> ".stripslashes($_POST['url'][$pair]).'</td></tr>';
     $array[$i-1][0]=stripslashes($_POST['name'][$pair]);
     $array[$i-1][1]=stripslashes($_POST['url'][$pair]); 
     $pair++;
     //We verifie that each function is unique and doesn't exist in the database.
      for ($j=0;$j<$i-1;$j++)
      {
        if ($array[$i-1][0]==$array[$j][0])
          $bool=false;
      }
    }
    //We verifie that there are no empty name and no empty url
    if (empty($array[$i-1][0])) $bool=false;
    if (empty($array[$i-1][1])) $bool=false;
//we get the datas to return to the precedente page
echo "<input type='hidden' name='tabname[]' value='".$array[$i-1][0]."'>";
echo "<input type='hidden' name='taburl[]' value='".$array[$i-1][1]."'>"; 
  }
?>
        </table>
      </td>
    </tr> 
    <tr>
      <td>
        <br> 
      </td> 
    </tr>
<?php
  if ($bool && $count==0)
  {
     $add= new c_module;
     $add->set_module('',$_POST['mod_name'],$_POST['mod_url'],$_POST['descr'] ,$array);
     $add->create_module();
     echo "<tr><td align=center valign=top><font color='#ff0000'><b>O m&oacute;dulo foi corretamente inserido no sistema.</b></font></td></tr>"; 
     echo "<tr><td align=center valign=top>Por enquanto, o usu&aacute;rio root &eacute; o &uacute;nico a ter acesso a este m&oacute;dulo.<br>";
     echo "Para alterar as permiss&otilde;es de acesso a este m&oacute;dulo, clique  ";
?>
     <a href="#" onclick="window.open('modif_rights.php?idmod=<?php echo $add->get_idmodule() ?>','pop1','width=600,height=600');">aqui</a>
     </td></tr>
<?php
     echo "<tr><td align=center>O arquivo header foi criado e incluido no diretório xxxxx com sucesso. Este arquivo permite o gerenciamento da segurança e da conexão com o banco de dados. A fim de integrtar o módulo ao sistema, este arquivo deve ser incluido em cada página visível no site do sistema (através do comando-php include()), com excessão das bibliotecas de funções e de classes. </td></tr>";
     echo "<tr><td align=center>Para adicionar outro m&oacute;dulo, clique <a href='add_module.php'>aqui</a></td></tr>";
     echo "<tr><td align=center>Para modificar este m&oacute;dulo clique <a href='modif_module.php?idmod=".$add->get_idmodule()."'>aqui</a></td></tr>";
     echo "<tr><td align=center>Para voltar &agrave; P&aacute;gina principal e atualizar o menu, clique <a href='../../index.php'>aqui</a></td></tr>";
  }
  else
  {

    //we get the datas to return to the precedente page
    echo "<input type='hidden' name='mod_name' value='".$_POST['mod_name']."'>";
    echo "<input type='hidden' name='mod_url' value='".$_POST['mod_url']."'>";
    echo "<input type='hidden' name='descr' value='".$_POST['descr']."'>";
    echo "<input type='hidden' name='nbadd' value='".$_POST['nbadd']."'>";
    echo "<tr><td align=center valign=top><font color='#ff0000'><b>Error : A insers&atilde;o do m&oacute;dulo foi efetuada.</b></font></td></tr>";
    if($count!=0)  
      echo "<tr><td align=center valign=top>Este m&oacute;dulo n&atilde;o pode ser inserido porque seu nome ou sua url j&aacute; existe.</td></tr>";
    if(!$bool)
      echo "<tr><td align=center valign=top>Este m&oacute;dulo n&atilde;o pode ser inserido porque duas de suas fun&ccedil;&otilde;es t&ecirc;m o mesmo nome ou s&atilde;o nulas.</td></tr>";
    echo "<tr><td align=center valign=top><b><a href='#' onclick='document.forms.formuval.submit();'>Tente novamente, por favor.</a></b></td></tr>";
  }
  pg_close();
?>
     </table>
  </form>
  </body>
</html>
