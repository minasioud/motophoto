document.addEventListener('DOMContentLoaded', function () {
    const lightboxOverlay = document.getElementById('lightbox-overlay');
    const lightboxImage = document.getElementById('lightbox-image');
    const lightboxTitle = document.getElementById('lightbox-title');
    const lightboxDescription = document.getElementById('lightbox-description');
    const lightboxClose = document.querySelector('.lightbox-close');
    const lightboxPrev = document.querySelector('.lightbox-prev');
    const lightboxNext = document.querySelector('.lightbox-next');
    const galleryImages = document.querySelectorAll('.gallery-image');

    let currentImageIndex = 0;

    // Ouvrir la lightbox
    galleryImages.forEach((img, index) => {
        img.addEventListener('click', () => {
            currentImageIndex = index;
            showLightbox(img);
        });
    });

    function showLightbox(img) {
        lightboxImage.src = img.src;
        lightboxTitle.textContent = img.alt || "Photo";
        lightboxDescription.textContent = img.getAttribute('data-description') || "Aucune description disponible.";
        lightboxOverlay.style.display = 'flex';
    }

    // Fermer la lightbox
    lightboxClose.addEventListener('click', () => {
        lightboxOverlay.style.display = 'none';
    });

    // Navigation dans la lightbox
    lightboxPrev.addEventListener('click', () => {
        currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
        showLightbox(galleryImages[currentImageIndex]);
    });

    lightboxNext.addEventListener('click', () => {
        currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
        showLightbox(galleryImages[currentImageIndex]);
    });

    // Fermer la lightbox en cliquant sur l'overlay
    lightboxOverlay.addEventListener('click', (event) => {
        if (event.target === lightboxOverlay) {
            lightboxOverlay.style.display = 'none';
        }
    });
});
