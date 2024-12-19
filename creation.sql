-- Suppression des tables existantes pour éviter les conflits
DROP TABLE IF EXISTS Contenir;
DROP TABLE IF EXISTS Musique;
DROP TABLE IF EXISTS Playlist;
DROP TABLE IF EXISTS Utilisateur;

-- Création de la table Utilisateur
CREATE TABLE IF NOT EXISTS Utilisateur (
   idUtilisateur VARCHAR(50),
   nom VARCHAR(50),
   email VARCHAR(50),
   PRIMARY KEY(idUtilisateur)
);

-- Création de la table Playlist
CREATE TABLE IF NOT EXISTS Playlist (
   idPlaylist VARCHAR(50),
   titre VARCHAR(50),
   dateCreation DATE,
   idUtilisateur VARCHAR(50) NOT NULL,
   PRIMARY KEY(idPlaylist),
   FOREIGN KEY(idUtilisateur) REFERENCES Utilisateur(idUtilisateur)
);

-- Création de la table Musique
CREATE TABLE IF NOT EXISTS Musique (
   idMusique VARCHAR(50),
   titre VARCHAR(50),
   artiste VARCHAR(50),
   lien VARCHAR(50),
   PRIMARY KEY(idMusique)
);

-- Création de la table Contenir (relation entre Playlist et Musique)
CREATE TABLE IF NOT EXISTS Contenir (
   idPlaylist VARCHAR(50),
   idMusique VARCHAR(50),
   PRIMARY KEY(idPlaylist, idMusique),
   FOREIGN KEY(idPlaylist) REFERENCES Playlist(idPlaylist),
   FOREIGN KEY(idMusique) REFERENCES Musique(idMusique)
);

-- Insertion des données utilisateur 
INSERT INTO Utilisateur (idUtilisateur, nom, email) VALUES
('U4', 'Jules', 'jvlatrille@iutbayonne.univ-pau.fr'),
('U5', 'Thibault', 'tchipy@iutbayonne.univ-pau.fr'),
('U6', 'Nathan', 'namrein@iutbayonne.univ-pau.fr');

-- Insertion des playlists
INSERT INTO Playlist (idPlaylist, titre, dateCreation, idUtilisateur) VALUES
-- Jules
('P4', 'Coup de Coeurs', '2024-11-01', 'U4'),
('P5', 'Drive', '2024-11-02', 'U4'),
-- Thibault
('P6', 'Coup de Coeur', '2024-11-10', 'U5'),
('P7', 'EH', '2024-11-10', 'U5'),
-- Nathan
('P8', 'Coup de Coeur', '2024-11-10', 'U6'),
('P9', "N'importe quoi", '2024-11-10', 'U6');


