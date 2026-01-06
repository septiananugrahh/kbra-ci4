-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2025 at 05:01 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new_kbra`
--

-- --------------------------------------------------------

--
-- Table structure for table `asesmen_anekdot`
--

CREATE TABLE `asesmen_anekdot` (
  `id` int(11) NOT NULL,
  `santri` varchar(9) NOT NULL,
  `kelas` varchar(9) NOT NULL,
  `semester` varchar(9) NOT NULL,
  `modul_ajar_id` varchar(9) NOT NULL,
  `tanggal` varchar(255) NOT NULL,
  `tempat` varchar(255) DEFAULT NULL,
  `peristiwa` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asesmen_anekdot`
--

INSERT INTO `asesmen_anekdot` (`id`, `santri`, `kelas`, `semester`, `modul_ajar_id`, `tanggal`, `tempat`, `peristiwa`, `keterangan`) VALUES
(1, '20', '6', '-', '2', 'Selasa, 03 Juni 2025', 'sdad', 'dsadad', 'dsad'),
(2, '20', '6', '-', '3', 'Selasa, 10 Juni 2025', 'dsa', 'sadasda', 'aaw'),
(3, '20', '6', '-', '3', 'Rabu, 18 Juni 2025', 'kelas', 'menyenangkan', 'profesi'),
(4, '22', '6', '-', '3', 'Selasa, 10 Juni 2025', 'sadas', 'sds', '');

-- --------------------------------------------------------

--
-- Table structure for table `asesmen_checklist`
--

