

<?php get_header(); ?>

<!-- Contenu principal -->
<main id="primary" class="site-main">
    <section class="banner">
        <img 
            class="floating-title" 
            src="<?php echo esc_url(get_template_directory_uri() . '/wp-content/uploads/2024/12/nathalie-0-scaled.jpeg'); ?>" 
            alt="<?php esc_attr_e('Photographe Event', 'your-theme-textdomain'); ?>" 
        />
        <?php echo $src; ?>
    </section>   

    <!-- Bouton pour ouvrir la modale -->
    <button class="open-contact-modal">Contactez-nous</button>

    <!-- Contenu de la modale -->
    <div id="contact-modal" class="contact-modal hidden">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Formulaire de Contact</h2>
            <?php echo do_shortcode('[contact-form-7 id="1234" title="Formulaire de contact"]'); ?>
        </div>
    </div>

    <?php
        // Vérifiez si le fichier existe avant de l'inclure
if (file_exists(get_stylesheet_directory() . '/custom-template.php')) {
    include(get_stylesheet_directory() . '/custom-template.php');
} else {
    // Fallback au contenu par défaut
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            get_template_part('template-parts/content', get_post_type());
        endwhile;
    else :
        get_template_part('template-parts/content', 'none');
    endif;
}

    ?>





</main>
<!-- FIN #primary -->

<?php get_footer(); ?>

