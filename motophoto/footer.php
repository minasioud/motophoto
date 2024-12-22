<footer id="site-footer" class="footer-conteneur">
   
    <div class="nav_fconteneur">
        <!-- Navigation Menu -->
        <?php if ( has_nav_menu( 'footer-menu' ) ) : ?>
        <nav id="id-fnav" class="nav_fmenu" aria-label="<?php esc_attr_e( 'footer-menu', 'twentytwentyone' ); ?>">
            <div class="menu-button-container">
                <button id="primary-mobile-menu" class="button" aria-controls="primary-menu-list" aria-expanded="false">
                    <span class="dropdown-icon open"><?php esc_html_e( 'Menu', 'twentytwentyone' ); ?>
                        <?php echo twenty_twenty_one_get_icon_svg( 'ui', 'menu' ); ?>
                    </span>
                    <span class="dropdown-icon close"><?php esc_html_e( 'Close', 'twentytwentyone' ); ?>
                        <?php echo twenty_twenty_one_get_icon_svg( 'ui', 'close' ); ?>
                    </span>
                </button>
            </div>
                            
            <?php
                wp_nav_menu(
                    array(
                            'theme_location'  => 'footer-menu',
                            'menu_class'      => 'menu-wrapper',
                            'container_class' => 'primary-menu-container',
                            'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
                            'fallback_cb'     => false,
                        )
                );
            ?>

        </nav>
        <?php endif; ?>
    </div>


    <!-- Lightbox Overlay -->
    <div id="lightbox-overlay" class="lightbox-overlay">
        <div class="lightbox-content">
            <img src="" alt="" class="lightbox-image">
            <p class="lightbox-title"></p>
            <button class="lightbox-prev">Précédent</button>
            <button class="lightbox-next">Suivant</button>
            <button class="lightbox-close">Fermer</button>
        </div>
    </div>

   
</footer>
 <!-- Inclusion de la modale de contact ------------------------------------------------------------------------->
 <?php get_template_part('templates_part/contact-modal'); ?>
    
<?php wp_footer(); ?>
