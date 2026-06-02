<?php
/**
 * Kassiri Pulse - Gestion des Artistes
 * Fichier : admin/artistes.php
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

$artistes = [];
$db_connected = false;

try {
    $pdo = Database::getConnection();
    $db_connected = true;
    
    $stmt = $pdo->query("SELECT * FROM artistes ORDER BY nom ASC");
    $artistes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $db_connected = false;
}

// Fallback Mock de secours
if (empty($artistes)) {
    $artistes = [
        ['id' => 1, 'nom' => 'Alif Naaba', 'slug' => 'alif-naaba', 'discipline' => 'Musique / Folk', 'ville' => 'Ouagadougou', 'photo' => 'https://images.unsplash.com/photo-1549834185-bd9f078a5dfe?q=80&w=300&auto=format&fit=crop'],
        ['id' => 2, 'nom' => 'Smarty', 'slug' => 'smarty', 'discipline' => 'Rap / Hip-Hop', 'ville' => 'Ouagadougou', 'photo' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?q=80&w=300&auto=format&fit=crop'],
        ['id' => 3, 'nom' => 'Siriki Ky', 'slug' => 'siriki-ky', 'discipline' => 'Sculpture', 'ville' => 'Laongo', 'photo' => 'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?q=80&w=300&auto=format&fit=crop'],
        ['id' => 4, 'nom' => 'Irène Tassembédo', 'slug' => 'irene-tassembedo', 'discipline' => 'Danse Contemporaine', 'ville' => 'Ouagadougou', 'photo' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?q=80&w=300&auto=format&fit=crop']
    ];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer Artistes | Admin Kassiri</title>
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
                <a href="artistes.php" class="sidebar-link active"><i class="fa-solid fa-user-group me-2"></i> Artistes</a>
                <a href="billets.php" class="sidebar-link"><i class="fa-solid fa-ticket-simple me-2"></i> Billets & Validation</a>
                <a href="podcasts.php" class="sidebar-link"><i class="fa-solid fa-podcast me-2"></i> Podcasts FM</a>
                <a href="commentaires.php" class="sidebar-link"><i class="fa-solid fa-comment-dots me-2"></i> Commentaires</a>
                <a href="../accueil" class="sidebar-link border-top border-secondary mt-5" target="_blank"><i class="fa-solid fa-circle-arrow-left me-2"></i> Retour au site</a>
                <a href="logout.php" class="sidebar-link text-danger"><i class="fa-solid fa-power-off me-2"></i> Déconnexion</a>
            </nav>
        </div>

        <!-- ZONE DES ARTISTES -->
        <div class="col-lg-10 p-5">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                <div>
                    <h2 class="font-serif text-dark mb-0 fw-bold" style="font-family:'Playfair Display',serif;">Créateurs & Artistes</h2>
                    <span class="text-muted text-xs font-mono">Consultez et répertoriez les profils d'intervenants culturels burkinabè.</span>
                </div>
                <div>
                    <button class="btn btn-warning rounded-0 font-serif text-xs px-3" id="btn-add-art-mock"><i class="fa-solid fa-user-plus me-1"></i> Répertorier Artiste</button>
                </div>
            </div>

            <!-- Grille des profils -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mt-2">
                <?php foreach($artistes as $art): ?>
                    <div class="col">
                        <div class="card p-3 text-center border bg-white h-100">
                            <div class="mx-auto rounded-circle overflow-hidden shadow border border-3 border-danger mb-3" style="width:110px; height:110px;">
                                <img src="<?php echo htmlspecialchars($art['photo']); ?>" class="w-100 h-100 object-cover" alt="Artiste">
                            </div>
                            <h5 class="font-serif text-dark mb-1 h6"><?php echo htmlspecialchars($art['nom']); ?></h5>
                            <span class="text-[10px] text-success uppercase font-mono tracking-wider"><?php echo htmlspecialchars($art['discipline']); ?></span>
                            <div class="text-muted text-[10px] font-sans mt-2"><i class="fa-solid fa-map-location-dot"></i> <?php echo htmlspecialchars($art['ville']); ?></div>
                            <div class="mt-3 d-flex justify-content-center gap-1">
                                <a href="../pages/artiste.php?slug=<?php echo htmlspecialchars($art['slug']); ?>" target="_blank" class="btn btn-xs btn-outline-secondary py-1 text-[10px]"><i class="fa-solid fa-eye"></i> Aperçu</a>
                                <button class="btn btn-xs btn-outline-danger py-1 text-[10px] btn-edit-art-mock"><i class="fa-solid fa-user-pen"></i> Éditer</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const triggers = document.querySelectorAll(".btn-edit-art-mock, #btn-add-art-mock");
        triggers.forEach(tr => {
            tr.addEventListener("click", function() {
                Swal.fire({
                    title: 'Gestionnaire d\'Artistes',
                    text: 'L\'édition et l\'enregistrement d\'un artiste sont simulés en environnement local. Configurez les credentials MySQL de Hostinger pour l\'état de persistance.',
                    icon: 'info',
                    confirmButtonColor: '#C0392B'
                });
            });
        });
    });
</script>

</body>
</html>
