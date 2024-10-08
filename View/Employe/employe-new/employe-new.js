document.addEventListener('DOMContentLoaded', function () {
    const roleSelect= document.getElementById('role');
    const salaireFixeSection = document.getElementById('salaire_fixe_section');
    const tarifHoraireSection = document.getElementById('tarif_horaire_section');
    const successModal = document.getElementById('successModal');
    const errorModal = document.getElementById('errorModal');
    const closeModalElements = document.querySelectorAll('.close');
    const form = document.getElementById('form-ajout');
    const passwordInput = document.getElementById('mot_de_passe');
    const confirmPasswordInput = document.getElementById('confirm_mot_de_passe');


    // Ajouter l'écouteur pour l'icône de mot de passe
    document.getElementById('togglePassword').addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });


    salaireFixeSection.style.display = 'none';
    tarifHoraireSection.style.display = 'none';
    // Afficher ou masquer les champs salaire fixe ou tarif horaire
    roleSelect.addEventListener('change', function () {
        const selectedRole = roleSelect.value;
        if (selectedRole === 'enseignant_secondaire') {
            tarifHoraireSection.style.display = 'block';
            salaireFixeSection.style.display = 'none';
        } else if(selectedRole === 'directeur'||selectedRole === 'enseignant_primaire'||selectedRole === 'surveillant_classe'||selectedRole === 'comptable'||selectedRole === 'surveillant_general') {
            tarifHoraireSection.style.display = 'none';
            salaireFixeSection.style.display = 'block';
        }else{
            tarifHoraireSection.style.display = 'none';
            salaireFixeSection.style.display = 'none';
        }
    });


    
    
 
    // Vérifier les mots de passe avant l'envoi du formulaire
    form.addEventListener('submit', function (event) {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        // Vérification si les mots de passe ne correspondent pas
        if (password !== confirmPassword) {
            event.preventDefault(); // Empêcher l'envoi du formulaire
            alert('Les mots de passe ne correspondent pas. Veuillez réessayer.');
        }else{
            // Vérifier si l'URL contient des paramètres de succès ou d'erreur
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
        
        // Afficher la modale de succès
        successModal.style.display = 'block';
    } else if (urlParams.get('error') === '1') {
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

        }
    });

    // Vérifier si l'URL contient des paramètres de succès ou d'erreur
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
        
        // Afficher la modale de succès
        successModal.style.display = 'block';
    } else if (urlParams.get('error') === '1') {
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
