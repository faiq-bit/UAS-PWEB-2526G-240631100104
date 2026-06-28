-- Database: keuangan
CREATE DATABASE IF NOT EXISTS keuangan;
USE keuangan;

CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL,
    keterangan VARCHAR(200) NOT NULL,
    jenis ENUM('pemasukan', 'pengeluaran') NOT NULL,
    jumlah DECIMAL(15,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO transaksi (tanggal, keterangan, jenis, jumlah) VALUES
('2026-06-01', 'Gaji bulanan', 'pemasukan', 2000000),
('2026-06-02', 'Beli makan siang', 'pengeluaran', 25000),
('2026-06-03', 'Uang jajan dari orang tua', 'pemasukan', 500000),
('2026-06-05', 'Bayar kos', 'pengeluaran', 800000),
('2026-06-07', 'Beli kuota internet', 'pengeluaran', 50000),
('2026-06-10', 'Freelance desain', 'pemasukan', 300000),
('2026-06-15', 'Beli buku kuliah', 'pengeluaran', 75000);