<?php
  require("head_aliases.php");

  $post_user = isset($_POST['user']) ? (string)$_POST['user'] : '';
  $usuario = ($post_user !== '') ? explode("-", $post_user) : array('', '', '');

  $coduser   = isset($usuario[0]) ? $usuario[0] : '';
  $nome      = isset($usuario[1]) ? $usuario[1] : '';
  $sobrenome = isset($usuario[2]) ? $usuario[2] : '';

function retira_acentos($texto)
{
  $array1 = array("á","à","â","ã","ä","é","è","ê","ë","í","ì","î","ï","ó","ò","ô","õ","ö","ú","ù","û","ü","ç","Á","À","Â","Ã","Ä","É","È","Ê","Ë","Í","Ì","Î","Ï","Ó","Ò","Ô","Õ","Ö","Ú","Ù","Û","Ü","Ç");
  $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C");
  return str_replace($array1, $array2, (string)$texto);
}

function gera_alias($nome, $sobrenome)
{
  $lista = array("DE","DA","DO","DOS","DAS");

  $alias = "";
  $nome_0 = explode(" ", trim(retira_acentos($nome)));
  for ($i = 0; $i < count($nome_0); $i++) {
      if (!(in_array(strtoupper($nome_0[$i]), $lista))) {
          $letras = chunk_split($nome_0[$i]);
          $alias = $alias . $letras[0] . ".";
      }
  }

  $sobrenome_0 = explode(" ", trim(retira_acentos($sobrenome)));
  for ($i = 0; $i < count($sobrenome_0); $i++) {
      if ($i == count($sobrenome_0) - 1) {
          $alias = $alias . $sobrenome_0[$i];
      } else {
          if (!(in_array(strtoupper($sobrenome_0[$i]), $lista))) {
              $letras = chunk_split($sobrenome_0[$i]);
              $alias = $alias . $letras[0] . ".";
          }
      }
  }
  return $alias;
}

function checa_alias($alias)
{
  $alias = retira_acentos($alias);
  $alias0 = str_replace(" ", ".", $alias);

  $query_checa = "select * from aliases where alias=? or alias2=?";
  $query_checa__p = array($alias0, $alias0);
  $res_query_checa = db_query($query_checa, $query_checa__p);
  $num_res_checa = db_num_rows($res_query_checa);

  if ($num_res_checa == 0) {
      return "ok";
  }
  return "ja_existe_um";
}

