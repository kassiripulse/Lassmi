<?php
/**
 * Kassiri Pulse - Galerie interactive d'images culturelles
 * Fichier : pages/galerie.php
 */
require_once '../config/database.php';
require_once '../includes/header.php';
require_once '../includes/navbar.php';

$db_connected = false;
$photos = [];

try {
    $pdo = Database::getConnection();
    $db_connected = true;

    // Charger toute la galerie
    $stmt = $pdo->query("SELECT g.*, e.titre as evenement FROM galerie g LEFT JOIN evenements e ON g.evenement_id = e.id ORDER BY g.id DESC");
    $photos = $stmt->fetchAll();
} catch (Exception $e) {
    $db_connected = false;
}

// Fallback Mock de secours
if (empty($photos)) {
    $photos = [
        ['id' => 1, 'titre' => 'Masque traditionnel de cérémonie Bobo', 'image' => 'https://images.unsplash.com/photo-1549834185-bd9f078a5dfe?q=80&w=600&auto=format&fit=crop', 'evenement' => 'Nuits Atypiques de Koudougou', 'type' => 'patrimoine'],
        ['id' => 2, 'titre' => 'Sculpture en bronze fondu — Fonderie d\'art de Ouaga', 'image' => 'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?q=80&w=600&auto=format&fit=crop', 'evenement' => 'SIAO 2026', 'type' => 'bronze'],
        ['id' => 3, 'titre' => 'Œuvre de granit ciselé — Siriki Ky', 'image' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?q=80&w=600&auto=format&fit=crop', 'evenement' => 'Symposium de Laongo', 'type' => 'sculpture'],
        ['id' => 4, 'titre' => 'Robe tissu Bogolan contemporain', 'image' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?q=80&w=600&auto=format&fit=crop', 'evenement' => 'SIAO 2026', 'type' => 'tissage'],
        ['id' => 5, 'titre' => 'Griot jouant du balafon traditionnel', 'image' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?q=80&w=600&auto=format&fit=crop', 'evenement' => 'Nuits Atypiques de Koudougou', 'type' => 'musique'],
        ['id' => 6, 'titre' => 'Spectacle de danse traditionnelle Mossi', 'image' => 'https://images.unsplash.com/photo-1459749411175-04bf5292ceea?q=80&w=600&auto=format&fit=crop', 'evenement' => 'Danse sacrée Ouagadougou', 'type' => 'danse']
    ];
}
?>

<!-- EN-TÊTE GALERIE -->
<section class="py-5 bg-dark text-white text-center border-bottom border-warning">
    <div class="container py-3" data-aos="zoom-in">
        <h1 class="display-3 font-serif mb-1 uppercase text-brand-gold">Musée Virtuel du Faso</h1>
        <p class="lead font-sans text-white-50 max-w-xl mx-auto" style="font-size:16px;">Contemplez la magnificence de notre patrimoine d'artisanat d'art, de masques sacrés et d'œuvres sculptées.</p>
    </div>
</section>

<!-- GRILLE DE MOTIFS PHOTOS ET CLASSEMENT INTERACTIF -->
<section class="py-5">
    <div class="container">
        <!-- Filtres catégories -->
        <div class="d-flex flex-wrap justify-content-center gap-2 mb-5" data-aos="fade-up">
            <button class="btn btn-sm btn-dark rounded-0 font-serif active btn-filter-gallery" data-filter="all">Tout voir</button>
            <button class="btn btn-sm btn-outline-dark rounded-0 font-serif btn-filter-gallery" data-filter="patrimoine">Patrimoine & Masques</button>
            <button class="btn btn-sm btn-outline-dark rounded-0 font-serif btn-filter-gallery" data-filter="bronze">Bronze de Ouaga</button>
            <button class="btn btn-sm btn-outline-dark rounded-0 font-serif btn-filter-gallery" data-filter="sculpture">Sculptures de Laongo</button>
            <button class="btn btn-sm btn-outline-dark rounded-0 font-serif btn-filter-gallery" data-filter="tissage">Bogolan & Tissage</button>
            <button class="btn btn-sm btn-outline-dark rounded-0 font-serif btn-filter-gallery" data-filter="musique">Musique Trad</button>
            <button class="btn btn-sm btn-outline-dark rounded-0 font-serif btn-filter-gallery" data-filter="danse">Danse</button>
        </div>

        <!-- Mosaïque Masonry -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="gallery-mosaic-container" data-aos="fade-up" data-aos-delay="100">
            <?php foreach ($photos as $ph): ?>
                <div class="col gallery-item-card" data-type="<?php echo htmlspecialchars($ph['type'] ?? 'all'); ?>">
                    <div class="card card-culture h-100 p-2">
                        <div class="position-relative overflow-hidden" style="height: 250px;">
                            <a href="<?php echo htmlspecialchars($ph['image']); ?>" data-lightbox="virtual-museum" data-title="<?php echo htmlspecialchars($ph['titre']); ?>" class="d-block w-full h-full">
                                <img src="<?php echo htmlspecialchars($ph['image']); ?>" class="w-100 h-100 object-cover hover-scale" alt="Musée">
                            </a>
                            <span class="position-absolute bottom-2 left-2 badge bg-dark opacity-90 px-2 py-1 font-mono uppercase text-[9px]">
                                <i class="fa-solid fa-camera me-1"></i> <?php echo htmlspecialchars($ph['type'] ?? 'Pièce d\'Art'); ?>
                            </span>
                        </div>
                        <div class="card-body p-3 text-center">
                            <h6 class="font-serif mb-1 h6 text-dark"><?php echo htmlspecialchars($ph['titre']); ?></h6>
                            <span class="text-[9px] text-muted font-mono block uppercase">Lié à : <?php echo htmlspecialchars($ph['evenement'] ?? 'Collection Publique'); ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- SCRIPTS LOCAL FILTRATION DE LA GALERIE EN JQUERY -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const filterBtns = document.querySelectorAll(".btn-filter-gallery");
        const galleryItems = document.querySelectorAll(".gallery-item-card");

        filterBtns.forEach(btn => {
            btn.addEventListener("click", function() {
                // Change boutons active
                filterBtns.forEach(b => {
                    b.classList.remove("active", "btn-dark");
                    b.classList.add("btn-outline-dark");
                });
                btn.classList.add("active", "btn-dark");
                btn.classList.remove("btn-outline-dark");

                const chosenFilter = btn.getAttribute("data-filter");

                galleryItems.forEach(item => {
                    const itemType = item.getAttribute("data-type");
                    if (chosenFilter === "all" || itemType === chosenFilter) {
                        item.style.display = "block";
                        // Ajouter une animation d'entrée
                        item.classList.add("animate-fade-in");
                    } else {
                        item.style.display = "none";
                    }
                });
            });
        });
    });
</script>

<?php
require_once '../includes/footer.php';
?>
