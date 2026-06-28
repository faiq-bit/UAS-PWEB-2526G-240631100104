<?php
$judul_halaman = "Edit Transaksi";
require 'koneksi.php';
require 'functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data transaksi berdasarkan ID
$query = "SELECT * FROM transaksi WHERE id = $id";
$result = mysqli_query($koneksi, $query);
$transaksi = mysqli_fetch_assoc($result);

// Kalau data tidak ditemukan, balik ke daftar
if (!$transaksi) {
    header("Location: daftar.php");
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal    = bersihkan_input($_POST['tanggal'] ?? '');
    $keterangan = bersihkan_input($_POST['keterangan'] ?? '');
    $jenis      = bersihkan_input($_POST['jenis'] ?? '');
    $jumlah     = (float)($_POST['jumlah'] ?? 0);

    // Validasi
    if (empty($tanggal))    $errors[] = "Tanggal tidak boleh kosong.";
    if (empty($keterangan)) $errors[] = "Keterangan tidak boleh kosong.";
    if (empty($jenis))      $errors[] = "Jenis transaksi harus dipilih.";
    if ($jumlah <= 0)       $errors[] = "Jumlah harus lebih dari 0.";

    if (empty($errors)) {
        $query = "UPDATE transaksi SET tanggal='$tanggal', keterangan='$keterangan', jenis='$jenis', jumlah=$jumlah WHERE id=$id";
        if (mysqli_query($koneksi, $query)) {
            header("Location: daftar.php?pesan=edit");
            exit;
        } else {
            $errors[] = "Gagal update: " . mysqli_error($koneksi);
        }
    } else {
        $transaksi['tanggal']    = $tanggal;
        $transaksi['keterangan'] = $keterangan;
        $transaksi['jenis']      = $jenis;
        $transaksi['jumlah']     = $jumlah;
    }
}

require 'header.php';
?>

<div class="page-header">
    <h1 class="page-title">✏️ Edit Transaksi</h1>
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
    <form method="POST" action="edit.php?id=<?= $id ?>" class="form-card">
        <div class="form-group">
            <label>Tanggal <span class="required">*</span></label>
            <input type="date" name="tanggal" class="form-control"
                   value="<?= $transaksi['tanggal'] ?>" required>
        </div>

        <div class="form-group">
            <label>Keterangan <span class="required">*</span></label>
            <input type="text" name="keterangan" class="form-control"
                   value="<?= htmlspecialchars($transaksi['keterangan']) ?>" required>
        </div>

        <div class="form-group">
            <label>Jenis Transaksi <span class="required">*</span></label>
            <select name="jenis" class="form-control" required>
                <option value="">-- Pilih Jenis --</option>
                <option value="pemasukan" <?= $transaksi['jenis'] == 'pemasukan' ? 'selected' : '' ?>>⬆ Pemasukan</option>
                <option value="pengeluaran" <?= $transaksi['jenis'] == 'pengeluaran' ? 'selected' : '' ?>>⬇ Pengeluaran</option>
            </select>
        </div>

        <div class="form-group">
            <label>Jumlah (Rp) <span class="required">*</span></label>
            <input type="number" name="jumlah" class="form-control"
                   value="<?= $transaksi['jumlah'] ?>" min="1" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
            <a href="daftar.php" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>

<?php require 'footer.php'; ?>