function grava_alias($coduser, $alias)
{
  exige_escrita();
  $alias = retira_acentos($alias);
  $alias_0 = str_replace(" ", ".", trim((string)$alias));
  if (!preg_match('/^[A-Za-z0-9._-]{1,64}$/', $alias_0)) {
      http_response_code(400);
      die(error("Alias invalido: use apenas letras, numeros, ponto, hifen ou sublinhado."));
  }
  $alias0 = $alias_0;

  $query_banco = "select * from aliases where coduser=?";
  $query_banco__p = array($coduser);
  $res_query = db_query($query_banco, $query_banco__p);
  $num_res = db_num_rows($res_query);

  if ($num_res != 0) {
      $query_grava = "update aliases set alias2=? where coduser=?";
      $query_grava__p = array($alias0, $coduser);
      db_query($query_grava, $query_grava__p);
      return "Alias atualizado";
  } else {
      $query_grava = "insert into aliases values(?,?,'')";
      $query_grava__p = array($coduser, $alias0);
      db_query($query_grava, $query_grava__p);
      return "Alias inserido";
  }
}

  $salvo_msg = '';
  $mensagem = '';
  $alias = '';
  $alias2 = '';

  if (isset($_POST['confirma']) && isset($_POST['alias2']) && checa_alias($_POST['alias2']) == "ok") {
      $salvo_msg = grava_alias($coduser, $_POST['alias2']);
  } elseif ($post_user !== '') {
      $pega_aliases = "select alias,alias2 from aliases where coduser=?";
      $pega_aliases__p = array($coduser);
      $query_aliases = db_query($pega_aliases, $pega_aliases__p);
      $res_aliases = db_fetch_array($query_aliases);
      $alias = ($res_aliases && isset($res_aliases['alias']))
          ? $res_aliases['alias']
          : '';
      if (isset($_POST['alias2'])) {
          $alias2 = $_POST['alias2'];
          if (checa_alias($_POST['alias2']) != "ok") {
              $mensagem = "Este Alias já existe. Escolha outro.";
          }
      } else {
          $alias2 = ($res_aliases && isset($res_aliases['alias2']))
              ? $res_aliases['alias2']
              : '';
      }
  }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link type="text/css" rel="stylesheet" href="../../global/grafic.css?v=<?php echo (int)@filemtime(__DIR__ . '/../../global/grafic.css'); ?>">
  <script src="navig_js.js"></script>
  <script src="formu.js"></script>
  <style>
    html, body {
      margin: 0;
      padding: 0;
      background: var(--si-surface, #ffffff);
    }

    .si-alias-body {
      padding: 28px 24px 32px;
      display: flex;
      justify-content: center;
    }

    .si-alias-box {
      width: 100%;
      max-width: 620px;
      background: var(--si-surface, #ffffff);
      border: 1px solid var(--si-border, #d0dbe6);
      border-radius: var(--si-radius, 10px);
      box-shadow: var(--si-shadow-sm, 0 1px 2px rgba(0, 34, 68, 0.06));
      overflow: hidden;
    }

    .si-alias-box-head {
      background: var(--unb-blue-mid, #004a8f);
      color: #ffffff;
      padding: 12px 18px;
      font-size: 14.5px;
      font-weight: 600;
    }

    .si-alias-box-content {
      padding: 20px 22px 22px;
    }

    .si-alias-row {
      display: grid;
      grid-template-columns: 200px 1fr;
      align-items: center;
      gap: 10px 16px;
      padding: 10px 0;
      border-bottom: 1px solid #eef2f6;
    }

    .si-alias-row:last-of-type {
      border-bottom: 0;
    }

    .si-alias-row label,
    .si-alias-label {
      font-weight: 600;
      color: var(--si-text, #1a2433);
      font-size: 14px;
    }

    .si-alias-value {
      font-size: 14.5px;
      font-weight: 600;
      color: var(--unb-blue, #003366);
    }

    .si-alias-row input[type="text"] {
      width: 100%;
      padding: 9px 12px;
      font-size: 14px;
    }

    .si-alias-actions {
      margin-top: 18px;
      padding-top: 14px;
      border-top: 1px solid #eef2f6;
      display: flex;
      justify-content: flex-end;
    }

    .si-alias-success {
      padding: 16px 18px;
      border-radius: 8px;
      background: var(--unb-green-soft, #e6f2ec);
      border: 1px solid #b7dec9;
      color: var(--unb-green-dark, #004d26);
      font-size: 14px;
      line-height: 1.5;
    }

    .si-alias-error {
      margin-top: 6px;
      color: var(--si-danger, #b91c1c);
      font-size: 12.5px;
      font-weight: 600;
    }

    .si-alias-empty {
      text-align: center;
      padding: 26px 18px;
      color: var(--si-text-muted, #435368);
      font-size: 14px;
    }

    @media (max-width: 600px) {
      .si-alias-row {
        grid-template-columns: 1fr;
        gap: 6px;
      }
    }
  </style>
</head>
<body>
  <div class="si-alias-body">
    <div class="si-alias-box">
      <div class="si-alias-box-head">
        <?php if ($salvo_msg !== ''): ?>
          Confirmação
        <?php elseif ($post_user !== ''): ?>
          Dados do Alias
        <?php else: ?>
          Gerenciamento de Alias
        <?php endif; ?>
      </div>

      <div class="si-alias-box-content">
        <?php if ($salvo_msg !== ''): ?>
          <div class="si-alias-success" role="status">
            <strong><?php echo h($salvo_msg); ?>.</strong><br>
            Alias do usuário <strong><?php echo h($nome . ' ' . $sobrenome); ?></strong> atualizado com sucesso.
          </div>
        <?php elseif ($post_user === ''): ?>
          <div class="si-alias-empty">
            Selecione um usuário na barra acima e clique em <strong>Confirmar</strong> para consultar ou definir o alias.
          </div>
        <?php else: ?>
          <form method="POST" name="utilisateur" action="cria_alias.php">
            <div class="si-alias-row">
              <span class="si-alias-label">Usuário:</span>
              <span class="si-alias-value"><?php echo h(trim($nome . ' ' . $sobrenome)); ?></span>
            </div>

            <div class="si-alias-row">
              <label for="alias-padrao">Alias padrão do usuário:</label>
              <div>
                <input type="text" id="alias-padrao" name="alias" maxlength="100" value="<?php echo h($alias); ?>" readonly>
              </div>
            </div>

            <div class="si-alias-row">
              <label for="alias-definido">Alias definido pelo usuário:</label>
              <div>
                <input type="text" id="alias-definido" name="alias2" maxlength="100" value="<?php echo h(retira_acentos($alias2)); ?>" placeholder="Ex.: nome.sobrenome">
                <?php if ($mensagem !== ''): ?>
                  <div class="si-alias-error" role="alert"><?php echo h($mensagem); ?></div>
                <?php endif; ?>
              </div>
            </div>

            <input type="hidden" name="user" value="<?php echo h($post_user); ?>">
            <div class="si-alias-actions">
              <input type="submit" name="confirma" value="Confirmar">
            </div>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>
