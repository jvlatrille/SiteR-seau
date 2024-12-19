<?php
// Inclure la configuration pour se connecter à la base
include 'config.php';

// Récupérer tous les utilisateurs pour les afficher dans la liste déroulante
$requete_utilisateurs = $bdd->query("SELECT idUtilisateur, nom FROM Utilisateur");
$utilisateurs = $requete_utilisateurs->fetchAll(PDO::FETCH_ASSOC);

// Définir les variables pour les sélections
$idUtilisateur = $_POST['idUtilisateur'] ?? null;
$idPlaylist = $_POST['idPlaylist'] ?? null;

// Récupérer les playlists associées à l'utilisateur sélectionné
$playlists = [];
if ($idUtilisateur) {
    $requete_playlists = $bdd->prepare("SELECT * FROM Playlist WHERE idUtilisateur = ?");
    $requete_playlists->execute([$idUtilisateur]);
    $playlists = $requete_playlists->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer les musiques associées à la playlist sélectionnée
$musiques = [];
if ($idPlaylist) {
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

    <!-- Sélection de l'utilisateur -->
    <form method="POST" action="index.php">
        <label for="idUtilisateur">Sélectionnez un utilisateur :</label>
        <select name="idUtilisateur" id="idUtilisateur">
            <option value="">Choisir...</option>
            <?php foreach ($utilisateurs as $utilisateur): ?>
                <option value="<?= $utilisateur['idUtilisateur'] ?>" <?= ($idUtilisateur == $utilisateur['idUtilisateur']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($utilisateur['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Valider</button>
    </form>

    <!-- Sélection de la playlist -->
    <?php if (!empty($idUtilisateur)): ?>
        <h2>Playlists de <?= htmlspecialchars($utilisateurs[array_search($idUtilisateur, array_column($utilisateurs, 'idUtilisateur'))]['nom']) ?></h2>
        <form method="POST" action="index.php">
            <input type="hidden" name="idUtilisateur" value="<?= $idUtilisateur ?>">
            <label for="idPlaylist">Sélectionnez une playlist :</label>
            <select name="idPlaylist" id="idPlaylist">
                <option value="">Choisir...</option>
                <?php foreach ($playlists as $playlist): ?>
                    <option value="<?= $playlist['idPlaylist'] ?>" <?= ($idPlaylist == $playlist['idPlaylist']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($playlist['titre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Valider</button>
        </form>
    <?php endif; ?>

    <!-- Tableau avec la liste des musiques -->
    <?php if (!empty($idPlaylist)): ?>
        <h2>Musiques dans la Playlist</h2>
        <table class="playlist-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Titre</th>
                    <th>Artiste</th>
                    <th>Écouter</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($musiques as $index => $musique): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><strong><?= htmlspecialchars($musique['titre']) ?></strong></td>
                        <td><?= htmlspecialchars($musique['artiste']) ?></td>
                        <td><a href="<?= htmlspecialchars($musique['lien']) ?>" target="_blank">Écouter</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
