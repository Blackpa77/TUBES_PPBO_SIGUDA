<?php

namespace App\Controllers;

class AuthController
{
    private $base_url;

    public function __construct($base_url)
    {
        session_start();
        $this->base_url = $base_url;
    }

    public function logout()
    {
        // Hapus semua variabel session
        $_SESSION = [];

        // Hapus cookie session jika ada
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Hancurkan session
        session_destroy();

        // Redirect ke halaman login (fungsi tetap sama)
        header("Location: {$this->base_url}");
        exit();
    }
}
