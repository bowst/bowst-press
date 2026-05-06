<?php
/**
 * Title: Two-Column Text + Image
 * Slug: bowst-press/two-column-text-image
 * Categories: bowst
 * Description: A two-column layout with text on one side and an image on the other.
 *
 * @package bowst-press
 * @since bowst-press 5.0
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|large","bottom":"var:preset|spacing|large"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--large);padding-bottom:var(--wp--preset--spacing--large)">
	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|regular","left":"var:preset|spacing|large"}}}} -->
	<div class="wp-block-columns alignwide">
		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center">
			<!-- wp:heading -->
			<h2 class="wp-block-heading"><?php echo esc_html_x( 'About our company', 'Pattern heading', 'bowst-press' ); ?></h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p><?php echo esc_html_x( 'We are a team of passionate individuals dedicated to delivering exceptional results. Our approach combines creativity with technical expertise to build solutions that matter.', 'Pattern paragraph', 'bowst-press' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph -->
			<p><?php echo esc_html_x( 'With years of experience across industries, we understand what it takes to make your project succeed from concept to launch.', 'Pattern paragraph', 'bowst-press' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button -->
				<div class="wp-block-button">
					<a class="wp-block-button__link wp-element-button"><?php esc_html_e( 'Learn more', 'bowst-press' ); ?></a>
				</div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"large"} -->
			<figure class="wp-block-image size-large">
				<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/botany-flowers.webp" alt="<?php echo esc_attr_x( 'Placeholder image', 'Alt text', 'bowst-press' ); ?>" style="aspect-ratio:4/3;object-fit:cover"/>
			</figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
