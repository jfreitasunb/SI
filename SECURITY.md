# Postura de seguranca do SI

Resumo do estado apos a remediacao e como manter o codigo novo em dia sem
reauditar tudo.

## O que ja foi tratado

- **SQL injection**: o caminho vivo usa PDO com prepared statements
  (`db_query($sql, $params, $pdo)`), nunca concatenacao. O codigo legado `pg_*`
  foi migrado ou removido (subsistema morto `servidor_admin/Tex/` e
  `muda_senha/libs.php` apagados).
- **Autenticacao/autorizacao**: gate central em `global/header.php`
  (`secure()` + `verif_permission()` fail-closed) + vinculo de IP de sessao.
- **CSRF**: token por sessao injetado em formularios POST e validado no gate.
- **XSS**: saida escapada com `h()` (`htmlspecialchars`). Veja o scanner para
  `echo` de superglobais sem escape. Regras:
  - dado do banco ou da requisicao impresso em HTML/atributo: `h($valor)`;
  - dado dentro de JavaScript (`<script>`, `onclick=`...): `js_str($valor)`
    (gera `'...'` escapado; `h()` NAO protege contexto JS);
  - variavel que guarda HTML montado pelo codigo: escape cada valor na montagem
    (`$x = "<td>".h($v)."</td>"`) e imprima `$x` sem `h()`;
  - excecao: `users_tipo_contrato.descricao` e `users_bolsas.descricao` ja guardam
    entidades HTML (`Dedica&ccedil;&atilde;o`) e sao impressas sem `h()`.
- **Hashing de senha**: `hash_senha_app()` (bcrypt) para a tabela `admin`;
  `cripta_senha_unix()` (SHA-512 `$6$`) para a tabela `unix`. Nunca `md5()` nem
  `crypt()` default.
- **Credenciais fora do versionamento**:
  - PHP: `global/db_config.php` (ignorado) ou variaveis `SI_DB_*` / `PYKOTA_DB_*`
    (ver `global/db_config.sample.php` e a funcao `db_config()`).
  - Docker: `.env` (ignorado), modelo em `.env.example`.
  - **Pendente operacional**: a senha antiga (`estudos`) ainda existe no
    historico do git — rotacione a senha no PostgreSQL para fechar o risco.
- **Cookie de sessao**: `global/sessao_cookie.php` (httponly, secure sob HTTPS,
  SameSite=Lax), incluido antes de cada `session_start()`.
- **Upload**: whitelist de extensao + validacao de conteudo (`finfo`) +
  `.htaccess` desabilitando execucao nas pastas de upload.
- **Anexos de documentos**: `modules/servidor_admin/anexos/` nao e servida pela
  web; o download passa por `baixa_anexo.php` (exige login no modulo 79).
- **Forca bruta**: `global/limite_login.php` — falhas de login ficam na tabela
  `login_falha` (5 por login ou 30 por IP em 15 min bloqueiam). Vale para todos
  os formularios que conferem senha. **Requer a migracao
  `sql/2026-11-08_login_falha.sql`**; sem ela o limite fica inativo (so loga erro).
- **CSRF em AJAX**: `csrf_injeta()` configura o jQuery para enviar o token no
  cabecalho `X-CSRF-Token`; `csrf_valida()` aceita campo ou cabecalho.
- **Docker/nginx**: o nginx ignora `.htaccess`; `docker/nginx/conf.d/default.conf`
  reproduz as mesmas regras. Ao criar um `.htaccess` novo, replique-o la.

## Scanner de regressao (nao reauditar tudo)

Quando adicionar/alterar arquivos, rode o scanner em vez de reanalisar o
projeto inteiro. Ele usa o tokenizer do PHP (ignora comentarios) e so reporta
o que **nao** estiver no baseline de achados ja conhecidos/aceitos.

```sh
# repo inteiro
php tools/scan_seguranca.php
# ou so os arquivos novos/alterados
php tools/scan_seguranca.php caminho/arquivo1.php caminho/arquivo2.php
# sem PHP local:
docker run --rm -v "$PWD":/app -w /app php:7.4-cli php tools/scan_seguranca.php
```

Regras detectadas: `pg-legado`, `sql-interpolada`, `xss-echo`,
`senha-hardcoded`, `crypt-fraco`, `hash-fraco`, `sql-driver`.

Saida vazia / "nenhum achado novo" = ok. Se aparecer algo novo, corrija. Se for
falso-positivo legitimo, registre no baseline:

```sh
php tools/scan_seguranca.php --atualiza-baseline
```

O baseline (`tools/seguranca_baseline.txt`) hoje contem ~41 achados, **todos em
codigo morto ou aceito** (parse-errors pre-existentes, consultas em blocos
`/* */`, verificacoes com `crypt($input,$hash)` que sao uso correto). Convem
revisa-lo periodicamente e ir zerando conforme o codigo morto for removido.

### Sugestao: rodar automaticamente no commit

```sh
# .git/hooks/pre-commit (chmod +x)
#!/bin/sh
arqs=$(git diff --cached --name-only --diff-filter=ACM | grep '\.php$')
[ -z "$arqs" ] && exit 0
php tools/scan_seguranca.php $arqs
```
