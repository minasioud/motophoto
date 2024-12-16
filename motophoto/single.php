<?php get_header(); ?>
<section class="single-container">
    <section class="photo-container">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>

                <article class="single-photo-info">
                        <h1 class="single-photo-info-title"><?php the_title(); ?></h1>
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
                </article>

                <article class="photo-affiche">
                    <div id="post-<?php the_ID(); ?>" <?php post_class('photo-item'); ?> >
                        <a href="<?php the_permalink(); ?>" class="photo-link">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="photo-thumbnail">
                                    <?php the_post_thumbnail('medium'); // Afficher l'image à la une ?>
                                </div>
                            <?php endif; ?>
                        </a>
                    </div>
                </article>
                    
            <?php endwhile; ?>
        <?php else : ?>
            <p>Aucune photo trouvée.</p>
        <?php endif; ?>
            
    </section>    

    <section class="photo_pagination_container">
        <div class="photo_pagination-items">
            <p>Cette photo vous intéresse ?</p>
            <button class="contact-button contact_button">Contact</button>  
        </div>
        <div class="photo_pagination-nav">
            <?php
            // Afficher la pagination
            the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => __('&laquo; Précédent', 'textdomain'),
                'next_text' => __('Suivant &raquo;', 'textdomain'),
            ));
            ?>
        </div>
    </section> 



    <section class="photo-container2">
        <?php
            // Crée une requête pour récupérer les posts du type "galerie_photo"
            $args = array(
                'post_type' => 'galerie_photo',   // Filtrer uniquement le type "galerie_photo"
                'posts_per_page' => 2,   // Récupérer toutes les photos
                'orderby' => 'rand',             // Trier aléatoirement
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
                            <div class="photo-img">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php the_title(); ?>">
                                </a>
                                <h3 class="photo-title"><?php the_title(); ?></h3>
                            </div>
                        </div>
                    <?php endif; ?>
           
                <?php endwhile; ?>
            <?php else : ?>
                <p>Aucune photo trouvée.</p>
            <?php endif; ?>
        <?php


            wp_reset_postdata();  // Réinitialiser la requête globale après la boucle
    
        ?>
    </section> 
</section>
            

<?php get_footer(); ?>