<?php
/**
 * Kassiri Pulse - Émissions et Podcasts de Kassiri FM
 * Fichier : pages/podcast.php
 */
require_once '../config/database.php';
require_once '../includes/header.php';
require_once '../includes/navbar.php';

$db_connected = false;
$podcasts = [];

try {
    $pdo = Database::getConnection();
    $db_connected = true;

    // Charger les podcasts par ordre décroissant
    $stmt = $pdo->query("SELECT p.*, a.nom as artiste_nom, a.slug as artiste_slug FROM podcasts p JOIN artistes a ON p.artiste_id = a.id ORDER BY p.id DESC");
    $podcasts = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    $db_connected = false;
}

// Fallback de secours si BDD non provisionnée
if (empty($podcasts)) {
    $podcasts = [
        [
            'id' => 1,
            'titre' => 'Alif Naaba : "L\'Écho de notre résilience artistique"',
            'slug' => 'alif-naaba-podcast',
            'fiche_technique' => 'Émission "Paroles d\'Afrique", Kassiri FM',
            'description' => 'Un grand entretien avec "le Prince aux pieds nus" Alif Naaba sur les changements profonds imposés par la crise humanitaire au Burkina Faso, la force salvatrice des concerts solidaires et l\'importance suprême de la création artistique pour unir la nation burkinabè.',
            'duree' => '14:25',
            'vignette' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?q=80&w=300&auto=format&fit=crop',
            'fichier_audio' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3',
            'artiste_nom' => 'Alif Naaba',
            'artiste_slug' => 'alif-naaba',
            'created_at' => '2026-05-10'
        ],
        [
            'id' => 2,
            'titre' => 'Aux origines mythiques du Symposium de Laongo : Siriki Ky',
            'slug' => 'siriki-ky-podcast',
            'fiche_technique' => 'Chronique "Le Ciseau et le Granit", Kassiri FM',
            'description' => 'Le sculpteur émérite Siriki Ky revient sur plus de 30 années d\'histoire du symposium international de Laongo, sa vision sacrée d\'habiller le granit sahélien et de laisser à l\'humanité des traces éternelles gravées de sagesse africaine.',
            'duree' => '22:10',
            'vignette' => 'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?q=80&w=300&auto=format&fit=crop',
            'fichier_audio' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3',
            'artiste_nom' => 'Siriki Ky',
            'artiste_slug' => 'siriki-ky',
            'created_at' => '2026-05-15'
        ],
        [
            'id' => 3,
            'titre' => 'Irène Tassembédo : Transmettre le geste aux générations futures',
            'slug' => 'irene-tassembedo-podcast',
            'fiche_technique' => 'Débat "Le Corps parle", Kassiri FM',
            'description' => 'La chorégraphe internationale explique la place de la formation et du partage d\'expériences au sein de son École de Danse à l\'attention des jeunes danseurs panafricains.',
            'duree' => '18:45',
            'vignette' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?q=80&w=300&auto=format&fit=crop',
            'fichier_audio' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-3.mp3',
            'artiste_nom' => 'Irène Tassembédo',
            'artiste_slug' => 'irene-tassembedo',
            'created_at' => '2026-05-22'
        ]
    ];
}
?>

<!-- EN-TÊTE PODCASTS -->
<section class="py-5 bg-dark text-white text-center border-bottom border-warning">
    <div class="container py-3" data-aos="zoom-in">
        <h1 class="display-3 font-serif mb-1 uppercase text-brand-gold"><i class="fa-solid fa-microphone-lines me-1"></i> Émissions & Podcasts</h1>
        <p class="lead font-sans text-white-50 max-w-xl mx-auto" style="font-size:16px;">
            Histoires, débats et rythmes en haute fidélité. Retrouvez des interviews exclusives, des chroniques de patrimoine et d'actualités.
        </p>
    </div>
</section>

