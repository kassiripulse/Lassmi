<?php
/**
 * Kassiri Pulse - Configuration Connexion Base de Données
 * Architecture : PHP PDO (PHP 8.x)
 * Fichier : config/database.php
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'u123456789_kassiri_user'); // Remplacer par vos identifiants d'hôte
define('DB_PASS', 'Kassiri@FasoSecure2026!'); // Remplacer par votre mot de passe d'hôte
define('DB_NAME', 'u123456789_kassiri_db');   // Remplacer par votre bdd d'hôte

class Database {
    private static $connection = null;

    /**
     * Retourne une instance PDO unique et sécurisée (Pattern Singleton)
     * @return PDO
     */
    public static function getConnection() {
        if (self::$connection === null) {
            try {
                $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
                ];
                
                self::$connection = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (PDOException $e) {
                // Journaliser l'erreur en interne au lieu de l'afficher publiquement
                error_log("Connection Error: " . $e->getMessage());
                // Afficher un message propre et sécurisé sans révéler la structure serveur ou les mots de passe
                die("<div style='font-family:sans-serif;text-align:center;padding:50px;background:#FAF5E9;color:#C0392B;'>
                        <h2 style='font-family:serif;'>Kassiri Pulse — Liaison Interrompue</h2>
                        <p>La connexion au serveur de base de données culturel n'a pas pu aboutir.</p>
                        <p style='font-size:12px;color:#1A1A1A;'>Veuillez vérifier vos identifiants SQL dans <code>config/database.php</code> sur Hostinger.</p>
                     </div>");
            }
        }
        return self::$connection;
    }
}
?>
