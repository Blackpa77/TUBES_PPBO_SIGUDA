<?php
namespace App\Controllers;

use App\Config\Database;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\TransaksiMasuk;
use App\Models\TransaksiKeluar;

class DashboardController
{
    protected $db;
    protected $produk;
    protected $kategori;
    protected $transMasuk;
    protected $transKeluar;
    protected $base_url;

    public function __construct()
    {
        // Mulai session aman
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Load base URL dari config
        $this->base_url = $_ENV['BASE_URL'] ?? 'http://localhost';

        // Koneksi database
        $database = new Database();
        $this->db = $database->getConnection();

        // Load model
        $this->produk = new Produk($this->db);
        $this->kategori = new Kategori($this->db);
        $this->transMasuk = new TransaksiMasuk($this->db);
        $this->transKeluar = new TransaksiKeluar($this->db);
    }

    public function index()
    {
        // Ambil data summary untuk dashboard
        $totalProduk = $this->produk->countAll();
        $totalKategori = $this->kategori->countAll();
        $masukHariIni = $this->transMasuk->countToday();
        $keluarHariIni = $this->transKeluar->countToday();

        // Kirim ke view
        include __DIR__ . '/../Views/dashboard.php';
    }
}
