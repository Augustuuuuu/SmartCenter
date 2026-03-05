<?php
/**
 * Template para páginas
 *
 * @package SmartCenter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
?>

<div class="sc-container" style="padding-top: 40px; padding-bottom: 60px;">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</article>
		<?php
	endwhile;
	?>
</div>

<?php get_footer(); ?>
