<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */
?>
</main>
</div>
</div>
<footer id="colophon" class="site-footer">
	<!-- Inclure le template de la modale -->
	<?php get_template_part('template-parts/modale-template');
	?>
	<nav id="nav-footer" class="site-navigation">
		<?php
		wp_nav_menu(array(
			'theme_location' => 'footer',
			'container' => false,
			'menu_class' => 'nav-menu',
			'fallback_cb' => false,
		));
		?>
	</nav>
</footer>
</div>

<?php wp_footer(); ?>
</body>

</html>