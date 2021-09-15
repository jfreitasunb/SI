<?php

function imprime_parecer($codigo,$tipo,$parecer,$id_entrada)
{
//$tmpfname = tempnam("/tmp", "APROV");
$arquivo="parecer_".$codigo."_".$id_entrada.".html";
//$caminho="../aproveitamento_estudos/pareceres/".$arquivo;
//$caminho="/tmp".$arquivo;

$query_dados_aluno=pg_query("select * from aproveitamento_entrada where id_entrada='".$id_entrada."'");
$dados_aluno=pg_fetch_array($query_dados_aluno);

$query_disciplina=pg_query("select nome from disciplinas_MAT where codigo='".$codigo."'");
$disciplina=pg_fetch_row($query_disciplina);

if ($tipo=="EE") {$EE="X"; $EC="";} else {$EC=""; $EE="X";}


$data_de_hoje=date(d)."/".date(m)."/".date(Y);


$texto="<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">
<HTML>
<HEAD>
	<META HTTP-EQUIV=\"CONTENT-TYPE\" CONTENT=\"text/html; charset=utf-8\">
	<TITLE></TITLE>
	<META NAME=\"GENERATOR\" CONTENT=\"BrOffice.org 3.2  (Unix)\">
	<META NAME=\"AUTHOR\" CONTENT=\"Guy Grebot\">
	<META NAME=\"CREATED\" CONTENT=\"20120418;17142800\">
	<META NAME=\"CHANGEDBY\" CONTENT=\"Guy (PROFESSOR)\">
	<META NAME=\"CHANGED\" CONTENT=\"20120419;16405000\">
	<STYLE TYPE=\"text/css\">
	<!--
		@page { margin: 1.5cm }
		P { margin-bottom: 0.21cm }
		P.western { so-language: pt-BR }
		TD P { margin-bottom: 0cm }
		TD P.western { so-language: pt-BR }
	-->
	</STYLE>
</HEAD>
<BODY LANG=\"pt-BR\" DIR=\"LTR\">
<TABLE WIDTH=100% BORDER=1 BORDERCOLOR=\"#000000\" CELLPADDING=4 CELLSPACING=0 FRAME=BELOW RULES=GROUPS>
	<COLGROUP>
		<COL WIDTH=117*>
	</COLGROUP>
	<COLGROUP>
		<COL WIDTH=42*>
		<COL WIDTH=2*>
	</COLGROUP>
	<COLGROUP>
		<COL WIDTH=40*>
	</COLGROUP>
	<COLGROUP>
		<COL WIDTH=18*>
	</COLGROUP>
	<COLGROUP>
		<COL WIDTH=37*>
	</COLGROUP>
	<TBODY>
		<TR VALIGN=TOP>
			<TD COLSPAN=2 WIDTH=62%>
				<P CLASS=\"western\"><BR>
				</P>
			</TD>
			<TD COLSPAN=4 WIDTH=38%>
				<P CLASS=\"western\" ALIGN=RIGHT><BR>
				</P>
			</TD>
		</TR>
	</TBODY>
	<TBODY>
		<TR VALIGN=TOP>
			<TD COLSPAN=2 WIDTH=62%>
				<P CLASS=\"western\"><FONT SIZE=2>ESPECIFICAÇÃO DE ADAPTAÇÃO DE
				ESTUDOS</FONT></P>
			</TD>
			<TD COLSPAN=4 WIDTH=38%>
				<P CLASS=\"western\" ALIGN=RIGHT>Universidade de Brasília</P>
				<P CLASS=\"western\" ALIGN=RIGHT><FONT SIZE=2>Diretoria de
				Administração Acadêmica</FONT></P>
			</TD>
		</TR>
	</TBODY>
	<TBODY>
		<TR>
			<TD COLSPAN=6 WIDTH=100% VALIGN=TOP>
				<P CLASS=\"western\">1- Identificação do aluno: 
				</P>
			</TD>
		</TR>
		<TR VALIGN=TOP>
			<TD COLSPAN=2 WIDTH=62%>
				<P CLASS=\"western\">Nome 
				</P>
				<P CLASS=\"western\">".$dados_aluno['nome']."</P>
			</TD>
			<TD COLSPAN=3 WIDTH=24%>
				<P CLASS=\"western\">Matrícula:</P>
				<P CLASS=\"western\">".$dados_aluno['matricula']."</P>
			</TD>
			<TD WIDTH=14%>
				<P CLASS=\"western\">Opção:</P>
				<P CLASS=\"western\">".$dados_aluno['opcao']."</P>
			</TD>
		</TR>
	</TBODY>
	<TBODY>
		<TR>
			<TD COLSPAN=6 WIDTH=100% VALIGN=TOP>
				<P CLASS=\"western\">2- Identificação da disciplina:</P>
			</TD>
		</TR>
		<TR VALIGN=TOP>
			<TD WIDTH=46%>
				<P CLASS=\"western\">Nome  
				</P>
				<P CLASS=\"western\">".$disciplina[0]."</P>
			</TD>
			<TD COLSPAN=2 WIDTH=17%>
				<P CLASS=\"western\">Cód. disciplina</P>
				<P CLASS=\"western\">".$codigo."</P>
			</TD>
			<TD WIDTH=16%>
				<P CLASS=\"western\">Departamento</P>
				<P CLASS=\"western\">MAT</P>
			</TD>
			<TD COLSPAN=2 WIDTH=21%>
				<P CLASS=\"western\">Processo referência 
				</P>
				<P CLASS=\"western\">".$dados_aluno['unbdoc']."</P>
			</TD>
		</TR>
	</TBODY>
	<TBODY>
		<TR>
			<TD COLSPAN=6 WIDTH=100% VALIGN=TOP>
				<P CLASS=\"western\"><BR>
				</P>
			</TD>
		</TR>
	</TBODY>
	<TBODY>
		<TR>
			<TD COLSPAN=6 WIDTH=100% VALIGN=TOP>
				<P CLASS=\"western\">3- Especificação</P>
			</TD>
		</TR>
		<TR>
			<TD COLSPAN=6 WIDTH=100% VALIGN=TOP>
				<P CLASS=\"western\">Recomendo  (".$EC.") Estudos complementares  (".$EE.")
				Exame especial  na disciplina acima identificada</P>
			</TD>
		</TR>
		<TR>
			<TD COLSPAN=6 WIDTH=100% VALIGN=TOP>
				<P CLASS=\"western\"><BR>
				</P>
			</TD>
		</TR>
		<TR>
			<TD COLSPAN=6 WIDTH=100% VALIGN=TOP>
				<DL>
					<DL>
						<DD>
						<TABLE WIDTH=474 BORDER=0 CELLPADDING=4 CELLSPACING=0>
							<COL WIDTH=466>
							<TR>
								<TD WIDTH=466 VALIGN=TOP>
									<P CLASS=\"western\">Tópicos da disciplina para adaptação 
									</P>
									<P CLASS=\"western\"><BR>
									</P>
									<P CLASS=\"western\">".$parecer."</P>
									<P CLASS=\"western\"><BR>
									</P>
									<P CLASS=\"western\"><BR>
									</P>
									<P CLASS=\"western\"><BR>
									</P>
									<P CLASS=\"western\"><BR>
									</P>
									<P CLASS=\"western\"><BR>
									</P>
									<P CLASS=\"western\"><BR>
									</P>
									<P CLASS=\"western\"><BR>
									</P>
									<P CLASS=\"western\"><BR>
									</P>
									<P CLASS=\"western\"><BR>
									</P>
									<P CLASS=\"western\"><BR>
									</P>
									<P CLASS=\"western\"><BR>
									</P>
									<P CLASS=\"western\"><BR>
									</P>
									<P CLASS=\"western\"><BR>
									</P>
								</TD>
							</TR>
						</TABLE>
					</DL>
				</DL>
				<P CLASS=\"western\"><BR>
				</P>
				<P CLASS=\"western\"><BR>
				</P>
				<P CLASS=\"western\" ALIGN=CENTER STYLE=\"margin-bottom: 0cm\"><BR>
				</P>
			</TD>
		</TR>
	</TBODY>
	<TBODY>
		<TR>
			<TD COLSPAN=6 WIDTH=100% HEIGHT=90 VALIGN=TOP>
				<P CLASS=\"western\">4- Autenticação</P>
				<DL>
					<DL>
						<DL>
							<DL>
								<DL>
									<DD>
									<TABLE WIDTH=381 BORDER=0 CELLPADDING=4 CELLSPACING=0>
										<COL WIDTH=153>
										<COL WIDTH=211>
										<TR VALIGN=TOP>
											<TD WIDTH=153>
								<P CLASS=\"western\" ALIGN=CENTER>".$data_de_hoje."</P></TD>
											<TD WIDTH=211>
												<P CLASS=\"western\" ALIGN=CENTER>_________________________</P>
											</TD>
										</TR>
										<TR VALIGN=TOP>
											<TD WIDTH=153>
												<P CLASS=\"western\" ALIGN=CENTER>data</P>
											</TD>
											<TD WIDTH=211>
												<P CLASS=\"western\" ALIGN=CENTER>assinatura</P>
											</TD>
										</TR>
									</TABLE>
								</DL>
							</DL>
						</DL>
					</DL>
				</DL>
				<P CLASS=\"western\" ALIGN=CENTER STYLE=\"margin-bottom: 0cm\">      
				            
				</P>
				<P CLASS=\"western\" ALIGN=CENTER STYLE=\"margin-bottom: 0cm\">      
				                     		</P>
			</TD>
		</TR>
	</TBODY>
</TABLE>
<P CLASS=\"western\" STYLE=\"margin-bottom: 0cm\"><BR>
</P>
<P CLASS=\"western\" ALIGN=CENTER STYLE=\"margin-bottom: 0cm\"><BR>
</P>
</BODY>
</HTML>";

$arquivo="parecer_".$codigo."_".$id_entrada.".html";

$tmpfname = tempnam("/var/www/si/modules/servidor_admin/Tex/", "APRO").".html";                         

$handle = fopen($tmpfname, "w");
fwrite($handle, $texto);
fclose($handle);

// do here something

//unlink($tmpfname);
        exec(" chmod 777 ".$tmpfname."");
        $cmd2="cd /var/www/si/modules/servidor_admin/Tex/; mv ".$tmpfname." ".$arquivo;                                   //do Guy
        exec($cmd2);                                                                            //do Guy
        exec("cd /var/www/si/modules/servidor_admin/Tex/; mv ".$arquivo." /paginas/si/modules/aproveitamento_estudos/pareceres");



//echo $data_de_hoje."-".$caminho."-".$texto;

//file_put_contents($tempfname, $texto);
//$cmd=" mv ".$tempfname." ".$caminho;                                   //do Guy
//exec($cmd2);
//return $arquivo;
return $arquivo;

}

?>

