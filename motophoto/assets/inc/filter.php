<?php
//********************************************* DEBUT photo_filter ************************************************************** */
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');

function filter_photos() {
    // Préparer les arguments de la requête
    $args = [
        'post_type' => 'galerie_photo',
        'posts_per_page' => 8,
        'orderby' => 'date',
    ];

    // Filtrer par catégorie
    if (!empty($_GET['filter_category'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'categorie',
            'field' => 'term_id',
            'terms' => intval($_GET['filter_category']),
        ];
    }

    // Filtrer par format
    if (!empty($_GET['filter_format'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'format',
            'field' => 'term_id',
            'terms' => intval($_GET['filter_format']),
        ];
    }

    // Trier par date
    if (!empty($_GET['sort'])) {
        $args['order'] = sanitize_text_field($_GET['sort']);
    }

    // Requête WP_Query
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            // Inclure le template d'affichage des photos
            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
            
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



        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;

    wp_die(); // Fin de la requête
}





//********************************************* FIN photo_filter ******************************************************* */
?>