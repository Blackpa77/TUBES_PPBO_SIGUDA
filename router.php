<?php

// Ambil path file yang diminta
$requested = __DIR__ . '/public' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Jika file statis ada, biarkan PHP melayani
if (is_file($requested)) {
    return false;
}

// Jika tidak ada → pakai index.php
require __DIR__ . '/public/index.php';