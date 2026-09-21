<?php
   session_start();
   include("function_php.php");

   // Conexão com o banco de dados (agora retorna um objeto PDO)
   $idconn = db_connect();

   // Previne erros de "Undefined variable" se $idmodule não estiver setado antes
   $idmodule = isset($idmodule) ? $idmodule : null;

   // Checa a identificação
   if (isset($_POST['login']) && isset($_POST['pass'])) {
       $identification = secure($_POST['login'], $_POST['pass'], $idmodule);
   } else {
       // Validação extra para evitar warnings se a sessão não existir
       $sess_login = isset($_SESSION['login']) ? $_SESSION['login'] : '';
       $sess_passwd = isset($_SESSION['passwd']) ? $_SESSION['passwd'] : '';
       $identification = secure($sess_login, $sess_passwd, $idmodule);
   }

   // Se não estivermos identificados, transfere para a página de login
   if (!$identification)
   {
?>
     <script language="javascript">
       document.location.href="../index.php"
     </script>
<?php
       exit; // IMPORTANTE: Interrompe o carregamento da página caso o usuário não esteja logado
   }
  
   // PDO: Consulta principal com Prepared Statement para evitar SQL Injection
   $query = "SELECT m.url, m.name, m.idmodule FROM module m, permission p WHERE m.idmodule = p.idmodule AND p.login = :login AND p.permission > 0";
   
   try {
       $stmt = $idconn->prepare($query);
       $stmt->execute([':login' => $_SESSION['login']]);
       // Traz todos os resultados em um array associativo (substitui a necessidade do pg_numrows)
       $modules = $stmt->fetchAll(PDO::FETCH_ASSOC); 
   } catch (PDOException $e) {
       die(error());
   }
?>
<html>
  <head>
    <script language="JavaScript" src="menu1.js"></script>
    <script language="JavaScript">
      var menu=new CreerMenu("dyn03.gif","dyn04.gif","dyn02.gif","dyn05.gif");
      
<?php 
    // Usamos um foreach para percorrer os resultados (muito mais limpo que o while com contador)
    foreach ($modules as $array)
    {
        echo "      menu.AddRub(\"<B>".addslashes($array["name"])."</B>\",\"N\");\n";
             
        // PDO: Segunda consulta (Interna) 
        $query2 = "SELECT funcurl, funcname FROM functions f WHERE f.idmodule = :idmodule";
        
        try {
            $stmt2 = $idconn->prepare($query2);
            $stmt2->execute([':idmodule' => $array["idmodule"]]);
            $functions = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($functions as $array2)
            {
                echo "      menu.AddLien(\"".addslashes($array2["funcname"])."\",\"".addslashes($array2["funcurl"])."\");\n"; 
            }
        } catch (PDOException $e) {
            die(error());
        }
    }
?>
    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
  </head>
<?php
  if (isset($_GET['fra']))
  {
?>
    <script language="javascript">
      // document.location.href="./menu.php"
    </script>
    <frame name="left" src="menu.php" noresize> 
<?php
  }
  else
  {
?>
  <frameset cols="20%,80%" frameborder=no>
    <frame name="left" src="menu.php" noresize>
    <frame name="right" src="accueil.php" noresize>
  </frameset>
<?php
  }
?> 
</html>  
<?php
  // Fechando a conexão no padrão PDO
  $idconn = null;
?>