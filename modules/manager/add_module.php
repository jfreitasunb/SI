<?php
 include("head_manager.php");
?>
<html>
  <head>
    <script language="javascript">

      var count=1;

      function cache_tout()
      {
        document.getElementById("entete1").style.visibility="hidden";
        document.getElementById("entete2").style.visibility="hidden"; 
<?php
        for($i=1;$i<21;$i++)
          echo "document.getElementById(\"id".$i."\").style.visibility=\"hidden\";";
?>
      }

      function compte(nb)
      {
        count=1;
        if (nb>20)
          nb=20;
        cache_tout();
        for(i=0;i<nb;i++)
          montre();
      }

      function champsok()
      {
        if (document.forms["formu"].mod_name.value.length == 0)
        {
          alert("Le champs correpsondant au nom du module est obligatoire. Veuillez le renseigner, svp.");
          document.forms["formu"].mod_name.focus();
          return false;
        }
        if (document.forms["formu"].mod_url.value.length == 0)
        {
          alert("Le champs correpsondant a l'url du module est obligatoire. Veuillez le renseigner, svp.");
          document.forms["formu"].mod_url.focus();
          return false;
        }
        if (document.forms["formu"].descr.value.length == 0)
        {
          alert("Le champs correpsondant a la description du module est obligatoire. Veuillez le renseigner, svp.");
          document.forms["formu"].mod_name.focus();
          return false;
        }
        return true;
      }

    </script>
    <script src="function_js.js" type="text/javascript">
    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
  </head>
  <body class=test onload="cache_tout();<?php if (isset($_POST['nbadd'])) echo "compte(".$_POST['nbadd'].")";  ?>">
    <table class=big>
    <tr>
      <td class=header align=center>
        <h1>Adi&ccedil;&atilde;o de um m&oacute;dulo</h1>
      </td>
    </tr>
    <form method=POST name=formu action="validaddmodule.php" OnSubmit="return champsok()">
    <tr>
      <td align=center> 
        <br>
        <table class=form>
        <tr>
          <td align=center colspan=2 class=header>Dados do m&oacute;dulo:</td>
        </tr>
        <tr>
          <td class=data>
            Nome do M&oacute;dulo :
          </td>
          <td class=data>
            <input type=text name=mod_name maxlength="60" size=30 value='<?php if (isset($_POST['mod_name']))echo $_POST['mod_name'] ?>'>
          </td>
        </tr>
        <tr>
          <td class=data>
            Diret&oacute;rio que cont&eacute;m o M&oacute;dulo :
          </td>
          <td class=data>
            <input type=text name=mod_url maxlength="60" size=30 value='<?php if (isset($_POST['mod_url']))echo $_POST['mod_url'] ?>'>
          </td>
        </tr>
        <tr>
          <td>
             Descri&ccedil;&atilde;o do m&oacute;dulo :
          </td>
        </tr>
        <tr>
          <td colspan=2>
            <textarea style="font-family: arial;font-size: 11px" name=descr cols=60 rows=5 onBlur="if(this.value.length>=300){alert ('Campo limitado a 300 caracteres.');this.focus();}"><?php if (isset($_POST['descr']))echo $_POST['descr'] ?></textarea>
          </td>
        </tr>

        <tr>
          <td class=data>
            Quantidade de fun&ccedil;&otilde;es:
          </td>
          <td class=data> 
            <select name="nbadd" onchange="compte(this.value)">
<?php
              for ($i=0;$i<21;$i++)
              {
                 echo "<option value=".$i;
                 if (isset($_POST['nbadd']))
                   if ($i==$_POST['nbadd'])
                     echo " selected "; 
                 echo ">".$i."</option>";
              }
?>
            </select>
          </td> 
        </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align=center>
        <br>
        <table class=form> 
        <tr>
          <td align=center colspan=3 class=header>Formul&aacute;rio para as fun&ccedil;&otilde;es:</td>
        </tr>
        <tr>
          <td align=center colspan=3 class=data> 
            <input type="button" value="Suprimir   --" onclick="cache()">
            <input type="button" value="Adicionar ++" onclick="montre()">
          </td>
        </tr>
        <tr> 
          <td colspan=3>
            <hr>
          </td> 
        </tr>
        <tr>
          <td class=data>
            <table>
              <tr id=entete1>
                <td class=data align=center>
                  <b>Nome :</b>
                </td>
                <td class=data align=center>
                  <b>Url :</b>
                </td>
              </tr>
<?php
            for($i=1;$i<21;$i+=2)
            {
?>
              <tr id=id<?php echo $i;?>>
                <td>
                  <input type="text" name="name[]" maxlength="60" <?php if (isset($_POST['tabname'][$i-1])) echo " value='".$_POST['tabname'][$i-1]."'" ?>>
                </td>
                <td>
                  <input type="text" name="url[]" maxlength="60" <?php if (isset($_POST['taburl'][$i-1])) echo " value='".$_POST['taburl'][$i-1]."'" ?>>
                </td>
              </tr>
<?php
            }
?>               
            </table> 
          </td>
          <td class=data>
            &nbsp&nbsp&nbsp&nbsp   
          </td>
          <td class=data>
            <table>
              <tr id=entete2>
                <td class=data align=center>
                  <b>Nome :</b>
                </td>
                <td class=data align=center>
                  <b>Url :</b>
                </td>
              </tr>
<?php
            for($i=2;$i<21;$i+=2)
            {
?>
              <tr id=id<?php echo $i;  ?>>
                <td>
                  <input type="text" name="nameo[]" maxlength="60" <?php if (isset($_POST['tabname'][$i-1])) echo " value='".$_POST['tabname'][$i-1]."'" ?>>
                </td>
                <td>
                  <input type="text" name="urlo[]" maxlength="60"  <?php if (isset($_POST['taburl'][$i-1])) echo " value='".$_POST['taburl'][$i-1]."'" ?>>
                </td>
              </tr>
<?php
            }
?>
            </table>   
          </td>
        </tr>                     
        </table>                  
      </td>
    </tr>
    <tr>
      <td align=center>
        <?php 
           if($_SESSION['permission']==2)
              echo "<input type=submit value='Confirmar'>";
        ?>
      </td>
    </tr>
    </table>
  </form>
  </body>
</html>
<?php
  pg_close($idconn);
?>
