<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Utilisateurs</title>
</head>

<body>

    <?php
    include 'config.php';
    try {
        // Requête SQL pour récupérer les utilisateurs et le nombre de playlists
        $users = $bdd->query('
            SELECT U.idUtilisateur, U.nom, U.email, COUNT(P.idPlaylist) AS nbPlaylists
            FROM Utilisateur U
            LEFT JOIN Playlist P ON U.idUtilisateur = P.idUtilisateur
            GROUP BY U.idUtilisateur
        ')->fetchAll(PDO::FETCH_ASSOC);

        // Affichage des utilisateurs
        echo '<h1>Utilisateurs</h1>';

        echo '<ul>';
        echo '<li><strong>Id - Nom - Email - Nb de Playlists</strong></li>';
        foreach ($users as $user) {
            echo '<li>';
            echo '<form action="playlists.php" method="post">';
            echo '<input type="hidden" name="id" value="' . htmlspecialchars($user['idUtilisateur']) . '">';
            echo '<button type="submit">'
                . htmlspecialchars($user['idUtilisateur']) . " - "
                . htmlspecialchars($user['nom']) . " - "
                . htmlspecialchars($user['email']) . " - "
                . htmlspecialchars($user['nbPlaylists']) .
                '</button>';
            echo '</form>';
            echo '</li>';
        }
        echo '</ul>';
    } catch (PDOException $e) {
        echo '<p>Erreur : ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
    ?>

</body>

</html>