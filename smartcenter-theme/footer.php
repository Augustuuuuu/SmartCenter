<?php
/**
 * Footer SmartCenter - minimalista, links legais e CNPJ
 *
 * @package SmartCenter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cnpj = get_theme_mod( 'smartcenter_cnpj', '' );
?>
	</main><!-- #main -->

	<footer class="sc-footer">
		<div class="sc-footer-inner">
			<div class="sc-footer-links">
				<a href="<?php echo esc_url( get_privacy_policy_url() ); ?>"><?php esc_html_e( 'Política de Privacidade', 'smartcenter' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/termos-de-uso/' ) ); ?>"><?php esc_html_e( 'Termos de Uso', 'smartcenter' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/politica-de-devolucao/' ) ); ?>"><?php esc_html_e( 'Política de Devolução', 'smartcenter' ); ?></a>
				<?php if ( $cnpj ) : ?>
					<span>CNPJ: <?php echo esc_html( $cnpj ); ?></span>
				<?php endif; ?>
				<span><?php esc_html_e( 'Certificado SSL - Conexão segura', 'smartcenter' ); ?></span>
			</div>
			<div class="sc-footer-legal">
				<p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'Todos os direitos reservados.', 'smartcenter' ); ?></p>
			</div>
		</div>
	</footer>

	<!-- Drawer do carrinho -->
	<div id="sc-cart-overlay" class="sc-cart-drawer-overlay" aria-hidden="true"></div>
	<div id="sc-cart-drawer" class="sc-cart-drawer" aria-hidden="true">
		<div class="sc-drawer-header">
			<h2><?php esc_html_e( 'Sacola', 'smartcenter' ); ?></h2>
			<button type="button" class="sc-drawer-close" aria-label="<?php esc_attr_e( 'Fechar', 'smartcenter' ); ?>">
				<svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
			</button>
		</div>
		<div class="sc-drawer-body">
			<?php if ( function_exists( 'woocommerce_mini_cart' ) ) : ?>
				<?php woocommerce_mini_cart(); ?>
			<?php endif; ?>
		</div>
		<div class="sc-drawer-footer">
			<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="sc-btn-checkout"><?php esc_html_e( 'Finalizar compra', 'smartcenter' ); ?></a>
		</div>
	</div>

</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>
