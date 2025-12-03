<?php
namespace App\Controllers;

use App\Config\Database;
use App\Models\Produk;
use App\Models\TransaksiMasuk;
use App\Models\TransaksiKeluar;
use App\Models\Kategori;

$database = new Database();
$db = $database->getConnection();

$produk = new Produk($db);
$kategori = new Kategori($db);
$transaksiMasuk = new TransaksiMasuk($db);
$transaksiKeluar = new TransaksiKeluar($db);

include __DIR__ . '/../views/dashboard.php';