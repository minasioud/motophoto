<?php get_header(); ?>

<!-- Contenu principal -->
<main id="primary" class="main_container">
    <section class="banner-images">
        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/nathalie-11.jpeg'; ?>" alt="Photographe Event">
        <p>PHOTOGRAPHE EVENT</p>
    </section> 

    <section class="galerie-container">
        <?php
            // Vérifiez si le fichier existe avant de l'inclure
            if (file_exists(get_stylesheet_directory() . '/templates_part/galerie.php')) {
                include(get_stylesheet_directory() . '/templates_part/galerie.php');
            } else {
                echo '<p>Le contenue est introuvable !</p>';
            }
        ?>
    </section>
</main>
<!-- FIN #primary -->

<?php get_footer(); ?>