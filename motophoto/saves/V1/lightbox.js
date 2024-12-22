document.addEventListener('DOMContentLoaded', () => {
    const lightboxOverlay = document.getElementById('lightbox-overlay');
    const lightboxImage = document.getElementById('lightbox-image');
    const lightboxTitle = document.getElementById('lightbox-title');
    const lightboxDescription = document.getElementById('lightbox-description');
    const lightboxClose = document.querySelector('.lightbox-close');
    const lightboxPrev = document.querySelector('.lightbox-prev');
    const lightboxNext = document.querySelector('.lightbox-next');
    const galleryImages = document.querySelectorAll('.gallery-image');

    let currentImageIndex = 0;

    // Afficher la lightbox
    const showLightbox = (index) => {
        const img = galleryImages[index];
        lightboxImage.src = img.src;
        lightboxTitle.textContent = img.alt || "Photo";
        lightboxDescription.textContent = img.dataset.description || "Aucune description disponible.";
        lightboxOverlay.classList.add('active');
        currentImageIndex = index;
    };

    // Fermer la lightbox
    const closeLightbox = () => {
        lightboxOverlay.classList.remove('active');
    };

    // Navigation dans la lightbox
    const navigateLightbox = (direction) => {
        currentImageIndex = (currentImageIndex + direction + galleryImages.length) % galleryImages.length;
        showLightbox(currentImageIndex);
    };

    // Gestion des événements
    galleryImages.forEach((img, index) => {
        img.addEventListener('click', () => showLightbox(index));
    });

    lightboxClose.addEventListener('click', closeLightbox);
    lightboxPrev.addEventListener('click', () => navigateLightbox(-1));
    lightboxNext.addEventListener('click', () => navigateLightbox(1));

    lightboxOverlay.addEventListener('click', (event) => {
        if (event.target === lightboxOverlay) closeLightbox();
    });

    // Gestion des touches clavier
    document.addEventListener('keydown', (event) => {
        if (!lightboxOverlay.classList.contains('active')) return;

        switch (event.key) {
            case 'ArrowLeft':
                navigateLightbox(-1);
                break;
            case 'ArrowRight':
                navigateLightbox(1);
                break;
            case 'Escape':
                closeLightbox();
                break;
        }
    });
});
