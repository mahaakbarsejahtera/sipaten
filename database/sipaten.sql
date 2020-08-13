


-- Membuang struktur basisdata untuk internal_pt_maha
DROP DATABASE IF EXISTS `internal_pt_maha`;
CREATE DATABASE IF NOT EXISTS `internal_pt_maha` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `internal_pt_maha`;

-- membuang struktur untuk table internal_pt_maha.anggaran
DROP TABLE IF EXISTS `anggaran`;
CREATE TABLE IF NOT EXISTS `anggaran` (
  `id_anggaran` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_permintaan` bigint(20) DEFAULT NULL,
  `approval_teknik` char(50) DEFAULT NULL,
  `approval_pemasaran` char(50) DEFAULT NULL,
  `approval_keuangan` char(50) DEFAULT NULL,
  PRIMARY KEY (`id_anggaran`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.anggaran: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `anggaran` DISABLE KEYS */;
/*!40000 ALTER TABLE `anggaran` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.estimasi
DROP TABLE IF EXISTS `estimasi`;
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
DROP TABLE IF EXISTS `hasil_estimasi`;
CREATE TABLE IF NOT EXISTS `hasil_estimasi` (
  `id_estimasi_item` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_estimasi` bigint(20) DEFAULT NULL,
  `estimasi_item_name` varchar(150) DEFAULT NULL,
  `estimasi_item_qty` float DEFAULT NULL,
  `estimasi_item_unit` varchar(15) DEFAULT NULL,
  `estimasi_harga_pokok` double DEFAULT NULL,
  `estimasi_harga_jual` double DEFAULT NULL,
  `estimas_harga_pokok_nego` double DEFAULT NULL,
  `estimasi_harga_jual_nego` double DEFAULT NULL,
  PRIMARY KEY (`id_estimasi_item`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.hasil_estimasi: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `hasil_estimasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `hasil_estimasi` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.hasil_survey
DROP TABLE IF EXISTS `hasil_survey`;
CREATE TABLE IF NOT EXISTS `hasil_survey` (
  `id_suvery_item` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_survey` bigint(20) DEFAULT NULL,
  `survey_item_name` varchar(150) DEFAULT NULL,
  `survey_item_qty` float DEFAULT NULL,
  `survey_item_unit` varchar(15) DEFAULT NULL,
  `survey_harga_pokok` double DEFAULT NULL,
  `survey_harga_jual` double DEFAULT NULL,
  `survey_harga_pokok_nego` double DEFAULT NULL,
  `survey_harga_jual_nego` double DEFAULT NULL,
  PRIMARY KEY (`id_suvery_item`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.hasil_survey: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `hasil_survey` DISABLE KEYS */;
/*!40000 ALTER TABLE `hasil_survey` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.jenis_pengajuan
DROP TABLE IF EXISTS `jenis_pengajuan`;
CREATE TABLE IF NOT EXISTS `jenis_pengajuan` (
  `id_jenis_pengajuan` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama_jenis_pengajuan` varchar(100) DEFAULT '',
  PRIMARY KEY (`id_jenis_pengajuan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.jenis_pengajuan: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `jenis_pengajuan` DISABLE KEYS */;
/*!40000 ALTER TABLE `jenis_pengajuan` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.pengajuan
DROP TABLE IF EXISTS `pengajuan`;
CREATE TABLE IF NOT EXISTS `pengajuan` (
  `id_pengajuan` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_anggaran` bigint(20) DEFAULT NULL,
  `id_jenis_pengajuan` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_pengajuan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.pengajuan: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `pengajuan` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengajuan` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.pengajuan_item
DROP TABLE IF EXISTS `pengajuan_item`;
CREATE TABLE IF NOT EXISTS `pengajuan_item` (
  `id_pengajuan` bigint(20) NOT NULL DEFAULT '0',
  `pengajuan_item` varchar(100) DEFAULT NULL,
  `pengajuan_qty` float DEFAULT NULL,
  `pengajuan_unit` varchar(15) DEFAULT NULL,
  `pengajuan_price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.pengajuan_item: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `pengajuan_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengajuan_item` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.permintaan
DROP TABLE IF EXISTS `permintaan`;
CREATE TABLE IF NOT EXISTS `permintaan` (
  `id_permintaan` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_permintaan` varchar(100) DEFAULT NULL,
  `nama_pekerjaan` varchar(100) DEFAULT NULL,
  `no_survey` varchar(100) DEFAULT NULL,
  `no_kontrak` varchar(100) DEFAULT NULL,
  `permintaan_status` varchar(15) DEFAULT NULL,
  `permintaan_user` bigint(20) DEFAULT NULL,
  `permintaan_lokasi_survey` text,
  `permintaan_jadwal_survey` date DEFAULT NULL,
  `permintaan_approval` varchar(15) DEFAULT NULL,
  `approve_by` bigint(20) DEFAULT NULL,
  `date_create` date DEFAULT NULL,
  PRIMARY KEY (`id_permintaan`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.permintaan: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `permintaan` DISABLE KEYS */;
INSERT IGNORE INTO `permintaan` (`id_permintaan`, `no_permintaan`, `nama_pekerjaan`, `no_survey`, `no_kontrak`, `permintaan_status`, `permintaan_user`, `permintaan_lokasi_survey`, `permintaan_jadwal_survey`, `permintaan_approval`, `approve_by`, `date_create`) VALUES
	(4, NULL, 'Pekerjaan 1', NULL, NULL, 'Draft', 5, 'Medan', '2020-08-12', NULL, NULL, '2020-08-12'),
	(5, NULL, 'Pekerjaan 2', NULL, NULL, 'Kontrak', 6, 'Medan', '2020-08-05', NULL, NULL, '2020-08-12'),
	(6, NULL, 'Pekerjaan 3', NULL, NULL, 'Publish', 6, 'Jakarta', '2020-08-12', NULL, NULL, '2020-08-12');
/*!40000 ALTER TABLE `permintaan` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.permintaan_file
DROP TABLE IF EXISTS `permintaan_file`;
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

-- membuang struktur untuk table internal_pt_maha.roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id_role` bigint(20) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(75) NOT NULL DEFAULT '',
  `role_desc` text NOT NULL,
  `role_cap` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.roles: ~5 rows (lebih kurang)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT IGNORE INTO `roles` (`id_role`, `role_name`, `role_desc`, `role_cap`) VALUES
	(1, 'Administrator', 'role dengan level tertinggi', 90),
	(14, 'Keuangan', 'roles keuangan', 75),
	(15, 'Pemasaran', 'Roles Pemasaran', 75),
	(16, 'Teknik', 'Role Tekniks', 75);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.survey
DROP TABLE IF EXISTS `survey`;
CREATE TABLE IF NOT EXISTS `survey` (
  `id_survey` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_permintaan` int(11) DEFAULT NULL,
  `survey_user` int(11) DEFAULT NULL,
  `survey_approve_status` varchar(15) DEFAULT NULL,
  `survey_approve_by` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_survey`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.survey: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `survey` DISABLE KEYS */;
/*!40000 ALTER TABLE `survey` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.timeline
DROP TABLE IF EXISTS `timeline`;
CREATE TABLE IF NOT EXISTS `timeline` (
  `id_timeline` int(11) NOT NULL AUTO_INCREMENT,
  `id_permintaan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_timeline`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.timeline: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `timeline` DISABLE KEYS */;
/*!40000 ALTER TABLE `timeline` ENABLE KEYS */;

-- membuang struktur untuk table internal_pt_maha.timeline_item
DROP TABLE IF EXISTS `timeline_item`;
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
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_role` bigint(20) DEFAULT NULL,
  `user_name` varchar(75) DEFAULT NULL,
  `user_fullname` varchar(150) DEFAULT NULL,
  `user_pass` char(32) DEFAULT NULL,
  `user_email` varchar(150) DEFAULT NULL,
  `user_status` varchar(15) DEFAULT NULL,
  `user_image` text,
  `create_date` date DEFAULT NULL,
  `latest_update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`)
<<<<<<< HEAD
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
=======
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel internal_pt_maha.users: ~2 rows (lebih kurang)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT IGNORE INTO `users` (`id_user`, `user_role`, `user_name`, `user_fullname`, `user_pass`, `user_email`, `user_status`, `user_image`, `create_date`, `latest_update`) VALUES
	(5, 1, 'anonim1', 'anonim1', '3847820138564525205299f1f444c5ec', 'anonim1@gmail.com', 'Suspend', '1597212041_fd59edd9cab78e43edf9.png', NULL, NULL),
	(6, 14, 'anonim2', 'Bambang Widjayanto', '126fbdc6ce3047fea1f8f6d65144e4fc', 'bambang@gmail.com', 'Active', '1597220648_71591cbb5668645eb80e.jpeg', NULL, NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
>>>>>>> f4c1f783aa74075116e74f2ebf344efb0e17d758
