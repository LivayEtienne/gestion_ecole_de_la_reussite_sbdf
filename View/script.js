document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordField = document.getElementById('password');
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
});
//la barre de recherche par nom ou par matricule liste surveillant
document.getElementById('searchButton').addEventListener('click', function() {
    var searchInput = document.getElementById('searchInput').value;
    var tableRows = document.getElementById('surveillantTableBody').rows;

    for (var i = 0; i < tableRows.length; i++) {
        var row = tableRows[i];
        var matriculeCell = row.cells[0];
        var nomCell = row.cells[1];

        if (matriculeCell.textContent.toLowerCase().includes(searchInput.toLowerCase()) || nomCell.textContent.toLowerCase().includes(searchInput.toLowerCase())) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
});

                        // Script pour gérer les modals
                        document.addEventListener('DOMContentLoaded', function () {
                            const paymentOptionsModal = document.getElementById('paymentOptionsModal');
                            const paymentModal = document.getElementById('paymentModal');
                            const confirmationModal = document.getElementById('confirmationModal');

                            // Remplir le modal de paiement avec les informations du professeur
                            paymentOptionsModal.addEventListener('show.bs.modal', function (event) {
                                const button = event.relatedTarget; // Bouton qui a déclenché le modal
                                const professeurId = button.getAttribute('data-id');
                                const nom = button.getAttribute('data-nom');
                                const prenom = button.getAttribute('data-prenom');

                                // Mettre à jour le champ caché avec l'ID du professeur
                                document.getElementById('professeurId').value = professeurId;
                                
                                // Remplir le modal de confirmation
                                document.getElementById('confirmNomPrenom').innerText = nom + ' ' + prenom;
                            });

                            // Gérer le choix du mode de paiement et ouvrir le modal de paiement
                            document.querySelectorAll('input[name="modePaiement"]').forEach(function (element) {
                                element.addEventListener('change', function () {
                                    // Ouvrir le modal de paiement lorsque l'utilisateur clique sur un mode de paiement
                                    const paymentModalInstance = new bootstrap.Modal(paymentModal);
                                    paymentModalInstance.show();
                                });
                            });

                            // Gérer la soumission du formulaire de paiement
                            const paymentForm = document.getElementById('paymentForm');
                            paymentForm.addEventListener('submit', function (event) {
                                event.preventDefault(); // Arrêter la soumission du formulaire
                                // Ouvrir le modal de confirmation
                                const confirmationModalInstance = new bootstrap.Modal(confirmationModal);
                                confirmationModalInstance.show();
                            });

                            // Gérer la confirmation du paiement
                            document.getElementById('confirmPaymentButton').addEventListener('click', function () {
                                // Récupérer les valeurs
                                const professeurId = document.getElementById('professeurId').value;
                                const montant = document.getElementById('montant').value;
                                const modePaiement = document.querySelector('input[name="modePaiement"]:checked').value;

                                // Ici, vous devriez appeler une fonction pour traiter le paiement avec les valeurs ci-dessus

                                // Fermer les modals
                                bootstrap.Modal.getInstance(paymentModal).hide();
                                bootstrap.Modal.getInstance(confirmationModal).hide();

                                // Afficher un message de succès ou rediriger, selon votre logique
                                alert('Paiement réussi pour le professeur avec ID: ' + professeurId + ', Montant: ' + montant + ', Mode de Paiement: ' + modePaiement);
                            });
                            
                        });
                       // Fonction pour valider le formulaire
                            function validateForm() {
                                const nom = document.getElementById('nom').value;
                                const telephone = document.getElementById('telephone').value;
                                const phoneError = document.getElementById('phoneError');

                                // Réinitialisation des messages d'erreur
                                phoneError.style.display = 'none';

                                // Validation du nom
                                if (nom.trim() === '') {
                                    alert('Veuillez entrer votre nom.');
                                    return false; // Empêche la soumission
                                }

                                // Validation du numéro de téléphone
                                const phoneRegex = /^(77|76|75|78)\d{7}$/;
                                if (!phoneRegex.test(telephone)) {
                                    phoneError.style.display = 'block';
                                    return false; // Empêche la soumission
                                }

                                return true; // Permet la soumission
                            }
                            
