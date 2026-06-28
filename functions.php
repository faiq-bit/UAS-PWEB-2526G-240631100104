<?php
function bersihkan_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function format_rupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function hitung_pemasukan($koneksi) {
    $query = "SELECT SUM(jumlah) as total FROM transaksi WHERE jenis = 'pemasukan'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}

function hitung_pengeluaran($koneksi) {
    $query = "SELECT SUM(jumlah) as total FROM transaksi WHERE jenis = 'pengeluaran'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}

function hitung_saldo($koneksi) {
    $pemasukan = hitung_pemasukan($koneksi);
    $pengeluaran = hitung_pengeluaran($koneksi);
    return $pemasukan - $pengeluaran;
}