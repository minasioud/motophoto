document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('contact-modal');
    const closeModal = document.querySelector('.close-modal');
    const openModalButtons = document.querySelectorAll('.contact-button');

    if (modal && openModalButtons.length > 0) {
        // Ouvrir la modale
        openModalButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const photoRef = button.getAttribute('data-photo-ref'); // Récupère la référence via un attribut data
                modal.style.display = "block";

                // Insérer la référence dans le formulaire
                const photoReferenceField = document.querySelector('#contact-form .photo-reference');
                if (photoReferenceField) {
                    photoReferenceField.value = photoRef || '';
                }
            });
        });

        // Fermer la modale
        if (closeModal) {
            closeModal.addEventListener('click', () => {
                modal.style.display = "none";
            });
        }
    }
});
