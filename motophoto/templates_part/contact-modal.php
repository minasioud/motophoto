<?php
/**
 * The template for displaying contact modal
 *
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 * Autor: mina
 */
?>
<div id="contact-modal" class="contact-modal" >
    <div class="modal-content">
        <div class="modal-header">
            <h2>CONTACT</h2>

            <span class="close-modal">
                <i class="fa fa-times"></i>                
            </span>
        </div>
        <div class="modal-details">
            <!-- Utilisation de Contact Form 7 pour le formulaire de contact -->
            <?php echo do_shortcode('[contact-form-7 id="b824493" title="Formulaire de contact 1"]'); ?>
        </div>
    </div>
</div>


