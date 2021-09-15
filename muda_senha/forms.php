<?php

/* Funções para facilitar a inserção de campos padronizados */
$masterconf="./conf/";
include("$masterconf"."html.php");

// insere campo text com  
// <qualquernome>, <nome do campo><valor> <tamanho>, <maximotam> <obrigatório>
// <se vai abrir uma linha na tabela> <se vai fechar a linha> <javascript>

function formtext($label, $nome, $valor, $size, $max, $obr, $abretab, $fechatab, $javascript) {
	global	$cortabela, $corfontetabelaast, $corfontetabela;
	
	if($abretab) { 	
	$resultado="<tr>"; };
	$resultado.="<td bgcolor=\"$cortabela\">";
	if($obr){
	$resultado.="<font color=\"$corfontetabelaast\">*</font>"; };
	$resultado.="<font color=\"$corfontetabela\">$label</font>";
	$resultado.="</td>";
	$resultado.="<td bgcolor=\"$cortabela\">";
	$resultado.="&nbsp;&nbsp;<input type=\"text\" name=\"$nome\" size=\"$size\" maxlength=\"$max\" value=\"$valor\" $javascript >&nbsp;&nbsp;&nbsp;&nbsp;";
	$resultado.="</td>";
	if($fechatab){
	$resultado.="</tr>"; }; 
echo $resultado;
};


// Função Passwd
//  <qualquernome>, <nome do campo>, <valor>  <tamanho>, <maximotam> <obrigatório>
// <se vai abrir uma linha na tabela>, <se vai fechar a linha><javascript>

function formpassword($label, $nome, $valor, $size, $max, $obr, $abretab, $fechatab, $javascript) {
        global  $cortabela, $corfontetabelaast, $corfontetabela;

        if($abretab) {
        $resultado="<tr>"; };
        $resultado.="<td bgcolor=\"$cortabela\">";
        if($obr){
        $resultado.="<font color=\"$corfontetabelaast\">*</font>"; };
        $resultado.="<font color=\"$corfontetabela\">$label</font>";
	$resultado.="</td>";
	$resultado.="<td bgcolor=\"$cortabela\">";
        $resultado.="&nbsp;&nbsp;<input type=\"password\" name=\"$nome\" size=\"$size\" maxlength=\"$max\" value=\"$valor\"  $javascript >&nbsp;&nbsp;&nbsp;&nbsp;";
        $resultado.="</td>";
        if($fechatab){
        $resultado.="</tr>"; };
echo $resultado;
};

// Função SELECT
// <qualquernome><nome><arrayvalores><labels><default01><obr>
// <seabre> <sefecha> <javascript>
//



function formselect($label, $nome, $valores, $labels, $default, $obr, $abretab, $fechatab, $javascript) { 

	global  $cortabela, $corfontetabelaast, $corfontetabela;

        if($abretab) {
        $resultado="<tr>"; };
        $resultado.="<td bgcolor=\"$cortabela\">";
        if($obr){
        $resultado.="<font color=\"$corfontetabelaast\">*</font>"; };
        $resultado.="<font color=\"$corfontetabela\">$label</font>";
	$resultado.="</td>";
	$resultado.="<td bgcolor=\"$cortabela\">";

        $resultado.="&nbsp;&nbsp;<select name=\"$nome\" size=\"1\" $javascript>";
	for($i=0;$i<sizeof($valores);$i++){
	$resultado.="<option value\"$valores[$i]\" $default[$i]>$labels[$i]</option>";
					};
	$resultado.="</select>";
	$resultado.="&nbsp;&nbsp;&nbsp;&nbsp;";
        $resultado.="</td>";
        if($fechatab){
        $resultado.="</tr>"; };
echo $resultado;

};

// Função RADIO
// <qualquernome><nome><arrayvalores><labels><default01><obr? >
// <seabre> <sefecha> <javascript>
//

function formradio($label, $nome, $valores, $labels, $default, $obr, $abretab, $fechatab, $javascript) {
	global  $cortabela, $corfontetabelaast, $corfontetabela;

        if($abretab) {
        $resultado="<tr>"; };
        $resultado.="<td bgcolor=\"$cortabela\">";
        if($obr){
        $resultado.="<font color=\"$corfontetabelaast\">*</font>"; };
        $resultado.="<font color=\"$corfontetabela\">$label</font>";
        $resultado.="</td>";
        $resultado.="<td bgcolor=\"$cortabela\">";
	for($i=0;$i<sizeof($labels);$i++){
	if($default[$i]){ $check="CHECKED"; }else { $check="";};
        $resultado.="&nbsp;&nbsp;$labels[$i]<input type=\"radio\" name=\"$nome\" value=\"$valores[$i]\"  $javascript $check>&nbsp;&nbsp;&nbsp;&nbsp;";
				  	  };
        $resultado.="</td>";
        if($fechatab){
        $resultado.="</tr>"; };
echo $resultado;

}; 

