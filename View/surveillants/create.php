<?php ob_start(); ?>
<h1>Ajouter un Surveillant</h1>
<form method="POST" action="">
    <div class="form-group">
        <label for="matricule">Matricule</label>
        <input type="text" class="form-control" id="matricule" name="matricule">
    </div>
    <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom">
    </div>
    <div class="form-group">
        <label for="prenom">Prénom</label>
        <input type="text" class="form-control" id="prenom" name="prenom">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email">
    </div>
    <div class="form-group">
        <label for="classe">Classe</label>
        <input type="text" class="form-control" id="classe" name="classe">
    </div>
    <button type="submit" class="btn btn-primary mt-3">Ajouter</button>
</form>
<?php $content = ob_get_clean(); ?>
<?php require 'views/layout.php'; ?>
