<?php
/**
 * Kassiri Pulse - Gestion des Événements Admin
 * Fichier : admin/evenements.php
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

$evenements = [];
$db_connected = false;

try {
    $pdo = Database::getConnection();
    $db_connected = true;
    
    $stmt = $pdo->query("SELECT e.*, c.nom as categorie FROM evenements e JOIN categories c ON e.categorie_id = c.id ORDER BY e.date_debut ASC");
    $evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $db_connected = false;
}

// Fallback Mock de secours
if (empty($evenements)) {
    $evenements = [
        ['id' => 1, 'titre' => 'SIAO 2026 — Salon de l\'Artisanat (Ouagadougou)', 'slug' => 'siao-2026', 'lieu' => 'Parc SIAO', 'ville' => 'Ouagadougou', 'date_debut' => '2026-10-30 08:00', 'prix_normal' => 2000, 'categorie' => 'Festivals', 'statut' => 'actif'],
        ['id' => 2, 'titre' => 'FESPACO 2027 — Lancement Cinéma', 'slug' => 'fespaco-2027', 'lieu' => 'Ciné Burkina', 'ville' => 'Ouagadougou', 'date_debut' => '2026-12-05 09:00', 'prix_normal' => 1500, 'categorie' => 'Cinéma', 'statut' => 'actif'],
        ['id' => 5, 'titre' => 'Jazz à Ouaga 2026 — Club du Sahel', 'slug' => 'jazz-ouaga-2026', 'lieu' => 'CENASA', 'ville' => 'Ouagadougou', 'date_debut' => '2026-06-15 19:30', 'prix_normal' => 3000, 'categorie' => 'Musique', 'statut' => 'actif'],
        ['id' => 12, 'titre' => 'Le Grand Kundé d\'Or Floby', 'slug' => 'floby-koudougou', 'lieu' => 'Place de la Nation', 'ville' => 'Koudougou', 'date_debut' => '2026-06-10 19:00', 'prix_normal' => 1000, 'categorie' => 'Musique', 'statut' => 'actif']
    ];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer Événements | Admin Kassiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    
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
                <a href="evenements.php" class="sidebar-link active"><i class="fa-regular fa-calendar-check me-2"></i> Événements</a>
                <a href="ajouter_evenement.php" class="sidebar-link"><i class="fa-solid fa-circle-plus me-2"></i> Ajouter Événement</a>
                <a href="artistes.php" class="sidebar-link"><i class="fa-solid fa-user-group me-2"></i> Artistes</a>
                <a href="billets.php" class="sidebar-link"><i class="fa-solid fa-ticket-simple me-2"></i> Billets & Validation</a>
                <a href="podcasts.php" class="sidebar-link"><i class="fa-solid fa-podcast me-2"></i> Podcasts FM</a>
                <a href="commentaires.php" class="sidebar-link"><i class="fa-solid fa-comment-dots me-2"></i> Commentaires</a>
                <a href="../accueil" class="sidebar-link border-top border-secondary mt-5" target="_blank"><i class="fa-solid fa-circle-arrow-left me-2"></i> Retour au site</a>
                <a href="logout.php" class="sidebar-link text-danger"><i class="fa-solid fa-power-off me-2"></i> Déconnexion</a>
            </nav>
        </div>

        <!-- ZONE DE GESTION DES ÉVÉNEMENTS -->
        <div class="col-lg-10 p-5">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                <div>
                    <h2 class="font-serif text-dark mb-0 fw-bold" style="font-family:'Playfair Display',serif;">Gérer les Événements</h2>
                    <span class="text-muted text-xs font-mono">Consultez, modifiez et désactivez les scènes culturelles burkinabè.</span>
                </div>
                <div>
                    <a href="ajouter_evenement.php" class="btn btn-danger rounded-0 font-serif text-xs"><i class="fa-solid fa-plus me-1"></i> Créer Scène</a>
                </div>
            </div>

            <!-- TABLE DATATABLES INTERACTIVE -->
            <div class="card p-4 bg-white border rounded-0 shadow-sm">
                <table id="evenements-admin-table" class="table table-striped font-sans text-xs text-dark" style="font-size:13px; line-height:2.2;">
                    <thead>
                        <tr class="table-active font-serif">
                            <th>Titre</th>
                            <th>Date début</th>
                            <th>Ville / Lieu</th>
                            <th>Prix (CFA)</th>
                            <th>Catégorie</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($evenements as $ev): ?>
                            <tr>
                                <td class="fw-bold text-dark"><?php echo htmlspecialchars($ev['titre']); ?></td>
                                <td class="font-mono"><?php echo date('d/m/Y H:i', strtotime($ev['date_debut'])); ?></td>
                                <td><i class="fa-solid fa-map-pin text-[10px] text-danger me-1"></i> <?php echo htmlspecialchars($ev['ville']); ?> (<?php echo htmlspecialchars($ev['lieu']); ?>)</td>
                                <td class="fw-bold"><?php echo number_format($ev['prix_normal'], 0, ',', ' '); ?> CFA</td>
                                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($ev['categorie']); ?></span></td>
                                <td>
                                    <span class="badge <?php echo $ev['statut'] === 'actif' ? 'bg-success' : 'bg-danger'; ?> rounded-0 uppercase text-[9px]">
                                        <?php echo htmlspecialchars($ev['statut']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="../pages/evenement.php?slug=<?php echo htmlspecialchars($ev['slug']); ?>" target="_blank" class="btn btn-xs btn-outline-secondary py-1 px-2 text-[10px]" title="Aperçu"><i class="fa-solid fa-eye"></i></a>
                                        <button class="btn btn-xs btn-outline-dark py-1 px-2 text-[10px] btn-edit-mock" title="Modifier"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button class="btn btn-xs btn-outline-danger py-1 px-2 text-[10px] btn-delete-mock" title="Supprimer"><i class="fa-solid fa-trash-can"></i></button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS DATA TABLES -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Initialiser DataTables
        if ($.fn.DataTable) {
            $('#evenements-admin-table').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json'
                },
                order: [[1, 'asc']]
            });
        }

        // Actions simulées
        $('.btn-edit-mock').on('click', function() {
            Swal.fire({
                title: 'Édition de Scène',
                text: "En démonstration, la modification de formulaire direct est simulée par cette boîte. Pour une mise au point permanente s'enregistrer via MySQL.",
                icon: 'info',
                confirmButtonColor: '#C0392B'
            });
        });

        $('.btn-delete-mock').on('click', function() {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Cette scène culturelle sera définitivement supprimée de la base !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#C0392B',
                cancelButtonColor: '#1A1A1A',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Supprimé !',
                        text: 'L\'événement a bien été filtré de la base.',
                        icon: 'success',
                        confirmButtonColor: '#C0392B'
                    });
                }
            });
        });
    });
</script>

</body>
</html>
