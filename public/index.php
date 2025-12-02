<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Gunakan Composer autoload
require_once __DIR__ . '/../vendor/autoload.php';

// Jika sudah login, atur return tampilan berdasarkan request
if (isset($_SESSION['user_id'])) {
    // Parse URL untuk ambil controller & action
    $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $request_uri = str_replace('/index.php', '', $request_uri);
    
    // Ambil path dari root (contoh: /Kategori atau /kategori)
    $path = trim($request_uri, '/');
    
    // Default controller
    $controller = 'Dashboard';
    $action = 'index';

    // Jika ada path, gunakan sebagai controller
    if (!empty($path)) {
        $controller = ucfirst(strtolower($path));
    }

    // Cek apakah query string ada (controller & action)
    if (isset($_GET['controller'])) {
        $controller = ucfirst(strtolower($_GET['controller']));
        $action = $_GET['action'] ?? 'index';
    }

    // Buat class name
    $controllerClass = 'App\\Controllers\\' . $controller . 'Controller';

    // Cek apakah class ada
    if (class_exists($controllerClass)) {
        $ctrl = new $controllerClass();
        if (method_exists($ctrl, $action)) {
            $ctrl->$action();
        } else {
            // Fallback ke index jika action tidak ada
            if (method_exists($ctrl, 'index')) {
                $ctrl->index();
            }
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

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($admin->login($username, $password)) {
        $_SESSION['user_id'] = $admin->getId();
        $_SESSION['username'] = $admin->getUsername();
        $_SESSION['nama_lengkap'] = $admin->getNamaLengkap();
        $_SESSION['role'] = $admin->getRole();

        // redirect ke root
        header("Location: /");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}

// Tampilkan halaman login
include_once __DIR__ . '/../App/Views/login.php';