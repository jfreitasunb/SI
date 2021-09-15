<?php
function  gera_data_saida($dia,$mes,$ano,$periodo)
  {
// data de entrada no MAT dada por $dia, $mes e $ano.
// $periodo é determinado pelas categorias de $tipo_contrato

$dia_saida=$dia;
$mes_saida=$mes;
$ano_saida=$ano;

if ($periodo=="30 dias") $mes_saida=$mes+1; // visitante com 30 dias
if ($periodo=="35 anos") $ano_saida=$ano+35; // dedicação exclusiva
if ($periodo=="2 anos")  $ano_saida=$ano+2; // aluno mestrado ou prof. substituto
if ($periodo=="4 anos")  $ano_saida=$ano+4; // aluno doutorado
if ($periodo=="5 anos")  $ano_saida=$ano+5; // credenciamento orientacao 
if ($periodo=="06 meses") $mes_saida=$mes+6; // aluno de graduação, estagiario 
if ($periodo=="1 ano") $ano_saida=$ano+1; // aluno de graduação, estagiario 

if (($dia_saida>28) and ($mes_saida==2))
    {
    $dia_saida=$dia_saida-28;
    $mes_saida=$mes_saida+1;
    }

if ($dia_saida>30)
    {
    $dia_saida=$dia_saida-30;
    $mes_saida=$mes_saida+1;
    }

if ($mes_saida>12)
   {
   $ano_saida=$ano_saida+1;
   $mes_saida=$mes_saida-12;
   }

$data_saida=$ano_saida."-".$mes_saida."-".$dia_saida;
return $data_saida;
  }
?>
