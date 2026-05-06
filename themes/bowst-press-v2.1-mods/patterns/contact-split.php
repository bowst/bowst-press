<?php
/**
 * Title: Contact Split
 * Slug: bowst-press/contact-split
 * Categories: bowst
 * Description: A two-column contact section with info on one side and form placeholder on the other.
 *
 * @package bowst-press
 * @since bowst-press 5.0
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|large","bottom":"var:preset|spacing|large"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--large);padding-bottom:var(--wp--preset--spacing--large)">
	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|regular","left":"var:preset|spacing|large"}}}} -->
	<div class="wp-block-columns alignwide">
		<!-- wp:column {"verticalAlignment":"top"} -->
		<div class="wp-block-column is-vertically-aligned-top">
			<!-- wp:heading -->
			<h2 class="wp-block-heading"><?php echo esc_html_x( 'Get in touch', 'Pattern heading', 'bowst-press' ); ?></h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p><?php echo esc_html_x( 'We would love to hear from you. Reach out to us and we will get back to you as soon as possible.', 'Pattern paragraph', 'bowst-press' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|x-small"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group">
				<!-- wp:paragraph {"fontSize":"medium"} -->
				<p class="has-medium-font-size"><strong><?php esc_html_e( 'Email', 'bowst-press' ); ?></strong><br><?php esc_html_e( 'hello@example.com', 'bowst-press' ); ?></p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"fontSize":"medium"} -->
				<p class="has-medium-font-size"><strong><?php esc_html_e( 'Phone', 'bowst-press' ); ?></strong><br><?php esc_html_e( '(555) 123-4567', 'bowst-press' ); ?></p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"fontSize":"medium"} -->
				<p class="has-medium-font-size"><strong><?php esc_html_e( 'Address', 'bowst-press' ); ?></strong><br><?php esc_html_e( '123 Main Street', 'bowst-press' ); ?><br><?php esc_html_e( 'Portland, ME 04101', 'bowst-press' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"top"} -->
		<div class="wp-block-column is-vertically-aligned-top">
			<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|regular","right":"var:preset|spacing|regular","bottom":"var:preset|spacing|regular","left":"var:preset|spacing|regular"}},"border":{"radius":"8px"}},"backgroundColor":"white","layout":{"type":"constrained"}} -->
			<div class="wp-block-group has-white-background-color has-background" style="border-radius:8px;padding-top:var(--wp--preset--spacing--regular);padding-right:var(--wp--preset--spacing--regular);padding-bottom:var(--wp--preset--spacing--regular);padding-left:var(--wp--preset--spacing--regular)">
				<!-- wp:heading {"level":3} -->
				<h3 class="wp-block-heading"><?php echo esc_html_x( 'Send us a message', 'Form heading', 'bowst-press' ); ?></h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"fontSize":"small"} -->
				<p class="has-small-font-size"><?php echo esc_html_x( 'Place your contact form shortcode or block here.', 'Form placeholder', 'bowst-press' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
