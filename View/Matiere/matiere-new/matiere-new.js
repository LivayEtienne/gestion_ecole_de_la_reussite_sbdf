// Ajoute ici tout code JavaScript nécessaire pour améliorer la page, par exemple, validation ou gestion des événements.
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const modal = document.getElementById('successModal');
    const successModal = document.getElementById('successModal');
    const errorModal = document.getElementById('errorModal');
    const closeModalElements = document.querySelectorAll('.close');

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === '1') {
        // Récupérer les informations de l'administrateur ajouté
        const nom_cycle = urlParams.get('nom_matiere');
        
        // Remplir les champs de la modale avec ces informations
        document.getElementById('modalnom_matiere').textContent = nom_cycle;
        
        // Afficher la modale
        modal.style.display = 'block';
    }else if (urlParams.get('error') === '1') {
        // Afficher la modale d'erreur
        document.getElementById('errorMessage').textContent = urlParams.get('message');
        errorModal.style.display = 'block';
    }

     // Fonction pour fermer les modales
    function closeModals() {
        successModal.style.display = 'none';
        errorModal.style.display = 'none';
    }

    // Fermer les modales quand on clique sur le bouton "fermer"
    closeModalElements.forEach(function (closeElement) {
        closeElement.addEventListener('click', closeModals);
    });

    // Fermer les modales quand on clique en dehors du contenu de la modale
    window.addEventListener('click', function (event) {
        if (event.target === successModal || event.target === errorModal) {
            closeModals();
        }
    });
});
