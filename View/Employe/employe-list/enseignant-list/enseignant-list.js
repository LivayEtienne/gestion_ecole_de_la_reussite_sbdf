// Sélectionner tous les liens d'archivage
const archiveLinks = document.querySelectorAll('a.icon-yellow');
const confirmModal = document.getElementById('confirmModal');
const confirmArchiveButton = document.getElementById('confirmArchive');
const cancelArchiveButton = document.getElementById('cancelArchive');
const closeModal = document.querySelector('.close');
const overlay = document.getElementById('overlay');

// Variable pour stocker l'URL de redirection
let archiveUrl = '';

// Fonction pour afficher le modal et l'overlay
const showModal = (url) => {
    archiveUrl = url; // Stocke l'URL de redirection
    overlay.classList.add('show'); // Affiche l'overlay
    confirmModal.classList.add('show'); // Affiche le modal
    confirmModal.style.display = 'block'; // S'assure que le modal est affiché
    setTimeout(() => { // Permet d'appliquer l'animation de fade in
        confirmModal.style.opacity = '1'; // Rendre le modal visible
    }, 10);
};

// Fonction pour masquer le modal et l'overlay
const hideModal = () => {
    confirmModal.style.opacity = '0'; // Rendre le modal invisible
    setTimeout(() => {
        overlay.classList.remove('show'); // Cache l'overlay
        confirmModal.classList.remove('show'); // Cache le modal
        confirmModal.style.display = 'none'; // Cache le modal
    }, 400); // Attendre la durée de l'animation avant de retirer les classes
};

// Ajouter des écouteurs aux liens d'archivage
archiveLinks.forEach(link => {
    link.addEventListener('click', (event) => {
        event.preventDefault();
        showModal(link.href); // Affiche le modal avec l'URL de redirection
    });
});

// Confirmer l'archivage
confirmArchiveButton.addEventListener('click', () => {
    window.location.href = archiveUrl; // Redirection vers l'URL d'archivage
});

// Annuler l'archivage
cancelArchiveButton.addEventListener('click', hideModal);
closeModal.addEventListener('click', hideModal);

// Fermer le modal et l'overlay en cliquant en dehors du contenu du modal
window.addEventListener('click', (event) => {
    if (event.target === overlay) {
        hideModal(); // Fermer uniquement si on clique sur l'overlay
    }
});
