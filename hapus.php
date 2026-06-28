<?php
require 'koneksi.php';
require 'functions.php';

// Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Cek data ada
$query = "SELECT * FROM transaksi WHERE id = $id";
$result = mysqli_query($koneksi, $query);
$transaksi = mysqli_fetch_assoc($result);

if ($transaksi) {
    // Hapus data
    $query = "DELETE FROM transaksi WHERE id = $id";
    if (mysqli_query($koneksi, $query)) {
        header("Location: daftar.php?pesan=hapus");
        exit;
    }
} else {
    // Data tidak ada, balik ke daftar
    header("Location: daftar.php");
    exit;
}
?>