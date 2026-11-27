<?php
  require("head_aliases.php");

  $query = "select ux.login, u.* from users u, unix ux where u.coduser=ux.coduser and ux.coduser<>'0' order by u.name";
  $query__p = array();
  $result = db_query($query, $query__p);
  $nb_enreg = db_num_rows($result);
  $selected_us = isset($_GET['US']) ? $_GET['US'] : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <base target="linha2">
  <link type="text/css" rel="stylesheet" href="../../global/grafic.css?v=<?php echo (int)@filemtime(__DIR__ . '/../../global/grafic.css'); ?>">
  <script src="navig_js.js"></script>
  <script src="formu.js"></script>
  <script>
    var utilisateurs = new Array();
    var i = 0;
  </script>
  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      background: var(--si-surface-muted, #f7f9fc);
    }

    .si-alias-toolbar {
      min-height: 100%;
      padding: 16px 24px;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: center;
      gap: 12px;
    }

    .si-alias-toolbar label {
      font-weight: 600;
      color: var(--unb-blue, #003366);
      font-size: 14px;
      white-space: nowrap;
    }

    .si-alias-toolbar select {
      min-width: 280px;
      max-width: 460px;
      width: 100%;
      flex: 1 1 280px;
    }
  </style>
</head>
<body>
  <form method="POST" name="utilisateur" action="cria_alias.php" class="si-alias-toolbar">
    <label for="alias-user-select">Selecione um usuário:</label>
    <select id="alias-user-select" name="user" onchange="enregistrement_modif(utilisateurs,this.selectedIndex,nb_enreg);">
<?php
    $js_init = array();
    for ($i = 0; $i < $nb_enreg; $i++)
    {
       $tab = db_fetch_array($result, $i);
       $nome = $tab['name'];
       $sobrenome = $tab['firstname'];
       $param = js_str($tab['login']) . ',' . js_str($nome . ' ' . $sobrenome);
       $param = str_replace(array("\n", "\r"), " ", $param);
       $js_init[] = "utilisateurs[" . (int)$i . "] = new modif_conta(" . $param . ");";

       echo "<option value='" . h($tab['coduser']) . "-" . h($nome) . "-" . h($sobrenome) . "'";
       if ($selected_us !== '' && $selected_us == $tab['coduser']) {
           echo " selected";
       }
       echo ">" . h($nome) . " " . h($sobrenome) . "</option>\n";
    }
?>
    </select>
    <input type="hidden" name="login">
    <input type="hidden" name="nome">
    <input type="submit" name="registra" value="Confirmar">
  </form>

  <script>
    <?php echo implode("\n    ", $js_init); ?>
    var nb_enreg = <?php echo (int)($nb_enreg - 1); ?>;
    if (nb_enreg >= 0 && typeof enregistrement_modif === 'function') {
      enregistrement_modif(utilisateurs, i, nb_enreg);
    }
  </script>
</body>
</html>
<?php
  db_close($idconn);
?>
