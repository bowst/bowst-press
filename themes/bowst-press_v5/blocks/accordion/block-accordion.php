<?php
/**
 * Accordion Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'accordion-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block-accordion mb-3';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}
?>

<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<?php if ( have_rows( 'accordion_items' ) ) : ?>
		<div class="accordion-items accordion">
			<?php
			while ( have_rows( 'accordion_items' ) ) :
				the_row();
				?>
				<div class="accordion-item">
					<h3 class="accordion-header">
						<button id="heading-<?php echo esc_attr( get_row_index() ); ?>" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-collapse-<?php echo esc_attr( get_row_index() ); ?>" aria-expanded="false" aria-controls="accordion-collapse-<?php echo esc_attr( get_row_index() ); ?>">
							<?php the_sub_field( 'heading' ); ?>
						</button>
					</h3>
					<div id="accordion-collapse-<?php echo esc_attr( get_row_index() ); ?>" class="accordion-content accordion-collapse collapse" aria-labelledby="heading-<?php echo esc_attr( get_row_index() ); ?>" data-bs-parent=".accordion">
						<div class="accordion-body">
							<?php the_sub_field( 'content' ); ?>
						</div>
					</div>
				</div>
				<?php
			endwhile;
			?>
		</div>
	<?php endif; ?>
</div>
