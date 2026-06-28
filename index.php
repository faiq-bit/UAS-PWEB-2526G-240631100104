<?php
$judul_halaman = "Beranda";
require 'koneksi.php';
require 'functions.php';
require 'header.php';

$pemasukan   = hitung_pemasukan($koneksi);
$pengeluaran = hitung_pengeluaran($koneksi);
$saldo       = hitung_saldo($koneksi);

$warna_saldo = $saldo >= 0 ? 'positif' : 'negatif';


$query = "SELECT * FROM transaksi ORDER BY tanggal DESC LIMIT 5";
$result = mysqli_query($koneksi, $query);
?>

<section class="hero">
    <h1>💰 CatatUang</h1>
    <p>Catat keuanganmu dengan mudah dan terorganisir</p>
</section>

<div class="stats-grid">
    <div class="stat-card saldo <?= $warna_saldo ?>">
        <span class="stat-icon">💳</span>
        <div>
            <span class="stat-number"><?= format_rupiah($saldo) ?></span>
            <span class="stat-label">Saldo Saat Ini</span>
        </div>
    </div>
    <div class="stat-card pemasukan">
        <span class="stat-icon">⬆️</span>
        <div>
            <span class="stat-number"><?= format_rupiah($pemasukan) ?></span>
            <span class="stat-label">Total Pemasukan</span>
        </div>
    </div>
    <div class="stat-card pengeluaran">
        <span class="stat-icon">⬇️</span>
        <div>
            <span class="stat-number"><?= format_rupiah($pengeluaran) ?></span>
            <span class="stat-label">Total Pengeluaran</span>
        </div>
    </div>
</div>

<section class="recent-section">
    <div class="section-header">
        <h2>Transaksi Terakhir</h2>
        <a href="daftar.php" class="btn btn-outline">Lihat Semua →</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Jenis</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                <td><?= htmlspecialchars($row['keterangan']) ?></td>
                <td>
                    <?php if ($row['jenis'] == 'pemasukan'): ?>
                        <span class="badge badge-masuk">⬆ Pemasukan</span>
                    <?php else: ?>
                        <span class="badge badge-keluar">⬇ Pengeluaran</span>
                    <?php endif; ?>
                </td>
                <td class="<?= $row['jenis'] == 'pemasukan' ? 'text-hijau' : 'text-merah' ?>">
                    <?= format_rupiah($row['jumlah']) ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>

<?php require 'footer.php'; ?>