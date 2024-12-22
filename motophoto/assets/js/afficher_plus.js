jQuery(document).ready(function ($) {
    let page = 1; // Page initiale
    const loadMoreBtn = $('#loadMore'); // Sélectionner le bouton
    const photoContainer = $('#g-photo-container'); // Conteneur des photos

    loadMoreBtn.on('click', function () {
        // Désactiver le bouton pour éviter plusieurs clics
        loadMoreBtn.prop('disabled', true);

        // Effectuer la requête AJAX
        $.ajax({
            //url: loadMore.ajaxUrl, // URL de l'admin AJAX
            url: '/wp-admin/admin-ajax.php',
            type: 'GET',
            data: {
                action: 'load_more_photos', // Action AJAX
                page: ++page, // Incrémenter la page
                security: loadMore.nonce, // Nonce pour la sécurité
                categorie: $('#filter_category').val(), // Récupérer la catégorie filtrée
                format: $('#filter_format').val(), // Récupérer le format filtré
                sort: $('#sort-date').val(), // Récupérer le tri
            },
            success: function (response) {
                if (response.success) {
                    // Ajouter les nouvelles photos au conteneur
                    photoContainer.append(response.data.html);

                    // Si plus de photos sont disponibles, continuer à afficher le bouton
                    if (!response.data.has_more) {
                        loadMoreBtn.hide(); // Masquer le bouton si plus de photos
                    }
                } else {
                    alert('Aucune photo supplémentaire trouvée.');
                }
                loadMoreBtn.prop('disabled', false); // Réactiver le bouton
            },
            error: function () {
                alert('Erreur lors du chargement des photos.');
                loadMoreBtn.prop('disabled', false); // Réactiver le bouton
            }
        });
    });
});
