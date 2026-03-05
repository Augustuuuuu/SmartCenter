<?php
/**
 * Card de produto - SmartCenter
 *
 * @package SmartCenter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$badge = '';
if ( function_exists( 'smartcenter_get_product_condition' ) ) {
	$badge = smartcenter_get_product_condition( $product->get_id() );
} else {
	$badge = $product->is_type( 'simple' ) && $product->is_in_stock() ? __( 'Novo', 'smartcenter' ) : '';
}
?>
<li class="sc-product-card">
	<a href="<?php the_permalink(); ?>" class="sc-card-link">
		<div class="sc-card-image">
			<?php if ( $badge ) : ?>
				<span class="sc-card-badge"><?php echo esc_html( $badge ); ?></span>
			<?php endif; ?>
			<?php echo $product->get_image( 'woocommerce_thumbnail' ); ?>
		</div>
	</a>
	<div class="sc-card-body">
		<a href="<?php the_permalink(); ?>">
			<h3 class="sc-card-title"><?php the_title(); ?></h3>
		</a>
		<div class="sc-card-price"><?php echo $product->get_price_html(); ?></div>
		<?php if ( $product->get_price() ) : ?>
			<div class="sc-card-installment">
				<?php
				$price = (float) $product->get_price();
				if ( $price >= 12 ) {
					$parcela = $price / 12;
					printf(
						/* translators: 1: number of installments, 2: value */
						esc_html__( 'ou em até 12x de %s', 'smartcenter' ),
						wc_price( $parcela )
					);
				}
				?>
			</div>
		<?php endif; ?>
		<?php if ( wc_review_ratings_count() > 0 ) : ?>
			<div class="sc-card-rating">
				<span class="stars"><?php echo wc_get_rating_html( $product->get_average_rating() ); ?></span>
				<span>(<?php echo (int) $product->get_review_count(); ?>)</span>
			</div>
		<?php endif; ?>
		<?php woocommerce_template_loop_add_to_cart(); ?>
	</div>
</li>
