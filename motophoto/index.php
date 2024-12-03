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
</main>
<!-- FIN #primary -->

<?php get_footer(); ?>

