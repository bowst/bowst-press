<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bowst-press
 */

?>

	</main>

	<footer id="footer" role="contentinfo">
		<div class="container">
			<?php wp_nav_menu( array( 'theme_location' => 'footer' ) ); ?>
			&copy; <?php bloginfo( 'name' ); ?> <?php echo date("Y"); ?>.
		</div>
	</footer>


<?php wp_footer(); ?>

</body>
</html>
