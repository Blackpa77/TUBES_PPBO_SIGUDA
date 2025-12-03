<?php
namespace App\Models;

class TransaksiKeluar extends Transaksi {

    public function validateStock() {
        $produk = new Produk($this->conn);
        $produk->setIdProduk($this->id_produk);
        $produk->readOne();
        return ($produk->getStok() >= $this->jumlah);
    }

    public function save() {
        $this->jenis_transaksi = 'keluar';
        $this->tanggal = date('Y-m-d H:i:s');

        if(!$this->validateStock()) {
            return false;
        }

        // Insert transaksi keluar
        $result = $this->insertToDatabase();

        // Kurangi stok produk jika insert berhasil
        if($result) {
            $produk = new Produk($this->conn);
            $produk->setIdProduk($this->id_produk);
            $produk->readOne();
            $produk->setStok($produk->getStok() - $this->jumlah);
            $produk->update();
        }

        return $result;
    }
}