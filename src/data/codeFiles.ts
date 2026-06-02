/**
 * KASSIRI PULSE - REPRÉSENTATION DU CODE PHP/SQL EXPORTABLE POUR LE CODE DRAWER
 * Fichier : src/data/codeFiles.ts
 */

export interface CodeFile {
  name: string;
  path: string;
  type: 'php' | 'sql' | 'css' | 'htaccess';
  content: string;
}

export const codeFiles: CodeFile[] = [
  {
    name: "Base de Données SQL",
    path: "kassiri_pulse.sql",
    type: "sql",
    content: `-- ====================================================================
-- KASSIRI PULSE - STRUCTURE DE BASE DE DONNÉES MYSQL
-- ====================================================================
CREATE DATABASE IF NOT EXISTS \`kassiri_pulse_db\` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE \`kassiri_pulse_db\`;

-- 1. Table des Catégories / Disciplines
CREATE TABLE IF NOT EXISTS \`categories\` (
  \`id\` INT AUTO_INCREMENT PRIMARY KEY,
  \`nom\` VARCHAR(100) NOT NULL UNIQUE,
  \`slug\` VARCHAR(100) NOT NULL UNIQUE,
  \`couleur\` VARCHAR(20) DEFAULT '#C0392B',
  \`icone\` VARCHAR(50) DEFAULT 'Music'
) ENGINE=InnoDB;

-- 2. Table des Artistes
CREATE TABLE IF NOT EXISTS \`artistes\` (
  \`id\` INT AUTO_INCREMENT PRIMARY KEY,
  \`nom\` VARCHAR(150) NOT NULL,
  \`slug\` VARCHAR(150) NOT NULL UNIQUE,
  \`photo\` VARCHAR(255) DEFAULT NULL,
  \`biographie\` TEXT,
  \`discipline\` VARCHAR(100) DEFAULT NULL,
  \`ville\` VARCHAR(100) DEFAULT NULL,
  \`facebook\` VARCHAR(255) DEFAULT NULL,
  \`instagram\` VARCHAR(255) DEFAULT NULL,
  \`youtube\` VARCHAR(255) DEFAULT NULL,
  \`site_web\` VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB;

-- 3. Table des Événements
CREATE TABLE IF NOT EXISTS \`evenements\` (
  \`id\` INT AUTO_INCREMENT PRIMARY KEY,
  \`titre\` VARCHAR(200) NOT NULL,
  \`slug\` VARCHAR(200) NOT NULL UNIQUE,
  \`description\` TEXT,
  \`image\` VARCHAR(255) DEFAULT NULL,
  \`lieu\` VARCHAR(150) NOT NULL,
  \`ville\` VARCHAR(100) NOT NULL,
  \`adresse\` VARCHAR(255) DEFAULT NULL,
  \`latitude\` DECIMAL(10, 8) DEFAULT NULL,
  \`longitude\` DECIMAL(11, 8) DEFAULT NULL,
  \`date_debut\` DATETIME NOT NULL,
  \`date_fin\` DATETIME DEFAULT NULL,
  \`prix_normal\` INT DEFAULT 0,
  \`prix_vip\` INT DEFAULT 0,
  \`capacite\` INT DEFAULT NULL,
  \`statut\` ENUM('actif', 'archive', 'annule') DEFAULT 'actif',
  \`vues\` INT DEFAULT 0,
  \`categorie_id\` INT NOT NULL,
  \`artiste_id\` INT DEFAULT NULL,
  FOREIGN KEY (\`categorie_id\`) REFERENCES \`categories\`(\`id\`) ON DELETE CASCADE,
  FOREIGN KEY (\`artiste_id\`) REFERENCES \`artistes\`(\`id\`) ON DELETE SET NULL
) ENGINE=InnoDB;`
  },
  {
    name: "Configuration PDO",
    path: "config/database.php",
    type: "php",
    content: `<?php
class Database {
    private static $host = "localhost";
    private static $db_name = "kassiri_pulse_db";
    private static $username = "root";
    private static $password = "";
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db_name . ";charset=utf8", self::$username, self::$password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ATTR_ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $exception) {
                throw new Exception("Erreur de connexion : " . $exception->getMessage());
            }
        }
        return self::$conn;
    }
}?>`
  },
  {
    name: "En-tête HTML layout",
    path: "includes/header.php",
    type: "php",
    content: `<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Kassiri Pulse</title>
    <!-- Chargement CDNs demandés -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>`
  },
  {
    name: "Page Index principale",
    path: "index.php",
    type: "php",
    content: `<?php
require_once 'config/database.php';
require_once 'includes/header.php';
require_once 'includes/navbar.php';

try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query("SELECT e.*, c.nom as categorie FROM evenements e JOIN categories c ON e.categorie_id = c.id WHERE e.statut='actif'");
    $evenements = $stmt->fetchAll();
} catch(Exception $e) {
    // Graceful error fallback
}
?>
<!-- Swiper Hero visualizer -->
<div class="swiper-container">
    <!-- Items dynamically injected -->
</div>
<?php require_once 'includes/footer.php'; ?>`
  }
];
