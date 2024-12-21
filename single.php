<?php
get_header();
?>
<div class="container_single_content">
	<div class="container_single_info">
		<?php
		if (have_posts()) {
			while (have_posts()) {
				the_post();
				$post_id = get_the_ID();
				$field_reference = get_field_object('reference', $post_id);
				$field_type = get_field_object('type', $post_id);
				$field_photo = get_field('photo');
		?>
				<script type="text/javascript">
					let photoRef = <?php echo json_encode($field_reference); ?>;
				</script>
				<h2><?php the_title(); ?></h2>
				<span><?php echo $field_reference['label'], " : ", the_field('reference'); ?></span>
			<?php
				$term_format = get_the_terms($post_id, 'format');
				$term_categorie = get_the_terms($post_id, 'categorie');
				//var_dump($term_categorie);
				if ($term_categorie && !is_wp_error($term_categorie)) {
					foreach ($term_categorie as $term) {
						echo '<span id="filter_categorie" data-value="' . $term->taxonomy . '">' . esc_html($term->taxonomy) . " : " . esc_html($term->slug) . '</span>';
					}
				} else {
					echo '<p>Aucun terme trouvé pour cette taxonomie.</p>';
				}
				if ($term_format && !is_wp_error($term_format)) {
					foreach ($term_format as $term) {
						echo '<span id="filter_format" data-value="' . $term->taxonomy . '">' . esc_html($term->taxonomy) . " : " . esc_html($term->slug) . '</span>';
					}
				} else {
					echo '<span>Aucun terme trouvé pour cette taxonomie.</span>';
				}
			}

			?>
			<span><?php echo $field_type['label'], " : ", the_field('type'); ?></span>
		<?php
			$year = get_the_date('Y');
			echo '<span id="filter_date" data-value="rand">ANNÉE : ' . $year . '</span>';
		}
		?>
	</div>
	<div class="container_single_photo">
		<img src="<?php echo $field_photo['url'] ?>" alt="<?php the_title_attribute(); ?>" />
	</div>
</div>
<div class="container_single_contact">
	<p>Cette photo vous intéresse ?</p>
	<button id="modalBtn" class="contact-modal">Contact</button>
	<?php
	/* Code fonctionnel pour navigation photo */
	$args = array(
		'post_type' => 'photo',
		'posts_per_page' => -1,
		'orderby' => 'date',
		'order'   => 'ASC'
	);
	$query = new WP_Query($args);
	$photos = $query->posts;
	if (!empty($photos)) :
		$photo_id = get_the_ID();
		$total_photos = count($photos);
		$current_index = array_search($photo_id, wp_list_pluck($photos, 'ID'));

		// Photo suivante
		$next_index = ($current_index + 1) % $total_photos;
		$next_photo = $photos[$next_index];
		$next_thumbnail = get_field('photo', $next_photo->ID)['url'];

		// Photo précédente
		$prev_index = ($current_index - 1 + $total_photos) % $total_photos;
		$prev_photo = $photos[$prev_index];
		$prev_thumbnail = get_field('photo', $prev_photo->ID)['url'];
	?>
		<div class="navigation-buttons">
			<a href="<?php echo get_permalink($prev_photo->ID); ?>" class="nav-button arrow prev-photo">
				<svg xmlns="http://www.w3.org/2000/svg" width="50" height="30" viewBox="0 0 30 24" fill="none" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
					<path d="M28 12H8"></path> <!-- Ligne horizontale plus longue -->
					<path d="M12 6L6 12l6 6"></path> <!-- Pointe de la flèche avec lignes moins épaisses -->
				</svg>
				<span class="thumbnail" style="background-image: url('<?php echo esc_url($prev_thumbnail); ?>');"></span>
			</a>
			<a href="<?php echo get_permalink($next_photo->ID); ?>" class="nav-button arrow next-photo">
				<svg xmlns="http://www.w3.org/2000/svg" width="50" height="30" viewBox="0 0 30 24" fill="none" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
					<path d="M2 12h20"></path> <!-- Ligne horizontale plus longue -->
					<path d="M18 6l6 6-6 6"></path> <!-- Pointe de la flèche avec lignes moins épaisses -->
				</svg>
				<span class="thumbnail" style="background-image: url('<?php echo esc_url($next_thumbnail); ?>');"></span>
			</a>
		</div>
	<?php
	endif;
	?>
</div>
<p class="text_like">VOUS AIMEREZ AUSSI</p>
<section class="photo_container gallery">
	<?php
	$post_id = get_the_ID();
	$term_categorie = get_the_terms($post_id, 'categorie');
	if ($term_categorie && !is_wp_error($term_categorie)) {
		$term_slugs = wp_list_pluck($term_categorie, 'slug');

		// Arguments pour WP_Query
		$args = array(
			'post_type' => 'photo',
			'posts_per_page' => 2,
			'orderby' => 'rand',
			'tax_query' => array(
				array(
					'taxonomy' => 'categorie',
					'field'    => 'slug',
					'terms'    => $term_slugs,
					'operator' => 'IN',
				),
			),
		);
		$query = new WP_Query($args);
		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				$thumbnail_photo = get_field('photo');
				$permalink = get_permalink();
				if ($thumbnail_photo) {
					/*
					echo "<div class='div_container_photo gallery'>";
					echo '<img class="gallery-image" src="' . esc_url($thumbnail_photo['url']) . '" alt="' . esc_attr($thumbnail_photo['alt']) . '">';
					echo '<span class="span_link icon_fullscreen">⛶</span>';
					echo '<span class="photo_category">' . $term_categorie . '</span>';
					//echo '<span class="photo_title">' . $photo_title . '</span>';
					echo '<span class="icon_eye" data-url="' . $permalink . '">👁️</span>';
					echo "</div>";
					*/
					get_template_part('template-parts/content', get_post_format());
				}
			}
			wp_reset_postdata();
		} else {
			echo '<p>Aucune photo trouvée pour cette catégorie.</p>';
		}
	} else {
		echo '<p>Aucun terme trouvé pour cette taxonomie.</p>';
	}
	?>
</section>
<?php
get_footer();
?>