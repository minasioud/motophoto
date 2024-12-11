

<div class="single-photo-content">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>
        <?php if (has_post_thumbnail()) : ?>
            <div class="photo-thumbnail">
                <?php the_post_thumbnail('full'); ?>
            </div>
        <?php endif; ?>
        <div class="photo-meta">
            <!-- Afficher les informations supplémentaires, comme le type, référence, catégorie, format -->
            <p><strong>Type:</strong> <?php echo get_post_meta(get_the_ID(), 'type', true); ?></p>
            <p><strong>Référence:</strong> <?php echo get_post_meta(get_the_ID(), 'reference', true); ?></p>
            <p><strong>Catégorie:</strong> <?php the_terms( get_the_ID(), 'categorie' ); ?></p>
            <p><strong>Format:</strong> <?php the_terms( get_the_ID(), 'format' ); ?></p>
        </div>
        <div class="photo-content">
            <p><?php the_content(); ?></p>
        </div>
    <?php endwhile; endif; ?>
</div>


