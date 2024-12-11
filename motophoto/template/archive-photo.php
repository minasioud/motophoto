<div class="photo-archive">
    <h1>Galerie de Photos</h1>
    <div class="photos-grid">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <div class="photo-item">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="photo-thumbnail">
                                <?php the_post_thumbnail('medium'); ?>
                            </div>
                        <?php endif; ?>
                        <h2><?php the_title(); ?></h2>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p>Aucune photo trouvée.</p>
        <?php endif; ?>
    </div>
</div>


