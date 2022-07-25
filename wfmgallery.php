<?php

/*
Plugin Name: WFM Gallery
Plugin URI: https://webformyself.com
Description: Плагин позволяет создавать галереи для постов
Version: 1.0
Author: Andrey Kudlay
Author URI: https://webformyself.com
Text Domain: wfmgallery
Domain Path: /languages
*/

defined( 'ABSPATH' ) or die;
define( 'WFMGALLERY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WFMGALLERY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WFMGALLERY_PLUGIN_NAME', dirname( plugin_basename( __FILE__ ) ) );

function wfmgallery_activate() {
	require_once WFMGALLERY_PLUGIN_DIR . 'includes/class-wfmgallery-activate.php';
	Wfmgallery_Activate::activate();
}

register_activation_hook( __FILE__, 'wfmgallery_activate' );

require_once WFMGALLERY_PLUGIN_DIR . 'includes/class-wfmgallery.php';

function run_wfmgallery() {
	$plugin = new Wfmgallery();
}

run_wfmgallery();
