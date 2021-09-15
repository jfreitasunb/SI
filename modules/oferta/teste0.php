<?php
include("head_oferta.php");
//include ("teste1.php");
include("manipula_arquivo_lista_de_ofertas.php");


/*
1- mostrar a lista de documentos - dropdown de documentos por categoria: select - deixar as atas de lado (serão tratadas em outro formulário) escolhe o documento.
2- selciona um ou mais arquivos para upload. o documento esta mostrado na pagina com possibilidade de voltar e mudar o documento.
3- registra a seleção; só pode ser arquivo do tipo ... e de um certo tamanho
4- salva o(s) arquivo(s) no diretorio de anexos. Renomear o arquivo: id_documentador_X.extensao em que X é o numero do anexo
5- inscreve na tabela admin_anexos: id_documentador, nome_do_arquivo, nome_diretorio(anexos,audios)

------ para audios das atas
1) O usuário faz o upload para um diretório específico;
2) O usuário abre a tela do sistema, digita as informações de data e outras coisas. O SI apresenta os arquivos que estão no diretório do servidor para o usuário selecionar qual ele enviou.
3) Após confirmação do usuário, o SI renomeia o arquivo e muda ele para a pasta correta, onde o usuário não teria acesso nem via FTP.
-------

*/



?>
<html>
<header>

<script language="javascript">

      var count=1;

      function cache_tout()
      {
        document.getElementById("entete1").style.visibility="hidden";
        document.getElementById("entete2").style.visibility="hidden"; 
<?
        for($i=1;$i<21;$i++)
          echo "document.getElementById(\"id".$i."\").style.visibility=\"hidden\";";
?>
      }

      function compte(nb)
      {
        count=1;
        if (nb>20)
          nb=20;
        cache_tout();
        for(i=0;i<nb;i++)
          montre();
      }
 function champsok()
      {
        if (document.forms["formu"].mod_name.value.length == 0)
        {
          alert("Le champs correpsondant au nom du module est obligatoire. Veuillez le renseigner, svp.");
          document.forms["formu"].mod_name.focus();
          return false;
        }
        if (document.forms["formu"].mod_url.value.length == 0)
        {
          alert("Le champs correpsondant a l'url du module est obligatoire. Veuillez le renseigner, svp.");
          document.forms["formu"].mod_url.focus();
          return false;
        }
        if (document.forms["formu"].descr.value.length == 0)
        {
          alert("Le champs correpsondant a la description du module est obligatoire. Veuillez le renseigner, svp.");
          document.forms["formu"].mod_name.focus();
          return false;
        }
        return true;
      }

    </script>
    <script language=javascript src="./scripts_uploads/function_js.js">
    </script>
    <script language=javascript src="formu.js">
    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
<body>
<table class=big>
      <tr>
        <td class=header align=center>
          <h1>Departamento de Matem&aacute;tica</h1>
        </td>
	</tr>
        <tr>
        <td align=center>
               <title>Atualiza&ccedil;&atilde;o da Lista de Ofertas</title>
        <table class=form>

<?
if (!isset($_POST['continuar']))
{
//$query_acusa_lista=pg_query("select * from oferta_acusa_lista order by ano desc,semestre desc");

?>
   <form method="POST" name="formu" action="teste0.php"  enctype="multipart/form-data">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Corre&ccedil;&atilde;o da Lista de Oferta de Disciplinas</h1>
        </td>
      </tr>

<tr><td>Escolha a lista:
        </select>
        <select name='lista'>
        <?
//        while ($registro=pg_fetch_row($query_acusa_lista))
	for ($i=2012;$i>2006;$i=$i-1)
       {
        ?>
        <option value="<?echo "2_".$i;?>"> 2 &ordm;/ <? echo $i;?></option>
        <option value="<?echo "1_".$i;?>"> 1 &ordm;/ <? echo $i;?></option>
        <?
        }
        ?>
        </tr>
		<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
		<tr><td colspan=2><b>Escolha o arquivo .txt da lista de discilpinas ministradas pelos professores do MAT, obtido do SIGRA:</b></td></tr>



	<tr><td>Arquivo:</td><td><input type=file name='arquivo'></td></tr>

<tr><td colspan=2 align=center><input type="submit" name='continuar' value="Confirmar" /></td></tr>
</form>
</table>
</td></tr>
</table>
</body>
</html>
<?
}

