<?php
/**
 * Kassiri Pulse - Guichet Général de Billetterie Culturelle
 * Fichier : pages/billetterie.php
 */
require_once '../config/database.php';
require_once '../includes/header.php';
require_once '../includes/navbar.php';

$db_connected = false;
$evenements = [];

try {
    $pdo = Database::getConnection();
    $db_connected = true;

    // Charger les événements pour le dropdown
    $stmt = $pdo->query("SELECT id, titre, prix_normal, prix_vip, ville FROM evenements WHERE statut='actif' ORDER BY date_debut ASC");
    $evenements = $stmt->fetchAll();
} catch (Exception $e) {
    $db_connected = false;
}

// Fallback Mock de secours
if (empty($evenements)) {
    $evenements = [
        ['id' => 1, 'titre' => 'SIAO 2026 — Salon de l\'Artisanat (Ouagadougou)', 'prix_normal' => 2000, 'prix_vip' => 10000, 'ville' => 'Ouagadougou'],
        ['id' => 2, 'titre' => 'FESPACO 2027 — Lancement Cinéma (Ouagadougou)', 'prix_normal' => 1500, 'prix_vip' => 5000, 'ville' => 'Ouagadougou'],
        ['id' => 5, 'titre' => 'Jazz à Ouaga 2026 — Club du Sahel (Ouagadougou)', 'prix_normal' => 3000, 'prix_vip' => 7000, 'ville' => 'Ouagadougou'],
        ['id' => 12, 'titre' => 'Le Grand Kundé d\'Or Floby (Koudougou)', 'prix_normal' => 1000, 'prix_vip' => 5000, 'ville' => 'Koudougou']
    ];
}
?>

<!-- HEADER GUICHET -->
<section class="py-5 bg-dark text-white text-center border-bottom border-warning">
    <div class="container py-3" data-aos="zoom-in">
        <h1 class="display-3 font-serif mb-1 uppercase text-brand-gold"><i class="fa-solid fa-calculator me-2"></i> Guichet de Billetterie</h1>
        <p class="lead font-sans text-white-50 max-w-xl mx-auto" style="font-size:16px;">
            Achetez en 2 clics et de manière 100% sécurisée vos pass pour tous les événements majeurs du Burkina.
        </p>
    </div>
</section>

