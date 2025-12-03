<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// STEP 1: Load composer autoload PERTAMA - JANGAN UBAH POSISI INI!
$autoloadPath = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    die('Error: Composer autoload not found. Run: composer install');
}
require_once $autoloadPath;

// STEP 2: Load .env file menggunakan Dotenv
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->safeLoad();
} catch (Exception $e) {
    // .env tidak ada atau error - gunakan default values
}

// STEP 3: Load path config (untuk $base_url)
require_once __DIR__ . '/../config/path.php';

// STEP 4: Import classes yang dibutuhkan
use App\Config\Database;
use App\Models\Admin;

// Jika sudah login, Atur return tampilan berdasarkan request
if (isset($_SESSION['user_id'])) {
    $path = ltrim($_SERVER['REQUEST_URI'], '/');
    $controller = explode('?', $path)[0];

    if (file_exists(__DIR__ . '/../controllers/' . $controller . 'Controller.php')) {
        require_once __DIR__ . '/../controllers/' . $controller . 'Controller.php';
        exit();
    }

    require_once __DIR__ . '/../controllers/DashboardController.php';
    exit();
}

// Proses Login saat tombol ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $database = new Database();
        $db = $database->getConnection();
        $admin = new Admin($db);

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($admin->login($username, $password)) {
            $_SESSION['user_id'] = $admin->getId();
            $_SESSION['username'] = $admin->getUsername();
            $_SESSION['nama_lengkap'] = $admin->getNamaLengkap();
            $_SESSION['role'] = $admin->getRole();

            header("Location: $base_url");
            exit();
        } else {
            $error = "Username atau password salah!";
        }
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}

include_once __DIR__ . '/../views/login.php';