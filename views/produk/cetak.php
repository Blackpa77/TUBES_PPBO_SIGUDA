<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Produk</title>
    <style>
        body { 
            font-family: 'DejaVu Sans', Arial, sans-serif; 
            font-size: 11pt;
            margin: 15px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 25px;
            border-bottom: 3px solid #333;
            padding-bottom: 10px;
        }
        .header h2 { 
            margin: 5px 0; 
            color: #0d6efd;
            font-size: 18pt;
        }
        .header p { margin: 3px 0; font-size: 10pt; }
        
        .info-box {
            background: #f8f9fa;
            padding: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #0d6efd;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }
        th, td { 
            border: 1px solid #333; 
            padding: 8px; 
            text-align: left; 
        }
        th { 
            background-color: #0d6efd; 
            color: white;
            font-weight: bold;
            text-align: center;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        .total-row {
            background-color: #e7f3ff;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 30px;
            float: right;
            text-align: center;
            width: 250px;
        }
        .footer p { margin: 5px 0; }
        
        .page-number {
            text-align: center;
            font-size: 9pt;
            margin-top: 20px;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>🏢 LAPORAN STOK PRODUK GUDANG FASHION</h2>
        <p><strong>SIGUDA - Sistem Informasi Gudang</strong></p>
        <p>Jl. Teuku Umar No. 123, Pontianak, Kalimantan Barat 78124</p>
        <p>Telp: (0561) 123456 | Email: info@siguda.com</p>
    </div>

    <div class="info-box">
        <strong>📅 Tanggal Cetak:</strong> <?php echo date('d F Y H:i'); ?> WIB<br>
        <strong>👤 Dicetak Oleh:</strong> <?php echo $_SESSION['nama_lengkap'] ?? 'Admin'; ?><br>
        <strong>📊 Total Item:</strong> <?php echo $stmt->rowCount(); ?> Produk
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="10%">Kode</th>
                <th width="25%">Nama Produk</th>
                <th width="15%">Kategori</th>
                <th width="8%">Ukuran</th>
                <th width="8%">Stok</th>
                <th width="15%">Harga Beli</th>
                <th width="15%">Total Nilai</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $grand_total = 0;
            $total_stok = 0;

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                $harga = $row['harga_beli'] ?? 0;
                $subtotal = $row['stok'] * $harga;
                $grand_total += $subtotal;
                $total_stok += $row['stok'];
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td class="text-center"><?= htmlspecialchars($row['kode_produk'] ?? '-'); ?></td>
                <td><?= htmlspecialchars($row['nama_produk']); ?></td>
                <td><?= htmlspecialchars($row['nama_kategori'] ?? '-'); ?></td>
                <td class="text-center"><?= htmlspecialchars($row['ukuran']); ?></td>
                <td class="text-center"><?= $row['stok']; ?></td>
                <td class="text-right">Rp <?= number_format($harga, 0, ',', '.'); ?></td>
                <td class="text-right">Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
            </tr>
            <?php endwhile; ?>
            
            <tr class="total-row">
                <th colspan="5" class="text-right">TOTAL</th>
                <th class="text-center"><?= $total_stok; ?></th>
                <th class="text-right">-</th>
                <th class="text-right">Rp <?= number_format($grand_total, 0, ',', '.'); ?></th>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Mengetahui,</p>
        <p><strong>Kepala Gudang</strong></p>
        <br><br><br>
        <p>_______________________</p>
        <p><strong><?php echo $_SESSION['nama_lengkap'] ?? 'Administrator'; ?></strong></p>
    </div>

    <div style="clear: both;"></div>
    
    <div class="page-number">
        <p>--- Dokumen ini digenerate otomatis oleh SIGUDA PPBO ---</p>
    </div>

</body>
</html>

<?php
// Ambil HTML content
$html = ob_get_clean();

// Load HTML ke Dompdf
$dompdf->loadHtml($html);

// Set ukuran kertas dan orientasi
$dompdf->setPaper('A4', 'landscape'); // atau 'portrait'

// Render PDF
$dompdf->render();

// Output PDF ke browser
$filename = "Laporan_Stok_Produk_" . date('Y-m-d_His') . ".pdf";
$dompdf->stream($filename, array("Attachment" => false)); // false = preview, true = download
?>