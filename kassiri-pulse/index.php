<?php
/**
 * KASSIRI PULSE — ACCUEIL CULTUREL
 * Fichier : index.php
 */
$page_title = "Le Pouls Culturel du Burkina Faso";
$page_desc = "Portail officiel de la musique, des danses traditionnelles, du cinéma, du théâtre et des festivals de l'Afrique sahélienne.";

// Charger la BDD et le Header commun
require_once 'config/database.php';
require_once 'includes/header.php';
require_once 'includes/navbar.php';

// Liaison BDD PDO sécurisée (Simulation de données en cas de non configuration SQL chez l'utilisateur)
$db_connected = false;
$evenements = [];
$artistes = [];
$podcasts = [];

try {
    $pdo = Database::getConnection();
    $db_connected = true;
    
    // Charger les événements à l'affiche (Vedettes)
    $stmt_ev = $pdo->query("SELECT e.*, c.nom as categorie, c.couleur, c.icone FROM evenements e JOIN categories c ON e.categorie_id = c.id WHERE e.statut='actif' ORDER BY e.vues DESC LIMIT 6");
    $evenements = $stmt_ev->fetchAll();

    // Charger les artistes
    $stmt_art = $pdo->query("SELECT * FROM artistes LIMIT 8");
    $artistes = $stmt_art->fetchAll();

    // Charger les derniers podcasts
    $stmt_pod = $pdo->query("SELECT p.*, a.nom as artiste FROM podcasts p JOIN artistes a ON p.artiste_id = a.id ORDER BY p.id DESC LIMIT 4");
    $podcasts = $stmt_pod->fetchAll();

} catch (Exception $e) {
    // Si la base de données n'est pas encore provisionnée sur Hostinger, on utilise des structures sécurisées de repli (Mock) pour le design
    $db_connected = false;
}

