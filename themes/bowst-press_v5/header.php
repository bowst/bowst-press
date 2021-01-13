<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bowst-press
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<link rel="shortcut icon" href="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/favicon.ico" />
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	}
	?>

	<header id="header" role="banner">

		<!-- BOOTSTRAP NAVBAR -->
		<nav class="navbar navbar-expand-md navbar-dark bg-dark">
			<div class="container-fluid">

				<?php if ( is_front_page() && is_home() ) : // Default homepage. ?>
					<h1 class="navbar-brand"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/public/img/logo.svg" alt="<?php bloginfo( 'name' ); ?>"></a></h1>
				<?php elseif ( is_front_page() ) : // Static homepage. ?>
					<h1 class="navbar-brand"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/public/img/logo.svg" alt="<?php bloginfo( 'name' ); ?>"></a></h1>
				<?php else : // Everything else. ?>
					<div class="navbar-brand"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/public/img/logo.svg" alt="<?php bloginfo( 'name' ); ?>"></a></div>
				<?php endif; ?>

				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="main-nav">
					<!-- Main Nav -->
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'depth'          => 2, // 1 = no dropdowns, 2 = with dropdowns.
							'menu_class'     => 'navbar-nav me-auto',
							'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
							'walker'         => new WP_Bootstrap_Navwalker(),
						)
					);
					?>

					<!-- Search -->
					<form class="search-form navbar-form d-flex my-2 my-md-0" role="search" method="get" action="<?php echo esc_url( home_url() ); ?>">
						<div class="input-group">
							<input class="form-control" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="Search" aria-label="Search">
							<button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
						</div>
					</form>
				</div>

			</div>
		</nav>

	</header>

	<main id="main" role="main">
