<?php
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

function theme_enqueue_styles()
{

    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

    wp_enqueue_script('scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array(), '1.0', true);
}




function theme_enqueue_google_fonts()
{
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap', false);
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

        body {
            font-family: <?php echo get_theme_mod('theme_body_font', 'Space Mono'); ?>, sans-serif;
        }
    </style>
<?php
}
add_action('wp_head', 'theme_apply_custom_fonts');
