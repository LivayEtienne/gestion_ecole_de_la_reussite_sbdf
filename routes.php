<?php
// Hachage du mot de passe
$hashedPassword = password_hash("password123", PASSWORD_DEFAULT);

// Affichage du mot de passe haché
echo $hashedPassword;
?>
