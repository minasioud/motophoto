<?php
/**
 * Functions and definitions for the Motophoto child theme.
 */

// Charger les styles du thème parent et du thème enfant
function motophoto_enqueue_styles() {
    $parenthandle = 'twenty-twenty-one-style'; // Identifiant du style parent
    $theme = wp_get_theme();

    // Charger le style du thème parent
    wp_enqueue_style($parenthandle, get_template_directory_uri() . '/style.css',
        array(), $theme->parent()->get('Version')
    );

    // Charger le style du thème enfant
    wp_enqueue_style('motophoto-style', get_stylesheet_uri(),
        array($parenthandle), $theme->get('Version')
    );

    // Charger les polices Google Fonts
    wp_enqueue_style(
        'motophoto-google-fonts',
        'https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap',
        false
    );

    // Charger les polices Font Awesome
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css',
        false
    );

    // Charger le script JS personnalisé
    wp_enqueue_script('motophoto-scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'motophoto_enqueue_styles');

// Ajouter des fonctionnalités spécifiques au thème enfant
function motophoto_setup() {
    // Support des menus
    add_theme_support('menus');

    // Déclarer les menus
    register_nav_menus(array(
        'main-menu' => __('Menu Principal', 'twentytwentyonechild'),
        'footer-menu' => __('Menu Pied de page', 'twentytwentyonechild'),
    ));

    // Support des images mises en avant
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'motophoto_setup');

// Personnalisation : Modifier la longueur des extraits d'articles
function motophoto_custom_excerpt_length($length) {
    return 20; // Par défaut, WordPress affiche 55 mots
}
add_filter('excerpt_length', 'motophoto_custom_excerpt_length');




function photo_custom_post_type_template($template) {
    if (is_post_type_archive('photo')) {
        $theme_files = ['galerie.php'];
        $exists_in_theme = locate_template($theme_files, false);
        if ($exists_in_theme != '') {
            return $exists_in_theme;
        }
    }
    return $template;
}
add_filter('archive_template', 'photo_custom_post_type_template');


