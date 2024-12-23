<?php
/**
 * Functions and definitions for the Motophoto theme.
 */

function motophoto_enqueue_styles() {
    $theme = wp_get_theme();

    // Charger le style principal du thème
    wp_enqueue_style(
        'motophoto-style',
        get_stylesheet_uri(),
        [],
        $theme->get('Version')
    );

    // Charger le CSS mobile
    wp_enqueue_style(
        'mobile-css',
        get_stylesheet_directory_uri() . '/assets/css/mobile.css',
        [],
        filemtime(get_stylesheet_directory() . '/assets/css/mobile.css')
    );

    // Charger le CSS tablette
    wp_enqueue_style(
        'tab-css',
        get_stylesheet_directory_uri() . '/assets/css/tab.css',
        [],
        filemtime(get_stylesheet_directory() . '/assets/css/tab.css')
    );

    // Charger les polices Google Fonts
    wp_enqueue_style(
        'motophoto-google-fonts',
        'https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'poppins-google-fonts',
        'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap',
        [],
        null
    );

    // Charger les polices Font Awesome
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css',
        false
    );

// Charger le CSS mobile
wp_enqueue_style(
    'basic-css',
    get_stylesheet_directory_uri() . '/assets/css/basic.css',
    [],
    filemtime(get_stylesheet_directory() . '/assets/css/basic.css')
);

}
add_action('wp_enqueue_scripts', 'motophoto_enqueue_styles');

// Charger les scripts personnalisés
function motophoto_enqueue_scripts() {
    // Charger le script pour la modale de contact
    wp_enqueue_script(
        'contact-modal',
        get_stylesheet_directory_uri() . '/assets/js/contact-modal.js',
        ['jquery'],
        '1.0',
        true
    );

    // Charger le script pour la lightbox
    wp_enqueue_script(
        'lightbox',
        get_stylesheet_directory_uri() . '/assets/js/lightbox.js',
        ['jquery'], // Dépend de jQuery si nécessaire
        '1.0',      // Version du fichier
        true        // Charger dans le footer
    );

    // Charger le script pour les filtres
    wp_enqueue_script(
        'filter-script',
        get_stylesheet_directory_uri() . '/assets/js/filter.js',
        ['jquery'],
        '1.0',
        true
    );

    // Charger le fichier scripts 
     wp_enqueue_script(
        'motophoto-scripts',
        get_stylesheet_directory_uri() . '/assets/js/scripts.js',
        ['jquery'],
        '1.0',
        true
    );

    // Ajouter des données dynamiques pour les scripts
    wp_localize_script('filter-script', 'ajax_object', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('motophoto_nonce'),
    ]);

}
add_action('wp_enqueue_scripts', 'motophoto_enqueue_scripts');

// Configurer le thème Motophoto
function motophoto_setup() {
    // Support des menus
    add_theme_support('menus');

    // Déclarer les menus
    register_nav_menus([
        'main-menu'   => __('Menu Principal', 'motophoto'),
        'footer-menu' => __('Menu Pied de page', 'motophoto'),
    ]);

    // Support des images mises en avant
    add_theme_support('post-thumbnails');

    // Support des balises HTML5
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);

    // Support des titres dynamiques
    add_theme_support('title-tag');

}
add_action('after_setup_theme', 'motophoto_setup');

// Personnalisation de la longueur des extraits d'articles
function motophoto_custom_excerpt_length($length) {
    return 20; // Limiter les extraits à 20 mots
}
add_filter('excerpt_length', 'motophoto_custom_excerpt_length');

// Utiliser un modèle personnalisé pour le post type "photo"
function photo_custom_post_type_template($template) {
    if (is_post_type_archive('photo')) {
        $custom_template = locate_template(['galerie.php']);
        if ($custom_template) {
            return $custom_template;
        }
    }
    return $template;
}
add_filter('archive_template', 'photo_custom_post_type_template');


// Inclure tous les fichiers PHP dans le dossier /assets/inc/
$inc_dir = get_stylesheet_directory() . '/assets/inc/';

// Vérifier si le dossier existe et inclure les fichiers PHP
if (is_dir($inc_dir)) {
    foreach (glob($inc_dir . '*.php') as $file) {
        if (file_exists($file)) {
            require_once $file;
        }
    }
}