if (isset($_POST['continuar']) and !isset($_POST['confirmar']))
{
$lista=explode("_",$_POST['lista']);
$semestre=$lista[0];
$ano=$lista[1];


// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = '/paginas/si/modules/oferta/listas_SAA/';
 
// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb
 
// Array com as extensões permitidas
$_UP['extensoes'] = array('txt');
	 
// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
$_UP['renomeia'] = true;
 
// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = 'N&atilde;o houve erro';
$_UP['erros'][1] = 'O arquivo no upload &eacute; maior do que o limite do PHP';
$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$_UP['erros'][4] = 'N&atilde;o foi feito o upload do arquivo';


// tabela admin_anexos: id_documento, numero_anexo, nome_arquivo


	if ($_FILES['arquivo']['name']!="")
		{
		//############### CASO ESTEJA PRONTO PARA UPLOAD
		// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
		if ($_FILES['arquivo']['error'] != 0) 
			{
			die("N&atilde;o foi poss&iacute;vel fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error']]);
			exit; // Para a execução do script
			}
	 	// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
	 
		// Faz a verificação da extensão do arquivo
		$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
		if (array_search($extensao, $_UP['extensoes']) === false) 
			{
			echo "Por favor, envie arquivos com as seguintes extens&otilde;es: txt";
			}
	 
		// Faz a verificação do tamanho do arquivo
			else if ($_UP['tamanho'] < $_FILES['arquivo']['size']) 
			{
			echo "O arquivo enviado &eacute; muito grande, envie arquivos de at&eacute; 2Mb.";
			}
	 
		// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
			else {
		// Primeiro verifica se deve trocar o nome do arquivo
				if ($_UP['renomeia'] == true) 
					{
		// Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
					$nome_final = "lista_carga_professor_".$semestre."_".$ano.".".$extensao;
					//echo $nome_final;
					} else 
					{
		// Mantém o nome original do arquivo
					$nome_final = $_FILES['arquivo']['name'];
					}
	 
		// Depois verifica se é possível mover o arquivo para a pasta escolhida
				if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) 
					{
		// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo; insere ponteiro na tabela
					echo "Upload efetuado com sucesso!";
					echo '<br /><a href="http://www.mat.unb.br/si/modules/oferta/listas_SAA/'.$nome_final . '">Clique aqui para acessar o arquivo</a><br>';

					// incluir aqui a rotina de manipulacao do arquivo!!!
					if (testa_arquivo($semestre,$ano,$nome_final,"lstofedlp"))
                                                {
                                                echo "<BR> Testando arquivos <BR>";
                                                echo "O arquivo e tipo lstofedlp<BR><BR>";
                                                $manipula=TRUE;
                                                $nome=$nome_final;
                                                // incluir aqui a rotina de manipulacao do arquivo!!!
//                                              $array_linhas=manipula_arquivo_atualiza_lista($semestre,$ano,$nome_final);
//                                              $processadas=processa_linhas($array_linhas,$semestre,$ano);
                                                }
                                        else 
                                                {
                                                echo "<BR><BR> O arquivo carregado nao e compativel com o tipo lstofedlp de arquivo desejado<br>";
                                                echo "<BR> Favor repetir a operacao<BR><BR>";
                                                $manipula[$i]=FALSE;
                                                }
					}
					else 
					{
					// Não foi possível fazer o upload, provavelmente a pasta está incorreta
					echo "N&atilde;o foi poss&iacute;vel enviar o arquivo, tente novamente";
					}
				}
		}


if ($manipula)
        {
echo "<BR> Manipulando os arquivos <BR>";
//set_time_limit(60);

// manipula arquivo de carga:
        $lista_arquivo=manipula_arquivo_atualiza_lista($semestre,$ano,$nome);
//        echo " cria array de profs<br>";
        $array_profs=monta_array_de_profs();
        $query_limpa=pg_query("delete from oferta_carga_professor where semestre='".$semestre."' and ano='".$ano."'") or die ("problema de acesso ao banco");
//        echo "<BR>".$query_limpa."<BR>";
        $melhora_lista=melhora_lista_carga($array_profs,$lista_arquivo,$semestre,$ano);
//        echo $melhora_lista;

        }

?>

</table>
</td></tr>
</table>
</body>
</html>

<?

}

pg_close($idconn);
?>

