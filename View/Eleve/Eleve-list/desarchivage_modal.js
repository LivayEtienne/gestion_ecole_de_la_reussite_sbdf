// Ouvrir le modal de confirmation pour désarchiver un élève
function openModal(eleveId) {
    const modal = document.getElementById("confirmationModal");
    const confirmButton = document.getElementById("confirmArchive");

    // Modifier le lien de confirmation avec l'ID de l'élève
    confirmButton.setAttribute("onclick", `confirmDesarchivage(${eleveId})`);
    
    modal.style.display = "block"; // Affiche le modal
}

// Fermer le modal
function closeModal() {
    const modal = document.getElementById("confirmationModal");
    modal.style.display = "none"; // Cache le modal
}

// Confirmer le désarchivage
function confirmDesarchivage(eleveId) {
    // Redirige vers l'URL de désarchivage
    window.location.href = `?action=desarchiver&id=${eleveId}`;
}

// Ferme le modal en cliquant à l'extérieur de celui-ci
window.onclick = function(event) {
    const modal = document.getElementById("confirmationModal");
    if (event.target === modal) {
        closeModal();
    }
};
