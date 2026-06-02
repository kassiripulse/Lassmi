<?php
/**
 * Kassiri Pulse - page-detail d'un artiste culturel
 * Fichier : pages/artiste.php
 */
require_once '../config/database.php';
require_once '../includes/header.php';
require_once '../includes/navbar.php';

$slug = isset($_GET['slug']) ? htmlspecialchars($_GET['slug']) : 'alif-naaba';

$db_connected = false;
$art = null;
$evenements = [];

try {
    $pdo = Database::getConnection();
    $db_connected = true;

    // Charger l'artiste
    $stmt = $pdo->prepare("SELECT * FROM artistes WHERE slug = ?");
    $stmt->execute([$slug]);
    $art = $stmt->fetch();

    if ($art) {
        // Charger les événements liés
        $stmt_ev = $pdo->prepare("SELECT e.*, c.nom as categorie, c.couleur FROM evenements e JOIN categories c ON e.categorie_id = c.id WHERE e.artiste_id = ? ORDER BY e.date_debut ASC");
        $stmt_ev->execute([$art['id']]);
        $evenements = $stmt_ev->fetchAll();
    }
} catch (Exception $e) {
    $db_connected = false;
}

// Fallback Mock de secours si pas de base de données active
if (!$art) {
    $art = [
        'id' => 1,
        'nom' => 'Alif Naaba',
        'slug' => 'alif-naaba',
        'photo' => 'https://images.unsplash.com/photo-1549834185-bd9f078a5dfe?q=80&w=600&auto=format&fit=crop',
        'biographie' => 'Surnommé "Le Prince aux pieds nus", Alif Naaba est un auteur-compositeur-interprète burkinabè incontournable. Sa voix chaude et ses mélodies mêlent afro-pop, jazz et musique traditionnelle moaga (Peuple Mossi). Originaire de Koudougou, il chante l\'espoir, la paix et le quotidien de son peuple.',
        'discipline' => 'Musique (Afro-Fusion / Folk)',
        'ville' => 'Ouagadougou',
        'facebook' => 'https://facebook.com/alifnaaba',
        'instagram' => 'https://instagram.com/alifnaaba',
        'youtube' => 'https://youtube.com/alifnaaba',
        'site_web' => 'http://www.alifnaaba.com'
    ];

    $evenements = [
        ['id' => 5, 'titre' => 'Jazz à Ouaga 2026 — Club du Sahel', 'slug' => 'jazz-ouaga-2026', 'lieu' => 'CENASA', 'ville' => 'Ouagadougou', 'image' => 'https://images.unsplash.com/photo-1486591978090-58e619d37fe7?q=80&w=800&auto=format&fit=crop', 'prix_normal' => 3000, 'date_debut' => '2026-06-15 19:30:00', 'categorie' => 'Musique', 'couleur' => '#C0392B']
    ];
}
?>

<!-- EN-TÊTE PROFIL ARTISTE -->
<section class="py-5 bg-dark text-white border-bottom border-warning" style="background-image: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.85)), url('<?php echo htmlspecialchars($art['photo']); ?>'); background-size: cover; background-position: center;">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-md-3 text-center text-md-start mb-4 mb-md-0" data-aos="zoom-in">
                <div class="rounded-circle overflow-hidden mx-auto mx-md-0 border border-4 border-warning shadow-lg" style="width: 200px; height: 200px;">
                    <img src="<?php echo htmlspecialchars($art['photo']); ?>" class="w-100 h-100 object-cover" alt="<?php echo htmlspecialchars($art['nom']); ?>">
                </div>
            </div>
            <div class="col-md-9 text-center text-md-start" data-aos="fade-left">
                <span class="badge bg-danger font-serif uppercase tracking-wider px-3 py-2 mb-2"><?php echo htmlspecialchars($art['discipline']); ?></span>
                <h1 class="display-4 font-serif text-white fw-bold mb-1"><?php echo htmlspecialchars($art['nom']); ?></h1>
                <p class="font-mono text-warning text-sm mb-3">
                    <i class="fa-solid fa-map-pins me-1"></i> Origine locale : <?php echo htmlspecialchars($art['ville']); ?>, Burkina Faso
                </p>
                <!-- Réseaux Sociaux -->
                <div class="d-flex gap-2 justify-content-center justify-content-md-start">
                    <?php if (!empty($art['facebook'])): ?>
                        <a href="<?php echo htmlspecialchars($art['facebook']); ?>" class="btn btn-sm btn-outline-warning rounded-circle" target="_blank" style="width:36px; height:36px; padding:6px;"><i class="fa-brands fa-facebook-f"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($art['instagram'])): ?>
                        <a href="<?php echo htmlspecialchars($art['instagram']); ?>" class="btn btn-sm btn-outline-warning rounded-circle" target="_blank" style="width:36px; height:36px; padding:6px;"><i class="fa-brands fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($art['youtube'])): ?>
                        <a href="<?php echo htmlspecialchars($art['youtube']); ?>" class="btn btn-sm btn-outline-warning rounded-circle" target="_blank" style="width:36px; height:36px; padding:6px;"><i class="fa-brands fa-youtube"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($art['site_web'])): ?>
                        <a href="<?php echo htmlspecialchars($art['site_web']); ?>" class="btn btn-sm btn-outline-warning rounded-circle" target="_blank" style="width:36px; height:36px; padding:6px;"><i class="fa-solid fa-globe"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- BIOGRAPHIE & ÉVÉNEMENTS LIÉS -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Biographie -->
            <div class="col-lg-8" data-aos="fade-right">
                <h3 class="font-serif border-bottom pb-2 mb-3 text-brand-charcoal">Biographie de l'artiste</h3>
                <p class="font-sans text-dark lead-xs" style="line-height:1.75;"><?php echo nl2br(htmlspecialchars($art['biographie'])); ?></p>
            </div>

            <!-- Événements associés -->
            <div class="col-lg-4 mt-5 mt-lg-0" data-aos="fade-left">
                <div class="p-4 bg-white border border-warning" style="border-width:2px;">
                    <h5 class="font-serif mb-3 text-brand-charcoal border-bottom pb-2">Scènes & Concerts liés</h5>
                    
                    <?php if (empty($evenements)): ?>
                        <p class="text-xs text-muted font-sans mb-0">Aucun concert ou représentation n'est planifié pour le moment.</p>
                    <?php else: ?>
                        <div class="row row-cols-1 g-3">
                            <?php foreach ($evenements as $ev): ?>
                                <div class="col">
                                    <div class="card p-3 border-0 bg-light shadow-sm">
                                        <span class="badge text-white px-2 py-1 uppercase text-[9px] mb-2 align-self-start" style="background-color: <?php echo htmlspecialchars($ev['couleur']); ?>;">
                                            <?php echo htmlspecialchars($ev['categorie']); ?>
                                        </span>
                                        <h6 class="font-serif text-dark mb-1 h6"><?php echo htmlspecialchars($ev['titre']); ?></h6>
                                        <div class="text-[10px] font-mono text-muted mb-2">
                                            <i class="fa-regular fa-calendar-check text-muted"></i> <?php echo date('d M Y', strtotime($ev['date_debut'])); ?>
                                        </div>
                                        <a href="evenement.php?slug=<?php echo htmlspecialchars($ev['slug']); ?>" class="btn btn-sm btn-kassiri py-1 text-center text-xs w-full">Consulter la scène</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once '../includes/footer.php';
?>
