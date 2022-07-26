<?php

class Wfmgallery_Public {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts_styles' ) );
	}

	public function enqueue_scripts_styles() {
		wp_enqueue_style( 'wfmgallery', WFMGALLERY_PLUGIN_URL . 'public/css/wfmgallery-public.css' );
		wp_enqueue_script( 'wfmgallery', WFMGALLERY_PLUGIN_URL . 'public/js/wfmgallery-public.js', array( 'jquery' ), false, true );
	}

}
