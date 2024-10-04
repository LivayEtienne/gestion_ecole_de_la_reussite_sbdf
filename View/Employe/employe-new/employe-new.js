document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('role');
    const salaireFixeSection = document.getElementById('salaire_fixe_section');
    const tarifHoraireSection = document.getElementById('tarif_horaire_section');
    const modal = document.getElementById('successModal');
    const successModal = document.getElementById('successModal');
    const errorModal = document.getElementById('errorModal');
    const closeModalElements = document.querySelectorAll('.close');
    const closeModal = document.querySelector('.close');
    
    // Afficher ou masquer les champs salaire fixe ou tarif horaire
    roleSelect.addEventListener('change', function () {
        const selectedRole = roleSelect.value;
        if (selectedRole === 'enseignant_secondaire') {
            tarifHoraireSection.style.display = 'block';
            salaireFixeSection.style.display = 'none';
        } else {
            tarifHoraireSection.style.display = 'block';
            salaireFixeSection.style.display = 'none';
        }
    });

    // Vérifier si l'URL contient des paramètres de succès
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === '1') {
        // Récupérer les informations de l'administrateur ajouté
        const nom = urlParams.get('nom');
        const prenom = urlParams.get('prenom');
        const email = urlParams.get('email');
        const role = urlParams.get('role');
        
        // Remplir les champs de la modale avec ces informations
        document.getElementById('modalNom').textContent = nom;
        document.getElementById('modalPrenom').textContent = prenom;
        document.getElementById('modalEmail').textContent = email;
        document.getElementById('modalRole').textContent = role;
        
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
