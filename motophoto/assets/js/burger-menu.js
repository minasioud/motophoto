document.addEventListener('DOMContentLoaded', function () {
    const burgerButton = document.getElementById('burger-menu');
    const mobileMenu = document.getElementById('mobile-nav');

    burgerButton.addEventListener('click', function () {
        // Ajoute ou supprime la classe 'visible' sur le menu mobile
        mobileMenu.classList.toggle('visible');
        // Ajoute ou supprime la classe 'active' sur le burger menu
        burgerButton.classList.toggle('active');
    });
});
