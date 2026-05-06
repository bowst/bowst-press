<?php
/**
 * Hero Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

global $post;

// Create id attribute allowing for custom "anchor" value.
$block_id = 'hero-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block-hero breakout-container mb-5';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

$heading        = get_field( 'heading' );
$content        = get_field( 'content' );
$background_img = get_field( 'background_image' );
$size           = 'hero'; // (thumbnail, medium, large, full or custom size)

if ( $background_img ) :
	$background_img_url = $background_img['sizes'][ $size ];
else :
	$background_img_url = get_the_post_thumbnail_url( $post->ID, $size );
endif;
?>

<div
	id="<?php echo esc_attr( $block_id ); ?>"
	class="<?php echo esc_attr( $class_name ); ?>"
	<?php echo $background_img_url ? 'style="background-image: url(' . esc_url( $background_img_url ) . ');"' : ''; ?>
>
	<div class="container">
		<div class="row">

			<div class="col col-lg-9">
				<h1>
					<?php
					if ( $heading ) :
						echo apply_filters( 'the_title', $heading );
					elseif ( is_home() ) :
						single_post_title();
					elseif ( is_archive() ) :
						the_archive_title();
					else :
						the_title();
					endif;
					?>
				</h1>

				<?php echo apply_filters( 'the_content', $content ); ?>

				<?php if ( have_rows( 'buttons' ) ) : ?>
					<div class="buttons">
						<?php
						while ( have_rows( 'buttons' ) ) :
							the_row();
							$button = get_sub_field( 'button' );
							?>
							<a href="<?php echo esc_url( $button['url'] ); ?>" class="btn btn-primary" target="<?php echo esc_attr( $button['target'] ); ?>">
								<?php echo esc_html( $button['title'] ); ?>
							</a>
							<?php
						endwhile;
						?>
					</div>
				<?php endif; ?>
			</div><!-- .col -->

		</div><!-- .row -->
	</div><!-- .container -->
</div>
