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

        wp_enqueue_style(
            'Poppins-google-fonts',
            'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap',
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


//********************************************* DEBUT sous le menu "Photos" ******************************************************* */

    // Ajouter un sous-menu sous le menu "Photos" pour afficher toutes les occurrences des champs "Type", "Référence" et "Année"
    function ajouter_sous_menu_type_reference() {
        add_submenu_page(
            'edit.php?post_type=galerie_photo', // Parent slug : menu "Photos"
            'Liste des Types et Références', // Titre de la page
            'Champs personnalisés', // Titre du menu
            'manage_options', // Capacité requise pour voir ce menu
            'types-references', // Slug de la page
            'afficher_types_references' // Fonction callback pour afficher le contenu
        );
    }
    add_action('admin_menu', 'ajouter_sous_menu_type_reference');



    // Fonction pour afficher la page avec toutes les occurrences des champs "Type", "Référence" et "Année"
    function afficher_types_references() {
        // Récupérer tous les posts de type "photo"
        $args = array(
            'post_type' => 'galerie_photo',
            'posts_per_page' => -1 // Récupérer tous les posts
        );
        $query = new WP_Query($args);
        
        // Afficher les résultats
        ?>
        <div class="wrap">
            <h1>Liste des Types, Références et Années</h1></br>
            <table class="widefat fixed">
                <thead>
                    <tr>
                        <th scope="col" class="manage-column">Titre de la Photo</th>
                        <th scope="col" class="manage-column">Type</th>
                        <th scope="col" class="manage-column">Référence</th>
                        <th scope="col" class="manage-column">Année</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($query->have_posts()) {
                            while ($query->have_posts()) {
                                $query->the_post();
                                // Récupérer les valeurs des champs personnalisés
                                $type = get_field('Type'); 
                                $reference = get_field('Reference');
                                $Annee = get_field('Annee');
                                ?>
                                <tr>
                                    <td><?php the_title(); ?></td>
                                    <td><?php echo esc_html($type); ?></td>
                                    <td><?php echo esc_html($reference); ?></td>
                                    <td><?php echo esc_html($Annee); ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="3">Aucune photo trouvée.</td></tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        // Réinitialiser la requête après l'affichage
        wp_reset_postdata();
    }

    // Ajouter un sous-menu sous le menu "Photos" pour afficher toutes les occurrences des champs "Type", "Référence" et "Année"
    function ajouter_sous_menu_types_references_annee() {
        // Sous-menu pour "Références"
        add_submenu_page(
            'edit.php?post_type=galerie_photo', // Parent slug : menu "Photos"
            'Liste des Références', // Titre de la page
            'Références', // Titre du menu
            'manage_options', // Capacité requise pour voir ce menu
            'liste-references', // Slug de la page
            'afficher_liste_references' // Fonction callback pour afficher le contenu
        );
        // Sous-menu pour "Types"
        add_submenu_page(
            'edit.php?post_type=galerie_photo', // Parent slug : menu "Photos"
            'Liste des Types', // Titre de la page
            'Types', // Titre du menu
            'manage_options', // Capacité requise pour voir ce menu
            'liste-types', // Slug de la page
            'afficher_liste_types' // Fonction callback pour afficher le contenu
        );
         // Sous-menu pour "Année"
         add_submenu_page(
            'edit.php?post_type=galerie_photo', // Parent slug : menu "Photos"
            'Liste Année', // Titre de la page
            'Année', // Titre du menu
            'manage_options', // Capacité requise pour voir ce menu
            'liste-annee', // Slug de la page
            'afficher_liste_annee' // Fonction callback pour afficher le contenu
        );

    }
    add_action('admin_menu', 'ajouter_sous_menu_types_references_annee');

    
    
    // Fonction pour afficher la page avec toutes les occurrences le champs "Référence"
    function afficher_liste_references() {
        $paged = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1; // Page actuelle
        $posts_per_page = 25; // Nombre de résultats par page

        // Récupérer tous les posts de type "photo"
        $args = array(
            'post_type' => 'galerie_photo',
            'posts_per_page' => $posts_per_page, // Récupérer tous les posts
            'paged' => $paged
        );
        // Ajouter un filtre si une recherche par Année est effectuée
        if (isset($_GET['search_references']) && !empty($_GET['search_references'])) {
            $search_references = sanitize_text_field($_GET['search_references']); // Sécuriser la valeur entrée
            $args['meta_query'] = array(
                array(
                    'key' => 'Reference',       // Nom du champ personnalisé (ACF)
                    'value' => $search_references, // Valeur à rechercher
                    'compare' => '='   // Recherche partielle (ou utilisez '=' pour une correspondance exacte)
                )
            );
        }

        // Nombre d'occurrences Référence
        global $wpdb;

        // Récupérer toutes les Référence et leur nombre d'occurrences
        $results = $wpdb->get_results("
            SELECT meta_value AS reference, post_id AS postid, COUNT(*) AS count
            FROM {$wpdb->postmeta}
            WHERE meta_key = 'Reference' AND meta_value != ''
            GROUP BY meta_value
            ORDER BY count DESC
        ");

        // Afficher les résultats
        ?>
        <div class="wrap">
            <h1>Liste des Référence</h1>
            <table class="widefat fixed">
                <thead>
                    <tr>
                        <th scope="col" class="manage-column">Référence</th>
                        <th scope="col" class="manage-column">Nombre d'occurrences</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($results)) {
                        foreach ($results as $row) {
                            ?>
                            <tr>
                                <td>
                                    <a href="<?php echo admin_url('post.php?post=' . urlencode($row->postid) . '&action=edit'); ?>">
                                        <?php echo esc_html($row->reference); ?>
                                    </a>
                                </td>
                                <td><?php echo intval($row->count); ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="2">Aucune Année trouvé.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php

        // Créer la requête WP_Query
        $query = new WP_Query($args);
        
        // Afficher les résultats
        ?>
        <div class="wrap">
            <h1>Liste des Références</h1>
            <!-- Formulaire de la recherche ----------------------------------->
            <form method="get" action="">
                <input type="hidden" name="post_type" value="galerie_photo">
                <input type="hidden" name="page" value="liste-references">
                <label for="search_references">Rechercher une Référence :</label>
                <input type="text" id="search_references" name="search_references" value="<?php echo isset($_GET['search_references']) ? esc_attr($_GET['search_references']) : ''; ?>">
                <button type="submit" class="button">Rechercher</button>
            </form></br>
            <table class="widefat fixed">
                <thead>
                    <tr>
                        <th scope="col" class="manage-column">Titre de la Photo</th>
                        <th scope="col" class="manage-column">Références</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($query->have_posts()) {
                            while ($query->have_posts()) {
                                $query->the_post();
                                // Récupérer les valeurs des champs personnalisés
                                $type = get_field('Type'); 
                                $reference = get_field('Reference');
                                ?>
                                <tr>
                                    <td><?php the_title(); ?></td>
                                    <td><?php echo esc_html($reference); ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="3">Aucune photo trouvée.</td></tr>';
                        }
                    ?>
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="tablenav">
                <div class="tablenav-pages">
                    <?php
                    echo paginate_links(array(
                        'total' => $query->max_num_pages,
                        'current' => $paged,
                        'format' => '?paged=%#%',
                        'prev_text' => __('« Précédent'),
                        'next_text' => __('Suivant »'),
                    ));
                    ?>
                </div>
            </div>
        </div>
        <?php
        // Réinitialiser la requête après l'affichage
        wp_reset_postdata();
    }

    // Fonction pour afficher la page avec toutes les occurrences le champs "Type":
    function afficher_liste_types() {
        $paged = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1; // Page actuelle
        $posts_per_page = 10; // Nombre de résultats par page

        // Récupérer tous les posts de type "photo"
        $args = array(
            'post_type' => 'galerie_photo',
            'posts_per_page' => $posts_per_page, // Récupérer tous les posts
            'paged' => $paged
        );
        // Ajouter un filtre si une recherche par Année est effectuée
        if (isset($_GET['search_type']) && !empty($_GET['search_type'])) {
            $search_type = sanitize_text_field($_GET['search_type']); // Sécuriser la valeur entrée
            $args['meta_query'] = array(
                array(
                    'key' => 'Type',       // Nom du champ personnalisé (ACF)
                    'value' => $search_type, // Valeur à rechercher
                    'compare' => 'LIKE'   // Recherche partielle (ou utilisez '=' pour une correspondance exacte)
                )
            );
        }
        
                
        // Nombre d'occurrences TYPE
        global $wpdb;

        // Récupérer tous les types et leur nombre d'occurrences
        $results = $wpdb->get_results("
            SELECT meta_value AS type, post_id AS postid, COUNT(*) AS count
            FROM {$wpdb->postmeta}
            WHERE meta_key = 'Type' AND meta_value != ''
            GROUP BY meta_value
            ORDER BY count DESC
        ");


        
        // Afficher les résultats
        ?>
        <div class="wrap">
            <h1>Liste des Types</h1>
            <table class="widefat fixed">
                <thead>
                    <tr>
                        <th scope="col" class="manage-column">Type</th>
                        <th scope="col" class="manage-column">Nombre d'occurrences</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($results)) {
                        foreach ($results as $row) {
                            ?>
                            <tr>
                                <td><?php echo esc_html($row->type); ?></td>
                                <td><?php echo intval($row->count); ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="2">Aucun type trouvé.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php


        // Créer la requête WP_Query
        $query = new WP_Query($args);
        // Afficher les résultats
        ?>
        <div class="wrap">
            <h1>Liste des Types</h1>
            <!-- Formulaire de la recherche ----------------------------------->
            <form method="get" action="">
                <input type="hidden" name="post_type" value="galerie_photo">
                <input type="hidden" name="page" value="liste-types">
                <label for="search-type">Rechercher un Type :</label>
                <input type="text" id="search-type" name="search_type" value="<?php echo isset($_GET['search_type']) ? esc_attr($_GET['search_type']) : ''; ?>">
                <button type="submit" class="button">Rechercher</button>
            </form></br>
            <table class="widefat fixed">
                <thead>
                    <tr>
                        <th scope="col" class="manage-column">Titre de la Photo</th>
                        <th scope="col" class="manage-column">Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($query->have_posts()) {
                            while ($query->have_posts()) {
                                $query->the_post();
                                // Récupérer les valeurs des champs personnalisés
                                $type = get_field('Type'); 
                                ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo admin_url('post.php?post=' . urlencode($row->postid) . '&action=edit'); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </td>
                                    <td><?php echo esc_html($type); ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="3">Aucune photo trouvée.</td></tr>';
                        }
                    ?>
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="tablenav">
                <div class="tablenav-pages">
                    <?php
                    echo paginate_links(array(
                        'total' => $query->max_num_pages,
                        'current' => $paged,
                        'format' => '?paged=%#%',
                        'prev_text' => __('« Précédent'),
                        'next_text' => __('Suivant »'),
                    ));
                    ?>
                </div>
            </div>
        </div>
        <?php
        // Réinitialiser la requête après l'affichage
        wp_reset_postdata();
    }

    // Fonction pour afficher la page avec toutes les occurrences le champs "Année"
    function afficher_liste_annee() {
        $paged = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1; // Page actuelle
        $posts_per_page = 25; // Nombre de résultats par page

        // Récupérer tous les posts de type "photo"
        $args = array(
            'post_type' => 'galerie_photo',
            'posts_per_page' => $posts_per_page, // Récupérer tous les posts
            'paged' => $paged
        );
        
        // Ajouter un filtre si une recherche par Année est effectuée
        if (isset($_GET['search_annee']) && !empty($_GET['search_annee'])) {
            $search_annee = sanitize_text_field($_GET['search_annee']); // Sécuriser la valeur entrée
            $args['meta_query'] = array(
                array(
                    'key' => 'Annee',       // Nom du champ personnalisé (ACF)
                    'value' => $search_annee, // Valeur à rechercher
                    'compare' => 'Like'   // Recherche partielle (ou utilisez '=' pour une correspondance exacte)
                )
            );
        }
        // Nombre d'occurrences Annee
        global $wpdb;

        // Récupérer toutes les Années et leur nombre d'occurrences
        $results = $wpdb->get_results("
            SELECT meta_value AS annee, post_id AS postid, COUNT(*) AS count
            FROM {$wpdb->postmeta}
            WHERE meta_key = 'Annee' AND meta_value != ''
            GROUP BY meta_value
            ORDER BY count DESC
        ");

        // Afficher les résultats
        ?>
        <div class="wrap">
            <h1>Liste des Année</h1>
            <table class="widefat fixed">
                <thead>
                    <tr>
                        <th scope="col" class="manage-column">Année</th>
                        <th scope="col" class="manage-column">Nombre d'occurrences</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($results)) {
                        foreach ($results as $row) {
                            ?>
                            <tr>
                                <td><?php echo esc_html($row->annee); ?></td>
                                <td><?php echo intval($row->count); ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="2">Aucune Année trouvé.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php


        // Créer la requête WP_Query
        $query = new WP_Query($args);
        
        // Afficher les résultats
        ?>
        <div class="wrap">
            <h1>Liste des Années</h1>
            <!-- Formulaire de la recherche ----------------------------------->
            <form method="get" action="">
                <input type="hidden" name="post_type" value="galerie_photo"> <!-- Assure que le CPT "photo" reste sélectionné -->
                <input type="hidden" name="page" value="liste-annee"> <!-- Identifie que l'on est sur la page "Types" -->
                <label for="search_annee">Rechercher une Année :</label>
                <input type="text" id="search_annee" name="search_annee" value="<?php echo isset($_GET['search_annee']) ? esc_attr($_GET['search_annee']) : ''; ?>" placeholder="Entrez une année">
                <button type="submit" class="button">Rechercher</button>
            </form></br>
            <table class="widefat fixed">
                <thead>
                    <tr>
                        <th scope="col" class="manage-column">Titre de la Photo</th>
                        <th scope="col" class="manage-column">Année</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($query->have_posts()) {
                            while ($query->have_posts()) {
                                $query->the_post();
                                // Récupérer les valeurs des champs personnalisés
                                $Annee = get_field('Annee');

                                ?>
                                <tr>
                                    <td><?php the_title(); ?></td>
                                    <td><?php echo esc_html($Annee); ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="3">Aucune photo trouvée.</td></tr>';
                        }
                    ?>
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="tablenav">
                <div class="tablenav-pages">
                    <?php
                    echo paginate_links(array(
                        'total' => $query->max_num_pages,
                        'current' => $paged,
                        'format' => '?paged=%#%',
                        'prev_text' => __('« Précédent'),
                        'next_text' => __('Suivant »'),
                    ));
                    ?>
                </div>
            </div>
        </div>
        <?php
        // Réinitialiser la requête après l'affichage
        wp_reset_postdata();
    }
//********************************************* FIN sous le menu "Photos" ******************************************************* */
//********************************************* DEBUT FCT sous le menu "Photos" ************************************************* */
// Fonction de validation JavaScript pour l'entrée (Annee)
function scf_annee_validation_script($hook) {
    // Charger uniquement sur les pages d'édition ou d'ajout
    if ('post.php' === $hook || 'post-new.php' === $hook) {
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const anneeField = document.querySelector('[name="annee"]');
                if (anneeField) {
                    anneeField.addEventListener('input', function () {
                        // Permet uniquement 4 chiffres
                        this.value = this.value.replace(/[^0-9]/g, '').substring(0, 4);
                    });
                }
            });
        </script>
        <?php
    }
}
add_action('admin_enqueue_scripts', 'scf_annee_validation_script');
function valider_champ_annee($value, $field, $args) {
    // Vérifiez si la valeur est un nombre à 4 chiffres
    if (!preg_match('/^\d{4}$/', $value)) {
        return 'Veuillez entrer une année valide (format : YYYY).';
    }
    return $value; // Retournez la valeur si elle est valide
}
add_filter('scf_validate_value_annee', 'valider_champ_annee', 10, 3);

















//********************************************* DEBUT photo_filter ************************************************************** */
/*
function register_photo_filter_api() {
    register_rest_route('photo-gallery/v1', '/filter', array(
        'methods' => 'GET',
        'callback' => 'filter_photos',
        'permission_callback' => '__return_true', // Pas de restriction pour l'instant
    ));
}

add_action('rest_api_init', 'register_photo_filter_api');

function filter_photos($request) {
    $category = $request->get_param('categorie');
    $format = $request->get_param('format');
    $sort = $request->get_param('sort') ?: 'DESC';

    $args = array(
        'post_type' => 'galerie_photo',
        'posts_per_page' => -1,
        'orderby' => 'Annee',
        'order' => $sort,
        'tax_query' => array(
            'relation' => 'AND',
        ),
    );

    if (!empty($category)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $category,
        );
    }

    if (!empty($format)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        );
    }

    $query = new WP_Query($args);
    $photos = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $photos[] = array(
                'title' => get_the_title(),
                'url' => get_permalink(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'large'),
            );
        }
    }
    wp_reset_postdata();

    return $photos;
}

*/
//********************************************* FIN photo_filter ******************************************************* */
//********************************************* DEBUT afficher plus ************************************************************** */

function load_more_photos() {
    // Vérifiez le numéro de page
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    // Arguments de la requête
    $args = array(
        'post_type' => 'galerie_photo',
        'posts_per_page' => 8, // Toujours 8 images par requête
        'paged' => $page,      // Charger la page demandée
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start(); // Capture le HTML généré
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="photo-item">
                <?php the_post_thumbnail('medium'); ?>
                <h2><?php the_title(); ?></h2>
            </div>
            <?php
        }
        wp_reset_postdata();

        // Envoyer la réponse
        wp_send_json_success(array(
            'html' => ob_get_clean(),
            'has_more' => $query->max_num_pages > $page, // Vérifie s'il reste des pages
        ));
    } else {
        wp_send_json_error();
    }

    wp_die(); // Terminer correctement l'exécution
}
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

//********************************************* FIN afficher plus ************************************************************** */




?>