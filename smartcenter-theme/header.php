<?php
/**
 * Header SmartCenter
 *
 * @package SmartCenter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'smartcenter-body' ); ?>>
<?php wp_body_open(); ?>

<div id="page" class="sc-site-wrapper">

	<?php smartcenter_navbar(); ?>

	<?php if ( is_front_page() || is_shop() ) : ?>
		<div class="sc-categories">
			<ul>
				<li><a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="<?php echo is_shop() && ! is_product_category() ? 'active' : ''; ?>"><?php esc_html_e( 'Todos', 'smartcenter' ); ?></a></li>
				<?php
				$categories = smartcenter_get_active_categories();
				foreach ( $categories as $cat ) :
					$link = get_term_link( $cat );
					if ( is_wp_error( $link ) ) continue;
					$current = is_product_category( $cat->term_id );
					?>
					<li><a href="<?php echo esc_url( $link ); ?>" class="<?php echo $current ? 'active' : ''; ?>"><?php echo esc_html( $cat->name ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<main id="main" class="sc-main" role="main">
