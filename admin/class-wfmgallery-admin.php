<?php

class Wfmgallery_Admin {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts_styles' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	public function enqueue_scripts_styles() {
		wp_enqueue_style( 'wfmgallery', WFMGALLERY_PLUGIN_URL . 'admin/css/wfmgallery-admin.css' );

		wp_enqueue_script( 'wfmgallery', WFMGALLERY_PLUGIN_URL . 'admin/js/wfmgallery-admin.js', array( 'jquery' ) );
	}

	public function admin_menu() {
		add_menu_page( __( 'WFM Gallery Main', 'wfmgallery' ), __( 'WFM Gallery', 'wfmgallery' ), 'manage_options', 'wfmgallery-main', array(
			$this,
			'render_main_page'
		), 'dashicons-format-gallery' );

		add_submenu_page( 'wfmgallery-main', __( 'WFM Gallery Main', 'wfmgallery' ), __( 'Galleries List', 'wfmgallery' ), 'manage_options', 'wfmgallery-main' );
		add_submenu_page( 'wfmgallery-main', __( 'Add Gallery', 'wfmgallery' ), __( 'New gallery', 'wfmgallery' ), 'manage_options', 'wfmgallery-new', array(
			$this,
			'render_gallery_new'
		) );
	}

	public function render_main_page() {
		require_once WFMGALLERY_PLUGIN_DIR . 'admin/templates/main-page-template.php';
	}

	public function render_gallery_new() {
		require_once WFMGALLERY_PLUGIN_DIR . 'admin/templates/newgallery-template.php';
	}

	public static function debug( $data ) {
		echo "<pre>" . print_r( $data, 1 ) . "</pre>";
	}

	public static function get_pagination_info( $per_page ) {
		global $wpdb;

		$rows = $wpdb->get_var( "SELECT COUNT(*) FROM wfm_gallery" );

		$total_pages = ceil($rows / $per_page) ?: 1;

		$paged = $_GET['paged'] ?? 1;
		if (!$paged || $paged < 1) {
			$paged = 1;
		}
		if ($paged > $total_pages) {
			$paged = $total_pages;
		}

		$start = ($paged - 1) * $per_page;

		return array(
			'rows' => $rows,
			'total_pages' => $total_pages,
			'paged' => $paged,
			'start' => $start,
		);
	}

	public static function get_galleries( $per_page ) {
		global $wpdb;
		$pagination_info = self::get_pagination_info( $per_page );

		return $wpdb->get_results( "SELECT * FROM wfm_gallery ORDER BY id LIMIT {$pagination_info['start']}, $per_page" );
	}

}
