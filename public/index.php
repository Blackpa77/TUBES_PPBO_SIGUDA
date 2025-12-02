<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Config;

// Set base_url untuk login page
$base_url = Config::getBaseUrl();

// Jika sudah login, atur return tampilan berdasarkan request
if (isset($_SESSION['user_id'])) {
    $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path = trim($request_uri, '/');
    
    // Remove index.php dari path jika ada
    $path = str_replace('index.php', '', $path);
    $path = trim($path, '/');
    
    // Default controller
    $controller = 'Dashboard';
    $action = 'index';

    // Parse path (contoh: /Kategori, /Produk, /Transaksi)
    if (!empty($path)) {
        $parts = explode('/', $path);
        $controller = ucfirst(strtolower($parts[0]));
        
        // Cek jika ada action di URL
        if (isset($parts[1])) {
            $action = $parts[1];
        }
    }

    // Cek query string untuk action
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
    }

    // Cek query string untuk controller
    if (isset($_GET['controller'])) {
        $controller = ucfirst(strtolower($_GET['controller']));
    }

    // Handle Logout
    if ($controller === 'Logout') {
        $logoutController = new App\Controllers\LogoutController();
        $logoutController->index();
        exit();
    }

    // Buat class name
    $controllerClass = 'App\\Controllers\\' . $controller . 'Controller';

    // Cek apakah class ada
    if (class_exists($controllerClass)) {
        try {
            $ctrl = new $controllerClass();
            if (method_exists($ctrl, $action)) {
                $ctrl->$action();
            } else {
                // Fallback ke index jika action tidak ada
                if (method_exists($ctrl, 'index')) {
                    $ctrl->index();
                } else {
                    throw new Exception("Method not found");
                }
            }
        } catch (Exception $e) {
            // Jika error, redirect ke dashboard
            $dashboard = new App\Controllers\DashboardController();
            $dashboard->index();
        }
        exit();
    }

    // Default ke Dashboard jika controller tidak ditemukan
    $dashboard = new App\Controllers\DashboardController();
    $dashboard->index();
    exit();
}

// Proses Login saat tombol ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = (new App\Config\Database())->getConnection();
    $admin = new App\Models\Admin($db);

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($admin->login($username, $password)) {
        $_SESSION['user_id'] = $admin->getId();
        $_SESSION['username'] = $admin->getUsername();
        $_SESSION['nama_lengkap'] = $admin->getNamaLengkap();
        $_SESSION['role'] = $admin->getRole();

        header("Location: /");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}

// Tampilkan halaman login
include_once __DIR__ . '/../App/Views/login.php';