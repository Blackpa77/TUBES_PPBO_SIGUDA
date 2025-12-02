<?php
namespace App\Models;

use PDO;

class TransaksiMasuk extends Transaksi {

    public function validateStock() {
        return true;
    }

    public function save() {
        $this->jenis_transaksi = 'masuk';
        $this->tanggal = date('Y-m-d H:i:s');
        return $this->insertToDatabase();
    }

    // Method tambahan untuk DashboardController
    public function getToday() {
        $query = "SELECT t.*, p.nama_produk, p.ukuran
                  FROM transaksi t
                  JOIN produk p ON t.id_produk = p.id_produk
                  WHERE t.jenis_transaksi = 'masuk' 
                  AND DATE(t.tanggal) = CURDATE()
                  ORDER BY t.tanggal DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
