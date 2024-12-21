<?php

/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title(); ?></title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<header class="site-header">
		<a href="<?php echo esc_url(home_url('/')); ?>">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Nathalie_Mota.png" alt="<?php bloginfo('name'); ?>">
		</a>

		<nav class="navbar">
			<div class="nav-links">
				<?php
				wp_nav_menu(array(
					'theme_location' => 'primary',
					'container' => false,
					'menu_class' => 'nav-menu',
					'fallback_cb' => false,
				));
				?>

			</div>
			<div class="burger-menu" id="burgerMenu">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</nav>

		<div class="lightbox hidden">
			<div class="lightbox-overlay"></div>
			<div class="lightbox-content">
				<button class="lightbox-close">
					<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
						<line x1="18" y1="6" x2="6" y2="18"></line>
						<line x1="6" y1="6" x2="18" y2="18"></line>
					</svg>
				</button>
				<button class="lightbox-prev .prev-photo">
					<svg xmlns="http://www.w3.org/2000/svg" width="50" height="60" viewBox="0 0 30 24" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
						<path d="M28 12H8"></path> <!-- Ligne horizontale plus longue -->
						<path d="M12 6L6 12l6 6"></path> <!-- Pointe de la flèche avec lignes moins épaisses -->
					</svg>
					Précédente
				</button>
				<div>
					<img class="lightbox-image" src="" alt="">
					<div class="span_containeur_info">
						<span class="lightbox-reference"></span>
						<span class="lightbox-categorie"></span>
					</div>
				</div class=".lightbox-image-container">
				<button class="lightbox-next .next-photo">Suivante
					<svg xmlns="http://www.w3.org/2000/svg" width="50" height="60" viewBox="0 0 30 24" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
						<path d="M2 12h20"></path> <!-- Ligne horizontale plus longue -->
						<path d="M18 6l6 6-6 6"></path> <!-- Pointe de la flèche avec lignes moins épaisses -->
					</svg>
				</button>
			</div>
		</div>
	</header>
	<script type="text/javascript">
		var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	</script>
	<main>