<?php

class Wfmgallery {

	public function __construct() {
		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	private function load_dependencies() {
		require_once WFMGALLERY_PLUGIN_DIR . 'admin/class-wfmgallery-admin.php';
		require_once WFMGALLERY_PLUGIN_DIR . 'public/class-wfmgallery-public.php';
	}

	private function define_admin_hooks() {
		$plugin_admin = new Wfmgallery_Admin();
	}

	private function define_public_hooks() {
		$plugin_public = new Wfmgallery_Public();
	}

}
