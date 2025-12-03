<?php

namespace App\Config;

class Config
{
    public static function getBaseUrl(): string
    {
        $host = $_SERVER['HTTP_HOST'];

        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
                    || $_SERVER['SERVER_PORT'] == 443 
                    ? "https://" 
                    : "http://";

        // Ambil path folder aplikasi secara otomatis
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        $basePath = rtrim($scriptName, '/');

        return $protocol . $host . $basePath;
    }
}
