<?php
namespace App\Controllers;

use App\Config\Database;
use App\Models\TransaksiMasuk;
use App\Models\TransaksiKeluar;
use App\Models\Produk;

class TransaksiController
{
    private $db;
    private $transaksiMasuk;
    private $transaksiKeluar;
    private $produk;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $database = new Database();
        $this->db = $database->getConnection();

        $this->transaksiMasuk = new TransaksiMasuk($this->db);
        $this->transaksiKeluar = new TransaksiKeluar($this->db);
        $this->produk = new Produk($this->db);
    }

    // ==========================
    // 1. HALAMAN INDEX
    // ==========================
    public function index()
    {
        $dataMasuk = $this->transaksiMasuk->readAll()->fetchAll(\PDO::FETCH_ASSOC);
        $dataKeluar = $this->transaksiKeluar->readAll()->fetchAll(\PDO::FETCH_ASSOC);

        $transaksi = array_merge($dataMasuk, $dataKeluar);

        // urutkan DESC
        usort($transaksi, function ($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });

        $data = [
            'title' => 'Data Transaksi',
            'transaksi' => $transaksi
        ];

        require_once __DIR__ . '/../Views/transaksi/index.php';
    }

    // ==========================
    // 2. TAMBAH TRANSAKSI
    // ==========================
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $jenis = $_POST['jenis_transaksi'] ?? 'masuk';
            $transaksi = ($jenis === 'masuk') ? $this->transaksiMasuk : $this->transaksiKeluar;

            $transaksi->id_produk = $_POST['id_produk'];
            $transaksi->jumlah = $_POST['jumlah'];
            $transaksi->tanggal = $_POST['tanggal'];
            $transaksi->keterangan = $_POST['keterangan'];
            $transaksi->jenis_transaksi = $jenis;

            // validasi stok (khusus transaksi keluar)
            if ($jenis === 'keluar' && !$transaksi->validateStock()) {
                $_SESSION['error'] = "Stok tidak mencukupi!";
            } else {
                if ($transaksi->save()) {
                    $_SESSION['success'] = "Transaksi berhasil disimpan!";
                    header("Location: index.php?action=transaksi");
                    exit();
                } else {
                    $_SESSION['error'] = "Gagal menyimpan transaksi!";
                }
            }
        }

        $produkList = $this->produk->readAll()->fetchAll(\PDO::FETCH_ASSOC);
        $data = ['produk' => $produkList];

        require_once __DIR__ . '/../Views/transaksi/create.php';
    }

    // ==========================
    // 3. HAPUS TRANSAKSI
    // ==========================
    public function delete()
    {
        if (!isset($_GET['id'], $_GET['jenis'])) {
            header("Location: index.php?action=transaksi");
            exit();
        }

        $id = $_GET['id'];
        $jenis = $_GET['jenis'];

        $transaksi = ($jenis === 'masuk') ? $this->transaksiMasuk : $this->transaksiKeluar;
        $transaksi->id_transaksi = $id;

        if ($transaksi->delete()) {
            $_SESSION['success'] = "Transaksi berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Gagal menghapus transaksi!";
        }

        header("Location: index.php?action=transaksi");
        exit();
    }

    // ==========================
    // 4. CETAK LAPORAN
    // ==========================
    public function cetakLaporan()
    {
        $start_date = $_GET['start_date'] ?? date('Y-m-01');
        $end_date   = $_GET['end_date'] ?? date('Y-m-d');

        $dataMasuk  = $this->transaksiMasuk->readLaporan($start_date, $end_date)->fetchAll(\PDO::FETCH_ASSOC);
        $dataKeluar = $this->transaksiKeluar->readLaporan($start_date, $end_date)->fetchAll(\PDO::FETCH_ASSOC);

        $laporan = array_merge($dataMasuk, $dataKeluar);

        // urutkan ASC
        usort($laporan, function ($a, $b) {
            return strtotime($a['tanggal']) - strtotime($b['tanggal']);
        });

        $data = [
            'laporan' => $laporan,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];

        require_once __DIR__ . '/../Views/transaksi/cetak_laporan.php';
    }
}
