/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE IF NOT EXISTS `briknow` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `briknow`;

CREATE TABLE IF NOT EXISTS `achievements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `badge` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_id` bigint(20) unsigned NOT NULL,
  `value` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `achievements` DISABLE KEYS */;
INSERT INTO `achievements` (`id`, `name`, `badge`, `activity_id`, `value`, `created_at`, `updated_at`) VALUES
	(1, 'Unyielding Hero', 'assets\\img\\achievement_badges\\003-unyielding-soldier.png', 1, 5, '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(2, 'Bravely Knight', 'assets\\img\\achievement_badges\\002-bravely-knight.png', 1, 15, '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(3, 'Prime Hero', 'assets\\img\\achievement_badges\\001-prime-hero.png', 1, 30, '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(4, 'The Appraiser', 'assets\\img\\achievement_badges\\006-the-appraiser.png', 2, 5, '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(5, 'The Investigator', 'assets\\img\\achievement_badges\\005-the-investigator.png', 2, 15, '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(6, 'The True Auditor', 'assets\\img\\achievement_badges\\004-the-true-auditor.png', 2, 30, '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(7, 'Attention Seeker', 'assets\\img\\achievement_badges\\009-attention-seeker.png', 8, 100, '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(8, 'The Rising Star', 'assets\\img\\achievement_badges\\008-the-rising-star.png', 8, 500, '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(9, 'Glorious Artist', 'assets\\img\\achievement_badges\\007-glorious-artist.png', 8, 1000, '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(10, 'The Diligent', 'assets\\img\\achievement_badges\\011-the-deligent.png', 6, 7, '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(11, 'The Dedicated', 'assets\\img\\achievement_badges\\010-the-dedicated.png', 6, 30, '2022-08-11 15:29:36', '2022-08-11 15:29:36');
/*!40000 ALTER TABLE `achievements` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `xp` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
INSERT INTO `activities` (`id`, `name`, `xp`, `created_at`, `updated_at`) VALUES
	(1, 'Membuat halaman proyek', 15, '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(2, 'Proyek telah terpublish', 10, '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(3, 'Membuat postingan forum', 5, '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(4, 'Memberikan komentar di sebuah proyek', 3, '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(5, 'Memberikan komentar di sebuah postingan forum', 3, '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(6, 'Login Harian', 2, '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(7, 'Mendapatkan Sebuah Achievement', 10, '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(8, 'Mengunjungi Proyek', 2, '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(9, 'Mengunjungi Forum', 2, '2022-08-11 15:29:36', '2022-08-11 15:29:36');
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `activity_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `activity_id` bigint(20) unsigned NOT NULL,
  `personal_number` bigint(20) unsigned NOT NULL,
  `xp_before` int(11) NOT NULL,
  `xp_after` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `activity_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_users` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `avatars` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `level_id` bigint(20) unsigned NOT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `avatars` DISABLE KEYS */;
INSERT INTO `avatars` (`id`, `level_id`, `path`, `created_at`, `updated_at`) VALUES
	(1, 1, 'assets/img/gamification/avatar/avatar 1.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(2, 1, 'assets/img/gamification/avatar/avatar 2.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(3, 1, 'assets/img/gamification/avatar/avatar 3.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(4, 1, 'assets/img/gamification/avatar/avatar 4.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(5, 2, 'assets/img/gamification/avatar/avatar 5.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(6, 2, 'assets/img/gamification/avatar/avatar 6.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(7, 2, 'assets/img/gamification/avatar/avatar 7.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(8, 2, 'assets/img/gamification/avatar/avatar 8.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(9, 2, 'assets/img/gamification/avatar/avatar 9.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(10, 2, 'assets/img/gamification/avatar/avatar 10.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(11, 3, 'assets/img/gamification/avatar/avatar 11.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(12, 3, 'assets/img/gamification/avatar/avatar 12.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(13, 3, 'assets/img/gamification/avatar/avatar 13.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(14, 3, 'assets/img/gamification/avatar/avatar 14.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(15, 3, 'assets/img/gamification/avatar/avatar 15.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(16, 3, 'assets/img/gamification/avatar/avatar 16.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(17, 4, 'assets/img/gamification/avatar/avatar 17.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(18, 4, 'assets/img/gamification/avatar/avatar 18.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(19, 4, 'assets/img/gamification/avatar/avatar 19.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(20, 4, 'assets/img/gamification/avatar/avatar 20.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(21, 4, 'assets/img/gamification/avatar/avatar 21.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(22, 4, 'assets/img/gamification/avatar/avatar 22.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36');
/*!40000 ALTER TABLE `avatars` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) DEFAULT NULL,
  `project_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `replyto_user_id` bigint(20) DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `communication_initiative` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_file` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_maker` int(11) NOT NULL,
  `is_recommend` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `approve_at` datetime DEFAULT NULL,
  `approve_by` int(11) DEFAULT NULL,
  `publish_at` datetime DEFAULT NULL,
  `publish_by` int(11) DEFAULT NULL,
  `unpublish_at` datetime DEFAULT NULL,
  `unpublish_by` int(11) DEFAULT NULL,
  `reject_at` datetime DEFAULT NULL,
  `reject_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `communication_initiative` DISABLE KEYS */;
INSERT INTO `communication_initiative` (`id`, `title`, `slug`, `type_file`, `desc`, `status`, `views`, `thumbnail`, `user_maker`, `is_recommend`, `updated_by`, `approve_at`, `approve_by`, `publish_at`, `publish_by`, `unpublish_at`, `unpublish_by`, `reject_at`, `reject_by`, `deleted_at`, `deleted_by`, `created_at`, `updated_at`) VALUES
	(1, 'TESTTTTING', 'testt', 'article', 'TESTTING INI TEST', 'publish', 1, 'test.png', 55268111, 0, 55268111, '2022-09-19 10:35:52', 55268111, '2022-09-19 10:36:04', 55268111, '2022-09-19 10:36:10', NULL, NULL, NULL, NULL, NULL, '2022-09-19 10:38:31', '2022-09-19 10:38:40');
/*!40000 ALTER TABLE `communication_initiative` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `consultants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tentang` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `bidang` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `facebook` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `consultants` DISABLE KEYS */;
INSERT INTO `consultants` (`id`, `nama`, `tentang`, `bidang`, `website`, `telepon`, `email`, `facebook`, `instagram`, `lokasi`, `created_at`, `updated_at`) VALUES
	(1, 'PT BRINGIN INTI TEKNOLOGI', 'PT Bringin Inti Teknologi Atau BRIIT adalah anak perusahaan dana pensiunan BRI (DAPEN BRI) yang banyak bergerak dalam bidang IT Solution', 'IT Solution', 'https://www.briit.co.id/website/index.html', '02157906373', 'corp@briit.co.id', '-', '-', 'Jl. Tanah Abang IV No.32h, RT.4/RW.3, Dukuh Atas, RT.3/RW.3, Petojo Sel., Kecamatan Gambir, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10160', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(2, 'PT ITOMMEY BINTANG INDONESIA', 'Companies are moving towards to digital era. With that, IT Organizations are racing to be the enabler for all digital services supporting the business. We are here to help companies shape their IT Organization to be ready to adapt all the technologies required for digital transformation. We\'re here not only to be your vendor, but we will be your trustworthy professional partner and your reinforcement to face all the challanges in digital technology. We\'re equipped with experienced professional people, great technologies also strong with knowledge of IT digital architecture and process.', 'IT Solution', 'https://www.itommey.com/', '02129826060', 'info@itommey.com', '-', '-', 'Menara Cardig, Lantai Mezzanine Jl. Raya Halim Perdanakusuma Jakarta 13650 Indonesia', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(3, 'PT INDUSTRI TELEKOMUNIKASI INDONESIA', 'PT INTI (Persero), one of the state-owned enterprises in strategic industries, was officially established on December 30, 1974. The Company headquartered in Jalan Moch Toha No. 77 Bandung has portfolio in the fields of Manufacture and Assembly, Managed Service, Digital Service, and System Integrator. To support its business, PT INTI (Persero) also operates an eight hectares production facility on Jalan Moch Toha No 225 which produces telecommunications and electronic devices.', 'Manufacture and Assembly, Managed Service, Digital Service, and System Integrator', 'https://www.inti.co.id/', '0225206510', 'info@inti.co.id', 'https://id-id.facebook.com/ptintiofficial/', 'https://www.instagram.com/ptintiofficial/', 'Gedung Graha Pratama Lantai 11 Jl. Letjen. MT. Haryono Kav. 15, Tebet Jakarta Selatan 12810', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(4, 'PT LEN INDUSTRI', 'PT Len Industri (Persero) saat ini berada di bawah koordinasi Kementrian Negara BUMN dengan kepemilikan saham 100% oleh Pemerintah Republik Indonesia. Selama ini, Len telah mengembangkan bisnis dan produk-produk dalam bidang elektronika untuk industri dan prasarana', 'Technology', 'https://www.len.co.id/', '0225202682', 'marketing@len.co.id', 'https://www.facebook.com/LenIndustri', 'https://www.instagram.com/lenindustri/', 'Jl. Raya Subang - Cikamurang Km 12 Cibogo, Subang 41285 - Jawa Barat', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(5, 'PT TELKOM INDONESIA', 'PT Telkom Indonesia Tbk, biasa disebut Telkom Indonesia atau Telkom saja adalah perusahaan informasi dan komunikasi serta penyedia jasa dan jaringan telekomunikasi secara lengkap di Indonesia.', 'Informasi & Komunikasi', 'https://www.telkom.co.id/sites', '02180863539', 'corporate_comm@telkom.co.id', 'https://www.facebook.com/TelkomIndonesia', 'https://www.instagram.com/telkomindonesia/', 'Telkom Landmark Tower, 39-nd floor Jl. Jendral Gatot Subroto Kav. 52 RT.6/RW.1, Kuningan Barat, Mampang Prapatan Jakarta Selatan, DKI Jakarta, 12710 Indonesia', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(6, 'PT SATKOMINDO MEDIYASA', 'PT Satkomindo Mediyasa adalah penyedia solusi infrastruktur jaringan telekomunikasi terkemuka. Kami adalah anak perusahaan dari Dana Pensiun BRI (Bank Rakyat Indonesia). Kami menyediakan layanan telekomunikasi berbasis satelit yang dikenal sebagai VSAT (Very Small Aperture Terminal) dan juga layanan terestrial.\r\n\r\n            Sebagai penyedia layanan solusi jaringan, SATKOMINDO menawarkan total layanan untuk kebutuhan perusahaan dalam jaringan telekomunikasi, mulai dari identifikasi kebutuhan jaringan, pengukuran pola lalu lintas, perhitungan kebutuhan bandwidth, desain jaringan, rencana implementasi, peluncuran instalasi, integrasi jaringan, pemantauan dan pengendalian, hingga jaringan pemeliharaan.\r\n            \r\n            Didukung oleh tim profesional dan berpengalaman kami di lapangan bersama dengan Service Point yang tersebar luas di seluruh Indonesia, SATKOMINDO siap memberikan solusi dan layanan telekomunikasi terbaik untuk perusahaan Anda dalam hal data, suara, komunikasi video serta akses internet.\r\n            Bermaksud untuk melakukan rekuitmen tenaga programmer yang akan ditempatkan di Bank tersebut.', 'infrastruktur jaringan telekomunikasi', 'https://www.satkomindo.com/#home', '02129125062', 'marketing@brinetcom.com', 'https://www.facebook.com/BRINETCOM/?ref=ts&fref=ts', '-', 'Jl.RS.Fatmawati No.1, Cilandak Barat. Jakarta Selatan. 12430', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(7, 'PT DELOITTE', 'Deloitte is a leading global provider of audit and assurance, consulting, financial advisory, risk advisory, tax, and related services. During its 175-year history, our organization has grown tremendously in both scale and capabilities. Deloitte currently has approximately 330,000 people in more than 150 countries and territories, and serves four out of five Fortune Global 500® companies. Yet, our shared culture and mission—to make an impact that matters—remains unchanged. This is evident not only in Deloitte’s work for clients, but also in our WorldClass ambition, our WorldClimate initiative and our ALL IN diversity and inclusion strategy.', 'Audit, Consulting, Advisory, and Tax Services', 'https://www2.deloitte.com/global/en.html', '02150818000', '-', 'https://www.facebook.com/DeloitteIndonesia/', 'https://www.instagram.com/deloitte_indonesia/', 'The Plaza Office Tower, 32nd Floor, Jl. M.H. Thamrin Kav 28-30, RT.9/RW.5, Gondangdia, Menteng, RT.9/RW.5, Gondangdia, Kec. Menteng, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10350', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(8, 'PT Somia Customer Experience', 'Pengalaman Pelanggan Somia membantu perusahaan menemukan wawasan tentang pelanggan mereka dan membantu mereka mengubah solusi dan organisasi mereka. Perusahaan ini bergerak di bidang Data and Analytics, Design.', 'jasa keamanan, jasa security, dan jasa satpam', 'https://somiacx.com/', '-', '-', '-', '-', 'Plaza Bapindo, Jl. Jend. Sudirman Kav. 54-55, Senayan, Kby. Baru, Jakarta, Daerah Khusus Ibukota Jakarta 12190, Indonesia', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(9, 'PT Sri Rejeki Isman Tbk', 'We serve visits from schools, universities, companies and agencies who are interested in visiting our Head Office in Sukoharjo, Central Java. During this visit, you can get to know more about how a textile factory works, from spinning to becoming a garment. We are proud to be the only company in Indonesia that can demonstrate and educate the public about the work processes of the best textile factories in Indonesia. It’s easy, please read the terms and fill in the online form below, one of our General Affairs officers will call you back within 24-48 hours.', 'Pabrik tekstil dan garmen', 'https://www.sritex.co.id/', '0271593188', '-', '-', '-', 'Jl. KH. Samanhudi 88, Jetis, Sukoharjo, Solo – Central Java Indonesia', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(10, 'PT Bolia Mitra Utama', 'PT Bolia Mitra Utama as a company focusing on promotional items targeting corporate segment. We Provide all kind of promotional item, merchandise/souvenir/gift that could be customized to fulfill clients\' needs and request. Our Workshop is equipped with more than 50 sewing machine that can produced all garment items such as dolls, any bag provided more than 25.000 pieces per month. We also have designer that can help provide unique design as request.', 'Promotion Item Berbagai Macam Gimmick.', 'http://boliajaya.com/index.php', '02154381676', 'boliajaya@gmail.com', '-', '-', 'Address : Jl. Raya Duri Kosambi No. 79 M - 79 L, Cengkareng - Duri Kosambi Jakarta 11750', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(11, 'CV Maju Lestari', 'Maju Lestari adalah perusahaan yang bergerak di bidang tekstil khususnya di bidang pakaian jadi atau garmen. Produk yang dibuat oleh perusahaan adalah pesanan dari pembeli. Beberapa pembeli yang bekerja sama dengan kami terus terjaga kualitasnya, karena yang paling penting adalah kepuasan pelanggan.', 'bidang tekstil Pakaian & Garmen', 'http://majulestarigarment.com/', '0226122960', 'md@maju-lestari.com', '-', '-', 'Jl.katalina raya no.9, perumahan cendrawasih, Andir, Bandung – Jawa Barat – Indonesia.', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(12, 'CV Surya Cipta Kreasi', 'Kami bangga dalam budaya tim kami yang kuat saling percaya, belajar, berbagi, kepedulian dan perhatian. Termasuk menyediakan lingkungan kerja yang nyaman dan kondusif dan meningkatkan profesional dan pribadi pertumbuhan staf kami. Kami mencari professional muda yang termotivasi, dinamis, mandiri, kreatif, inovatif, bertanggung jawab dan disiplin bersedia untuk maju dan bergabung dengan kami dan menjadi salah satu tim yang hebat kami.', 'Pabrik tekstil dan garmen', 'http://www.suryaciptamandiri.co.id', '02122302547', '-', '-', '-', 'Jalan Taman Palem Raya, Kota Jakarta Barat, Jakarta, Indonesia', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(13, 'CV TEGUH JAYA ABADI', 'CV. TEGUH JAYA ABADI adalah badan usaha berpengalaman yang mengerjakan proyek nasional. CV. TEGUH JAYA ABADI saat ini memiliki kualifikasi . CV. TEGUH JAYA ABADI dapat mengerjakan proyek-proyek dengan sub klasifikasi', 'Kontruksi Bangunan', 'https://indokontraktor.com/business/cv-teguh-jaya-abadi', '0271593188', '-', '-', '-', 'Jl. Halim Perdana Kusuma No.19, RT.001/RW.005, Jurumudi, Benda, Tangerang kota, Banten 15124', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(14, 'Accenture', 'Accenture plc is an Irish-domiciled multinational company that provides consulting and processing services. A Fortune Global 500 company, it reported revenues of $44.33 billion in 2020 and had 537,000 employees. In 2015, the company had about 150,000 employees in India, 48,000 in the US, and 50,000 in the Philippines.', 'Layanan dan Teknologi Informasi', 'https://www.accenture.com/id-en', '-', '-', '-', '-', 'Lingkaran Syed Putra Kuala Lumpur, Federal Territory of Kuala Lumpur 59200, MY', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(15, 'PT Infosys', 'Infosys Limited is an Indian multinational information technology company that provides business consulting, information technology and outsourcing services. The company was founded in Pune and is headquartered in Bangalore', 'Information Technology', 'https://www.infosys.com/', '+61398602000', '-', '-', '-', 'Two Melbourne Quarter Level 4, 697 Collins Street Docklands, 3008 VIC', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(16, 'PT Karim Consulting Indonesia', 'KARIM Consulting Indonesia is a dynamic consulting firm specializing in Islamic Economics and Finance supported by professional people working full time. KARIM Consulting Indonesia was established in August 2001 and positioned itself as a world leading Shariah Compliance consulting firm. We continuously pursue the search for innovative products and present new concepts in Islamic Banking and Finance through publications and free sessions. KARIM Consulting Indonesia believes that to further develop and promote Islamic Banking and Finance, trainings in Islamic Banking and Finance area are essential. KARIM Consulting Indonesia believes that the development of the human potential is very much needed. We, at KARIM Consulting Indonesia, help pioneer Islamic Thought through our activities at major Universities in Indonesia. We work closely with the research Teams in these Universities to develop new analytical tools and methods to be applied in the development of new Islamic Banking and Finance instruments and provide the relevant research base for Islamic Economics publications.', 'Islamic Economics and Finance', 'https://www.compnet.co.id', '02175917891', '-', '-', '-', 'AKR TOWER Gallery West Office Tower 8th floor Jl. Panjang No. 5, Kebon Jeruk Jakarta Barat 11530 - Indonesia  ', '2022-08-11 15:29:36', '2022-08-11 15:29:36');
/*!40000 ALTER TABLE `consultants` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `consultant_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `consultant_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `consultant_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `consultant_logs` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `consultant_projects` (
  `consultant_id` bigint(20) unsigned NOT NULL,
  `project_id` bigint(20) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `consultant_projects` DISABLE KEYS */;
INSERT INTO `consultant_projects` (`consultant_id`, `project_id`) VALUES
	(1, 1),
	(2, 2),
	(2, 3),
	(4, 4),
	(5, 5),
	(6, 6),
	(7, 7),
	(8, 8),
	(9, 9),
	(10, 10);
/*!40000 ALTER TABLE `consultant_projects` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `divisis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cost_center` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direktorat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `divisi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shortname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `divisis_cost_center_unique` (`cost_center`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `divisis` DISABLE KEYS */;
INSERT INTO `divisis` (`id`, `cost_center`, `direktorat`, `divisi`, `shortname`, `created_at`, `updated_at`) VALUES
	(1, 'NEW1', 'Micro Business Directorate', 'Ultra Micro Business Team Division', 'UMI', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(2, 'NEW2', 'Small, Retail & Medium Business Directorate', 'Medium Business 1 Division', 'MBO', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(3, 'NEW3', 'Small, Retail & Medium Business Directorate', 'Medium Business 2 Division', 'MBT', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(4, 'NEW4', 'Network & Service Directorate', 'Distribution Network Division', 'DNR', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(5, 'NEW5', 'Digital & Information Technology Directorate', 'Enterprise Data Management Division', 'EDM', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(6, 'NEW6', 'Human Capital Directorate', 'Corporate University Division', 'BCU', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(7, 'NEW7', 'Internal Audit Directorate', 'Head Office, Special Branch & Overseas Network Audit Division', 'AIK', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(8, 'NEW8', 'Internal Audit Directorate', 'Information Technology Audit Desk Division', 'AIT', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(9, 'PS20024', 'Change Management & Transformation Office Directorate', 'Desk Project Management Office Division', 'PMO', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(10, 'PS10007', 'Compliance Directorate', 'Kebijakan & Prosedur Division', 'KPD', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(11, 'PS10008', 'Risk Management Directorate', 'Kebijakan Risiko Kredit Division', 'KRD', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(12, 'PS10009', 'Risk Management Directorate', 'Risk Enterprise & Mnjm Portofolio Division', 'EMP', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(13, 'PS10010', 'Risk Management Directorate', 'Manajemen Risk Oprasional & Pasar Division', 'MOP', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(14, 'PS10011', 'Finance Directorate', 'Assets Liabilities Management Division', 'ALM', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(15, 'PS10012', 'Finance Directorate', 'Hubungan Investor Division', 'DHI', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(16, 'PS10014', 'Corporate Banking Directorate', 'Sindikasi & Jasa Lembaga Keuangan Division', 'SJK', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(17, 'PS10015', 'Network & Service Directorate', 'Operasional Kredit Division', 'OPK', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(18, 'PS10017', 'Consumer Directorate', 'Retail Payment Division', 'RPT', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(19, 'PS10019', 'Digital & Information Technology Directorate', 'Digital Center Of Excellence Division', 'DCE', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(20, 'PS10024', 'Network & Services', 'Desk Jaringan Brilink Division', 'BND', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(21, 'PS10029', 'Digital & Information Technology Directorate', 'Desk Information Security Division', 'ISC', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(22, 'PS19001', 'Human Capital Directorate', 'Human Capital Business Partner Division', 'HCBP', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(23, 'PS19002', 'Human Capital Directorate', 'Human Capital Development Division', 'HCD', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(24, 'PS19003', 'Human Capital Directorate', 'Human Capital Strategy & Policy Division', 'HCS', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(25, 'PS19005', 'Human Capital Directorate', 'Culture Transformation Division', 'CTR', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(26, 'PS19006', 'Micro Business Directorate', 'Micro Sales Management Division', 'MSM', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(27, 'PS19007', 'Micro Business Directorate', 'Kebijakan Bisnis Mikro Division', 'KBM', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(28, 'PS19009', 'Micro Business Directorate', 'Social Entrepreneurship & Inkubasi Division', 'SEI', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(29, 'PS19011', 'Small, Retail & Medium Business Directorate', 'Kebijakan Bisnis Kecil, Ritel & Menengah Division', 'BKRM', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(30, 'PS19012', 'Small, Retail & Medium Business Directorate', 'Small Sales Management Division', 'MSM', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(31, 'PS19013', 'Institutional & SOE Directorate', 'Institutional Division', 'INS', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(32, 'PS19014', 'Consumer Directorate', 'Mass Funding Division', 'MFD', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(33, 'PS19017', 'Network & Service Directorate', 'Jaringan Brilink Division', 'BND', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(34, 'PS19018', 'Digital & Information Technology Directorate', 'It Strategy & Governance Division', 'ISG', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(35, 'PS19019', 'Digital & Information Technology Directorate', 'Application Management & Operation Division', 'APP', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(36, 'PS19020', 'Digital & Information Technology Directorate', 'It Infrastructure & Operation Division', 'INF', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(37, 'PS19023', 'Finance Directorate', 'Tim Implementasi Bri Financial Enterprise System Division', 'NFS', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(38, 'PS20001', 'Institutional & SOE Directorate', 'SOE 1 Division', 'SOO', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(39, 'PS20002', 'Institutional & SOE Directorate', 'SOE 2 Division', 'SOT', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(40, 'PS20004', 'Corporate Banking Directorate', 'Corporate Banking 1 Division', 'CBO', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(41, 'PS20005', 'Corporate Banking Directorate', 'Corporate Banking 2 Division', 'CBT', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(42, 'PS20007', 'Fixed Assets Management & Procurement Directorate', 'Procurement, Logistic Policy & Fix Assets Management Division', 'PLM', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(43, 'PS20008', 'Fixed Assets Management & Procurement Directorate', 'Procurement & Logistic Operation Division', 'PLO', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(44, 'PS52000', 'Consumer Directorate', 'Kartu Kredit Division', 'KKD', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(45, 'PS53000', 'Consumer Directorate', 'Kredit Konsumer Division', 'KRK', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(46, 'PS54000', 'Consumer Directorate', 'Marketing Communication Division', 'MCM', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(47, 'PS57000', 'Finance Directorate', 'Corporate Development & Strategy Division', 'CDS', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(48, 'PS58000', 'Treasury & Global Services Directorate', 'Investment Service Division', 'INV', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(49, 'PS59000', 'Consumer Directorate', 'Wealth Management Division', 'WMG', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(50, 'PS60000', 'Institutional & SOE Directorate', 'Transaction Banking Division', 'TRB', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(51, 'PS61000', 'Compliance Directorate', 'Kepatuhan Division', 'KEP', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(52, 'PS70099', 'Internal Audit Directorate', 'Satuan Kerja Audit Intern Division', 'SKAI', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(53, 'PS71000', NULL, 'Sekretariat Perusahaan Division', 'SKP', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(54, 'PS79000', 'Risk Management Directorate', 'Analisis Resiko Kredit Division', 'ARK', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(55, 'PS80000', 'Risk Management Directorate', 'Restruktrs. & Penyelesaian Kredit Division', 'RPK', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(56, 'PS82000', 'Treasury & Global Services Directorate', 'Treasury Business Division', 'TRY', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(57, 'PS83000', 'Finance Directorate', 'Akuntansi Manajemen & Keuangan Division', 'AMK', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(58, 'PS84000', 'Treasury & Global Services', 'Bisnis Internasional Division', 'INT', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(59, 'PS85000', 'Network & Service Directorate', 'Sentra Operasi Division', 'STO', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(60, 'PS92000', 'Compliance Directorate', 'Hukum Division', 'LGL', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(61, 'PS98502', 'Network & Service Directorate', 'Layanan & Contact Center Division', 'LCC', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(62, 'PS98600', 'Change Management & Transformation Office Directorate', 'Corporate Transformation Division', 'CTF', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(63, 'PS51201', NULL, 'Pengembangan Bisnis E-banking', 'EBanking', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(64, 'PS64000', NULL, 'Desk E-Channel', 'ECH', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(65, 'PS98200', NULL, 'Direksi', 'OPT', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(66, 'PS51000', NULL, 'Dana & Jasa', 'DANA&JASA', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(67, 'PS77000', NULL, 'Bisnis Korporasi', 'BKO', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(68, 'PS10032', NULL, 'Bisnis Pertanian', 'BPT', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(69, 'PS10025', NULL, 'Bisnis Retail', 'BRL', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(70, 'PS19010', NULL, 'Bisnis Ritel & Menengah', 'BRM', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(71, 'PS19004', NULL, 'Human Capital Partnership Management', 'HCM', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(72, 'PS50100', NULL, 'Institution 1', 'INS', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(73, 'PS50200', NULL, 'Institution 2', 'IND', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(74, 'PS10013', NULL, 'Jaringan Bisnis Mikro', 'JBM', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(75, 'PS10021', NULL, 'Jaringan Bisnis Retail', 'JBR', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(76, 'PS87000', NULL, 'Kebijakan & Pengembangan HC', 'KHC', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(77, 'PS10028', NULL, 'Kerjasama Teknologi', 'KJT', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(78, 'PS19015', NULL, 'Kredit Briguna', 'KBG', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(79, 'PS88200', NULL, 'Management AT & Pengadaan Properti', 'MAT', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(80, 'PS63000', NULL, 'Perencanaan & Pengembangan IT', 'PPT', '2022-08-11 15:29:36', '2022-08-11 15:29:36');
/*!40000 ALTER TABLE `divisis` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `documents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) unsigned NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_file` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_file` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `favorite_consultants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `consultant_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `favorite_consultants` DISABLE KEYS */;
/*!40000 ALTER TABLE `favorite_consultants` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `favorite_projects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `project_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `favorite_projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `favorite_projects` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `forums` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `restriction` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `forums` DISABLE KEYS */;
/*!40000 ALTER TABLE `forums` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `forum_comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `forum_id` bigint(20) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `replyto_user_id` bigint(20) unsigned DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `forum_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_comments` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `forum_users` (
  `forum_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `forum_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_users` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `implementation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `divisi_id` bigint(20) unsigned NOT NULL,
  `project_managers_id` bigint(20) unsigned NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `is_restricted` int(11) NOT NULL,
  `user_access` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc_piloting` text COLLATE utf8mb4_unicode_ci,
  `desc_roll_out` text COLLATE utf8mb4_unicode_ci,
  `desc_sosialisasi` text COLLATE utf8mb4_unicode_ci,
  `project_link` text COLLATE utf8mb4_unicode_ci,
  `user_checker` int(11) NOT NULL,
  `user_signer` int(11) NOT NULL,
  `user_maker` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `approve_at` datetime DEFAULT NULL,
  `approve_by` int(11) DEFAULT NULL,
  `publish_at` datetime DEFAULT NULL,
  `publish_by` int(11) DEFAULT NULL,
  `unpublish_at` datetime DEFAULT NULL,
  `unpublish_by` int(11) DEFAULT NULL,
  `reject_at` datetime DEFAULT NULL,
  `reject_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `implementation` DISABLE KEYS */;
/*!40000 ALTER TABLE `implementation` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `keywords` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) unsigned NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `keywords` DISABLE KEYS */;
INSERT INTO `keywords` (`id`, `project_id`, `nama`, `created_at`, `updated_at`) VALUES
	(1, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(2, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(3, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(4, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(5, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(6, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(7, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(8, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(9, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(10, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(11, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(12, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(13, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(14, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(15, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(16, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(17, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(18, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(19, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(20, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(21, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(22, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(23, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(24, 1, 'dolorem', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(25, 2, 'Constance Gaylord', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(26, 2, 'Wava McCullough', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(27, 3, 'Wilton Kulas', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(28, 1, 'Mr. Reed Abbott', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(29, 2, 'Dr. Mohamed Kihn DVM', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(30, 1, 'Elza Lowe', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(31, 1, 'Ms. Birdie Carter MD', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(32, 3, 'Dr. Jaylan Leffler MD', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(33, 3, 'Jacinthe Wehner', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(34, 1, 'Garrick Dickinson', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(35, 3, 'Mrs. Nyah Cronin I', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(36, 2, 'Mrs. Abigale Kris DDS', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(37, 1, 'Ephraim Heaney', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(38, 2, 'Ms. Lelia Ryan IV', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(39, 1, 'Jordy Stehr', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(40, 3, 'Dr. Gillian Schultz', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(41, 2, 'Hanna Strosin', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(42, 3, 'Jamar Fadel', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(43, 3, 'Liza Kshlerin', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(44, 3, 'Ms. Annette Johnston', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(45, 2, 'Juanita Braun', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(46, 1, 'Orville Beahan', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(47, 3, 'Wilber Aufderhar PhD', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(48, 1, 'Dr. Franz O\'Keefe II', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(49, 3, 'Isabel Weissnat', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(50, 3, 'Lincoln Fisher', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(51, 3, 'Prof. Adelle Denesik', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(52, 1, 'Misael Schultz', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(53, 3, 'Katlyn Schmeler', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(54, 2, 'Doug Homenick', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(55, 2, 'Dorothy Bergstrom', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(56, 3, 'Wyatt Anderson', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(57, 2, 'Mr. Braxton Hintz', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(58, 2, 'Dr. Cierra Schinner DVM', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(59, 2, 'Rubye Watsica V', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(60, 3, 'Queenie Renner', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(61, 2, 'Marcelle Swift', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(62, 2, 'Prof. Cielo Kunde', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(63, 1, 'Jamarcus Becker', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(64, 3, 'Allen Johnson V', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(65, 1, 'Edna Tromp', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(66, 1, 'Jimmie Hilpert', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(67, 2, 'Lorenz Kertzmann', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(68, 3, 'Dr. Fredy Reynolds', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(69, 1, 'Harley McCullough Sr.', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(70, 1, 'Wilhelmine Rosenbaum', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(71, 2, 'Vaughn Schmidt Jr.', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(72, 2, 'Ms. River Ziemann', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(73, 1, 'Prof. Taurean Marks III', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(74, 3, 'Prof. Malvina Bednar', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(75, 3, 'Margie Smitham III', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(76, 2, 'Danika Kiehn', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(77, 3, 'Abel Lebsack', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(78, 2, 'Juliana Kuvalis II', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(79, 2, 'Prof. Elinore Hill', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(80, 3, 'Prof. Blake Auer', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(81, 3, 'Mr. Xavier Kunde', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(82, 1, 'Tod Robel', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(83, 1, 'Eldora Schulist', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(84, 3, 'Nellie Bradtke', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(85, 3, 'Ms. Duane Lesch', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(86, 3, 'Dr. Simeon Mosciski DVM', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(87, 1, 'Frank Nolan', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(88, 3, 'Ms. Alysson Frami', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(89, 2, 'Prof. Giovani Bashirian', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(90, 3, 'Kacie Zieme II', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(91, 2, 'Carmela Gutkowski', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(92, 3, 'Theodora DuBuque', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(93, 2, 'Jerrold Zulauf II', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(94, 2, 'Dr. Nia Lockman I', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(95, 2, 'Arnaldo Dickens', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(96, 3, 'Ms. Nia Nienow', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(97, 2, 'Herta Trantow', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(98, 1, 'Otto Wolf', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(99, 1, 'Felipa Jaskolski', '2022-08-14 21:31:53', '2022-08-14 21:31:53'),
	(100, 1, 'Kay Baumbach Jr.', '2022-08-14 21:31:53', '2022-08-14 21:31:53');
/*!40000 ALTER TABLE `keywords` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `keywords_documents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `document_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `keywords_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `keywords_documents` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `keyword_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `keyword_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `keyword_logs` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `lesson_learneds` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) unsigned NOT NULL,
  `divisi_id` bigint(20) unsigned NOT NULL,
  `consultant_id` bigint(20) unsigned NOT NULL,
  `tahap` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lesson_learned` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_maker` int(11) NOT NULL,
  `user_signer` int(11) NOT NULL,
  `user_checker` int(11) NOT NULL,
  `checker_at` datetime DEFAULT NULL,
  `signer_at` datetime DEFAULT NULL,
  `review_at` datetime DEFAULT NULL,
  `publish_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `lesson_learneds` DISABLE KEYS */;
INSERT INTO `lesson_learneds` (`id`, `project_id`, `divisi_id`, `consultant_id`, `tahap`, `lesson_learned`, `detail`, `user_maker`, `user_signer`, `user_checker`, `checker_at`, `signer_at`, `review_at`, `publish_at`, `created_at`, `updated_at`) VALUES
	(1, 3, 19, 4, 'Plan', 'Lorem Ipsum', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 78085196, 55268111, 55268111, '2022-08-22 15:46:44', '2022-08-22 15:46:46', '2022-08-22 15:46:47', NULL, '2022-08-22 15:48:45', '2022-08-22 15:48:47'),
	(2, 2, 19, 3, 'Plan', 'TESTTSTTET', 'LESTETTSTSETS', 78085196, 55268111, 55268111, '2022-08-25 01:06:39', '2022-08-25 01:06:40', '2022-08-25 01:06:41', NULL, '2022-08-25 01:06:42', '2022-08-25 01:06:43'),
	(3, 1, 17, 3, 'Implementation', 'LOREMMMEMMM', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 0, 0, 0, '2022-08-25 01:07:23', '2022-08-25 01:07:24', '2022-08-25 01:07:25', NULL, '2022-08-25 01:07:26', '2022-08-25 01:07:27'),
	(4, 3, 19, 4, 'Plan', 'Lorem Ipsum', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 78085196, 55268111, 55268111, '2022-08-22 15:46:44', '2022-08-22 15:46:46', '2022-08-22 15:46:47', NULL, '2022-08-22 15:48:45', '2022-08-22 15:48:47'),
	(5, 3, 10, 2, 'Procurement', 'Lorem Ipsum', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 78085196, 55268111, 55268111, '2022-08-22 15:46:44', '2022-08-22 15:46:46', '2022-08-22 15:46:47', NULL, '2022-08-22 15:48:45', '2022-08-22 15:48:47'),
	(6, 3, 13, 2, 'Procurement', 'Lorem Ipsum', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 78085196, 55268111, 55268111, '2022-08-22 15:46:44', '2022-08-22 15:46:46', '2022-08-22 15:46:47', NULL, '2022-08-22 15:48:45', '2022-08-22 15:48:47'),
	(7, 3, 11, 2, 'Procurement', 'Lorem Ipsum', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 78085196, 55268111, 55268111, '2022-08-22 15:46:44', '2022-08-22 15:46:46', '2022-08-22 15:46:47', NULL, '2022-08-22 15:48:45', '2022-08-22 15:48:47'),
	(8, 5, 11, 5, 'Development', 'Lorem Ipsum', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 0, 0, 0, '2022-08-22 15:46:44', '2022-08-22 15:46:46', '2022-08-22 15:46:47', NULL, '2022-08-22 15:48:45', '2022-08-22 15:48:47'),
	(9, 5, 8, 6, 'Development', 'Lorem Ipsum', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 0, 0, 0, '2022-08-22 15:46:44', '2022-08-22 15:46:46', '2022-08-22 15:46:47', NULL, '2022-08-22 15:48:45', '2022-08-22 15:48:47'),
	(10, 8, 20, 3, 'Pilot Run', 'Lorem Ipsum', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 78085196, 55268111, 55268111, '2022-08-22 15:46:44', '2022-08-22 15:46:46', '2022-08-22 15:46:47', NULL, '2022-08-22 15:48:45', '2022-08-22 15:48:47'),
	(11, 9, 21, 10, 'Pilot Run', 'Lorem Ipsum', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 0, 0, 0, '2022-08-22 15:46:44', '2022-08-22 15:46:46', '2022-08-22 15:46:47', NULL, '2022-08-22 15:48:45', '2022-08-22 15:48:47'),
	(12, 10, 24, 19, 'Implementation', 'Lorem Ipsum', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 0, 0, 0, '2022-08-22 15:46:44', '2022-08-22 15:46:46', '2022-08-22 15:46:47', NULL, '2022-08-22 15:48:45', '2022-08-22 15:48:47');
/*!40000 ALTER TABLE `lesson_learneds` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `levels` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `xp` int(11) NOT NULL,
  `badge` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `levels_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `levels` DISABLE KEYS */;
INSERT INTO `levels` (`id`, `name`, `xp`, `badge`, `created_at`, `updated_at`) VALUES
	(1, 'Junior Grade', 0, 'assets\\img\\level_badges\\1.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(2, 'Master Grade', 100, 'assets\\img\\level_badges\\2.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(3, 'Grandmaster Grade', 250, 'assets\\img\\level_badges\\3.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36'),
	(4, 'Legendary Grade', 1000, 'assets\\img\\level_badges\\4.png', '2022-08-11 15:29:36', '2022-08-11 15:29:36');
/*!40000 ALTER TABLE `levels` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2021_02_04_090631_create_user_logs_table', 1),
	(6, '2021_02_04_100939_create_favorite_projects_table', 1),
	(7, '2021_02_04_101115_create_keywords_table', 1),
	(8, '2021_02_04_101242_create_search_logs_table', 1),
	(9, '2021_02_04_102202_create_favorite_consultants_table', 1),
	(10, '2021_02_04_102314_create_documents_table', 1),
	(11, '2021_02_04_103042_create_project_managers_table', 1),
	(12, '2021_02_04_103138_create_keywords_documents_table', 1),
	(13, '2021_02_04_103310_create_consultants_table', 1),
	(14, '2021_02_04_103529_create_divisis_table', 1),
	(15, '2021_02_04_103530_create_projects_table', 1),
	(16, '2021_04_06_143626_create_consultant_projects_table', 1),
	(17, '2021_04_15_224042_create_consultant_logs_table', 1),
	(18, '2021_04_20_162525_create_restrictions_table', 1),
	(19, '2021_04_21_152428_create_my_projects_table', 1),
	(21, '2021_05_05_130415_create_temp_uploads_table', 1),
	(22, '2021_05_28_104513_create_keyword_logs_table', 1),
	(23, '2021_06_10_102036_create_comments_table', 1),
	(24, '2021_06_15_141518_create_forums_table', 1),
	(25, '2021_06_15_141756_create_forum_comments_table', 1),
	(26, '2021_06_21_135601_create_forum_users_table', 1),
	(27, '2021_06_28_163130_create_levels_table', 1),
	(28, '2021_06_28_172505_create_achievements_table', 1),
	(29, '2021_06_28_173432_create_user_achievements_table', 1),
	(30, '2021_06_29_175521_create_notifikasis_table', 1),
	(31, '2021_06_30_230128_create_activities_table', 1),
	(32, '2021_07_02_101953_create_avatars_table', 1),
	(33, '2021_07_03_152014_create_activity_users_table', 1),
	(34, '2021_07_03_212653_create_user_levels_table', 1),
	(35, '2021_07_03_232344_create_jobs_table', 1),
	(37, '2014_10_12_000000_create_users_table', 2),
	(39, '2022_08_22_144750_create_leasson_learned_table', 3),
	(41, '2021_04_28_210526_create_lesson_learneds_table', 4),
	(44, '2022_09_10_133558_create_implementation_table', 6),
	(45, '2022_09_01_123820_create_communication_initiative_table', 7);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `my_projects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `project_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `my_projects` DISABLE KEYS */;
INSERT INTO `my_projects` (`id`, `user_id`, `project_id`, `created_at`, `updated_at`) VALUES
	(1, 78085196, 3, '2022-08-25 03:09:13', '2022-08-25 03:09:15');
/*!40000 ALTER TABLE `my_projects` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `notifikasis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `kategori` int(11) NOT NULL,
  `judul` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `direct` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `notifikasis` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifikasis` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
	(37, 'App\\User', 1, 'web-token', '70ea3e06291023e9c8bffff4938a4417d8567ebd5e38bce637c04f29bfaa7bb5', '["*"]', '2022-09-22 15:13:45', '2022-09-22 15:09:05', '2022-09-22 15:13:45'),
	(25, 'App\\User', 2, 'web-token', '9274fc349496ec6578300cbafbc061010aa9c31e3baef784bb034b16d15b3c91', '["*"]', '2022-09-07 00:58:58', '2022-09-07 00:58:41', '2022-09-07 00:58:58');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `divisi_id` bigint(20) unsigned NOT NULL,
  `project_managers_id` bigint(20) unsigned NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` text COLLATE utf8mb4_unicode_ci,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metodologi` text COLLATE utf8mb4_unicode_ci,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status_read` int(11) DEFAULT NULL,
  `status_finish` int(11) NOT NULL,
  `is_recomended` int(11) NOT NULL,
  `is_restricted` int(11) NOT NULL,
  `flag_mcs` int(11) DEFAULT NULL,
  `user_maker` int(11) NOT NULL,
  `user_checker` int(11) NOT NULL,
  `user_signer` int(11) NOT NULL,
  `checker_at` datetime DEFAULT NULL,
  `signer_at` datetime DEFAULT NULL,
  `review_at` datetime DEFAULT NULL,
  `publish_at` datetime DEFAULT NULL,
  `r_note1` text COLLATE utf8mb4_unicode_ci,
  `r_note2` text COLLATE utf8mb4_unicode_ci,
  `flag_es` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` (`id`, `divisi_id`, `project_managers_id`, `nama`, `slug`, `thumbnail`, `deskripsi`, `metodologi`, `tanggal_mulai`, `tanggal_selesai`, `status_read`, `status_finish`, `is_recomended`, `is_restricted`, `flag_mcs`, `user_maker`, `user_checker`, `user_signer`, `checker_at`, `signer_at`, `review_at`, `publish_at`, `r_note1`, `r_note2`, `flag_es`, `created_at`, `updated_at`) VALUES
	(1, 2, 1, 'dolorem', '72928987-dolorem', 'thumbnail_project.jpg', 'Commodi sequi totam.', '<html><p>Hello world.</p></html>', '2022-09-14', '2022-09-14', 1, 1, 1, 1, 5, 33333333, 55268111, 55268111, '2022-09-14 21:30:13', '2022-09-14 21:30:13', '2022-09-14 21:30:13', '2022-09-14 21:30:13', NULL, NULL, NULL, '2022-08-14 21:30:13', '2022-08-14 23:20:15'),
	(2, 1, 3, 'quidem', '60698257-quidem', 'thumbnail_project.jpg', 'Veritatis perspiciatis non a.', '<html><p>Hello world.</p></html>', '2022-09-14', '2022-09-14', 1, 0, 0, 0, 5, 78085196, 55268111, 55268111, '2022-09-14 21:30:13', '2022-09-14 21:30:13', '2022-08-25 03:11:26', '2022-08-25 03:11:35', NULL, NULL, NULL, '2022-08-14 21:30:13', '2022-08-14 23:20:15'),
	(3, 3, 1, 'excepturi', '51533079-excepturi', 'thumbnail_project.jpg', 'Illum ad ducimus maxime.', '<html><p>Hello world.</p></html>', '2022-09-14', '2022-09-14', 1, 0, 0, 0, 5, 33333333, 55268111, 55268111, '2022-09-14 21:30:13', '2022-09-14 21:30:13', '2022-09-14 21:30:13', '2022-09-14 21:30:13', NULL, NULL, NULL, '2022-08-14 21:30:13', '2022-08-14 23:20:15'),
	(4, 3, 1, 'vitae', '89877252-vitae', 'thumbnail_project.jpg', 'Maiores aut quam est iure.', '<html><p>Hello world.</p></html>', '2022-09-14', '2022-09-14', 1, 1, 0, 0, 5, 22222222, 55268111, 55268111, '2022-09-14 21:30:13', '2022-09-14 21:30:13', '2022-08-25 03:11:26', '2022-08-25 03:11:34', NULL, NULL, NULL, '2022-08-14 21:30:13', '2022-08-14 23:20:15'),
	(5, 3, 3, 'deserunt', '821424-deserunt', 'thumbnail_project.jpg', 'Non aut.', '<html><p>Hello world.</p></html>', '2022-09-14', '2022-09-14', 1, 0, 1, 1, 5, 22222222, 55268111, 55268111, '2022-08-25 03:11:16', '2022-08-25 03:11:20', '2022-08-25 03:11:27', '2022-08-25 03:11:34', NULL, NULL, NULL, '2022-08-14 21:30:13', '2022-08-14 23:20:15'),
	(6, 3, 3, 'omnis', '24790538-omnis', 'thumbnail_project.jpg', 'Recusandae ea sunt.', '<html><p>Hello world.</p></html>', '2022-09-14', '2022-09-14', 1, 1, 0, 1, 5, 22222222, 55268111, 55268111, '2022-08-25 03:11:18', '2022-08-25 03:11:21', '2022-08-25 03:11:27', '2022-08-25 03:11:33', NULL, NULL, NULL, '2022-08-14 21:30:13', '2022-08-14 23:20:15'),
	(7, 3, 3, 'consectetur', '16132878-consectetur', 'thumbnail_project.jpg', 'Doloribus itaque beatae explicabo.', '<html><p>Hello world.</p></html>', '2022-09-14', '2022-09-14', 1, 0, 1, 0, 5, 22222222, 55268111, 55268111, '2022-08-25 03:11:18', '2022-08-25 03:11:22', '2022-08-25 03:11:28', '2022-08-25 03:11:33', NULL, NULL, NULL, '2022-08-14 21:30:13', '2022-08-14 23:20:15'),
	(8, 3, 3, 'itaque', '56083797-itaque', 'thumbnail_project.jpg', 'Dolore alias reprehenderit quae.', '<html><p>Hello world.</p></html>', '2022-09-14', '2022-09-14', 1, 0, 0, 0, 5, 11111111, 55268111, 55268111, '2022-08-25 03:11:19', '2022-08-25 03:11:23', '2022-08-25 03:11:30', '2022-08-25 03:11:32', NULL, NULL, NULL, '2022-08-14 21:30:13', '2022-08-14 23:20:15'),
	(9, 2, 2, 'facilis', '23889041-facilis', 'thumbnail_project.jpg', 'Sed voluptate.', '<html><p>Hello world.</p></html>', '2022-09-14', '2022-09-14', 1, 1, 0, 1, 5, 22222222, 55268111, 55268111, '2022-09-14 21:30:13', '2022-09-14 21:30:13', '2022-08-25 03:11:30', '2022-08-25 03:11:32', NULL, NULL, NULL, '2022-08-14 21:30:13', '2022-08-14 23:20:15'),
	(10, 1, 1, 'quia', '35897567-quia', 'thumbnail_project.jpg', 'Ut autem omnis.', '<html><p>Hello world.</p></html>', '2022-09-14', '2022-09-14', 1, 0, 0, 1, 5, 11111111, 55268111, 55268111, '2022-09-14 21:30:13', '2022-08-25 03:11:24', '2022-08-25 03:11:29', '2022-08-25 03:11:31', NULL, NULL, NULL, '2022-08-14 21:30:13', '2022-08-14 23:20:15');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `project_managers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `project_managers` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_managers` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `restrictions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `project_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `restrictions` DISABLE KEYS */;
/*!40000 ALTER TABLE `restrictions` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `search_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `project_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `search_logs` DISABLE KEYS */;
INSERT INTO `search_logs` (`id`, `user_id`, `project_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 3, '2022-08-18 15:35:15', '2022-08-18 15:35:15'),
	(2, 1, 3, '2022-08-25 01:01:01', '2022-08-25 01:01:02'),
	(3, 2, 2, '2022-08-25 03:25:09', '2022-08-25 03:25:09');
/*!40000 ALTER TABLE `search_logs` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `temp_uploads` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `jenis` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_file` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `temp_uploads` DISABLE KEYS */;
INSERT INTO `temp_uploads` (`id`, `jenis`, `nama_file`, `size`, `type`, `path`, `created_at`, `updated_at`) VALUES
	(1, 'photo', '12tahunmelonindonesia-bd9343e6-766f-4d7b-878b-f17e3e328f35.jpg', '1603554', 'jpg', 'document/photo/6310067cc1a2b-1661994620/5vaGvHmhtJVDHFu0z9ZSUkfs8EkcSh9RVDzIfQ48.jpg', '2022-09-01 08:10:21', '2022-09-01 08:10:21'),
	(2, 'photo', '12tahunmelonindonesia-bd9343e6-766f-4d7b-878b-f17e3e328f35.jpg', '1603554', 'jpg', 'document/photo/63100cd4c9b07-1661996244/O9xf1HsyDukPMGdkMg5KPSE2IZuIjT8tlRlXjtMk.jpg', '2022-09-01 08:37:24', '2022-09-01 08:37:24'),
	(3, 'photo', '12tahunmelonindonesia-bd9343e6-766f-4d7b-878b-f17e3e328f35.jpg', '1603554', 'jpg', 'document/photo/6310110431d1d-1661997316/0MggOP6amXXWi2TxFipR4Xyy3B7GcOJc9Nbr4BoT.jpg', '2022-09-01 08:55:16', '2022-09-01 08:55:16'),
	(4, 'photo', '12tahunmelonindonesia-bd9343e6-766f-4d7b-878b-f17e3e328f35.jpg', '1603554', 'jpg', 'document/photo/6310168fdef07-1661998735/MJNG0cEH30t9Qd9YMKgkcDQ0ygxEQDLMbDTcUqfW.jpg', '2022-09-01 09:18:56', '2022-09-01 09:18:56'),
	(5, 'photo', '12tahunmelonindonesia-bd9343e6-766f-4d7b-878b-f17e3e328f35.jpg', '1603554', 'jpg', 'document/photo/631018f660542-1661999350/v9poXsowsk6OUyWnolGLk6XZMsxd8KfswmU9LP2m.jpg', '2022-09-01 09:29:10', '2022-09-01 09:29:10'),
	(6, 'attach', 'Agreement Letter 2021.pdf', '365224', 'pdf', 'document/attach/631586cd77266-1662355149/2lihhcRP8LwVRVMu2ZRHi99eoTdadLejMB2tdAV2.pdf', '2022-09-05 12:19:09', '2022-09-05 12:19:09'),
	(7, 'attach', 'Telkom_Wellbeing_272903.pdf', '580070', 'pdf', 'document/attach/631587256314b-1662355237/kuj7cdBaxfy1WEI7sicvEXmz0aAtA64FOjKLcR9t.pdf', '2022-09-05 12:20:37', '2022-09-05 12:20:37'),
	(8, 'attach', 'Telkom_Wellbeing_272903.pdf', '580070', 'pdf', 'document/attach/6315887446d69-1662355572/z2Jmd9soELDaORJF30fyzm8Bsh3BNsYjhAUpHbeG.pdf', '2022-09-05 12:26:12', '2022-09-05 12:26:12'),
	(9, 'attach', '2022810112244.pdf', '2716712', 'pdf', 'document/attach/6315897fda1ed-1662355839/mKOsV36JgQQidDlJbNH11PvWMFpPR0KIymagdNtv.pdf', '2022-09-05 12:30:40', '2022-09-05 12:30:40'),
	(10, 'attach', 'KTP.pdf', '535816', 'pdf', 'document/attach/63220be44cb31-1663175652/374ukD8L60iP3eMyeebZsNydUw6g009w1oIQajw9.pdf', '2022-09-15 00:14:12', '2022-09-15 00:14:12'),
	(11, 'attach', 'Surat Pernyataan KJP Plus.pdf', '482660', 'pdf', 'document/attach/63220bea100f7-1663175658/sB4Kdqq8SsejUXLwyfP2IaeR3lpcr5xZuSXphygd.pdf', '2022-09-15 00:14:18', '2022-09-15 00:14:18'),
	(12, 'attach', 'Surat Ketaatan Pengguna KJP .pdf', '800298', 'pdf', 'document/attach/63220bf7ea9e2-1663175671/ergS8lhRrwcsL2mgYo3yV4CBm1CB9d9hLmPnYzEb.pdf', '2022-09-15 00:14:32', '2022-09-15 00:14:32'),
	(13, 'attach', 'KTP.pdf', '535816', 'pdf', 'document/attach/63220c279f094-1663175719/SeEGRUXC4I5lAB0htG50WtYGP7WVsbPQ0LBLyNMS.pdf', '2022-09-15 00:15:19', '2022-09-15 00:15:19'),
	(14, 'attach', 'KK.pdf', '1214570', 'pdf', 'document/attach/63220c701df6f-1663175792/7Ztrxvo1dTzKCz8pxrB8ujNduzgxeeU739eI6nHd.pdf', '2022-09-15 00:16:32', '2022-09-15 00:16:32'),
	(15, 'attach', 'Surat Ketaatan Pengguna KJP .pdf', '800298', 'pdf', 'document/attach/63220cb923a95-1663175865/4gJu0ypoZ1Qg9V6GSlnr3sZ3eFdCiSZgUuvQro9x.pdf', '2022-09-15 00:17:45', '2022-09-15 00:17:45'),
	(16, 'attach', 'Surat Pernyataan KJP Plus.pdf', '482660', 'pdf', 'document/attach/63220cbf6ec6d-1663175871/3qY2jhaMH6hsKy2CsTInQGjoNMemtn6BORC077qj.pdf', '2022-09-15 00:17:51', '2022-09-15 00:17:51'),
	(17, 'attach', 'KTP.pdf', '535816', 'pdf', 'document/attach/63220edb50e47-1663176411/nxtADKMmLiVtA2YoYurE5H5AjBuutxIx5PCB3Shv.pdf', '2022-09-15 00:26:51', '2022-09-15 00:26:51');
/*!40000 ALTER TABLE `temp_uploads` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_number` int(11) NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `role` int(11) NOT NULL,
  `last_login_at` datetime NOT NULL,
  `divisi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `xp` int(11) NOT NULL,
  `avatar_id` int(11) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_personal_number_unique` (`personal_number`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `personal_number`, `username`, `email`, `email_verified_at`, `role`, `last_login_at`, `divisi`, `xp`, `avatar_id`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Prof. Maximo Hammes DVM', 55268111, 'ghahn', 'dprice@example.net', '2022-08-14 22:03:04', 3, '2022-08-14 22:03:04', '1', 2060, 1, 'kfzKkSpbR6', '2022-08-14 22:03:04', '2022-08-14 22:03:04'),
	(2, 'Mr. Kurtis Ruecker Jr.', 78085196, 'sdare', 'alycia.bashirian@example.net', '2022-08-14 22:03:04', 0, '2022-08-14 22:03:04', '1', 1580, 1, 'R5GuTntj4f', '2022-08-14 22:03:04', '2022-08-14 22:03:04'),
	(3, 'Dr. Kayla Gusikowski', 20030344, 'johnston.lisette', 'wanderson@example.net', '2022-08-14 22:03:04', 0, '2022-08-14 22:03:04', '1', 3989, 1, 'vBWP5PVK4T', '2022-08-14 22:03:04', '2022-08-14 22:03:04'),
	(4, 'Elena Dicki DVM', 35741257, 'jovanny.schumm', 'tania92@example.com', '2022-08-14 22:03:04', 0, '2022-08-14 22:03:04', '1', 7884, 1, 'COeEmr84n8', '2022-08-14 22:03:04', '2022-08-14 22:03:04'),
	(5, 'Vivian Waters', 6744187, 'linwood.oconner', 'kfisher@example.org', '2022-08-14 22:03:04', 0, '2022-08-14 22:03:04', '1', 6772, 1, 'jClvAu7ilY', '2022-08-14 22:03:04', '2022-08-14 22:03:04'),
	(6, 'Mafalda Kirlin', 78999424, 'mrohan', 'elna.mitchell@example.org', '2022-08-14 22:03:04', 0, '2022-08-14 22:03:04', '1', 4464, 1, 'GYQybpM91A', '2022-08-14 22:03:04', '2022-08-14 22:03:04'),
	(7, 'Ramon Kuhic', 37494416, 'khalil.dubuque', 'walsh.anabelle@example.org', '2022-08-14 22:03:04', 0, '2022-08-14 22:03:04', '1', 3065, 1, 'WKR9pBb4Ja', '2022-08-14 22:03:04', '2022-08-14 22:03:04'),
	(8, 'Miss Kristin Kuhlman', 34485822, 'roxane35', 'monroe57@example.net', '2022-08-14 22:03:04', 0, '2022-08-14 22:03:04', '1', 5226, 1, 'jaBm86ly6T', '2022-08-14 22:03:04', '2022-08-14 22:03:04'),
	(9, 'Mr. Ben Batz', 26381872, 'emmerich.kraig', 'mandy.walker@example.com', '2022-08-14 22:03:04', 0, '2022-08-14 22:03:04', '1', 3703, 1, 'x64a7C8aSW', '2022-08-14 22:03:04', '2022-08-14 22:03:04'),
	(10, 'Prof. Aiden Shanahan III', 50381766, 'jjaskolski', 'malcolm94@example.com', '2022-08-14 22:03:04', 0, '2022-08-14 22:03:04', '1', 7462, 1, 'D3sVk2loJv', '2022-08-14 22:03:04', '2022-08-14 22:03:04');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `user_achievements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `personal_number` bigint(20) unsigned NOT NULL,
  `achievements_id` bigint(20) unsigned NOT NULL,
  `congrats_view` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `user_achievements` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_achievements` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `user_levels` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `personal_number` bigint(20) unsigned NOT NULL,
  `level_before` bigint(20) unsigned NOT NULL,
  `level_after` bigint(20) unsigned NOT NULL,
  `congrats_view` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `user_levels` DISABLE KEYS */;
INSERT INTO `user_levels` (`id`, `personal_number`, `level_before`, `level_after`, `congrats_view`, `created_at`, `updated_at`) VALUES
	(1, 55268111, 3, 3, 0, NULL, NULL);
/*!40000 ALTER TABLE `user_levels` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `user_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `user_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_logs` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
