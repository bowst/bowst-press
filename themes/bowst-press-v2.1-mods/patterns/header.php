<?php
/**
 * Title: Header
 * Slug: bowst-press/header
 * Categories: header
 * Block Types: core/template-part/header
 * Description: Site header with dark navy background, logo, and navigation.
 *
 * @package bowst-press
 */

?>
<!-- wp:group {"align":"full","style":{"color":{"background":"var:preset|color|black"}},"textColor":"white","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull has-white-color has-text-color" style="background-color:var(--wp--preset--color--black)">
	<!-- wp:group {"layout":{"type":"constrained"}} -->
	<div class="wp-block-group">
		<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|x-small","bottom":"var:preset|spacing|x-small"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
		<div class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--x-small);padding-bottom:var(--wp--preset--spacing--x-small)">
			<!-- wp:site-title {"level":0,"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"textColor":"white"} /-->
			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
			<div class="wp-block-group">
				<!-- wp:navigation {"textColor":"white","overlayBackgroundColor":"black","overlayTextColor":"white","layout":{"type":"flex","justifyContent":"right","flexWrap":"wrap"},"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"},":hover":{"color":{"text":"var:preset|color|white"}}}}}} /-->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
