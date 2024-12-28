<?php
/*
function add_fancybox_assets()
{
    wp_enqueue_style('fancybox-css', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4/dist/fancybox.css');
    wp_enqueue_script('fancybox-js', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4/dist/fancybox.umd.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'add_fancybox_assets');
*/
///////


function theme_enqueue_scripts()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    //wp_enqueue_script('jquery');
    //wp_enqueue_style('fancybox-css', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4/dist/fancybox.css');
    //wp_enqueue_script('fancybox-js', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4/dist/fancybox.umd.js', array('jquery'), null, true);
    // Enfile ton script personnalisé
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery'), null, true);

    // Localise le script pour l'usage de l'URL AJAX
    wp_localize_script('custom-script', 'myAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');
function theme_enqueue_google_fonts()
{
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap', false);
}

add_action('wp_enqueue_scripts', 'theme_enqueue_google_fonts');

function theme_customize_register($wp_customize)
{
    // Section pour les polices
    $wp_customize->add_section('theme_fonts_section', array(
        'title' => __('Polices', 'mon-theme'),
        'priority' => 30,
    ));

    // Setting pour la police des titres
    $wp_customize->add_setting('theme_title_font', array(
        'default' => 'Roboto',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // Control pour la police des titres
    $wp_customize->add_control('theme_title_font_control', array(
        'label' => __('Police des titres', 'mon-theme'),
        'section' => 'theme_fonts_section',
        'settings' => 'theme_title_font',
        'type' => 'select',
        'choices' => array(
            'Poppins' => 'Poppins',
            'Space Mono' => 'Space Mono',
        ),
    ));

    // Setting pour la police du corps de texte
    $wp_customize->add_setting('theme_body_font', array(
        'default' => 'Open Sans',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // Control pour la police du corps de texte
    $wp_customize->add_control('theme_body_font_control', array(
        'label' => __('Police du corps de texte', 'mon-theme'),
        'section' => 'theme_fonts_section',
        'settings' => 'theme_body_font',
        'type' => 'select',
        'choices' => array(
            'Poppins' => 'Poppins',
            'Space Mono' => 'Space Mono',
        ),
        // Setting pour la police des balises select
        $wp_customize->add_setting('theme_select_font', array(
            'default' => 'Poppins',
            'sanitize_callback' => 'sanitize_text_field',
        )),

        // Control pour la police des balises select
        $wp_customize->add_control('theme_select_font_control', array(
            'label' => __('Police des balises de selection', 'mon-theme'),
            'section' => 'theme_fonts_section',
            'settings' => 'theme_select_font',
            'type' => 'select',
            'choices' => array(
                'Poppins' => 'Poppins',
                'Space Mono' => 'Space Mono',
            ),
        )),
        $wp_customize->add_setting('theme_paragraph_font', array(
            'default' => 'Poppins',
            'sanitize_callback' => 'sanitize_text_field',
        )),
        $wp_customize->add_control('theme_paragraph_font_control', array(
            'label' => __('Police des paragraphes', 'mon-theme'),
            'section' => 'theme_fonts_section',
            'settings' => 'theme_paragraph_font',
            'type' => 'select',
            'choices' => array(
                'Poppins' => 'Poppins',
                'Space Mono' => 'Space Mono',
            ),
        )),

        $wp_customize->add_setting('theme_header_menu_font', array(
            'default' => 'Poppins',
            'sanitize_callback' => 'sanitize_text_field',
        )),

        $wp_customize->add_control('theme_header_menu_font_control', array(
            'label' => __('Police du menu principal (Header)', 'mon-theme'),
            'section' => 'theme_fonts_section',
            'settings' => 'theme_header_menu_font',
            'type' => 'select',
            'choices' => array(
                'Poppins' => 'Poppins',
                'Space Mono' => 'Space Mono',
            ),
        )),

        $wp_customize->add_setting('theme_footer_menu_font', array(
            'default' => 'Space Mono',
            'sanitize_callback' => 'sanitize_text_field',
        )),

        $wp_customize->add_control('theme_footer_menu_font_control', array(
            'label' => __('Police du menu du footer', 'mon-theme'),
            'section' => 'theme_fonts_section',
            'settings' => 'theme_footer_menu_font',
            'type' => 'select',
            'choices' => array(
                'Poppins' => 'Poppins',
                'Space Mono' => 'Space Mono',
            ),
        )),

    ));
}
add_action('customize_register', 'theme_customize_register');
function theme_apply_custom_fonts()
{
?>
    <style type="text/css">
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: <?php echo get_theme_mod('theme_title_font', 'Poppins'); ?>, sans-serif;
        }

        body,
        button {
            font-family: <?php echo get_theme_mod('theme_body_font', 'Space Mono'); ?>, sans-serif;
        }


        .custom_select,
        .custom_default li {
            font-family: <?php echo get_theme_mod('theme_select_font', 'Poppins'); ?>, sans-serif;
        }

        p,
        .modal-form input {
            font-family: <?php echo get_theme_mod('theme_paragraph_font', 'Poppins'); ?>, sans-serif;
        }

        #nav-header li a,
        .modal-form .btn_submit {
            font-family: <?php echo get_theme_mod('theme_header_menu_font', 'Space Mono'); ?>, sans-serif;

        }

        #nav-footer li a {
            font-family: <?php echo get_theme_mod('theme_footer_menu_font', 'Space Mono'); ?>, sans-serif;

        }
    </style>
<?php
}
add_action('wp_head', 'theme_apply_custom_fonts');

function custom_menu_header_class($classes, $item, $args)
{
    if ($args->theme_location == 'primary' && $item->title == 'CONTACT') {
        $classes[] = 'contact-modal';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'custom_menu_header_class', 10, 3);

function mon_theme_register_menus()
{
    register_nav_menus(array(
        'primary' => __('Menu Principal'),
        'footer'  => __('Menu Footer'),
    ));
}
add_action('init', 'mon_theme_register_menus');


function creer_type_contenu_personnalise()
{
    $labels = array(
        'name'                  => _x('Photos', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Photo', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Photos', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Photo', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Ajouter', 'textdomain'),
        'add_new_item'          => __('Ajouter une nouvelle photo', 'textdomain'),
        'new_item'              => __('Nouvelle photo', 'textdomain'),
        'edit_item'             => __('Modifier la photo', 'textdomain'),
        'view_item'             => __('Voir la photo', 'textdomain'),
        'all_items'             => __('Toutes les photos', 'textdomain'),
        'search_items'          => __('Rechercher des photos', 'textdomain'),
        'parent_item_colon'     => __('Photo parente :', 'textdomain'),
        'not_found'             => __('Aucune photo trouvée.', 'textdomain'),
        'not_found_in_trash'    => __('Aucune photo trouvée dans la corbeille.', 'textdomain'),
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'photo'),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 5,
        'supports'              => array('title', 'thumbnail', 'custom-fields'),
    );

    register_post_type('photo', $args);
}

add_action('init', 'creer_type_contenu_personnalise');

function remove_unwanted_supports()
{
    remove_post_type_support('photo', 'editor');
}
add_action('init', 'remove_unwanted_supports', 11);




function filter_photos_ajax()
{
    // Récupération des paramètres
    $categorie = isset($_POST['categorie']) ? sanitize_text_field($_POST['categorie']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : '';
    $paged = isset($_POST['page']) ? (int) $_POST['page'] : 1;
    $items_per_page = isset($_POST['items_per_page']) ? (int) $_POST['items_per_page'] : 8;

    // Logique de la requête
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => $items_per_page,
        'paged' => $paged,
        'tax_query' => array_filter(array(
            $categorie ? array(
                'taxonomy' => 'categorie',
                'field'    => 'slug',
                'terms'    => $categorie,
                'operator' => 'IN',
            ) : null,
            $format ? array(
                'taxonomy' => 'format',
                'field'    => 'slug',
                'terms'    => $format,
                'operator' => 'IN',
            ) : null,
        )),
        'orderby' => ($paged > 1 && $date === 'rand') ? 'date' : ($date === 'rand' ? 'rand' : 'date'),

        'order' => $date === 'rand' ? 'ASC' : ($date === 'desc' ? 'DESC' : 'ASC'),
    );

    // Exécution de la requête
    $query = new WP_Query($args);
    //$response = '';
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            get_template_part('template-parts/content', get_post_format());
        endwhile;


        wp_reset_postdata();
    else :
        $response .= 'Aucune photo trouvée.';
    endif;

    wp_die();
}
add_action('wp_ajax_filter_photos', 'filter_photos_ajax');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos_ajax');
