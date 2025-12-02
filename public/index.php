<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Gunakan Composer autoload
require_once __DIR__ . '/../vendor/autoload.php';

// Jika sudah login, atur return tampilan berdasarkan request
if (isset($_SESSION['user_id'])) {
    // aturan request /<controller>?<action>
    $path = ltrim($_SERVER['REQUEST_URI'], '/');

    // ambil nama class controller (string sebelum ?)
    $controller = explode('?', $path)[0];

    // cek apakah class controller ada di namespace App\Controllers
    $controllerClass = 'App\\Controllers\\' . ucfirst($controller) . 'Controller';

    if (class_exists($controllerClass)) {
        $ctrl = new $controllerClass();
        if (method_exists($ctrl, 'index')) {
            $ctrl->index();
        }
        exit();
    }

    // Default ke Dashboard
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
include_once __DIR__ . '/../views/login.php';
