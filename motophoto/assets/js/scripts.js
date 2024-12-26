// Fonction pour basculer l'état du menu burger
function toggleMenu() {
    const header = document.querySelector('.nav_conteneur');
    header.classList.toggle('open');
}

// Ajouter un événement au burger pour ouvrir/fermer le menu
const burger = document.querySelector('.menu-burger');
burger.addEventListener('click', toggleMenu);
