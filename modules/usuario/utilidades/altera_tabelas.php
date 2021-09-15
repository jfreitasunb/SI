<?php
   include("head_user.php");
?>
<?php

/// ALTERA TABELA USERS PARA REORDENAR POR CODUSER
   $query="select * from users";
   $result=pg_query($query);
   $count=pg_num_rows($result);
   $i=0;
   $novo_coduser=0;
	while ($i<$count)
	{ 
       $usuario_a_mudar=pg_fetch_row($result,$i);
       $coduser_a_mudar=$usuario_a_mudar[0];
	if (($coduser_a_mudar<>0) and ($coduser_a_mudar<>99))
	{$novo_coduser=$novo_coduser+1;
	print "; o coduser ".$coduser_a_mudar." passa a ser o ".$novo_coduser;
        $query="update users set coduser='".$novo_coduser."' where coduser='".$coduser_a_mudar."'";        
        $result2=pg_query($query);
	}
	$i=$i+1;
	}
        pg_free_result($result);
//
?>

