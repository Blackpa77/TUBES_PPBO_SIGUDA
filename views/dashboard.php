<?php

// Hitung total data
$total_produk = $produk->readAll()->rowCount();
$total_kategori = $kategori->readAll()->rowCount();

// Ambil transaksi
$data_masuk = $transaksiMasuk->readAll()->fetchAll(PDO::FETCH_ASSOC);
$data_keluar = $transaksiKeluar->readAll()->fetchAll(PDO::FETCH_ASSOC);

// Gabungkan semua transaksi
$all_transaksi = array_merge($data_masuk, $data_keluar);

// Urutkan berdasarkan tanggal DESC
usort($all_transaksi, function($a, $b) {
    return strtotime($b['tanggal']) - strtotime($a['tanggal']);
});

$total_transaksi = count($all_transaksi);

// Hitung nilai stok
$stmt_nilai = $produk->readAll();
$total_nilai_stok = 0;
while($row = $stmt_nilai->fetch(PDO::FETCH_ASSOC)) {
    $harga_hitung = isset($row['harga_beli']) && $row['harga_beli'] > 0 
        ? $row['harga_beli'] 
        : ($row['harga'] ?? 0);

    $total_nilai_stok += ($row['stok'] * $harga_hitung);
}

// Stok menipis
$stmt_low = $produk->getLowStock(10);
$low_stock_data = $stmt_low ? $stmt_low->fetchAll(PDO::FETCH_ASSOC) : [];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SIGUDA PPBO</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        body {
            background: #f4f7fb;
            font-family: 'Poppins', sans-serif;
        }

        .card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            transition: .2s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }

        .summary-card {
            color: white;
            background: linear-gradient(135deg, #0d47a1, #1565c0);
        }

        .summary-icon {
            opacity: .25;
            font-size: 3.3rem;
        }

        .table thead {
            background: #e9eef7;
        }

        .badge {
            padding: 6px 12px;
            font-size: .75rem;
            border-radius: 20px;
        }

        .section-title {
            font-weight: 600;
            color: #0d47a1;
        }
    </style>
</head>

<body>

<?php include __DIR__ . '/layouts/navbar.php'; ?>

<div class="container py-4">

    <!-- Welcome Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="fw-bold mb-1">Selamat Datang, <?= htmlspecialchars($_SESSION['nama_lengkap']); ?> 👋</h4>
            <p class="text-muted mb-0">Anda login sebagai <strong><?= ucfirst($_SESSION['role']); ?></strong></p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4">

        <div class="col-md-3">
            <div class="card summary-card p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Total Produk</h6>
                        <h2 class="fw-bold mt-1"><?= $total_produk ?></h2>
                    </div>
                    <i class="bi bi-box-seam summary-icon"></i>
                </div>
                <a href="<?= $base_url ?>/Produk" class="text-white small mt-2 d-block">Lihat Detail →</a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card summary-card p-3 shadow-sm" style="background: linear-gradient(135deg,#2e7d32,#43a047);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Total Kategori</h6>
                        <h2 class="fw-bold mt-1"><?= $total_kategori ?></h2>
                    </div>
                    <i class="bi bi-tags summary-icon"></i>
                </div>
                <a href="<?= $base_url ?>/Kategori" class="text-white small mt-2 d-block">Lihat Detail →</a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card summary-card p-3 shadow-sm" style="background: linear-gradient(135deg,#ffb300,#ffa000);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Total Transaksi</h6>
                        <h2 class="fw-bold mt-1"><?= $total_transaksi ?></h2>
                    </div>
                    <i class="bi bi-arrow-left-right summary-icon"></i>
                </div>
                <a href="<?= $base_url ?>/Transaksi" class="text-white small mt-2 d-block">Lihat Detail →</a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card summary-card p-3 shadow-sm" style="background: linear-gradient(135deg,#0288d1,#03a9f4);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Nilai Aset Stok</h6>
                        <h4 class="fw-bold mt-1">Rp <?= number_format($total_nilai_stok,0,',','.') ?></h4>
                    </div>
                    <i class="bi bi-cash-coin summary-icon"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Stok Menipis & 5 Transaksi Terakhir -->
    <div class="row mt-4">

        <!-- Stok Menipis -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="section-title"><i class="bi bi-exclamation-triangle text-danger"></i> Stok Menipis</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Produk</th>
                                <th class="text-center">Sisa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($low_stock_data)): ?>
                                <?php foreach($low_stock_data as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['kode_produk']) ?></td>
                                    <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-danger"><?= $row['stok'] ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="3" class="text-center text-muted py-3">Tidak ada stok menipis</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 5 Transaksi Terakhir -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="section-title"><i class="bi bi-clock-history text-primary"></i> 5 Transaksi Terakhir</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php 
                        $i = 0;
                        foreach($all_transaksi as $row): 
                            if($i++ >= 5) break;
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($row['kode_produk'] ?? $row['id_transaksi']) ?></td>
                            <td>
                                <?php if($row['jenis_transaksi'] == 'masuk'): ?>
                                    <span class="badge bg-success">Masuk</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Keluar</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                        </tr>
                        <?php endforeach; ?>

                        <?php if(empty($all_transaksi)): ?>
                            <tr><td colspan="3" class="text-center py-3 text-muted">Belum ada transaksi</td></tr>
                        <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
</body>
</html>
