# SIGUDA - Sistem Informasi Gudang Fashion
Tugas Besar/Capstone Proyek Mata Kuliah: Praktikum Pemrograman Berorientasi Objek (PPBO), 2025. 
- [Commit at Presentation Day](https://github.com/Blackpa77/TUBES_PPBO_SIGUDA/commit/1017e6c7cf814e90e474c69e6d0469766b341a37)

## Deskripsi Proyek
SIGUDA (Sistem Informasi Gudang) adalah aplikasi berbasis web untuk mengelola inventori gudang fashion Aplikasi ini dibangun menggunakan PHP OOP dengan arsitektur MVC dan PostgreSQL sebagai database.

## Informasi Tim
1. H1101241039 -  Florecita Wenny 
2. H1101241001 - Adhelia Issabel 
3. H1101241029 - Arjun Maheswara Paundra 
4. H1101241043 - Aurellya Yocelyn Prasista 
5. H1101241057 - Tesa Firna Ananta 

## Fitur Utama

### 1. Autentikasi
- Login dengan username & password  
- Manajemen session  
- Role-based access (Admin/Staff)

### 2. Dashboard
- Statistik: total produk, kategori, transaksi  
- Alert stok menipis (<10 unit)  
- 5 transaksi terbaru  
- Estimasi nilai aset stok

### 3. Manajemen Kategori
- CRUD kategori  
- Validasi: kategori dengan produk tidak dapat dihapus

### 4. Manajemen Produk
- CRUD produk lengkap  
- Atribut: kode, nama, ukuran, warna, stok, harga beli, harga jual  
- Filter stok menipis  
- Export laporan ke HTML & PDF (Dompdf)

### 5. Manajemen Transaksi
- Transaksi masuk (tambah stok)  
- Transaksi keluar (kurangi stok + validasi)  
- Riwayat transaksi lengkap  
- Cetak laporan transaksi berdasarkan periode

## Penerapan Konsep OOP
1. Encapsulation
Lokasi: `models/Admin.php`, `models/Produk.php`
```php
// Property PRIVATE dengan Getter & Setter
private $id;
private $username;
public function getId() { return $this->id; }
public function setId($id) { $this->id = $id; }
```
2. Inheritance
Lokasi: `models/TransaksiMasuk.php`, `models/TransaksiKeluar.php`
```php
// Class child extends parent
class TransaksiMasuk extends Transaksi { ... }
class TransaksiKeluar extends Transaksi { ... }
```

3. Polymorphism
Lokasi: Method `validateStock()` dan `save()` di class Transaksi
```php
// Method di parent class Transaksi
abstract public function validateStock();
abstract public function save();

// Override di TransaksiKeluar
public function validateStock() {
    // Logic khusus untuk validasi stok keluar
    return ($produk->stok >= $this->jumlah);
}
```

4. Abstract Class
Lokasi: `models/Transaksi.php`
```php
abstract class Transaksi {
    abstract public function validateStock();
    abstract public function save();
}
```

5. Interface
Lokasi: `models/LaporanInterface.php`
```php
interface LaporanInterface {
    public function readLaporan($start_date, $end_date);
    public function exportToPDF();
}
```

## Cara Penggunaan:
- Test dengan Akses: Menu Produk → Klik tombol "Export PDF"
- PDF akan otomatis ter-generate dan dapat di-download

## Cara Instalasi di Local
Prerequisites: 
- PHP 8.2 atau lebih tinggi & Composer
- Database Server
- Web Server (Apache/Nginx) atau PHP Built-in Server

Langkah-langkah:
```bash
# 1. Clone Repository
git clone https://github.com/Blackpa77/TUBES_PPBO_SIGUDA.git
cd TUBES_PPBO_SIGUDA

# 2. Install Dependencies
composer install
# -- Ini akan menginstall **Dompdf** untuk export PDF & Dependencies lainnya

# 3. Setup Database (MySQL)
## -- Cara 1: Login ke mysql
mysql -U 
## -- -- Buat database
CREATE DATABASE gudang_fashion;
## -- -- Import schema
\i db.sql

## -- Cara 2: Masuk GUI seperti HeidiSQL
## -- -- Lalu salin file `db.sql` 
## -- -- ke SQL Editor GUI

```
Database, tabel, & isi nya akan otomatis dibuat. 

4. Konfigurasi Environment
Buat file `.env` atau set environment variables:
```env
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=gudang_fashion
DB_USERNAME=postgres
DB_PASSWORD=your_password
```
Untuk deployment di Vercel/Railway, pastikan environment variables sudah di-set di dashboard platform.

5. Jalankan Aplikasi
- Opsi 1: PHP Built-in Server
```bash
php -S localhost:8000 -t public router.php
# Ini memberi tahu PHP bahwa semua request harus lewat file router tersebut, tapi public tetap menyimpan data statis yg dapat diakses.
```
- Opsi 2: Apache/Nginx (bisa pakai Laragon, tapi butuh konfigurasi target ke `router.php`)

### Cara Deploy ke Vercel & Supabase
- run `vercel --prod` (bisa koneksi ke repo github untuk auto run), atau push ke repo github lalu buat proyek langsung di [vercel.com](https://vercel.com/)
- setup database: jika pakai `supabase`, run `db-pg.sql` di **SQL Editor** supabase, sesuaikan konfigurasi `DB_*` seperti pada contoh di `.env.prod.example`, dan paste-kan ke dalam **vercel environment variable**

### Cara Deploy ke Railway & Database (Supaase or Mysql)
- Push ke github repo, lalu buat proyek di [railway](https://railway.com/new).
- Create juga Database di project yang sama. Sesuaikan .env berdasarkan tipe database yang dipilih.
- Untuk run setup Query SQL, koneksikan ke GUI local. Jika pakai HeidiSQL dan DB Railway adalah MySQL: gunakan konfigurasi mysql://<user>:<password>@<host>:<port>. di Heidi, gunakan lib **mariadb.dll**.

## Link Project
- [Dokumen Laporan](https://docs.google.com/document/d/1mTMhX8uBaTI0z1bTFjYZ2TCWiV2GJZW7ITvg3r7dA1o/edit?tab=t.0)
- [Demo](https://drive.google.com/file/d/11hGy3fDN1dMsLLIxJcppz2fa6ZidSn7w/view?usp=sharing) 
- [Video presentasi](https://drive.google.com/file/d/11hGy3fDN1dMsLLIxJcppz2fa6ZidSn7w/view?usp=sharing) 


