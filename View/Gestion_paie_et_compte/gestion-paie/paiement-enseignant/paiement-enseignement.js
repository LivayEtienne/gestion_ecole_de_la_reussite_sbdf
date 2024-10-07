// surveillant-list.js

document.addEventListener('DOMContentLoaded', function() {
    const payerButtons = document.querySelectorAll('.payer-btn');

    payerButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Changement de couleur et désactivation du bouton
            this.classList.remove('btn-danger');
            this.classList.add('btn-secondary');
            this.textContent = 'Payé';
            this.disabled = true;

            // Récupérer la cellule 'Statut' correspondante dans la même ligne
            const row = this.closest('tr');
            const statutCell = row.querySelector('.statut span');

            // Mettre à jour le statut en "Payé" avec la couleur verte
            statutCell.classList.remove('bg-danger');
            statutCell.classList.add('bg-success');
            statutCell.textContent = 'Payé';

            // Vous pouvez ajouter ici une requête AJAX pour mettre à jour le statut dans la base de données
            const employeId = this.getAttribute('data-id');
            console.log('Employé payé, ID:', employeId);

            // Exemple de requête AJAX (commenté)
            /*
            fetch('payer_employe.php', {
                method: 'POST',
                body: JSON.stringify({ id: employeId }),
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                return response.json();
            }).then(data => {
                if (data.success) {
                    console.log('Paiement confirmé pour l\'employé ID:', employeId);
                } else {
                    console.error('Erreur lors du paiement.');
                }
            });
            */
        });
    });
});
