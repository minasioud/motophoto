<footer id="site-footer" class="header-footer-group">
   
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


</footer>
<?php wp_footer(); ?>
