<?php
/**
 * Title: Footer
 * Slug: bowst-press/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 * Description: Footer with dark background, navigation columns, and bottom bar.
 *
 * @package bowst-press
 */

?>
<!-- wp:group {"align":"full","style":{"color":{"background":"var:preset|color|black"}},"textColor":"white","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull has-white-color has-text-color" style="background-color:var(--wp--preset--color--black)">
	<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|x-large","bottom":"var:preset|spacing|large"}}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--x-large);padding-bottom:var(--wp--preset--spacing--large)">
		<!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
		<div class="wp-block-group alignwide">
			<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|large"}}}} -->
			<div class="wp-block-columns">
				<!-- wp:column {"width":"40%"} -->
				<div class="wp-block-column" style="flex-basis:40%">
					<!-- wp:site-title {"level":3,"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white","fontSize":"x-large"} /-->
					<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white","fontSize":"small"} -->
					<p class="has-white-color has-text-color has-small-font-size"><?php esc_html_e( 'A digital agency focused on strategy, design, and technology.', 'bowst-press' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:column -->

				<!-- wp:column -->
				<div class="wp-block-column">
					<!-- wp:heading {"level":4,"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white","fontSize":"small"} -->
					<h4 class="wp-block-heading has-white-color has-text-color has-small-font-size"><?php esc_html_e( 'Services', 'bowst-press' ); ?></h4>
					<!-- /wp:heading -->
					<!-- wp:navigation {"textColor":"white","overlayMenu":"never","layout":{"type":"flex","orientation":"vertical"},"style":{"typography":{"fontSize":"0.875rem"},"elements":{"link":{"color":{"text":"var:preset|color|white"},":hover":{"color":{"text":"var:preset|color|white"}}}}}} -->
						<!-- wp:navigation-link {"label":"<?php esc_html_e( 'Web Design', 'bowst-press' ); ?>","url":"#"} /-->
						<!-- wp:navigation-link {"label":"<?php esc_html_e( 'Development', 'bowst-press' ); ?>","url":"#"} /-->
						<!-- wp:navigation-link {"label":"<?php esc_html_e( 'Strategy', 'bowst-press' ); ?>","url":"#"} /-->
						<!-- wp:navigation-link {"label":"<?php esc_html_e( 'Branding', 'bowst-press' ); ?>","url":"#"} /-->
					<!-- /wp:navigation -->
				</div>
				<!-- /wp:column -->

				<!-- wp:column -->
				<div class="wp-block-column">
					<!-- wp:heading {"level":4,"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white","fontSize":"small"} -->
					<h4 class="wp-block-heading has-white-color has-text-color has-small-font-size"><?php esc_html_e( 'Company', 'bowst-press' ); ?></h4>
					<!-- /wp:heading -->
					<!-- wp:navigation {"textColor":"white","overlayMenu":"never","layout":{"type":"flex","orientation":"vertical"},"style":{"typography":{"fontSize":"0.875rem"},"elements":{"link":{"color":{"text":"var:preset|color|white"},":hover":{"color":{"text":"var:preset|color|white"}}}}}} -->
						<!-- wp:navigation-link {"label":"<?php esc_html_e( 'About', 'bowst-press' ); ?>","url":"#"} /-->
						<!-- wp:navigation-link {"label":"<?php esc_html_e( 'Case Studies', 'bowst-press' ); ?>","url":"#"} /-->
						<!-- wp:navigation-link {"label":"<?php esc_html_e( 'Blog', 'bowst-press' ); ?>","url":"#"} /-->
						<!-- wp:navigation-link {"label":"<?php esc_html_e( 'Contact', 'bowst-press' ); ?>","url":"#"} /-->
					<!-- /wp:navigation -->
				</div>
				<!-- /wp:column -->
			</div>
			<!-- /wp:columns -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"align":"full","style":{"color":{"background":"var:preset|color|black"},"spacing":{"padding":{"top":"var:preset|spacing|x-small","bottom":"var:preset|spacing|x-small"}}},"textColor":"white","layout":{"type":"constrained"}} -->
	<div class="wp-block-group alignfull has-white-color has-text-color" style="background-color:var(--wp--preset--color--black);padding-top:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--x-small)">
		<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|tiny"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
		<div class="wp-block-group alignwide">
			<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white","fontSize":"small"} -->
			<p class="has-white-color has-text-color has-small-font-size">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php esc_html_e( 'Bowst. All rights reserved.', 'bowst-press' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white","fontSize":"small"} -->
			<p class="has-white-color has-text-color has-small-font-size">
				<a href="#"><?php esc_html_e( 'Privacy Policy', 'bowst-press' ); ?></a> &middot; <a href="#"><?php esc_html_e( 'Terms', 'bowst-press' ); ?></a>
			</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
