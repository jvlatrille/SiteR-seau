-- Table Utilisateur
CREATE TABLE IF NOT EXISTS Utilisateur (
   idUtilisateur VARCHAR(50),
   nom VARCHAR(50),
   email VARCHAR(50),
   PRIMARY KEY(idUtilisateur)
);

-- Table Playlist
CREATE TABLE IF NOT EXISTS Playlist (
   idPlaylist VARCHAR(50),
   titre VARCHAR(50),
   dateCreation DATE,
   idUtilisateur VARCHAR(50) NOT NULL,
   PRIMARY KEY(idPlaylist),
   FOREIGN KEY(idUtilisateur) REFERENCES Utilisateur(idUtilisateur)
);

-- Table Musique
CREATE TABLE IF NOT EXISTS Musique (
   idMusique VARCHAR(50),
   titre VARCHAR(50),
   artiste VARCHAR(50),
   lien VARCHAR(50),
   PRIMARY KEY(idMusique)
);

-- Table Contenir (relation entre Playlist et Musique)
CREATE TABLE IF NOT EXISTS Contenir (
   idPlaylist VARCHAR(50),
   idMusique VARCHAR(50),
   PRIMARY KEY(idPlaylist, idMusique),
   FOREIGN KEY(idPlaylist) REFERENCES Playlist(idPlaylist),
   FOREIGN KEY(idMusique) REFERENCES Musique(idMusique)
);

-- Insertion de données d'exemple dans la table Utilisateur
INSERT INTO Utilisateur (idUtilisateur, nom, email) VALUES
('U1', 'Alice', 'alice@example.com'),
('U2', 'Bob', 'bob@example.com'),
('U3', 'Charlie', 'charlie@example.com');

-- Insertion de données d'exemple dans la table Playlist
INSERT INTO Playlist (idPlaylist, titre, dateCreation, idUtilisateur) VALUES
('P1', 'Rock Classics', '2024-01-15', 'U1'),
('P2', 'Chill Vibes', '2024-02-20', 'U2'),
('P3', 'Workout Hits', '2024-03-10', 'U3');

-- Insertion de données d'exemple dans la table Musique
INSERT INTO Musique (idMusique, titre, artiste, lien) VALUES
('M1', 'Bohemian Rhapsody', 'Queen', 'https://example.com/bohemian_rhapsody'),
('M2', 'Shape of You', 'Ed Sheeran', 'https://example.com/shape_of_you'),
('M3', 'Eye of the Tiger', 'Survivor', 'https://example.com/eye_of_the_tiger');

-- Insertion de données d'exemple dans la table Contenir
INSERT INTO Contenir (idPlaylist, idMusique) VALUES
('P1', 'M1'), -- Rock Classics contient Bohemian Rhapsody
('P2', 'M2'), -- Chill Vibes contient Shape of You
('P3', 'M3'), -- Workout Hits contient Eye of the Tiger
('P1', 'M3'); -- Rock Classics contient aussi Eye of the Tiger
