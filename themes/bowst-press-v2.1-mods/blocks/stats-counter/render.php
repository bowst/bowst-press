<?php
/**
 * Stats Counter Block Template.
 *
 * @param array $block The block settings and attributes.
 */

$block_id = 'stats-counter-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

$class_name = 'block-stats-counter';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
?>

<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<?php if ( have_rows( 'stats' ) ) : ?>
		<div class="row g-4 text-center">
			<?php
			$count = 0;
			while ( have_rows( 'stats' ) ) :
				the_row();
				$count++;
			endwhile;

			// Reset and re-loop
			$col_class = 'col-6 col-md-' . ( $count > 0 ? intval( 12 / min( $count, 4 ) ) : 3 );

			while ( have_rows( 'stats' ) ) :
				the_row();
				$number = get_sub_field( 'number' );
				$label  = get_sub_field( 'label' );
				$prefix = get_sub_field( 'prefix' );
				$suffix = get_sub_field( 'suffix' );
				?>
				<div class="<?php echo esc_attr( $col_class ); ?>">
					<div class="block-stats-counter__item">
						<div class="block-stats-counter__number">
							<?php if ( $prefix ) : ?>
								<span class="block-stats-counter__prefix"><?php echo esc_html( $prefix ); ?></span>
							<?php endif; ?>
							<span class="block-stats-counter__value"><?php echo esc_html( $number ); ?></span>
							<?php if ( $suffix ) : ?>
								<span class="block-stats-counter__suffix"><?php echo esc_html( $suffix ); ?></span>
							<?php endif; ?>
						</div>
						<?php if ( $label ) : ?>
							<div class="block-stats-counter__label"><?php echo esc_html( $label ); ?></div>
						<?php endif; ?>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
</div>
