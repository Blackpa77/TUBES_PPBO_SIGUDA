<?php
namespace App\Models;

use PDO;

class Kategori {
    private $conn;
    private $table = "kategori";

    public $id_kategori;
    public $nama_kategori;

    public function __construct($db) {
        $this->conn = $db;
    }
    public function setIdKategori($id) { 
    $this->id_kategori = $id; 
}

public function setNamaKategori($nama) { 
    $this->nama_kategori = $nama; 
}
    // CREATE
    public function create() {
        $query = "INSERT INTO {$this->table} SET nama_kategori=:nama_kategori";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nama_kategori', $this->nama_kategori);
        return $stmt->execute();
    }

    // READ ALL
    public function readAll() {
        $query = "SELECT id_kategori, nama_kategori 
                  FROM {$this->table} 
                  ORDER BY nama_kategori ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // READ ONE
    public function readOne() {
        $query = "SELECT id_kategori, nama_kategori 
                  FROM {$this->table} 
                  WHERE id_kategori = :id_kategori 
                  LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_kategori', $this->id_kategori);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->id_kategori = $row['id_kategori'];
            $this->nama_kategori = $row['nama_kategori'];
            return true;
        }
        return false;
    }

    // UPDATE
    public function update() {
        $query = "UPDATE {$this->table} 
                  SET nama_kategori=:nama_kategori 
                  WHERE id_kategori=:id_kategori";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nama_kategori', $this->nama_kategori);
        $stmt->bindParam(':id_kategori', $this->id_kategori);
        return $stmt->execute();
    }

    // DELETE
    public function delete() {
        $query = "DELETE FROM {$this->table} WHERE id_kategori = :id_kategori";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_kategori', $this->id_kategori);
        return $stmt->execute();
    }

    // COUNT PRODUK
    public function countProduk() {
        $query = "SELECT COUNT(*) as total FROM produk WHERE id_kategori = :id_kategori";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_kategori', $this->id_kategori);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    // ----------------------------
    // METHOD TAMBAHAN UNTUK DASHBOARD
    // ----------------------------
    public function getAll() {
        return $this->readAll()->fetchAll(PDO::FETCH_ASSOC);
    }
}
