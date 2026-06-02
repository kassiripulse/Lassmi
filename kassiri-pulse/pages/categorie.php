<?php
/**
 * Kassiri Pulse - Liste des événements par Discipline/Catégorie
 * Fichier : pages/categorie.php
 */
require_once '../config/database.php';
require_once '../includes/header.php';
require_once '../includes/navbar.php';

$cat_slug = isset($_GET['slug']) ? htmlspecialchars($_GET['slug']) : 'musique';

// Charger les événements liés de la catégorie
$db_connected = false;
$categorie = null;
$evenements = [];

try {
    $pdo = Database::getConnection();
    $db_connected = true;

    // Charger catégorie
    $stmt_cat = $pdo->prepare("SELECT * FROM categories WHERE slug = ?");
    $stmt_cat->execute([$cat_slug]);
    $categorie = $stmt_cat->fetch();

    if ($categorie) {
        $stmt_ev = $pdo->prepare("SELECT e.*, c.nom as categorie, c.couleur, c.icone FROM evenements e JOIN categories c ON e.categorie_id = c.id WHERE c.id = ? AND e.statut='actif' ORDER BY e.date_debut ASC");
        $stmt_ev->execute([$categorie['id']]);
        $evenements = $stmt_ev->fetchAll();
    }
} catch (Exception $e) {
    $db_connected = false;
}

