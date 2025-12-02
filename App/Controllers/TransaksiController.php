<?php

namespace App\Controllers;

use App\Config\Database;
use App\Config\Config;
use App\Models\TransaksiMasuk;
use App\Models\TransaksiKeluar;
use App\Models\Produk;

class TransaksiController
{
    private $db;
    private $produk;
    private $base_url;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: /");
            exit();
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->produk = new Produk($this->db);
        $this->base_url = Config::getBaseUrl();
    }

    public function index()
    {
        $base_url = $this->base_url;
        
        $transaksiMasuk = new TransaksiMasuk($this->db);
        $transaksiKeluar = new TransaksiKeluar($this->db);

        $stmtMasuk = $transaksiMasuk->readAll()->fetchAll(\PDO::FETCH_ASSOC);
        $stmtKeluar = $transaksiKeluar->readAll()->fetchAll(\PDO::FETCH_ASSOC);

        $transaksiList = array_merge($stmtMasuk, $stmtKeluar);

        usort($transaksiList, function($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });

        require_once __DIR__ . '/../Views/transaksi/index.php';
    }

    public function create()
    {
        $base_url = $this->base_url;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jenis = $_POST['jenis_transaksi'] ?? 'masuk';
            $transaksi = ($jenis === 'masuk') 
                         ? new TransaksiMasuk($this->db) 
                         : new TransaksiKeluar($this->db);

            $transaksi->id_produk = $_POST['id_produk'] ?? 0;
            $transaksi->jumlah = $_POST['jumlah'] ?? 0;
            $transaksi->tanggal = $_POST['tanggal'] ?? date('Y-m-d H:i:s');
            $transaksi->keterangan = $_POST['keterangan'] ?? '';
            $transaksi->jenis_transaksi = $jenis;

            if ($jenis === 'keluar' && !$transaksi->validateStock()) {
                $_SESSION['error'] = "Stok tidak mencukupi untuk transaksi keluar!";
            } else {
                if ($transaksi->save()) {
                    $_SESSION['success'] = "Transaksi berhasil disimpan";
                    header("Location: {$this->base_url}/Transaksi");
                    exit();
                } else {
                    $_SESSION['error'] = "Gagal menyimpan transaksi";
                }
            }
        }

        $produkList = $this->produk->readAll()->fetchAll(\PDO::FETCH_ASSOC);
        require_once __DIR__ . '/../Views/transaksi/create.php';
    }

    public function delete()
    {
        if (isset($_GET['id'], $_GET['jenis'])) {
            $jenis = $_GET['jenis'];
            $transaksi = ($jenis === 'masuk') 
                         ? new TransaksiMasuk($this->db) 
                         : new TransaksiKeluar($this->db);

            $transaksi->id_transaksi = $_GET['id'];

            if ($transaksi->delete()) {
                $_SESSION['success'] = "Transaksi berhasil dihapus";
            } else {
                $_SESSION['error'] = "Gagal menghapus transaksi";
            }
        }

        header("Location: {$this->base_url}/Transaksi");
        exit();
    }

    public function cetakLaporan()
    {
        $base_url = $this->base_url;
        
        $start_date = $_GET['start_date'] ?? date('Y-m-01');
        $end_date = $_GET['end_date'] ?? date('Y-m-d');

        $transaksiMasuk = new TransaksiMasuk($this->db);
        $transaksiKeluar = new TransaksiKeluar($this->db);

        $dataMasuk = $transaksiMasuk->readLaporan($start_date, $end_date)->fetchAll(\PDO::FETCH_ASSOC);
        $dataKeluar = $transaksiKeluar->readLaporan($start_date, $end_date)->fetchAll(\PDO::FETCH_ASSOC);

        $data = array_merge($dataMasuk, $dataKeluar);

        usort($data, function($a, $b) {
            return strtotime($a['tanggal']) - strtotime($b['tanggal']);
        });

        require_once __DIR__ . '/../Views/transaksi/cetak_laporan.php';
    }
}