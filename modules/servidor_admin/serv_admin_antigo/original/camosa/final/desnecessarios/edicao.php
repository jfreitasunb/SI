<?php

require('../fpdf/fpdf.php');

class PDF extends FPDF
{
//Page header
function Header()
{
$this->SetXY(23,28);
$this->SetFont('Times', 'B', 14);
$this->Cell(65, 0, 'Fundação Universidade de Brasília');
$this->Ln(4);
$this->SetX(23);
$this->SetFont('Times', 'B', 8);
$this->Cell(65, 0, 'Departamento de Matemática - IE');
$this->Ln(4);
$this->SetX(23);
$this->SetLineWidth(0.5);
$this->Line($this->GetX()+1, $this->GetY()-1, $this->GetX()+168, $this->GetY()-1);
$this->Ln(2);
$this->SetX(23);
$this->SetFont('Times', '', 8);
$this->Write(0,'Campus Universitário, 70910-900 - Brasília - DF');
$tam=$this->GetStringWidth('Fone: (061) 273-3356 - FAX: (061) 274-3910');
$this->SetX(168- $tam);

$this->Write(0,'Fone: (061) 273-3356 - FAX: (061) 274-3910');
$this->Ln(14);

}
}


$pdf =new PDF();
$pdf->SetLeftMargin(23);
$pdf->SetRightMargin(18);
$pdf->SetTopMargin(28);
$pdf->SetAutoPageBreak('T',40);


$pdf->AddPage();


require "conexao.php";


$result = pg_query($conn, "SELECT * FROM documentador WHERE id_documentador = '$id_documentador'");
if (!$result) {
   echo "Um erro ocorreu.\n";
   exit;
}

$row=pg_fetch_row($result,$i);
$assina=pg_fetch_row(pg_query($conn,"SELECT * FROM assinaturas WHERE id_assinaturas = '$row[7]'"),$i);
$documento=pg_fetch_row(pg_query($conn,"SELECT * FROM tipos WHERE id_tipo = '$row[1]'"),$i);
$dest=pg_fetch_row(pg_query($conn,"SELECT * FROM departamentos WHERE id_departamentos = '$row[3]'"),$i);

$pdf->SetLeftMargin(33);
$pdf->Ln(10);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(25, 5, $documento[1]);
$pdf->Cell(20, 5, '/MAT/Nº ');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(5, 5, $row[2]);
$data = strftime("%d/%m/%Y"); 
$pdf->Cell(30,5,'/2005 ' );
$pdf->Cell(20,5,'');
$pdf->Write(5,'DATA: ');
$pdf->Write(5,$data);
$pdf->Ln(10);
$pdf->SetLineWidth(0.5);
$pdf->Line($pdf->GetX()+1, $pdf->GetY()-1, $pdf->GetX()+158, $pdf->GetY()-1);
$pdf->Ln(3);
$pdf->SetFont('Times','B','12');
$pdf->Cell(0,0,'1 - IDENTIFICAÇÃO');
$pdf->Ln(7);
$pdf->SetLeftMargin(37);
$pdf->Write(0,'Procedência: ');
$pdf->SetFont('Times','','12');
$pdf->Write(0, 'DEPARTAMENTO DE MATEMÁTICA');
$pdf->Ln(3);
$pdf->SetFont('Times','B','12');
$pdf->Write(5,'Destino    : ');
$pdf->SetFont('Times','','12');
$pdf->Write(5,$dest[1]);
//$pdf->Ln(8);
$pdf->SetLeftMargin(33);
$pdf->Ln(10);
$pdf->SetLineWidth(0.5);
$pdf->Line($pdf->GetX()+1, $pdf->GetY()-1, $pdf->GetX()+158, $pdf->GetY()-1);
$pdf->Ln(3);
$pdf->SetFont('Times','B','12');
$pdf->Cell(0,0,'2 - ASSUNTO');
$pdf->Ln(5);
$pdf->SetLeftMargin(37);
$pdf->SetFont('Times','','12');
$pdf->Write(0,$row[4]);

//anexo

$pdf->SetLeftMargin(33);
$pdf->Ln(8);
$pdf->SetLineWidth(0.5);
$pdf->Line($pdf->GetX()+1, $pdf->GetY()-1, $pdf->GetX()+158, $pdf->GetY()-1);
$pdf->Ln(3);
$pdf->SetFont('Times','B','12');
$pdf->Cell(0,0,'3 - ANEXO(S)');
$pdf->Ln(5);
$pdf->SetLeftMargin(37);
$pdf->SetFont('Times','','12');
$pdf->Write(0,$row[9]);

$pdf->SetLeftMargin(33);
$pdf->Ln(8);
$pdf->SetLineWidth(0.5);
$pdf->Line($pdf->GetX()+1, $pdf->GetY()-1, $pdf->GetX()+158, $pdf->GetY()-1);
$pdf->Ln(3);
$pdf->SetFont('Times','B','12');
$pdf->Cell(0,0,'4 - MENSAGEM');
$pdf->Ln(20);
$pdf->SetLeftMargin(37);
$pdf->SetFont('Times','','12');
$pdf->Cell(13,0,'');
$pdf->Write(5,$row[4]);
$pdf->Write(5,',');
$pdf->Ln(11);
$pdf->MultiCell(0,5, $row[5], 'J');

//desfecho

$pdf->Ln(7);
$pdf->Cell(81,0,'');
$pdf->Write(5,$row[6]);
$pdf->Write(5,',');
$pdf->Ln(20);

//assinatura

$pdf->SetLineWidth(0.5);
$tam=($pdf->GetStringWidth($row[6]));
$pdf->Line($pdf->GetX()+81 - 0.71 * ($tam) , $pdf->GetY(), $pdf->GetX()+81 + 1.71 * ($tam) , $pdf->GetY());
$pdf->Ln(3);
$pdf->Cell(81,0,'');
$pdf->Write(5,$assina[1]);
$pdf->Ln(5);
$pdf->Cell(81,0,'');
$pdf->Write(5,$assina[2]);


 
$pdf->Output("teste_t2.pdf","I");


?>
