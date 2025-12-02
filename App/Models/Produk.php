<?php
namespace App\Models;

class Produk {
    private $conn;
    private $table = "produk";

    private $id_produk;
    private $id_kategori;
    private $kode_produk;
    private $nama_produk;
    private $ukuran;
    private $warna;
    private $stok;
    private $harga_beli;
    private $harga_jual;
    private $deskripsi;

    public function __construct($db) {
        $this->conn = $db;
    }

    // -----------------------------
    // SETTER & GETTER (Encapsulation)
    // -----------------------------
    public function setIdProduk($id) { $this->id_produk = $id; }
    public function getIdProduk() { return $this->id_produk; }

    public function setIdKategori($id) { $this->id_kategori = $id; }
    public function getIdKategori() { return $this->id_kategori; }

    public function setKodeProduk($kode) { $this->kode_produk = $kode; }
    public function getKodeProduk() { return $this->kode_produk; }

    public function setNamaProduk($nama) { $this->nama_produk = $nama; }
    public function getNamaProduk() { return $this->nama_produk; }

    public function setUkuran($ukuran) { $this->ukuran = $ukuran; }
    public function getUkuran() { return $this->ukuran; }

    public function setWarna($warna) { $this->warna = $warna; }
    public function getWarna() { return $this->warna; }

    public function setStok($stok) { $this->stok = $stok; }
    public function getStok() { return $this->stok; }

    public function setHargaBeli($harga) { $this->harga_beli = $harga; }
    public function getHargaBeli() { return $this->harga_beli; }

    public function setHargaJual($harga) { $this->harga_jual = $harga; }
    public function getHargaJual() { return $this->harga_jual; }

    public function setDeskripsi($deskripsi) { $this->deskripsi = $deskripsi; }
    public function getDeskripsi() { return $this->deskripsi; }

    // -----------------------------
    // CRUD
    // -----------------------------
    public function create() {
        $query = "INSERT INTO {$this->table} 
                SET id_kategori=:id_kategori, kode_produk=:kode_produk, 
                    nama_produk=:nama_produk, ukuran=:ukuran, warna=:warna,
                    stok=:stok, harga_beli=:harga_beli, harga_jual=:harga_jual,
                    deskripsi=:deskripsi";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_kategori', $this->id_kategori);
        $stmt->bindParam(':kode_produk', $this->kode_produk);
        $stmt->bindParam(':nama_produk', $this->nama_produk);
        $stmt->bindParam(':ukuran', $this->ukuran);
        $stmt->bindParam(':warna', $this->warna);
        $stmt->bindParam(':stok', $this->stok);
        $stmt->bindParam(':harga_beli', $this->harga_beli);
        $stmt->bindParam(':harga_jual', $this->harga_jual);
        $stmt->bindParam(':deskripsi', $this->deskripsi);

        return $stmt->execute();
    }

    public function readAll() {
        $query = "SELECT p.*, k.nama_kategori 
                FROM {$this->table} p
                LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
                ORDER BY p.id_produk DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM {$this->table} WHERE id_produk=:id_produk LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_produk', $this->id_produk);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($row) {
            $this->id_produk = $row['id_produk'];
            $this->id_kategori = $row['id_kategori'];
            $this->kode_produk = $row['kode_produk'];
            $this->nama_produk = $row['nama_produk'];
            $this->ukuran = $row['ukuran'];
            $this->warna = $row['warna'];
            $this->stok = $row['stok'];
            $this->harga_beli = $row['harga_beli'];
            $this->harga_jual = $row['harga_jual'];
            $this->deskripsi = $row['deskripsi'];
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE {$this->table} SET 
                id_kategori=:id_kategori, kode_produk=:kode_produk,
                nama_produk=:nama_produk, ukuran=:ukuran, warna=:warna,
                stok=:stok, harga_beli=:harga_beli, harga_jual=:harga_jual,
                deskripsi=:deskripsi
                WHERE id_produk=:id_produk";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_kategori', $this->id_kategori);
        $stmt->bindParam(':kode_produk', $this->kode_produk);
        $stmt->bindParam(':nama_produk', $this->nama_produk);
        $stmt->bindParam(':ukuran', $this->ukuran);
        $stmt->bindParam(':warna', $this->warna);
        $stmt->bindParam(':stok', $this->stok);
        $stmt->bindParam(':harga_beli', $this->harga_beli);
        $stmt->bindParam(':harga_jual', $this->harga_jual);
        $stmt->bindParam(':deskripsi', $this->deskripsi);
        $stmt->bindParam(':id_produk', $this->id_produk);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM {$this->table} WHERE id_produk=:id_produk";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_produk', $this->id_produk);
        return $stmt->execute();
    }

    // -----------------------------
    // Fitur tambahan
    // -----------------------------
    public function getLowStock($limit = 10) {
        $query = "SELECT p.*, k.nama_kategori 
                FROM {$this->table} p
                LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
                WHERE p.stok <= :limit
                ORDER BY p.stok ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit);
        $stmt->execute();
        return $stmt;
    }
}
?>
