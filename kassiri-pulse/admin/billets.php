<?php
/**
 * Kassiri Pulse - Billets & Validation
 * Fichier : admin/billets.php
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
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billets & Validation | Admin Kassiri</title>
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
        .scanner-simulation {
            border: 4px solid var(--primary-red);
            padding: 30px;
            background-color: #000;
            color: var(--primary-green);
            font-family: 'JetBrains Mono', monospace;
            min-height: 250px;
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
                <a href="billets.php" class="sidebar-link active"><i class="fa-solid fa-ticket-simple me-2"></i> Billets & Validation</a>
                <a href="podcasts.php" class="sidebar-link"><i class="fa-solid fa-podcast me-2"></i> Podcasts FM</a>
                <a href="commentaires.php" class="sidebar-link"><i class="fa-solid fa-comment-dots me-2"></i> Commentaires</a>
                <a href="../accueil" class="sidebar-link border-top border-secondary mt-5" target="_blank"><i class="fa-solid fa-circle-arrow-left me-2"></i> Retour au site</a>
                <a href="logout.php" class="sidebar-link text-danger"><i class="fa-solid fa-power-off me-2"></i> Déconnexion</a>
            </nav>
        </div>

        <!-- ZONE DES BILLETS -->
        <div class="col-lg-10 p-5">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                <div>
                    <h2 class="font-serif text-dark mb-0 fw-bold" style="font-family:'Playfair Display',serif;">Validation Mobiles & Contrôle</h2>
                    <span class="text-muted text-xs font-mono">Simulez le scanneur de portillon d'accès aux festivals de Kassiri Pulse.</span>
                </div>
            </div>

            <div class="row g-4">
                <!-- Zone Scan Simulation -->
                <div class="col-lg-7">
                    <div class="card p-4 bg-white rounded-0 border mb-4 shadow-sm">
                        <h5 class="font-serif text-dark border-bottom pb-2 mb-3">Lecteur de Codes QR</h5>
                        <p class="text-xs text-muted font-sans mb-3">Entrez manuellement un code de billet de la forme <strong>BIL-KPS-XXXX-BF</strong> ou <strong>BIL-LKP-XXXX-BF</strong> pour simuler une vérification automatisée aux portiques de sécurité.</p>
                        
                        <form id="ticket-checker-form" class="mb-4">
                            <div class="input-group">
                                <input type="text" id="coupon-field" class="form-control rounded-0 font-mono text-dark font-bold text-uppercase" placeholder="Ex: BIL-KPS-A5B9C3D-BF" required>
                                <button class="btn btn-danger rounded-0 font-serif px-3" type="submit"><i class="fa-solid fa-barcode"></i> Vérifier le Pass</button>
                            </div>
                        </form>

                        <div class="scanner-simulation d-flex flex-column justify-content-center text-center align-items-center" id="scan-terminal">
                            <i class="fa-solid fa-camera display-4 text-warning mb-2 animate-pulse"></i>
                            <div class="text-warning font-bold">TERMINAL RECHERCHE ACTIF</div>
                            <div class="text-muted text-[10px] uppercase font-mono mt-1">Saisie de code ou scan en cours...</div>
                        </div>
                    </div>
                </div>

                <!-- Liste d'aide -->
                <div class="col-lg-5">
                    <div class="p-4 bg-light border border-dark rounded-0 mb-4 text-dark text-xs">
                        <h6 class="font-serif fw-bold text-danger border-bottom pb-2 mb-3"><i class="fa-solid fa-shield-halved"></i> Manuel du contrôleur</h6>
                        <ol class="ps-3" style="line-height:2;">
                            <li>Demandez le ticket papier ou écran mobile au spectateur au portillon.</li>
                            <li>Saisissez le code de réservation unique sous forme de caractères.</li>
                            <li>Vérifiez la conformité de l'identité imprimée par le scanner.</li>
                            <li>Autorisez l'entrée si le témoin de validation affiche <span class="badge bg-success rounded-0">PASS VALIDE</span>.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkForm = document.getElementById("ticket-checker-form");
        const terminal = document.getElementById("scan-terminal");

        if (checkForm) {
            checkForm.addEventListener("submit", function (e) {
                e.preventDefault();
                const code = document.getElementById("coupon-field").value.toUpperCase().trim();

                // Simulation de chargement
                terminal.innerHTML = `
                    <div class="spinner-border text-info mb-2" role="status"></div>
                    <div class="text-info font-bold">INTERROGATION SERVEUR KASSIRI...</div>
                `;

                setTimeout(() => {
                    const isValid = code.startsWith("BIL-");
                    
                    if (isValid) {
                        terminal.innerHTML = `
                            <i class="fa-solid fa-circle-check text-success display-3 mb-2"></i>
                            <div class="text-success h4 fw-bold">PASS VALIDE <i class="fa-solid fa-door-open ms-1"></i></div>
                            <div class="text-white text-[11px] font-bold font-mono mt-1">${code}</div>
                            <div class="text-muted text-[10px] mt-2 font-sans">Acheteur répertorié : Souleymane Barry | Type : Accès Général | Quantité : 1 place</div>
                        `;
                    } else {
                        terminal.innerHTML = `
                            <i class="fa-solid fa-circle-xmark text-danger display-3 mb-2"></i>
                            <div class="text-danger h4 fw-bold">CODE INCONNU / EXSPIRÉ <i class="fa-solid fa-triangle-exclamation ms-1"></i></div>
                            <div class="text-white text-[11px] font-bold font-mono mt-1">${code}</div>
                            <div class="text-muted text-[10px] mt-2 font-sans">Le code saisi ne correspond à aucun contrat de vente enregistré sur la plateforme.</div>
                        `;
                    }
                }, 1000);
            });
        }
    });
</script>

</body>
</html>
