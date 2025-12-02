<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../"); # __DIR__ = directory saat ini
$dotenv->safeLoad(); 
# akan mengisi $_ENV, $_SERVER, dan menjalankan setenv()

class Database {
    // 1. Properti Private
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    
    public $conn;

    public function __construct() {
        // var_dump('TEST .env is loaded: ', $_ENV['DB_DRIVER']); // untuk test: lihat respon di bagian network browser 
        $this->host = getenv('DB_HOST') ?: 'localhost';
        $this->port = getenv('DB_PORT') ?: '3306';
        $this->db_name = getenv('DB_NAME') ?: 'gudang_fashion';
        $this->username = getenv('DB_USER') ?: 'root';
        $this->password = getenv('DB_PASS') ?: '';
    }

    public function getConnection() {
        $this->conn = null;
        
        try {
            // PENTING: Menggunakan driver 'pgsql' untuk PostgreSQL (Supabase)
            $dsn = "{$_ENV['DB_DRIVER']}:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";sslmode={$_ENV['DB_SSLMODE']}";
            
            // 5. Inisialisasi PDO
            $this->conn = new PDO($dsn, $this->username, $this->password);
            
            // Set Error Mode ke Exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Set fetch mode default ke Associative Array
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch(PDOException $exception) {
            // Tampilkan pesan error jika koneksi gagal
            echo "Database Connection Error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>