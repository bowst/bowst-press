<?php
/**
 * Logo Grid Block Template.
 *
 * @param array $block The block settings and attributes.
 */

$block_id = 'logo-grid-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

$class_name = 'block-logo-grid';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}

$columns = get_field( 'columns' ) ?: 4;
$col_class = 'col-6 col-md-' . intval( 12 / $columns );
?>

<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<?php if ( have_rows( 'logos' ) ) : ?>
		<div class="row g-4 align-items-center justify-content-center">
			<?php
			while ( have_rows( 'logos' ) ) :
				the_row();
				$image = get_sub_field( 'image' );
				$link  = get_sub_field( 'link' );
				?>
				<div class="<?php echo esc_attr( $col_class ); ?>">
					<div class="block-logo-grid__item">
						<?php if ( $link ) : ?>
							<a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener noreferrer">
						<?php endif; ?>

						<?php if ( $image ) : ?>
							<img
								src="<?php echo esc_url( $image['sizes']['medium'] ); ?>"
								alt="<?php echo esc_attr( $image['alt'] ); ?>"
								loading="lazy"
							/>
						<?php endif; ?>

						<?php if ( $link ) : ?>
							</a>
						<?php endif; ?>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
</div>
