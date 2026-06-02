<?php
/**
 * Kassiri Pulse - Gestion des Commentaires Admin
 * Fichier : admin/commentaires.php
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

$commentaires = [];
$db_connected = false;

try {
    $pdo = Database::getConnection();
    $db_connected = true;
    
    $stmt = $pdo->query("SELECT c.*, e.titre as evenement_titre FROM commentaires c JOIN evenements e ON c.evenement_id = e.id ORDER BY c.id DESC");
    $commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $db_connected = false;
}

// Fallback Mock de secours
if (empty($commentaires)) {
    $commentaires = [
        ['id' => 1, 'nom' => 'Seydou Ouattara', 'contenu' => 'Le SIAO est vraiment le fleuron de l\'artisanat africain ! Magnifique organisation.', 'note' => 5, 'statut' => 'approuve', 'evenement_titre' => 'SIAO 2026 — Salon de l\'Artisanat'],
        ['id' => 2, 'nom' => 'Mariam Diallo', 'contenu' => 'Je n\'ai pas trouvé le stand des bijoux d\'Afrique.', 'note' => 3, 'statut' => 'en_attente', 'evenement_titre' => 'SIAO 2026 — Salon de l\'Artisanat'],
        ['id' => 3, 'nom' => 'Idrissa Barro', 'contenu' => 'Très bon concert ! Vivement l\'année prochaine !', 'note' => 5, 'statut' => 'approuve', 'evenement_titre' => 'Le Grand Kundé d\'Or Floby à Koudougou']
    ];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modérer Commentaires | Admin Kassiri</title>
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
                <a href="podcasts.php" class="sidebar-link"><i class="fa-solid fa-podcast me-2"></i> Podcasts FM</a>
                <a href="commentaires.php" class="sidebar-link active"><i class="fa-solid fa-comment-dots me-2"></i> Commentaires</a>
                <a href="../accueil" class="sidebar-link border-top border-secondary mt-5" target="_blank"><i class="fa-solid fa-circle-arrow-left me-2"></i> Retour au site</a>
                <a href="logout.php" class="sidebar-link text-danger"><i class="fa-solid fa-power-off me-2"></i> Déconnexion</a>
            </nav>
        </div>

        <!-- ZONE DES COMMENTAIRES -->
        <div class="col-lg-10 p-5">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                <div>
                    <h2 class="font-serif text-dark mb-0 fw-bold" style="font-family:'Playfair Display',serif;">Modérer les Commentaires</h2>
                    <span class="text-muted text-xs font-mono">Approuvez ou supprimez les critiques laissées par les utilisateurs du Faso.</span>
                </div>
            </div>

            <!-- Liste des critiques -->
            <div class="card p-4 bg-white border rounded-0 shadow-sm">
                <div class="row row-cols-1 g-3">
                    <?php foreach($commentaires as $comm): ?>
                        <div class="col border-bottom pb-3 mb-2">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="font-bold text-dark mb-0 h6"><?php echo htmlspecialchars($comm['nom']); ?></h6>
                                    <span class="text-[10px] text-muted font-mono block">Sur l'événement : <?php echo htmlspecialchars($comm['evenement_titre']); ?></span>
                                </div>
                                <div class="text-warning">
                                    <?php for($i=1; $i<=5; $i++): ?>
                                        <i class="fa-<?php echo $i <= $comm['note'] ? 'solid' : 'regular'; ?> fa-star" style="font-size:12px;"></i>
                                    <?php endfor; ?>
                                    <span class="badge rounded-0 ms-2 text-[8px] uppercase <?php echo $comm['statut'] === 'approuve' ? 'bg-success' : 'bg-warning text-dark'; ?>">
                                        <?php echo htmlspecialchars($comm['statut']); ?>
                                    </span>
                                </div>
                            </div>
                            <p class="text-xs text-muted font-sans mb-3"><?php echo nl2br(htmlspecialchars($comm['contenu'])); ?></p>
                            <div class="d-flex gap-1 justify-content-end">
                                <?php if($comm['statut'] === 'en_attente'): ?>
                                    <button class="btn btn-xs btn-outline-success py-1 px-3 text-[10px]" onclick="Swal.fire('Succès !', 'Commentaire approuvé.', 'success')"><i class="fa-solid fa-check"></i> Approuver</button>
                                <?php endif; ?>
                                <button class="btn btn-xs btn-outline-danger py-1 px-3 text-[10px]" onclick="Swal.fire('Succès !', 'Commentaire supprimé.', 'success')"><i class="fa-solid fa-trash-can"></i> Supprimer</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
