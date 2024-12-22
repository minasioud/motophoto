<?php
//********************************************* Enqueue le script JavaScript ****************************************************** */

// Enqueue le script JavaScript pour le bouton "Afficher plus"
function enqueue_load_more_script() {
    wp_enqueue_script('load-more', get_stylesheet_directory_uri() . '/assets/js/afficher_plus.js', ['jquery'], null, true);

    wp_localize_script('load-more', 'loadMore', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('load_more_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_script');


//********************************************* DEBUT afficher plus ************************************************************** */

// Gérer la requête AJAX pour charger plus de photos
function load_more_photos() {
    // Vérifier le nonce pour la sécurité
    if (!isset($_GET['security']) || !wp_verify_nonce($_GET['security'], 'load_more_nonce')) {
        wp_send_json_error(array('message' => 'Nonce invalide.'));
    }

    // Récupérer la page demandée
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    // Arguments pour la requête
    $args = array(
        'post_type' => 'galerie_photo',
        'posts_per_page' => 8, // Nombre de photos par page
        'paged' => $page, // Page actuelle
    );

    // Si un filtre est appliqué, ajouter la taxonomie à la requête
    if (isset($_GET['categorie']) && !empty($_GET['categorie'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'categorie', // Taxonomie associée aux categories
                'field' => 'term_id',
                'terms' => $_GET['categorie'],
                'operator' => 'IN'
            ),
        );
    }

    // Ajouter le filtre pour les formats si spécifié
    if (isset($_GET['format']) && !empty($_GET['format'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format', // Taxonomie associée aux formats
            'field' => 'term_id',
            'terms' => $_GET['format'],
            'operator' => 'IN'
        );
    }


    // La requête WP
    $photo_query = new WP_Query($args);

    // Vérifie s'il y a des posts
    if ($photo_query->have_posts()) :
        ob_start(); // Capture le HTML

        while ($photo_query->have_posts()) : $photo_query->the_post();
            // Récupère l'ID de l'image à la Une
            if (has_post_thumbnail()) :
                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large'); // Utilise la taille 'large' pour la galerie
                ?>
                <div class="photo-item">
                    <div class="photo-img">
                            <a href="<?php the_permalink(); ?>" class="lightbox-trigger">
                                <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php the_title(); ?>">
                            </a>
                            <h3 class="photo-title"><?php the_title(); ?></h3>

                            <!-- Icônes au survol -->
                            <div class="info-photo-icons">
                                <!-- Icône œil pour afficher les informations -->
                                <a href="<?php the_permalink(); ?>" class="info-icon" title="Voir les informations">
                                    <i class="far fa-eye"></i>
                                </a>
                            </div>
                            <div class="full-photo-icons">
                                <!-- Icône plein écran pour ouvrir la lightbox -->
                                <a href="<?php echo esc_url( $image_url ); ?>" class="fullscreen-icon" title="Voir en plein écran">
                                    <i class="fas fa-expand"></i>
                                </a>
                            </div>
                        </div>
                    
                    
                        <!-- A supprimer !!!!!!!!!!! -->
                        <div class="photo-info">
                            <?php
                            // Fonction SCF pour récupérer le champ
                            $reference = get_field('Reference');
                            $type = get_field('Type');
                            $annee = get_field('Annee');

                            echo '<p class="photo-reference">Référence : ' . esc_html($reference) . '</p>';
                            echo '<p class="photo-type">Type : ' . esc_html($type) . '</p>';
                            echo '<p class="photo-type">Année : ' . esc_html($annee) . '</p>';

                            /* Date de prise de vue */
                            echo '<p class="photo-date">Date de prise : ' . get_the_date() . '</p>';

                            // Afficher les taxonomies
                            $categories = get_the_terms(get_the_ID(), 'categorie');
                            $formats = get_the_terms(get_the_ID(), 'format');
                            if ($categories) {
                                echo '<p class="photo-categories">Catégories : ';
                                foreach ($categories as $category) {
                                    echo esc_html($category->name) . ' ';
                                }
                                echo '</p>';
                            }
                            if ($formats) {
                                echo '<p class="photo-formats">Formats : ';
                                foreach ($formats as $format) {
                                    echo esc_html($format->name) . ' ';
                                }
                                echo '</p>';
                            }
                            ?>
                        </div>
                        <!-- A supprimer !!!!!!!!!!! -->
                </div>
                <?php
            endif;
        endwhile;

        wp_reset_postdata(); // Réinitialiser la requête globale après la boucle

        // Retourner la réponse avec les photos et l'indicateur de pagination
        wp_send_json_success(array(
            'html' => ob_get_clean(),
            'has_more' => $photo_query->max_num_pages > $page, // Vérifier s'il y a plus de pages
        ));
    else :
        wp_send_json_error(array('message' => 'Aucune photo trouvée.'));
    endif;

    wp_die(); // Terminer l'exécution
}
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');






//********************************************* FIN afficher plus ************************************************************** */
?>