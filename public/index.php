<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/path.php'; // base_url

// Jika sudah login, Atur return tampilan berdasarkan request
if (isset($_SESSION['user_id'])) {
    // aturan request /<controller>?<action>
    $path = ltrim($_SERVER['REQUEST_URI'], '/');
    // var_dump("PATH: " . $path);

    // ambil nama class controller (string sebelum ?)
    $controller = explode('?', $path)[0];
    // var_dump("CONTROLLER: " . $controller);

    // cek apakah file controller ada
    if (file_exists(__DIR__ . '/../controllers/' . $controller . 'Controller.php')) {
        require_once __DIR__ . '/../controllers/' . $controller . 'Controller.php';
        exit();
    }

    require_once __DIR__ . '/../controllers/DashboardController.php';
    exit();
}

// Proses Login saat tombol ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once __DIR__ . '/../config/database.php';
    require_once __DIR__ . '/../models/Admin.php';

    $database = new Database();
    $db = $database->getConnection();
    $admin = new Admin($db);

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($admin->login($username, $password)) {
        // PERBAIKAN: Menggunakan Getter karena properti di Model sekarang Private
        $_SESSION['user_id'] = $admin->getId();
        $_SESSION['username'] = $admin->getUsername();
        $_SESSION['nama_lengkap'] = $admin->getNamaLengkap();
        $_SESSION['role'] = $admin->getRole();

        // redirect kembali ke root → yang akan otomatis load DashboardController
        header("Location: $base_url");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
include_once __DIR__ . '/../views/login.php';