<?php
get_header();

if (have_posts()) :
    while (have_posts()) : the_post();
        echo '<h3>' . get_the_title() . '</h3>';
        echo '<div>' . get_the_content() . '</div>';
    endwhile;
else :
    echo '<p>Aucun contenu trouvé.</p>';
endif;
get_footer();
