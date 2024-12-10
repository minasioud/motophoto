<?php
/**
 * Displays the site navigation.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
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
                <?php if ( has_nav_menu( 'primary' ) ) : ?>
                    <nav id="id-nav" class="nav_menu" aria-label="<?php esc_attr_e( 'Primary menu', 'twentytwentyone' ); ?>">
                    
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
                                    'theme_location'  => 'primary',
                                    'menu_class'      => 'menu-wrapper',
                                    'container_class' => 'primary-menu-container',
                                    'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
                                    'fallback_cb'     => false,
                                )
                            );
                        ?>
                             
                    </nav>
                <?php endif; ?>
               <?php /* <button class="contact-button">CONTACT</button>   */?>
            </div>
        </header>

