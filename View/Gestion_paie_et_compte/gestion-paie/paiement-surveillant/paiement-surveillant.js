$(document).ready(function() {
    // Fonction pour mettre à jour la page lors du changement de filtre
    function updatePage() {
        const selectedMonth = $('#mois-select').val();
        const selectedYear = $('#annee-select').val();
        const searchTerm = $('#search-input').val();
        const roleFilter = $('#role').val();

        // Rediriger vers la même page avec les nouveaux paramètres
        const params = new URLSearchParams();
        if (selectedMonth) params.append('mois', selectedMonth);
        if (selectedYear) params.append('annee', selectedYear);
        if (searchTerm) params.append('search', searchTerm);
        if (roleFilter) params.append('role', roleFilter);

        window.location.href = `paiement-surveillant.php?${params.toString()}`;
    }

    // Détection des changements dans les sélecteurs pour mise à jour automatique
    $('#mois-select, #annee-select, #role').on('change', function() {
        updatePage();
    });

    // Écouteur d'événement pour le bouton Payer
    $('.payer-btn').on('click', function() {
        const id = $(this).data('id');
        const nom = $(this).data('nom');
        const prenom = $(this).data('prenom');
        const salaire = $(this).data('salaire');
        const mois = $(this).data('mois');
        const annee = $(this).data('annee');

        // Remplissage des champs du modal
        $('#nom-complet').text(`${prenom} ${nom}`);
        $('#montant-paiement').text(salaire);
        $('#mois-paiement').text(mois);
        $('#annee-paiement').text(annee);

        // Stocker l'ID de l'administrateur dans le bouton de confirmation
        $('#confirmPayment').data('id', id);
        $('#confirmPayment').data('salaire', salaire);
        $('#confirmPayment').data('mois', mois);
        $('#confirmPayment').data('annee', annee);

        // Réinitialiser le mode de paiement sélectionné
        $('#selectedPaymentMode').val('');
        $('.payment-card').removeClass('border-primary');
        $('#confirmPayment').prop('disabled', true);

        // Afficher le modal
        $('#paiementModal').modal('show');
    });

    // Écouteur d'événement pour les cartes de paiement
    $('.payment-card').on('click', function() {
        // Suppression de la classe active de toutes les cartes
        $('.payment-card').removeClass('border-primary');
        
        // Ajout de la classe active à la carte sélectionnée
        $(this).addClass('border-primary');

        // Récupération du mode de paiement sélectionné
        const mode = $(this).data('mode');
        $('#selectedPaymentMode').val(mode);

        // Activer le bouton de confirmation
        $('#confirmPayment').prop('disabled', false);
    });

    // Écouteur d'événement pour confirmer le paiement
    $('#confirmPayment').on('click', function() {
        const modePaiement = $('#selectedPaymentMode').val();
        if (!modePaiement) {
            alert('Veuillez sélectionner un mode de paiement.');
            return;
        }

        const idAdmin = $(this).data('id');
        const salaire = $(this).data('salaire');
        const mois = $(this).data('mois');
        const annee = $(this).data('annee');
        const datePaiement = new Date().toISOString().slice(0, 10); // Format YYYY-MM-DD

        // Envoyer une requête AJAX pour enregistrer le paiement dans la base de données
        $.ajax({
            url: 'enregistrer-paiement-surveillant.php',
            method: 'POST',
            data: {
                id_admin: idAdmin,
                salaire: salaire,
                mois: mois,
                annee: annee,
                date_paiement: datePaiement,
                mode_paiement: modePaiement
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Fermer le modal
                    $('#paiementModal').modal('hide');

                    // Mettre à jour le statut dans le tableau
                    $('#status-' + idAdmin).html('<span class="badge bg-success">Payé</span>');

                    // Désactiver le bouton "Payer" et changer son apparence après succès
                    $('.payer-btn[data-id="' + idAdmin + '"]').prop('disabled', true);
                    $('.payer-btn[data-id="' + idAdmin + '"]').text('Payé');
                    $('.payer-btn[data-id="' + idAdmin + '"]').removeClass('btn-danger').addClass('btn-success');

                    // Mettre à jour le bouton 'Reçu' dans le tableau
                    $('#recu-' + idAdmin).html('<a href="generate-pdf.php?id=' + response.paiement_id + '" class="btn btn-info">Télécharger Reçu</a>');

                    // Afficher le modal de succès
                    $('#successPaymentMode').text(modePaiement);
                    $('#successModal').modal('show');
                } else {
                    alert('Une erreur est survenue lors du paiement.');
                }
            },
            error: function() {
                alert('Une erreur est survenue lors du paiement.');
            }
        });
    });
});
