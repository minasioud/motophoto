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
