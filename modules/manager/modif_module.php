<?php
  include("head_manager.php");
?>
<html>
  <head>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
    <script type="text/javascript">
    function champsok()
    {
      if (document.forms["formu"].mod_name.value.length == 0)
      {
         alert("Informar o nome do modulo obrigatoriamente.");
         document.forms["formu"].mod_name.focus();
         return false;
      }
      if (document.forms["formu"].mod_url.value.length == 0)
      {
         alert("Informar a url do modulo obrigatoriamente.");
         document.forms["formu"].mod_url.focus();
         return false;
      }
      if (document.forms["formu"].descr.value.length == 0)
      {
         alert("Informar a descricao do modulo obrigatoriamente.");
         document.forms["formu"].mod_name.focus();
         return false;
      }
      return true;
    }

    </script>
  </head> 
  <body>
    <table class=big>
<?php
      if (isset($_GET['idmod']))
      {
         $modul=new c_module();
         $modul->get_module($_GET['idmod']);
         
         if (isset($_GET['glob']))
         {
           $modul->suppr_module ();
?>
           <script type="text/javascript">
             document.location.href="../../index.php";
           </script> 
<?php
         }

         if (isset($_GET['idfunc']))
            $modul->suppr_func($_GET['idfunc']);
?>
    <form name="formu" method=post action="validmodifmodule.php" onsubmit="return champsok()"> 
    <tr>   
      <td colspan=4 class=header align=center>
        <h1>Modifica&ccedil;&atilde;o do m&oacute;dulo "<?php echo $modul->get_name() ?>"</h1>          
      </td>
    </tr>
    <tr>     
      <td align=center>
        <fieldset>
          <legend>&nbsp;Dados sobre o m&oacute;dulo&nbsp;</legend>
          <table class=form align=center>
          <tr>
            <td class=header align=center colspan=2>
              Dados relativos ao m&oacute;dulo :
            </td>
          </tr>
          <tr> 
            <td> 
              Nome du M&oacute;dulo :
            </td>
            <td>
              <input maxlength="60" type=text size=40 <?php if($_SESSION['permission']!=2) echo 'readonly'; ?>  name=mod_name value="<?php if (isset($_POST['mod_name'])) echo $_POST['mod_name']; else echo $modul->get_name(); ?>">
            </td>
          </tr>
          <tr>
            <td>
               Diret&oacute;rio que cont&eacute;m o M&oacute;dulo :
            </td>
            <td>
              <input maxlength="60"  type=text size=40 <?php if($_SESSION['permission']!=2) echo 'readonly'; ?>   name=mod_url value="<?php if (isset($_POST['mod_url'])) echo $_POST['mod_url']; else echo $modul->get_url();?> " >
            </td>
          </tr>
          <tr>
            <td>
               Descri&ccedil;&atilde;o do m&oacute;dulo :
            </td>
          </tr>
          <tr>
            <td colspan=2>
               <textarea onBlur="if(this.value.length>=300){alert ('Este campo &eacute; limitado a 300 caracteres.');this.focus();}" style="font-family: arial;font-size: 11px" name=descr cols=60 rows=5 <?php if($_SESSION['permission']!=2) echo 'readonly'; ?>><?php if (isset($_POST['descr'])) echo $_POST['descr']; else echo $modul->get_descr();?></textarea>
            </td>
          </tr>  
          </table>
          <br> 
          <table class=form align=center>
          <tr>
            <td colspan=3 class=header align=center> 
              Funcionalidades do M&oacute;dulo : 
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
     echo "<tr><td colspan=3>N&atilde;o h&aacute;, por enquanto, fun&ccedil;&otilde;es associadas a este m&oacute;dulo.</td></tr>";
   else
   {
     foreach($modul->get_func() as $array)
     {
        $yan=0; //it was just one variable with the creator's name :-)        
?>
       <tr>
         <td>
           <input type=text size=30 maxlength="60"<?php if($_SESSION['permission']!=2) echo 'readonly'; ?> value='<?php if(isset($_POST['tabname'][$yan])) echo $_POST['tabname'][$yan] ; else echo $array[0]; ?>' name=funcname[]>
         </td>
         <td>
           <input type=text size=40 maxlength="60" <?php if($_SESSION['permission']!=2) echo 'readonly'; ?> value='<?php if(isset($_POST['tabname'][$yan])) echo $_POST['taburl'][$yan] ; else echo $array[1]; ?>' name=funcurl[]>
         </td> 
         <td>
           <a href='modif_module.php?idmod=<?php echo $_GET['idmod']?>&&idfunc=<?php echo $array[0] ?>'>Suprimir</4a>
         </td>
       </tr>
<?php      
       $yan+=1; 
     }
   }   
?>
          </table>
       </fieldset>
      </td>
    </tr>
    <tr>
      <td align=center>
        <?php if ($_SESSION['permission']==2)
           {
?> 
              <input type=submit value='Modificar'>
<?php          }
        ?> 
        <input type=button name='rights' value='Permiss&otilde;es' onclick="window.open('modif_rights.php?idmod=<?php echo $_GET['idmod'] ?>','pop1','width=600,height=600');">
        <input type=button name='New Functions' value='Novas Fun&ccedil;&otilde;es' onclick="window.open('add_functions.php?idmod=<?php echo $_GET['idmod'] ?>','pop1','width=510,height=560');">
<?php       if (($_SESSION['permission']==2)&&($_SESSION['login']=='root'))
         {
?>
           <input type=button name='Suprimir' value='Suprimir' onclick="document.location.href='modif_module.php?idmod=<?php echo $_GET['idmod'] ?>&&glob=1'">
<?php       }
?>
      </td>
    </tr>
    <input type=hidden name=modid value=<?php echo $modul->get_idmodule()  ?>>
    </form>  
<?php    
      }  
      else
      {  
        $query1="select * from module";
        $result1=pg_query($query1)or die(error());
        $count1=pg_numrows($result1);
?>
     <tr> 
        <td align=center class=header colspan=2>
          <h1>Modifica&ccedil;&atilde;o de m&oacute;dulo</h1> 
        </td>
    </tr>
    <tr>
      <td align=center>
        <b>Selecionar o m&oacute;dulo a ser modificado :</b>
      </td>
      <td>
        <select onchange="document.location.href='modif_module.php?idmod='+this.value;">
          <option value=''>Selecionar um m&oacute;dulo</option>  
<?php        
          $i=0;   
          while($i<$count1)
          {
            $array=pg_fetch_array($result1,$i);
            echo "<option value='".$array['idmodule']."'>".$array['name']."</option>";
            $i+=1;
          }
?>
          </select>
      </td>
    </tr>
<?php
      }
?>
    </table>
  </body>
<html>
