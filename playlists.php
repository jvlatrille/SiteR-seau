<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Playlists</title>
</head>

<body>

    <?php
    include 'config.php';
    try {
        // Vérification de la présence d'un ID utilisateur
        if (!isset($_POST['id']) || empty($_POST['id'])) {
            throw new Exception('Aucun utilisateur spécifié.');
        }

        // Requête SQL pour récupérer les playlists de l'utilisateur
        $stmt = $bdd->prepare('
            SELECT P.idPlaylist, P.titre, P.dateCreation, COUNT(C.idMusique) AS nbMusiques
            FROM Playlist P
            LEFT JOIN Contenir C ON C.idPlaylist = P.idPlaylist
            WHERE P.idUtilisateur = ?
            GROUP BY P.idPlaylist
        ');
        $stmt->execute([$_POST['id']]);
        $playlists = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Affichage des playlists
        echo '<h1>Playlists</h1>';

        echo '<ul>';
        echo '<li><strong>Id - Titre - Date de Création - Nb de Musiques</strong></li>';
        foreach ($playlists as $playlist) {
            echo '<li>';
            echo '<form action="musiques.php" method="post">';
            echo '<input type="hidden" name="id" value="' . htmlspecialchars($playlist['idPlaylist']) . '">';
            echo '<button type="submit">'
                . htmlspecialchars($playlist['idPlaylist']) . " - "
                . htmlspecialchars($playlist['titre']) . " - "
                . htmlspecialchars($playlist['dateCreation']) . " - "
                . htmlspecialchars($playlist['nbMusiques']) .
                '</button>';
            echo '</form>';
            echo '</li>';
        }
        echo '</ul>';
    } catch (PDOException $e) {
        echo '<p>Erreur : ' . htmlspecialchars($e->getMessage()) . '</p>';
    } catch (Exception $e) {
        echo '<p>Erreur : ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
    ?>

    <br>
    <form action="index.php" method="post">
        <button type="submit">Retour</button>
    </form>

</body>

</html>