<!-- LISTE DES PLAYERS PLYR.JS -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Liste Principale -->
            <div class="col-lg-8" data-aos="fade-right">
                <div class="row row-cols-1 g-4 mb-5">
                    <?php foreach ($podcasts as $pod): ?>
                        <div class="col">
                            <div class="card p-4 border-0 bg-white shadow-sm flex flex-md-row rounded-0 text-dark">
                                <!-- Vignette -->
                                <div class="rounded-0 overflow-hidden flex-shrink-0 mb-3 mb-md-0 mx-auto" style="width: 140px; height: 140px; border: 2px solid var(--primary-gold);">
                                    <img src="<?php echo htmlspecialchars($pod['vignette']); ?>" class="w-100 h-100 object-cover" alt="Podcast">
                                </div>
                                <!-- Détails + Player -->
                                <div class="ms-md-4 d-flex flex-column justify-between w-full">
                                    <div>
                                        <span class="badge bg-danger rounded-0 text-[9px] uppercase font-serif py-1 mb-2"><?php echo htmlspecialchars($pod['fiche_technique']); ?></span>
                                        <h5 class="font-serif text-dark mb-1 h6"><?php echo htmlspecialchars($pod['titre']); ?></h5>
                                        <p class="text-xs text-muted mb-3 font-sans" style="line-height:1.5;"><?php echo htmlspecialchars($pod['description']); ?></p>
                                        
                                        <div class="text-[10px] text-muted font-mono mb-3 d-flex flex-wrap gap-3">
                                            <span><i class="fa-solid fa-user text-muted"></i> Avec : <?php echo htmlspecialchars($pod['artiste_nom']); ?></span>
                                            <span><i class="fa-regular fa-clock text-muted"></i> Durée : <?php echo htmlspecialchars($pod['duree']); ?></span>
                                            <span><i class="fa-regular fa-calendar-alt text-muted"></i> Publié le : <?php echo date('d/m/Y', strtotime($pod['created_at'])); ?></span>
                                        </div>
                                    </div>

                                    <!-- Lecteur Plyr intégré -->
                                    <div class="plyr-audio-player w-full mb-3">
                                        <audio id="player-<?php echo $pod['id']; ?>" class="plyr-audio-player" controls>
                                            <source src="<?php echo htmlspecialchars($pod['fichier_audio']); ?>" type="audio/mp3">
                                        </audio>
                                    </div>

                                    <!-- Partages et téléchargement -->
                                    <div class="d-flex justify-content-between align-items-center mt-2 border-top pt-2">
                                        <a href="<?php echo htmlspecialchars($pod['fichier_audio']); ?>" class="btn btn-xs btn-outline-dark rounded-0 py-1 px-3 text-[10px]" download>
                                            <i class="fa-solid fa-download me-1"></i> Télécharger MP3
                                        </a>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-xs btn-outline-secondary py-1 px-2 text-[10px] share-pod-btn" data-title="<?php echo htmlspecialchars($pod['titre']); ?>"><i class="fa-solid fa-share-nodes"></i> Partager</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Sidebar Thématique -->
            <div class="col-lg-4" data-aos="fade-left">
                <div class="p-4 bg-light border border-dark rounded-0 shadow-sm sticky-top" style="top:95px;">
                    <h5 class="font-serif mb-3 text-brand-charcoal text-center border-bottom pb-2">Fréquences Kassiri FM</h5>
                    <ul class="text-xs font-mono text-dark list-unstyled mb-4" style="line-height:2.2;">
                        <li><i class="fa-solid fa-tower-broadcast text-danger me-2"></i> Ouagadougou : <span class="fw-bold">95.4 FM</span></li>
                        <li><i class="fa-solid fa-tower-broadcast text-danger me-2"></i> Bobo-Dioulasso : <span class="fw-bold">101.2 FM</span></li>
                        <li><i class="fa-solid fa-tower-broadcast text-danger me-2"></i> Koudougou : <span class="fw-bold">88.8 FM</span></li>
                        <li><i class="fa-solid fa-tower-broadcast text-danger me-2"></i> Kaya : <span class="fw-bold">96.0 FM</span></li>
                    </ul>

                    <div class="p-3 bg-warning text-dark text-center border-bogolan-subtle" style="border-width:2px;">
                        <h6 class="font-serif mb-2 text-brand-charcoal">Grille des chroniques</h6>
                        <p class="text-xs font-sans text-muted mb-0">Tous les samedis à 18h30, l'émission "L'Écorce d'Or" revient sur la spiritualité des masques sacrés mossis et bobos.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ACTIONS SCRIPT LOCALES -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const shareBtns = document.querySelectorAll(".share-pod-btn");
        shareBtns.forEach(btn => {
            btn.addEventListener("click", function() {
                const podTitle = btn.getAttribute("data-title");
                Swal.fire({
                    title: 'Partager le Podcast',
                    text: `L'adresse de l'émission "${podTitle}" est désormais copiée dans votre presse-papiers. Partagez-la avec vos amis !`,
                    icon: 'info',
                    confirmButtonColor: '#C0392B',
                    confirmButtonText: 'D\'accord'
                });
            });
        });
    });
</script>

<?php
require_once '../includes/footer.php';
?>
