<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($judul_halaman) ? $judul_halaman . ' - ' : '' ?>Catatan Keuangan</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 999;
    justify-content: center;
    align-items: center;
}
.modal-overlay.aktif { display: flex; }
.modal-box {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    width: 360px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    animation: popIn .3s ease;
}
@keyframes popIn {
    from { transform: scale(0.8); opacity: 0; }
    to   { transform: scale(1);   opacity: 1; }
}
.modal-header {
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: .8rem;
}
.modal-header-icon { font-size: 1.8rem; }
.modal-header-title { color: #fff; font-size: 1.1rem; font-weight: 700; }
.modal-body {
    padding: 1.8rem;
    text-align: center;
}
.modal-body p { color: #475569; font-size: .95rem; margin-bottom: .5rem; }
.modal-nama {
    color: #dc2626;
    font-weight: 700;
    font-size: 1.1rem;
    margin: .5rem 0 1rem;
}
.modal-warning {
    font-size: .82rem;
    color: #94a3b8;
}
.modal-actions {
    display: flex;
    gap: .8rem;
    padding: 0 1.8rem 1.8rem;
    justify-content: center;
}
.btn-modal-hapus {
    background: #dc2626;
    color: #fff;
    border: none;
    padding: .6rem 1.5rem;
    border-radius: 10px;
    font-size: .95rem;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s;
}
.btn-modal-hapus:hover { background: #b91c1c; }
.btn-modal-batal {
    background: #f1f5f9;
    color: #475569;
    border: none;
    padding: .6rem 1.5rem;
    border-radius: 10px;
    font-size: .95rem;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s;
}
.btn-modal-batal:hover { background: #e2e8f0; }
</style>

<!-- Modal Hapus -->
<div class="modal-overlay" id="modalHapus">
    <div class="modal-box">
        <div class="modal-header">
            <span class="modal-header-icon">🗑️</span>
            <span class="modal-header-title">Konfirmasi Hapus</span>
        </div>
        <div class="modal-body">
            <p>Yakin ingin menghapus transaksi</p>
            <div class="modal-nama" id="modalNama"></div>
            <p class="modal-warning">⚠️ Data yang dihapus tidak bisa dikembalikan!</p>
        </div>
        <div class="modal-actions">
            <button class="btn-modal-batal" onclick="tutupModal()">Batal</button>
            <a id="btnHapusOk" href="#" class="btn-modal-hapus">Ya, Hapus!</a>
        </div>
    </div>
</div>

<script>
function bukuModal(id, nama) {
    document.getElementById('modalNama').innerText = nama;
    document.getElementById('btnHapusOk').href = 'hapus.php?id=' + id;
    document.getElementById('modalHapus').classList.add('aktif');
}
function tutupModal() {
    document.getElementById('modalHapus').classList.remove('aktif');
}
// Klik di luar modal = tutup
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay')) {
        tutupModal();
    }
});
</script>
</head>
<body>
    <nav class="navbar">
        <div class="nav-brand">
            💰 <span>CatatUang</span>
        </div>
        <ul class="nav-links">
            <li><a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">Beranda</a></li>
            <li><a href="daftar.php" class="<?= basename($_SERVER['PHP_SELF']) == 'daftar.php' ? 'active' : '' ?>">Transaksi</a></li>
            <li><a href="tambah.php" class="<?= basename($_SERVER['PHP_SELF']) == 'tambah.php' ? 'active' : '' ?>">+ Tambah</a></li>
        </ul>
    </nav>
    <main class="container">