<?php
   require("head_user.php");
?>
<?php

/// ALTERA TABELA USERS PARA REORDENAR POR CODUSER
   $query="select * from users";
   $result=db_query($query);
   $count=db_num_rows($result);
   $i=0;
   $novo_coduser=0;
	while ($i<$count)
	{ 
       $usuario_a_mudar=db_fetch_row($result,$i);
       $coduser_a_mudar=$usuario_a_mudar[0];
	if (($coduser_a_mudar<>0) and ($coduser_a_mudar<>99))
	{$novo_coduser=$novo_coduser+1;
	print "; o coduser ".$coduser_a_mudar." passa a ser o ".$novo_coduser;
        $result2=db_query("update users set coduser=? where coduser=?", array($novo_coduser, $coduser_a_mudar));
	}
	$i=$i+1;
	}
        db_free_result($result);
//
?>

