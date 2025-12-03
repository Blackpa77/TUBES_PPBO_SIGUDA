<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../vendor/autoload.php';
use App\Config\Config;

// Set base_url
$base_url = Config::getBaseUrl();

if (isset($_SESSION['user_id'])) {

    // Parsing path aman PHP 8+
    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    $parsed_path = parse_url($request_uri, PHP_URL_PATH) ?? '';
    $path = trim(str_replace('index.php', '', $parsed_path), '/');

    // Default controller
    $controller = 'Dashboard';
    $action = 'index';

    // Parsing path /Controller/Action
    if (!empty($path)) {
        $parts = explode('/', $path);
        if (isset($parts[0]) && !empty($parts[0])) $controller = ucfirst(strtolower($parts[0]));
        if (isset($parts[1]) && !empty($parts[1])) $action = $parts[1];
    }

    // Override dengan query string
    if (isset($_GET['controller']) && !empty($_GET['controller'])) $controller = ucfirst(strtolower($_GET['controller']));
    if (isset($_GET['action']) && !empty($_GET['action'])) $action = $_GET['action'];

    // Handle logout
    if ($controller === 'Logout') {
        $logoutController = new App\Controllers\LogoutController();
        $logoutController->index();
        exit();
    }

    $controllerClass = 'App\\Controllers\\' . $controller . 'Controller';
    if (class_exists($controllerClass)) {
        $ctrl = new $controllerClass();
        if (method_exists($ctrl, $action)) {
            $ctrl->$action();
            exit();
        } elseif (method_exists($ctrl, 'index')) {
            $ctrl->index();
            exit();
        }
    }

    $dashboard = new App\Controllers\DashboardController();
    $dashboard->index();
    exit();
}

// Login POST
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

        header("Location: {$base_url}");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}

include_once __DIR__ . '/../App/Views/login.php';
