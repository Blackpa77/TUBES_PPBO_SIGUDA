<?php
namespace App\Models;

use PDO;

class TransaksiKeluar extends Transaksi {

    // Validasi stok sebelum melakukan transaksi keluar
    public function validateStock(): bool {
        $produk = new Produk($this->conn);
        $produk->setIdProduk($this->id_produk);
        $produk->readOne();

        return ($produk->getStok() >= $this->jumlah);
    }

    // Simpan transaksi keluar dan update stok
    public function save(): bool {
        $this->jenis_transaksi = 'keluar';
        $this->tanggal = date('Y-m-d H:i:s');

        if (!$this->validateStock()) {
            return false;
        }

        // Masukkan transaksi ke database
        $result = $this->insertToDatabase();

        if ($result) {
            // Kurangi stok produk
            $produk = new Produk($this->conn);
            $produk->setIdProduk($this->id_produk);
            $produk->readOne();
            $produk->setStok($produk->getStok() - $this->jumlah);
            $produk->update();
        }

        return $result;
    }

    // Ambil transaksi keluar hari ini (untuk dashboard)
    public function getToday(): array {
        $query = "SELECT t.*, p.nama_produk, p.ukuran
                  FROM transaksi t
                  JOIN produk p ON t.id_produk = p.id_produk
                  WHERE t.jenis_transaksi = 'keluar' 
                  AND DATE(t.tanggal) = CURDATE()
                  ORDER BY t.tanggal DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
