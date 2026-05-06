<?php
/**
 * Team Member Block Template.
 *
 * @param array $block The block settings and attributes.
 */

$block_id = 'team-member-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

$class_name = 'block-team-member';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}

$photo = get_field( 'photo' );
$name  = get_field( 'name' );
$role  = get_field( 'role' );
$bio   = get_field( 'bio' );
?>

<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<?php if ( $photo ) : ?>
		<div class="block-team-member__photo">
			<img
				src="<?php echo esc_url( $photo['sizes']['medium'] ); ?>"
				alt="<?php echo esc_attr( $photo['alt'] ?: $name ); ?>"
				loading="lazy"
			/>
		</div>
	<?php endif; ?>

	<div class="block-team-member__info">
		<?php if ( $name ) : ?>
			<h3 class="block-team-member__name"><?php echo esc_html( $name ); ?></h3>
		<?php endif; ?>

		<?php if ( $role ) : ?>
			<p class="block-team-member__role"><?php echo esc_html( $role ); ?></p>
		<?php endif; ?>

		<?php if ( $bio ) : ?>
			<div class="block-team-member__bio">
				<p><?php echo esc_html( $bio ); ?></p>
			</div>
		<?php endif; ?>

		<?php if ( have_rows( 'social' ) ) : ?>
			<div class="block-team-member__social">
				<?php
				while ( have_rows( 'social' ) ) :
					the_row();
					$platform = get_sub_field( 'platform' );
					$url      = get_sub_field( 'url' );
					if ( $platform && $url ) :
						$icon_map = array(
							'facebook'  => 'fa-brands fa-facebook',
							'twitter'   => 'fa-brands fa-x-twitter',
							'linkedin'  => 'fa-brands fa-linkedin',
							'instagram' => 'fa-brands fa-instagram',
							'github'    => 'fa-brands fa-github',
							'website'   => 'fa-solid fa-globe',
						);
						$icon = isset( $icon_map[ $platform ] ) ? $icon_map[ $platform ] : 'fa-solid fa-link';
						?>
						<a href="<?php echo esc_url( $url ); ?>" class="block-team-member__social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( ucfirst( $platform ) ); ?>">
							<i class="<?php echo esc_attr( $icon ); ?>"></i>
						</a>
					<?php endif; ?>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</div>
