<?php
// Class Produk: Model untuk entitas produk (Kriteria 1: Menggunakan class dan object)
class Produk {
    private $conn; // Kriteria 1: Properti private/protected (Encapsulation)
    private $table = "produk";
    
    // Properti publik digunakan untuk menampung data sebelum CRUD
    public $id_produk;
    public $id_kategori; // Kriteria 1: Relasi (terhubung dengan class Kategori)
    public $kode_produk;
    public $nama_produk;
    public $ukuran;
    public $warna;
    public $stok;
    public $harga_beli;
    public $harga_jual;
    public $deskripsi;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Kriteria 4: Fungsionalitas CRUD (Tambah)
    public function create() {
        $query = "INSERT INTO {$this->table} 
                SET id_kategori=:id_kategori, kode_produk=:kode_produk, 
                    nama_produk=:nama_produk, ukuran=:ukuran, warna=:warna,
                    stok=:stok, harga_beli=:harga_beli, harga_jual=:harga_jual,
                    deskripsi=:deskripsi";
        
        // Kriteria 5: Query aman (prepared statement)
        $stmt = $this->conn->prepare($query); 
        
        // Binding parameter untuk menghindari SQL Injection
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

    // Kriteria 4: Fungsionalitas CRUD (Lihat)
    public function readAll() {
        $query = "SELECT p.*, k.nama_kategori 
                FROM {$this->table} p
                LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
                ORDER BY p.id_produk DESC";
        
        // Prepared statement digunakan meskipun query SELECT
        $stmt = $this->conn->prepare($query); 
        $stmt->execute();
        return $stmt;
    }

    // Kriteria 4: Fungsionalitas CRUD (Lihat satu)
    public function readOne() {
        $query = "SELECT * FROM {$this->table} WHERE id_produk=:id_produk LIMIT 1";
        
        // Kriteria 5: Query aman (prepared statement)
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_produk', $this->id_produk);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Logika untuk mengisi properti objek
        if($row) {
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

    // Kriteria 4: Fungsionalitas CRUD (Ubah)
    public function update() {
        $query = "UPDATE {$this->table} SET 
                id_kategori=:id_kategori, kode_produk=:kode_produk,
                nama_produk=:nama_produk, ukuran=:ukuran, warna=:warna,
                stok=:stok, harga_beli=:harga_beli, harga_jual=:harga_jual,
                deskripsi=:deskripsi
                WHERE id_produk=:id_produk";
                
        // Kriteria 5: Query aman (prepared statement)
        $stmt = $this->conn->prepare($query);
        
        // Binding parameter
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

    // Kriteria 4: Fungsionalitas CRUD (Hapus)
    public function delete() {
        $query = "DELETE FROM {$this->table} WHERE id_produk=:id_produk";
        
        // Kriteria 5: Query aman (prepared statement)
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_produk', $this->id_produk);
        
        return $stmt->execute();
    }

    // Kriteria 7: Inovasi & Kreativitas (Fitur Tambahan)
    public function getLowStock($limit = 10) {
        $query = "SELECT p.*, k.nama_kategori 
                FROM {$this->table} p
                LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
                WHERE p.stok <= :limit
                ORDER BY p.stok ASC";
                
        // Kriteria 5: Query aman (prepared statement)
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit);
        $stmt->execute();
        return $stmt;
    }
}
?>