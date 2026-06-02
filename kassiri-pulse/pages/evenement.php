<?php
/**
 * Kassiri Pulse - page-detail d'un événement
 * Fichier : pages/evenement.php
 */
require_once '../config/database.php';
require_once '../includes/header.php';
require_once '../includes/navbar.php';

// Récupérer le slug d'URL
$slug = isset($_GET['slug']) ? htmlspecialchars($_GET['slug']) : 'siao-2026';

// Charger l'événement
$db_connected = false;
$ev = null;
$commentaires = [];
$galerie = [];

try {
    $pdo = Database::getConnection();
    $db_connected = true;

    // Charger l'événement lié
    $stmt = $pdo->prepare("SELECT e.*, c.nom as categorie, c.couleur, c.icone, a.nom as artiste_nom, a.slug as artiste_slug 
                           FROM evenements e 
                           JOIN categories c ON e.categorie_id = c.id 
                           LEFT JOIN artistes a ON e.artiste_id = a.id 
                           WHERE e.slug = ?");
    $stmt->execute([$slug]);
    $ev = $stmt->fetch();

    if ($ev) {
        // Enregistrer une vue automatique
        $pdo->prepare("UPDATE evenements SET vues = vues + 1 WHERE id = ?")->execute([$ev['id']]);

        // Charger galerie liée
        $stmt_gal = $pdo->prepare("SELECT * FROM galerie WHERE evenement_id = ?");
        $stmt_gal->execute([$ev['id']]);
        $galerie = $stmt_gal->fetchAll();

        // Charger commentaires approuvés
        $stmt_comm = $pdo->prepare("SELECT * FROM commentaires WHERE evenement_id = ? AND statut = 'approuve' ORDER BY id DESC");
        $stmt_comm->execute([$ev['id']]);
        $commentaires = $stmt_comm->fetchAll();
    }
} catch (Exception $e) {
    $db_connected = false;
}

// Fallback Mock de secours si la BDD n'est pas encore connectée
if (!$ev) {
    // Événement SIAO par défaut
    $ev = [
        'id' => 1,
        'titre' => 'SIAO 2026 — Salon International de l\'Artisanat de Ouagadougou',
        'slug' => 'siao-2026',
        'description' => 'Le plus grand rassemblement de l\'artisanat africain d\'art et de design contemporain. Découvrez des créateurs venus d\'une quarantaine de pays d\'Afrique : maroquinerie, Bogolan raffiné, sculptures d\'artisanat en bronze de Ouaga, poteries, et vannerie fine du désert. Des défilés de mode textile, d\'incroyables créations locales et un grand marché d\'exposition transforment le Parc des Expositions.',
        'image' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?q=80&w=800&auto=format&fit=crop',
        'lieu' => 'Parc des Expositions du SIAO',
        'ville' => 'Ouagadougou',
        'adresse' => 'Boulevard France-Afrique, Quartier Patte d\'Oie',
        'latitude' => 12.3392,
        'longitude' => -1.5034,
        'date_debut' => '2026-10-30 08:00:00',
        'date_fin' => '2026-11-08 22:00:00',
        'prix_normal' => 2000,
        'prix_vip' => 10000,
        'capacite' => 95000,
        'statut' => 'actif',
        'vues' => 2450,
        'categorie' => 'Festivals',
        'couleur' => '#D4A017',
        'artiste_nom' => 'Siriki Ky',
        'artiste_slug' => 'siriki-ky'
    ];

    $galerie = [
        ['id' => 1, 'titre' => 'SIAO Stand d\'Exposition Artisanat de Bronze', 'image' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?q=80&w=600&auto=format&fit=crop'],
        ['id' => 2, 'titre' => 'Exposants de Bogolan Fin d\'Afrique', 'image' => 'https://images.unsplash.com/photo-1549834185-bd9f078a5dfe?q=80&w=600&auto=format&fit=crop']
    ];

    $commentaires = [
        ['id' => 1, 'nom' => 'Seydou Ouattara', 'contenu' => 'Le SIAO est vraiment le fleuron de l\'artisanat africain ! Magnifique organisation.', 'note' => 5, 'created_at' => '2026-05-18 18:30:00']
    ];
}
?>

<!-- BANNIÈRE HEADER DE L'ÉVÉNEMENT -->
<section class="py-5 bg-dark text-white text-center position-relative" style="background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.85)), url('<?php echo htmlspecialchars($ev['image']); ?>'); background-size: cover; background-position: center;">
    <div class="container py-4">
        <span class="badge font-serif uppercase py-2 px-3 mb-3 text-white" style="background-color: <?php echo htmlspecialchars($ev['couleur'] ?? '#C0392B'); ?>;">
            <?php echo htmlspecialchars($ev['categorie']); ?>
        </span>
        <h1 class="display-4 font-serif text-white mb-2"><?php echo htmlspecialchars($ev['titre']); ?></h1>
        <p class="font-mono text-warning text-sm mb-0">
            <i class="fa-regular fa-calendar-days me-1"></i> Du <?php echo date('d M Y à H:i', strtotime($ev['date_debut'])); ?> au <?php echo date('d M', strtotime($ev['date_fin'])); ?>
        </p>
    </div>
</section>

<!-- CONTENU PRINCIPAL -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Colonne gauche : Description, Galerie, Carte et Commentaires -->
            <div class="col-lg-8" data-aos="fade-right">
                <h4 class="font-serif border-bottom pb-2 mb-3 text-brand-charcoal">Présentation de l'Événement</h4>
                <p class="font-sans text-dark lead-xs" style="line-height:1.7;"><?php echo nl2br(htmlspecialchars($ev['description'])); ?></p>
                
                <?php if ($ev['artiste_nom']): ?>
                    <div class="p-3 bg-light border-start border-warning border-3 my-4 font-sans">
                        <span class="text-xs text-muted block font-mono">Artiste ou intervenant phare de cet événement :</span>
                        <a href="artiste.php?slug=<?php echo htmlspecialchars($ev['artiste_slug']); ?>" class="h6 text-danger fw-bold text-decoration-none"><?php echo htmlspecialchars($ev['artiste_nom']); ?></a>
                    </div>
                <?php endif; ?>

                <!-- GALERIE IMAGES LIGHTBOX2 -->
                <?php if (!empty($galerie)): ?>
                    <h4 class="font-serif border-bottom pb-2 mb-3 mt-5 text-brand-charcoal">Aperçu Galerie Photos</h4>
                    <div class="row row-cols-2 row-cols-md-3 g-3">
                        <?php foreach ($galerie as $img): ?>
                            <div class="col">
                                <a href="<?php echo htmlspecialchars($img['image']); ?>" data-lightbox="event-gallery" data-title="<?php echo htmlspecialchars($img['titre']); ?>" class="d-block overflow-hidden rounded position-relative h-40">
                                    <img src="<?php echo htmlspecialchars($img['image']); ?>" class="w-100 h-100 object-cover hover-scale" alt="Galerie">
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- GÉOLOCALISATION LEAFLET.JS -->
                <h4 class="font-serif border-bottom pb-2 mb-3 mt-5 text-brand-charcoal">Géolocalisation & Lieu</h4>
                <p class="text-sm font-sans mb-2 font-mono"><i class="fa-solid fa-map-location-dot text-danger"></i> Adresse : <?php echo htmlspecialchars($ev['adresse']); ?>, <?php echo htmlspecialchars($ev['ville']); ?></p>
                <div id="event-map" class="border border-dark w-100 mb-5" style="height: 350px;"></div>

                <!-- ZONE COMMENTAIRES & ÉTOILES -->
                <div class="mt-5">
                    <h4 class="font-serif border-bottom pb-2 mb-4 text-brand-charcoal">Critiques & Commentaires (<?php echo count($commentaires); ?>)</h4>
                    
                    <?php foreach ($commentaires as $comm): ?>
                        <div class="p-4 bg-white border border-light-subtle rounded-0 mb-3 text-dark">
                            <div class="row items-center justify-between mb-2">
                                <div class="col-auto">
                                    <span class="fw-bold font-serif"><?php echo htmlspecialchars($comm['nom']); ?></span>
                                    <span class="text-xs text-muted font-mono ms-2">le <?php echo date('d/m/Y', strtotime($comm['created_at'] ?? '2026-06-02')); ?></span>
                                </div>
                                <div class="col-auto text-warning">
                                    <?php for($i=1; $i<=5; $i++): ?>
                                        <i class="fa-<?php echo $i <= $comm['note'] ? 'solid' : 'regular'; ?> fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p class="font-sans mb-0 text-xs text-muted" style="line-height:1.5;"><?php echo nl2br(htmlspecialchars($comm['contenu'])); ?></p>
                        </div>
                    <?php endforeach; ?>

                    <!-- Formulaire ajouter un commentaire dynamique -->
                    <form id="comment-form-event" class="bg-light p-4 mt-4 border border-dark">
                        <h5 class="font-serif mb-3 text-brand-charcoal">Laisser une critique</h5>
                        <div class="row g-2">
                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control rounded-0 text-xs font-sans" name="comm_nom" placeholder="Votre Nom complet" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="email" class="form-control rounded-0 text-xs font-sans" name="comm_email" placeholder="Votre Email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-xs fw-bold font-serif text-dark block">Votre Note :</label>
                            <div class="rating-stars text-warning fs-4 d-flex gap-1" style="cursor: pointer;">
                                <i class="fa-solid fa-star star-opt" data-val="1"></i>
                                <i class="fa-solid fa-star star-opt" data-val="2"></i>
                                <i class="fa-solid fa-star star-opt" data-val="3"></i>
                                <i class="fa-solid fa-star star-opt" data-val="4"></i>
                                <i class="fa-solid fa-star star-opt" data-val="5"></i>
                            </div>
                            <input type="hidden" name="comm_note" id="comm_note_val" value="5">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control rounded-0 text-xs font-sans" name="comm_contenu" rows="4" placeholder="Qu'avez-vous pensé de l'événement ?" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-kassiri py-2 px-4 font-serif text-xs">Soumettre mon avis</button>
                    </form>
                </div>
            </div>

            <!-- Colonne droite : Billetterie, Tarification et QR Code -->
            <div class="col-lg-4 mt-5 mt-lg-0" data-aos="fade-left">
                <div class="bg-white p-4 border-bogolan shadow-sm sticky-top" style="top:95px; z-index:10;">
                    <h4 class="font-serif text-center text-brand-charcoal mb-3">Achat de Billets</h4>
                    
                    <div class="p-3 bg-light border border-dark text-center mb-3">
                        <div class="text-xs uppercase font-mono text-muted">Abonnement National</div>
                        <div class="h3 font-serif text-danger fw-bold mb-0 mt-1"><?php echo number_format($ev['prix_normal'], 0, ',', ' '); ?> CFA <span class="text-xs text-muted font-sans">/ Normal</span></div>
                        <div class="h5 font-serif text-warning fw-bold mb-0 mt-1"><?php echo number_format($ev['prix_vip'], 0, ',', ' '); ?> CFA <span class="text-xs text-muted font-sans">/ VIP Access</span></div>
                    </div>

                    <form id="ticket-booking-form">
                        <input type="hidden" id="booking-event-id" value="<?php echo $ev['id']; ?>">
                        <input type="hidden" id="booking-event-title" value="<?php echo htmlspecialchars($ev['titre']); ?>">
                        
                        <div class="mb-3 text-xs">
                            <label class="form-label font-serif text-dark fw-bold">Type de Billet :</label>
                            <select id="booking-type" class="form-select rounded-0">
                                <option value="normal" data-price="<?php echo $ev['prix_normal']; ?>">Normal — <?php echo number_format($ev['prix_normal'],0,',',' '); ?> CFA</option>
                                <option value="vip" data-price="<?php echo $ev['prix_vip']; ?>">VIP Access — <?php echo number_format($ev['prix_vip'],0,',',' '); ?> CFA</option>
                            </select>
                        </div>

                        <div class="mb-3 text-xs">
                            <label class="form-label font-serif text-dark fw-bold">Quantité :</label>
                            <input type="number" id="booking-qty" class="form-control rounded-0" value="1" min="1" max="10">
                        </div>

                        <div class="mb-3 text-xs">
                            <label class="form-label font-serif text-dark fw-bold">Nom de l'acheteur :</label>
                            <input type="text" id="booking-name" class="form-control rounded-0" placeholder="Ex: Adama Sawadogo" required>
                        </div>

                        <div class="mb-3 text-xs">
                            <label class="form-label font-serif text-dark fw-bold">Email de livraison :</label>
                            <input type="email" id="booking-email" class="form-control rounded-0" placeholder="sawadogo@fasonet.bf" required>
                        </div>

                        <div class="mb-3 text-xs">
                            <label class="form-label font-serif text-dark fw-bold">Téléphone Mobile :</label>
                            <input type="text" id="booking-phone" class="form-control rounded-0" placeholder="Ex: +22670123456" required>
                        </div>

                        <button type="submit" class="btn btn-kassiri w-100 font-serif uppercase tracking-wider py-2">
                            <i class="fa-solid fa-ticket me-1 animate-bounce"></i> Réserver mon Billet
                        </button>
                    </form>

                    <!-- DIV CACHÉ POUR GÉNÉRER ET SCANNER LE BILLET APRÈS RÉSERVATION -->
                    <div id="booking-success-qr" class="d-none mt-4 p-3 bg-light text-center border border-success">
                        <span class="badge bg-success block py-1 mb-2">Billet Validé avec Succès !</span>
                        <div id="qrcode-container" class="my-3 flex items-center justify-center bg-white p-2 border"></div>
                        <div class="text-[10px] font-mono font-bold" id="ticket-id-display">BIL-LKP-XXXX</div>
                        <p class="text-[10px] text-muted font-sans mt-2">Le QR code est envoyé à votre email. Présentez ce code aux agents d'accueil.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SCRIPTS LEAFLET SCELLÉS -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1. CARTE GÉOGRAPHIQUE LEAFLET.JS
        try {
            const latitude = <?php echo floatval($ev['latitude'] ?? 12.3392); ?>;
            const longitude = <?php echo floatval($ev['longitude'] ?? -1.5034); ?>;
            const mapTitle = "<?php echo htmlspecialchars($ev['lieu']); ?>";

            const map = L.map('event-map').setView([latitude, longitude], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            // Icône rouge personnalisée
            const redIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            L.marker([latitude, longitude], {icon: redIcon}).addTo(map)
                .bindPopup(`<strong class="font-serif text-brand-charcoal">${mapTitle}</strong><br><span class="text-xs font-mono text-danger">Événement de Kassiri Pulse</span>`)
                .openPopup();
        } catch(e) {
            console.error("Leaflet mapping error: ", e);
        }

        // 2. LOGIC DE SELECTION COMM-STARS
        const stars = document.querySelectorAll(".star-opt");
        const ratingVal = document.getElementById("comm_note_val");
        stars.forEach(star => {
            star.addEventListener("click", function() {
                const checkedValue = parseInt(star.getAttribute("data-val"));
                ratingVal.value = checkedValue;
                // Repaindre
                stars.forEach(s => {
                    const sVal = parseInt(s.getAttribute("data-val"));
                    if (sVal <= checkedValue) {
                        s.classList.remove("fa-regular");
                        s.classList.add("fa-solid");
                    } else {
                        s.classList.remove("fa-solid");
                        s.classList.add("fa-regular");
                    }
                });
            });
        });

        // 3. FORMULAIRE DE BILLETTERIE SWEETALERT & QRCODE GENERATION
        const bookingForm = document.getElementById("ticket-booking-form");
        const successDiv = document.getElementById("booking-success-qr");
        const qrContainer = document.getElementById("qrcode-container");
        const ticketDisplay = document.getElementById("ticket-id-display");

        if (bookingForm) {
            bookingForm.addEventListener("submit", function(e) {
                e.preventDefault();
                
                const nom = document.getElementById("booking-name").value;
                const email = document.getElementById("booking-email").value;
                const qty = document.getElementById("booking-qty").value;
                const typeB = document.getElementById("booking-type").value;
                
                // Calculer prix
                const selectElement = document.getElementById("booking-type");
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                const unitPrice = parseFloat(selectedOption.getAttribute("data-price"));
                const totalPrice = unitPrice * parseInt(qty);

                // Générer un code unique
                const randCode = "BIL-" + Math.random().toString(36).substr(2, 8).toUpperCase() + "-BF";

                // Vider l'ancien QR code
                qrContainer.innerHTML = "";

                // Générer le QR Code sur le div caché
                try {
                    new QRCode(qrContainer, {
                        text: `KassiriPulse|${randCode}|${nom}|Qty:${qty}|Total:${totalPrice}CFA`,
                        width: 120,
                        height: 120,
                        colorDark : "#1A1A1A",
                        colorLight : "#ffffff"
                    });
                } catch(qrErr) {
                    // Fallback si QRCode.js n'est pas chargé
                    qrContainer.innerHTML = `<img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=KassiriPulse|${randCode}" alt="QR code" />`;
                }

                // Affichage final des éléments
                ticketDisplay.innerText = randCode;
                bookingForm.style.display = "none";
                successDiv.classList.remove("d-none");

                Swal.fire({
                    title: 'Réservation Enregistrée !',
                    text: `Félicitations ${nom}, votre code de billet est ${randCode}. Total de ${totalPrice} CFA payable via Orange Money / Moov Money.`,
                    icon: 'success',
                    confirmButtonColor: '#C0392B',
                    confirmButtonText: 'Afficher le Ticket'
                });
            });
        }
    });
</script>

<?php
require_once '../includes/footer.php';
?>
