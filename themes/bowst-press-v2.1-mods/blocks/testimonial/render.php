<?php
/**
 * Testimonial Block Template.
 *
 * @param array $block The block settings and attributes.
 */

$block_id = 'testimonial-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

$class_name = 'block-testimonial';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}

$quote  = get_field( 'quote' );
$author = get_field( 'author' );
$role   = get_field( 'role' );
$image  = get_field( 'image' );
$rating = get_field( 'rating' );
?>

<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<?php if ( $rating ) : ?>
		<div class="block-testimonial__rating" aria-label="<?php echo esc_attr( sprintf( '%d out of 5 stars', $rating ) ); ?>">
			<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
				<span class="block-testimonial__star <?php echo $i <= $rating ? 'is-filled' : ''; ?>">&#9733;</span>
			<?php endfor; ?>
		</div>
	<?php endif; ?>

	<?php if ( $quote ) : ?>
		<blockquote class="block-testimonial__quote">
			<p><?php echo esc_html( $quote ); ?></p>
		</blockquote>
	<?php endif; ?>

	<div class="block-testimonial__attribution">
		<?php if ( $image ) : ?>
			<img
				class="block-testimonial__image"
				src="<?php echo esc_url( $image['sizes']['thumbnail'] ); ?>"
				alt="<?php echo esc_attr( $image['alt'] ?: $author ); ?>"
				width="60"
				height="60"
				loading="lazy"
			/>
		<?php endif; ?>

		<div class="block-testimonial__meta">
			<?php if ( $author ) : ?>
				<cite class="block-testimonial__author"><?php echo esc_html( $author ); ?></cite>
			<?php endif; ?>
			<?php if ( $role ) : ?>
				<span class="block-testimonial__role"><?php echo esc_html( $role ); ?></span>
			<?php endif; ?>
		</div>
	</div>
</div>
