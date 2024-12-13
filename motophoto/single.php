<?php get_header(); ?>
<div class="photo-archive">
    <header class="archive-header">
        <h1 class="archive-title">Single Photos</h1>
        <p>Explorez notre collection de photos classées par catégories et formats.</p>
    </header>

    <div class="photo-grid">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('photo-item'); ?>>
                    <a href="<?php the_permalink(); ?>" class="photo-link">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="photo-thumbnail">
                                <?php the_post_thumbnail('medium'); // Afficher l'image à la une ?>
                            </div>
                        <?php endif; ?>
                        <div class="photo-content">
                            <h2 class="photo-title"><?php the_title(); ?></h2>
                            <p class="photo-date">Date de prise de vue : <?php echo get_the_date(); ?></p>
                            
                            <?php
                            // Afficher les champs personnalisés
                            $type = get_field('Type');
                            $reference = get_field('Reference');
                          
                            if ($type) {
                                echo '<p class="photo-type">Type : ' . esc_html($type) . '</p>';
                            }
                            if ($reference) {
                                echo '<p class="photo-reference">Référence : ' . esc_html($reference) . '</p>';
                            }
                            
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
                    </a>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p>Aucune photo trouvée.</p>
        <?php endif; ?>
    </div>

    <div class="pagination">
        <?php
        // Afficher la pagination
        the_posts_pagination(array(
            'mid_size'  => 2,
            'prev_text' => __('&laquo; Précédent', 'textdomain'),
            'next_text' => __('Suivant &raquo;', 'textdomain'),
        ));
        ?>
    </div>
</div>
<?php get_footer(); ?>