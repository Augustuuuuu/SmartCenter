<?php
/**
 * Index fallback
 *
 * @package SmartCenter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
?>

<div class="sc-container">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
	else :
		echo '<p>' . esc_html__( 'Nenhum conteúdo encontrado.', 'smartcenter' ) . '</p>';
	endif;
	?>
</div>

<?php get_footer(); ?>
