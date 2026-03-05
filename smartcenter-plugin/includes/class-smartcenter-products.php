<?php
/**
 * Campos de produto: condição, marca, especificações, relevante, destaque
 *
 * @package SmartCenter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SmartCenter_Products {

	private static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'woocommerce_product_options_general_product_data', array( $this, 'add_product_fields' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'save_product_fields' ) );
		add_action( 'woocommerce_product_options_inventory_product_data', array( $this, 'add_inventory_fields' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'save_inventory_fields' ) );
	}

	public function add_product_fields() {
		global $post;
		$cond = get_post_meta( $post->ID, 'sc_product_condition', true );
		$brand = get_post_meta( $post->ID, 'sc_product_brand', true );
		$relevant = get_post_meta( $post->ID, 'sc_product_relevant', true );
		$highlight = get_post_meta( $post->ID, 'sc_product_highlight', true );
		$cond_options = SmartCenter_Helpers::get_condition_options();
		echo '<div class="options_group">';
		woocommerce_wp_select( array(
			'id'      => 'sc_product_condition',
			'label'   => __( 'Condição / Tipo', 'smartcenter' ),
			'options' => array_merge( array( '' => __( '— Selecione —', 'smartcenter' ) ), $cond_options ),
			'value'   => $cond,
		) );
		woocommerce_wp_text_input( array(
			'id'    => 'sc_product_brand',
			'label' => __( 'Marca', 'smartcenter' ),
			'value' => $brand,
		) );
		woocommerce_wp_checkbox( array(
			'id'          => 'sc_product_relevant',
			'label'       => __( 'Produto relevante', 'smartcenter' ),
			'description' => __( 'Aparece na página inicial', 'smartcenter' ),
			'value'       => ( $relevant === '1' || $relevant === 'yes' ) ? 'yes' : '',
		) );
		woocommerce_wp_checkbox( array(
			'id'          => 'sc_product_highlight',
			'label'       => __( 'Em destaque', 'smartcenter' ),
			'description' => __( 'Destaque na loja (também marca como Featured no WooCommerce)', 'smartcenter' ),
			'value'       => ( $highlight === '1' || $highlight === 'yes' || has_term( 'featured', 'product_visibility', $post ) ) ? 'yes' : '',
		) );
		echo '</div>';

		echo '<div class="options_group">';
		woocommerce_wp_text_input( array( 'id' => 'sc_product_ram', 'label' => __( 'RAM', 'smartcenter' ), 'value' => get_post_meta( $post->ID, 'sc_product_ram', true ) ) );
		woocommerce_wp_text_input( array( 'id' => 'sc_product_storage', 'label' => __( 'Armazenamento', 'smartcenter' ), 'value' => get_post_meta( $post->ID, 'sc_product_storage', true ) ) );
		woocommerce_wp_text_input( array( 'id' => 'sc_product_screen', 'label' => __( 'Tela', 'smartcenter' ), 'value' => get_post_meta( $post->ID, 'sc_product_screen', true ) ) );
		woocommerce_wp_text_input( array( 'id' => 'sc_product_camera', 'label' => __( 'Câmera', 'smartcenter' ), 'value' => get_post_meta( $post->ID, 'sc_product_camera', true ) ) );
		woocommerce_wp_text_input( array( 'id' => 'sc_product_battery', 'label' => __( 'Bateria', 'smartcenter' ), 'value' => get_post_meta( $post->ID, 'sc_product_battery', true ) ) );
		woocommerce_wp_text_input( array( 'id' => 'sc_product_os', 'label' => __( 'Sistema operacional', 'smartcenter' ), 'value' => get_post_meta( $post->ID, 'sc_product_os', true ) ) );
		woocommerce_wp_text_input( array( 'id' => 'sc_product_processor', 'label' => __( 'Processador', 'smartcenter' ), 'value' => get_post_meta( $post->ID, 'sc_product_processor', true ) ) );
		woocommerce_wp_text_input( array( 'id' => 'sc_product_connectivity', 'label' => __( 'Conectividade', 'smartcenter' ), 'value' => get_post_meta( $post->ID, 'sc_product_connectivity', true ) ) );
		woocommerce_wp_text_input( array( 'id' => 'sc_product_weight', 'label' => __( 'Peso', 'smartcenter' ), 'value' => get_post_meta( $post->ID, 'sc_product_weight', true ) ) );
		woocommerce_wp_text_input( array( 'id' => 'sc_product_dimensions', 'label' => __( 'Dimensões', 'smartcenter' ), 'value' => get_post_meta( $post->ID, 'sc_product_dimensions', true ) ) );
		woocommerce_wp_textarea_input( array( 'id' => 'sc_product_accessories', 'label' => __( 'Acessórios inclusos', 'smartcenter' ), 'value' => get_post_meta( $post->ID, 'sc_product_accessories', true ) ) );
		echo '</div>';

		echo '<div class="options_group">';
		woocommerce_wp_text_input( array(
			'id'          => 'sc_product_cost',
			'label'       => __( 'Preço de custo', 'smartcenter' ),
			'description' => __( 'Apenas no painel, não exibido no site.', 'smartcenter' ),
			'value'       => get_post_meta( $post->ID, 'sc_product_cost', true ),
			'type'        => 'number',
			'custom_attributes' => array( 'step' => '0.01' ),
		) );
		echo '</div>';
	}

	public function save_product_fields( $post_id ) {
		$fields = array(
			'sc_product_condition', 'sc_product_brand', 'sc_product_ram', 'sc_product_storage',
			'sc_product_screen', 'sc_product_camera', 'sc_product_battery', 'sc_product_os',
			'sc_product_processor', 'sc_product_connectivity', 'sc_product_weight',
			'sc_product_dimensions', 'sc_product_accessories', 'sc_product_cost',
		);
		foreach ( $fields as $key ) {
			if ( isset( $_POST[ $key ] ) ) {
				update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
			}
		}
		if ( isset( $_POST['sc_product_relevant'] ) ) {
			update_post_meta( $post_id, 'sc_product_relevant', '1' );
		} else {
			delete_post_meta( $post_id, 'sc_product_relevant' );
		}
		if ( isset( $_POST['sc_product_highlight'] ) ) {
			update_post_meta( $post_id, 'sc_product_highlight', '1' );
			wp_set_object_terms( $post_id, 'featured', 'product_visibility' );
		} else {
			delete_post_meta( $post_id, 'sc_product_highlight' );
			wp_remove_object_terms( $post_id, 'featured', 'product_visibility' );
		}
	}

	public function add_inventory_fields() {
		global $post;
		woocommerce_wp_text_input( array(
			'id'          => 'sc_stock_min',
			'label'       => __( 'Estoque mínimo (alerta)', 'smartcenter' ),
			'value'       => get_post_meta( $post->ID, 'sc_stock_min', true ),
			'type'        => 'number',
			'custom_attributes' => array( 'min' => '0' ),
		) );
	}

	public function save_inventory_fields( $post_id ) {
		if ( isset( $_POST['sc_stock_min'] ) && is_numeric( $_POST['sc_stock_min'] ) ) {
			update_post_meta( $post_id, 'sc_stock_min', (int) $_POST['sc_stock_min'] );
		}
	}
}
