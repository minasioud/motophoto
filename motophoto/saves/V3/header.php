<?php
/**
 * Displays the site navigation.
 *
 * @package WordPress
 * @subpackage Motophoto
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); /**  Ajoute automatiquement des classes au <body>*/ ?>> 
<?php wp_body_open(); ?>
    
    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'motophoto' ); ?></a>
        
        <header id="id_cheader" class="conteneur_header" role="banner">
                     
            <!-- Logo Section -->
            <div class="logo_conteneur">
                <?php 
                    if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) 
                    {
                        the_custom_logo();
                    } 
                    else { ?> 
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo_titre"><?php bloginfo( 'name' ); ?></a> <?php 
                        }
                ?>
            </div>
            
            <div class="nav_conteneur">
                <!-- Navigation Menu -->
                <?php if ( has_nav_menu( 'main-menu' ) ) : ?>
                        <nav id="id-nav" class="nav_menu desktop-menu" aria-label="<?php esc_attr_e( 'Main menu', 'motophoto' ); ?>">          
                    
                            <?php
                                wp_nav_menu(
                                    array(
                                        'theme_location'  => 'main-menu',
                                        'menu_class'      => 'menu-wrapper',
                                        'container_class' => 'primary-menu-container',
                                        'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
                                        'fallback_cb'     => function() {
                                            echo '<ul class="menu-wrapper"><li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'motophoto' ) . '</a></li></ul>';
                                        },
                                    )
                                );
                            ?>
                                
                        </nav>
                <?php else : ?>
                    <p><?php esc_html_e( 'No menu assigned. Please set up a menu in the WordPress admin.', 'motophoto' ); ?></p>
                <?php endif; ?>
                
                <!-- Menu mobile -->
                <div id="burger-menu-button" class="burger-menu-button" aria-label="<?php esc_attr_e( 'Toggle menu', 'motophoto' ); ?>">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                <nav id="mobile-nav" class="nav_menu mobile-menu" aria-label="<?php esc_attr_e( 'Mobile menu', 'motophoto' ); ?>">
                    <?php
                        wp_nav_menu(
                            array(
                                'theme_location'  => 'main-menu',
                                'menu_class'      => 'menu-wrapper',
                                'container_class' => 'primary-menu-container',
                                'items_wrap'      => '<ul id="mobile-menu-list" class="%2$s">%3$s</ul>',
                                'fallback_cb'     => function() {
                                    echo '<ul class="menu-wrapper"><li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'motophoto' ) . '</a></li></ul>';
                                },
                            )
                        );
                    ?>
                </nav>
                
                <?php /* <button class="contact-button" data-photo-ref="12345">CONTACT</button>   */?>
            </div>
        </header>
    </div>