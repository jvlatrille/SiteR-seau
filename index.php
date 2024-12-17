<?php
// Inclure la configuration
include 'config.php';

// Fonction pour exécuter dialog et récupérer une option
function afficherMenuDialog($titre, $options) {
    $menu = "";
    foreach ($options as $index => $option) {
        $menu .= "$index \"{$option}\"\n";
    }

    // Crée la commande dialog
    $commande = "dialog --clear --menu \"$titre\" 15 50 10 $menu 2>&1 >/dev/tty";
    exec($commande, $choix);

    return $choix ? (int)$choix : null;
}

// Étape 1 : Sélectionner un utilisateur
$requete_utilisateurs = $bdd->query("SELECT idUtilisateur, nom FROM Utilisateur");
$utilisateurs = $requete_utilisateurs->fetchAll(PDO::FETCH_KEY_PAIR);

$idUtilisateur = afficherMenuDialog("Sélectionnez un utilisateur", $utilisateurs);

if (!$idUtilisateur) {
    echo "Aucun utilisateur sélectionné.\n";
    exit;
}

// Étape 2 : Sélectionner une playlist
$requete_playlists = $bdd->prepare("SELECT idPlaylist, titre FROM Playlist WHERE idUtilisateur = ?");
$requete_playlists->execute([$idUtilisateur]);
$playlists = $requete_playlists->fetchAll(PDO::FETCH_KEY_PAIR);

if (empty($playlists)) {
    echo "Cet utilisateur n'a aucune playlist.\n";
    exit;
}

$idPlaylist = afficherMenuDialog("Sélectionnez une playlist", $playlists);

if (!$idPlaylist) {
    echo "Aucune playlist sélectionnée.\n";
    exit;
}

// Étape 3 : Afficher les musiques
$requete_musiques = $bdd->prepare("
    SELECT Musique.titre, Musique.artiste, Musique.lien
    FROM Musique
    INNER JOIN Contenir ON Musique.idMusique = Contenir.idMusique
    WHERE Contenir.idPlaylist = ?
");
$requete_musiques->execute([$idPlaylist]);
$musiques = $requete_musiques->fetchAll(PDO::FETCH_ASSOC);

echo "### Musiques dans la Playlist ###\n";
foreach ($musiques as $index => $musique) {
    echo ($index + 1) . ". Titre : {$musique['titre']} | Artiste : {$musique['artiste']} | Lien : {$musique['lien']}\n";
}
?>
