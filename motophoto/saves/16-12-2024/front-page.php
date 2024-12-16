<?php get_header(); ?>

<!-- Contenu principal -->
<main id="primary" class="main_container">
    <section class="banner-images">
        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/nathalie-11.jpeg'; ?>" alt="Photographe Event">
        <p>PHOTOGRAPHE EVENT</p>
    </section> 

    <section class="galerie-container">
        <?php /*   
            <?php
                // Vérifiez si le fichier existe avant de l'inclure
                if (file_exists(get_stylesheet_directory() . '/templates_part/galerie.php')) {
                    include(get_stylesheet_directory() . '/templates_part/galerie.php');
                } else {
                    echo '<p>Le contenue est introuvable !</p>';
                }
            ?>
        */ ?>
<!----------------------------------------------------------- galerie.php -->
        <section class="galerie-filters">
            <form id="galerie-filters-form"  method="GET" action="" class="galerie-filters-form">
                
                <div class="galerie-filters-form-item gauche">
                    <!-- Champ Catégories -->
                    <select id="filter_category" name="filter_category" onchange="this.form.submit()">
                        <option value="">Sélectionnez une catégorie</option>
                        <?php
                        // Récupérer toutes les catégories de photos disponibles
                        $categories = get_terms(array(
                            'taxonomy' => 'categorie',
                            'hide_empty' => false
                        ));
                        foreach ($categories as $category) {
                            //echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
                            echo '<option value="' . esc_attr($category->term_id) . '" ' . selected($_GET['categorie'], $category->term_id, false) . '>' . esc_html($category->name) . '</option>';
                        }
                        ?>
                    </select>

                    <!-- Champ Formats -->
                    <select id="filter_format" name="filter_format" onchange="this.form.submit()">
                        <option value="">Sélectionnez une FORMATS</option>
                        <?php
                        $formats = get_terms(array(
                            'taxonomy' => 'format',
                            'hide_empty' => false
                        ));
                        foreach ($formats as $format) {
                            echo '<option value="' . esc_attr($format->term_id) . '" ' . selected($_GET['format'], $format->term_id, false) . '>' . esc_html($format->name) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="galerie-filters-form-item droite">
                    <!-- Champ Tri -->
                    <select id="sort-date" name="sort" onchange="this.form.submit()">
                        <option value="">TRIER PAR</option>
                        <option value="DESC">Plus récentes</option>
                        <option value="ASC">Plus anciennes</option>
                    </select>
                </div>

            </form>
        </section>
        
        
        
        
        <article class="galerie-photos">
            <?php
                // Crée une requête pour récupérer les posts du type "galerie_photo"
                $args = array(
                    'post_type' => 'galerie_photo',   // Filtrer uniquement le type "galerie_photo"
                    'posts_per_page' => -1,   // Récupérer toutes les photos
                    'orderby' => 'meta_value_num',
                    'meta_key' => 'annee',      // Trier par date de publication
                    'order' => 'DESC',        // Du plus récent au plus ancien
                );
                
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
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php the_title(); ?>">
                                    </a>
                                    <h3 class="photo-title"><?php the_title(); ?></h3>
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

<!----------------------------------------------------------- galerie.php -->
    </section>
</main>
<!-- FIN #primary -->

<?php get_footer(); ?>