<?php
/**
 * CTA Banner Block Template.
 *
 * @param array $block The block settings and attributes.
 */

$block_id = 'cta-banner-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

$class_name = 'block-cta-banner';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}

$heading          = get_field( 'heading' );
$content          = get_field( 'content' );
$background_color = get_field( 'background_color' );

$style = '';
if ( $background_color ) {
	$style = 'background-color: ' . esc_attr( $background_color ) . ';';
}
?>

<div
	id="<?php echo esc_attr( $block_id ); ?>"
	class="<?php echo esc_attr( $class_name ); ?>"
	<?php echo $style ? 'style="' . esc_attr( $style ) . '"' : ''; ?>
>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8 text-center">
				<?php if ( $heading ) : ?>
					<h2 class="block-cta-banner__heading"><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>

				<?php if ( $content ) : ?>
					<div class="block-cta-banner__content">
						<p><?php echo esc_html( $content ); ?></p>
					</div>
				<?php endif; ?>

				<?php if ( have_rows( 'buttons' ) ) : ?>
					<div class="block-cta-banner__buttons">
						<?php
						while ( have_rows( 'buttons' ) ) :
							the_row();
							$label = get_sub_field( 'label' );
							$url   = get_sub_field( 'url' );
							$style = get_sub_field( 'style' );

							$btn_class = 'btn';
							if ( 'outline' === $style ) {
								$btn_class .= ' btn-outline-primary';
							} else {
								$btn_class .= ' btn-primary';
							}
							?>
							<?php if ( $label && $url ) : ?>
								<a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( $btn_class ); ?>">
									<?php echo esc_html( $label ); ?>
								</a>
							<?php endif; ?>
						<?php endwhile; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