CREATE TABLE `asesmen_checklist` (
  `id` int(11) NOT NULL,
  `santri` int(11) NOT NULL,
  `kelas` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `modul_ajar_id` int(11) NOT NULL,
  `tanggal` varchar(255) NOT NULL,
  `isi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asesmen_checklist`
--

INSERT INTO `asesmen_checklist` (`id`, `santri`, `kelas`, `semester`, `modul_ajar_id`, `tanggal`, `isi`) VALUES
(1, 20, 6, 0, 3, 'Selasa, 10 Juni 2025', '[{\"id\":\"2\",\"status\":\"belum_muncul\"},{\"id\":\"4\",\"status\":\"belum_muncul\"},{\"id\":\"10\",\"status\":\"sudah_muncul\"}]'),
(2, 22, 6, 0, 3, 'Senin, 02 Juni 2025', '[{\"id\":\"2\",\"status\":\"sudah_muncul\"},{\"id\":\"4\",\"status\":\"sudah_muncul\"},{\"id\":\"10\",\"status\":\"sudah_muncul\"}]'),
(3, 21, 6, 0, 3, 'Selasa, 03 Juni 2025', '[{\"id\":\"2\",\"status\":\"belum_muncul\"},{\"id\":\"4\",\"status\":\"sudah_muncul\"},{\"id\":\"10\",\"status\":\"sudah_muncul\"}]'),
(4, 23, 6, 0, 3, 'Selasa, 10 Juni 2025', '[{\"id\":\"2\",\"status\":\"sudah_muncul\"},{\"id\":\"4\",\"status\":\"sudah_muncul\"},{\"id\":\"10\",\"status\":\"belum_muncul\"}]'),
(5, 21, 6, 0, 2, 'Rabu, 18 Juni 2025', '[{\"id\":\"5\",\"status\":\"sudah_muncul\"},{\"id\":\"9\",\"status\":\"belum_muncul\"}]'),
(6, 24, 6, 0, 3, 'Selasa, 03 Juni 2025', '[]');

-- --------------------------------------------------------

--
-- Table structure for table `asesmen_fotoberseri`
--

CREATE TABLE `asesmen_fotoberseri` (
  `id` bigint(20) NOT NULL,
  `santri` varchar(9) NOT NULL,
  `kelas` varchar(9) NOT NULL,
  `semester` varchar(9) NOT NULL,
  `modul_ajar_id` varchar(9) NOT NULL,
  `tanggal` varchar(255) NOT NULL,
  `foto1` text DEFAULT NULL,
  `ket_foto1` text DEFAULT NULL,
  `foto2` text DEFAULT NULL,
  `ket_foto2` text DEFAULT NULL,
  `foto3` text DEFAULT NULL,
  `ket_foto3` text DEFAULT NULL,
  `analisis_guru` text DEFAULT NULL,
  `umpan_balik` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asesmen_fotoberseri`
--

INSERT INTO `asesmen_fotoberseri` (`id`, `santri`, `kelas`, `semester`, `modul_ajar_id`, `tanggal`, `foto1`, `ket_foto1`, `foto2`, `ket_foto2`, `foto3`, `ket_foto3`, `analisis_guru`, `umpan_balik`) VALUES
(1, '21', '6', '-', '3', 'Selasa, 03 Juni 2025', '1750082709_fee38046032a357bc726.png', 'satu', '1750082709_70bc8e455d5cbab1c862.jpg', 'dua', NULL, 'tiga', 'analisis guru', 'umpan balik'),
(2, '20', '6', '-', '3', 'Selasa, 10 Juni 2025', '1749828620_8258982c04af3a18395a.png', 'sss', '1749828620_198266db7ced6e044b06.jpg', 'ddd', '', 'eee', 'sadasd', 'wdadwa'),
(3, '24', '6', '-', '3', 'Selasa, 03 Juni 2025', '1750119955_822cae5dcbe38189f0a3.jpg', 'dasda', NULL, '', NULL, 's', 'dasdad', 'dwada');

-- --------------------------------------------------------

--
-- Table structure for table `asesmen_hasilkarya`
--

CREATE TABLE `asesmen_hasilkarya` (
  `id` int(11) NOT NULL,
  `santri` varchar(9) NOT NULL,
  `kelas` varchar(9) NOT NULL,
  `semester` varchar(9) NOT NULL,
  `modul_ajar_id` varchar(9) NOT NULL,
  `tanggal` varchar(255) NOT NULL,
  `kegiatan` varchar(255) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asesmen_hasilkarya`
--

INSERT INTO `asesmen_hasilkarya` (`id`, `santri`, `kelas`, `semester`, `modul_ajar_id`, `tanggal`, `kegiatan`, `foto`, `catatan`) VALUES
(1, '21', '6', '-', '3', 'Selasa, 03 Juni 2025', 'hasil karya', NULL, 'hasil karya');

-- --------------------------------------------------------

--
-- Table structure for table `capaian_pembelajaran`
--

CREATE TABLE `capaian_pembelajaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `urut` int(11) NOT NULL,
  `setting` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `capaian_pembelajaran`
--

INSERT INTO `capaian_pembelajaran` (`id`, `nama`, `urut`, `setting`, `deleted`) VALUES
(1, 'Nilai Agama dan Budi Pekerti', 1, '1', 0),
(3, 'Jati Diri', 2, '1', 0),
(4, 'Dasar- dasar Literasi, Matematika,  Sains, Teknologi,Rekayasa,dan Seni', 3, '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` varchar(200) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `token` text DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `nama`, `username`, `password`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `token`, `deleted`) VALUES
(1, 'Septian', 'unnamed', '$2y$10$go9JjThNKXXRPwdanmyF.u7C.d5ayxDV5cRH.HuAeGAL91n0ghpMe', 'Ponorogo', '05-05-1997', 'Ponorogo', NULL, 0),
(4, 'NURUL WIDIYAWATI, S.Pd', 'nurul', '$2y$10$K.Xr35hXDOEWa46nr4NYYuJRgfw5vDg1BfAg7Ez9zj5mZOOYnS4R.', 'Ponorogo', '21-05-2025', 'Ponorogo', NULL, 0),
(5, 'VINA NURA NENNISSA,S.Pd', 'vina', '$2y$10$8Q77wfCzvRfeqbTVVsIKfOTb42GT/blss1aMy1Lq9o.I4GSPLs2he', 'Ponorogo', '13-06-2025', 'Ponorogo', NULL, 0),
(6, 'NOFI SHANDRA PRASWI, S.Pd', 'nofi', '$2y$10$iQIyc607UqM9nzVImu170uhZOl5DxNCC4KFvVB6Ljm2yT61Lls3bO', 'Ponorogo', '21-05-2025', 'Ponorogo', NULL, 0),
(7, 'NUNING MUFAROKAH, S.Pd', 'nuning', '$2y$10$fxrVfrLB44PyjAat3G8diO3KyENytKMohSHj32tgJcQTCzxcQjonW', 'Ponorogo', '21-05-2025', 'Ponorogo', NULL, 0),
(8, 'FAZA IMAROTUL LATIFAH', 'faza', '$2y$10$1ieWnlvWBAsFB3v6pK/dFuoTMVy2BHkOM.hQ/6qkzFx0UOz7.q0/2', 'Ponorogo', '21-05-2025', 'Ponorogo', NULL, 0),
(9, 'NUR AISYAH ROHMAWATI', 'aisyah', '$2y$10$qSuWqGV5I6c8l234ZCze1exkL5XNsZGUhBlhF3/ckzUl2n1as6d2u', 'Ponorogo', '21-05-2025', 'Ponorogo', NULL, 0),
(10, 'IKHDA AFILA RIZKA, S. Pd.', 'ikhda', '$2y$10$aURZ.IjGuyIsubQlgP30bu3b2wI0ceeqrV2tG7GABCFTH/OYM289C', 'Ponorogo', '21-05-2025', 'Ponorogo', NULL, 0),
(11, 'PASHA HAMIDAH PURNAVINNA, S. Pd', 'pasha', '$2y$10$gibh1vIjGiKXs9Z5byGPkOP2OaMK0SPGYvy7aPx9zEfR4Se9lPjx2', 'Ponorogo', '21-05-2025', 'Ponorogo', NULL, 0),
(12, 'FENTI DWI ANGGRAINI', 'fenti', '$2y$10$va1SkZ6jOWdbJJWJBWr6CedlcL3tns1lJWTlH4o15UDUdjRQJkQuq', 'Ponorogo', '21-05-2025', 'Ponorogo', NULL, 0),
(13, 'HANIFAH NUR AZIZAH, S. Ag', 'hanifah', '$2y$10$kc5wEO6y0yPEAp2vB21UFev5HNZd8dRW9beDDcu9v3DBFuwLpYYFi', 'Ponorogo', '21-05-2025', 'Ponorogo', NULL, 0),
(14, 'IMROATUL MUFIDAH, S. Pd. SD', 'imroatul', '$2y$10$Fyl2YBaxPjWEGBNvrQ0FKeoZSnzlGmEU9jgFNOnHhSi2U55BUFmaO', 'Ponorogo', '21-05-2025', 'Ponorogo', NULL, 0),
(15, 'WIDIA KRISNAWATI', 'widia', '$2y$10$xX4ZSgyFd0ejCvct8UKFq.vgE/l3rtZZBASFdRsumbKtRmAaKzsma', 'Ponorogo', '21-05-2025', 'Ponorogo', NULL, 0),
(16, 'MARFITRI DIANASARI, A.Md KeP', 'marfitri', '$2y$10$Olkqdec8JamnwYDvDiouteNEPFpK2BVjt4Sm6Sdsd.77pxLg3kSQS', 'Ponorogo', '21-05-2025', 'Ponorogo', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `guru_kelas`
--

CREATE TABLE `guru_kelas` (
  `id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `guru_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru_kelas`
--

INSERT INTO `guru_kelas` (`id`, `kelas_id`, `guru_id`) VALUES
(7, 6, 12),
(8, 6, 5);

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `jenjang` varchar(10) NOT NULL,
  `tingkat` varchar(10) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `set` int(11) NOT NULL,
  `wali` varchar(5) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `jenjang`, `tingkat`, `nama`, `set`, `wali`, `deleted`) VALUES
(6, 'RA', 'A', 'Matahari', 1, '12', 0),
(7, 'RA', 'A', 'Bulan', 1, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `attempted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modul_ajar`
--

CREATE TABLE `modul_ajar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `dibuat_tanggal` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `pekan` varchar(255) NOT NULL,
  `model_pembelajaran` varchar(255) NOT NULL,
  `tema_pembelajaran` varchar(255) NOT NULL,
  `topik_pembelajaran` varchar(255) NOT NULL,
  `deskripsi_pembelajaran` varchar(255) NOT NULL,
  `tujuan_pembelajaran` text DEFAULT '[]',
  `foto_mediaPembelajaran` varchar(255) DEFAULT NULL,
  `deskripsi_mediaPembelajaran` varchar(255) DEFAULT NULL,
  `subTopik_tanggal1` varchar(255) DEFAULT NULL,
  `subTopik_1` varchar(255) DEFAULT NULL,
  `subTopik_tanggal2` varchar(255) DEFAULT NULL,
  `subTopik_2` varchar(255) DEFAULT NULL,
  `subTopik_tanggal3` varchar(255) DEFAULT NULL,
  `subTopik_3` varchar(255) DEFAULT NULL,
  `subTopik_tanggal4` varchar(255) DEFAULT NULL,
  `subTopik_4` varchar(255) DEFAULT NULL,
  `subTopik_tanggal5` varchar(255) DEFAULT NULL,
  `subTopik_5` varchar(255) DEFAULT NULL,
  `deleted` varchar(2) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modul_ajar`
--

INSERT INTO `modul_ajar` (`id`, `kelas_id`, `dibuat_tanggal`, `semester`, `pekan`, `model_pembelajaran`, `tema_pembelajaran`, `topik_pembelajaran`, `deskripsi_pembelajaran`, `tujuan_pembelajaran`, `foto_mediaPembelajaran`, `deskripsi_mediaPembelajaran`, `subTopik_tanggal1`, `subTopik_1`, `subTopik_tanggal2`, `subTopik_2`, `subTopik_tanggal3`, `subTopik_3`, `subTopik_tanggal4`, `subTopik_4`, `subTopik_tanggal5`, `subTopik_5`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 6, '', '1', '1', 'Daring', 'dawdad', 'awdawdad', 'dwadadawd', NULL, '1748756430_95819db9a32d8ebaf478.png', 'dawdawdawd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL),
(2, 6, 'Selasa, 10 Juni 2025', '1', '1', 'Luring', 'Integrated CPU', 'Integrated CPU', 'Integrated CPU', '[\"5\",\"9\"]', '1748789551_4fc5f6612be98ffb7da2.png', 'dawdwadawd', 'Selasa, 03 Juni 2025', 'dawdad', 'Rabu, 18 Juni 2025', 'dawdad', 'Kamis, 19 Juni 2025', 'dawdad', 'Jumat, 20 Juni 2025', 'dawdawd', 'Sabtu, 21 Juni 2025', 'dawdawdawd', '0', NULL, NULL),
(3, 6, 'Selasa, 17 Juni 2025', '1', '1', 'Luring', 'ilmu pengetahuan', 'ilmu pengetahuan', 'ilmu pengetahuan', '[\"2\",\"4\",\"10\"]', '1748759043_d885909923d4fdafb20e.png', 'dawdawdad', 'Senin, 02 Juni 2025', 'dwadawd', 'Selasa, 03 Juni 2025', 'dawdawdwad', 'Rabu, 18 Juni 2025', 'dawdawd', 'Kamis, 19 Juni 2025', 'dwadawdad', 'Selasa, 10 Juni 2025', 'dawdawdawda', '0', NULL, NULL),
(4, 6, 'Senin, 02 Juni 2025', '1', '1', 'Daring', 'profesi', 'profesi', 'profesi', '[\"22\"]', '1748869893_f7d0c62ed39f1515c0f1.png', 'dwadawd', 'Selasa, 03 Juni 2025', 'cdawdad', 'Selasa, 03 Juni 2025', 'dwadawda', 'Selasa, 03 Juni 2025', 'dwadad', 'Rabu, 18 Juni 2025', 'dwadadw', 'Rabu, 18 Juni 2025', 'dwdadadad', '0', NULL, NULL),
(5, 6, 'Selasa, 03 Juni 2025', '1', '1', 'Daring', 'dawdawd', 'awdadw', 'dwdadsad', NULL, '1748866967_84d39e34249fc83ff8ca.png', 'dawdawd', 'Senin, 09 Juni 2025', 'dwadasda', 'Selasa, 10 Juni 2025', 'dawdadsad', 'Rabu, 11 Juni 2025', 'dwadsasd', 'Kamis, 12 Juni 2025', 'dasadasd', 'Jumat, 13 Juni 2025', 'dasdawda', '0', NULL, NULL),
(6, 6, 'Senin, 16 Juni 2025', '1', '1', 'Daring', 'penerbangan', 'penerbangan', 'penerbangan', NULL, '1748869827_77347f98ea20c7298950.png', 'dawdasd', 'Senin, 02 Juni 2025', 'dasdasd', 'Selasa, 03 Juni 2025', 'dadsad', 'Rabu, 04 Juni 2025', 'dsadsad', 'Kamis, 05 Juni 2025', 'dsadasd', 'Jumat, 06 Juni 2025', 'dsdadsad', '0', NULL, NULL),
(7, 6, 'Selasa, 17 Juni 2025', '1', '1', 'Daring', 'dasdadawd', 'dasdassdasdadasdaw232', 'dadsads', '[]', '1748870544_9a4c7df5e03ac2e0cc58.png', 'sdasdasdad', 'Senin, 02 Juni 2025', 'sdawad', 'Selasa, 03 Juni 2025', 'dsadsadawd', 'Rabu, 04 Juni 2025', 'dwadawdad', 'Kamis, 05 Juni 2025', 'dsadadwdda', 'Jumat, 06 Juni 2025', 'sadawdwad', '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ruang_kelas`
--

CREATE TABLE `ruang_kelas` (
  `id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `santri_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ruang_kelas`
--

INSERT INTO `ruang_kelas` (`id`, `kelas_id`, `santri_id`) VALUES
(30, 6, 20),
(31, 6, 21),
(32, 6, 22),
(33, 6, 23),
(34, 6, 24),
(35, 6, 25),
(36, 6, 26),
(37, 6, 27),
(38, 6, 28),
(39, 6, 29),
(40, 6, 30),
(41, 6, 31),
(42, 6, 32),
(43, 6, 33),
(44, 6, 34),
(45, 6, 35),
(46, 6, 36),
(47, 6, 37),
(48, 6, 38),
(49, 6, 39),
(50, 7, 40),
(51, 7, 41),
(52, 7, 42),
(53, 7, 43),
(54, 7, 44),
(55, 7, 45),
(56, 7, 46),
(57, 7, 47),
(58, 7, 48),
(59, 7, 49),
(60, 7, 50),
(61, 7, 51),
(62, 7, 52),
(63, 7, 53),
(64, 7, 54),
(65, 7, 55),
(66, 7, 56),
(67, 7, 57),
(68, 7, 58),
(69, 7, 59),
(70, 7, 60);

-- --------------------------------------------------------

--
-- Table structure for table `santri`
--

CREATE TABLE `santri` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nis_lokal` varchar(255) NOT NULL,
  `nisn` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` varchar(50) NOT NULL,
  `telp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `nama_ayah` varchar(255) NOT NULL,
  `nama_ibu` varchar(255) NOT NULL,
  `pekerjaan_ayah` varchar(255) NOT NULL,
  `pekerjaan_ibu` varchar(255) NOT NULL,
  `foto_santri` varchar(255) DEFAULT NULL,
  `jenjang` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT '"1"',
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `santri`
--

INSERT INTO `santri` (`id`, `nama`, `nis_lokal`, `nisn`, `nik`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `telp`, `alamat`, `nama_ayah`, `nama_ibu`, `pekerjaan_ayah`, `pekerjaan_ibu`, `foto_santri`, `jenjang`, `status`, `deleted`) VALUES
(20, 'ADAM FARIZQI MUNTAHA', '0', '3198865246', '3502113010190001.00 ', 'L', 'PONOROGO', '2019-10-30', '0', 'PERUMAHAN KERTOSARI INDAH BLOK P 11 KERTOSARI, BABADAN, PONOROGO, JAWA TIMUR, 63491, 63491', 'AHMAD INTO PRADANA MUNTAHA', 'SRI WINARTI', '-', '-', NULL, 'RA', '1', 0),
(21, 'ASMA SYIFAU RAHMA PRAYITNO', '12', '3202903945', '3502156103200001', 'P', 'PONOROGO', '2020-03-21', '0', 'DESA KALIMALANG, RT 02 RW 02 KALIMALANG, SUKOREJO, PONOROGO, JAWA TIMUR, 63453, 63453', 'SUGENG PRAYITNO', 'NURUL YULIANA', '-', '-', '1750073463_ff8421aa6c651ca40327.jpg', 'KB', '1', 0),
(22, 'AMATULLAH SHOLIHAH', '0', '3192845154', '\'3502166203190003', 'P', 'PONOROGO', '2019-03-22', '0', 'DESA LEMBAH TLASIH LEMBAH, BABADAN, PONOROGO, JAWA TIMUR, 63491, 63491', 'M JA\'FAR SHODIQ', 'RINA PUJI LESTARI', '-', '-', NULL, 'RA', '1', 0),
(23, 'ALESHA RUZAZA WIJAYA', '0', '3199120007', '\'3502176711190003', 'P', 'PONOROGO', '2019-11-27', '0', 'JALAN LETJEND S.PARMAN NO,21 BEDURI, PONOROGO, PONOROGO, JAWA TIMUR, 63412, 63412', 'HARIS DANUR WIJAYA', 'ARIS EGAYANTI', '-', '-', NULL, 'RA', '1', 0),
(24, 'DJENAR KASTUBA', '0', '3207753641', '\'3502072402200002', 'L', 'PONOROGO', '2020-02-24', '0', 'JALAN KHASAN BESARI NO.13 KAUMAN, KAUMAN, PONOROGO, JAWA TIMUR, 63451, 63451', 'BIMA PRASETYO, A.Md.Kep', 'ERMA ULLUL JANAH S.I.P', '-', '-', NULL, 'RA', '1', 0),
(25, 'HANIN HANANIA', '0', '3193568203', '\'3502104608190001', 'P', 'PONOROGO', '2019-08-06', '0', 'PERUMNAS ASABRI BLOK F/17 PIJERAN, SIMAN, PONOROGO, JAWA TIMUR, 63471, 63471', 'I MADE CANDRA WIJAYA', 'DITA IMANIAR', '-', '-', NULL, 'RA', '1', 0),
(26, 'HIROKI HASAN', '0', '3197099293', '\'3502170102190001', 'L', 'PONOROGO', '2019-02-01', '0', 'JALAN ONGGOLONO 59 RT 06 RW 01 GOLAN, SUKOREJO, PONOROGO, JAWA TIMUR, 63453, 63453', 'ARIF RIYADI', 'KHOLIFATUN NISWATUR RASYIDAH', '-', '-', NULL, 'RA', '1', 0),
(27, 'MAISHA AL HAURAIN', '0', '3192448076', '\'6471055503190001', 'P', 'PONOROGO', '2019-03-15', '0', 'PERUM GRAND VIOLA 2 NO.A17 JALAN DOPLANG PURBOSUMAN, PONOROGO, PONOROGO, JAWA TIMUR, 63417, 63417', 'BAIDOWI RIDWAN', 'FETI APRILIA', '-', '-', NULL, 'RA', '1', 0),
(28, 'MUHAMMAD HANIF ABBAD', '0', '3199203857', '\'3502102209190002', 'L', 'PONOROGO', '2019-09-22', '0', 'JALAN JAMKHASARI 01/01 DEMANGAN DEMANGAN, SIMAN, PONOROGO, JAWA TIMUR, 63471, 63471', 'ROHMAT HENDRO SULISTYO', 'LUTFHIANA DWI ERNAWATI', '-', '-', NULL, 'RA', '1', 0),
(29, 'MUHAMMAD AGHNI ALFA MUBAROK', '0', '3192376982', '\'3501091311190001', 'L', 'PONOROGO', '2019-11-13', '0', 'JALAN UKEL GANG 11 NO.7 KERTOSARI, BABADAN, PONOROGO, JAWA TIMUR, 63491, 63491', 'MARYONO', 'HANIM MAGHFIROH', '-', '-', NULL, 'RA', '1', 0),
(30, 'NUSAIBAH', '0', '3193546687', '\'3502036906190001', 'P', 'PONOROGO', '2019-06-29', '0', 'DESA KUNTI RT 02/ RW 02 KUNTI, BUNGKAL, PONOROGO, JAWA TIMUR, 63462, 63462', 'FREDI SETIAWAN', 'PERWITA OKTIKA RINI', '-', '-', NULL, 'RA', '1', 0),
(31, 'PUTRI SARAH AL-GHAITSA', '0', '3197805649', '\'3502186011190001', 'P', 'PONOROGO', '2019-11-20', '0', 'JALAN GONDOLOYO RT 01/RW 01 SETONO, JENANGAN, PONOROGO, JAWA TIMUR, 63492, 63492', 'YATROWI', 'MUKAYANAH', '-', '-', NULL, 'RA', '1', 0),
(32, 'RANIA SAJIDAH', '0', '3192349602', '\'3502174805190001', 'P', 'PONOROGO', '2019-05-08', '0', 'JALAN MERAPI NO.7 NOLOGATEN, PONOROGO, PONOROGO, JAWA TIMUR, 63411, 63411', 'MUHAMMAD SYAIFUL HIDAYAT', 'SITI ULIPAH', '-', '-', NULL, 'RA', '1', 0),
(33, 'YASMIN KHADIJAH MUHADI', '0', '3201999252', '\'3502136404200001', 'P', 'PONOROGO', '2020-04-24', '0', 'DUSUN SUKOSARI RT 02 RW 02 KAPURAN, BADEGAN, PONOROGO, JAWA TIMUR, 63491, 63491', 'NANANG MUHADI', 'AYNUN UMAISYAH', '-', '-', NULL, 'RA', '1', 0),
(34, 'YUSUF ALKHALIFI', '0', '3204573147', '\'3502200902200001', 'L', 'PONOROGO', '2020-02-09', '0', 'DESA MENANG RT001 RW002 MENANG, JAMBON, PONOROGO, JAWA TIMUR, 63456, 63456', 'YAKOB SUPRAPTO', 'DIAN VATMASARI', '-', '-', NULL, 'RA', '1', 0),
(35, 'SYAIFA KUSUMA HAKIM', '0', '3199582395', '\'3502165311190002', 'P', 'PONOROGO', '2019-11-13', '0', 'JALAN KH. ABDUL HADI RT01 RW02 GUPOLO, BABADAN, PONOROGO, JAWA TIMUR, 63491, 63491', 'LUKMAN HAKIM', 'LIKHA DIAH KUSUMA WARDANI', '-', '-', NULL, 'RA', '1', 0),
(36, 'USAMAH ABDURRAHMAN BAHANA', '0', '3192733932', '\'3502161609190002', 'L', 'PONOROGO', '2019-09-16', '0', 'RT 03 RW 01 DUKUH BANGUNSARI SUKOSARI, BABADAN, PONOROGO, JAWA TIMUR, 63491, 63491', 'ANGGIT BAHANA BRIYANTIKA', 'RAHMA ZULI AHSANTI', '-', '-', NULL, 'RA', '1', 0),
(37, 'DAVIAN NAZEEM MUFAZZAL', '0', '3201231019', '\'3502172603200001', 'L', 'PONOROGO', '2020-03-26', '0', 'JALAN SEKAR PUTIH TIMUR NO.16 TONATAN, PONOROGO, PONOROGO, JAWA TIMUR, 63418, 63418', 'ARFIAN SEPTIANTO', 'DIAN PERMATASARI', '-', '-', NULL, 'RA', '1', 0),
(38, 'ABDURRAHMAN FARIH AL MUSYAFFA\'', '0', '3193723049', '\'3502091108190001', 'L', 'PONOROGO', '2019-08-11', '0', 'DESA WONOKETRO RT 001 RW 002 WONOKETRO, JETIS, PONOROGO, JAWA TIMUR, 63473, 63473', 'NURUDDIN RIFAI', 'FAIZAH USNIDA RUSDIYATI', '-', '-', NULL, 'RA', '1', 0),
(39, 'SYAFIQ ZUHAIR', '0', '3198778459', '\'3311012903190002', 'L', 'SUKOHARJO', '2019-03-29', '0', 'SINGOSAREN BLOK A41 SINGOSAREN, JENANGAN, PONOROGO, JAWA TIMUR, 63492, 63492', 'RONI MULYANTO. A. Md', 'YULIANA PUJIASTUTI', '-', '-', NULL, 'RA', '1', 0),
(40, 'NAJMI ABDURROHMAN', '0', '3193411048', '\'3516132704190001', 'L', 'MOJOKERTO', '2019-04-27', '0', 'JL KI AGENG KUTU NO 5 SIMAN, SIMAN, PONOROGO, JAWA TIMUR, 63471, 63471', 'ALFAN ZAIN KUSUMA PUTRA', 'NOVA RIZQI LAILI', '-', '-', NULL, 'RA', '1', 0),
(41, 'ASMA NAIRA', '0', '3198721279', '\'3519034512190001', 'P', 'MADIUN', '2019-12-05', '0', 'JALAN ANGGREK, SEDAH KLOROGAN, GEGER, MADIUN, JAWA TIMUR, 63171, 63171', 'MISENO', 'SRI HANDAYANI', '-', '-', NULL, 'RA', '1', 0),
(42, 'FATHIMAH NISWATUSH SHALIHAH', '0', '3196537710', '\'3502055112190001', 'P', 'PONOROGO', '2019-12-11', '0', 'JALAN S.PARMAN, LINGKUNGAN SABLAK RT 03 RW 02. KENITEN KENITEN, PONOROGO, PONOROGO, JAWA TIMUR, 63412, 63412', 'WAWAN RIANDRI, ST', 'EVIE YULIANTI', '-', '-', NULL, 'RA', '1', 0),
(43, 'IRFAN MAULANA PUTRA', '0', '3185806738', '\'3502172212180001', 'L', 'PONOROGO', '2018-12-22', '0', 'JALAN MUSLIM NO.10 DUKUH JETIS 1 JETIS, JETIS, PONOROGO, JAWA TIMUR, 63473, 63473', 'TRI JANARKO', 'NOVI FATMAWATI SETYANINGRUM S.PD', '-', '-', NULL, 'RA', '1', 0),
(44, 'MARYAM HAMIZAH ATS - TSABITAH', '0', '3209807307', '\'3502176103200002', 'P', 'PONOROGO', '2020-03-21', '0', 'JALAN LET.JEND S PARMAN NO,149 KENITEN, PONOROGO, PONOROGO, JAWA TIMUR, 63412, 63412', 'AGUS ARDIANTO', 'MADA NUVITA SARI S.PD', '-', '-', NULL, 'RA', '1', 0),
(45, 'MUHAMMAD GHAISAN ALKHALIFI', '0', '3205168395', '\'3502172504200001', 'L', 'PONOROGO', '2020-04-25', '0', 'JALAN KALIMANTAN 73 MANGKUJAYAN, PONOROGO, PONOROGO, JAWA TIMUR, 63413, 63413', 'WIBOWO ROMADHONA', 'AYU RISSA ROSSALIN', '-', '-', NULL, 'RA', '1', 0),
(46, 'SALMAN DHIAURRAHMAN', '0', '3193454047', '\'3502091305190002', 'L', 'PONOROGO', '2019-05-13', '0', 'JALAN KH.TAPTOJANI RT 003 RW 001 WONOKETRO, JETIS, PONOROGO, JAWA TIMUR, 63473, 63473', 'SUBANDI', 'WIWIK ISTIANI', '-', '-', NULL, 'RA', '1', 0),
(47, 'ADIBA RAYYA MALAIKA ALFATHUNISSA', '0', '3199576008', '\'3502165909190001', 'P', 'PONOROGO', '2019-09-19', '0', 'JALAN PARANG UKEL NO.39, RT 02 RW 02 KADIPATEN, BABADAN, PONOROGO, JAWA TIMUR, 63491, 63491', 'MUHAMAD BANGUN DWI ROHMANTO, S.Pd', 'YESI AISAH SE', '-', '-', NULL, 'RA', '1', 0),
(48, 'FATHIMAH AZ ZAHRA', '0', '3195121864', '\'3502114412190001', 'P', 'PONOROGO', '2019-12-04', '0', 'DESA GRENTENG RT 03 RW 02 NGAMPEL, BALONG, PONOROGO, JAWA TIMUR, 63461, 63461', 'HERI WIBOWO', 'TRI WAHYUNINGSIH', '-', '-', NULL, 'RA', '1', 0),
(49, 'AZKA FAWWAZ AZIZAIN', '0', '3196612732', '\'3502110607190002', 'L', 'PONOROGO', '2019-07-06', '0', 'JALAN DR.CIPTO MANGUNKUSUMA RT 1 RW 12 KENITEN, PONOROGO, PONOROGO, JAWA TIMUR, 63412, 63412', 'SLAMET RIYADI', 'NURUL WIDIYAWATI', '-', '-', NULL, 'RA', '1', 0),
(50, 'GHAZALI ARDHY EL RUMI', '0', '3191098775', '\'3506251304190003', 'L', 'PONOROGO', '2019-04-13', '0', 'JALAN LET.JEND SUKOWATI II NO.6A KENITEN, PONOROGO, PONOROGO, JAWA TIMUR, 63412, 63412', 'RAMADHANE ARDHY SULAKSONO', 'KRISTINA RAHAYU', '-', '-', NULL, 'RA', '1', 0),
(51, 'JIHAD AL FATH', '0', '3199291671', '\'3577031208190001', 'L', 'KOTA MADIUN', '2019-08-12', '0', 'PERUMAN CITRA PURI KENITEN 2.BLOK A-3B KENITEN, PONOROGO, PONOROGO, JAWA TIMUR, 63412, 63412', 'TRI PRIO PRANOTO WIBOWO', 'SITI SALSABILA', '-', '-', NULL, 'RA', '1', 0),
(52, 'KHADIJAH HAYYIN PRAMESWARI', '0', '3193743049', '\'3520066307190001', 'P', 'PONOROGO', '2019-07-23', '0', 'PERUM CITRA PURI PERMATA A-14 KERTOSARI, BABADAN, PONOROGO, JAWA TIMUR, 63491, 63491', 'MIFTAHUL CHANAFI', 'EVA WIDYAWATI', '-', '-', NULL, 'RA', '1', 0),
(53, 'MUHAMMAD BAHRUSSALAM', '0', '3199722354', '\'3502161408190001', 'L', 'PONOROGO', '2019-08-14', '0', 'JALAN PARANG PARUNG NO.60 PATIHAN WETAN, BABADAN, PONOROGO, JAWA TIMUR, 63491, 63491', 'NISAHUDIN', 'SITI MUNAWAROH', '-', '-', NULL, 'RA', '1', 0),
(54, 'MUHAMMAD DAFFA ALFARIZI', '0', '3204734475', '\'3502170705200002', 'L', 'PONOROGO', '2020-05-07', '0', 'JALAN RUJAK SENTE NO.27 D COKROMENGGALAN, PONOROGO, PONOROGO, JAWA TIMUR, 63411, 63411', 'LADI, S.Pd.I', 'IRNAWATI A.MA', '-', '-', NULL, 'RA', '1', 0),
(55, 'MUHAMMAD NARENDRA TANSATRISNA', '0', '3204112691', '\'3502101301200002', 'L', 'PONOROGO', '2020-01-13', '0', 'JALAN SRIGADING RT02 RW 01 MADUSARI, SIMAN, PONOROGO, JAWA TIMUR, 63471, 63471', 'W. SIDIK RASTRA HENDRA', 'FIQIN MEGAVILYA BAKTI', '-', '-', NULL, 'RA', '1', 0),
(56, 'MUHAMMAD UTSMAN BAIHAQI', '0', '3184616538', '\'3502091907180001', 'L', 'PONOROGO', '2018-07-19', '0', 'JALAN JENDRAL SUDIRMAN 321 JOSARI, JETIS, PONOROGO, JAWA TIMUR, 63473, 63473', 'MUHAMAD TAUFIQ QUROHMAN', 'NURUL SYULAINI', '-', '-', NULL, 'RA', '1', 0),
(57, 'OMAR FAZZA DZULQARNAIN', '0', '3190315064', '\'3502102009190001', 'L', 'PONOROGO', '2019-09-20', '0', 'JALAN SINGOLEMBORO NO.II A SIMAN, SIMAN, PONOROGO, JAWA TIMUR, 63471, 63471', 'SUCAHYONO', 'HANIK TRISETYAWATI', '-', '-', NULL, 'RA', '1', 0),
(58, 'ZULFANSYAH ARROYYAN UTOMO', '0', '3193097181', '\'3502162306190001', 'L', 'PONOROGO', '2019-06-23', '0', 'JALAN DURGANDINI RT006 RW 001 LEMBAH, BABADAN, PONOROGO, JAWA TIMUR, 63491, 63491', 'DIDIK PRIYO UTOMO', 'RATNA INDARWATI', '-', '-', NULL, 'RA', '1', 0),
(59, 'UWAIS ALAFASY', '0', '3208509752', '\'3502172401200001', 'L', 'PONOROGO', '2020-01-24', '0', 'JALAN JAWA GANG V. NO.1 C MANGKUJAYAN, PONOROGO, PONOROGO, JAWA TIMUR, 63413, 63413', 'IBOB WIJAYA', 'DINDA CARNELIA', '-', '-', NULL, 'RA', '1', 0),
(60, 'KHADIJAH AT-THAHIRAH', '0', '3197681293', '\'3508096806190001', 'P', 'PONOROGO', '2019-06-28', '0', 'JALAN KI AGENG SELO NO. 31 JAPAN, BABADAN, PONOROGO, JAWA TIMUR, 63491, 63491', 'NUR ABIDIN', 'ZULAEKHA ARIFAH ZUBAID', '-', '-', NULL, 'RA', '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `id` int(11) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `tahun` varchar(50) NOT NULL,
  `tingkat` varchar(50) NOT NULL,
  `kepala` int(11) NOT NULL,
  `copy_tp` int(2) NOT NULL,
  `tanggal_rapor` varchar(200) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`id`, `semester`, `tahun`, `tingkat`, `kepala`, `copy_tp`, `tanggal_rapor`, `deleted`) VALUES
(1, 'GANJIL', '2025/2026', 'KB', 14, 0, '12 Maret 2025', 0),
(2, 'GENAP', '2024/2025', 'KB', 14, 0, '12 Maret 2025', 0),
(3, 'GENAP', '2024/2025', 'RA', 4, 0, '12 Maret 2025', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tujuan_pembelajaran`
--

CREATE TABLE `tujuan_pembelajaran` (
  `id` int(11) NOT NULL,
  `capaian` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `urut` int(11) NOT NULL,
  `deleted` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tujuan_pembelajaran`
--

INSERT INTO `tujuan_pembelajaran` (`id`, `capaian`, `nama`, `urut`, `deleted`) VALUES
(1, '1', 'Anak mengenal dan percaya kepada Allah Subhanahu wa ta’ala melalui Asmaul ', 1, 0),
(2, '1', 'Anak mengenal dan percaya kepada Allah Subhanahu wa ta’ala melalui ciptaan Nya', 2, 0),
(3, '1', 'Rukun Iman', 1, 0),
(4, '1', 'Rukun Islam', 1, 0),
(5, '1', 'Alquran Sebagai Pedoman Hidup', 1, 0),
(6, '1', 'Al Hadits sebagai pedoman hidup', 1, 0),
(7, '1', 'Doa harian', 1, 0),
(8, '1', 'Kegiatan ibadah (wudhu, adzan, sholat, puasa)', 1, 0),
(9, '1', 'Adab dalam kehidupan sehari-hari (makan, minum, berbicara, berperilaku)', 1, 0),
(10, '1', 'Kalimat Thoyyibah', 1, 0),
(11, '1', 'Menghargai perbedaan', 1, 0),
(12, '1', 'Siroh nabi dan para sahabat', 1, 0),
(13, '1', 'Kosakata bahasa arab secara lisan', 1, 0),
(14, '1', 'Kosakata bahasa arab secara tertulis', 1, 0),
(15, '1', 'Kebersihan diri sebagai bentuk rasa sayang terhadap dirinya dan syukur kepada Alloh Subhanahu wa ta’ala', 1, 0),
(16, '1', 'Menjaga kebersihan lingkungan sebagai bentuk syukur kepada Alloh Subhanahu wa ta’ala', 1, 0),
(17, '1', 'Kesehatan diri sebagai bentuk rasa sayang terhadap dirinya dan syukur kepada Alloh Subhanahu wa ta’ala', 1, 0),
(18, '3', 'Memiliki perilaku yang mencerminkan sikap sabar', 1, 0),
(19, '3', 'Memiliki perilaku yang mencerminkan sikap jujur', 1, 0),
(20, '3', 'Memiliki perilaku yang mencerminkan sikap tanggung jawab', 1, 0),
(21, '3', 'Memiliki perilaku yang mencerminkan sikap estetis', 1, 0),
(22, '3', 'Memiliki perilaku yang mencerminkan sikap percaya diri', 1, 0),
(23, '3', 'Memiliki perilaku yang mencerminkan sikap kerjasama', 1, 0),
(24, '3', 'Mengenal perilaku baik dan santun sebagai cerminan akhlak mulia', 1, 0),
(25, '3', 'Mengenal lingkungan social (keluarga, teman, tempat tinggal, budaya,dll )', 1, 0),
(26, '3', 'Memiliki perilaku yang mencerminkan sikap santun kepada orang tua, pendidik dan teman', 1, 0),
(27, '3', 'Memiliki perilaku yang mencerminkan sikap peduli dan mau membantu jika diminta bantuannya', 1, 0),
(28, '3', 'Memiliki perilaku yang mencerminkan sikap taat terhadap aturan sehari-hari untuk melatih kedisiplinan', 1, 0),
(29, '3', 'Memilik perilaku yang mencerminkaan kemandirian', 1, 0),
(30, '3', 'Motorik Kasar', 1, 0),
(31, '3', 'Motorik Halus dan Taktil', 1, 0),
(32, '4', 'Memilliki perilaku yang mencerminkan sikap ingin tahu', 5, 0),
(33, '4', 'Mengenal berbagai macam sains/percobaan sederhana', 1, 0),
(34, '4', 'Mengetahui cara dan mampu memecahkan masalah sehari- hari', 1, 0),
(35, '4', 'Memahami bahasa ekspresif (mengungkapkan bahasa secara verbal dan non verbal)', 1, 0),
(36, '4', 'Memahami bahasa reseptif (menyimak dan membaca)', 1, 0),
(37, '4', 'Mengenal lambang bilangan', 1, 0),
(38, '4', 'Mengenal huruf latin', 1, 0),
(39, '4', 'Memiliki perilaku yang mencerminkan sikap kreatif', 1, 0),
(40, '4', 'Mengenal dan menghasilkan berbagai karya dan aktivitas seni', 1, 0),
(41, '4', 'Mengenal nama-nama benda di sekitarnya ( ukuran, pola, sifat, suara, tekstur, fungsi dan ciri-ciri lainnya)', 1, 0),
(42, '4', 'Mengenal nama-nama benda di sekitarnya berdasarkan warnanya', 1, 0),
(43, '4', 'Mengenal nama-nama benda di sekitarnya berdasarkan bentuknya', 1, 0),
(44, '4', 'Mengenal nama-nama benda di sekitarnya berdasarkan ukurannya', 1, 0),
(45, '4', 'Mengenal dan menggunakan teknologi sederhana', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_level_desc`
--

CREATE TABLE `user_level_desc` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `ket` varchar(50) NOT NULL DEFAULT '---',
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_level_desc`
--

INSERT INTO `user_level_desc` (`id`, `nama`, `ket`, `deleted`) VALUES
(3, 'Tata Usaha', '', 0),
(4, 'Guru', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_level_list`
--

CREATE TABLE `user_level_list` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_level_list`
--

INSERT INTO `user_level_list` (`id`, `user`, `type`) VALUES
(3, 1, 3),
(4, 6, 4),
(5, 8, 4),
(6, 5, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asesmen_anekdot`
--
ALTER TABLE `asesmen_anekdot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asesmen_checklist`
--
ALTER TABLE `asesmen_checklist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asesmen_fotoberseri`
--
ALTER TABLE `asesmen_fotoberseri`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asesmen_hasilkarya`
--
ALTER TABLE `asesmen_hasilkarya`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `capaian_pembelajaran`
--
ALTER TABLE `capaian_pembelajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guru_kelas`
--
ALTER TABLE `guru_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip_address` (`ip_address`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modul_ajar`
--
ALTER TABLE `modul_ajar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ruang_kelas`
--
ALTER TABLE `ruang_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `santri`
--
ALTER TABLE `santri`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tujuan_pembelajaran`
--
ALTER TABLE `tujuan_pembelajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_level_desc`
--
ALTER TABLE `user_level_desc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_level_list`
--
ALTER TABLE `user_level_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asesmen_anekdot`
--
ALTER TABLE `asesmen_anekdot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `asesmen_checklist`
--
ALTER TABLE `asesmen_checklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `asesmen_fotoberseri`
--
ALTER TABLE `asesmen_fotoberseri`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `asesmen_hasilkarya`
--
ALTER TABLE `asesmen_hasilkarya`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `capaian_pembelajaran`
--
ALTER TABLE `capaian_pembelajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `guru_kelas`
--
ALTER TABLE `guru_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modul_ajar`
--
ALTER TABLE `modul_ajar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ruang_kelas`
--
ALTER TABLE `ruang_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `santri`
--
ALTER TABLE `santri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tujuan_pembelajaran`
--
ALTER TABLE `tujuan_pembelajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `user_level_desc`
--
ALTER TABLE `user_level_desc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_level_list`
--
ALTER TABLE `user_level_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
