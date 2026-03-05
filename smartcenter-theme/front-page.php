<?php
/**
 * Página inicial - produtos em destaque/relevantes, sem banner grande
 *
 * @package SmartCenter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$query = smartcenter_get_featured_products( array(
	'paged' => $paged,
	'posts_per_page' => 12,
) );

$brands = get_terms( array( 'taxonomy' => 'pa_marca', 'hide_empty' => true ) );
if ( is_wp_error( $brands ) ) {
	$brands = array();
}
?>

<div class="sc-toolbar">
	<div class="sc-filters">
		<?php if ( ! empty( $brands ) ) : ?>
			<label for="sc-filter-brand"><?php esc_html_e( 'Marca:', 'smartcenter' ); ?></label>
			<select id="sc-filter-brand" name="marca">
				<option value=""><?php esc_html_e( 'Todas', 'smartcenter' ); ?></option>
				<?php foreach ( $brands as $brand ) : ?>
					<option value="<?php echo esc_attr( $brand->slug ); ?>"><?php echo esc_html( $brand->name ); ?></option>
				<?php endforeach; ?>
			</select>
		<?php endif; ?>
	</div>
	<div class="sc-sort">
		<label for="sc-orderby"><?php esc_html_e( 'Ordenar:', 'smartcenter' ); ?></label>
		<select id="sc-orderby" name="orderby">
			<option value="menu_order"><?php esc_html_e( 'Relevância', 'smartcenter' ); ?></option>
			<option value="price"><?php esc_html_e( 'Menor preço', 'smartcenter' ); ?></option>
			<option value="price-desc"><?php esc_html_e( 'Maior preço', 'smartcenter' ); ?></option>
			<option value="date"><?php esc_html_e( 'Lançamentos', 'smartcenter' ); ?></option>
			<option value="popularity"><?php esc_html_e( 'Mais vendidos', 'smartcenter' ); ?></option>
		</select>
	</div>
</div>

<ul class="products sc-products-grid" id="sc-products-grid">
	<?php
	if ( $query->have_posts() ) :
		while ( $query->have_posts() ) :
			$query->the_post();
			wc_get_template_part( 'content', 'product' );
		endwhile;
		wp_reset_postdata();
	else :
		?>
		<li class="sc-no-products"><?php esc_html_e( 'Nenhum produto em destaque no momento.', 'smartcenter' ); ?></li>
		<?php
	endif;
	?>
</ul>

<?php if ( $query->max_num_pages > 1 ) : ?>
	<nav class="sc-pagination sc-container">
		<?php
		echo wp_kses_post( paginate_links( array(
			'current'   => $paged,
			'total'     => $query->max_num_pages,
			'prev_text' => __( 'Anterior', 'smartcenter' ),
			'next_text' => __( 'Próxima', 'smartcenter' ),
		) ) );
		?>
	</nav>
<?php endif; ?>

<?php get_footer(); ?>
