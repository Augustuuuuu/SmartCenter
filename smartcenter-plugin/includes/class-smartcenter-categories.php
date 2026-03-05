<?php
/**
 * Categorias: ativo, ordem de exibição
 *
 * @package SmartCenter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SmartCenter_Categories {

	private static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'product_cat_add_form_fields', array( $this, 'add_category_fields' ), 10 );
		add_action( 'product_cat_edit_form_fields', array( $this, 'edit_category_fields' ), 10 );
		add_action( 'created_product_cat', array( $this, 'save_category_fields' ), 10 );
		add_action( 'edited_product_cat', array( $this, 'save_category_fields' ), 10 );
		add_filter( 'get_terms_args', array( $this, 'order_terms_by_meta' ), 10, 2 );
	}

	public function add_category_fields() {
		?>
		<div class="form-field">
			<label for="sc_category_active">
				<input type="checkbox" name="sc_category_active" id="sc_category_active" value="1" checked />
				<?php esc_html_e( 'Exibir no menu do site', 'smartcenter' ); ?>
			</label>
		</div>
		<div class="form-field">
			<label for="sc_category_order"><?php esc_html_e( 'Ordem de exibição', 'smartcenter' ); ?></label>
			<input type="number" name="sc_category_order" id="sc_category_order" value="0" min="0" />
		</div>
		<?php
	}

	public function edit_category_fields( $term ) {
		$active = get_term_meta( $term->term_id, 'sc_category_active', true );
		$order  = get_term_meta( $term->term_id, 'sc_category_order', true );
		if ( $active === '' ) {
			$active = '1';
		}
		?>
		<tr class="form-field">
			<th><label for="sc_category_active"><?php esc_html_e( 'Exibir no menu', 'smartcenter' ); ?></label></th>
			<td>
				<label>
					<input type="checkbox" name="sc_category_active" id="sc_category_active" value="1" <?php checked( $active, '1' ); ?> />
					<?php esc_html_e( 'Ativo (aparece na barra de categorias)', 'smartcenter' ); ?>
				</label>
			</td>
		</tr>
		<tr class="form-field">
			<th><label for="sc_category_order"><?php esc_html_e( 'Ordem', 'smartcenter' ); ?></label></th>
			<td>
				<input type="number" name="sc_category_order" id="sc_category_order" value="<?php echo esc_attr( $order ?: 0 ); ?>" min="0" />
			</td>
		</tr>
		<?php
	}

	public function save_category_fields( $term_id ) {
		if ( isset( $_POST['sc_category_active'] ) ) {
			update_term_meta( $term_id, 'sc_category_active', '1' );
		} else {
			update_term_meta( $term_id, 'sc_category_active', '0' );
		}
		if ( isset( $_POST['sc_category_order'] ) && is_numeric( $_POST['sc_category_order'] ) ) {
			update_term_meta( $term_id, 'sc_category_order', (int) $_POST['sc_category_order'] );
		}
	}

	/**
	 * Ordenar termos por sc_category_order quando for product_cat no front
	 */
	public function order_terms_by_meta( $args, $taxonomies ) {
		if ( in_array( 'product_cat', (array) $taxonomies, true ) && ! is_admin() ) {
			$args['meta_key'] = 'sc_category_order';
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'ASC';
		}
		return $args;
	}
}
