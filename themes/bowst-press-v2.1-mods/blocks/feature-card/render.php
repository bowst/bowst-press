<?php
/**
 * Feature Card Block Template.
 *
 * @param array $block The block settings and attributes.
 */

$block_id = 'feature-card-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

$class_name = 'block-feature-card';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}

$icon    = get_field( 'icon' );
$heading = get_field( 'heading' );
$content = get_field( 'content' );
$link    = get_field( 'link' );
?>

<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<?php if ( $icon ) : ?>
		<div class="block-feature-card__icon">
			<?php if ( is_array( $icon ) && ! empty( $icon['url'] ) ) : ?>
				<img src="<?php echo esc_url( $icon['url'] ); ?>" alt="<?php echo esc_attr( $icon['alt'] ?? '' ); ?>" width="48" height="48" loading="lazy" />
			<?php else : ?>
				<i class="<?php echo esc_attr( $icon ); ?>"></i>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php if ( $heading ) : ?>
		<h3 class="block-feature-card__heading"><?php echo esc_html( $heading ); ?></h3>
	<?php endif; ?>

	<?php if ( $content ) : ?>
		<div class="block-feature-card__content">
			<p><?php echo esc_html( $content ); ?></p>
		</div>
	<?php endif; ?>

	<?php if ( $link ) : ?>
		<a href="<?php echo esc_url( $link['url'] ); ?>" class="block-feature-card__link" <?php echo ! empty( $link['target'] ) ? 'target="' . esc_attr( $link['target'] ) . '"' : ''; ?>>
			<?php echo esc_html( $link['title'] ?: __( 'Learn more', 'bowst-press' ) ); ?>
		</a>
	<?php endif; ?>
</div>
