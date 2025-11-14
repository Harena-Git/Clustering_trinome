<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class MySQLSessionHandler implements SessionHandlerInterface {
	private $pdo;

	public function __construct() {
		$dsn = 'mysql:host=haproxy-db;port=3307;dbname=sessionsdb;';
		$user = 'php_session_user';
		$password = 'session';
		$this->pdo = new PDO($dsn, $user, $password, [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		]);
	}

	public function open($savePath, $sessionName): bool {
		return true;
	}

	public function close(): bool {
		$this->pdo = null;
		return true;
	}

	public function read($id): string|false {
		$stmt = $this->pdo->prepare("SELECT data FROM php_sessions WHERE id = :id");
		$stmt->execute(['id' => $id]);
		if ($row = $stmt->fetch()) {
			return $row['data'];
		}
		return '';
	}

	public function write($id, $data): bool {
		$stmt = $this->pdo->prepare("
			INSERT INTO php_sessions (id, data, last_access)
			VALUES (:id, :data, NOW())
			ON DUPLICATE KEY UPDATE data = VALUES(data), last_access = NOW()
		");
		return $stmt->execute(['id' => $id, 'data' => $data]);
	}

	public function destroy($id): bool {
		$stmt = $this->pdo->prepare("DELETE FROM php_sessions WHERE id = :id");
		return $stmt->execute(['id' => $id]);
	}

	public function gc($maxlifetime): int|false {
		$stmt = $this->pdo->prepare("DELETE FROM php_sessions WHERE last_access < (NOW() - INTERVAL :maxlifetime SECOND)");
		$stmt->execute(['maxlifetime' => $maxlifetime]);
		return $stmt->rowCount();
	}
}

// Utilisation du handler personnalisé
$handler = new MySQLSessionHandler();
session_set_save_handler($handler, true);
session_start();

// Affichage debug session
echo "Session ID: " . session_id() . "<br>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>