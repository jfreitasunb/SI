<?
include("head_oferta.php");
/* CRIAR/ALTERAR OFERTA DO SEMESTRE/ANO:
Ajuda para a elaboração da lista de ofertas
*/
?>

<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
  <body>
      <table class=big>
      <tr>
        <td class=header align=center colspan=2>
        <h1>Cria&ccedil;&atilde;o de lista de ofertas</h1>
        </td>
      </tr>
        <tr><td>1- Definir corretamente as disciplinas obrigat&oacute;rias a serem ofertadas por semestre (na tabela de oferta_semestres).</td></tr>
	<tr><td>2- Criar as disciplinas magistrais e os grupos de aulas teoricas com a fun&ccedil;&atilde;o "Magistral- Cria&ccedil;&atilde;o de disciplina magistr" e  "Magistra Grupos de aulas te&oacute;rica"</td></tr>
        <tr><td>3- Criar uma nova lista usando a fun&ccedil;&atilde;o "Criar nova lista de ofertas".</td></tr>
        <tr><td>4- Incluir novas discilpinas optativas atrav&egrave;s da fu&ccedil;&atilde;o "Inclus&atilde;o de nova disciplina/turma".</td></tr>
        <tr><td>5- Definir as datas de abertura e fechamento da terla de escolha do professor. </td></tr>
        <tr><td>6- Usar a fun&ccedil;&atilde;o "Atua&ccedil;&otilde;es no Noturno/prioridades" para atualizar o rodízio do noturno.</td></tr>
        <tr><td>7- Após fechado o período de escolha de discilpinas, roda o esboço da lista com a &ccedil;&atilde;o "Cria um esbo&ccedil;o da lista de ofertas (aloca&ccedil;&atilde;o de professores)".</td></tr>
        <tr><td>8- Uma vez criado um esboço da lista, ele pode ser alterado e ajustado com a fu&ccedil;&atilde;o "Atualiza&ccedil;&atilde;o da lista provis&oacute;ria".</td></tr>
	<tr><td>9- Uma vez a lista aprovada no colegiado, abrir a tela de "Atualiza&ccedil;&atilde;o da lista provisór e clicar na o&ccedil;&atilde; "submeter lista" na parte inferir da p&aacute;gina.</td></tr> 
<td colspan=2 align=center>
</td>
</tr>
</table>
</BODY>
</HTML>

<?
pg_close($idconn);
?>


