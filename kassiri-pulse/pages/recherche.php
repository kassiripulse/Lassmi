<?php
/**
 * Kassiri Pulse - Page de Recherche Globale
 * Fichier : pages/recherche.php
 */
require_once '../config/database.php';
require_once '../includes/header.php';
require_once '../includes/navbar.php';

$query = isset($_GET['q']) ? trim(htmlspecialchars($_GET['q'])) : '';

$db_connected = false;
$evenements = [];
$artistes = [];

try {
    $pdo = Database::getConnection();
    $db_connected = true;

    if (!empty($query)) {
        // Rechercher Événements
        $stmt_ev = $pdo->prepare("SELECT e.*, c.nom as categorie, c.couleur 
                                  FROM evenements e 
                                  JOIN categories c ON e.categorie_id = c.id 
                                  WHERE e.titre LIKE ? OR e.description LIKE ? OR e.ville LIKE ?");
        $like_query = '%' . $query . '%';
        $stmt_ev->execute([$like_query, $like_query, $like_query]);
        $evenements = $stmt_ev->fetchAll();

        // Rechercher Artistes
        $stmt_art = $pdo->prepare("SELECT * FROM artistes WHERE nom LIKE ? OR biographie LIKE ? OR discipline LIKE ?");
        $stmt_art->execute([$like_query, $like_query, $like_query]);
        $artistes = $stmt_art->fetchAll();
    }
} catch (Exception $e) {
    $db_connected = false;
}

// Fallback Mock de secours si pas de base de données active
if (!$db_connected && !empty($query)) {
    // Liste fictive
    $all_mock_events = [
        ['id' => 1, 'titre' => 'SIAO 2026 — Salon International de l\'Artisanat de Ouagadougou', 'slug' => 'siao-2026', 'lieu' => 'Parc des Expositions SIAO', 'ville' => 'Ouagadougou', 'category' => 'Festivals', 'couleur' => '#D4A017', 'image' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?q=80&w=800&auto=format&fit=crop', 'prix_normal' => 2000, 'date_debut' => '2026-10-30 08:00:00', 'description' => 'Le plus grand rassemblement de l\'artisanat d\'art.'],
        ['id' => 12, 'titre' => 'Le Grand Kundé d\'Or Floby à Koudougou', 'slug' => 'floby-koudougou', 'lieu' => 'Place de la Nation', 'ville' => 'Koudougou', 'category' => 'Musique', 'couleur' => '#C0392B', 'image' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?q=80&w=800&auto=format&fit=crop', 'prix_normal' => 1000, 'date_debut' => '2026-06-10 19:00:00', 'description' => 'Le Roi Floby revient chanter la paix.']
    ];

    $all_mock_artists = [
        ['id' => 1, 'nom' => 'Alif Naaba', 'slug' => 'alif-naaba', 'photo' => 'https://images.unsplash.com/photo-1549834185-bd9f078a5dfe?q=80&w=300&auto=format&fit=crop', 'discipline' => 'Musique / Folk', 'ville' => 'Ouagadougou'],
        ['id' => 2, 'nom' => 'Smarty', 'slug' => 'smarty', 'photo' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?q=80&w=300&auto=format&fit=crop', 'discipline' => 'Rap / Hip-Hop', 'ville' => 'Ouagadougou']
    ];

    $evenements = array_filter($all_mock_events, function($e) use ($query) {
        return stripos($e['titre'], $query) !== false || stripos($e['description'], $query) !== false || stripos($e['ville'], $query) !== false;
    });

    $artistes = array_filter($all_mock_artists, function($a) use ($query) {
        return stripos($a['nom'], $query) !== false || stripos($a['discipline'], $query) !== false;
    });
}
?>

<!-- HEADER DE RECHERCHE -->
<section class="py-5 bg-light text-center border-bottom border-danger">
    <div class="container" data-aos="zoom-in">
        <h1 class="font-serif text-brand-charcoal mb-2"><i class="fa-solid fa-magnifying-glass me-2 text-danger"></i> Résultats de Recherche</h1>
        <p class="lead font-sans text-muted" style="font-size:15px;">Vous avez recherché : <strong class="text-danger">"<?php echo htmlspecialchars($query); ?>"</strong></p>
    </div>
</section>

<!-- RÉSULTATS -->
<section class="py-5">
    <div class="container">
        <!-- Section Événements -->
        <div class="row" data-aos="fade-up">
            <div class="col-12 mb-4">
                <h3 class="font-serif text-brand-charcoal border-bottom pb-2">Événements Correspondants (<?php echo count($evenements); ?>)</h3>
            </div>
            
            <?php if (empty($evenements)): ?>
                <div class="col-12 mb-5">
                    <p class="text-xs text-muted font-sans"><i class="fa-solid fa-triangle-exclamation me-1 text-warning"></i> Aucun événement culturel ne correspond à vos mots-clés.</p>
                </div>
            <?php else: ?>
                <?php foreach ($evenements as $ev): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card card-culture h-100">
                            <div class="position-relative overflow-hidden" style="height: 180px;">
                                <img src="<?php echo htmlspecialchars($ev['image']); ?>" class="card-img-top w-100 h-100 object-cover" alt="Image">
                            </div>
                            <div class="card-body p-4 d-flex flex-column justify-between">
                                <div>
                                    <h5 class="card-title font-serif h6 text-dark mb-2"><?php echo htmlspecialchars($ev['titre']); ?></h5>
                                    <p class="card-text text-xs text-muted mb-3"><?php echo htmlspecialchars(substr($ev['description'] ?? '', 0, 95)); ?>...</p>
                                </div>
                                <div class="border-top pt-3 font-mono text-[11px] text-muted">
                                    <div class="mb-1"><i class="fa-regular fa-calendar-check text-danger me-1"></i> <?php echo date('d M Y', strtotime($ev['date_debut'])); ?></div>
                                    <div class="mb-2"><i class="fa-solid fa-location-arrow text-success me-1"></i> <?php echo htmlspecialchars($ev['ville']); ?> — <?php echo htmlspecialchars($ev['lieu']); ?></div>
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-dark fw-bold"><?php echo $ev['prix_normal'] == 0 ? "Entrée Libre" : number_format($ev['prix_normal'], 0, ',', ' ') . " CFA"; ?></span>
                                        <a href="evenement.php?slug=<?php echo htmlspecialchars($ev['slug']); ?>" class="btn btn-sm btn-kassiri py-1 px-3" style="font-size:11px;">Consulter</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Section Artistes -->
        <div class="row mt-5" data-aos="fade-up">
            <div class="col-12 mb-4">
                <h3 class="font-serif text-brand-charcoal border-bottom pb-2">Artistes Correspondants (<?php echo count($artistes); ?>)</h3>
            </div>
            
            <?php if (empty($artistes)): ?>
                <div class="col-12 mb-5">
                    <p class="text-xs text-muted font-sans"><i class="fa-solid fa-triangle-exclamation me-1 text-warning"></i> Aucun profil d'artiste ne correspond à votre recherche.</p>
                </div>
            <?php else: ?>
                <?php foreach ($artistes as $art): ?>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card card-culture p-3 text-center h-100">
                            <div class="mx-auto rounded-circle overflow-hidden shadow-lg border border-3 border-warning mb-3" style="width:120px; height:120px;">
                                <img src="<?php echo htmlspecialchars($art['photo']); ?>" class="w-100 h-100 object-cover" alt="Artiste">
                            </div>
                            <h5 class="font-serif text-dark mb-1 h6"><?php echo htmlspecialchars($art['nom']); ?></h5>
                            <span class="text-[10px] text-success uppercase font-mono tracking-wider"><?php echo htmlspecialchars($art['discipline']); ?></span>
                            <div class="text-muted text-[10px] font-sans mt-2"><i class="fa-solid fa-map-marker-alt me-1"></i> <?php echo htmlspecialchars($art['ville']); ?></div>
                            <div class="mt-2 text-center">
                                <a href="artiste.php?slug=<?php echo htmlspecialchars($art['slug']); ?>" class="btn btn-sm btn-outline-danger rounded-0 py-0 px-2 text-[10px]">Voir Profil</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
require_once '../includes/footer.php';
?>
