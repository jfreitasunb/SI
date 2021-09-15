<?php
// chama a classe 'class.ezpdf.php' necessária para se gerar o documento
include "GeraPDF/class.ezpdf.php";

// instancia um novo documento com o nome de pdf
$pdf = new Cezpdf();

// seta a fonte que será usada para apresentar os dados
//essas fontes são aquelas dentro do diretório GeraPDF/fonts
$pdf->selectFont('GeraPDF/fonts/Helvetica.afm');

// chama o método ezText e passa o texto que deverá ser apresentado no documento
//o numero após o texto se refere ao tamanho da fonte
$pdf->ezText('Futuro Servidor Administrativo do Mat',50);

// gera o PDF
$pdf->ezStream();
?>
