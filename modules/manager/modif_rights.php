<?php
  include("head_manager.php");
  if (isset($_GET['idmod']))
  {
    if (isset($_GET['login']))
    {
      $query="update permission set permission=".$_POST['permission']." where login='".$_GET['login']."' and idmodule=".$_GET['idmod'];
      $result=pg_query($query);
      pg_free_result($result);
    }
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
        <h1>Permiss&otilde;es para o m&oacute;dulo :<br>"<?php echo $tab['name'];  ?>"</h1>
      </td>
    </tr>
    <tr>
      <td>
        <table align=center>
        <tr>
          <td class=header align=center rowspan=2 valign=middle>
            Login usu&aacute;rio :
          </td>
          <td class=header align=center rowspan=2 valign=middle>
            Nome :
          </td>
          <td class=header align=center rowspan=2 valign=middle>
            Sobrenome :
          </td>
          <td colspan=3 class=header align=center>
            Permiss&otilde;es
          </td>
        </tr>
        <tr>
          <td class=header>nenhuma</td>
          <td class=header>leitura</td>
          <td class=header>leitura/escritura</td>
        </tr>
<?php
    pg_free_result($result);
    $query="select p.login, u.name, u.firstname,p.permission from permission p, users u, admin a  where idmodule=".$_GET['idmod']." and u.coduser=a.coduser and a.login=p.login order by p.login";
    $result=pg_query($query);
    $count=pg_numrows($result);
    for($i=0;$i<$count;$i++)
    {
      $tab=pg_fetch_array($result, $i);
?>
        <form method=POST name='form<?php echo $i;  ?>' action="modif_rights.php?login=<?php echo $tab['login']; ?>&idmod=<?php echo $_GET['idmod'] ?>">
        <input type=hidden name=test value=1>
        <tr>
          <td class=data align=center>
            <b><?php echo $tab['login'];?></b>
          </td>
          <td class=data align=center>
            <?php echo $tab['firstname'];?>
          </td>
          <td class=data align=center>
            <?php echo $tab['name'];?>
          </td>
          <td class=data align=center>
            <input type=radio <?php if(($_SESSION['permission']!=2)||($tab['login']=='root')) echo 'disabled'; ?>  name=permission value=0 <?php if ($tab['permission']==0)echo "checked";  ?>  >
          </td>
          <td class=data align=center>
            <input type=radio <?php if(($_SESSION['permission']!=2)||($tab['login']=='root')) echo 'disabled'; ?>  name=permission value=1 <?php if ($tab['permission']==1)echo "checked";  ?>  >
	  </td>
          <td class=data align=center>
            <input type=radio <?php if(($_SESSION['permission']!=2)||($tab['login']=='root')) echo 'disabled'; ?>  name=permission value=2 <?php if ($tab['permission']==2)echo "checked";  ?>  >
          </td>
          <td class=header>
<?php
          if(($_SESSION['permission']==2)&&($tab['login']!='root'))
          {
?>
            <a href='#' class=menu onclick="document.forms.form<?php echo $i; ?>.submit();">Atribuir</a>
<?php
          }
?>
          </td>
        </tr>
        </form>
<?php
    }
    pg_free_result($result);
?>
        </table>
      </td>
    </tr>
    <tr> 
      <td align=center>
        <input type=button value="Fechar Janela" onclick="window.close();">
      </td>
    </tr>
    </table>
  </body>
</html>
<?php
  pg_close($idconn);
  }
?>
