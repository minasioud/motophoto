document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('contact-modal');
    const closeModal = document.querySelector('.close-modal');

    // Ouvrir la modale
    document.querySelectorAll('.open-contact-modal').forEach(button => {
        button.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });
    });

    // Fermer la modale
    closeModal.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // Fermer la modale en cliquant en dehors du contenu
    window.addEventListener('click', (e) => {
        if (e.target == modal) {
            modal.classList.add('hidden');
        }
    });
});
