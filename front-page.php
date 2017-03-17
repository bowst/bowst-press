<?php get_header();
/* Template Name: Homepage */
 ?>
<?php while ( have_posts() ) : the_post(); // begin the page loop ?>

	<div class="container padding-vert">
		<h1><?php the_title(); ?></h1>
		<?php the_content(); ?>
	</div>

<?php endwhile; ?>

<?php
get_footer();
