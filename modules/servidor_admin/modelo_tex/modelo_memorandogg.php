<?php
$texto_arquivo="\documentclass[12pt]{artigo} 
\usepackage[english,portuges,brazil]{babel}
\usepackage[latin1]{inputenc}
\addtolength{\oddsidemargin}{-2pc}
\addtolength{\evensidemargin}{2pc}
\setlength{\topmargin}{.5cm}
\setlength{\textwidth}{16cm} 
\setlength{\textheight}{22.0cm}
\pagestyle{empty}
\begin{document}
\vspace*{.8cm}
\timbrado
\parindent=2cm 
\setlength{\baselineskip}{5mm}
\noindent 
\begin{minipage}{16cm}
\vspace*{-12mm}
\parindent=2cm
\setlength{\baselineskip}{5mm}
\vspace*{.2cm}
\noindent
\small
{\bf  MEMO/MAT/N\primo}".$seds['LATEXNUMERO']."\/05 \hfill {DATA:} {".$seds['LATEXDATA']."}
\vum \\
{\bf VIA:} {".$seds['LATEXVIA']."}  
\\
\mbox{} \hrulefill\
\\
{\bf 1 - IDENTIFICA\c{C}\~AO} 
\\
\phantom{xxx}{\bf Proced\^encia:} {DEPARTAMENTO DE MATEM\'ATICA - UnB}
\\
\phantom{xxx}{\bf Destino \phantom{xxx}:} {".$seds['LATEXDESTINO']."}
\\
\mbox{} \hrulefill\
\\
{\bf 2 - ASSUNTO:} \\
\phantom{xxx}{".$seds['LATEXASSUNTO']."}
\\
\mbox{} \hrulefill\
\\
{\bf 3 - ANEXO(S):} 
\\
\phantom{xxx} {".$seds['LATEXANEXO']."}
\\
\mbox{} \hrulefill\
\\
{ \bf 4 - MENSAGEM} 
\end{minipage}
\setlength{\baselineskip}{9mm}
\vspace*{.92cm} 

".$seds['LATEXVOCATIVO']."\,
\vspace*{8mm} 

".$seds['LATEXMENSAGEM']."
\vspace*{15mm} 
\begin{center} 
\setlength{\baselineskip}{6mm}
".$seds['LATEXDESFECHO']."\,
\vspace*{15mm} \\
$\overline{\phantom{x}\mbox{\bf ".$seds['LATEXNASSINATURA']."} \phantom{x}}$ 
\\
".$seds['LATEXCASSINATURA']."
\end{center}
\end{document}
";

?>

