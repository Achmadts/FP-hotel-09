-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Des 2023 pada 00.32
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fountaine-project-hotel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `codes`
--

CREATE TABLE `codes` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `code` varchar(5) NOT NULL,
  `expire` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `codes`
--

INSERT INTO `codes` (`id`, `email`, `code`, `expire`) VALUES
(1, 'dalanga85@gmail.com', '69406', 1703759721),
(2, 'dalanga85@gmail.com', '93052', 1703769780);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kamar`
--

CREATE TABLE `kamar` (
  `no_kamar` int(11) NOT NULL,
  `ketersediaan` enum('Tersedia','Tidak tersedia') NOT NULL,
  `foto_kamar` varchar(255) NOT NULL,
  `type_kamar` enum('Standard','Executive','Suite','View','Family','Thematic') NOT NULL,
  `fasilitas_kamar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kamar`
--

INSERT INTO `kamar` (`no_kamar`, `ketersediaan`, `foto_kamar`, `type_kamar`, `fasilitas_kamar`) VALUES
(1, 'Tersedia', './assets/img/paket1.jpg', 'Standard', 'WiFi,TV,AC'),
(2, 'Tersedia', './assets/img/paket2.jpg', 'Executive', 'WiFi,TV,AC,Pemanas air'),
(3, 'Tersedia', './assets/img/paket3.jpeg', 'Family', 'WiFi,TV,AC,Pemanas air'),
(4, 'Tersedia', './assets/img/paket4.jpeg', 'Suite', 'WiFi,TV,AC,Pemanas air'),
(5, 'Tersedia', './assets/img/paket5.jpeg', 'View', 'WiFi,TV,AC'),
(6, 'Tersedia', './assets/img/paket6.jpeg', 'Thematic', 'WiFi,TV,AC');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengunjung`
--

CREATE TABLE `pengunjung` (
  `id_pengunjung` int(11) NOT NULL,
  `nama_pengunjung` varchar(255) NOT NULL,
  `email_pengunjung` varchar(255) NOT NULL,
  `alamat_pengunjung` varchar(255) NOT NULL,
  `no_hp_pengunjung` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengunjung`
--

INSERT INTO `pengunjung` (`id_pengunjung`, `nama_pengunjung`, `email_pengunjung`, `alamat_pengunjung`, `no_hp_pengunjung`) VALUES
(1, 'Achmad Tirto Sudiro', 'achmadtirtosudirosudiro@gmail.com', 'Karawang', '0895320316384');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_pengunjung` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `no_kamar` int(11) NOT NULL,
  `type_kamar` enum('Standard','Executive','Suite','View','Family','Thematic') NOT NULL,
  `waktu_chekin` datetime NOT NULL,
  `waktu_chekout` datetime NOT NULL,
  `lama_inap` varchar(255) NOT NULL,
  `total_harga` bigint(20) NOT NULL,
  `expire` datetime DEFAULT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pengunjung`, `id`, `no_kamar`, `type_kamar`, `waktu_chekin`, `waktu_chekout`, `lama_inap`, `total_harga`, `expire`, `status`) VALUES
(1, 1, 2, 3, 'Family', '2023-12-31 00:00:00', '2024-01-03 00:00:00', '1', 30000000, '2023-12-30 18:19:46', 'Dibayar');

-- --------------------------------------------------------

--
-- Struktur dari tabel `type_kamar`
--

CREATE TABLE `type_kamar` (
  `type_kamar` enum('Standard','Executive','Suite','View','Family','Thematic') NOT NULL,
  `harga_kamar` bigint(50) NOT NULL,
  `kapasitas_pengunjung` int(11) NOT NULL,
  `unit_tersedia` int(11) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `type_kamar`
--

INSERT INTO `type_kamar` (`type_kamar`, `harga_kamar`, `kapasitas_pengunjung`, `unit_tersedia`, `rating`) VALUES
('Standard', 2000000, 2, 99, 4),
('Executive', 8000000, 2, 97, 5),
('Suite', 8500000, 4, 97, 5),
('View', 4500000, 2, 49, 4),
('Family', 10000000, 4, 95, 5),
('Thematic', 4000000, 2, 48, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL,
  `verifiedEmail` int(11) NOT NULL DEFAULT 0,
  `token` varchar(255) NOT NULL DEFAULT '',
  `type` int(11) NOT NULL DEFAULT 0,
  `token_id` varchar(255) NOT NULL,
  `2FA` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `verifiedEmail`, `token`, `type`, `token_id`, `2FA`) VALUES
(1, 'Achmad Tirto Sudiro', 'achmadtirtosudirosudiro@gmail.com', '$2y$10$Zm/nwof3iYEFcEMgpdf2w.usqrDgqCO1UGgSjfFr5EVAq65FXqF0u', 1, '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', 0, '118708640', 0),
(2, 'Atok Dalang', 'dalanga85@gmail.com', '$2y$10$AAy34gTegIRnl8C0bteXJuTZL.Cc5li7dC1pmuFl3DD.ZMUZ74E5O', 1, '', 1, '', 0),
(3, 'Con Toh', 'tohcon59@gmail.com', '', 1, '114040684234577599877', 0, '', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `codes`
--
ALTER TABLE `codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `expire` (`expire`),
  ADD KEY `email` (`email`);

--
-- Indeks untuk tabel `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`no_kamar`),
  ADD KEY `type_kamar` (`type_kamar`);

--
-- Indeks untuk tabel `pengunjung`
--
ALTER TABLE `pengunjung`
  ADD PRIMARY KEY (`id_pengunjung`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_pengunjung` (`id_pengunjung`,`no_kamar`),
  ADD KEY `no_kamar` (`no_kamar`),
  ADD KEY `id` (`id`),
  ADD KEY `type_kamar` (`type_kamar`);

--
-- Indeks untuk tabel `type_kamar`
--
ALTER TABLE `type_kamar`
  ADD PRIMARY KEY (`type_kamar`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `codes`
--
ALTER TABLE `codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `kamar`
--
ALTER TABLE `kamar`
  MODIFY `no_kamar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pengunjung`
--
ALTER TABLE `pengunjung`
  MODIFY `id_pengunjung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kamar`
--
ALTER TABLE `kamar`
  ADD CONSTRAINT `kamar_ibfk_1` FOREIGN KEY (`type_kamar`) REFERENCES `type_kamar` (`type_kamar`);

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_pengunjung`) REFERENCES `pengunjung` (`id_pengunjung`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`no_kamar`) REFERENCES `kamar` (`no_kamar`),
  ADD CONSTRAINT `transaksi_ibfk_3` FOREIGN KEY (`id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `transaksi_ibfk_4` FOREIGN KEY (`type_kamar`) REFERENCES `type_kamar` (`type_kamar`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
