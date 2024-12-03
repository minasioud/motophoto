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

// Exemple d'ajout d'un widget personnalisé
function motophoto_register_sidebars() {
    register_sidebar(array(
        'name'          => __('Sidebar Principale', 'twentytwentyonechild'),
        'id'            => 'main-sidebar',
        'description'   => __('Ajouter des widgets ici pour apparaître dans la sidebar principale.', 'twentytwentyonechild'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'motophoto_register_sidebars');

// Charger un script JS personnalisé
function motophoto_enqueue_scripts() {
    wp_enqueue_script('motophoto-scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'motophoto_enqueue_scripts');

register_sidebar(array(
    'name'          => __('Footer Widget Area', 'twentytwentyonechild'),
    'id'            => 'footer-widgets',
    'description'   => __('Widgets apparaissant dans le pied de page.', 'twentytwentyonechild'),
    'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="footer-widget-title">',
    'after_title'   => '</h3>',
));
