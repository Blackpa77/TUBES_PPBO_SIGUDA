<?php
namespace App\Controllers;

use App\Config\Database;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\TransaksiMasuk;
use App\Models\TransaksiKeluar;

class DashboardController
{
    private $db;
    private $produk;
    private $kategori;
    private $transMasuk;
    private $transKeluar;

    public function __construct()
    {
        session_start();
        $database = new Database();
        $this->db = $database->getConnection();

        $this->produk = new Produk($this->db);
        $this->kategori = new Kategori($this->db);
        $this->transMasuk = new TransaksiMasuk($this->db);
        $this->transKeluar = new TransaksiKeluar($this->db);
    }

    public function index()
    {
        require_once __DIR__ . '/../Views/dashboard.php';
    }
}
