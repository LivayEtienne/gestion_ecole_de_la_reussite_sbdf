// surveillant-list.js

document.addEventListener('DOMContentLoaded', function() {
    const payerButtons = document.querySelectorAll('.payer-btn');
    const moisSelect = document.getElementById('mois-select');
    const tableBody = document.getElementById('employe-table-body');

    // Gérer le clic sur le bouton "Payer"
    payerButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Changement de couleur et désactivation du bouton
            this.classList.remove('btn-danger');
            this.classList.add('btn-secondary');
            this.textContent = 'Payé';
            this.disabled = true;

            // Mettre à jour le statut en "Payé" avec la couleur verte
            const row = this.closest('tr');
            const statutCell = row.querySelector('.statut span');
            statutCell.classList.remove('bg-danger');
            statutCell.classList.add('bg-success');
            statutCell.textContent = 'Payé';

            // Récupérer l'ID de l'employé pour mise à jour via AJAX (optionnel)
            const employeId = this.getAttribute('data-id');
            console.log('Employé payé, ID:', employeId);
        });
    });

    // Gérer la sélection d'un mois
    moisSelect.addEventListener('change', function() {
        const selectedMois = this.value.toLowerCase(); // Récupérer la valeur du mois sélectionné
        const rows = tableBody.querySelectorAll('tr');

        rows.forEach(row => {
            const rowMois = row.getAttribute('data-mois');
            if (rowMois === selectedMois) {
                row.style.display = ''; // Afficher la ligne si le mois correspond
            } else {
                row.style.display = 'none'; // Masquer la ligne sinon
            }
        });
    });
});
