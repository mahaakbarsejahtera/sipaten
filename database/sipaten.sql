-- --------------------------------------------------------
-- Host:                         localhost
-- Versi server:                 5.7.24 - MySQL Community Server (GPL)
-- OS Server:                    Win64
-- HeidiSQL Versi:               10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Membuang struktur basisdata untuk internal_pt_maha
CREATE DATABASE IF NOT EXISTS `internal_pt_maha` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `internal_pt_maha`;

-- membuang struktur untuk table internal_pt_maha.anggaran
CREATE TABLE IF NOT EXISTS `anggaran` (
  `id_anggaran` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_permintaan` bigint(20) DEFAULT NULL,
  `approval_teknik` char(50) DEFAULT NULL,
  `approval_pemasaran` char(50) DEFAULT NULL,
  `approval_keuangan` char(50) DEFAULT NULL,
  `anggaran_json` json DEFAULT NULL,
  `anggaran_status` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_anggaran`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.anggaran: ~2 rows (lebih kurang)
/*!40000 ALTER TABLE `anggaran` DISABLE KEYS */;
INSERT IGNORE INTO `anggaran` (`id_anggaran`, `id_permintaan`, `approval_teknik`, `approval_pemasaran`, `approval_keuangan`, `anggaran_json`, `anggaran_status`) VALUES
	(1, 8, '', '', '', NULL, NULL),
	(3, 9, '', '', '', NULL, NULL);
/*!40000 ALTER TABLE `anggaran` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.anggaran_item
CREATE TABLE IF NOT EXISTS `anggaran_item` (
  `id_anggaran_item` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_anggaran` bigint(20) NOT NULL DEFAULT '0',
  `jenis_anggaran` varchar(100) DEFAULT '',
  `anggaran_item` varchar(150) DEFAULT '',
  `anggaran_qty` double DEFAULT NULL,
  `anggaran_unit` varchar(10) DEFAULT '',
  `anggaran_price` double DEFAULT NULL,
  `anggaran_keterangan` text,
  PRIMARY KEY (`id_anggaran_item`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.anggaran_item: ~13 rows (lebih kurang)
/*!40000 ALTER TABLE `anggaran_item` DISABLE KEYS */;
INSERT IGNORE INTO `anggaran_item` (`id_anggaran_item`, `id_anggaran`, `jenis_anggaran`, `anggaran_item`, `anggaran_qty`, `anggaran_unit`, `anggaran_price`, `anggaran_keterangan`) VALUES
	(1, 1, 'boq', 'item 1', 1, 'pc', 30, NULL),
	(2, 1, 'boq', 'item 2', 1, 'pc', 3000000, NULL),
	(4, 1, 'teknik', 'Item 1', 1, 'pc', 30, NULL),
	(8, 1, 'pemasaran', 'item 1', 30, 'pc', 30, NULL),
	(9, 1, 'keuangan', 'item 2', 1, 'pc', 3, NULL),
	(10, 1, 'proyek', 'item 2', 5, 'pc', 30000, NULL),
	(11, 1, 'boq', 'item 5', 2, 'pc', 5000000, NULL),
	(12, 1, 'teknik', 'item 2', 1, 'lot', 2, NULL),
	(13, 1, 'pemasaran', 'item 2', 5, 'pc', 5, NULL),
	(14, 1, 'keuangan', 'item 8', 8, 'pc', 4, NULL),
	(15, 1, 'proyek', 'item 8', 5, 'roll', 50000, NULL),
	(16, 1, 'boq', '', 0, '', 0, NULL),
	(17, 1, 'boq', '', 0, '', 0, NULL);
/*!40000 ALTER TABLE `anggaran_item` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id_customer` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_customer` varchar(10) NOT NULL,
  `nama_customer` varchar(150) DEFAULT NULL,
  `alamat_customer` text,
  `pic_nama_customer` char(75) DEFAULT NULL,
  `pic_no_customer` char(15) DEFAULT NULL,
  PRIMARY KEY (`id_customer`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.customers: ~2 rows (lebih kurang)
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT IGNORE INTO `customers` (`id_customer`, `kode_customer`, `nama_customer`, `alamat_customer`, `pic_nama_customer`, `pic_no_customer`) VALUES
	(2, 'X', 'PT. XXXx', 'JL. STM SUKA TARI', 'BAGAS', '087867894423'),
	(3, 'XA', 'Customer 2 after update', 'Jl. Ileng\r\n', 'Bambang', '087867894423'),
	(4, 'MKD', 'PT Bank Mestika Dharma Tbk.', 'JL. ', '', '');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.divisi
CREATE TABLE IF NOT EXISTS `divisi` (
  `id_divisi` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama_divisi` varchar(75) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_divisi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.divisi: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `divisi` DISABLE KEYS */;
/*!40000 ALTER TABLE `divisi` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.estimasi
CREATE TABLE IF NOT EXISTS `estimasi` (
  `id_estimasi` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_permintaan` bigint(20) NOT NULL DEFAULT '0',
  `estimasi_approve_status` varchar(15) DEFAULT NULL,
  `estimasi_approve_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_estimasi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.estimasi: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `estimasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `estimasi` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.hasil_estimasi
CREATE TABLE IF NOT EXISTS `hasil_estimasi` (
  `id_estimasi_item` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_estimasi` bigint(20) DEFAULT NULL,
  `estimasi_item_name` varchar(150) DEFAULT NULL,
  `estimasi_item_qty` float DEFAULT NULL,
  `estimasi_item_unit` varchar(15) DEFAULT NULL,
  `estimasi_harga_pokok` double DEFAULT NULL,
  `estimasi_harga_jual` double DEFAULT NULL,
  `estimasi_harga_pokok_nego` double DEFAULT NULL,
  `estimasi_harga_jual_nego` double DEFAULT NULL,
  PRIMARY KEY (`id_estimasi_item`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.hasil_estimasi: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `hasil_estimasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `hasil_estimasi` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.hasil_survey
CREATE TABLE IF NOT EXISTS `hasil_survey` (
  `id_survey_item` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_survey` bigint(20) DEFAULT '0',
  `survey_item_name` varchar(150) DEFAULT '',
  `survey_item_qty` float DEFAULT '0',
  `survey_item_unit` varchar(15) DEFAULT '',
  `survey_harga_pokok` double DEFAULT '0',
  `survey_harga_jual` double DEFAULT '0',
  `survey_harga_pokok_nego` double DEFAULT '0',
  `survey_harga_jual_nego` double DEFAULT '0',
  `survey_item_keterangan` text,
  `survey_divisi` varchar(50) DEFAULT '',
  PRIMARY KEY (`id_survey_item`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.hasil_survey: ~18 rows (lebih kurang)
/*!40000 ALTER TABLE `hasil_survey` DISABLE KEYS */;
INSERT IGNORE INTO `hasil_survey` (`id_survey_item`, `id_survey`, `survey_item_name`, `survey_item_qty`, `survey_item_unit`, `survey_harga_pokok`, `survey_harga_jual`, `survey_harga_pokok_nego`, `survey_harga_jual_nego`, `survey_item_keterangan`, `survey_divisi`) VALUES
	(2, 6, 'Bakwan', 3, 'PC', NULL, NULL, NULL, NULL, NULL, NULL),
	(3, 6, 'Tisu', 5, 'PC', NULL, NULL, NULL, NULL, NULL, NULL),
	(9, 4, 'Item Baru', 3, 'PC', 1000, 2000, 0, 0, NULL, 'teknik'),
	(10, 4, 'Item Baru 2', 1, 'Lot', 3000, 3000, 0, 0, NULL, 'teknik'),
	(12, 7, 'jj', 1, 'PC', NULL, NULL, NULL, NULL, NULL, NULL),
	(14, 5, 'wew', 1, '0', 4, 4, 0, 0, NULL, ''),
	(15, 0, 'wew2', 2, '0', 5, 5, 0, 0, NULL, ''),
	(17, 4, 'Item Baru 3', 2, 'Unit', 4000, 5000, 0, 0, NULL, 'teknik'),
	(20, 4, 'Bakwan', 1, 'PC', 5000, 5200, 0, 0, NULL, 'pemasaran'),
	(21, 8, 'Pisang', 3, 'PC', 0, 0, 0, 0, NULL, NULL),
	(22, 8, 'item 1 ', 1, 'PC', 0, 0, 0, 0, NULL, NULL),
	(24, 7, 'item 1 ', 1, 'PC', 0, 0, 0, 0, NULL, 'teknik'),
	(25, 4, 'Item Baru 4', 3, 'PC', 5000, 5500, 0, 0, NULL, 'teknik'),
	(27, 4, 'Item 5', 4, 'PC', 10000, 6000, 0, 0, NULL, 'teknik'),
	(28, 0, 'a', 2, 'ls', 5, 6, 0, 0, NULL, 'teknik'),
	(30, 0, 'c', 8, 'unit', 4, 5, 0, 0, NULL, 'teknik'),
	(31, 0, 'b', 3, 'pcs', 3, 4, 0, 0, NULL, 'teknik');
/*!40000 ALTER TABLE `hasil_survey` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.jenis_pengajuan
CREATE TABLE IF NOT EXISTS `jenis_pengajuan` (
  `id_jenis_pengajuan` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_jenis_pengajuan` char(15) NOT NULL DEFAULT '',
  `nama_jenis_pengajuan` varchar(100) DEFAULT '',
  `jenis_pengajuan_term` text,
  PRIMARY KEY (`id_jenis_pengajuan`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.jenis_pengajuan: ~11 rows (lebih kurang)
/*!40000 ALTER TABLE `jenis_pengajuan` DISABLE KEYS */;
INSERT IGNORE INTO `jenis_pengajuan` (`id_jenis_pengajuan`, `kode_jenis_pengajuan`, `nama_jenis_pengajuan`, `jenis_pengajuan_term`) VALUES
	(23, 'OPP', 'Operasinal Pemasaran', '<p>Atas pengeluaran uang pribadi tersebut diatas, dengan ini mohon penggantian dari perusahaan.</p>'),
	(24, 'ppp', 'Promosi Pemasaran', '<p>Promosi pemasaran</p>'),
	(25, 'ABP', 'Anggaran Bulanan Pemasaran', '<p>-</p>'),
	(26, 'OPT', 'Operasional Proyek Teknik', '<p>-</p>'),
	(28, 'MJT', 'Material Jasa', '<p>-</p>'),
	(30, 'PPPT', 'Perlengkapan Peralatan Proyek', ''),
	(32, 'KMP', 'Komisi Sales', ''),
	(33, 'AKK', 'Anggaran Keuangan', ''),
	(34, 'PKK', 'Perlengkapan Kantor', ''),
	(35, 'PPK', 'Pembayaran Pajak', ''),
	(36, 'OK', 'Operasinal Keuangan', '');
/*!40000 ALTER TABLE `jenis_pengajuan` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.negosiasi
CREATE TABLE IF NOT EXISTS `negosiasi` (
  `id_nego` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_permintaan` bigint(20) DEFAULT '0',
  `nego_no` varchar(75) DEFAULT '',
  `nego_tgl_surat` date,
  `nego_lokasi` varchar(75) DEFAULT '',
  `nego_term` text,
  `nego_pic_nama` text,
  `nego_pic_jabatan` text,
  `date_created` datetime DEFAULT NULL,
  `latest_edit` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_nego`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.negosiasi: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `negosiasi` DISABLE KEYS */;
INSERT IGNORE INTO `negosiasi` (`id_nego`, `id_permintaan`, `nego_no`, `nego_tgl_surat`, `nego_lokasi`, `nego_term`, `nego_pic_nama`, `nego_pic_jabatan`, `date_created`, `latest_edit`) VALUES
	(4, 8, 'HK/01/01/01', '2020-08-26', 'Medan', '<p>test</p>', 'Bambang Hendrato:Manager Project, Imam Samudra:Purchasing', '', NULL, '2020-08-26 09:36:19');
/*!40000 ALTER TABLE `negosiasi` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.penanggung_jawab
CREATE TABLE IF NOT EXISTS `penanggung_jawab` (
  `id_penanggung_jawab` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_jenis_pengajuan` bigint(20) DEFAULT '0',
  `penanggung_jawab_user` bigint(20) DEFAULT '0',
  `sebagai_penanggung_jawab` varchar(50) DEFAULT '',
  `urutan_penanggung_jawab` int(3) DEFAULT '0',
  PRIMARY KEY (`id_penanggung_jawab`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.penanggung_jawab: ~42 rows (lebih kurang)
/*!40000 ALTER TABLE `penanggung_jawab` DISABLE KEYS */;
INSERT IGNORE INTO `penanggung_jawab` (`id_penanggung_jawab`, `id_jenis_pengajuan`, `penanggung_jawab_user`, `sebagai_penanggung_jawab`, `urutan_penanggung_jawab`) VALUES
	(1, 16, 6, 'Di Periksa', 0),
	(2, 20, 5, 'Di Periksa', 1),
	(3, 20, 5, 'Di Periksa', 2),
	(4, 20, 5, 'Di Periksa', 3),
	(5, 20, 5, 'Di Periksa', 4),
	(6, 20, 5, 'Di Periksa', 5),
	(7, 20, 5, 'Di Periksa', 6),
	(8, 20, 5, 'Di Periksa', 7),
	(9, 20, 5, 'Di Periksa', 8),
	(10, 21, 5, 'Di Periksa', 1),
	(14, 22, 5, 'Di Periksa', 1),
	(15, 22, 6, 'Di Periksa', 2),
	(16, 1, 7, 'Di Periksa', 1),
	(17, 23, 5, 'Di Periksa', 1),
	(18, 24, 6, 'Di Ketahui', 1),
	(19, 24, 7, 'Di Ketahui', 2),
	(20, 24, 5, 'Di Periksa', 3),
	(21, 0, 5, 'Di Periksa', 1),
	(22, 0, 6, 'Di Periksa', 2),
	(23, 0, 7, 'Di Ketahui', 3),
	(24, 25, 5, 'Di Periksa', 1),
	(25, 25, 6, 'Di Periksa', 2),
	(26, 25, 7, 'Di Ketahui', 3),
	(27, 26, 5, 'Di Ketahui', 1),
	(28, 26, 6, 'Di Periksa', 2),
	(29, 26, 7, 'Di Ketahui', 3),
	(30, 28, 5, 'Di Periksa', 1),
	(31, 28, 6, 'Di Periksa', 2),
	(32, 30, 5, 'Di Periksa', 1),
	(33, 30, 6, 'Di Periksa', 2),
	(34, 30, 7, 'Di Ketahui', 3),
	(35, 32, 5, 'Di Periksa', 1),
	(36, 32, 6, 'Di Periksa', 2),
	(37, 32, 7, 'Di Ketahui', 3),
	(38, 33, 5, 'Di Periksa', 1),
	(39, 33, 6, 'Di Periksa', 2),
	(40, 33, 7, 'Di Ketahui', 3),
	(41, 34, 5, 'Di Periksa', 1),
	(42, 34, 6, 'Di Periksa', 2),
	(43, 35, 5, 'Di Periksa', 1),
	(44, 35, 6, 'Di Periksa', 2),
	(45, 36, 5, 'Di Periksa', 1);
/*!40000 ALTER TABLE `penanggung_jawab` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.penawaran
CREATE TABLE IF NOT EXISTS `penawaran` (
  `id_penawaran` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_permintaan` bigint(20) NOT NULL DEFAULT '0',
  `penawaran_no` varchar(100) DEFAULT '',
  `penawaran_due_date` date DEFAULT NULL,
  `penawaran_validasi_date` date DEFAULT NULL,
  `penawaran_term` text,
  PRIMARY KEY (`id_penawaran`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.penawaran: ~2 rows (lebih kurang)
/*!40000 ALTER TABLE `penawaran` DISABLE KEYS */;
INSERT IGNORE INTO `penawaran` (`id_penawaran`, `id_permintaan`, `penawaran_no`, `penawaran_due_date`, `penawaran_validasi_date`, `penawaran_term`) VALUES
	(8, 8, '001\n/PN/0/MKD/VIII/2020', '2020-08-29', '2020-08-21', '<ol style="box-sizing: border-box; margin-top: 0px; margin-bottom: 1rem; color: #212529; font-family: \'Source Sans Pro\', -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; font-size: 16px; background-color: #ffffff;">\n<li style="box-sizing: border-box;">pekerjaan di medan - binjai</li>\n<li style="box-sizing: border-box;">syarat pembayaran&nbsp;<br style="box-sizing: border-box;" />\n<ul style="box-sizing: border-box; margin-top: 0px; margin-bottom: 0px;">\n<li style="box-sizing: border-box;">50% DP</li>\n<li style="box-sizing: border-box;">50% Selesai berita acara</li>\n</ul>\n</li>\n<li style="box-sizing: border-box;">Harga sudah termasuk P</li>\n</ol>'),
	(9, 9, '002\n/PN/0/XA/VIII/2020', '2020-08-29', '2020-08-20', '<ol style="box-sizing: border-box; margin-top: 0px; margin-bottom: 1rem; color: #212529; font-family: \'Source Sans Pro\', -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; font-size: 16px; background-color: #ffffff;">\n<li style="box-sizing: border-box;">pekerjaan di medan - binjai</li>\n<li style="box-sizing: border-box;">syarat pembayaran&nbsp;<br style="box-sizing: border-box;" />\n<ul style="box-sizing: border-box; margin-top: 0px; margin-bottom: 0px;">\n<li style="box-sizing: border-box;">50% DP</li>\n<li style="box-sizing: border-box;">50% Selesai berita acara</li>\n</ul>\n</li>\n<li style="box-sizing: border-box;">Harga sudah termasuk P</li>\n</ol>');
/*!40000 ALTER TABLE `penawaran` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.pengajuan_internal
CREATE TABLE IF NOT EXISTS `pengajuan_internal` (
  `id_pengajuan_internal` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_jenis_pengajuan` bigint(20) DEFAULT '0',
  `id_pengaju` bigint(20) NOT NULL DEFAULT '0',
  `perihal_pengajuan_internal` varchar(150) DEFAULT '',
  `no_surat_pengajuan_internal` varchar(50) DEFAULT '',
  `tanggal_pengajuan_internal` date DEFAULT NULL,
  `due_date_pengajuan_internal` date DEFAULT NULL,
  PRIMARY KEY (`id_pengajuan_internal`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.pengajuan_internal: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `pengajuan_internal` DISABLE KEYS */;
INSERT IGNORE INTO `pengajuan_internal` (`id_pengajuan_internal`, `id_jenis_pengajuan`, `id_pengaju`, `perihal_pengajuan_internal`, `no_surat_pengajuan_internal`, `tanggal_pengajuan_internal`, `due_date_pengajuan_internal`) VALUES
	(1, 23, 5, 'Pengajuan X', '01/OPP/VIII/2020', '2020-08-29', '2020-09-12');
/*!40000 ALTER TABLE `pengajuan_internal` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.pengajuan_internal_item
CREATE TABLE IF NOT EXISTS `pengajuan_internal_item` (
  `id_pengajuan_internal_item` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_pengajuan_internal` bigint(20) DEFAULT '0',
  `pengajuan_internal_name` varchar(100) DEFAULT '',
  `pengajuan_internal_desc` text,
  `pengajuan_internal_qty` float DEFAULT '0',
  `pengajuan_internal_keterangan` text,
  `pengajuan_internal_unit` varchar(15) DEFAULT '',
  `pengajuan_internal_price` double DEFAULT '0',
  PRIMARY KEY (`id_pengajuan_internal_item`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.pengajuan_internal_item: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `pengajuan_internal_item` DISABLE KEYS */;
INSERT IGNORE INTO `pengajuan_internal_item` (`id_pengajuan_internal_item`, `id_pengajuan_internal`, `pengajuan_internal_name`, `pengajuan_internal_desc`, `pengajuan_internal_qty`, `pengajuan_internal_keterangan`, `pengajuan_internal_unit`, `pengajuan_internal_price`) VALUES
	(1, 1, 'Item 1', '', 3, 'Keterangan Item 1', 'PC', 1500000);
/*!40000 ALTER TABLE `pengajuan_internal_item` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.pengajuan_item_meta
CREATE TABLE IF NOT EXISTS `pengajuan_item_meta` (
  `id_pengajuan_meta` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_pengajuan` bigint(20) NOT NULL DEFAULT '0',
  `pengajuan_meta_key` varchar(75) DEFAULT '',
  `pengajuan_meta_value` text,
  PRIMARY KEY (`id_pengajuan_meta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.pengajuan_item_meta: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `pengajuan_item_meta` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengajuan_item_meta` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.pengajuan_proyek
CREATE TABLE IF NOT EXISTS `pengajuan_proyek` (
  `id_pengajuan_proyek` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_pengaju` bigint(20) NOT NULL DEFAULT '0',
  `id_anggaran` bigint(20) DEFAULT '0',
  `id_jenis_pengajuan` bigint(20) DEFAULT '0',
  `perihal_pengajuan_proyek` varchar(150) DEFAULT '',
  `no_surat_pengajuan_proyek` varchar(50) DEFAULT '',
  `tanggal_pengajuan_proyek` date DEFAULT NULL,
  `due_date_pengajuan_proyek` date DEFAULT NULL,
  PRIMARY KEY (`id_pengajuan_proyek`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.pengajuan_proyek: ~1 rows (lebih kurang)
/*!40000 ALTER TABLE `pengajuan_proyek` DISABLE KEYS */;
INSERT IGNORE INTO `pengajuan_proyek` (`id_pengajuan_proyek`, `id_pengaju`, `id_anggaran`, `id_jenis_pengajuan`, `perihal_pengajuan_proyek`, `no_surat_pengajuan_proyek`, `tanggal_pengajuan_proyek`, `due_date_pengajuan_proyek`) VALUES
	(9, 6, 1, 23, 'Perihal 1', '01/PBB/VIII/2020', '2020-08-28', '2020-09-11'),
	(10, 6, 1, 24, 'Perihal 2', '01/PBBP/VIII/2020', '2020-08-28', '2020-09-11');
/*!40000 ALTER TABLE `pengajuan_proyek` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.pengajuan_proyek_item
CREATE TABLE IF NOT EXISTS `pengajuan_proyek_item` (
  `id_pengajuan_proyek_item` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_pengajuan_proyek` bigint(20) NOT NULL DEFAULT '0',
  `pengajuan_proyek_name` varchar(100) DEFAULT '',
  `pengajuan_proyek_desc` text,
  `pengajuan_proyek_qty` float DEFAULT '0',
  `pengajuan_proyek_unit` varchar(15) DEFAULT '',
  `pengajuan_proyek_price` double DEFAULT '0',
  `pengajuan_proyek_keterangan` text,
  PRIMARY KEY (`id_pengajuan_proyek_item`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.pengajuan_proyek_item: ~2 rows (lebih kurang)
/*!40000 ALTER TABLE `pengajuan_proyek_item` DISABLE KEYS */;
INSERT IGNORE INTO `pengajuan_proyek_item` (`id_pengajuan_proyek_item`, `id_pengajuan_proyek`, `pengajuan_proyek_name`, `pengajuan_proyek_desc`, `pengajuan_proyek_qty`, `pengajuan_proyek_unit`, `pengajuan_proyek_price`, `pengajuan_proyek_keterangan`) VALUES
	(2, 9, 'Item2', 'ini item 2', 3, 'PC', 1000000, 'keterangan item 2'),
	(3, 9, 'item 3', 'item 3', 5, 'PC', 30000, 'ini keterangan item 3'),
	(4, 10, 'ITEM 1', '', 1, 'PC', 10000, '');
/*!40000 ALTER TABLE `pengajuan_proyek_item` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.permintaan
CREATE TABLE IF NOT EXISTS `permintaan` (
  `id_permintaan` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_customer` bigint(20) NOT NULL DEFAULT '0',
  `id_pic` bigint(20) NOT NULL DEFAULT '0',
  `no_permintaan` varchar(100) DEFAULT NULL,
  `nama_pekerjaan` varchar(100) DEFAULT '',
  `keterangan_pekerjaan` text,
  `no_survey` varchar(100) DEFAULT '',
  `no_kontrak` varchar(100) DEFAULT '',
  `permintaan_status` varchar(15) DEFAULT '',
  `permintaan_sales` bigint(20) DEFAULT '0',
  `permintaan_lokasi_survey` text,
  `permintaan_jadwal_survey` date DEFAULT NULL,
  `permintaan_approval` varchar(15) DEFAULT NULL,
  `approve_by` bigint(20) DEFAULT NULL,
  `date_create` date DEFAULT NULL,
  `permintaan_supervisi_status` varchar(15) DEFAULT 'Draft',
  `permintaan_supervisi` bigint(20) DEFAULT '0',
  `permintaan_hasil_survey_status` varchar(15) DEFAULT 'Draft',
  `permintaan_nego_nama` varchar(100) DEFAULT '',
  `permintaan_nego_jabatan` varchar(100) DEFAULT '',
  `permintaan_nego` char(1) DEFAULT '',
  `permintaan_kontrak` char(1) DEFAULT '',
  PRIMARY KEY (`id_permintaan`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.permintaan: ~2 rows (lebih kurang)
/*!40000 ALTER TABLE `permintaan` DISABLE KEYS */;
INSERT IGNORE INTO `permintaan` (`id_permintaan`, `id_customer`, `id_pic`, `no_permintaan`, `nama_pekerjaan`, `keterangan_pekerjaan`, `no_survey`, `no_kontrak`, `permintaan_status`, `permintaan_sales`, `permintaan_lokasi_survey`, `permintaan_jadwal_survey`, `permintaan_approval`, `approve_by`, `date_create`, `permintaan_supervisi_status`, `permintaan_supervisi`, `permintaan_hasil_survey_status`, `permintaan_nego_nama`, `permintaan_nego_jabatan`, `permintaan_nego`, `permintaan_kontrak`) VALUES
	(8, 4, 1, '', 'PEKERJAAN 1', 'WEW', '', '', 'Publish', 5, 'MEDAN', '2020-08-22', NULL, NULL, '2020-08-25', NULL, NULL, 'Accept', 'Draft', 'Draft', 'N', 'N'),
	(9, 3, 0, '', 'Baru', 'Test', '', '', 'Publish', 6, 'Medan', '2020-08-18', NULL, NULL, '2020-08-25', 'Accept', 7, 'Accept', 'Draft', 'Draft', 'Y', 'Y');
/*!40000 ALTER TABLE `permintaan` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.permintaan_file
CREATE TABLE IF NOT EXISTS `permintaan_file` (
  `id_file` bigint(20) NOT NULL DEFAULT '0',
  `id_permintaan` bigint(20) NOT NULL DEFAULT '0',
  `nama_file` varchar(50) DEFAULT NULL,
  `lokasi_file` text,
  PRIMARY KEY (`id_file`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.permintaan_file: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `permintaan_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `permintaan_file` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.permintaan_item
CREATE TABLE IF NOT EXISTS `permintaan_item` (
  `id_item` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_permintaan` bigint(20) DEFAULT '0',
  `item_name` varchar(150) DEFAULT '',
  `item_keterangan` varchar(100) DEFAULT '',
  `item_qty` double DEFAULT '0',
  `item_unit` varchar(15) DEFAULT '',
  `item_hp` double DEFAULT '0',
  `item_hj` double DEFAULT '0',
  `item_hp_nego` double DEFAULT '0',
  `item_hj_nego` double DEFAULT '0',
  `item_divisi` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.permintaan_item: ~8 rows (lebih kurang)
/*!40000 ALTER TABLE `permintaan_item` DISABLE KEYS */;
INSERT IGNORE INTO `permintaan_item` (`id_item`, `id_permintaan`, `item_name`, `item_keterangan`, `item_qty`, `item_unit`, `item_hp`, `item_hj`, `item_hp_nego`, `item_hj_nego`, `item_divisi`) VALUES
	(6, 8, 'item 1 ', '0', 1, 'PC', 3000, 50006, 0, 45000, NULL),
	(8, 8, 'ITEM 3', '', 5, 'PC', 4000, 6000, 0, 3000, NULL),
	(9, 8, 'ITEM 4', '', 5, 'PC', 2000, 2500, 0, 2100, NULL),
	(10, 9, 'Pekerjaan baru item baru', '', 3, 'pc', 0, 0, 0, 2, NULL),
	(11, 9, 'perkjaan baru item baru 2', '', 4, 'lot', 0, 0, 0, 3, NULL),
	(12, 8, 'ITEM 5', '', 2, 'Set', 10000, 11000, 0, 10500, NULL),
	(13, 8, 'ITEM 6', '', 7, 'Set', 4000, 4500, 0, 4100, NULL),
	(14, 8, 'Aksesories (Kabel ties, lakban, Rubber tape, stainless steel wire support)', '', 10, 'set', 2000, 2500, 0, 2100, NULL);
/*!40000 ALTER TABLE `permintaan_item` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.pic
CREATE TABLE IF NOT EXISTS `pic` (
  `id_pic` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_customer` bigint(20) DEFAULT '0',
  `nama_pic` varchar(75) DEFAULT '-',
  `divisi_pic` varchar(150) DEFAULT '-',
  `jabatan_pic` varchar(150) DEFAULT '-',
  `kontak_pic` varchar(15) DEFAULT '-',
  PRIMARY KEY (`id_pic`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.pic: ~2 rows (lebih kurang)
/*!40000 ALTER TABLE `pic` DISABLE KEYS */;
INSERT IGNORE INTO `pic` (`id_pic`, `id_customer`, `nama_pic`, `divisi_pic`, `jabatan_pic`, `kontak_pic`) VALUES
	(1, 4, 'Bambang', 'nama divisi', 'nama divisi', '087867894423'),
	(3, 4, 'Bambang 2', 'nama divisi 2', 'nama jabatan 2', '087867894423');
/*!40000 ALTER TABLE `pic` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id_role` bigint(20) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(75) NOT NULL DEFAULT '',
  `role_desc` text NOT NULL,
  `role_cap` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.roles: ~7 rows (lebih kurang)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT IGNORE INTO `roles` (`id_role`, `role_name`, `role_desc`, `role_cap`) VALUES
	(1, 'Administrator', 'role dengan level tertinggi', 99),
	(14, 'Keuangan', 'roles keuangan', 75),
	(15, 'Pemasaran', 'Roles Pemasaran', 75),
	(16, 'Teknik', 'Role Tekniks', 75),
	(17, 'Wew', 'Wew', 50),
	(18, 'Direktur', 'direktur', 95),
	(19, 'Manager Teknik', '', 90),
	(20, 'Manager Keuangan', '', 90);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.survey
CREATE TABLE IF NOT EXISTS `survey` (
  `id_survey` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_permintaan` bigint(20) DEFAULT '0',
  `survey_approve_status` varchar(15) DEFAULT NULL,
  `survey_approve_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_survey`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.survey: ~5 rows (lebih kurang)
/*!40000 ALTER TABLE `survey` DISABLE KEYS */;
INSERT IGNORE INTO `survey` (`id_survey`, `id_permintaan`, `survey_approve_status`, `survey_approve_by`) VALUES
	(4, 4, NULL, NULL),
	(5, 5, NULL, NULL),
	(6, 6, NULL, NULL),
	(7, 5, NULL, NULL),
	(8, 7, NULL, NULL);
/*!40000 ALTER TABLE `survey` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.timeline
CREATE TABLE IF NOT EXISTS `timeline` (
  `id_timeline` int(11) NOT NULL AUTO_INCREMENT,
  `id_permintaan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_timeline`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.timeline: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `timeline` DISABLE KEYS */;
/*!40000 ALTER TABLE `timeline` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.timeline_item
CREATE TABLE IF NOT EXISTS `timeline_item` (
  `id_timeline_item` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_timeline` bigint(20) DEFAULT NULL,
  `timeline_activity` varchar(150) DEFAULT NULL,
  `timeline_time` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_timeline_item`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.timeline_item: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `timeline_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `timeline_item` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.users
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_divisi` bigint(20) NOT NULL DEFAULT '0',
  `user_role` bigint(20) DEFAULT NULL,
  `user_code` varchar(10) NOT NULL DEFAULT '0',
  `user_name` varchar(75) DEFAULT NULL,
  `user_fullname` varchar(150) DEFAULT NULL,
  `user_pass` char(32) DEFAULT NULL,
  `user_email` varchar(150) DEFAULT NULL,
  `user_status` varchar(15) DEFAULT NULL,
  `user_image` text,
  `create_date` date DEFAULT NULL,
  `latest_update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.users: ~3 rows (lebih kurang)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT IGNORE INTO `users` (`id_user`, `user_divisi`, `user_role`, `user_code`, `user_name`, `user_fullname`, `user_pass`, `user_email`, `user_status`, `user_image`, `create_date`, `latest_update`) VALUES
	(5, 0, 1, '0', 'anonim1', 'anonim1', '3847820138564525205299f1f444c5ec', 'anonim1@gmail.com', 'Suspend', '1597212041_fd59edd9cab78e43edf9.png', NULL, NULL),
	(6, 0, 14, '0', 'anonim2', 'Bambang Widjayanto', '126fbdc6ce3047fea1f8f6d65144e4fc', 'bambang@gmail.com', 'Active', '1597220648_71591cbb5668645eb80e.jpeg', NULL, NULL),
	(7, 0, 16, '0', 'ibnu', 'ibnu', '126fbdc6ce3047fea1f8f6d65144e4fc', 'ibnu@gmail.com', 'Active', '1597473165_7b6332b5eca3d3a853c4.png', NULL, NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
