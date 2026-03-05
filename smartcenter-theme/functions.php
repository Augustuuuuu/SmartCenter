<?php
/**
 * SmartCenter Theme Functions
 *
 * @package SmartCenter
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SMARTCENTER_THEME_VERSION', '1.0.0' );

/**
 * Suporte ao tema: WooCommerce, título, thumbnails, etc.
 */
function smartcenter_theme_setup() {
	load_theme_textdomain( 'smartcenter', get_stylesheet_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'smartcenter_theme_setup' );

/**
 * Enfileira estilos e scripts
 */
function smartcenter_enqueue_assets() {
	$uri = get_stylesheet_directory_uri();
	$ver = SMARTCENTER_THEME_VERSION;

	$parent_dep = ( get_template() === 'storefront' ) ? array( 'storefront-style' ) : array();
	wp_enqueue_style(
		'smartcenter-style',
		get_stylesheet_uri(),
		$parent_dep,
		$ver
	);

	wp_enqueue_style(
		'smartcenter-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_script(
		'smartcenter-main',
		$uri . '/assets/js/main.js',
		array( 'jquery' ),
		$ver,
		true
	);

	wp_localize_script( 'smartcenter-main', 'smartcenter_i18n', array(
		'cart_drawer_title' => __( 'Sacola', 'smartcenter' ),
		'close'             => __( 'Fechar', 'smartcenter' ),
		'checkout'          => __( 'Finalizar compra', 'smartcenter' ),
		'login_required'    => __( 'Você precisa estar logado para finalizar a compra. Faça login ou cadastre-se gratuitamente.', 'smartcenter' ),
		'ajax_url'          => admin_url( 'admin-ajax.php' ),
		'nonce'             => wp_create_nonce( 'smartcenter_nonce' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'smartcenter_enqueue_assets', 20 );

/**
 * Declara dependência do tema pai (Storefront)
 */
function smartcenter_child_theme_parent_style() {
	if ( get_template() === 'storefront' ) {
		wp_enqueue_style(
			'storefront-style',
			get_template_directory_uri() . '/style.css',
			array(),
			SMARTCENTER_THEME_VERSION
		);
	}
}
add_action( 'wp_enqueue_scripts', 'smartcenter_child_theme_parent_style', 10 );

/**
 * Registra menus
 */
function smartcenter_register_menus() {
	register_nav_menus( array(
		'primary' => __( 'Menu principal', 'smartcenter' ),
	) );
}
add_action( 'init', 'smartcenter_register_menus' );

/**
 * Navbar customizada (substitui header do Storefront na home/shop)
 */
function smartcenter_navbar() {
	$cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	?>
	<nav class="sc-navbar" role="navigation">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sc-logo"><?php bloginfo( 'name' ); ?></a>
		<div class="sc-search">
			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="search" name="s" placeholder="<?php esc_attr_e( 'Buscar produtos...', 'smartcenter' ); ?>" value="<?php echo get_search_query(); ?>" />
				<input type="hidden" name="post_type" value="product" />
			</form>
		</div>
		<div class="sc-actions">
			<?php if ( function_exists( 'YITH_WCWL' ) ) : ?>
				<a href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ); ?>" title="<?php esc_attr_e( 'Favoritos', 'smartcenter' ); ?>" aria-label="<?php esc_attr_e( 'Favoritos', 'smartcenter' ); ?>">
					<svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
				</a>
			<?php endif; ?>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" title="<?php esc_attr_e( 'Minha conta', 'smartcenter' ); ?>" aria-label="<?php esc_attr_e( 'Minha conta', 'smartcenter' ); ?>">
				<svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
			</a>
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="sc-cart-trigger" title="<?php esc_attr_e( 'Sacola', 'smartcenter' ); ?>" aria-label="<?php esc_attr_e( 'Sacola', 'smartcenter' ); ?>">
				<svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
				<?php if ( $cart_count > 0 ) : ?>
					<span class="cart-count"><?php echo (int) $cart_count; ?></span>
				<?php endif; ?>
			</a>
		</div>
	</nav>
	<?php
}

/**
 * Lista categorias ativas (para menu da home)
 */
function smartcenter_get_active_categories() {
	$args = array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => true,
		'number'     => 20,
	);
	if ( function_exists( 'get_term_meta' ) ) {
		$args['meta_query'] = array(
			array(
				'key'     => 'sc_category_active',
				'value'   => '1',
				'compare' => '=',
			),
		);
		$args['meta_key'] = 'sc_category_order';
		$args['orderby']  = 'meta_value_num';
		$args['order']    = 'ASC';
	} else {
		$args['orderby'] = 'name';
		$args['order']   = 'ASC';
	}
	$categories = get_terms( $args );
	if ( is_wp_error( $categories ) || empty( $categories ) ) {
		$categories = get_terms( array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => true,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'number'     => 12,
		) );
	}
	return $categories;
}

/**
 * Query produtos em destaque (featured) + relevantes (meta) para a home.
 */
function smartcenter_get_featured_products( $args = array() ) {
	$per_page = isset( $args['posts_per_page'] ) ? (int) $args['posts_per_page'] : 12;
	$paged   = isset( $args['paged'] ) ? (int) $args['paged'] : 1;

	$featured_ids = array();
	$q_featured = new WP_Query( array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'posts_per_page' => 200,
		'tax_query'      => array(
			array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
			),
		),
	) );
	if ( $q_featured->have_posts() ) {
		$featured_ids = $q_featured->posts;
	}

	$relevant_ids = array();
	$q_relevant = new WP_Query( array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'posts_per_page' => 200,
		'meta_query'     => array(
			array( 'key' => 'sc_product_relevant', 'value' => '1' ),
		),
	) );
	if ( $q_relevant->have_posts() ) {
		$relevant_ids = $q_relevant->posts;
	}

	$ids = array_unique( array_merge( $featured_ids, $relevant_ids ) );
	if ( empty( $ids ) ) {
		$ids = array( 0 );
	}

	$defaults = array(
		'post_type'      => 'product',
		'posts_per_page' => $per_page,
		'paged'          => $paged,
		'post_status'    => 'publish',
		'post__in'       => $ids,
		'orderby'        => 'post__in',
	);
	return new WP_Query( wp_parse_args( $args, $defaults ) );
}

