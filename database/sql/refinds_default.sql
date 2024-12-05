

-- Dumping structure for table db_refinds.kategori
CREATE TABLE IF NOT EXISTS `kategori` (
  `id_kategori` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_kategori` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_refinds.kategori: ~4 rows (approximately)
INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `deskripsi_kategori`, `created_at`, `updated_at`) VALUES
	(1, 'elektronik', 'Officia error non doloribus unde. Delectus qui nihil omnis. Doloremque eveniet quidem voluptates deleniti rerum beatae. Sint quisquam eius in voluptas unde.', '2024-10-24 16:16:13', '2024-11-07 06:32:54'),
	(2, 'furniture', 'Consequatur distinctio unde qui molestias in qui quas. Quo dolorem esse eos nesciunt. Et eius velit aperiam recusandae.', '2024-10-24 16:16:13', '2024-11-07 06:32:54'),
	(3, 'pakaian', 'Non dolores doloremque ut eius ipsum distinctio. In consequuntur aut alias. Et autem iste et odio earum ex. Quod ipsum doloremque laborum.', '2024-10-24 16:16:13', '2024-11-07 06:32:54'),
	(4, 'alat rumah tangga', 'Quidem sit rerum quis aperiam nesciunt vero. Sed optio illum molestiae voluptatem asperiores. Aut sit deserunt ullam itaque atque ullam suscipit a. Ratione velit ea beatae.', '2024-10-24 16:16:13', '2024-11-07 06:32:54');


-- Dumping structure for table db_refinds.subkategori
CREATE TABLE IF NOT EXISTS `subkategori` (
  `id_subkategori` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_kategori` bigint unsigned NOT NULL,
  `nama_subkategori` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_subkategori` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_subkategori`),
  KEY `subkategori_id_kategori_foreign` (`id_kategori`),
  CONSTRAINT `subkategori_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_refinds.subkategori: ~16 rows (approximately)
INSERT INTO `subkategori` (`id_subkategori`, `id_kategori`, `nama_subkategori`, `deskripsi_subkategori`, `created_at`, `updated_at`) VALUES
	(1, 1, 'laptop', 'Omnis aspernatur autem doloribus quia ut nam nisi occaecati. Sit fuga temporibus repellendus odit eveniet. Et possimus veritatis rerum. Similique pariatur sunt ut non.', '2024-10-24 16:16:13', '2024-11-07 06:32:54'),
	(2, 1, 'mouse', 'Fugit laudantium quia quisquam ex odit. Vel molestias facilis est consequatur praesentium aut deleniti. Quae omnis est soluta expedita. Ut non illum omnis repudiandae officiis.', '2024-10-24 16:16:13', '2024-11-07 06:32:54'),
	(3, 1, 'keyboard', 'Vitae vitae eius mollitia nostrum. Sint voluptatem laudantium qui neque autem odit fugit. Officiis velit asperiores delectus asperiores. Et neque ut dolor est aut.', '2024-10-24 16:16:13', '2024-11-07 06:32:54'),
	(4, 1, 'hp', 'Minus ea sunt quidem asperiores. Aut sunt et esse autem cumque. Eum aut et sunt voluptatem magni. Nesciunt tempora a molestiae quibusdam.', '2024-10-24 16:16:13', '2024-11-07 06:32:54'),
	(5, 2, 'kursi', 'Perspiciatis autem velit animi dignissimos nulla nobis est similique. Voluptate ratione animi laudantium expedita ea. Optio totam asperiores at aut sit sequi. Laudantium nam qui eos.', '2024-10-24 16:16:13', '2024-11-07 06:32:54'),
	(6, 2, 'lampu', 'Voluptatum sint unde corporis asperiores ut. Vero aut fuga voluptatem aspernatur. In rem perferendis ratione ut.', '2024-10-24 16:16:13', '2024-11-07 06:32:54'),
	(7, 2, 'meja', 'Aliquam fuga et voluptatem vitae ipsa illum. A sint quas voluptates beatae omnis quia sed. Omnis aut dolore unde magnam autem quia enim in. Ut reprehenderit dolore magnam tempora cupiditate error.', '2024-10-24 16:16:14', '2024-11-07 06:32:54'),
	(8, 2, 'rak', 'Quo quidem id reiciendis accusamus labore eos exercitationem. Voluptas odio sint odio consectetur minima officiis eos. Velit recusandae non iusto quis sapiente voluptatem.', '2024-10-24 16:16:14', '2024-11-07 06:32:54'),
	(9, 3, 'topi', 'Molestiae consectetur veritatis qui doloremque et. Et perferendis nihil porro ipsum repellat necessitatibus. Qui quaerat tempora qui necessitatibus sit ipsam molestiae.', '2024-10-24 16:16:15', '2024-11-07 06:32:54'),
	(10, 3, 'sepatu', 'Quia aspernatur labore ipsa inventore hic aut. Recusandae dolore facilis repudiandae animi unde sint.', '2024-10-24 16:16:15', '2024-11-07 06:32:54'),
	(11, 3, 'celana', 'Magnam ab sit consequatur architecto nemo et. Id sint non dolore voluptatem maiores.', '2024-10-24 16:16:15', '2024-11-07 06:32:54'),
	(12, 3, 'baju', 'Eos tempora amet non sapiente mollitia deserunt ratione. Quasi qui aliquam nihil quod amet. Non suscipit voluptatum non deserunt recusandae aliquid.', '2024-10-24 16:16:16', '2024-11-07 06:32:54'),
	(13, 4, 'piring', 'Atque quibusdam tempora dolorem reprehenderit facere. Nemo commodi autem illo pariatur. Neque qui id adipisci eius velit consequatur quia. Doloremque veritatis et aliquam deleniti modi numquam.', '2024-10-24 16:16:16', '2024-11-07 06:32:54'),
	(14, 4, 'gelas', 'Molestias quia earum illo dolore. At facere soluta dolores blanditiis. Alias unde quam numquam fuga enim est. Sunt suscipit placeat expedita ut nihil suscipit rerum.', '2024-10-24 16:16:17', '2024-11-07 06:32:54'),
	(15, 4, 'wajan', 'Qui rem autem neque qui. Autem sunt temporibus mollitia eos ducimus id quo atque. Unde ea quisquam ipsa et molestiae culpa.', '2024-10-24 16:16:17', '2024-11-07 06:32:54'),
	(16, 4, 'mangkok', 'Ea et consequatur earum reprehenderit non eum alias aut. Dolorum sed est veniam voluptatum ducimus provident ea. Eos velit quia ut illo qui eius.', '2024-10-24 16:16:17', '2024-11-07 06:32:54');

