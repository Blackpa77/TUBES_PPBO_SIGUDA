<?php
namespace App\Controllers;

use App\Config\Database;
use App\Models\Kategori;

$database = new Database();
$db = $database->getConnection();
$kategori = new Kategori($db);

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch($action) {
    case 'index':
        $stmt = $kategori->readAll();
        include __DIR__ . '/../views/kategori/index.php';
        break;
        
    case 'create':
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $kategori->nama_kategori = $_POST['nama_kategori'];
            
            if($kategori->create()) {
                $_SESSION['success'] = "Kategori berhasil ditambahkan";
                header("Location: $base_url?controller=kategori&action=index");
                exit();
            } else {
                $_SESSION['error'] = "Gagal menambahkan kategori";
            }
        }
        include __DIR__ . '/../views/kategori/create.php';
        break;
        
    case 'edit':
        if(isset($_GET['id'])) {
            $kategori->id_kategori = $_GET['id'];
            $kategori->readOne();
            
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $kategori->nama_kategori = $_POST['nama_kategori'];
                
                if($kategori->update()) {
                    $_SESSION['success'] = "Kategori berhasil diupdate";
                    header("Location: $base_url/Kategori");
                    exit();
                } else {
                    $_SESSION['error'] = "Gagal mengupdate kategori";
                }
            }
        }
        include __DIR__ . '/../views/kategori/edit.php';
        break;
        
    case 'delete':
        if(isset($_GET['id'])) {
            $kategori->id_kategori = $_GET['id'];
            
            if($kategori->countProduk() > 0) {
                $_SESSION['error'] = "Tidak dapat menghapus kategori yang memiliki produk";
            } else {
                if($kategori->delete()) {
                    $_SESSION['success'] = "Kategori berhasil dihapus";
                } else {
                    $_SESSION['error'] = "Gagal menghapus kategori";
                }
            }
        }
        header("Location: $base_url/Kategori");
        exit();

    default:
        $stmt = $kategori->readAll();
        include __DIR__ . '/../views/kategori/index.php';
        break;
}