// Função CHECKBOX
// <qualquernome><nome><valor><default01><obr? >
// <seabre> <sefecha> <javascript>
//

function formcheckbox($label, $nome, $valor, $checked, $obr, $abretab, $fechatab, $javascript) {
        global  $cortabela, $corfontetabelaast, $corfontetabela;

        if($abretab) {
        $resultado="<tr>"; };
        $resultado.="<td bgcolor=\"$cortabela\">";
        if($obr){
        $resultado.="<font color=\"$corfontetabelaast\">*</font>"; };
        $resultado.="<font color=\"$corfontetabela\">$label</font>";
        $resultado.="</td>";
        $resultado.="<td bgcolor=\"$cortabela\">";
        if($checked){ $check="CHECKED"; }else { $check="";};
        $resultado.="&nbsp;&nbsp;<input type=\"checkbox\" name=\"$nome\" value=\"$valor\"  $javascript $check>&nbsp;&nbsp;&nbsp;&nbsp;";
        $resultado.="</td>";
        if($fechatab){
        $resultado.="</tr>"; };
echo $resultado;

};

// Função TEXTAREA
// <qualquernome><nome><valor><default01><obr? >
// <seabre> <sefecha> <javascript>
//


function formtextarea($label, $nome, $default, $cols, $rows, $obr, $abretab, $fechatab, $javascript)
{

        global  $cortabela, $corfontetabelaast, $corfontetabela;
	
	if($tdcols){ $tdc="cols=$tdcols"; };
	if($tdrows){ $tdr="rows=$tdrows"; };
	// For feature
	$tdr=$tdc="";
        if($abretab) {
        $resultado="<tr>"; };
        $resultado.="<td bgcolor=\"$cortabela\" $tdr valign=\"top\">";
        if($obr){
        $resultado.="<font color=\"$corfontetabelaast\">*</font>"; };
        $resultado.="<font color=\"$corfontetabela\">$label</font>";
        $resultado.="</td>";
        $resultado.="<td bgcolor=\"$cortabela\" $tdc $tdr>";
        $resultado.="&nbsp;&nbsp;<textarea name=\"$nome\" cols=\"$cols\" rows=\"$rows\" $javascript>$default</textarea>&nbsp;&nbsp;&nbsp;&nbsp;";
        $resultado.="</td>";
        if($fechatab){
        $resultado.="</tr>"; };
echo $resultado;
};

// Função SUBMIT
// <nome><valor><valor> <seabre> <sefecha> <alinhamento> <javascript>
//


function formsubmit($name, $value, $abretab, $fechatab, $align, $javascript)
{
        global  $cortabela, $corfontetabelaast, $corfontetabela;

        if($abretab) {
        $resultado="<tr>"; };
        $resultado.="<td bgcolor=\"$cortabela\" align=\"$align\">";
        $resultado.="<input type=\"submit\" name=\"$name\" value=\"$value\" $javascript>";
        $resultado.="</td>";
        if($fechatab){
        $resultado.="</tr>"; };
echo $resultado;
};

function formbutton($name, $value, $abretab, $fechatab, $align, $javascript)
{
        global  $cortabela, $corfontetabelaast, $corfontetabela;

        if($abretab) {
        $resultado="<tr>"; };
        $resultado.="<td bgcolor=\"$cortabela\" align=\"$align\">";
        $resultado.="<input type=\"button\" name=\"$name\" value=\"$value\" $javascript>";
        $resultado.="</td>";
        if($fechatab){
        $resultado.="</tr>"; };
echo $resultado;
};

// Função RESET
// <nome><valor><valor> <seabre> <sefecha> <alinhamento> <javascript>
//


function formreset($name, $value, $abretab, $fechatab, $align, $javascript)
{
        global  $cortabela, $corfontetabelaast, $corfontetabela;

        if($abretab) {
        $resultado="<tr>"; };
        $resultado.="<td bgcolor=\"$cortabela\" align=\"$align\">";
        $resultado.="<input type=\"reset\" name=\"$name\" value=\"$value\" $javascript>";
        $resultado.="</td>";
        if($fechatab){
        $resultado.="</tr>"; };
echo $resultado;
}

// Funcao HIDDEN
//

function formhidden($nome, $valor)
{
	$resultado="<input type=\"hidden\" name=\"$nome\" value=\"$valor\">";
	echo $resultado;
}				


?>	
