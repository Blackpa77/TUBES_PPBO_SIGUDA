-- Database: gudang_fashion

CREATE DATABASE IF NOT EXISTS gudang_fashion;
USE gudang_fashion;

-- Tabel Users (Dibutuhkan oleh Admin.php)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    role ENUM('admin', 'staff') NOT NULL DEFAULT 'staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Kategori
CREATE TABLE IF NOT EXISTS kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Produk
CREATE TABLE IF NOT EXISTS produk (
    id_produk INT AUTO_INCREMENT PRIMARY KEY,
    id_kategori INT NOT NULL,
    nama_produk VARCHAR(200) NOT NULL,
    ukuran VARCHAR(50) NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    harga DECIMAL(15,2) NOT NULL DEFAULT 0,
    -- Tambahkan kolom yang digunakan di Produk.php dan dashboard.php
    harga_beli DECIMAL(15,2) NOT NULL DEFAULT 0,
    harga_jual DECIMAL(15,2) NOT NULL DEFAULT 0,
    kode_produk VARCHAR(50) UNIQUE,
    warna VARCHAR(50),
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Transaksi
CREATE TABLE IF NOT EXISTS transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    id_produk INT NOT NULL,
    jenis_transaksi ENUM('masuk', 'keluar') NOT NULL,
    jumlah INT NOT NULL,
    tanggal DATE NOT NULL,
    keterangan TEXT,
    -- Tambahkan kolom yang digunakan di dashboard.php (jika ada kode transaksi)
    kode_transaksi VARCHAR(50) UNIQUE,
    tanggal_transaksi DATE, -- Menggunakan tanggal yang ada (tanggal)
    FOREIGN KEY (id_produk) REFERENCES produk(id_produk) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data dummy kategori
INSERT INTO kategori (nama_kategori) VALUES 
('Kaos'),
('Kemeja'),
('Celana'),
('Jaket'),
('Dress');

-- Data dummy produk (Perlu menyesuaikan dengan kolom baru)
INSERT INTO produk (id_kategori, nama_produk, ukuran, stok, harga, harga_beli, harga_jual, kode_produk, warna) VALUES 
(1, 'Kaos Polos Hitam', 'M', 25, 75000, 50000, 75000, 'K001', 'Hitam'),
(1, 'Kaos Polos Putih', 'L', 30, 75000, 50000, 75000, 'K002', 'Putih'),
(2, 'Kemeja Formal Biru', 'M', 15, 150000, 100000, 150000, 'M001', 'Biru'),
(3, 'Celana Jeans Slim Fit', '32', 20, 200000, 150000, 200000, 'C001', 'Biru Dongker'),
(4, 'Jaket Bomber Hitam', 'XL', 8, 350000, 250000, 350000, 'J001', 'Hitam'),
(5, 'Dress Casual Pink', 'M', 12, 180000, 120000, 180000, 'D001', 'Pink');

-- Data dummy transaksi (Perlu menyesuaikan dengan kolom baru)
INSERT INTO transaksi (id_produk, jenis_transaksi, jumlah, tanggal, keterangan, kode_transaksi) VALUES 
(1, 'masuk', 50, '2025-01-15', 'Stok awal', 'T-M-001'),
(2, 'masuk', 50, '2025-01-15', 'Stok awal', 'T-M-002'),
(1, 'keluar', 25, '2025-01-20', 'Penjualan online', 'T-K-001'),
(2, 'keluar', 20, '2025-01-22', 'Penjualan toko', 'T-K-002');

-- Inisialisasi user admin
-- Password 'admin123' dengan hash: $2y$10$WohKMED8JPn10ZMbIUr4peJRQFAUu6Gu4Z7IymWxBkRywXvlKoK3e
INSERT INTO users (username, password, nama_lengkap, role) VALUES 
('admin', '$2y$10$WohKMED8JPn10ZMbIUr4peJRQFAUu6Gu4Z7IymWxBkRywXvlKoK3e', 'Administrator', 'admin');