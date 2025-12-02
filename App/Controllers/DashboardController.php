<?php

namespace App\Controllers;

use App\Config\Database;
use App\Config\Config;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\TransaksiMasuk;
use App\Models\TransaksiKeluar;

class DashboardController
{
    private $db;
    private $produk;
    private $kategori;
    private $masuk;
    private $keluar;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: /");
            exit();
        }

        $this->db = (new Database())->getConnection();
        $this->produk = new Produk($this->db);
        $this->kategori = new Kategori($this->db);
        $this->masuk = new TransaksiMasuk($this->db);
        $this->keluar = new TransaksiKeluar($this->db);
    }

    public function index()
    {
        // Set base_url untuk view
        $base_url = Config::getBaseUrl();
        
        $produk = $this->produk;
        $kategori = $this->kategori;
        $transaksiMasuk = $this->masuk;
        $transaksiKeluar = $this->keluar;

        require_once __DIR__ . '/../Views/dashboard.php';
    }
}