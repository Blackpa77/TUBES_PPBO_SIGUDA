<?php

namespace App\Controllers;

use App\Config\Database;
use App\Models\Produk;
use App\Models\Kategori;
use Dompdf\Dompdf;
use Dompdf\Options;

class ProdukController
{
    private $db;
    private $produk;
    private $kategori;
    private $base_url;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $database = new Database();
        $this->db = $database->getConnection();

        $this->produk = new Produk($this->db);
        $this->kategori = new Kategori($this->db);

        $this->base_url = \App\Config\Config::getBaseUrl();
    }

    /** -----------------------------------------------------
     * INDEX
     * ----------------------------------------------------- */
    public function index()
    {
        $stmt = $this->produk->readAll();
        require_once __DIR__ . '/../Views/produk/index.php';
    }

    /** -----------------------------------------------------
     * CREATE
     * ----------------------------------------------------- */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->produk->setIdKategori($_POST['kategori_id']);
            $this->produk->setKodeProduk($_POST['kode_produk']);
            $this->produk->setNamaProduk($_POST['nama_produk']);
            $this->produk->setUkuran($_POST['ukuran']);
            $this->produk->setWarna($_POST['warna']);
            $this->produk->setStok($_POST['stok']);
            $this->produk->setHargaBeli($_POST['harga_beli']);
            $this->produk->setHargaJual($_POST['harga_jual']);
            $this->produk->setDeskripsi($_POST['deskripsi']);

            if ($this->produk->create()) {
                $_SESSION['success'] = "Produk berhasil ditambahkan";
                $base_url = \App\Config\Config::getBaseUrl();
                header("Location: {$base_url}/Produk");
                exit();
            } else {
                $_SESSION['error'] = "Gagal menambah produk (Kode Produk mungkin duplikat)";
            }
        }

        $base_url = \App\Config\Config::getBaseUrl();
        $stmt_kategori = $this->kategori->readAll();
        require_once __DIR__ . '/../Views/produk/create.php';
    }

    /** -----------------------------------------------------
     * EDIT
     * ----------------------------------------------------- */
    public function edit()
    {
        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "ID produk tidak ditemukan";
            header("Location: {$this->base_url}/Produk");
            exit();
        }

        $id = $_GET['id'];
        $this->produk->setIdProduk($id);
        $data = $this->produk->readOne(); // pastikan readOne() mengembalikan array data

        if (!$data) {
            $_SESSION['error'] = "Produk tidak ditemukan";
            header("Location: {$this->base_url}/Produk");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->produk->setIdKategori($_POST['kategori_id']);
            $this->produk->setKodeProduk($_POST['kode_produk']);
            $this->produk->setNamaProduk($_POST['nama_produk']);
            $this->produk->setUkuran($_POST['ukuran']);
            $this->produk->setWarna($_POST['warna']);
            $this->produk->setStok($_POST['stok']);
            $this->produk->setHargaBeli($_POST['harga_beli']);
            $this->produk->setHargaJual($_POST['harga_jual']);
            $this->produk->setDeskripsi($_POST['deskripsi']);

            if ($this->produk->update()) {
                $_SESSION['success'] = "Produk berhasil diperbarui";
                header("Location: {$this->base_url}/Produk");
                exit();
            } else {
                $_SESSION['error'] = "Gagal memperbarui produk";
            }
        }

        $stmt_kategori = $this->kategori->readAll();
        require_once __DIR__ . '/../Views/produk/edit.php';
    }

    /** -----------------------------------------------------
     * DELETE
     * ----------------------------------------------------- */
    public function delete()
    {
        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "ID produk tidak ditemukan";
            header("Location: {$this->base_url}/Produk");
            exit();
        }

        $id = $_GET['id'];
        $this->produk->setIdProduk($id);

        if ($this->produk->delete()) {
            $_SESSION['success'] = "Produk berhasil dihapus";
        } else {
            $_SESSION['error'] = "Gagal menghapus produk";
        }

        header("Location: {$this->base_url}/Produk");
        exit();
    }

    /** -----------------------------------------------------
     * CETAK HTML
     * ----------------------------------------------------- */
    public function cetak()
    {
        $stmt = $this->produk->readAll();

        if (!$stmt) {
            echo "Error: Data tidak ditemukan.";
            exit;
        }

        require_once __DIR__ . '/../vendor/autoload.php';

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        ob_start();
        require __DIR__ . '/../Views/produk/cetak.php';
        $html = ob_get_clean();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("laporan_produk.pdf", ["Attachment" => false]);
        exit();
    }

    /** -----------------------------------------------------
     * CETAK PDF
     * ----------------------------------------------------- */
    public function cetakPdf()
    {
        $stmt = $this->produk->readAll();

        require_once __DIR__ . '/../Views/produk/cetak_pdf.php';
    }
}
