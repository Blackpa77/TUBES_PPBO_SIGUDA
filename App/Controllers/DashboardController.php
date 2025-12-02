<?php

namespace App\Controllers;

use App\Config\Database;
use App\Models\Kategori;
use App\Models\TransaksiMasuk;
use App\Models\TransaksiKeluar;

class DashboardController
{
    private $db;
    private $kategori;
    private $masuk;
    private $keluar;

    public function __construct()
    {
        // 1. Start session sekali
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // 2. Proteksi halaman — sama seperti kode awal
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../index.php");
            exit();
        }

        // 3. Koneksi Database (fungsi asli tidak diubah)
        $this->db = (new Database())->getConnection();

        // 4. Load model (fungsi asli tetap sama)
        $this->kategori = new Kategori($this->db);
        $this->masuk    = new TransaksiMasuk($this->db);
        $this->keluar   = new TransaksiKeluar($this->db);
    }

    public function index()
    {
        // 5. Ambil data sesuai dashboard.php (logika tetap sama)
        $kategori = $this->kategori->getAll();
        $barangMasuk = $this->masuk->getToday();
        $barangKeluar = $this->keluar->getToday();

        // 6. Kirim ke view seperti kode asli
        require_once __DIR__ . '/../Views/dashboard.php';
    }
}
