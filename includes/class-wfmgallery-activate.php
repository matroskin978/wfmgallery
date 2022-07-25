<?php

class Wfmgallery_Activate {

	public static function activate() {
//		file_put_contents(WFMGALLERY_PLUGIN_DIR . 'log.txt', "Плагин активирован.\n", FILE_APPEND);
		global $wpdb;
		$wpdb->query( "CREATE TABLE IF NOT EXISTS `wfm_gallery` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci" );
	}

}
