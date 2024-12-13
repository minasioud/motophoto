<?php
// Récupérer les photos et les catégories depuis ACF
$photos = get_field('photos');
$categories = get_field('categories');
?>
<div class="gallerie-container">
    <h2>Galerie de Photos</h2>
    <div id="filters">
        <button onclick="filterGallery('all')">Tous</button>
        <?php
        // Afficher les boutons pour chaque catégorie unique
        if ($categories) {
            foreach (array_unique($categories) as $category) {
                echo '<button onclick="filterGallery(\'' . esc_attr($category) . '\')">' . esc_html($category) . '</button>';
            }
        }
        ?>
    </div>

    <div class="gallery">
        <?php if ($photos): ?>
            <?php foreach ($photos as $photo): ?>
                <?php
                // Récupérer les catégories attribuées à l'image
                $photo_categories = get_field('categories', $photo['ID']);
                $category_classes = $photo_categories ? implode(' ', $photo_categories) : '';
                ?>
                <div class="item <?php echo esc_attr($category_classes); ?>">
                    <img src="<?php echo esc_url($photo['url']); ?>" alt="<?php echo esc_attr($photo['alt']); ?>">
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>