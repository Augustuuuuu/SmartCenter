<?php
/**
 * Plugin Name: SmartCenter E-commerce
 * Description: Campos de produto, categorias ativas, produtos relevantes e integrações para o tema SmartCenter.
 * Version: 1.0.0
 * Author: SmartCenter
 * Text Domain: smartcenter
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * WC requires at least: 6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SMARTCENTER_PLUGIN_VERSION', '1.0.0' );
define( 'SMARTCENTER_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Campos de produto (condição, marca, especificações, relevante/destaque)
 */
require_once SMARTCENTER_PLUGIN_PATH . 'includes/class-smartcenter-products.php';
/**
 * Categorias (ativo, ordem)
 */
require_once SMARTCENTER_PLUGIN_PATH . 'includes/class-smartcenter-categories.php';
/**
 * Helpers para o tema
 */
require_once SMARTCENTER_PLUGIN_PATH . 'includes/class-smartcenter-helpers.php';

function smartcenter_plugin_init() {
	load_plugin_textdomain( 'smartcenter', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	SmartCenter_Products::instance();
	SmartCenter_Categories::instance();
	SmartCenter_Helpers::instance();
}
add_action( 'plugins_loaded', 'smartcenter_plugin_init' );
