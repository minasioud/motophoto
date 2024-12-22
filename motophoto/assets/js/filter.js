jQuery(document).ready(function ($) {
    const filtersForm = $('#galerie-filters-form');
    const photoContainer = $('#g-photo-container');

    // Gestion des changements dans les champs de filtre
    filtersForm.find('select').on('change', function () {
        const formData = filtersForm.serialize(); // Sérialiser les données du formulaire

        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'GET',
            data: {
                action: 'filter_photos', // Action WordPress
                ...parseQueryString(formData), // Convertir les données sérialisées en objet
            },
            beforeSend: function () {
                photoContainer.html('<p>Chargement des photos...</p>'); // Afficher un indicateur de chargement
            },
            success: function (data) {
                photoContainer.html(data); // Injecter les nouvelles photos
            },
            error: function () {
                photoContainer.html('<p>Une erreur est survenue lors du chargement des photos.</p>'); // Afficher un message d'erreur
            },
        });
    });

    /**
     * Convertit une chaîne de requête sérialisée en objet.
     * @param {string} queryString - La chaîne de requête sérialisée.
     * @returns {object} - Un objet clé-valeur.
     */
    function parseQueryString(queryString) {
        return queryString
            .split('&')
            .reduce((acc, pair) => {
                const [key, value] = pair.split('=').map(decodeURIComponent);
                acc[key] = value;
                return acc;
            }, {});
    }
});
