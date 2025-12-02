<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Produk.php';
require_once __DIR__ . '/../models/TransaksiMasuk.php';
require_once __DIR__ . '/../models/TransaksiKeluar.php';
require_once __DIR__ . '/../models/Kategori.php';

// 5. Integrasi Database - penerapan konsep OOP
$database = new Database();
$db = $database->getConnection();

// Instansiasi class
$produk = new Produk($db);
$kategori = new Kategori($db);
$transaksiMasuk = new TransaksiMasuk($db);
$transaksiKeluar = new TransaksiKeluar($db);

//2. struktur program & arditektur - Pemisahan logika dan tampilan
include __DIR__ . '/../views/dashboard.php';