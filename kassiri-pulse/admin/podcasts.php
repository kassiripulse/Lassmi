<?php
/**
 * Kassiri Pulse - Gestion des Podcasts Admin
 * Fichier : admin/podcasts.php
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Sécurité
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

require_once '../config/database.php';

$podcasts = [];
$db_connected = false;

try {
    $pdo = Database::getConnection();
    $db_connected = true;
    
    $stmt = $pdo->query("SELECT p.*, a.nom as artiste_nom FROM podcasts p JOIN artistes a ON p.artiste_id = a.id ORDER BY p.id DESC");
    $podcasts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $db_connected = false;
}

// Fallback Mock de secours
if (empty($podcasts)) {
    $podcasts = [
        ['id' => 1, 'titre' => 'Alif Naaba : "L\'Écho de notre résilience"', 'artiste_nom' => 'Alif Naaba', 'duree' => '14:25', 'statut' => 'actif'],
        ['id' => 2, 'titre' => 'Aux origines du symposium de Laongo', 'artiste_nom' => 'Siriki Ky', 'duree' => '22:10', 'statut' => 'actif']
    ];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer Podcasts | Admin Kassiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --primary-red: #C0392B;
            --primary-green: #1A6B3C;
            --primary-gold: #D4A017;
            --bg-cream: #FAF5E9;
            --dark-charcoal: #1A1A1A;
        }
        body {
            background-color: var(--bg-cream);
            font-family: 'Source Sans Pro', sans-serif;
        }
        .admin-sidebar {
            background-color: var(--dark-charcoal);
            color: #ffffff;
            min-height: 100vh;
        }
        .sidebar-brand {
            border-bottom: 2px solid var(--primary-gold);
            padding: 20px;
        }
        .sidebar-link {
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        .sidebar-link:hover, .sidebar-link.active {
            color: var(--primary-gold);
            background-color: rgba(250, 245, 233, 0.05);
            border-left: 4px solid var(--primary-red);
        }
    </style>
</head>
<body>

<div class="container-fluid g-0">
    <div class="row g-0">
        <!-- BARRE LATÉRALE -->
        <div class="col-lg-2 admin-sidebar">
            <div class="sidebar-brand text-center">
                <div class="bg-danger d-inline-flex align-items-center justify-content-center text-white mb-2" style="width: 36px; height: 36px; border: 2px solid var(--primary-gold);">
                    <span class="fw-bold" style="font-size: 20px; font-family:'Playfair Display',serif;">K</span>
                </div>
                <h6 class="text-uppercase tracking-wider fw-bold mb-0">Kassiri Control</h5>
                <span class="text-muted font-mono d-block" style="font-size:9px;">Utilisateur: <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
            </div>

            <nav class="mt-3">
                <a href="dashboard.php" class="sidebar-link"><i class="fa-solid fa-chart-line me-2"></i> Dashboard</a>
                <a href="evenements.php" class="sidebar-link"><i class="fa-regular fa-calendar-check me-2"></i> Événements</a>
                <a href="ajouter_evenement.php" class="sidebar-link"><i class="fa-solid fa-circle-plus me-2"></i> Ajouter Événement</a>
                <a href="artistes.php" class="sidebar-link"><i class="fa-solid fa-user-group me-2"></i> Artistes</a>
                <a href="billets.php" class="sidebar-link"><i class="fa-solid fa-ticket-simple me-2"></i> Billets & Validation</a>
                <a href="podcasts.php" class="sidebar-link active"><i class="fa-solid fa-podcast me-2"></i> Podcasts FM</a>
                <a href="commentaires.php" class="sidebar-link"><i class="fa-solid fa-comment-dots me-2"></i> Commentaires</a>
                <a href="../accueil" class="sidebar-link border-top border-secondary mt-5" target="_blank"><i class="fa-solid fa-circle-arrow-left me-2"></i> Retour au site</a>
                <a href="logout.php" class="sidebar-link text-danger"><i class="fa-solid fa-power-off me-2"></i> Déconnexion</a>
            </nav>
        </div>

        <!-- ZONE DES PODCASTS -->
        <div class="col-lg-10 p-5">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                <div>
                    <h2 class="font-serif text-dark mb-0 fw-bold" style="font-family:'Playfair Display',serif;">Gérer les Podcasts FM</h2>
                    <span class="text-muted text-xs font-mono">Publiez ou gérez les émissions audios de Kassiri FM.</span>
                </div>
                <div>
                    <button class="btn btn-danger rounded-0 font-serif text-xs px-3" id="btn-add-podcast"><i class="fa-solid fa-plus me-1"></i> Publier Émission de Radio</button>
                </div>
            </div>

            <!-- Liste des Podcasts -->
            <div class="card p-4 bg-white border rounded-0 shadow-sm">
                <table class="table table-striped font-sans text-xs text-dark" style="font-size:13px; line-height:2.2;">
                    <thead>
                        <tr class="table-active">
                            <th>Titre</th>
                            <th>Artiste lié</th>
                            <th>Durée</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($podcasts as $pod): ?>
                            <tr>
                                <td class="fw-bold"><?php echo htmlspecialchars($pod['titre']); ?></td>
                                <td><i class="fa-solid fa-microphone text-[10px] text-danger me-1"></i> <?php echo htmlspecialchars($pod['artiste_nom']); ?></td>
                                <td class="font-mono"><?php echo htmlspecialchars($pod['duree']); ?></td>
                                <td><span class="badge bg-success">Actif</span></td>
                                <td>
                                    <button class="btn btn-xs btn-outline-danger py-1 px-2 text-[10px]" onclick="Swal.fire('Info', 'Simulation d\'archivage local.', 'info')"><i class="fa-solid fa-trash-can"></i> Archiver</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById("btn-add-podcast").addEventListener("click", function() {
        Swal.fire({
            title: 'Créer Émission Audio',
            text: 'La publication directe d\'audio et décalages est simulée localement pour démonstration d\'architecture MVC sans installation locale.',
            icon: 'info',
            confirmButtonColor: '#C0392B'
        });
    });
</script>

</body>
</html>
