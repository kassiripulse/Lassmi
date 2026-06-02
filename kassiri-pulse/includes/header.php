<?php
/**
 * Kassiri Pulse - Header commun
 * Fichier : includes/header.php
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Protection basique de la session contre la fixation de session
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}

// Variables meta SEO par défaut
$site_title = isset($page_title) ? $page_title . " | Kassiri Pulse" : "Kassiri Pulse — Portail Culturel du Burkina Faso";
$meta_desc = isset($page_desc) ? $page_desc : "Kassiri Pulse est la plateforme premium de l'actualité culturelle, des événements, de la billetterie et des podcasts du Burkina Faso.";
$og_image = isset($page_image) ? $page_image : "assets/images/og-default.jpg";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($site_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($meta_desc); ?>">
    
    <!-- Open Graph SEO -->
    <meta property="og:title" content="<?php echo htmlspecialchars($site_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($meta_desc); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($og_image); ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="fr_FR">

    <!-- Google Fonts - Ambiance Sahélienne & Design Éditorial Premium -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Source+Serif+4:ital,opsz,wght@0,8..60,200..900;1,8..60,200..900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">

    <!-- CDNs de toutes les bibliothèques demandées -->
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- FontAwesome pour les glyphes & icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Leaflet.js (Cartes) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <!-- Swiper.js (Sliders) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <!-- AOS.js (Animations au scroll) -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <!-- Lightbox2 (Visionneuse images) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">
    <!-- Plyr.js (Lecteur audio et podcasts) -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css">
    <!-- FullCalendar.js (Agenda interactif) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css">
    <!-- Select2 (Champs sélections stylisés) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    <!-- DataTables (Tableaux administratifs) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    
    <!-- Styles d'intégration Kassiri Pulse -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Mémorisation et application instantanée du thème (Évite le flash blanc en mode sombre) -->
    <script>
        (function() {
            const currentTheme = localStorage.getItem('kassiri-theme') || 'light';
            if (currentTheme === 'dark') {
                document.documentElement.classList.add('dark-mode-active');
            }
        })();
    </script>
</head>
<body>
    
    <!-- LOADER ANIMÉ DE L'AMBANCE BURKINABÈ -->
    <div id="cultural-loader">
        <div class="loader-pot"></div>
        <div class="h2 font-serif mt-3 text-brand-charcoal">KASSIRI PULSE</div>
        <div class="text-xs font-mono text-muted text-uppercase tracking-wider">Le Souffle Culturel du Faso</div>
    </div>
