<?php

namespace App\Controllers;

use App\Config\Database;
use App\Models\Kategori;

class KategoriController
{
    private $db;
    private $kategori;
    private $base_url;

    public function __construct($base_url)
    {
        session_start();

        $this->base_url = $base_url;

        // Koneksi database
        $this->db = (new Database())->getConnection();

        // Load model (fungsi tidak diubah)
        $this->kategori = new Kategori($this->db);
    }

    public function index()
    {
        $stmt = $this->kategori->readAll();

        include __DIR__ . '/../Views/kategori/index.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->kategori->nama_kategori = $_POST['nama_kategori'];

            if ($this->kategori->create()) {
                $_SESSION['success'] = "Kategori berhasil ditambahkan";
                header("Location: {$this->base_url}?controller=kategori&action=index");
                exit();
            } else {
                $_SESSION['error'] = "Gagal menambahkan kategori";
            }
        }

        include __DIR__ . '/../Views/kategori/create.php';
    }

    public function edit()
    {
        if (isset($_GET['id'])) {

            $this->kategori->id_kategori = $_GET['id'];
            $this->kategori->readOne();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $this->kategori->nama_kategori = $_POST['nama_kategori'];

                if ($this->kategori->update()) {
                    $_SESSION['success'] = "Kategori berhasil diupdate";
                    header("Location: {$this->base_url}/Kategori");
                    exit();
                } else {
                    $_SESSION['error'] = "Gagal mengupdate kategori";
                }
            }

            include __DIR__ . '/../Views/kategori/edit.php';
        }
    }

    public function delete()
    {
        if (isset($_GET['id'])) {

            $this->kategori->id_kategori = $_GET['id'];

            if ($this->kategori->countProduk() > 0) {
                $_SESSION['error'] = "Tidak dapat menghapus kategori yang memiliki produk";
            } else {
                if ($this->kategori->delete()) {
                    $_SESSION['success'] = "Kategori berhasil dihapus";
                } else {
                    $_SESSION['error'] = "Gagal menghapus kategori";
                }
            }
        }

        header("Location: {$this->base_url}/Kategori");
        exit();
    }
}
