<?php
error_reporting(E_ALL ^E_WARNING ^E_NOTICE);
// no operação2.php e no ati.php: substituir "$arquivo=" por $arquivo=escolhe_arquivo($data,$tipo,$com_copia); 

function escolhe_arquivo($data,$tipo,$com_copia) 
{
/*
Tipos:

1=memorando
2= circular
3,6=oficio interno ou externo                
4=ato
5=ata

arqwuivos do tipo ***_novo.tex são montados com o artigo.cls em que os dados telefonicos do MAT foram atualizados em xx/xx/2010

*/

$data_0=explode('/',$data);

//$data_dia=str_split($data_0[0]);
//$data_mes=str_split($data_0[1]);

$dia_muda=5;
$mes_muda=11;
$ano_muda=2010;
$dias=array("06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");

//if (( in_array($data_0[0],$dias) and $data_0[1]=="11" and $data_0[3]==$ano_muda) or ($data_0[1]=="12" and $data_0[3]==$ano_muda) or ($data_0[3]>$ano_muda)) 
if (( in_array($data_0[0],$dias) and $data_0[1]=="11" and $data_0[2]=="2010") or ($data_0[1]=="12" and $data_0[2]=="2010") or ($data_0[2]>$ano_muda)) 
	{//escolhe documentos com novos telefones:
	if (($tipo=="1") and ($com_copia=="")) $arquivo="modelo_memorando_novo.tex"; else $arquivo="modelo_memorandocc_novo.tex";
        if ((($tipo=="3") or ($tipo=="6")) and ($com_copia=="")) $arquivo="modelo_oficio_novo.tex";else $arquivo="modelo_oficiocc_novo.tex";
        if ($tipo=="2") $arquivo="modelo_circular_novo.tex";
        if ($tipo=="4") $arquivo="modelo_ato_novo.tex";
        if ($tipo=="5") $arquivo="modelo_ata_novo.tex";
	}
else 
	{//usa os documentos antigos
	if (($tipo=="1") and ($com_copia=="")) $arquivo="modelo_memorando.tex"; else $arquivo="modelo_memorandocc.tex";
        if ((($tipo=="3") or ($tipo=="6")) and ($com_copia=="")) $arquivo="modelo_oficio.tex";else $arquivo="modelo_oficiocc.tex";
        if ($tipo=="2") $arquivo="modelo_circular.tex";
        if ($tipo=="4") $arquivo="modelo_ato.tex";
        if ($tipo=="5") $arquivo="modelo_ata.tex";
	}
//print $arquivo;
return $arquivo;
}



?>
