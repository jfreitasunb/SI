<?php

/**
 * Conexao PDO unica (por requisicao) usada pelos DAOs do lista_oferta.
 * As credenciais vem de $DB (conf/default.php), que por sua vez usa db_config()
 * — a mesma configuracao do resto do sistema.
 */
class Connection {
	/** @var PDO|null */
	private static $instance = null;

	private function __construct() {
	}

	/**
	 * @return PDO
	 * @throws PDOException
	 */
	public static function getInstance() {
		if (self::$instance === null) {
			global $DB;

			$dsn = "pgsql:host=" . $DB["host"] . ";port=" . $DB["dbport"] . ";dbname=" . $DB["dbname"];
			try {
				// Usuario e senha como argumentos (nao no DSN), para nunca aparecerem em mensagens de erro.
				$pdo = new PDO($dsn, $DB["user"], $DB["password"]);
			} catch (PDOException $e) {
				error_log("lista_oferta Connection: " . $e->getMessage());
				throw new PDOException("Erro de acesso ao banco", (int)$e->getCode());
			}
			// Erros de SQL viram excecao (os DAOs nao precisam checar errorInfo()).
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// Valores como string, como o MDB2/pg_* que o codigo original usava.
			$pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, true);

			self::$instance = $pdo;
		}
		return self::$instance;
	}
}
