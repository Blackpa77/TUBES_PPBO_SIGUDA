<?php
namespace App\Config;

use PDO;
use PDOException;

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    
    public $conn;

    public function __construct() {
        // Gunakan $_ENV yang sudah di-load di index.php
        $this->host = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: 'localhost';
        $this->port = $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?: '3306';
        $this->db_name = $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?: 'gudang_fashion';
        $this->username = $_ENV['DB_USER'] ?? getenv('DB_USER') ?: 'root';
        $this->password = $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?: '';
    }

    public function getConnection() {
        $this->conn = null;
        
        try {
            $driver = $_ENV['DB_DRIVER'] ?? getenv('DB_DRIVER') ?: 'mysql';
            $sslmode = $_ENV['DB_SSLMODE'] ?? getenv('DB_SSLMODE') ?: 'prefer';
            
            $dsn = "{$driver}:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name;
            
            if ($driver === 'pgsql') {
                $dsn .= ";sslmode={$sslmode}";
            }
            
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch(PDOException $exception) {
            echo "Database Connection Error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}