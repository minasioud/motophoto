<?php get_header(); ?>

<!-- Contenu principal -->
<main id="primary" class="main_container">
    <section class="banner-images">
        <img class="banner" src="<?php echo get_stylesheet_directory_uri() . '/assets/img/nathalie-11.jpeg'; ?>" alt="Photographe Event">
        <p class="banner-text">PHOTOGRAPHE EVENT</p>
    </section> 

    <section class="gallerie-container">
        <p class="galerie-titre">GALERIE PHOTOS</p>
        <?php
            // Vérifiez si le fichier existe avant de l'inclure
            if (file_exists(get_stylesheet_directory() . '/templates_part/galerie.php')) {
                include(get_stylesheet_directory() . '/templates_part/galerie.php');
            }

        ?>




</main>
<!-- FIN #primary -->

<?php get_footer(); ?>