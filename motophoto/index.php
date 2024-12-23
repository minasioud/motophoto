<?php
// Protéger le fichier contre un accès direct
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Quitter si l'accès est direct
}

// Inclure l'en-tête du site
get_header(); 
?>

<main id="site-content">

    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();

            // Afficher le contenu des articles
            get_template_part( 'templates-part', get_post_type() );

        endwhile;

        // Pagination
        the_posts_pagination( array(
            'mid_size'  => 2,
            'prev_text' => __( 'Previous', 'motophoto' ),
            'next_text' => __( 'Next', 'motophoto' ),
        ) );

    else :
        // Message si aucun contenu
        get_template_part( 'template-parts', 'none' );
    endif;
    ?>

</main><!-- #site-content -->

<?php
// Inclure le pied de page du site
get_footer();