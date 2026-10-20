<?php
 require("head_user.php"); 
?>
<?php
			$convidado=$_POST['name01'];
			$dia1=$_POST['dia1'];$mes1=$_POST['mes1'];$ano1=$_POST['ano1'];
			$date1=$ano1."-".$mes1."-".$dia1;
			$dia2=$_POST['dia2'];$mes2=$_POST['mes2'];$ano2=$_POST['ano2'];
			$date2=$ano2."-".$mes2."-".$dia2; 
print $convidado.",   ".$date1.",   ".$date2 ."\n"; 



//include("convidado.php");
echo '<pre>';
var_dump( "insert into visitor values ('$coduser','$date1','$date2','$convidado')" );
$res = db_query("insert into visitor values (?,?,?,?)", array($coduser, $date1, $date2, $convidado));

?>