<!-- BUREAU DE VENTE -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7" data-aos="fade-right">
                <div class="bg-white p-5 border-bogolan shadow-sm mb-4">
                    <h4 class="font-serif text-brand-charcoal border-bottom pb-2 mb-4">Formulaire de Réservation Directe</h4>
                    
                    <form id="desk-billing-engine">
                        <!-- Sélection Événement -->
                        <div class="mb-3 text-xs">
                            <label class="form-label font-serif text-dark fw-bold">Sélectionnez l'Événement :</label>
                            <select id="desk-ev" class="form-select rounded-0 font-sans" required>
                                <option value="" disabled selected>Choisissez un événement...</option>
                                <?php foreach ($evenements as $ev): ?>
                                    <option value="<?php echo $ev['id']; ?>" 
                                            data-normal="<?php echo $ev['prix_normal']; ?>" 
                                            data-vip="<?php echo $ev['prix_vip']; ?>"
                                            data-title="<?php echo htmlspecialchars($ev['titre']); ?>">
                                        <?php echo htmlspecialchars($ev['titre']); ?> [Normal : <?php echo number_format($ev['prix_normal'],0,',',' '); ?> CFA]
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Type de place -->
                        <div class="mb-3 text-xs">
                            <label class="form-label font-serif text-dark fw-bold">Catégorie :</label>
                            <div class="d-flex gap-3 mt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="desk-type" id="type-norm" value="normal" checked>
                                    <label class="form-check-label text-dark" for="type-norm">Billet Normal</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="desk-type" id="type-vip" value="vip">
                                    <label class="form-check-label text-dark" for="type-vip">VIP Access</label>
                                </div>
                            </div>
                        </div>

                        <!-- Quantité -->
                        <div class="mb-3 text-xs">
                            <label class="form-label font-serif text-dark fw-bold">Nombre de places :</label>
                            <input type="number" id="desk-qty" class="form-control rounded-0 font-sans" value="1" min="1" max="10">
                        </div>

                        <!-- Informations acheteur -->
                        <div class="mb-3 text-xs">
                            <label class="form-label font-serif text-dark fw-bold">Nom complet :</label>
                            <input type="text" id="desk-name" class="form-control rounded-0 font-sans" placeholder="Ex: Souleymane Barry" required>
                        </div>

                        <div class="row g-2 mb-4">
                            <div class="col-md-6 mb-2 text-xs">
                                <label class="form-label font-serif text-dark fw-bold">Votre Email :</label>
                                <input type="email" id="desk-email" class="form-control rounded-0 font-sans" placeholder="barry@fasonet.bf" required>
                            </div>
                            <div class="col-md-6 mb-2 text-xs">
                                <label class="form-label font-serif text-dark fw-bold">Téléphone Mobile :</label>
                                <input type="text" id="desk-phone" class="form-control rounded-0 font-sans" placeholder="Ex: +226 70123456" required>
                            </div>
                        </div>

                        <!-- Moyen de paiement national -->
                        <div id="payment-gateways" class="p-3 bg-light border border-warning text-xs mb-4">
                            <label class="form-label font-serif text-dark fw-bold block mb-2"><i class="fa-solid fa-credit-card text-danger"></i> Choisissez un mode de paiement sahélien :</label>
                            <div class="row row-cols-3 g-2 text-center text-dark">
                                <div class="col">
                                    <label class="p-2 border bg-white d-block cursor-pointer border-danger" style="border-width: 2px;">
                                        <input type="radio" name="gateway" value="OrangeMoney" class="me-1" checked> OM 🇧🇫
                                    </label>
                                </div>
                                <div class="col">
                                    <label class="p-2 border bg-white d-block cursor-pointer">
                                        <input type="radio" name="gateway" value="MoovMoney" class="me-1"> Moov 🇧🇫
                                    </label>
                                </div>
                                <div class="col">
                                    <label class="p-2 border bg-white d-block cursor-pointer">
                                        <input type="radio" name="gateway" value="Espece" class="me-1"> Au guichet
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Résumé de prix -->
                        <div class="p-3 bg-dark text-white font-mono text-center mb-4">
                            <span class="text-xs text-white-50 uppercase tracking-widest block">MONTANT TOTAL DE LA TRANSACTION</span>
                            <span class="h1 fw-bold text-warning mb-0" id="desk-total-display">0 CFA</span>
                        </div>

                        <button type="submit" class="btn btn-kassiri w-100 font-serif uppercase tracking-wider py-2">
                            <i class="fa-solid fa-credit-card me-1 text-yellow"></i> Valider ma commande
                        </button>
                    </form>

                    <!-- Ticket QR -->
                    <div id="desk-ticket-result" class="d-none mt-5 p-4 bg-light border border-success text-center">
                        <span class="badge bg-success block py-1 mb-3">CONTRAT DE BILLET VALIDÉ</span>
                        <div id="desk-qr-container" class="my-4 flex items-center justify-center bg-white p-2 border border-secondary" style="width:140px; height:140px; margin:0 auto;"></div>
                        <div class="h5 font-serif text-dark mt-3 mb-1" id="desk-res-name">Nom de l'acheteur</div>
                        <div class="text-[11px] font-mono font-bold text-danger mb-2" id="desk-res-code">CODE : BIL-LKP-XXXX</div>
                        <div class="text-[10px] text-muted font-sans" id="desk-res-summary">Résumé</div>
                        <p class="text-[10px] text-success font-semibold font-sans mt-3"><i class="fa-solid fa-circle-check"></i> Votre e-ticket est actif et enregistré chez l'organisateur.</p>
                        <button class="btn btn-sm btn-outline-dark rounded-0 font-serif text-xs mt-3 px-3" onclick="window.print()"><i class="fa-solid fa-print"></i> Imprimer mon ticket</button>
                    </div>
                </div>
            </div>

            <!-- Colonne droite : Instructions -->
            <div class="col-lg-5" data-aos="fade-left">
                <div class="p-4 bg-light text-dark border border-dark mb-4">
                    <h5 class="font-serif mb-3 text-brand-charcoal text-center"><i class="fa-solid fa-shield-halved text-success me-1"></i> Sécurité Kassiri</h5>
                    <ul class="text-xs list-unstyled font-sans" style="line-height:2;">
                        <li><i class="fa-solid fa-lock text-success me-2"></i> Chiffrement SSL 256 bits</li>
                        <li><i class="fa-solid fa-mobile-screen text-success me-2"></i> Compatible Orange Money & Moov Money directement</li>
                        <li><i class="fa-solid fa-circle-question text-success me-2"></i> Assistance billetterie disponible 24h/24</li>
                    </ul>
                </div>

                <div class="p-4 bg-warning-subtle text-dark border border-warning">
                    <h5 class="font-serif mb-2 text-warning-emphasis">Comment ça marche ?</h5>
                    <ol class="text-xs font-sans ps-3" style="line-height:2.2;">
                        <li>Sélectionnez votre festival préféré dans le formulaire de gauche.</li>
                        <li>Remplissez vos coordonnées de livraison.</li>
                        <li>Payez de manière sécurisée en composant votre code USSD national de paiement.</li>
                        <li>Récupérez instantanément votre QR code de billet à présenter aux portillons.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- LOGICAL TRANSACTIONS JQUERY -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const deskEv = document.getElementById("desk-ev");
        const radNorm = document.getElementById("type-norm");
        const radVip = document.getElementById("type-vip");
        const deskQty = document.getElementById("desk-qty");
        const totalDisplay = document.getElementById("desk-total-display");

        // Formulaire desk
        const billingForm = document.getElementById("desk-billing-engine");
        const resultDiv = document.getElementById("desk-ticket-result");
        const qrBox = document.getElementById("desk-qr-container");
        const resName = document.getElementById("desk-res-name");
        const resCode = document.getElementById("desk-res-code");
        const resSum = document.getElementById("desk-res-summary");

        function calculateDeskTotal() {
            if (!deskEv.value) {
                totalDisplay.innerText = "0 CFA";
                return;
            }

            const selectedOption = deskEv.options[deskEv.selectedIndex];
            const normalPrice = parseFloat(selectedOption.getAttribute("data-normal"));
            const vipPrice = parseFloat(selectedOption.getAttribute("data-vip"));
            const qty = parseInt(deskQty.value) || 1;

            const unitPrice = radVip.checked ? vipPrice : normalPrice;
            const finalTotal = unitPrice * qty;

            totalDisplay.innerText = finalTotal.toLocaleString('fr-FR') + " CFA";
        }

        if (deskEv && deskQty) {
            deskEv.addEventListener("change", calculateDeskTotal);
            deskQty.addEventListener("input", calculateDeskTotal);
            radNorm.addEventListener("change", calculateDeskTotal);
            radVip.addEventListener("change", calculateDeskTotal);
        }

        // Commande submission
        if (billingForm) {
            billingForm.addEventListener("submit", function(e) {
                e.preventDefault();

                const selectOption = deskEv.options[deskEv.selectedIndex];
                const evTitle = selectOption.getAttribute("data-title");
                const nom = document.getElementById("desk-name").value;
                const email = document.getElementById("desk-email").value;
                const qty = parseInt(deskQty.value);
                const categoryType = radVip.checked ? "VIP Access" : "Billet Normal";
                const totalText = totalDisplay.innerText;

                const randCode = "BIL-KPS-" + Math.random().toString(36).substr(2, 8).toUpperCase() + "-BF";

                // Vider QR
                qrBox.innerHTML = "";

                // Générer QR
                try {
                    new QRCode(qrBox, {
                        text: `KassiriPulseDesk|${randCode}|${nom}|Ev:${evTitle}|Qty:${qty}|Total:${totalText}`,
                        width: 140,
                        height: 140,
                        colorDark : "#1A1A1A",
                        colorLight : "#ffffff"
                    });
                } catch(qrErr) {
                    qrBox.innerHTML = `<img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data=KassiriPulseDesk|${randCode}" alt="Ticket Code" />`;
                }

                // Hydrater résultats
                resName.innerText = nom;
                resCode.innerText = "NUMÉRO DE CONTRAT : " + randCode;
                resSum.innerText = `${qty} x ${categoryType} pour l'événement : ${evTitle} (Total : ${totalText})`;

                // Révélations
                billingForm.style.display = "none";
                resultDiv.classList.remove("d-none");

                Swal.fire({
                    title: 'Billet Dématérialisé Prêt !',
                    text: `Merci ${nom} d'avoir fait confiance à Kassiri Pulse. Votre billet à code unique est sauvegardé.`,
                    icon: 'success',
                    confirmButtonColor: '#C0392B',
                    confirmButtonText: 'Afficher le QR code'
                });
            });
        }
    });
</script>

<?php
require_once '../includes/footer.php';
?>
