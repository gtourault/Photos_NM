<?php get_header();
?>
<?php
$args = array(
	'post_type'      => 'attachment',
	'post_mime_type' => 'image',
	'post_status'    => 'inherit',
	'posts_per_page' => 1,
	'orderby'        => 'rand',
);

$random_image_query = new WP_Query($args);
if ($random_image_query->have_posts()) :
	while ($random_image_query->have_posts()) : $random_image_query->the_post();
		$image_url = wp_get_attachment_url(get_the_ID());
?>
		<div class="hero" style="background-image: url('<?php echo esc_url($image_url); ?>');">
			<h1 class="hero-title">PHOTOGRAPHE EVENT</h1>
		</div>

<?php
	endwhile;
endif;
wp_reset_postdata();
?>
<div class="container_select">
	<?php
	$excluded_taxonomies = array('category', 'post_tag', 'post_format');
	$taxonomies = get_taxonomies(array('public' => true), 'objects');
	$args = array(
		'post_type' => 'photo',
		'posts_per_page' => 8,
	);
	foreach ($taxonomies as $taxonomy) {
		if (in_array($taxonomy->name, $excluded_taxonomies)) {
			continue;
		}
		echo '<div id="filter_' . esc_attr($taxonomy->name) . '" class="custom_select" data-value="">';
		echo '<div class="custom_default" data-value="' . esc_attr($taxonomy->name) . '">';
		echo esc_attr($taxonomy->label);
		echo '<span class="icon_select fas fa-chevron-down"></span>';
		echo '</div>';
		echo '<ul class="custom_options hidden">';
		echo '<li data-value="' . esc_html($taxonomy->name) . '">' . esc_html($taxonomy->label) . '</li>';

		$terms = get_terms(array('taxonomy' => $taxonomy->name, 'hide_empty' => false));

		if (!empty($terms) && !is_wp_error($terms)) {
			foreach ($terms as $term) {
				echo '<li data-value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</li>';
			}
		}
		echo '</ul>';
		echo '</div>';
	}
	$args = array(
		'post_type' => 'photo',
		'posts_per_page' => 8,
	);
	?>

	<div id="filter_date" class="custom_select" data-value="">
		<div class="custom_default" data-value="rand">Trier par
			<span class="icon_select fas fa-chevron-down"></span>
		</div>
		<ul class="custom_options hidden">
			<li data-value="rand">Trier par </li>
			<li data-value="desc">À partir des plus récentes</li>
			<li data-value="asc">À partir des plus anciennes</li>
		</ul>
	</div>
</div>
<div id="photo-container" class='photo_container gallery'>

</div>
<div id="loadMoreContainer">
	<button id="loadMore" class="pagination-button">Charger plus</button>
</div>
<div id="custom-content-container"></div>


<?php get_footer();
?>