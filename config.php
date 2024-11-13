<?php
$hote = 'localhost'; // A remplacer par l'ip du serveurBD
$nom_bdd = 'bdreseau'; // jsp
$utilisateur = 'root';
$mot_de_passe = ''; // toor

try {
    $bdd = new PDO("mysql:host=$hote;dbname=$nom_bdd;charset=utf8", $utilisateur, $mot_de_passe);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
