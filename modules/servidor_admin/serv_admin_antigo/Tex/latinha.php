<?php
//exec('/bin/rm -f /tmp/MEM*');
//exec('/usr/local/bin/latex --interaction batchmode  '.$tmpfname.'.tex ; dvips '.$tmpfname.'.dvi ; ps2pdf '.$tmpfname.'.ps ');
//exec('/bin/rm -f /tmp/MEM*');
//exec('/bin/rm -f '.$tmpfname.'*');

$resultado2=pg_query("SELECT nome,cargo FROM assinaturas WHERE id_assinaturas = '$dado[7]'") or die("Não foi possível executar 
                     a operação. Contacte a Coordenação de Informática.");
$row2= pg_fetch_row($resultado2,$i);


switch($id_tipo){

	case 1 || 3: //memorando ou oficio
	{
	$seds[LATEXNUMERO]="XX";
	$seds[LATEXDESTINO]=$dado[1];
	$seds[LATEXASSUNTO]=$dado[2];
	$seds[LATEXANEXO]=$dado[3];
	$seds[LATEXVOCATIVO]=$dado[4];
	$seds[LATEXMENSAGEM]=$dado[5];
	$seds[LATEXDESFECHO]=$dado[6];
	$seds[LATEXNASSINATURA]=$row2[0];
	$seds[LATEXCASSINATURA]=$row2[1];
	$arquivo="modelo_memorando.tex";
	}
	break;

	case 2: //circular
	{
	$seds[LATEXNUMERO]="XX";
        $seds[LATEXASSUNTO]=$dado[2]; 
        $seds[LATEXVOCATIVO]=$dado[3]; 
        $seds[LATEXMENSAGEM]=$dado[4]; 
        $seds[LATEXDESFECHO]=$dado[5]; 
        $seds[LATEXNASSINATURA]=$row2[0];
	$arquivo="modelo_circular.tex"; 
	}

	case 4: //ato
	{
	$seds[LATEXNUMERO]="XX";
        $seds[LATEXMENSAGEM]=$dado[1]; 
        $seds[LATEXNASSINATURA]=$row2[0];
	$arquivo="modelo_ato.tex";
	}

	case 5: //ata
	{
	$seds[LATEXNUMERO]="XX";
        $seds[LATEXMENSAGEM]=$dado[1];
	$arquivo="modelo_ata.tex"; 
	}

}
	
	

$template="/home/sarah/public_html/teste/$arquivo";
//$seds[LATEXNUMERODOCUMENTO]="ASDASDASDASD";

$tmpfname = tempnam("/tmp", "ABAB");
Header("Content-type: application/pdf");

exec('cat '.$template.' > '.$tmpfname.'.tex');

foreach($seds as $key => $val ) 
{ 
        exec('sed s/'.$key.'/'.$val.'/ '.$tmpfname.'.tex > '.$tmpfname.'.tex.tmp ; mv -f '.$tmpfname.'.tex.tmp '.$tmpfname.'.tex');
} 

exec('cd /tmp/; /usr/local/bin/pdflatex '.$tmpfname.'.tex');
//echo $errou;

$fp=fopen("".$tmpfname.".pdf","r"); 
 
 while (!feof($fp)) { 
   $buffer = fgets($fp, 4096); 
 echo $buffer; 
 } 

fclose($fp);

?>
