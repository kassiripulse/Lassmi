-- ==========================================
-- KASSIRI PULSE — BASE DE DONNÉES MYSQL
-- Cible : MySQL 8.x + / MariaDB
-- Conçu pour Hostinger Premium et Cloud SQL
-- ==========================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- -------------------------------------------------------------
-- Structure de la table `categories`
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nom` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `couleur` VARCHAR(7) NOT NULL DEFAULT '#D4A017',
  `icone` VARCHAR(50) NOT NULL DEFAULT 'Music'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Structure de la table `artistes`
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `artistes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nom` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(150) NOT NULL UNIQUE,
  `photo` VARCHAR(255) NOT NULL,
  `biographie` TEXT NOT NULL,
  `discipline` VARCHAR(100) NOT NULL,
  `ville` VARCHAR(100) NOT NULL,
  `facebook` VARCHAR(255) DEFAULT NULL,
  `instagram` VARCHAR(255) DEFAULT NULL,
  `youtube` VARCHAR(255) DEFAULT NULL,
  `soundcloud` VARCHAR(255) DEFAULT NULL,
  `site_web` VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Structure de la table `evenements`
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `evenements` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `titre` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `description` TEXT NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `categorie_id` INT NOT NULL,
  `artiste_id` INT DEFAULT NULL,
  `lieu` VARCHAR(255) NOT NULL,
  `ville` VARCHAR(150) NOT NULL,
  `adresse` VARCHAR(255) NOT NULL,
  `latitude` DECIMAL(10, 8) NOT NULL,
  `longitude: DECIMAL` DECIMAL(11, 8) NOT NULL, -- correction syntaxique
  `date_debut` DATETIME NOT NULL,
  `date_fin` DATETIME NOT NULL,
  `prix_normal` INT NOT NULL DEFAULT 0,
  `prix_vip` INT NOT NULL DEFAULT 0,
  `capacite` INT NOT NULL DEFAULT 100,
  `statut` ENUM('actif', 'archive', 'annule') NOT NULL DEFAULT 'actif',
  `vues` INT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`categorie_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`artiste_id`) REFERENCES `artistes`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `evenements` CHANGE `longitude: DECIMAL` `longitude` DECIMAL(11,8);