/**
 * Redireciona checkout para login se não logado (mensagem em PT-BR)
 */
function smartcenter_checkout_login_redirect() {
	if ( is_checkout() && ! is_user_logged_in() && ! is_wc_endpoint_url( 'order-received' ) ) {
		wc_add_notice( __( 'Você precisa estar logado para finalizar a compra. Faça login ou cadastre-se gratuitamente.', 'smartcenter' ), 'error' );
		wp_safe_redirect( add_query_arg( 'redirect_to', urlencode( wc_get_checkout_url() ), wc_get_page_permalink( 'myaccount' ) ) );
		exit;
	}
}
add_action( 'template_redirect', 'smartcenter_checkout_login_redirect' );

/**
 * Após login, redireciona para checkout se veio do redirect_to
 */
function smartcenter_redirect_after_login( $redirect, $user ) {
	if ( ! empty( $_GET['redirect_to'] ) && wp_validate_redirect( $_GET['redirect_to'], false ) ) {
		return esc_url_raw( wp_unslash( $_GET['redirect_to'] ) );
	}
	return $redirect;
}
add_filter( 'woocommerce_login_redirect', 'smartcenter_redirect_after_login', 10, 2 );

/**
 * Botão "Comprar" no loop com classe do tema
 */
function smartcenter_loop_add_to_cart_args( $args, $product ) {
	$args['class'] = isset( $args['class'] ) ? $args['class'] . ' sc-btn-buy' : 'sc-btn-buy button';
	return $args;
}
add_filter( 'woocommerce_loop_add_to_cart_args', 'smartcenter_loop_add_to_cart_args', 10, 2 );

/**
 * Remove versão do WordPress do head (segurança)
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * AJAX: atualizar mini cart no drawer
 */
function smartcenter_ajax_refresh_mini_cart() {
	ob_start();
	woocommerce_mini_cart();
	wp_send_json_success( array( 'html' => ob_get_clean() ) );
}
add_action( 'wp_ajax_smartcenter_refresh_mini_cart', 'smartcenter_ajax_refresh_mini_cart' );
add_action( 'wp_ajax_nopriv_smartcenter_refresh_mini_cart', 'smartcenter_ajax_refresh_mini_cart' );

/**
 * Inclui template parts
 */
function smartcenter_get_template_part( $slug, $name = null ) {
	get_template_part( $slug, $name );
}
