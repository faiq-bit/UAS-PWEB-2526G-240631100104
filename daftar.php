<?php
$judul_halaman = "Daftar Transaksi";
require 'koneksi.php';
require 'functions.php';
require 'header.php';

// Fitur pencarian (GET)
$keyword = '';
if (isset($_GET['cari']) && !empty($_GET['cari'])) {
    $keyword = bersihkan_input($_GET['cari']);
    $query = "SELECT * FROM transaksi WHERE keterangan LIKE '%$keyword%' OR jenis LIKE '%$keyword%' ORDER BY tanggal DESC";
} else {
    $query = "SELECT * FROM transaksi ORDER BY tanggal DESC";
}

$result = mysqli_query($koneksi, $query);
$total  = mysqli_num_rows($result);
?>

<div class="page-header">
    <h1 class="page-title">📋 Daftar Transaksi</h1>
    <a href="tambah.php" class="btn btn-primary">+ Tambah</a>
</div>

<!-- Form Pencarian -->
<div class="search-bar">
    <form method="GET" action="daftar.php">
        <div class="search-input-group">
            <input type="text" name="cari" placeholder="Cari transaksi..." 
                   value="<?= htmlspecialchars($keyword) ?>" class="search-input">
            <button type="submit" class="btn btn-primary">🔍 Cari</button>
            <?php if ($keyword): ?>
                <a href="daftar.php" class="btn btn-outline">✕ Reset</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Notifikasi -->
<?php if (isset($_GET['pesan'])): ?>
    <?php if ($_GET['pesan'] == 'tambah'): ?>
        <div class="alert alert-success">✅ Transaksi berhasil ditambahkan!</div>
    <?php elseif ($_GET['pesan'] == 'edit'): ?>
        <div class="alert alert-success">✅ Transaksi berhasil diperbarui!</div>
    <?php elseif ($_GET['pesan'] == 'hapus'): ?>
        <div class="alert alert-danger">🗑️ Transaksi berhasil dihapus!</div>
    <?php endif; ?>
<?php endif; ?>

<!-- Tabel -->
<div class="table-wrapper">
    <?php if ($total > 0): ?>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)): 
            ?>
            <tr>
                <td><?= $no++ ?></td>
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
                <td>
                  <a href="#" class="btn-sm btn-hapus" 
   onclick="bukuModal(<?= $row['id'] ?>, '<?= htmlspecialchars($row['keterangan']) ?>')">🗑️ Hapus</a>
 
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <div class="empty-state-box">
            <p>📭 Belum ada transaksi.</p>
            <a href="tambah.php" class="btn btn-primary">+ Tambah Sekarang</a>
        </div>
    <?php endif; ?>
</div>

<?php require 'footer.php'; ?>