-- Insertion des musiques dans la table Musique
INSERT INTO Musique (idMusique, titre, artiste, lien) VALUES
-- Playlist Coup de Coeurs de Jules
('M10', 'ОТДАЙ', 'MIFEST, Leytink', 'https://youtu.be/0g206u5Iaf8?si=qc28qpKlSNndoCt6'),
('M11', 'untouched', 'Jerry Diane', 'https://open.spotify.com/intl-fr/track/0gCktbMM6YJ9EHa06Y6Uh8?si=91ddbd58a0524ed0'),
('M12', 'Magic Melody', 'ALTRAX', 'https://youtu.be/JFLLc7g_Yk8?si=3nxbAx8tmsWoBwkz'),
('M13', 'SLAVA FUNK!', 'MVSTERIOUS, Hxmr, yngastrobeatz', 'https://youtu.be/w_VQJBWvJcI?si=3CNMMgTS6QvxpDGK'),
('M14', 'All the Things She Said - Noiseflow Remix', 'DJ Gollum, Noiseflow, Triple X, Scarlet', 'https://youtu.be/jit-8fZGJNg?si=8DYyHbFHRNF2BJe9'),
('M15', 'Shut Up and Dance', 'WALK THE MOON', 'https://youtu.be/6JCLY0Rlx6Q?si=uQaJmAg-Eo1OJJ2T'),
('M16', '300', 'lagoyo', 'https://youtu.be/VGwtXoeo7II?si=8Rc_WFPanopCrhNt'),
-- Playlist Drive de Jules
('M24', 'Tsunami', 'DVBBS, Borgeous', 'https://youtu.be/0EWbonj7f18?si=ortFk3qefriSXvpr'),
('M25', 'Happy Pills', 'Weathers', 'https://youtu.be/mFxq7Mb96b0?si=TAOHOfL-8DNpQBmA'),
('M26', 'Monster', 'Luxxious', 'https://youtu.be/gX2rR9gy-mM?si=OoikgK5uGM2QHSPK'),
('M27', 'Saxobeat', 'Bread Beatz, Newmagick', 'https://youtu.be/yMSvhsd8NzI?si=vSQOfpmCXyii6V22'),
('M28', 'Controlla - Lieless Remix', 'Yarimov, Lieless', 'https://youtu.be/Jrterm8Yx9s?si=-HeKrVoIotKG8Wkr'),
('M29', 'BANGARANG', 'KILLEDDY', 'https://youtu.be/KK5wKJEs5x0?si=kTwKxgoNigxPoV5m'),
('M30', 'FIGHT!', 'xxephyrr, TWISTED', 'https://youtu.be/LUWmJ_6QsWs?si=s7KijgGO56w-dKdq'),
--Playlist Coup de Coeur de Thibault
('M31', 'Les sardines', 'Patrick Sébastien', 'https://www.youtube.com/watch?v=PA3P1-aSvKQ'),
('M32', 'Under the bridge', 'Red Hot Chili Peppers', 'https://www.youtube.com/watch?v=GLvohMXgcBo'),
('M33', 'Comfortably Nump', 'Pink Floyd', 'https://open.spotify.com/intl-fr/track/7Fg4jpwpkdkGCvq1rrXnvx?si=f53928b1de914107'),
-- Playlist EH de Thibault
('M34', 'Lokaleko Leihotik', 'Sully Riot', 'https://www.youtube.com/watch?v=bEZOO1a4luI'),
('M35', 'Haizea', 'Ken Zazpi', 'https://www.youtube.com/watch?v=DmNrapVHNRY'),
('M36', 'Hotzikara', 'Ken Zazpi', 'https://www.youtube.com/watch?v=OQsN1dWYSjY'),
-- Playlist Coup de Coeur de Nathan
('M37', 'Le portrait', 'Calogero', 'https://www.youtube.com/watch?v=eyEDej0aGh8'),
('M38', 'Life is a hightway', 'Cars', 'https://www.youtube.com/watch?v=5tXh_MfrMe0'),
('M39', 'Life could be a dream', 'Cars', 'https://www.youtube.com/watch?v=n-miJQUD9l4'),
-- Playlist N'importeQuoi de Nathan
('M40', 'We are', 'One Piece', 'https://www.youtube.com/watch?v=oK0ULo01cYs'),
('M41', 'Les yeux de la mama', 'Kendji Girac', 'https://www.youtube.com/watch?v=YgP2whwA2Wg'),
('M42', 'Top 1', 'Squeezie', 'https://www.youtube.com/watch?v=uGSu6mhk3RQ'),
-- Musiques par défaut
('M43', 'Titre1', 'Artiste1', 'https://example.com/titre1'),
('M44', 'Titre2', 'Artiste2', 'https://example.com/titre2'),
('M45', 'Titre3', 'Artiste3', 'https://example.com/titre3');



-- Liaison des musiques
INSERT INTO Contenir (idPlaylist, idMusique) VALUES
-- Liens entre les musiques Coups de Coeurs Jules et la playlist
('P4', 'M10'),
('P4', 'M11'),
('P4', 'M12'),
('P4', 'M13'),
('P4', 'M14'),
('P4', 'M15'),
('P4', 'M16'),
-- Liens entre les musiques Drive Jules et la playlist
('P5', 'M24'),
('P5', 'M25'),
('P5', 'M26'),
('P5', 'M27'),
('P5', 'M28'),
('P5', 'M29'),
('P5', 'M30'),
-- Musiques pour la playlist "Coup de Coeur" de Thibault
('P6', 'M31'),
('P6', 'M32'),
('P6', 'M33'),
-- Musiques pour la playlist "Nom Playlist" de Thibault
('P7', 'M31'),
('P7', 'M32'),
('P7', 'M33'),
-- Musiques pour la playlist "Coup de Coeur" de Nathan
('P8', 'M37'),
('P8', 'M38'),
('P8', 'M39'),
-- Musiques pour la playlist "Nom Playlist" de Nathan
('P9', 'M40'),
('P9', 'M41'),
('P9', 'M42'),
