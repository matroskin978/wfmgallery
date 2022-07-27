<?php

class Wfmgallery_Public {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts_styles' ) );
		add_shortcode( 'wfmgallery', array( $this, 'wfmgallery_shortcode' ) );
	}

	public function wfmgallery_shortcode( $atts ) {
		$atts = shortcode_atts( array (
			'id' => 0,
		), $atts );
		$id = (int) $atts['id'];
		$html = $this->get_gallery_html( $id );
		return $html;
	}

	private function get_gallery_html( $id ) {
		$gallery = Wfmgallery_Admin::get_gallery( $id );
		if ( empty( $gallery[0]['content'] ) ) {
			return '';
		}

		$re = "#<img .+?>#";
		preg_match_all($re, $gallery[0]['content'], $matches);
		$html = '';
		if ( $matches[0] ) {
			$html = '<div class="wfmgallery owl-carousel owl-theme">';
			foreach ( $matches[0] as $item ) {
				$html .= "<div>{$item}</div>";
			}
			$html .= '</div>';
		}
		return $html;
	}

	public function enqueue_scripts_styles() {
		wp_enqueue_style( 'wfmgallery-owlcarousel', WFMGALLERY_PLUGIN_URL . 'public/assets/owlcarousel/assets/owl.carousel.min.css' );
		wp_enqueue_style( 'wfmgallery-owlcarousel-theme', WFMGALLERY_PLUGIN_URL . 'public/assets/owlcarousel/assets/owl.theme.default.min.css' );
		wp_enqueue_style( 'wfmgallery', WFMGALLERY_PLUGIN_URL . 'public/css/wfmgallery-public.css' );
		wp_enqueue_script( 'wfmgallery-owlcarousel', WFMGALLERY_PLUGIN_URL . 'public/assets/owlcarousel/owl.carousel.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'wfmgallery', WFMGALLERY_PLUGIN_URL . 'public/js/wfmgallery-public.js', array( 'wfmgallery-owlcarousel' ), false, true );
	}

}
