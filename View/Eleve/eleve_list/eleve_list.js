// Fonction pour ouvrir le modal
function openModal(eleveId) {
    const modal = document.getElementById("confirmationModal");
    const confirmButton = document.getElementById("confirmArchive");

    // Modifier le lien de confirmation avec l'ID de l'élève
    confirmButton.setAttribute("onclick", `confirmArchive(${eleveId})`);
    
    modal.style.display = "block"; // Affiche le modal
}

// Fonction pour fermer le modal
function closeModal() {
    const modal = document.getElementById("confirmationModal");
    modal.style.display = "none"; // Cache le modal
}

// Fonction pour confirmer l'archivage
function confirmArchive(eleveId) {
    // Redirige vers l'URL d'archivage
    window.location.href = `?action=archiver&id=${eleveId}`;
}

// Ferme le modal lorsqu'on clique à l'extérieur de celui-ci
window.onclick = function(event) {
    const modal = document.getElementById("confirmationModal");
    if (event.target === modal) {
        closeModal();
    }
};

// Fonction pour rechercher les élèves
function searchStudents() {
    const matricule = document.getElementById('searchMatricule').value;
    const classe = document.getElementById('searchClasse').value;

    // Logique de recherche à implémenter ici
    console.log("Recherche par matricule :", matricule);
    console.log("Recherche par classe :", classe);
    
    // Vous pouvez ajouter la logique pour filtrer la liste des élèves ici.
}
