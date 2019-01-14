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
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="shortcut icon" href="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/favicon.ico" />
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<header id="header" role="banner">

		<!-- BOOTSTRAP NAVBAR -->
		<nav class="navbar navbar-expand-md navbar-light bg-light justify-content-between">

			<?php if ( is_front_page() && is_home() ) : // Default homepage. ?>
				<h1 class="navbar-brand"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/public/img/logo.svg" alt="<?php bloginfo( 'name' ); ?>"></a></h1>
			<?php elseif ( is_front_page() ) : // Static homepage. ?>
				<h1 class="navbar-brand"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/public/img/logo.svg" alt="<?php bloginfo( 'name' ); ?>"></a></h1>
			<?php else : // Everything else. ?>
				<div class="navbar-brand"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/public/img/logo.svg" alt="<?php bloginfo( 'name' ); ?>"></a></div>
			<?php endif; ?>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="main-nav">
				<!-- Main Nav -->
				<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'depth'          => 2, // 1 = no dropdowns, 2 = with dropdowns.
						'menu_class'     => 'navbar-nav mr-auto',
						'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
						'walker'         => new WP_Bootstrap_Navwalker(),
					) );
				?>

				<!-- Search -->
				<form class="navbar-form form-inline my-2 my-lg-0">
					<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
				</form>
			</div>

		</nav>

	</header>

	<main id="main" role="main">
