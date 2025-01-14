<?php
$hote = '192.168.1.3'; // A remplacer par l'ip du serveurBD
$nom_bdd = 'ma_bd'; // jsp
$utilisateur = 'NatJuThi';
$mot_de_passe = 'Helium64'; // toor

try {
    $bdd = new PDO("mysql:host=$hote;dbname=$nom_bdd;charset=utf8", $utilisateur, $mot_de_passe);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