// Données de repli (Mocks réalistes identiques pour éviter les erreurs de déploiement)
if (!$db_connected || empty($evenements)) {
    // Ces données seront affichées si l'utilisateur n'a pas encore configuré sa base de données MySQL
    $evenements = [
        [
            'id' => 1, 'titre' => 'SIAO 2026 — Salon International de l\'Artisanat de Ouagadougou', 'slug' => 'siao-2026', 'lieu' => 'Parc des Expositions SIAO', 'ville' => 'Ouagadougou',
            'image' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?q=80&w=800&auto=format&fit=crop', 'prix_normal' => 2000, 'prix_vip' => 10000, 'date_debut' => '2026-10-30 08:00:00',
            'categorie' => 'Festivals', 'couleur' => '#D4A017', 'icone' => 'Sparkles', 'description' => 'Le plus grand rassemblement de l\'artisanat d\'art.'
        ],
        [
            'id' => 2, 'titre' => 'FESPACO 2027 — Édition Spéciale de Lancement Faso', 'slug' => 'fespaco-2027', 'lieu' => 'Ciné Burkina', 'ville' => 'Ouagadougou',
            'image' => 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=800&auto=format&fit=crop', 'prix_normal' => 1500, 'prix_vip' => 5000, 'date_debut' => '2026-12-05 09:00:00',
            'categorie' => 'Cinéma', 'couleur' => '#1A1A1A', 'icone' => 'Film', 'description' => 'Célébrez l\'histoire fantastique du cinéma panafricain.'
        ],
        [
            'id' => 6, 'titre' => 'Concert Solidaire Smarty : L\'Écho de la Paix', 'slug' => 'smarty-echo-paix', 'lieu' => 'Maison de la Culture', 'ville' => 'Bobo-Dioulasso',
            'image' => 'https://images.unsplash.com/photo-1459749411175-04bf5292ceea?q=80&w=800&auto=format&fit=crop', 'prix_normal' => 2000, 'prix_vip' => 5000, 'date_debut' => '2026-06-28 20:00:00',
            'categorie' => 'Musique', 'couleur' => '#C0392B', 'icone' => 'Music', 'description' => 'Une nuit d\'union patriotique pour la paix au Faso.'
        ],
        [
            'id' => 12, 'titre' => 'Le Grand Kundé d\'Or Floby à Koudougou', 'slug' => 'floby-koudougou', 'lieu' => 'Place de la Nation', 'ville' => 'Koudougou',
            'image' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?q=80&w=800&auto=format&fit=crop', 'prix_normal' => 1000, 'prix_vip' => 5000, 'date_debut' => '2026-06-10 19:00:00',
            'categorie' => 'Musique', 'couleur' => '#C0392B', 'icone' => 'Music', 'description' => 'Un spectacle à couper le souffle.'
        ]
    ];

    $artistes = [
        ['id' => 1, 'nom' => 'Alif Naaba', 'slug' => 'alif-naaba', 'photo' => 'https://images.unsplash.com/photo-1549834185-bd9f078a5dfe?q=80&w=300&auto=format&fit=crop', 'discipline' => 'Musique / Folk', 'ville' => 'Ouagadougou'],
        ['id' => 2, 'nom' => 'Smarty', 'slug' => 'smarty', 'photo' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?q=80&w=300&auto=format&fit=crop', 'discipline' => 'Rap / Hip-Hop', 'ville' => 'Ouagadougou'],
        ['id' => 3, 'nom' => 'Siriki Ky', 'slug' => 'siriki-ky', 'photo' => 'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?q=80&w=300&auto=format&fit=crop', 'discipline' => 'Sculpture', 'ville' => 'Laongo'],
        ['id' => 4, 'nom' => 'Irène Tassembédo', 'slug' => 'irene-tassembedo', 'photo' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?q=80&w=300&auto=format&fit=crop', 'discipline' => 'Danse Contemporaine', 'ville' => 'Ouagadougou']
    ];

    $podcasts = [
        ['id' => 1, 'titre' => 'Alif Naaba : "L\'Écho de notre résilience"', 'slug' => 'alif-naaba-podcast', 'duree' => '14:25', 'artiste' => 'Alif Naaba', 'image' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?q=80&w=200&auto=format&fit=crop', 'fichier_audio' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3', 'description' => 'La voix citoyenne face aux bouleversements.'],
        ['id' => 2, 'titre' => 'Aux origines de Laongo : Siriki Ky', 'slug' => 'siriki-ky-podcast', 'duree' => '22:10', 'artiste' => 'Siriki Ky', 'image' => 'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?q=80&w=200&auto=format&fit=crop', 'fichier_audio' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3', 'description' => 'Sculpter le granit sahélien.']
    ];
}
?>

<!-- 1. HERO CAROUSEL SWIPER - À L'AFFICHE -->
<section class="position-relative swiper-hero overflow-hidden">
    <div class="swiper-container swiper-hero-container w-full h-full">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide hero-slide h-full" style="background-image: url('https://images.unsplash.com/photo-1513519245088-0e12902e5a38?q=80&w=1600&auto=format&fit=crop');">
                <div class="hero-overlay"></div>
                <div class="container h-full flex items-center">
                    <div class="hero-content max-w-2xl" data-aos="fade-up">
                        <span class="badge bg-danger font-serif uppercase py-2 px-3 mb-3">Grand Festival</span>
                        <h1 class="display-3 text-white mb-3">SIAO 2026</h1>
                        <p class="lead text-white-50 font-sans mb-4">Découvrez la quintessence de la créativité artisanale panafricaine à Ouagadougou. Des créations d'art en bronze, des bogolans raffinés et de la maroquinerie fine.</p>
                        <a href="evenement/siao-2026" class="btn btn-kassiri-gold text-uppercase px-4">Prendre mon billet</a>
                    </div>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="swiper-slide hero-slide h-full" style="background-image: url('https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=1600&auto=format&fit=crop');">
                <div class="hero-overlay"></div>
                <div class="container h-full flex items-center">
                    <div class="hero-content max-w-2xl">
                        <span class="badge bg-success font-serif uppercase py-2 px-3 mb-3">Cinéma Panafricain</span>
                        <h1 class="display-3 text-white mb-3">FESPACO 2027</h1>
                        <p class="lead text-white-50 font-sans mb-4">Célébrons le triomphe du cinéma d'Afrique pour sa 55ème année d'existence culturelle majeure dans les salles de classe populaire.</p>
                        <a href="evenement/fespaco-2027" class="btn btn-kassiri-gold text-uppercase px-4">Projections de plein air</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pagination & Navigation boutons -->
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev text-white"></div>
        <div class="swiper-button-next text-white"></div>
    </div>
</section>

<!-- 2. COMPTE À REBOURS ÉVÉNEMENT IMMINENT (FLOby À KOUDOUGOU) -->
<section class="py-4 bg-dark text-white position-relative" style="background-color: var(--dark-charcoal) !important;">
    <div class="container">
        <div class="row align-items-center justify-between border-bogolan-subtle pb-3" style="border-width: 2px;">
            <div class="col-md-5 mb-3 mb-md-0 d-flex align-items-center" data-aos="fade-right">
                <div class="bg-danger p-3 text-center me-3 font-serif line-height-1" style="width: 70px; height: 75px; border: 2px solid var(--primary-gold);">
                    <span class="h3 block fw-bold mb-0">10</span>
                    <span class="text-xs text-uppercase block font-mono">JUIN</span>
                </div>
                <div>
                    <h5 class="font-serif mb-1 text-warning">Roi Floby à Koudougou !</h5>
                    <span class="text-xs text-white-50 font-mono"><i class="fa-solid fa-map-pin me-1"></i> Place de la Nation de Koudougou</span>
                </div>
            </div>
            <div class="col-md-6 text-center text-md-end" data-aos="fade-left">
                <div class="d-inline-flex gap-3 font-mono" id="countdown-wrapper">
                    <div class="text-center bg-black p-2 border border-warning" style="min-width: 65px;">
                        <span class="block h4 fw-bold mb-0 text-brand-gold" id="days">08</span>
                        <span class="text-[9px] uppercase text-white-50">Jours</span>
                    </div>
                    <div class="text-center bg-black p-2 border border-warning" style="min-width: 65px;">
                        <span class="block h4 fw-bold mb-0 text-brand-gold" id="hours">14</span>
                        <span class="text-[9px] uppercase text-white-50">Heures</span>
                    </div>
                    <div class="text-center bg-black p-2 border border-warning" style="min-width: 65px;">
                        <span class="block h4 fw-bold mb-0 text-brand-gold" id="minutes">22</span>
                        <span class="text-[9px] uppercase text-white-50">Min</span>
                    </div>
                    <div class="text-center bg-black p-2 border border-warning" style="min-width: 65px;">
                        <span class="block h4 fw-bold mb-0 text-brand-gold" id="seconds">55</span>
                        <span class="text-[9px] uppercase text-white-50">Sec</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. GRILLE DE COMPOSITIONS PAR CATÉGORIES -->
<section class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="font-serif text-brand-charcoal" data-aos="fade-up">Disciplines Artistiques</h2>
        <p class="text-muted font-sans text-xs uppercase tracking-widest mb-4">Au cœur des vibrations sahéliennes</p>
        
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-3 mt-2" data-aos="fade-up" data-aos-delay="100">
            <div class="col">
                <a href="categorie/musique" class="card card-culture p-4 d-block text-decoration-none text-dark hover-gold">
                    <i class="fa-solid fa-music text-danger display-5 mb-2"></i>
                    <h6 class="font-serif mb-0">Musique</h6>
                </a>
            </div>
            <div class="col">
                <a href="categorie/danse" class="card card-culture p-4 d-block text-decoration-none text-dark hover-gold">
                    <i class="fa-solid fa-fire text-success display-5 mb-2"></i>
                    <h6 class="font-serif mb-0">Danse</h6>
                </a>
            </div>
            <div class="col">
                <a href="categorie/arts-plastiques" class="card card-culture p-4 d-block text-decoration-none text-dark hover-gold">
                    <i class="fa-solid fa-palette text-warning display-5 mb-2"></i>
                    <h6 class="font-serif mb-0">Arts plastiques</h6>
                </a>
            </div>
            <div class="col">
                <a href="categorie/cinema" class="card card-culture p-4 d-block text-decoration-none text-dark hover-gold">
                    <i class="fa-solid fa-film text-dark display-5 mb-2"></i>
                    <h6 class="font-serif mb-0">Cinéma</h6>
                </a>
            </div>
            <div class="col">
                <a href="categorie/theatre" class="card card-culture p-4 d-block text-decoration-none text-dark hover-gold">
                    <i class="fa-solid fa-masks-theater text-danger display-5 mb-2"></i>
                    <h6 class="font-serif mb-0">Théâtre</h6>
                </a>
            </div>
            <div class="col">
                <a href="categorie/festivals" class="card card-culture p-4 d-block text-decoration-none text-dark hover-gold">
                    <i class="fa-solid fa-wand-magic-sparkles text-warning display-5 mb-2"></i>
                    <h6 class="font-serif mb-0">Festivals</h6>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- 4. NOTRE AGENDA - EXPÉRIMENTAL AVEC FILTRES JS -->
<section class="py-5" id="evenements">
    <div class="container">
        <div class="row align-items-end justify-between mb-4">
            <div class="col-lg-6" data-aos="fade-right">
                <h2 class="font-serif mb-1 text-brand-charcoal">Événements Culturels à Venir</h2>
                <span class="text-xs text-muted font-mono"><i class="fa-solid fa-circle-nodes me-1 text-success"></i> Filtres dynamiques en temps réel par ville et type</span>
            </div>
            <div class="col-lg-6 mt-3 mt-lg-0 d-flex justify-content-lg-end gap-2" data-aos="fade-left">
                <!-- Filtre par Ville -->
                <select id="filter-ville" class="form-select rounded-0 text-xs font-mono font-bold" style="width: 170px;">
                    <option value="">Toutes les Villes</option>
                    <option value="Ouagadougou">Ouagadougou</option>
                    <option value="Bobo-Dioulasso">Bobo-Dioulasso</option>
                    <option value="Koudougou">Koudougou</option>
                    <option value="Banfora">Banfora</option>
                    <option value="Kaya">Kaya</option>
                </select>
                <!-- Filtre par Categorie -->
                <select id="filter-cat" class="form-select rounded-0 text-xs font-mono font-bold" style="width: 170px;">
                    <option value="">Toutes Catégories</option>
                    <option value="musique">Musique</option>
                    <option value="danse">Danse</option>
                    <option value="arts-plastiques">Arts plastiques</option>
                    <option value="cinema">Cinéma</option>
                    <option value="theatre">Théâtre</option>
                    <option value="festivals">Festivals</option>
                </select>
            </div>
        </div>

        <div class="row g-4" id="events-grid-results" data-aos="fade-up">
            <?php foreach ($evenements as $ev): ?>
                <div class="col-lg-4 col-md-6 event-card-item" data-ville="<?php echo htmlspecialchars($ev['ville']); ?>" data-cat="<?php echo strtolower(htmlspecialchars($ev['categorie'])); ?>">
                    <div class="card card-culture h-100">
                        <div class="position-relative overflow-hidden" style="height: 200px;">
                            <img src="<?php echo htmlspecialchars($ev['image']); ?>" class="card-img-top w-100 h-100 object-cover" alt="<?php echo htmlspecialchars($ev['titre']); ?>">
                            <span class="position-absolute top-2 left-2 badge text-white px-2 py-1 uppercase text-[10px]" style="background-color: <?php echo htmlspecialchars($ev['couleur'] ?? '#1A1A1A'); ?>;">
                                <?php echo htmlspecialchars($ev['categorie']); ?>
                            </span>
                        </div>
                        <div class="card-body d-flex flex-column justify-between p-4">
                            <div>
                                <h5 class="card-title font-serif h6 mb-2"><?php echo htmlspecialchars($ev['titre']); ?></h5>
                                <p class="card-text text-xs text-muted mb-3"><?php echo htmlspecialchars(substr($ev['description'] ?? '', 0, 110)); ?>...</p>
                            </div>
                            <div class="border-top pt-3 font-mono text-[11px] text-muted">
                                <div class="mb-1"><i class="fa-regular fa-calendar text-danger me-1"></i> <?php echo date('d M Y', strtotime($ev['date_debut'])); ?></div>
                                <div class="mb-2"><i class="fa-solid fa-map-location-dot text-success me-1"></i> <?php echo htmlspecialchars($ev['ville']); ?> — <?php echo htmlspecialchars($ev['lieu']); ?></div>
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
    </div>
</section>

<!-- 5. ARTISTES VEDETTES DU FASO (SWIPER CAROUSEL) -->
<section class="py-5 bg-dark text-white position-relative overflow-hidden" id="artistes">
    <div class="container relative z-2">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="font-serif text-brand-gold">Gardiens de notre Patrimoine</h2>
            <p class="text-white-50 font-sans text-xs uppercase tracking-widest">Les têtes d'affiches culturelles</p>
        </div>

        <div class="swiper-container swiper-artistes-container overflow-hidden" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper">
                <?php foreach ($artistes as $art): ?>
                    <div class="swiper-slide h-auto">
                        <div class="card border-0 bg-transparent text-center h-100">
                            <div class="mx-auto rounded-circle overflow-hidden shadow-lg border border-3 border-warning mb-3" style="width:160px; height:160px;">
                                <img src="<?php echo htmlspecialchars($art['photo']); ?>" class="w-100 h-100 object-cover" alt="<?php echo htmlspecialchars($art['nom']); ?>">
                            </div>
                            <h5 class="font-serif text-warning mb-1"><?php echo htmlspecialchars($art['nom']); ?></h5>
                            <span class="text-xs text-brand-cream-muted uppercase font-mono tracking-wider"><?php echo htmlspecialchars($art['discipline']); ?></span>
                            <div class="text-muted text-[11px] font-sans mt-2"><i class="fa-solid fa-map-pin me-1"></i> <?php echo htmlspecialchars($art['ville']); ?></div>
                            <div class="mt-2 text-center">
                                <a href="artiste/<?php echo htmlspecialchars($art['slug']); ?>" class="btn btn-sm btn-outline-warning rounded-0 py-0 px-2 text-[10px]">Voir Profil</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Pagination Swiper -->
            <div class="swiper-artist-pagination text-center mt-4"></div>
        </div>
    </div>
</section>

<!-- 6. PODCASTS ET SIDEBAR - LECTEUR INTEGRÉ PLYR.JS -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Lectures Podcasts Principal -->
            <div class="col-lg-8" data-aos="fade-right">
                <h3 class="font-serif text-brand-charcoal pb-2 border-bottom border-danger">Derniers Podcasts de Kassiri FM</h3>
                <div class="row row-cols-1 g-3 mt-3">
                    <?php foreach ($podcasts as $pod): ?>
                        <div class="col card p-3 border-0 bg-white shadow-sm flex flex-md-row g-3">
                            <div class="rounded overflow-hidden flex-shrink-0 mb-3 mb-md-0" style="width: 120px; height: 120px;">
                                <img src="<?php echo htmlspecialchars($pod['image']); ?>" class="w-full h-full object-cover" alt="Podcast">
                            </div>
                            <div class="ms-md-3 d-flex flex-column justify-between w-full">
                                <div>
                                    <h5 class="font-serif h6 text-dark"><?php echo htmlspecialchars($pod['titre']); ?></h5>
                                    <p class="text-xs text-muted mb-2 font-sans"><?php echo htmlspecialchars($pod['description'] ?? ''); ?></p>
                                    <div class="text-[10px] font-mono text-muted mb-2">
                                        <span><i class="fa-solid fa-microphone me-1"></i> <?php echo htmlspecialchars($pod['artiste']); ?></span>
                                        <span class="mx-2">|</span>
                                        <span><i class="fa-regular fa-clock me-1"></i> Durée : <?php echo htmlspecialchars($pod['duree']); ?></span>
                                    </div>
                                </div>
                                <!-- Lecteur plyr -->
                                <div class="plyr-audio-player w-full mt-2">
                                    <audio controls>
                                        <source src="<?php echo htmlspecialchars($pod['fichier_audio']); ?>" type="audio/mp3">
                                    </audio>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Sidebar tendances -->
            <div class="col-lg-4 mt-5 mt-lg-0" data-aos="fade-left">
                <div class="p-4 bg-white border border-danger-subtle card">
                    <h5 class="font-serif mb-3 text-brand-charcoal text-center border-bottom pb-2">Burkina Faso en Chiffres</h5>
                    <div class="row row-cols-2 text-center g-3 mt-1">
                        <div class="col border-end border-bottom pb-3">
                            <h3 class="text-danger font-serif fw-bold block mb-0">15+</h3>
                            <span class="text-[9px] uppercase font-mono text-muted">Festivals Actifs</span>
                        </div>
                        <div class="col border-bottom pb-3">
                            <h3 class="text-success font-serif fw-bold block mb-0">8</h3>
                            <span class="text-[9px] uppercase font-mono text-muted">Artistes Phares</span>
                        </div>
                        <div class="col border-end pt-3">
                            <h3 class="text-warning font-serif fw-bold block mb-0">20+</h3>
                            <span class="text-[9px] uppercase font-mono text-muted">Billets Vendus</span>
                        </div>
                        <div class="col pt-3">
                            <h3 class="text-dark font-serif fw-bold block mb-0">5</h3>
                            <span class="text-[9px] uppercase font-mono text-muted">Podcasts FM</span>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-warning-subtle text-dark border border-warning mt-4 card">
                    <h5 class="font-serif mb-2"><i class="fa-solid fa-radio text-danger me-1 animate-pulse"></i> Radio Kassiri FM</h5>
                    <p class="text-xs font-sans text-muted mb-3">En direct de Ouaga, écoutez les rythmes légendaires Mossi, Mandingue et Peulh mêlés à l'Afropop.</p>
                    <a href="radio" class="btn btn-sm btn-dark w-full font-serif text-xs">Écouter en Direct l'Antenne</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Logic de compte à rebours JS local à la page -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Compte à rebours pour Floby le 10 Juin 2026 UTC
        const targetDate = new Date("2026-06-10T19:00:00Z").getTime();
        
        function updateClock() {
            const now = new Date().getTime();
            const difference = targetDate - now;
            
            if (difference < 0) {
                document.getElementById("countdown-wrapper").innerHTML = "<div class='text-danger font-serif'>L'événement a commencé !</div>";
                return;
            }
            
            const days = Math.floor(difference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((difference % (1000 * 60)) / 1000);
            
            document.getElementById("days").innerText = days.toString().padStart(2, '0');
            document.getElementById("hours").innerText = hours.toString().padStart(2, '0');
            document.getElementById("minutes").innerText = minutes.toString().padStart(2, '0');
            document.getElementById("seconds").innerText = seconds.toString().padStart(2, '0');
        }
        
        updateClock();
        setInterval(updateClock, 1000);

        // GESTION DU FILTRAGE DES CARTES FRONT EN VANILLA JS
        const filterVille = document.getElementById("filter-ville");
        const filterCat = document.getElementById("filter-cat");
        const eventCards = document.querySelectorAll(".event-card-item");

        function applyCardsFilter() {
            const selectedVille = filterVille.value;
            const selectedCat = filterCat.value.toLowerCase();

            eventCards.forEach(card => {
                const cardVille = card.getAttribute("data-ville");
                const cardCat = card.getAttribute("data-cat");

                const matchVille = selectedVille === "" || cardVille === selectedVille;
                const matchCat = selectedCat === "" || cardCat.includes(selectedCat);

                if (matchVille && matchCat) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        }

        if (filterVille && filterCat) {
            filterVille.addEventListener("change", applyCardsFilter);
            filterCat.addEventListener("change", applyCardsFilter);
        }
    });
</script>

<?php
// Charger le Footer commun
require_once 'includes/footer.php';
?>
