<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class SmartCenter_Helpers {
	private static $instance = null;
	public static function instance() {
		if ( null === self::$instance ) self::$instance = new self();
		return self::$instance;
	}
	private function __construct() {}
	public static function get_product_condition( $product_id ) {
		$tipo = get_post_meta( $product_id, 'sc_product_condition', true );
		if ( ! $tipo ) return __( 'Novo', 'smartcenter' );
		$opcoes = self::get_condition_options();
		return isset( $opcoes[ $tipo ] ) ? $opcoes[ $tipo ] : $tipo;
	}
	public static function get_condition_options() {
		return array(
			'novo' => __( 'Novo', 'smartcenter' ),
			'usado' => __( 'Usado', 'smartcenter' ),
			'seminovo' => __( 'Seminovo', 'smartcenter' ),
			'recondicionado' => __( 'Recondicionado', 'smartcenter' ),
			'vitrine' => __( 'Vitrine', 'smartcenter' ),
		);
	}
	public static function get_product_meta_line( $product_id ) {
		$product = wc_get_product( $product_id );
		if ( ! $product ) return '';
		$parts = array();
		$marca = get_post_meta( $product_id, 'sc_product_brand', true );
		if ( $marca ) $parts[] = $marca;
		$cond = self::get_product_condition( $product_id );
		if ( $cond ) $parts[] = $cond;
		$cor = $product->get_attribute( 'pa_cor' );
		if ( $cor ) $parts[] = $cor;
		$storage = $product->get_attribute( 'pa_armazenamento' );
		if ( $storage ) $parts[] = $storage;
		return implode( ' · ', $parts );
	}
	public static function get_product_specs( $product_id ) {
		$specs = array();
		$map = array(
			'sc_product_brand' => __( 'Marca', 'smartcenter' ),
			'sc_product_condition' => __( 'Condição', 'smartcenter' ),
			'sc_product_ram' => __( 'RAM', 'smartcenter' ),
			'sc_product_storage' => __( 'Armazenamento', 'smartcenter' ),
			'sc_product_screen' => __( 'Tela', 'smartcenter' ),
			'sc_product_camera' => __( 'Câmera', 'smartcenter' ),
			'sc_product_battery' => __( 'Bateria', 'smartcenter' ),
			'sc_product_os' => __( 'Sistema operacional', 'smartcenter' ),
			'sc_product_processor' => __( 'Processador', 'smartcenter' ),
			'sc_product_connectivity' => __( 'Conectividade', 'smartcenter' ),
		);
		$cond_options = self::get_condition_options();
		foreach ( $map as $meta_key => $label ) {
			$val = get_post_meta( $product_id, $meta_key, true );
			if ( $meta_key === 'sc_product_condition' && $val ) {
				$val = isset( $cond_options[ $val ] ) ? $cond_options[ $val ] : $val;
			}
			if ( $val !== '' && $val !== null ) $specs[ $label ] = $val;
		}
		$product = wc_get_product( $product_id );
		if ( $product ) {
			if ( $product->get_attribute( 'pa_cor' ) ) $specs[ __( 'Cor', 'smartcenter' ) ] = $product->get_attribute( 'pa_cor' );
			if ( $product->get_attribute( 'pa_armazenamento' ) ) $specs[ __( 'Armazenamento', 'smartcenter' ) ] = $product->get_attribute( 'pa_armazenamento' );
		}
		return $specs;
	}
}
if ( ! function_exists( 'smartcenter_get_product_condition' ) ) {
	function smartcenter_get_product_condition( $product_id ) { return SmartCenter_Helpers::get_product_condition( $product_id ); }
}
if ( ! function_exists( 'smartcenter_get_product_meta_line' ) ) {
	function smartcenter_get_product_meta_line( $product_id ) { return SmartCenter_Helpers::get_product_meta_line( $product_id ); }
}
if ( ! function_exists( 'smartcenter_get_product_specs' ) ) {
	function smartcenter_get_product_specs( $product_id ) { return SmartCenter_Helpers::get_product_specs( $product_id ); }
}
