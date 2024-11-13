<?php
// Inclure la configuration pour se connecter à la base
include 'config.php';

// Récupérer tous les utilisateurs pour les afficher dans la liste déroulante
$requete_utilisateurs = $bdd->query("SELECT idUtilisateur, nom FROM Utilisateur");
$utilisateurs = $requete_utilisateurs->fetchAll(PDO::FETCH_ASSOC);

// Si un utilisateur est sélectionné, récupérer sa playlist
$playlists = [];
if (isset($_POST['idUtilisateur'])) {
    $idUtilisateur = $_POST['idUtilisateur'];
    $requete_playlists = $bdd->prepare("SELECT * FROM Playlist WHERE idUtilisateur = ?");
    $requete_playlists->execute([$idUtilisateur]);
    $playlists = $requete_playlists->fetchAll(PDO::FETCH_ASSOC);
}

// Si une playlist est sélectionnée, récupérer les musiques associées
$musiques = [];
if (isset($_POST['idPlaylist'])) {
    $idPlaylist = $_POST['idPlaylist'];
    $requete_musiques = $bdd->prepare("
        SELECT Musique.titre, Musique.artiste, Musique.lien 
        FROM Musique
        INNER JOIN Contenir ON Musique.idMusique = Contenir.idMusique
        WHERE Contenir.idPlaylist = ?
    ");
    $requete_musiques->execute([$idPlaylist]);
    $musiques = $requete_musiques->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Playlist Utilisateur</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <h1>Voir la Playlist d'un Utilisateur</h1>

    <!-- Formulaire de sélection de l'utilisateur -->
    <form method="POST" action="index.php">
        <label for="idUtilisateur">Sélectionnez un utilisateur :</label>
        <select name="idUtilisateur" id="idUtilisateur" onchange="this.form.submit()">
            <option value="">Choisir...</option>
            <?php foreach ($utilisateurs as $utilisateur): ?>
                <option value="<?= $utilisateur['idUtilisateur'] ?>" <?= isset($idUtilisateur) && $idUtilisateur == $utilisateur['idUtilisateur'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($utilisateur['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if (!empty($playlists)): ?>
        <h2>Playlists de <?= htmlspecialchars($utilisateurs[array_search($idUtilisateur, array_column($utilisateurs, 'idUtilisateur'))]['nom']) ?></h2>
        <form method="POST" action="index.php">
            <input type="hidden" name="idUtilisateur" value="<?= $idUtilisateur ?>">
            <label for="idPlaylist">Sélectionnez une playlist :</label>
            <select name="idPlaylist" id="idPlaylist" onchange="this.form.submit()">
                <option value="">Choisir...</option>
                <?php foreach ($playlists as $playlist): ?>
                    <option value="<?= $playlist['idPlaylist'] ?>" <?= isset($idPlaylist) && $idPlaylist == $playlist['idPlaylist'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($playlist['titre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    <?php endif; ?>

    <?php if (!empty($musiques)): ?>
        <h2>Musiques dans la Playlist</h2>
        <ul>
            <?php foreach ($musiques as $musique): ?>
                <li>
                    <strong><?= htmlspecialchars($musique['titre']) ?></strong> - <?= htmlspecialchars($musique['artiste']) ?>
                    <a href="<?= htmlspecialchars($musique['lien']) ?>" target="_blank">Écouter</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>

</html>