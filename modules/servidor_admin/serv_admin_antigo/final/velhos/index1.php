<?php

require "verifica.php";

?>

<html>

<head>

<title>index1</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body {
	scrollbar-face-color: #DEE3E7;
	scrollbar-highlight-color: #FFFFFF;
	scrollbar-shadow-color: #DEE3E7;
	scrollbar-3dlight-color: #D1D7DC;
	scrollbar-arrow-color:  #006699;
	scrollbar-track-color: #EFEFEF;
	scrollbar-darkshadow-color: #98AAB1;
}
</style>

</head>



<body bgcolor="#FFFFFF" text="#000000" leftmargin="2" topmargin="0">

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <td width="15%" height="43">
      <div align="center"><img src="figuras/logo_car.gif" width="80" height="80"></div>
    </td>
    <td colspan="3" valign="middle" height="20">
      <div align="center"><font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#990000"><strong><font color="#014D74">Bem
              vindo ao Servidor Administrativo
              </font></strong></font></div>
    </td>
  </tr>
</table>
<div align="justify"> <font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#990000"><b>
  <center>
  </center>
</b></font></div>
<br>
<font face="Verdana, Arial, Helvetica, sans-serif" size="2">Escolha as altera&ccedil;&otilde;es 
a serem feitas de acordo com o <em>menu</em> ao lado.</font><br>
<div align="center"><?php
if ($msg != "")
	echo "<p align='center'><font face='Verdana, Arial, Helvetica, sans-serif' size='1'>$msg</font></p>";
?>	

</div>
</body>

</html>

