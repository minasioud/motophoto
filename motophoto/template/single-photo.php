<?php
$images = SCF::get('galerie-photos'); // Récupère les images du champ SCF
if ($images) :
    echo '<div class="galerie-photos">';
    foreach ($images as $image_id) :
        $image_url = wp_get_attachment_image_src($image_id, 'large')[0]; // URL de l'image
        echo '<div class="galerie-item">';
        echo '<img src="' . esc_url($image_url) . '" alt="">';
        echo '</div>';
    endforeach;
    echo '</div>';
endif;
?>


