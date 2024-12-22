
<section class="galerie-filters">
    <form id="galerie-filters-form" class="galerie-filters-form">
        <div class="galerie-filters-form-item gauche">
            <!-- Champ Catégories -->
            <select id="filter_category" name="filter_category">
                <option value="">Sélectionnez une catégorie</option>
                <?php
                $categories = get_terms(['taxonomy' => 'categorie', 'hide_empty' => false]);
                foreach ($categories as $category) {
                    echo '<option value="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</option>';
                }
                ?>
            </select>

            <!-- Champ Formats -->
            <select id="filter_format" name="filter_format">
                <option value="">Sélectionnez un format</option>
                <?php
                $formats = get_terms(['taxonomy' => 'format', 'hide_empty' => false]);
                foreach ($formats as $format) {
                    echo '<option value="' . esc_attr($format->term_id) . '">' . esc_html($format->name) . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="galerie-filters-form-item droite">
            <!-- Champ de tri -->
            <select id="sort_date" name="sort">
                <option value="">Trier par</option>
                <option value="DESC">Plus récentes</option>
                <option value="ASC">Plus anciennes</option>
            </select>
        </div>
    </form>
</section>

        
        
<article class="galerie-photos" id="g-photo-container">
    <?php
        // Crée une requête pour récupérer les posts du type "galerie_photo"
        $args = array(
            'post_type' => 'galerie_photo',   // Filtrer uniquement le type "galerie_photo"
            'posts_per_page' => 8,   // Récupérer toutes les photos
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
        $photo_query = new WP_Query( $args );

        // Vérifie s'il y a des posts
        if ( $photo_query->have_posts() ) :
            while ( $photo_query->have_posts() ) : $photo_query->the_post();
                
                // Récupère l'ID de l'image à la Une
                if ( has_post_thumbnail() ) :
                    $image_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );  // Utilise la taille 'large' pour la galerie
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
                    </div>
                    <?php
                endif;
            endwhile;
            wp_reset_postdata();  // Réinitialiser la requête globale après la boucle
        else :
            // Si aucune photo n'est trouvée
            echo '<p>Aucune photo disponible.</p>';
        endif;               
    ?>
</article>

<article class="galerie-photos-plus">
    <!-- Bouton pour charger plus d'images -->
    <button id="loadMore" class="contact_button" data-page="1" aria-live="polite" aria-label="Charger plus d'images">Afficher plus</button>
</article>