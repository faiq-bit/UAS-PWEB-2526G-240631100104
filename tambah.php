<?php
$judul_halaman = "Tambah Transaksi";
require 'koneksi.php';
require 'functions.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal     = bersihkan_input($_POST['tanggal'] ?? '');
    $keterangan  = bersihkan_input($_POST['keterangan'] ?? '');
    $jenis       = bersihkan_input($_POST['jenis'] ?? '');
    $jumlah      = (float)str_replace('.', '', $_POST['jumlah'] ?? 0);

    // Validasi
    if (empty($tanggal))    $errors[] = "Tanggal tidak boleh kosong.";
    if (empty($keterangan)) $errors[] = "Keterangan tidak boleh kosong.";
    if (empty($jenis))      $errors[] = "Jenis transaksi harus dipilih.";
    if ($jumlah <= 0)       $errors[] = "Jumlah harus lebih dari 0.";

    if (empty($errors)) {
        $query = "INSERT INTO transaksi (tanggal, keterangan, jenis, jumlah) VALUES ('$tanggal', '$keterangan', '$jenis', $jumlah)";
        if (mysqli_query($koneksi, $query)) {
            header("Location: daftar.php?pesan=tambah");
            exit;
        } else {
            $errors[] = "Gagal menyimpan: " . mysqli_error($koneksi);
        }
    }
}

require 'header.php';
?>

<div class="page-header">
    <h1 class="page-title">➕ Tambah Transaksi</h1>
    <a href="daftar.php" class="btn btn-outline">← Kembali</a>
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <strong>⚠️ Terdapat kesalahan:</strong>
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?= $err ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="form-wrapper">
    <form method="POST" action="tambah.php" class="form-card">
        <div class="form-group">
            <label>Tanggal <span class="required">*</span></label>
            <input type="date" name="tanggal" class="form-control"
                   value="<?= isset($tanggal) ? $tanggal : date('Y-m-d') ?>" required>
        </div>

        <div class="form-group">
            <label>Keterangan <span class="required">*</span></label>
            <input type="text" name="keterangan" class="form-control"
                   placeholder="Contoh: Beli makan siang"
                   value="<?= isset($keterangan) ? htmlspecialchars($keterangan) : '' ?>" required>
        </div>

        <div class="form-group">
            <label>Jenis Transaksi <span class="required">*</span></label>
            <select name="jenis" class="form-control" required>
                <option value="">-- Pilih Jenis --</option>
                <option value="pemasukan" <?= (isset($jenis) && $jenis == 'pemasukan') ? 'selected' : '' ?>>⬆ Pemasukan</option>
                <option value="pengeluaran" <?= (isset($jenis) && $jenis == 'pengeluaran') ? 'selected' : '' ?>>⬇ Pengeluaran</option>
            </select>
        </div>

        <div class="form-group">
            <label>Jumlah (Rp) <span class="required">*</span></label>
            <input type="number" name="jumlah" class="form-control"
                   placeholder="Contoh: 50000" min="1"
                   value="<?= isset($jumlah) && $jumlah > 0 ? $jumlah : '' ?>" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Simpan</button>
            <a href="daftar.php" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>

<?php require 'footer.php'; ?>