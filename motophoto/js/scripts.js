document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('contact-modal');
    const closeModal = document.querySelector('.close-modal');
    const openModal = document.querySelectorAll('.contact-button');

    // Ouvrir la modale
    openModal.forEach(function (e) {
        e.addEventListener('click', () => {
            modal.style.display = "block";

            // Récupérer la valeur de photoRef et la mettre dans le champ du formulaire
            var photoRef = '<?php echo esc_js(get_post_meta(get_the_ID(), "reference", true)); ?>';

            document.querySelector('#contact-form .photo-reference').value = photoRef;
        });
    })

    // Fermer la modale
    closeModal.addEventListener('click', () => {
        modal.style.display = "none";
    });
});

//************************** Gestion des filtres ***************************** */
// Gestion des filtres
const filterForm = document.getElementById('photo-filter-form');
const galleryContainer = document.querySelector('.galerie-photos');

// Fonction pour charger les photos en fonction des filtres
const loadPhotos = () => {
    const formData = new FormData(filterForm);
    const params = new URLSearchParams();

    for (const [key, value] of formData.entries()) {
        if (value) params.append(key, value);
    }

    fetch(`/wp-json/photo-gallery/v1/filter?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            galleryContainer.innerHTML = '';
            if (data.length > 0) {
                data.forEach(photo => {
                    const photoItem = document.createElement('div');
                    photoItem.classList.add('photo-item');
                    photoItem.innerHTML = `
                        <a href="${photo.url}">
                            <img src="${photo.image}" alt="${photo.title}">
                        </a>
                        <h3>${photo.title}</h3>
                    `;
                    galleryContainer.appendChild(photoItem);
                });
            } else {
                galleryContainer.innerHTML = '<p>Aucune photo trouvée.</p>';
            }
        })
        .catch(error => console.error('Erreur lors du chargement des photos :', error));
};

// Écouter les changements sur les champs de filtre
filterForm.querySelectorAll('select').forEach(select => {
    select.addEventListener('change', loadPhotos);
});

//******************************************************** */
// Fonction pour mettre à jour la galerie
function updateGallery(data) {
    galleryContainer.innerHTML = '';
    if (data.length > 0) {
        data.forEach(photo => {
            const photoItem = document.createElement('div');
            photoItem.classList.add('photo-item');
            photoItem.innerHTML = `
                 <a href="${photo.url}">
                     <img src="${photo.image}" alt="${photo.title}">
                 </a>
                 <h3>${photo.title}</h3>
             `;
            galleryContainer.appendChild(photoItem);
        });
    } else {
        galleryContainer.innerHTML = '<p>Aucune photo trouvée.</p>';
    }
}

// Filtrage initial de la galerie
filterGallery('all');
//**************************************************** */

// Fonction gallerie-photos :
function filterGallery(category) {
    let items = document.querySelectorAll('.gallery .item');
    items.forEach(item => {
        if (category === 'all' || item.classList.contains(category)) {
            item.classList.add('show');
        } else {
            item.classList.remove('show');
        }
    });
}

// Charger toutes les images au début
filterGallery('all');

document.getElementById('loadMore').addEventListener('click', function () {
    const button = this;
    const currentPage = parseInt(button.getAttribute('data-page')); // Page actuelle
    const nextPage = currentPage + 1; // Prochaine page

    // Effectuer une requête AJAX pour charger plus d'images
    fetch(`/wp-admin/admin-ajax.php?action=load_more_photos&page=${nextPage}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.html) {
                // Ajouter les nouvelles images au conteneur
                document.getElementById('gallery').insertAdjacentHTML('beforeend', data.html);

                // Mettre à jour le numéro de page
                button.setAttribute('data-page', nextPage);

                // Cacher le bouton si toutes les images sont chargées
                if (!data.has_more) {
                    button.style.display = 'none';
                }
            }
        })
        .catch(error => console.error('Erreur lors du chargement des images :', error));
});
