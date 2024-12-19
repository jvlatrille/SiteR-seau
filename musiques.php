<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Musiques</title>
</head>

<body>

    <?php
    include 'config.php';
    try {
        // Vérification de la présence d'un ID playlist
        if (!isset($_POST['id']) || empty($_POST['id'])) {
            throw new Exception('Aucune playlist spécifiée.');
        }

        // Requête SQL pour récupérer les musiques de la playlist
        $stmt = $bdd->prepare('
            SELECT M.idMusique, M.titre, M.artiste, M.lien
            FROM Musique M
            JOIN Contenir C ON M.idMusique = C.idMusique
            WHERE C.idPlaylist = ?
        ');
        $stmt->execute([$_POST['id']]);
        $musiques = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Affichage des musiques
        echo '<h1>Musiques</h1>';

        if (count($musiques) === 0) {
            echo '<p>Aucune musique trouvée pour cette playlist.</p>';
        } else {
            echo '<ul>';
            echo '<li><strong>Id - Titre - Artiste</strong></li>';
            foreach ($musiques as $musique) {
                echo '<li>';
                echo htmlspecialchars($musique['idMusique']) . ' - '
                    . htmlspecialchars($musique['titre']) . ' - '
                    . htmlspecialchars($musique['artiste']);
                echo ' - <a href="' . htmlspecialchars($musique['lien']) . '" target="_blank">Écouter</a>';
                echo '</li>';
            }
            echo '</ul>';
        }
    } catch (PDOException $e) {
        echo '<p>Erreur : ' . htmlspecialchars($e->getMessage()) . '</p>';
    } catch (Exception $e) {
        echo '<p>Erreur : ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
    ?>

    <br>
    <form action="playlists.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_POST['id']); ?>">
        <button type="submit">Retour</button>
    </form>

</body>

</html>