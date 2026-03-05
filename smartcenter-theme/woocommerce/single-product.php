<?php
/**
 * Página single product - SmartCenter
 *
 * @package SmartCenter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$product = wc_get_product( get_the_ID() );
	if ( ! $product ) continue;
	?>
	<div class="sc-single-product">
		<div class="sc-gallery">
			<div class="sc-main-image">
				<?php echo $product->get_image( 'woocommerce_single' ); ?>
			</div>
			<?php if ( $product->get_gallery_image_ids() ) : ?>
				<div class="sc-thumbnails">
					<?php foreach ( $product->get_gallery_image_ids() as $img_id ) : ?>
						<img src="<?php echo esc_url( wp_get_attachment_image_url( $img_id, 'thumbnail' ) ); ?>" alt="" data-full="<?php echo esc_url( wp_get_attachment_image_url( $img_id, 'woocommerce_single' ) ); ?>">
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="sc-summary">
			<h1 class="sc-product-title"><?php the_title(); ?></h1>
			<div class="sc-meta">
				<?php
				if ( function_exists( 'smartcenter_get_product_meta_line' ) ) {
					echo smartcenter_get_product_meta_line( $product->get_id() );
				} else {
					echo esc_html( $product->get_short_description() );
				}
				?>
			</div>
			<?php if ( function_exists( 'smartcenter_get_product_specs' ) ) : ?>
				<ul class="sc-specs-list">
					<?php foreach ( smartcenter_get_product_specs( $product->get_id() ) as $label => $value ) : ?>
						<li><strong><?php echo esc_html( $label ); ?></strong> <span><?php echo esc_html( $value ); ?></span></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<div class="sc-price-block">
				<div class="sc-price"><?php echo $product->get_price_html(); ?></div>
				<div class="sc-installment">
					<?php
					$price = (float) $product->get_price();
					if ( $price >= 12 ) {
						printf( esc_html__( 'ou em até 12x de %s', 'smartcenter' ), wc_price( $price / 12 ) );
					}
					?>
				</div>
			</div>
			<?php woocommerce_template_single_add_to_cart(); ?>
			<div class="sc-shipping">
				<label for="sc-cep"><?php esc_html_e( 'Calcular frete:', 'smartcenter' ); ?></label>
				<input type="text" id="sc-cep" name="sc_cep" placeholder="00000-000" maxlength="9">
				<button type="button" class="button sc-calc-shipping"><?php esc_html_e( 'Calcular', 'smartcenter' ); ?></button>
			</div>
			<?php woocommerce_output_product_data_tabs(); ?>
		</div>
	</div>
	<?php
endwhile;

get_footer();
