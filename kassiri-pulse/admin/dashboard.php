<?php
/**
 * Kassiri Pulse - Tableau de Bord Administratif Principal
 * Fichier : admin/dashboard.php
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté administratrice
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

require_once '../config/database.php';

// Variables de statistiques
$total_evenements = 12;
$total_artistes = 8;
$revenus_totaux = 1450000; // CFA
$total_commentaires_approuves = 25;
$recent_transactions = [
    ['id' => 1, 'acheteur' => 'Adama Sawadogo', 'evenement' => 'Floby à Koudougou', 'type' => 'vip', 'total' => 10000, 'date' => '2026-06-02 12:45'],
    ['id' => 2, 'acheteur' => 'Mariam Diallo', 'evenement' => 'SIAO 2026', 'type' => 'normal', 'total' => 4000, 'date' => '2026-06-01 19:15'],
    ['id' => 3, 'acheteur' => 'Ousmane Traoré', 'evenement' => 'Jazz à Ouaga 2026', 'type' => 'normal', 'total' => 3000, 'date' => '2026-06-01 10:30'],
    ['id' => 4, 'acheteur' => 'Awa Ouédraogo', 'evenement' => 'FESPACO Film Sira', 'type' => 'normal', 'total' => 1500, 'date' => '2026-05-30 16:50']
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Kassiri Pulse</title>
    <!-- CSS libraries CDNs -->
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
        .stat-card {
            background-color: #ffffff;
            border-left: 5px solid var(--primary-red);
            border-radius: 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }
        .border-bogolan {
            border-style: solid;
            border-width: 4px;
            border-image: repeating-linear-gradient(45deg, var(--primary-green), var(--primary-green) 10px, var(--primary-gold) 10px, var(--primary-gold) 20px, var(--primary-red) 20px, var(--primary-red) 30px, var(--dark-charcoal) 30px, var(--dark-charcoal) 40px) 20;
        }
    </style>
</head>
<body>

<div class="container-fluid g-0">
    <div class="row g-0">
        <!-- BARRE LATÉRALE DE CONTRÔLE -->
        <div class="col-lg-2 admin-sidebar">
            <div class="sidebar-brand text-center">
                <div class="bg-danger d-inline-flex align-items-center justify-content-center text-white mb-2" style="width: 36px; height: 36px; border: 2px solid var(--primary-gold);">
                    <span class="fw-bold" style="font-size: 20px; font-family:'Playfair Display',serif;">K</span>
                </div>
                <h6 class="text-uppercase tracking-wider fw-bold mb-0">Kassiri Control</h5>
                <span class="text-muted font-mono d-block" style="font-size:9px;">Utilisateur: <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
            </div>

            <nav class="mt-3">
                <a href="dashboard.php" class="sidebar-link active"><i class="fa-solid fa-chart-line me-2"></i> Dashboard</a>
                <a href="evenements.php" class="sidebar-link"><i class="fa-regular fa-calendar-check me-2"></i> Événements</a>
                <a href="ajouter_evenement.php" class="sidebar-link"><i class="fa-solid fa-circle-plus me-2"></i> Ajouter Événement</a>
                <a href="artistes.php" class="sidebar-link"><i class="fa-solid fa-user-group me-2"></i> Artistes</a>
                <a href="billets.php" class="sidebar-link"><i class="fa-solid fa-ticket-simple me-2"></i> Billets & Validation</a>
                <a href="podcasts.php" class="sidebar-link"><i class="fa-solid fa-podcast me-2"></i> Podcasts FM</a>
                <a href="commentaires.php" class="sidebar-link"><i class="fa-solid fa-comment-dots me-2"></i> Commentaires</a>
                <a href="../accueil" class="sidebar-link border-top border-secondary mt-5" target="_blank"><i class="fa-solid fa-circle-arrow-left me-2"></i> Retour au site</a>
                <a href="logout.php" class="sidebar-link text-danger"><i class="fa-solid fa-power-off me-2"></i> Déconnexion</a>
            </nav>
        </div>

        <!-- ZONE DE TRAVAIL PRINCIPALE -->
        <div class="col-lg-10 p-5">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                <div>
                    <h2 class="font-serif text-dark mb-0 fw-bold" style="font-family:'Playfair Display',serif;">Tableau de Bord Administratif</h2>
                    <span class="text-muted text-xs font-mono">Consultez en un clin d'œil les résultats de la culture burkinabè.</span>
                </div>
                <div>
                    <span class="badge bg-success py-2 px-3 rounded-0 font-mono">BASE SECURE : OK <i class="fa-solid fa-shield-halved ms-1"></i></span>
                </div>
            </div>

            <!-- CARDS STATISTIQUES SAHÉLIENNES -->
            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <div class="card stat-card p-4">
                        <span class="text-muted text-[10px] uppercase font-mono block">Scènes Actives</span>
                        <h2 class="fw-bold text-dark mt-1 mb-0"><?php echo $total_evenements; ?></h2>
                        <span class="text-success text-[10px] font-bold d-block mt-2"><i class="fa-solid fa-circle-arrow-up"></i> +2 ce mois</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card p-4" style="border-left-color: var(--primary-green);">
                        <span class="text-muted text-[10px] uppercase font-mono block">Gardiens Artistes</span>
                        <h2 class="fw-bold text-dark mt-1 mb-0"><?php echo $total_artistes; ?></h2>
                        <span class="text-[10px] text-muted d-block mt-2">Répertoriés au Burkina</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card p-4" style="border-left-color: var(--primary-gold);">
                        <span class="text-muted text-[10px] uppercase font-mono block">Recettes Billetterie</span>
                        <h2 class="fw-bold text-dark mt-1 mb-0"><?php echo number_format($revenus_totaux, 0, ',', ' '); ?> CFA</h2>
                        <span class="text-success text-[10px] font-bold d-block mt-2"><i class="fa-solid fa-wallet"></i> Orange & Moov validés</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card p-4" style="border-left-color: var(--dark-charcoal);">
                        <span class="text-muted text-[10px] uppercase font-mono block">Avis Critiques</span>
                        <h2 class="fw-bold text-dark mt-1 mb-0"><?php echo $total_commentaires_approuves; ?></h2>
                        <span class="text-warning text-[10px] font-bold d-block mt-2">Note globale moyenne : 4.8 / 5</span>
                    </div>
                </div>
            </div>

            <!-- ANALYTICS CHARTS AVEC CHART.JS -->
            <div class="row g-4 mb-5">
                <!-- Graphique de billetterie -->
                <div class="col-lg-6">
                    <div class="card p-4 bg-white rounded-0 border shadow-sm">
                        <h5 class="font-serif text-dark border-bottom pb-2 mb-3" style="font-family:'Playfair Display',serif;">Ventes cumulées de billets (CFA)</h5>
                        <div style="height:300px; position:relative;">
                            <canvas id="ticketsChartCanvas"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Graphique de visites par catégories -->
                <div class="col-lg-6">
                    <div class="card p-4 bg-white rounded-0 border shadow-sm">
                        <h5 class="font-serif text-dark border-bottom pb-2 mb-3" style="font-family:'Playfair Display',serif;">Popularité des Disciplines (Vues)</h5>
                        <div style="height:300px; position:relative;">
                            <canvas id="categoriesChartCanvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DERNIÈRES VENTES ENREGISTRÉES -->
            <div class="row">
                <div class="col-12">
                    <div class="card p-4 bg-white border rounded-0 shadow-sm">
                        <h5 class="font-serif text-dark border-bottom pb-2 mb-3" style="font-family:'Playfair Display',serif;"><i class="fa-solid fa-credit-card text-success"></i> Flux Récent des Commandes Validés</h5>
                        <table class="table table-striped font-sans text-xs text-dark" style="font-size:13px; line-height:2;">
                            <thead>
                                <tr class="table-active">
                                    <th>Acheteur</th>
                                    <th>Événement</th>
                                    <th>Catégorie</th>
                                    <th>Montant payé (CFA)</th>
                                    <th>Date d'achat</th>
                                    <th>Statut de livraison</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_transactions as $tr): ?>
                                    <tr>
                                        <td class="fw-bold"><?php echo htmlspecialchars($tr['acheteur']); ?></td>
                                        <td><?php echo htmlspecialchars($tr['evenement']); ?></td>
                                        <td><span class="badge <?php echo $tr['type'] === 'vip' ? 'bg-warning text-dark' : 'bg-secondary'; ?> uppercase text-[10px]"><?php echo $tr['type']; ?></span></td>
                                        <td class="fw-bold"><?php echo number_format($tr['total'], 0, ',', ' '); ?> CFA</td>
                                        <td class="font-mono"><?php echo $tr['date']; ?></td>
                                        <td><span class="badge bg-success rounded-0"><i class="fa-solid fa-square-envelope"></i> Envoyé QR</span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS DE COMPOSITION CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1. CHART DE BILLETTERIE (BARRES)
        try {
            const ctxTickets = document.getElementById('ticketsChartCanvas').getContext('2d');
            new Chart(ctxTickets, {
                type: 'bar',
                data: {
                    labels: ['SIAO 2026', 'Floby Koudougou', 'Jazz à Ouaga', 'FESPACO 2027', 'Concert Smarty'],
                    datasets: [{
                        label: 'Ventes en CFA',
                        data: [650000, 320000, 240000, 150000, 90000],
                        backgroundColor: '#C0392B',
                        borderColor: '#1A1A1A',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        } catch(chartErr) {
            console.error("Tickets chart exception: ", chartErr);
        }

        // 2. CHART DE POPULARITÉ (DONUT / PIE)
        try {
            const ctxCats = document.getElementById('categoriesChartCanvas').getContext('2d');
            new Chart(ctxCats, {
                type: 'doughnut',
                data: {
                    labels: ['Musique', 'Danse', 'Arts Plastiques', 'Cinéma', 'Théâtre', 'Festivals'],
                    datasets: [{
                        data: [420, 210, 180, 560, 110, 890],
                        backgroundColor: ['#C0392B', '#1A6B3C', '#D4A017', '#1A1A1A', '#EF4444', '#F59E0B']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        } catch(chartErr) {
            console.error("Categories chart exception: ", chartErr);
        }
    });
</script>

</body>
</html>
