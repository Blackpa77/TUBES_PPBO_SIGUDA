<?php

$host = $_SERVER['HTTP_HOST'];

if (strpos($host, 'localhost') !== false) {
    $base_url = 'http://' . $host;
} else {
    $base_url = 'https://' . $host;
}