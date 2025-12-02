<?php

namespace App\Config;

use PDO;
use PDOException;
use Dotenv\Dotenv;

class Database
{
    // Properti private (rapi & sesuai standar PHP 8+)
    private string $host;
    private string $db_name;
    private string $username;
    private string $password;
    private string $port;
    private ?PDO $conn = null;

    public function __construct()
    {
        // Load .env sekali saja
        $dotenv = Dotenv::createImmutable(__DIR__ . "/../");
        $dotenv->safeLoad();

        // Baca env
        $this->host = getenv('DB_HOST') ?: 'localhost';
        $this->port = getenv('DB_PORT') ?: '3306';
        $this->db_name = getenv('DB_NAME') ?: 'gudang_fashion';
        $this->username = getenv('DB_USER') ?: 'root';
        $this->password = getenv('DB_PASS') ?: '';
    }

    public function getConnection(): ?PDO
    {
        $this->conn = null;

        try {
            // DRIVER & SSLMODE dari .env
            $driver  = $_ENV['DB_DRIVER'] ?? 'mysql';
            $sslmode = $_ENV['DB_SSLMODE'] ?? '';

            // DSN (PostgreSQL)
            $dsn = "$driver:host={$this->host};port={$this->port};dbname={$this->db_name};sslmode=$sslmode";

            // Options diselaraskan dengan contoh kedua (rapi & modern)
            $options = [
                PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
            ];

            // Init PDO
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);

        } catch (PDOException $exception) {
            // Boleh diperlihatkan agar error terlihat di Vercel
            die("❌ Database Connection Error: " . $exception->getMessage());
        }

        return $this->conn;
    }
}
