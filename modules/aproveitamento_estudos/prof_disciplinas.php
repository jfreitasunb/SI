<?php


if(isset($_POST['periodo']))
{
$profs="select name||' '||firstname as nome, d.codigo as codigo,d.nome as disciplina,periodo as periodo from aproveitamento_prof_disc a, users u,disciplinas_MAT d where u.coduser=a.coduser and d.codigo=a.codigo order by d.codigo";

$query_profs=pg_query($profs);



while($res=pg_fetch_row($profs))
	{
	
	}

}


if(!isset($_POST['periodo']))
{


}

?>
