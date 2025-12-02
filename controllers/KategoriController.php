<?php
namespace App\Controllers;

use App\Config\Database;
use App\Models\Kategori;

class KategoriController
{
    private $db;
    private $kategori;

    public function __construct()
    {
        session_start();
        $database = new Database();
        $this->db = $database->getConnection();
        $this->kategori = new Kategori($this->db);
    }

    public function index()
    {
        $stmt = $this->kategori->readAll();
        require_once __DIR__ . '/../Views/kategori/index.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->kategori->nama_kategori = $_POST['nama_kategori'];

            if ($this->kategori->create()) {
                $_SESSION['success'] = "Kategori berhasil ditambahkan";
                header("Location: index.php?controller=kategori&action=index");
                exit;
            }

            $_SESSION['error'] = "Gagal menambahkan kategori";
        }

        require_once __DIR__ . '/../Views/kategori/create.php';
    }

    public function edit()
    {
        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=kategori");
            exit;
        }

        $this->kategori->id_kategori = $_GET['id'];
        $this->kategori->readOne();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->kategori->nama_kategori = $_POST['nama_kategori'];

            if ($this->kategori->update()) {
                $_SESSION['success'] = "Kategori berhasil diupdate";
                header("Location: index.php?controller=kategori");
                exit;
            }

            $_SESSION['error'] = "Gagal mengupdate kategori";
        }

        require_once __DIR__ . '/../Views/kategori/edit.php';
    }

    public function delete()
    {
        if (isset($_GET['id'])) {
            $this->kategori->id_kategori = $_GET['id'];

            if ($this->kategori->countProduk() > 0) {
                $_SESSION['error'] = "Tidak dapat menghapus kategori yang memiliki produk";
            } else {
                $this->kategori->delete();
                $_SESSION['success'] = "Kategori berhasil dihapus";
            }
        }

        header("Location: index.php?controller=kategori");
        exit;
    }
}
