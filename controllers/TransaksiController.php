<?php
require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../models/TransaksiMasuk.php';
require_once __DIR__.'/../models/TransaksiKeluar.php';
require_once __DIR__.'/../models/Produk.php';

class TransaksiController {

    private $db;
    private $produk;

    public function __construct() {
        session_start();
        $database = new Database();
        $this->db = $database->getConnection();

        $this->produk = new Produk($this->db);
    }

    public function index() {
        $tm = new TransaksiMasuk($this->db);
        $tk = new TransaksiKeluar($this->db);

        $data = array_merge(
            $tm->readAll()->fetchAll(PDO::FETCH_ASSOC),
            $tk->readAll()->fetchAll(PDO::FETCH_ASSOC)
        );

        usort($data, fn($a,$b)=>strtotime($b['tanggal']) - strtotime($a['tanggal']));
        include __DIR__.'/../views/transaksi/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $jenis = $_POST['jenis_transaksi'];
            $t = ($jenis==='masuk')
                ? new TransaksiMasuk($this->db)
                : new TransaksiKeluar($this->db);

            $t->id_produk = $_POST['id_produk'];
            $t->jumlah = $_POST['jumlah'];
            $t->tanggal = $_POST['tanggal'];
            $t->keterangan = $_POST['keterangan'];

            if ($jenis==='keluar' && !$t->validateStock()) {
                $_SESSION['error'] = "Stok tidak mencukupi!";
            } elseif ($t->save()) {
                $_SESSION['success'] = "Transaksi berhasil disimpan";
                header("Location: $base_url/Transaksi");
                exit;
            } else {
                $_SESSION['error'] = "Gagal menyimpan transaksi";
            }
        }

        $produkList = $this->produk->readAll()->fetchAll(PDO::FETCH_ASSOC);
        include __DIR__.'/../views/transaksi/create.php';
    }

    public function delete() {
        if(isset($_GET['id'], $_GET['jenis'])) {
            $jenis = $_GET['jenis'];
            $t = ($jenis === 'masuk')
                ? new TransaksiMasuk($this->db)
                : new TransaksiKeluar($this->db);

            $t->id_transaksi = $_GET['id'];

            if($t->delete()) {
                $_SESSION['success'] = "Transaksi berhasil dihapus";
            } else {
                $_SESSION['error'] = "Gagal menghapus";
            }
        }
        header("Location: $base_url/Transaksi");
    }
}
