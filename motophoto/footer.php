<footer id="site-footer" class="footer-conteneur">

    <!-- Footer Navigation Menu -->
    <div class="nav_fconteneur">
        <?php if ( has_nav_menu( 'footer-menu' ) ) : ?>
            <nav id="id-fnav" class="nav_fmenu" aria-label="<?php esc_attr_e( 'Footer Menu', 'motophoto' ); ?>">
                <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'footer-menu',
                            'menu_class'      => 'menu-wrapper',
                            'container_class' => 'footer-menu-container',
                            'items_wrap'      => '<ul id="footer-menu-list" class="%2$s">%3$s</ul>',
                            'fallback_cb'     => false,
                        )
                    );
                ?>
            </nav>
        <?php else : ?>
            <p><?php esc_html_e( 'No footer menu assigned. Please set up a menu in the WordPress admin.', 'motophoto' ); ?></p>
        <?php endif; ?>
    </div>

    <!-- Lightbox Overlay -->
    <div id="lightbox-overlay" class="lightbox-overlay">
        <div class="lightbox-content">
            <img src="" alt="" class="lightbox-image">
            <p class="lightbox-title"></p>
            <button class="lightbox-prev"><?php esc_html_e( 'Previous', 'motophoto' ); ?></button>
            <button class="lightbox-next"><?php esc_html_e( 'Next', 'motophoto' ); ?></button>
            <button class="lightbox-close"><?php esc_html_e( 'Close', 'motophoto' ); ?></button>
        </div>
    </div>

</footer>

<!-- Inclusion de la modale de contact -->
<?php get_template_part( 'templates_part/contact-modal' ); ?>

<?php wp_footer(); ?>
