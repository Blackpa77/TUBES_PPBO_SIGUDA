-- ============================================
-- DATABASE SCHEMA - gudang_fashion
-- PostgreSQL Version
-- ============================================

-- ==========================
-- DROP ALL TABLES (Opsional, Jika ingin Reset Supabase PostgreSQL)
-- ==========================
DO $$ DECLARE
    r RECORD;
BEGIN
    FOR r IN (SELECT tablename FROM pg_tables WHERE schemaname = 'public') LOOP
        EXECUTE 'DROP TABLE IF EXISTS ' || quote_ident(r.tablename) || ' CASCADE';
    END LOOP;
END $$;

-- ============================
-- Table: users
-- ============================
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    role VARCHAR(10) NOT NULL CHECK (role IN ('admin', 'staff')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================
-- Table: kategori
-- ============================
CREATE TABLE kategori (
    id_kategori SERIAL PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL
);

-- ============================
-- Table: produk
-- ============================
CREATE TABLE produk (
    id_produk SERIAL PRIMARY KEY,
    id_kategori INT NOT NULL REFERENCES kategori(id_kategori) ON DELETE CASCADE,
    nama_produk VARCHAR(200) NOT NULL,
    ukuran VARCHAR(50) NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    harga NUMERIC(15,2) NOT NULL DEFAULT 0,
    harga_beli NUMERIC(15,2) NOT NULL DEFAULT 0,
    harga_jual NUMERIC(15,2) NOT NULL DEFAULT 0,
    kode_produk VARCHAR(50) UNIQUE,
    warna VARCHAR(50),
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================
-- Table: transaksi
-- ============================
CREATE TABLE transaksi (
    id_transaksi SERIAL PRIMARY KEY,
    id_produk INT NOT NULL REFERENCES produk(id_produk) ON DELETE CASCADE,
    jenis_transaksi VARCHAR(10) NOT NULL CHECK (jenis_transaksi IN ('masuk', 'keluar')),
    jumlah INT NOT NULL,
    tanggal DATE NOT NULL,
    keterangan TEXT,
    kode_transaksi VARCHAR(50) UNIQUE,
    tanggal_transaksi DATE
);

-- ============================
-- Dummy Data: kategori
-- ============================
INSERT INTO kategori (nama_kategori) VALUES
('Kaos'),
('Kemeja'),
('Celana'),
('Jaket'),
('Dress');

-- ============================
-- Dummy Data: produk
-- ============================
INSERT INTO produk (id_kategori, nama_produk, ukuran, stok, harga, harga_beli, harga_jual, kode_produk, warna) VALUES
(1, 'Kaos Polos Hitam', 'M', 25, 75000, 50000, 75000, 'K001', 'Hitam'),
(1, 'Kaos Polos Putih', 'L', 30, 75000, 50000, 75000, 'K002', 'Putih'),
(2, 'Kemeja Formal Biru', 'M', 15, 150000, 100000, 150000, 'M001', 'Biru'),
(3, 'Celana Jeans Slim Fit', '32', 20, 200000, 150000, 200000, 'C001', 'Biru Dongker'),
(4, 'Jaket Bomber Hitam', 'XL', 8, 350000, 250000, 350000, 'J001', 'Hitam'),
(5, 'Dress Casual Pink', 'M', 12, 180000, 120000, 180000, 'D001', 'Pink');

-- ============================
-- Dummy Data: transaksi
-- ============================
INSERT INTO transaksi (id_produk, jenis_transaksi, jumlah, tanggal, keterangan, kode_transaksi) VALUES
(1, 'masuk', 50, '2025-01-15', 'Stok awal', 'T-M-001'),
(2, 'masuk', 50, '2025-01-15', 'Stok awal', 'T-M-002'),
(1, 'keluar', 25, '2025-01-20', 'Penjualan online', 'T-K-001'),
(2, 'keluar', 20, '2025-01-22', 'Penjualan toko', 'T-K-002');

-- ============================
-- Dummy Data: users (admin)
-- Password: admin123
-- ============================
INSERT INTO users (username, password, nama_lengkap, role) VALUES
('admin', '$2y$10$WohKMED8JPn10ZMbIUr4peJRQFAUu6Gu4Z7IymWxBkRywXvlKoK3e', 'Administrator', 'admin');
