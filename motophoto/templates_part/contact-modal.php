<?php
/**
 * The template for displaying contact modal
 *
 *
 * @package WordPress
 * @subpackage motophoto
 * @since motophoto 1.0
 * Autor: mina
 */
?>
<div id="contact-modal" class="contact-modal" role="dialog" aria-labelledby="contact-modal-label" aria-hidden="true">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="contact-modal-label">CONTACT</h2>

            <span class="close-modal" aria-label="Close modal">
                <i class="fa fa-times"></i>                
            </span>
        </div>
        <div class="modal-details">
            <!-- Utilisation de Contact Form 7 pour le formulaire de contact -->
            <?php echo do_shortcode('[contact-form-7 id="b824493" title="Formulaire de contact 1"]'); ?>
        </div>
    </div>
</div>



