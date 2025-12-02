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

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $database = new Database();
        $this->db = $database->getConnection();

        $this->produk = new Produk($this->db);
        $this->kategori = new Kategori($this->db);
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
                header("Location: index.php?action=produk");
                exit();
            } else {
                $_SESSION['error'] = "Gagal menambah produk (Kode Produk mungkin duplikat)";
            }
        }

        $stmt_kategori = $this->kategori->readAll();
        require_once __DIR__ . '/../Views/produk/create.php';
    }

    /** -----------------------------------------------------
     * EDIT
     * ----------------------------------------------------- */
    public function edit()
    {
        if (isset($_GET['id'])) {

            $this->produk->setIdProduk($_GET['id']);
            $this->produk->readOne();

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
                    $_SESSION['success'] = "Produk berhasil diupdate";
                    header("Location: index.php?action=produk");
                    exit();
                } else {
                    $_SESSION['error'] = "Gagal mengupdate produk";
                }
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
        if (isset($_GET['id'])) {
            $this->produk->setIdProduk($_GET['id']);

            if ($this->produk->delete()) {
                $_SESSION['success'] = "Produk berhasil dihapus";
            } else {
                $_SESSION['error'] = "Gagal menghapus produk";
            }
        }

        header("Location: index.php?action=produk");
        exit();
    }

    /** -----------------------------------------------------
     * CETAK HTML
     * ----------------------------------------------------- */
    public function cetak()
    {
        $stmt = $this->produk->readAll();

        if (!isset($stmt)) {
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
