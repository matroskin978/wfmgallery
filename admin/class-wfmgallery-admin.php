<?php

class Wfmgallery_Admin {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts_styles' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_post_save_gallery', array( $this, 'save_gallery' ) );
	}

	public static function get_gallery( $id ) {
		global $wpdb;
		$id = (int) $id;
		return $wpdb->get_results( "SELECT * FROM wfm_gallery WHERE id={$id}", ARRAY_A );
	}

	public function save_gallery() {
		if ( ! isset( $_POST['wfmgallery_add'] ) || ! wp_verify_nonce( $_POST['wfmgallery_add'], 'wfmgallery_action' ) ) {
			wp_die( __( 'Error!', 'wfmgallery' ) );
		}

		$gallery_content = isset( $_POST['gallery_content'] ) ? trim( $_POST['gallery_content'] ) : '';
		$gallery_id      = isset( $_POST['gallery_id'] ) ? (int) $_POST['gallery_id'] : 0;

		if ( empty( $gallery_content ) ) {
			set_transient( 'wfmgallery_form_errors', __( 'Add images to gallery', 'wfmgallery' ), 30 );
		} else {
			$gallery_content = wp_unslash( $gallery_content );
			$gallery = '';

			$re = "#<img .+?>#";
			preg_match_all($re, $gallery_content, $matches);
			if ($matches[0]) {
				foreach ($matches[0] as $match) {
					$gallery .= $match;
				}

				global $wpdb;
				if ( $gallery_id ) {
					$query = "UPDATE wfm_gallery SET content = %s WHERE id = $gallery_id";
				} else {
					$query = "INSERT INTO wfm_gallery (content) VALUES (%s)";
				}

				if ( false !== $wpdb->query( $wpdb->prepare(
						$query, $gallery
					) ) ) {
					set_transient( 'wfmgallery_form_success', __( 'Gallery saved', 'wfmgallery' ), 30 );
				} else {
					set_transient( 'wfmgallery_form_errors', __( 'Error saving gallery', 'wfmgallery' ), 30 );
				}
			} else {
				set_transient( 'wfmgallery_form_errors', __( 'Add images to gallery', 'wfmgallery' ), 30 );
			}
		}
		wp_redirect( $_POST['_wp_http_referer'] );
		exit;
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
		add_submenu_page( 'wfmgallery-main', __( 'Add Gallery', 'wfmgallery' ), __( 'Add gallery', 'wfmgallery' ), 'manage_options', 'wfmgallery-add', array(
			$this,
			'render_gallery_add'
		) );
	}

	public function render_main_page() {
		require_once WFMGALLERY_PLUGIN_DIR . 'admin/templates/main-page-template.php';
	}

	public function render_gallery_add() {
		require_once WFMGALLERY_PLUGIN_DIR . 'admin/templates/addgallery-template.php';
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

		return $wpdb->get_results( "SELECT * FROM wfm_gallery ORDER BY id LIMIT {$pagination_info['start']}, $per_page", ARRAY_A );
	}

}
