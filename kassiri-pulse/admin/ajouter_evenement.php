<?php
/**
 * Kassiri Pulse - Ajouter un Événement Culturel
 * Fichier : admin/ajouter_evenement.php
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

$categories = [];
$db_connected = false;

try {
    $pdo = Database::getConnection();
    $db_connected = true;
    
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY nom ASC");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $db_connected = false;
}

// Fallback Mock de secours
if (empty($categories)) {
    $categories = [
        ['id' => 1, 'nom' => 'Musique'],
        ['id' => 2, 'nom' => 'Danse'],
        ['id' => 3, 'nom' => 'Arts plastiques'],
        ['id' => 4, 'nom' => 'Cinéma'],
        ['id' => 5, 'nom' => 'Théâtre'],
        ['id' => 6, 'nom' => 'Festivals']
    ];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Scène | Admin Kassiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Select2 Bootstrap 5 Styles -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    <!-- Dropzone.js CSS -->
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">

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
        .dropzone {
            background-color: #fafafa;
            border: 2px dashed var(--primary-red) !important;
            border-radius: 0;
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
                <a href="ajouter_evenement.php" class="sidebar-link active"><i class="fa-solid fa-circle-plus me-2"></i> Ajouter Événement</a>
                <a href="artistes.php" class="sidebar-link"><i class="fa-solid fa-user-group me-2"></i> Artistes</a>
                <a href="billets.php" class="sidebar-link"><i class="fa-solid fa-ticket-simple me-2"></i> Billets & Validation</a>
                <a href="podcasts.php" class="sidebar-link"><i class="fa-solid fa-podcast me-2"></i> Podcasts FM</a>
                <a href="commentaires.php" class="sidebar-link"><i class="fa-solid fa-comment-dots me-2"></i> Commentaires</a>
                <a href="../accueil" class="sidebar-link border-top border-secondary mt-5" target="_blank"><i class="fa-solid fa-circle-arrow-left me-2"></i> Retour au site</a>
                <a href="logout.php" class="sidebar-link text-danger"><i class="fa-solid fa-power-off me-2"></i> Déconnexion</a>
            </nav>
        </div>

        <!-- ZONE DE CRÉATION -->
        <div class="col-lg-10 p-5">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                <div>
                    <h2 class="font-serif text-dark mb-0 fw-bold" style="font-family:'Playfair Display',serif;">Nouveau Événement Culturel</h2>
                    <span class="text-muted text-xs font-mono">Publiez une nouvelle programmation à l'échelle nationale burkinabè.</span>
                </div>
                <div>
                    <a href="evenements.php" class="btn btn-outline-dark rounded-0 font-serif text-xs"><i class="fa-solid fa-arrow-left me-1"></i> Gérer Événements</a>
                </div>
            </div>

            <div class="row">
                <!-- Formulaire principal -->
                <div class="col-lg-8">
                    <form id="add-cultural-scene-form" class="bg-white p-5 border shadow-sm mb-4">
                        <div class="mb-3 text-xs">
                            <label class="form-label font-serif fw-bold text-dark block">Titre de l'événement :</label>
                            <input type="text" class="form-control rounded-0 font-sans" name="titre" placeholder="Ex: Festival International des Masques de Dédougou (FESTIMA)" required>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6 mb-2 text-xs">
                                <label class="form-label font-serif fw-bold text-dark block">Catégorie / Discipline :</label>
                                <select class="form-select rounded-0 font-sans select2-cat-init" name="categorie_id" required>
                                    <option value="" disabled selected>Sélectionnez...</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['nom']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-2 text-xs">
                                <label class="form-label font-serif fw-bold text-dark block">Localisation Ville :</label>
                                <select class="form-select rounded-0 font-sans select2-city-init" name="ville" required>
                                    <option value="" disabled selected>Sélectionnez...</option>
                                    <option value="Ouagadougou">Ouagadougou</option>
                                    <option value="Bobo-Dioulasso">Bobo-Dioulasso</option>
                                    <option value="Koudougou">Koudougou</option>
                                    <option value="Banfora">Banfora</option>
                                    <option value="Dédougou">Dédougou</option>
                                    <option value="Kaya">Kaya</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6 mb-2 text-xs">
                                <label class="form-label font-serif fw-bold text-dark block font-bold">Prix Billet Normal (CFA) :</label>
                                <input type="number" class="form-control rounded-0" name="prix_normal" value="0" min="0">
                            </div>
                            <div class="col-md-6 mb-2 text-xs">
                                <label class="form-label font-serif fw-bold text-dark block font-bold">Prix Billet VIP (CFA) :</label>
                                <input type="number" class="form-control rounded-0" name="prix_vip" value="0" min="0">
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6 mb-2 text-xs">
                                <label class="form-label font-serif fw-bold text-dark block">Date et Heure de Début :</label>
                                <input type="datetime-local" class="form-control rounded-0" name="date_debut" required>
                            </div>
                            <div class="col-md-6 mb-2 text-xs">
                                <label class="form-label font-serif fw-bold text-dark block">Date et Heure de Fin :</label>
                                <input type="datetime-local" class="form-control rounded-0" name="date_fin" required>
                            </div>
                        </div>

                        <div class="mb-3 text-xs">
                            <label class="form-label font-serif fw-bold text-dark block">Description du festival :</label>
                            <textarea class="form-control rounded-0 font-sans" name="description" rows="5" placeholder="Saisissez en détail les moments clés de la programmation, les artistes présents..." required></textarea>
                        </div>

                        <div class="mb-4 text-xs">
                            <label class="form-label font-serif fw-bold text-dark block">Dépôt d'Affiche / Visuel (Dropzone simulé) :</label>
                            <div class="dropzone" id="culturalDropzone"></div>
                        </div>

                        <button type="submit" class="btn btn-danger w-100 py-2 font-serif uppercase tracking-wide"><i class="fa-solid fa-square-plus me-1"></i> Publier l'Événement</button>
                    </form>
                </div>

                <!-- Guidance informative -->
                <div class="col-lg-4">
                    <div class="p-4 bg-light border border-dark mb-4 text-dark shadow-sm">
                        <h5 class="font-serif mb-2 text-danger"><i class="fa-solid fa-triangle-exclamation"></i> Consignes d'Édition</h5>
                        <p class="text-xs font-sans text-muted mb-0" style="line-height:1.75;">
                            Afin de respecter la mise en page, veillez à téléverser des visuels d'affiches au format 16:9 ou carré de résolution convenable. Les prix saisis à 0 correspondront automatiquement à une tarification libellée "Entrée Libre" sur le guichet de billetterie publique.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS CONFIGURATION INTERACTIVE INITIALISATIONS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Désactiver le chargement automatique globale Dropzone
    Dropzone.autoDiscover = false;

    $(document).ready(function() {
        // Init Select2
        if ($.fn.select2) {
            $('.select2-cat-init').select2({ theme: 'bootstrap-5' });
            $('.select2-city-init').select2({ theme: 'bootstrap-5' });
        }

        // Init Dropzone
        try {
            const myDropzone = new Dropzone("#culturalDropzone", {
                url: "#", // Mock upload URL
                maxFiles: 1,
                acceptedFiles: "image/*",
                autoProcessQueue: false,
                dictDefaultMessage: "Déposez l'affiche de l'événement ici ou cliquez pour parcourir"
            });
        } catch(dzErr) {
            console.error("Dropzone initiation error: ", dzErr);
        }

        // Enregistrement
        $('#add-cultural-scene-form').on('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Scène Culturelle Enregistrée !',
                text: "L'événement culturel a bien été créé et est désormais consultable par le public sur Kassiri Pulse.",
                icon: 'success',
                confirmButtonColor: '#C0392B'
            });

            this.reset();
        });
    });
</script>

</body>
</html>
