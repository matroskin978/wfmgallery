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

}
