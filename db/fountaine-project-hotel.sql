-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Des 2023 pada 13.57
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengunjung`
--

CREATE TABLE `pengunjung` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `no_telpon` varchar(15) NOT NULL,
  `jkel` enum('Laki-laki','Perempuan','','') NOT NULL,
  `region` enum('Warga Lokal','Warga Asing','','') NOT NULL,
  `tgl_check_in` date NOT NULL,
  `tgl_check_out` date NOT NULL,
  `jenis_kamar` enum('Single','Double','Suite','') NOT NULL,
  `jumlah_tamu` int(11) NOT NULL,
  `kategori` enum('VVIP','VIP','Biasa','') NOT NULL,
  `fasilitas_tambahan` varchar(255) NOT NULL,
  `metode_pembayaran` enum('Kartu Kredit','Transfer Bank','Tunai') NOT NULL,
  `nomor_kartu_kredit` varchar(16) NOT NULL,
  `tgl_expired` date NOT NULL,
  `pesan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengunjung`
--

INSERT INTO `pengunjung` (`id`, `name`, `email`, `alamat`, `tgl_lahir`, `no_telpon`, `jkel`, `region`, `tgl_check_in`, `tgl_check_out`, `jenis_kamar`, `jumlah_tamu`, `kategori`, `fasilitas_tambahan`, `metode_pembayaran`, `nomor_kartu_kredit`, `tgl_expired`, `pesan`) VALUES
(1, 'Achmad Tirto Sudiro', 'achmadtirtosudirosudiro@gmail.com', 'Klari', '2006-09-09', '0895320316384', 'Laki-laki', 'Warga Lokal', '2023-12-12', '2023-12-20', 'Double', 2, 'VVIP', 'Bantal, Acara Spesial', 'Transfer Bank', '', '0000-00-00', 'Tes'),
(2, 'Bayu', 'bayu@gmail.com', 'Karawang', '2001-01-10', '089523865727675', 'Laki-laki', 'Warga Lokal', '2023-12-12', '2023-12-13', 'Single', 1, 'VVIP', 'Bantal, Acara Spesial', 'Tunai', '', '0000-00-00', 'Hai\r\n'),
(3, 'Iswan', 'wan@gmail.com', 'Karawang', '2006-10-10', '089858265726956', 'Laki-laki', 'Warga Lokal', '2023-12-12', '2023-12-13', 'Single', 1, 'VVIP', 'Bantal Acara Spesial ', 'Transfer Bank', '', '0000-00-00', 'Hai');

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
  `type` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indeks untuk tabel `pengunjung`
--
ALTER TABLE `pengunjung`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengunjung`
--
ALTER TABLE `pengunjung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