// Fallback Mock de secours si pas de base de données active
if (!$categorie) {
    $categories_mock = [
        'musique' => ['id' => 1, 'nom' => 'Musique', 'couleur' => '#C0392B', 'icone' => 'Music', 'description' => 'Découvrez les concerts mythiques d\'afro-fusion, de jazz sahélien et de variété populaire au Faso.'],
        'danse' => ['id' => 2, 'nom' => 'Danse', 'couleur' => '#1A6B3C', 'icone' => 'Flame', 'description' => 'De la danse traditionnelle mandingue aux chorégraphies africaines contemporaines.'],
        'arts-plastiques' => ['id' => 3, 'nom' => 'Arts plastiques', 'couleur' => '#D4A017', 'icone' => 'Palette', 'description' => 'Sculptures de bronze majestueuses et symposium de granit à ciel ouvert.'],
        'cinema' => ['id' => 4, 'nom' => 'Cinéma', 'couleur' => '#1A1A1A', 'icone' => 'Film', 'description' => 'Le temple du septième art d\'Afrique avec le légendaire FESPACO.'],
        'theatre' => ['id' => 5, 'nom' => 'Théâtre', 'couleur' => '#C0392B', 'icone' => 'Theater', 'description' => 'La dramaturgie d\'expression sociale engagée au service de la résilience.'],
        'festivals' => ['id' => 6, 'nom' => 'Festivals', 'couleur' => '#D4A017', 'icone' => 'Sparkles', 'description' => 'Célébrations festives et foires commerciales artisanales du Sahel (SIAO, FESTIMA).']
    ];

    $categorie = isset($categories_mock[$cat_slug]) ? $categories_mock[$cat_slug] : $categories_mock['musique'];
    
    // Événements liés (Mock)
    $all_mock_events = [
        ['id' => 12, 'titre' => 'Le Grand Kundé d\'Or Floby à Koudougou', 'slug' => 'floby-koudougou', 'lieu' => 'Place de la Nation', 'ville' => 'Koudougou', 'image' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?q=80&w=800&auto=format&fit=crop', 'prix_normal' => 1000, 'date_debut' => '2026-06-10 19:00:00', 'categorie_id' => 1, 'description' => 'Le Roi Floby revient chanter la paix envers ses compatriotes mossis de Koudougou.'],
        ['id' => 5, 'titre' => 'Jazz à Ouaga 2026 — Club du Sahel', 'slug' => 'jazz-ouaga-2026', 'lieu' => 'CENASA', 'ville' => 'Ouagadougou', 'image' => 'https://images.unsplash.com/photo-1486591978090-58e619d37fe7?q=80&w=800&auto=format&fit=crop', 'prix_normal' => 3000, 'date_debut' => '2026-06-15 19:30:00', 'categorie_id' => 1, 'description' => 'La 34ème édition de notre festival de jazz métissé.'],
        ['id' => 1, 'titre' => 'SIAO 2026 — Salon de l\'Artisanat', 'slug' => 'siao-2026', 'lieu' => 'Parc SIAO', 'ville' => 'Ouagadougou', 'image' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?q=80&w=800&auto=format&fit=crop', 'prix_normal' => 2000, 'date_debut' => '2026-10-30 08:00:00', 'categorie_id' => 6, 'description' => 'Le grand marché des créations africaines.'],
        ['id' => 7, 'titre' => 'FIDO 2027 — Danse de Ouaga', 'slug' => 'fido-2027', 'lieu' => 'CDC La Termitière', 'ville' => 'Ouagadougou', 'image' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?q=80&w=800&auto=format&fit=crop', 'prix_normal' => 1000, 'date_debut' => '2026-11-12 19:00:00', 'categorie_id' => 2, 'description' => 'FIDO chorégraphie transgressive sahélienne.']
    ];

    $evenements = array_filter($all_mock_events, function($e) use ($categorie) {
        return $e['categorie_id'] == $categorie['id'];
    });
}
?>

<!-- EN-TÊTE DE LA DISCIPLINE -->
<section class="py-5 text-white text-center border-bottom border-warning" style="background-color: <?php echo htmlspecialchars($categorie['couleur']); ?> !important;">
    <div class="container" data-aos="zoom-in">
        <h1 class="display-3 font-serif mb-2 text-uppercase"><?php echo htmlspecialchars($categorie['nom']); ?></h1>
        <p class="lead font-sans max-w-xl mx-auto text-white-50" style="font-size:16px;">
            <?php echo isset($categorie['description']) ? htmlspecialchars($categorie['description']) : "Explorez tous les agendas de la discipline artistique au Burkina Faso."; ?>
        </p>
    </div>
</section>

<!-- FILTRES SELECT2 ET GRILLE -->
<section class="py-5">
    <div class="container">
        <!-- Barre de recherche locale avec Select2 -->
        <div class="row items-center justify-between bg-white p-4 border border-light-subtle rounded-0 mb-4 g-2" data-aos="fade-up">
            <div class="col-md-4 text-xs">
                <label class="form-label font-serif fw-bold block">Filtrer par Ville :</label>
                <select id="select-city-opt" class="form-select rounded-0 text-xs font-mono font-bold select2-city-init">
                    <option value="">Toutes les Villes</option>
                    <option value="Ouagadougou">Ouagadougou</option>
                    <option value="Bobo-Dioulasso">Bobo-Dioulasso</option>
                    <option value="Koudougou">Koudougou</option>
                    <option value="Banfora">Banfora</option>
                    <option value="Kaya">Kaya</option>
                </select>
            </div>
            <div class="col-md-4 text-xs">
                <label class="form-label font-serif fw-bold block">Trier par Tarification :</label>
                <select id="select-pricing-opt" class="form-select rounded-0 text-xs font-mono font-bold select2-price-init">
                    <option value="default">Ordre Chronologique</option>
                    <option value="low-high">Tarif croissant</option>
                    <option value="high-low">Tarif décroissant</option>
                </select>
            </div>
        </div>

        <!-- RÉSULTATS DES ÉVÉNEMENTS -->
        <?php if (empty($evenements)): ?>
            <div class="py-5 text-center bg-white border" data-aos="fade-up">
                <i class="fa-solid fa-calendar-xmark text-danger display-4 mb-3"></i>
                <h4 class="font-serif text-dark">Aucun événement à venir</h4>
                <p class="text-xs text-muted font-sans">Il n'y a pour le moment aucun événement répertorié dans la discipline <?php echo htmlspecialchars($categorie['nom']); ?>. Veuillez revenir ultérieurement.</p>
                <a href="accueil" class="btn btn-kassiri rounded-0 text-xs font-serif mt-3">Retour à l'accueil</a>
            </div>
        <?php else: ?>
            <div class="row g-4" id="category-events-grid" data-aos="fade-up">
                <?php foreach ($evenements as $ev): ?>
                    <div class="col-lg-4 col-md-6 cat-event-card" data-ville="<?php echo htmlspecialchars($ev['ville']); ?>" data-price="<?php echo $ev['prix_normal']; ?>">
                        <div class="card card-culture h-100">
                            <div class="position-relative overflow-hidden" style="height: 200px;">
                                <img src="<?php echo htmlspecialchars($ev['image']); ?>" class="card-img-top w-100 h-100 object-cover" alt="Image">
                            </div>
                            <div class="card-body p-4 d-flex flex-column justify-between">
                                <div>
                                    <h5 class="card-title font-serif h6 text-dark mb-2"><?php echo htmlspecialchars($ev['titre']); ?></h5>
                                    <p class="card-text text-xs text-muted mb-3"><?php echo htmlspecialchars(substr($ev['description'] ?? '', 0, 110)); ?>...</p>
                                </div>
                                <div class="border-top pt-3 font-mono text-[11px] text-muted">
                                    <div class="mb-1"><i class="fa-regular fa-calendar-check text-danger me-1"></i> <?php echo date('d M Y', strtotime($ev['date_debut'])); ?></div>
                                    <div class="mb-2"><i class="fa-solid fa-location-crosshairs text-success me-1"></i> <?php echo htmlspecialchars($ev['ville']); ?> — <?php echo htmlspecialchars($ev['lieu']); ?></div>
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-dark fw-bold"><?php echo $ev['prix_normal'] == 0 ? "Entrée Libre" : number_format($ev['prix_normal'], 0, ',', ' ') . " CFA"; ?></span>
                                        <a href="evenement/<?php echo htmlspecialchars($ev['slug']); ?>" class="btn btn-sm btn-kassiri py-1 px-3" style="font-size:11px;">Consulter</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- SCRIPTS SELECT2 INITIALIZATION & CHILL SORTING -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialiser Select2
        if (typeof $.fn.select2 !== 'undefined') {
            $('.select2-city-init').select2({
                theme: 'bootstrap-5',
                placeholder: 'Filtrer par Ville'
            });
            $('.select2-price-init').select2({
                theme: 'bootstrap-5',
                placeholder: 'Trier par Prix'
            });
        }

        // Logic de filtrage JS
        const selectCity = document.getElementById("select-city-opt");
        const selectPricing = document.getElementById("select-pricing-opt");
        const eventCardsContainer = document.getElementById("category-events-grid");

        function filterAndSortEvents() {
            if (!eventCardsContainer) return;
            const cards = Array.from(eventCardsContainer.getElementsByClassName("cat-event-card"));
            const chosenCity = selectCity.value;
            const chosenSort = selectPricing.value;

            // Filtrer
            cards.forEach(card => {
                const cardVille = card.getAttribute("data-ville");
                if (chosenCity === "" || cardVille === chosenCity) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });

            // Trier
            if (chosenSort === "low-high") {
                cards.sort((a,b) => parseInt(a.getAttribute("data-price")) - parseInt(b.getAttribute("data-price")));
            } else if (chosenSort === "high-low") {
                cards.sort((a,b) => parseInt(b.getAttribute("data-price")) - parseInt(a.getAttribute("data-price")));
            }

            cards.forEach(card => eventCardsContainer.appendChild(card));
        }

        if (selectCity && selectPricing) {
            selectCity.addEventListener("change", filterAndSortEvents);
            selectPricing.addEventListener("change", filterAndSortEvents);
            
            // Écouter si Select2 est actif
            $(selectCity).on('change', filterAndSortEvents);
            $(selectPricing).on('change', filterAndSortEvents);
        }
    });
</script>

<?php
require_once '../includes/footer.php';
?>
