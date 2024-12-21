<div class="content_area_photo">
    <?php
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 10,
    );
    $photo_query = new WP_Query($args);

    if ($photo_query->have_posts()) :
        while ($photo_query->have_posts()) : $photo_query->the_post();
    ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                <?php endif;
                echo the_permalink(); ?>
            </article>
    <?php
        endwhile;

        the_posts_navigation();
    else :
        get_template_part('template-parts/content', 'none');
    endif;

    wp_reset_postdata();
    ?>
</div>