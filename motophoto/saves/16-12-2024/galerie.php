    <div class="photo-galerie">
        <?php
        // Crée une requête pour récupérer les posts du type "galerie_photo"
        $args = array(
            'post_type' => 'galerie_photo',   // Filtrer uniquement le type "galerie_photo"
            'posts_per_page' => -1,   // Récupérer toutes les photos
            'orderby' => 'date',      // Trier par date de publication
            'order' => 'DESC',        // Du plus récent au plus ancien
        );

        // La requête WP
        $photo_query = new WP_Query( $args );

        // Vérifie s'il y a des posts
        if ( $photo_query->have_posts() ) :
            while ( $photo_query->have_posts() ) : $photo_query->the_post();
                // Récupère l'ID de l'image à la Une
                if ( has_post_thumbnail() ) :
                    $image_url = get_the_post_thumbnail_url( get_the_ID(), 'medium' );  // Utilise la taille 'large' pour la galerie
                    ?>
                    <div class="photo-item">
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php the_title(); ?>">
                        </a>
                        <h3 class="photo-title"><?php the_title(); ?></h3>

                        

                        <?php
                            // Afficher les champs personnalisés
                            $type = get_field('type');
                            $reference = get_field('reference');
                            if ($type) {
                                echo '<p class="photo-type">Type : ' . esc_html($type) . '</p>';
                            }
                            if ($reference) {
                                echo '<p class="photo-reference">Référence : ' . esc_html($reference) . '</p>';
                            }
                            
                            // Afficher les taxonomies
                            $reference = get_field('reference');
                            $reference = get_field('reference');

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
                    <?php
                endif;
            endwhile;
            wp_reset_postdata();  // Réinitialiser la requête globale après la boucle
        else :
            // Si aucune photo n'est trouvée
            echo '<p>Aucune photo disponible.</p>';
        endif;
        ?>
    </div>