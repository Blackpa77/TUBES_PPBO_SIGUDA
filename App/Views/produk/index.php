<?php
// ===========================
// views/produk/index.php
// ===========================

// Validasi variabel wajib
if (!isset($stmt) || !$stmt) {
    echo "<div class='alert alert-danger'>Error: Data produk tidak ditemukan. Pastikan controller mengirim \$stmt.</div>";
    exit;
}

if (!isset($base_url)) {
    // fallback otomatis jika controller lupa mengirimkan base_url
    $base_url = \App\Config\Config::getBaseUrl();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk - SIGUDA PPBO</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        body {
            background: #f8f9fa;
        }
        .table thead th {
            white-space: nowrap;
        }
    </style>
</head>
<body>

<?php include __DIR__ . '/../layouts/navbar.php'; ?>

<div class="container mt-4">

    <div class="row mb-3">
        <div class="col-md-6">
            <h2><i class="bi bi-box-seam"></i> Data Produk</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="<?= $base_url ?>/Produk?action=create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Produk
            </a>

            <a href="<?= $base_url ?>/Produk?action=cetak" target="_blank" class="btn btn-secondary">
                <i class="bi bi-printer"></i> Cetak Laporan
            </a>
        </div>
    </div>

    <!-- Notifikasi -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= htmlspecialchars($_SESSION['success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Card tabel -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        $no = 1;
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>

                            <td>
                                <span class="badge bg-secondary">
                                    <?= htmlspecialchars($row['kode_produk'] ?? '-') ?>
                                </span>
                            </td>

                            <td>
                                <strong><?= htmlspecialchars($row['nama_produk']) ?></strong><br>
                                <small class="text-muted">
                                    <?= htmlspecialchars($row['ukuran']) ?> |
                                    <?= htmlspecialchars($row['warna'] ?? '-') ?>
                                </small>
                            </td>

                            <td><?= htmlspecialchars($row['nama_kategori'] ?? '-') ?></td>

                            <td>
                                <?php if ((int)$row['stok'] <= 10): ?>
                                    <span class="badge bg-danger"><?= $row['stok'] ?></span>
                                <?php else: ?>
                                    <span class="badge bg-success"><?= $row['stok'] ?></span>
                                <?php endif; ?>
                            </td>

                            <td>Rp <?= number_format($row['harga_beli'], 0, ',', '.') ?></td>
                            <td>Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?></td>

                            <td class="text-center">
                                <a href="<?= $base_url ?>/Produk?action=edit&id=<?= $row['id_produk'] ?>" 
                                   class="btn btn-warning btn-sm text-white">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <a href="<?= $base_url ?>/Produk?action=delete&id=<?= $row['id_produk'] ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin ingin menghapus data ini?')">
                                   <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>

                        <?php if ($no == 1): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-inbox display-6"></i><br>
                                Belum ada data produk.
                            </td>
                        </tr>
                        <?php endif; ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
