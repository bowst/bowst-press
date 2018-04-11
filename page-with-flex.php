<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * Reference code for using ACF flexible content field.
 * Rename this file to page.php if you intend on using it.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bowst-press
 */

get_header(); ?>

	<div class="container padding-vert">

		<?php
		while ( have_posts() ) : the_post();

			if ( have_rows( 'global_layouts' ) ) :

				while ( have_rows( 'global_layouts' ) ) : the_row();

					$layout = get_row_layout();
					$layout = substr( $layout, 6 );

					get_template_part( 'blocks/block', $layout );

				endwhile;

			else :

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endif;

		endwhile; // End of the loop.
		?>

	</div>

<?php
get_footer();
