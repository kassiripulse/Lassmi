<?php
/**
 * Kassiri Pulse - Carte Culturelle Interactive (Leaflet)
 * Fichier : pages/carte.php
 */
require_once '../config/database.php';
require_once '../includes/header.php';
require_once '../includes/navbar.php';

$db_connected = false;
$markers = [];

try {
    $pdo = Database::getConnection();
    $db_connected = true;

    // Récupérer tous les événements disposant de coordonnées
    $stmt = $pdo->query("SELECT e.id, e.titre, e.lieu, e.ville, e.latitude, e.longitude, e.slug, c.nom as categorie, c.couleur 
                           FROM evenements e 
                           JOIN categories c ON e.categorie_id = c.id 
                           WHERE e.latitude IS NOT NULL AND e.longitude IS NOT NULL AND e.statut='actif'");
    $markers = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    $db_connected = false;
}

// Fallback Mock de secours si pas de BDD active
if (empty($markers)) {
    $markers = [
        [
            'id' => 1,
            'titre' => 'SIAO 2026 — Salon de l\'Artisanat',
            'lieu' => 'Parc des Expositions SIAO',
            'ville' => 'Ouagadougou',
            'latitude' => 12.3392,
            'longitude' => -1.5034,
            'slug' => 'siao-2026',
            'categorie' => 'Festivals',
            'couleur' => '#D4A017'
        ],
        [
            'id' => 2,
            'titre' => 'FESPACO 2027 — Ciné Burkina',
            'lieu' => 'Ciné Burkina, Avenue Nelson Mandela',
            'ville' => 'Ouagadougou',
            'latitude' => 12.3702,
            'longitude' => -1.5248,
            'slug' => 'fespaco-2027',
            'categorie' => 'Cinéma',
            'couleur' => '#1A1A1A'
        ],
        [
            'id' => 5,
            'titre' => 'Jazz à Ouaga 2026 — CENASA',
            'lieu' => 'CENASA, Ouagadougou',
            'ville' => 'Ouagadougou',
            'latitude' => 12.3655,
            'longitude' => -1.5180,
            'slug' => 'jazz-ouaga-2026',
            'categorie' => 'Musique',
            'couleur' => '#C0392B'
        ],
        [
            'id' => 12,
            'titre' => 'Le Grand Kundé d\'Or — Place de la Nation',
            'lieu' => 'Place de la Nation',
            'ville' => 'Koudougou',
            'latitude' => 12.2536,
            'longitude' => -2.3621,
            'slug' => 'floby-koudougou',
            'categorie' => 'Musique',
            'couleur' => '#C0392B'
        ],
        [
            'id' => 6,
            'titre' => 'Concert Solidaire Smarty',
            'lieu' => 'Maison de la Culture de Bobo',
            'ville' => 'Bobo-Dioulasso',
            'latitude' => 11.1772,
            'longitude' => -4.2913,
            'slug' => 'smarty-echo-paix',
            'categorie' => 'Musique',
            'couleur' => '#C0392B'
        ]
    ];
}
?>

<!-- EN-TÊTE CARTE -->
<section class="py-5 bg-dark text-white text-center border-bottom border-warning">
    <div class="container py-3" data-aos="zoom-in">
        <h1 class="display-3 font-serif mb-1 uppercase text-brand-gold"><i class="fa-solid fa-map-location-dot me-1"></i> Cartographie Artistique</h1>
        <p class="lead font-sans text-white-50 max-w-xl mx-auto" style="font-size:16px;">
            Explorez géographiquement les foyers de culture, galeries et festivals à travers les provinces et d'importantes villes du Burkina.
        </p>
    </div>
</section>

<!-- CONTENEUR CARTE PLEINE LARGEUR AVEC FILTRE JQUERY -->
<section class="py-5 bg-bogolan-subtle">
    <div class="container">
        <div class="row">
            <!-- Sidebar indicateur de lieux -->
            <div class="col-lg-4 mb-4 mb-lg-0" data-aos="fade-right">
                <div class="p-4 bg-white border border-dark rounded-0 shadow-sm">
                    <h5 class="font-serif text-brand-charcoal mb-3 border-bottom pb-2">Destinations Culturelles</h5>
                    <p class="text-xs text-muted font-sans" style="line-height:1.6;">Cliquez sur l'un des foyers indiqués ci-dessous pour zoomer immédiatement sur la carte interactive.</p>
                    
                    <div class="list-group list-group-flush max-h-[350px] overflow-y-auto" id="province-list-trigger" style="max-height: 380px; overflow-y: auto;">
                        <?php foreach($markers as $marker): ?>
                            <button class="list-group-item list-group-item-action border-bottom text-xs py-3 font-sans d-flex align-items-center justify-between pointer transition btn-zoom-map"
                                    data-lat="<?php echo $marker['latitude']; ?>"
                                    data-lng="<?php echo $marker['longitude']; ?>">
                                <div>
                                    <strong class="font-serif block text-dark" style="font-size:12px;"><?php echo htmlspecialchars($marker['titre']); ?></strong>
                                    <span class="text-[9px] font-mono text-muted uppercase"><i class="fa-solid fa-location-dot me-1 text-danger"></i> <?php echo htmlspecialchars($marker['ville']); ?></span>
                                </div>
                                <span class="badge rounded-0 font-serif uppercase text-[8px] py-1 text-white" style="background-color: <?php echo htmlspecialchars($marker['couleur'] ?? '#C0392B'); ?>;">
                                    <?php echo htmlspecialchars($marker['categorie']); ?>
                                </span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Carte centrale Leaflet -->
            <div class="col-lg-8" data-aos="fade-left">
                <div class="bg-white p-2 border border-dark shadow-sm">
                    <div id="interactive-cultural-map" class="w-100" style="height: 520px; z-index:1;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SCRIPTS LEAFLET SCELLÉS ET DYNAMIQUES -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Coordonnées moyennes pour centrer sur le Burkina Faso
        const burkinaLat = 12.2383;
        const burkinaLng = -1.5616;

        // Initialiser la carte Leaflet
        const map = L.map('interactive-cultural-map').setView([burkinaLat, burkinaLng], 7);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        // Jeu de marqueurs d'expositions
        const markersData = <?php echo json_encode($markers); ?>;

        // Fonction d'iconographie personnalisée de couleur en fonction de la categorie
        function getCustomIcon(couleurHex) {
            let colorName = "red";
            if (couleurHex === "#D4A017") colorName = "gold";
            if (couleurHex === "#1A6B3C") colorName = "green";
            if (couleurHex === "#1A1A1A") colorName = "black";

            return L.icon({
                iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-${colorName}.png`,
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
        }

        // Ajouter les marqueurs dynamiques
        markersData.forEach(item => {
            const markerIcon = getCustomIcon(item.couleur);
            const markerObj = L.marker([parseFloat(item.latitude), parseFloat(item.longitude)], {icon: markerIcon}).addTo(map);
            
            markerObj.bindPopup(`
                <div class="p-1 font-sans text-dark" style="min-width: 180px;">
                    <span class="badge text-white px-2 py-1 uppercase text-[8px] mb-1" style="background-color: ${item.couleur};">${item.categorie}</span>
                    <strong class="font-serif block text-dark h6 my-1" style="font-size:12px;">${item.titre}</strong>
                    <span class="text-[10px] text-muted font-mono block mb-2"><i class="fa-solid fa-map-pin"></i> ${item.lieu} (${item.ville})</span>
                    <a href="evenement.php?slug=${item.slug}" class="btn btn-xs btn-danger text-white rounded-0 py-1 font-serif text-[10px] w-full text-center d-block">Consulter Guichet</a>
                </div>
            `);
        });

        // Gestion du clic sur les boutons d'index de la sidebar pour centrer et zoomer
        const zoomBtns = document.querySelectorAll(".btn-zoom-map");
        zoomBtns.forEach(btn => {
            btn.addEventListener("click", function() {
                const targetLat = parseFloat(btn.getAttribute("data-lat"));
                const targetLng = parseFloat(btn.getAttribute("data-lng"));

                map.setView([targetLat, targetLng], 14, {
                    animate: true,
                    duration: 1.2
                });
            });
        });
    });
</script>

<?php
require_once '../includes/footer.php';
?>
