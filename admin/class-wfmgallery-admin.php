<?php

class Wfmgallery_Admin {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts_styles' ) );
	}

	public function enqueue_scripts_styles() {
		wp_enqueue_style( 'wfmgallery', WFMGALLERY_PLUGIN_URL . 'admin/css/wfmgallery-admin.css' );

		wp_enqueue_script( 'wfmgallery', WFMGALLERY_PLUGIN_URL . 'admin/js/wfmgallery-admin.js', array( 'jquery' ) );
	}

}