-- -------------------------------------------------------------
-- Structure de la table `galerie`
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `galerie` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `titre` VARCHAR(150) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `evenement_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`evenement_id`) REFERENCES `evenements`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Structure de la table `billets`
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `billets` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `evenement_id` INT NOT NULL,
  `nom_acheteur` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `telephone` VARCHAR(30) NOT NULL,
  `type_billet` ENUM('normal', 'vip') NOT NULL DEFAULT 'normal',
  `quantite` INT NOT NULL DEFAULT 1,
  `montant_total` INT NOT NULL DEFAULT 0,
  `code_billet` VARCHAR(100) NOT NULL UNIQUE,
  `statut_paiement` ENUM('paye', 'en_attente', 'echoue') NOT NULL DEFAULT 'en_attente',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`evenement_id`) REFERENCES `evenements`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Structure de la table `podcasts`
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `podcasts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `titre` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `description` TEXT NOT NULL,
  `fichier_audio` VARCHAR(255) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `duree` VARCHAR(10) NOT NULL,
  `artiste_id` INT DEFAULT NULL,
  `categorie_id` INT DEFAULT NULL,
  `vues` INT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`artiste_id`) REFERENCES `artistes`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`categorie_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Structure de la table `utilisateurs`
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nom` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(50) NOT NULL DEFAULT 'moderateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Structure de la table `commentaires`
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `commentaires` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `evenement_id` INT NOT NULL,
  `nom` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `contenu` TEXT NOT NULL,
  `note` INT NOT NULL DEFAULT 5,
  `statut` ENUM('approuve', 'suspendu', 'en_attente') NOT NULL DEFAULT 'en_attente',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`evenement_id`) REFERENCES `evenements`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Structure de la table `newsletter`
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `nom` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Structure de la table `contacts`
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nom` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `sujet` VARCHAR(200) NOT NULL,
  `message` TEXT NOT NULL,
  `statut` ENUM('non_lu', 'lu', 'repondu') NOT NULL DEFAULT 'non_lu',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================
-- INSERTION DES DONNÉES INITIALES BURKINABÈ
-- =============================================================

-- Catégories
INSERT INTO `categories` (`id`, `nom`, `slug`, `couleur`, `icone`) VALUES
(1, 'Musique', 'musique', '#C0392B', 'Music'),
(2, 'Danse', 'danse', '#1A6B3C', 'Flame'),
(3, 'Arts plastiques', 'arts-plastiques', '#D4A017', 'Palette'),
(4, 'Cinéma', 'cinema', '#1A1A1A', 'Film'),
(5, 'Théâtre', 'theatre', '#C0392B', 'Theater'),
(6, 'Festivals', 'festivals', '#D4A017', 'Sparkles');

-- Artistes
INSERT INTO `artistes` (`id`, `nom`, `slug`, `photo`, `biographie`, `discipline`, `ville`, `facebook`, `instagram`, `youtube`, `soundcloud`, `site_web`) VALUES
(1, 'Alif Naaba', 'alif-naaba', 'alif_naaba.jpg', 'Surnommé \"Le Prince aux pieds nus\", Alif Naaba est un auteur-compositeur-interprète incontournable. Sa voix chaude et ses mélodies mêlent afro-pop, jazz et musique traditionnelle moaga.', 'Musique (Afro-Fusion / Folk)', 'Ouagadougou', 'facebook.com/alifnaaba', 'instagram.com/alifnaaba', 'youtube.com/alifnaaba', NULL, 'www.alifnaaba.com'),
(2, 'Smarty', 'smarty', 'smarty.jpg', 'Lauréat du Prix Découvertes RFI en 2013, Smarty est un pionnier engagé du rap burkinabè. Son écriture ciselée aborde la poésie sociale et la paix au Sahel.', 'Hip-Hop / Rap', 'Ouagadougou', 'facebook.com/smarty.officiel', NULL, 'youtube.com/smarty', NULL, NULL),
(3, 'Siriki Ky', 'siriki-ky', 'siriki_ky.jpg', 'Artiste plasticien mondialement connu pour avoir initié le symposium de sculpture sur granit de Laongo.', 'Arts Plastiques & Sculpture', 'Laongo', NULL, NULL, NULL, NULL, 'sirikiky.org'),
(4, 'Irène Tassembédo', 'irene-tassembedo', 'irene.jpg', 'Chorégraphe de légende de danse africaine contemporaine, fondatrice de l\'EDIT à Ouagadougou.', 'Danse Contemporaine', 'Ouagadougou', 'facebook.com/edit.tassembedo', NULL, NULL, NULL, NULL),
(5, 'Siriki Coulibaly', 'siriki-coulibaly', 'siriki_couly.jpg', 'Danseur de formation traditionnelle mandingue explorant la liaison entre percussions et écologie sahélienne.', 'Danse Traditionnelle', 'Bobo-Dioulasso', NULL, NULL, NULL, NULL, NULL),
(6, 'Apolline Traoré', 'apolline-traore', 'apolline.jpg', 'Réalisatrice de renommée internationale, récompensée par l\'Étalon de Bronze au FESPACO 2023 pour le film SIRA.', 'Cinéma (Réalisation)', 'Ouagadougou', NULL, 'instagram.com/apolline', NULL, NULL, NULL),
(7, 'Étienne Minoungou', 'etienne-minoungou', 'etienne.jpg', 'Dramaturge majeur et directeur artistique fondateur des Récréâtrales de Ouagadougou.', 'Théâtre', 'Ouagadougou', 'facebook.com/recreatrales', NULL, NULL, NULL, NULL),
(8, 'Floby', 'floby', 'floby.jpg', 'Surnommé \"Le Kirikou d\'Afrique\", il est le roi incontesté de l\'afro-pop et la variété folklorique mandingue.', 'Musique Populaire', 'Koudougou', 'facebook.com/flobyking', NULL, NULL, NULL, NULL);

-- Événements
INSERT INTO `evenements` (`id`, `titre`, `slug`, `description`, `image`, `categorie_id`, `artiste_id`, `lieu`, `ville`, `adresse`, `latitude`, `longitude`, `date_debut`, `date_fin`, `prix_normal`, `prix_vip`, `capacite`, `statut`, `vues`) VALUES
(1, 'SIAO 2026 — Salon International de l\'Artisanat de Ouagadougou', 'siao-2026', 'Le plus grand rassemblement de l\'artisanat africain d\'art et de design contemporain.', 'siao.jpg', 6, 3, 'Parc des Expositions du SIAO', 'Ouagadougou', 'Boulevard France-Afrique, Patte d\'Oie', 12.3392, -1.5034, '2026-10-30 08:00:00', '2026-11-08 22:00:00', 2000, 10000, 95000, 'actif', 2450),
(2, 'FESPACO 2027 — Édition Lancement Faso', 'fespaco-2027', 'Sélections et projections de cinéma de plein air en hommage à l\'histoire africaine.', 'fespaco.jpg', 4, 6, 'Ciné Burkina & Siège du FESPACO', 'Ouagadougou', 'Rue Agostino Neto, Centre-Ville', 12.3712, -1.5199, '2026-12-05 09:00:00', '2026-12-12 23:30:00', 1500, 5000, 15000, 'actif', 3890),
(3, 'Les Récréâtrales 2026 — Scènes de Bougsemtenga', 'recreatrales-2026', 'Résidences théâtrales d\'envergure internationale dans les concessions de Bougsemtenga.', 'recreatrales.jpg', 5, 7, 'Quartier Populaire Bougsemtenga', 'Ouagadougou', 'Rue des Récréâtrales', 12.3821, -1.5302, '2026-10-24 17:00:00', '2026-10-31 23:59:00', 1000, 3000, 8000, 'actif', 1280),
(4, 'Nuits Atypiques de Koudougou 2026', 'nak-2026', 'Une explosion culturelle réunissant musique traditionnelle et artisanat sahélien.', 'nak.jpg', 6, 8, 'Théâtre Populaire de Koudougou', 'Koudougou', 'Quartier Burkina, Secteur 3', 12.2514, -2.3611, '2026-11-25 18:00:00', '2026-11-29 23:59:00', 1000, 5000, 25000, 'actif', 1740),
(5, 'Jazz à Ouaga 2026 — Club du Sahel', 'jazz-ouaga-2026', 'La 34ème édition réunissant jazz occidental et polyrythmie du désert.', 'jazz_ouaga.jpg', 1, 1, 'CENASA', 'Ouagadougou', 'Rue de la Victoire, Koulouba', 12.3698, -1.5164, '2026-06-15 19:30:00', '2026-06-22 23:00:00', 3000, 15000, 2500, 'actif', 1980),
(6, 'Concert Solidaire Smarty : L\'Écho de la Paix', 'smarty-echo-paix', 'Une soirée engagée du rappeur philosophe Smarty pour l\'union nationale.', 'smarty_concert.jpg', 1, 2, 'Maison de la Culture', 'Bobo-Dioulasso', 'Boulevard Châlons-en-Champagne', 11.1685, -4.2798, '2026-06-28 20:00:00', '2026-06-28 23:30:00', 2000, 5000, 3500, 'actif', 1610),
(7, 'FIDO 2027 — Danse de Ouagadougou', 'fido-2027', 'FIDO rassemble des compagnies d\'expression spirituelle et contemporaine.', 'fido.jpg', 2, 4, 'CDC La Termitière', 'Ouagadougou', 'Quartier Samandin', 12.3587, -1.5289, '2026-11-12 19:00:00', '2026-11-19 22:30:00', 1000, 3000, 1200, 'actif', 840),
(8, 'Siriki Ky — Exposition \"Mémoire de Granit\"', 'siriki-ky-exposition', 'Exposition exclusive regroupant les bronzes originaux façonnés par Siriki Ky.', 'siriki_expo.jpg', 3, 3, 'Institut Français', 'Ouagadougou', 'Avenue de la Nation', 12.3725, -1.5173, '2026-07-02 10:00:00', '2026-07-31 18:00:00', 500, 2000, 500, 'actif', 920),
(9, 'Transe-Écologie Mandingue — Banfora', 'transe-ecologie', 'Dialogue de danse classique mandingue et percussions face aux défis écologiques.', 'transe.jpg', 2, 5, 'Espace Culturel des Cascades', 'Banfora', 'Secteur 2, Route des Cascades', 10.6402, -4.7589, '2026-08-14 19:00:00', '2026-08-16 22:00:00', 1000, 2500, 1500, 'actif', 670),
(10, 'L\'Étoile Noire du CITO : \"L\'Exil de Soundjata\"', 'exil-soundjata', 'Interprétation théâtrale de Soundjata Keïta portée par Étienne Minoungou.', 'cito_exil.jpg', 5, 7, 'CITO', 'Ouagadougou', 'Quartier Samandin, Secteur 14', 12.3551, -1.5273, '2026-09-10 20:00:00', '2026-09-25 22:30:00', 1500, 4000, 600, 'actif', 1020),
(11, 'SIRA — Projection Spéciale Apolline Traoré', 'sira-projection', 'Projection exclusive de Sira suivie d\'une conférence sur les luttes féminines.', 'sira_proj.jpg', 4, 6, 'Ciné Neerwaya', 'Ouagadougou', 'Avenue de la Liberté, Paspanga', 12.3815, -1.5152, '2026-07-15 19:00:00', '2026-07-15 22:30:00', 1000, 3000, 1500, 'actif', 3120),
(12, 'Le Grand Kundé d\'Or Floby à Koudougou', 'floby-koudougou', 'Le Roi de la variété populaire fait vibrer sa communauté mossi d\'origine.', 'floby_concert.jpg', 1, 8, 'Place de la Nation', 'Koudougou', 'Secteur 1, Centre-Ville', 12.2498, -2.3598, '2026-06-10 19:00:00', '2026-06-11 02:00:00', 1000, 5000, 12000, 'actif', 2150),
(13, 'FESTIMA 2026 — Dédougou Les Masques', 'festima-2026', 'Danse des masques traditionnels de l\'ASAMA : plumes, fibres et bois sculpté.', 'festima.jpg', 6, 3, 'Grande Arène Municipale', 'Dédougou', 'Route de Bobo, Secteur 4', 12.4632, -3.4611, '2026-11-01 08:00:00', '2026-11-07 22:00:00', 500, 2000, 45000, 'actif', 1540),
(14, 'Garba Faso Fest — Édition Bobo', 'garba-faso-bobo', 'Prestations de rap et célébrations dégustatives culinaires de manioc et de thon.', 'garba_fest.jpg', 6, 8, 'Stade Wobi de Bobo-Dioulasso', 'Bobo-Dioulasso', 'Avenue de la République', 11.1712, -4.3005, '2026-09-04 12:00:00', '2026-09-06 23:30:00', 1000, 3000, 15000, 'actif', 1250),
(15, 'Nuit Chorégraphique de Kaya — Souffle du Sahel', 'nuit-kaya', 'Chant de solidarité patriotique liant artistes résidents et déplacés.', 'kaya_nuit.jpg', 2, 4, 'Place de la Nation de Kaya', 'Kaya', 'Secteur 2, Centre-Ville', 13.0905, -1.0841, '2026-07-24 18:30:00', '2026-07-25 00:00:00', 500, 2000, 4000, 'actif', 780);

-- Galerie d\'images
INSERT INTO `galerie` (`id`, `titre`, `image`, `evenement_id`) VALUES
(1, 'SIAO Stand d\'Exposition Artisanat de Bronze', 'bronze.jpg', 1),
(2, 'Exposants de Bogolan Fin d\'Afrique', 'bogolan.jpg', 1),
(3, 'Tapis Rouge FESPACO Foule', 'fespaco_foule.jpg', 2),
(4, 'Scène de théâtre en plein air à Bougsemtenga', 'theatre_bougs.jpg', 3),
(5, 'Spectateurs réunis aux Nuits Atypiques', 'spectateurs_kdg.jpg', 4),
(6, 'Siriki Ky sculptant le Granit', 'granit_laongo.jpg', 8);

-- Billet vendus (20 billets)
INSERT INTO `billets` (`id`, `evenement_id`, `nom_acheteur`, `email`, `telephone`, `type_billet`, `quantite`, `montant_total`, `code_billet`, `statut_paiement`) VALUES
(1, 1, 'Abdoulaye Traoré', 'abdoul@gmail.com', '+22670111213', 'normal', 2, 4000, 'BIL-SIAO-2026-A1X98', 'paye'),
(2, 1, 'Fatoumata Ouédraogo', 'fatou@outlook.com', '+22676451234', 'vip', 1, 10000, 'BIL-SIAO-2026-VIP7', 'paye'),
(3, 2, 'Jean-Baptiste Sawadogo', 'jb.sawa@gmail.com', '+22660142536', 'normal', 3, 4500, 'BIL-FES-2027-H29P3', 'paye'),
(4, 3, 'Mariam Diallo', 'mariam@univ-ouaga.bf', '+22678964412', 'normal', 1, 1000, 'BIL-REC-2026-N29D1', 'paye'),
(5, 5, 'Marc Dubois', 'm.dubois@ambassade-fr.org', '+22670258525', 'vip', 2, 30000, 'BIL-JAZ-2026-VIP1A', 'paye'),
(6, 6, 'Pascal Kaboré', 'pascal@gmail.com', '+22670562312', 'normal', 2, 4000, 'BIL-SMY-002', 'paye'),
(7, 6, 'Fatima Sidibé', 'fatima@hotmail.fr', '+22666144556', 'vip', 1, 5000, 'BIL-SMY-003', 'paye'),
(8, 12, 'Adama Compaoré', 'adama@gmail.com', '+22671029342', 'normal', 4, 4000, 'BIL-FLB-2342', 'paye'),
(9, 12, 'Pierre Zoungrana', 'pierre@zoung.bf', '+22678123456', 'normal', 2, 2000, 'BIL-FLB-5346', 'paye'),
(10, 4, 'Sylvie Bonkoungou', 'sylvie@gmail.com', '+22675667788', 'vip', 2, 10000, 'BIL-NAK-9831', 'paye'),
(11, 4, 'Ousmane Barry', 'ousmane@barry.bf', '+22670334455', 'normal', 5, 5000, 'BIL-NAK-1112', 'paye'),
(12, 11, 'Issaka Sogodogo', 'issaka@sogo.net', '+22661559988', 'normal', 2, 2000, 'BIL-SIRA-4144', 'paye'),
(13, 11, 'Chantal Zongo', 'chantal@live.com', '+22674251212', 'vip', 1, 3000, 'BIL-SIRA-5512', 'paye'),
(14, 8, 'Emile Coulibaly', 'emile@bobo.bf', '+22670112233', 'normal', 1, 500, 'BIL-SK-5567', 'paye'),
(15, 8, 'Delphine Somé', 'delph@gmail.com', '+22665123456', 'normal', 2, 1000, 'BIL-SK-3431', 'paye'),
(16, 9, 'Karim Sanogo', 'karim@sanogo.info', '+22671009988', 'normal', 3, 3000, 'BIL-TRNS-12', 'paye'),
(17, 10, 'Gisèle Yoda', 'gisele@yoda.bf', '+22676001234', 'normal', 2, 3000, 'BIL-CITO-092', 'paye'),
(18, 13, 'Amadou Dicko', 'dicko@gmail.com', '+22670550011', 'normal', 10, 5000, 'BIL-FESTMAX', 'paye'),
(19, 14, 'Alain Soura', 'alain@soura.bf', '+22678229900', 'normal', 1, 1000, 'BIL-GARBA-01', 'paye'),
(20, 15, 'Sita Guinko', 'sita@yahoo.fr', '+22670554433', 'vip', 2, 4000, 'BIL-KAYA-SH', 'paye');

-- Podcasts
INSERT INTO `podcasts` (`id`, `titre`, `slug`, `description`, `fichier_audio`, `image`, `duree`, `artiste_id`, `categorie_id`, `vues`) VALUES
(1, 'Alif Naaba : \"L\'Écho de notre résilience moderne\"', 'alif-naaba-podcast', 'Discussion exclusive sur la mission éthique du chanteur moderne.', 'alif_audio.mp3', 'alif_pod.jpg', '14:25', 1, 1, 340),
(2, 'Aux origines de Laongo : Siriki Ky', 'siriki-ky-podcast', 'Les secrets de la taille du granit dans le désert burkinabè.', 'siriki_audio.mp3', 'siriki_pod.jpg', '22:10', 3, 3, 215),
(3, 'Smarty : \"Rimes percutantes et poésie sociale\"', 'smarty-podcast', 'Décryptage poétique de ses plus belles odes à la paix.', 'smarty_audio.mp3', 'smarty_pod.jpg', '18:50', 2, 1, 490),
(4, 'Apolline Traoré : Le Cri des Femmes de Sira', 'apolline-podcast', 'Analyse féministe du combat féminin sahélien face à la terreur.', 'apolline_audio.mp3', 'apolline_pod.jpg', '25:40', 6, 4, 512),
(5, 'Récréâtrales : Le Théâtre comme catharsis populaire', 'etienne-podcast', 'Entretiens avec Étienne Minoungou sur l\'amour des cours de concessions.', 'etienne_audio.mp3', 'etienne_pod.jpg', '16:05', 7, 5, 165);

-- Utilisateurs (Mot de passe haché par défaut = "admin123" -> $2y$10$S9zEq9h10Vb46MREeHqgOOHO4o9oK4Yp1r4A84p7nC1xY1I9lB8U2)
INSERT INTO `utilisateurs` (`id`, `nom`, `email`, `password`, `role`) VALUES
(1, 'Kassiri Admin', 'admin@kassiripulse.bf', '$2y$10$O03rU7qGz.Fp26d2Ue62IuN9V7Tq2CqF69t37tN9U9C3C2I9lB8U2', 'superadmin');

-- Commentaires
INSERT INTO `commentaires` (`id`, `evenement_id`, `nom`, `email`, `contenu`, `note`, `statut`) VALUES
(1, 1, 'Seydou Ouattara', 'seydou.ouat@live.fr', 'Le SIAO est vraiment le fleuron de l\'artisanat africain !', 5, 'approuve'),
(2, 1, 'Claire Boulanger', 'claire.b@yahoo.fr', 'Des artisans talentueux. Chaud sous les halls mais fabuleux !', 4, 'approuve'),
(3, 5, 'Salif Sanfo', 'salif@cultural.bf', 'Le concert d\'Alif Naaba au CENASA était fantastique !', 5, 'approuve'),
(4, 6, 'Inoussa Kaboré', 'inou@gmail.com', 'Smarty fidèle à lui-même. Des textes très percutants.', 5, 'approuve'),
(5, 11, 'Rasmata Traoré', 'rasou@univ-ouaga.bf', 'Sira est un chef-d\'œuvre bouleversant d\'humanité.', 5, 'approuve');

COMMIT;
