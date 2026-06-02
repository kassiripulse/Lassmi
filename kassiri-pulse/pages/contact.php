<?php
/**
 * Kassiri Pulse - Contact et Localisation des Bureaux
 * Fichier : pages/contact.php
 */
require_once '../config/database.php';
require_once '../includes/header.php';
require_once '../includes/navbar.php';
?>

<!-- EN-TÊTE CONTACT -->
<section class="py-5 bg-dark text-white text-center border-bottom border-warning">
    <div class="container py-3" data-aos="zoom-in">
        <h1 class="display-3 font-serif mb-1 uppercase text-brand-gold"><i class="fa-regular fa-envelope me-1"></i> Prenez Contact</h1>
        <p class="lead font-sans text-white-50 max-w-xl mx-auto" style="font-size:16px;">
            Une suggestion, un partenariat de festival ou besoin d'assistance pour vos pass ? L'équipe de Kassiri Pulse est à votre entière disposition.
        </p>
    </div>
</section>

<!-- ADRESSE, FORMULAIRE ET CARTE LEAFLET -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Formulaire de contact jQuery -->
            <div class="col-lg-7" data-aos="fade-right">
                <div class="bg-white p-5 border-bogolan shadow-sm mb-4">
                    <h4 class="font-serif text-brand-charcoal border-bottom pb-2 mb-4">Écrire aux Administration Bureaux</h4>
                    
                    <form id="contact-kassiri-form">
                        <div class="row g-2 mb-3 text-xs">
                            <div class="col-md-6 mb-2">
                                <label class="form-label font-serif fw-bold text-dark block">Votre Nom complet :</label>
                                <input type="text" id="contact-name" class="form-control rounded-0 font-sans" placeholder="Adama Sawadogo" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label font-serif fw-bold text-dark block">Votre Email :</label>
                                <input type="email" id="contact-email" class="form-control rounded-0 font-sans" placeholder="sawadogo@fasonet.bf" required>
                            </div>
                        </div>

                        <div class="mb-3 text-xs">
                            <label class="form-label font-serif fw-bold text-dark block">Sujet du Message :</label>
                            <input type="text" id="contact-subject" class="form-control rounded-0 font-sans" placeholder="Ex: Partenariat d'exposition artisanale" required>
                        </div>

                        <div class="mb-4 text-xs">
                            <label class="form-label font-serif fw-bold text-dark block">Message :</label>
                            <textarea id="contact-msg" class="form-control rounded-0 font-sans" rows="5" placeholder="Écrivez-nous en détails..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-kassiri w-100 font-serif uppercase tracking-wider py-2">
                            <i class="fa-solid fa-paper-plane me-1"></i> Envoyer mon courrier
                        </button>
                    </form>
                </div>
            </div>

            <!-- Coordonnées et Carte Leaflet -->
            <div class="col-lg-5" data-aos="fade-left">
                <div class="p-4 bg-light border border-dark mb-4 text-dark shadow-sm">
                    <h5 class="font-serif border-bottom pb-2 mb-3 text-brand-charcoal">Siège de Kassiri Pulse</h5>
                    <p class="text-xs font-sans text-muted mb-3" style="line-height:1.7;">
                        Nos bureaux administratifs se trouvent au cœur de Ouagadougou, à proximité des ministères et centres culturels (Maison du Peuple, CENASA). Passer pour prendre vos pass imprimés si besoin !
                    </p>
                    <div class="text-xs font-mono text-dark" style="line-height:2;">
                        <p class="mb-1"><i class="fa-solid fa-map-location-dot text-danger me-2"></i> Koulouba, Rue de la Victoire, Ouagadougou, Faso</p>
                        <p class="mb-1"><i class="fa-solid fa-envelope text-danger me-2"></i> contact@kassiripulse.bf</p>
                        <p class="mb-0"><i class="fa-solid fa-headset text-danger me-2"></i> +226 25 30 00 00 / +226 70 00 00 00</p>
                    </div>
                </div>

                <!-- Carte d'implantation locale -->
                <div class="bg-white p-2 border border-secondary shadow-sm">
                    <div id="office-location-map" class="w-100" style="height: 250px; z-index:1;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SCRIPTS GESTION DE CONTACT ET MAP JQUERY -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1. CARTE LEAFLET DU SIÈGE
        try {
            const ouagaOfficeLat = 12.3683;
            const ouagaOfficeLng = -1.5172;

            const map = L.map('office-location-map').setView([ouagaOfficeLat, ouagaOfficeLng], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            const redIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            L.marker([ouagaOfficeLat, ouagaOfficeLng], {icon: redIcon}).addTo(map)
                .bindPopup('<strong class="font-serif text-brand-charcoal">Siège KASSIRI PULSE</strong><br><span class="text-[10px] text-danger font-mono">Ouagadougou, Koulouba</span>')
                .openPopup();
        } catch(err) {
            console.error("Leaflet mapping error: ", err);
        }

        // 2. GESTION DU SUBMISSION DU FORMULAIRE DE CONTACT AVEC SWEETALERT
        const form = document.getElementById("contact-kassiri-form");
        if (form) {
            form.addEventListener("submit", function(e) {
                e.preventDefault();
                const nom = document.getElementById("contact-name").value;

                Swal.fire({
                    title: 'Message enregistré !',
                    text: `Merci ${nom} pour votre message. Nos équipes administratives prendront contact avec vous sous 24 heures.`,
                    icon: 'success',
                    confirmButtonColor: '#C0392B',
                    confirmButtonText: 'Barika (Merci)'
                });

                form.reset();
            });
        }
    });
</script>

<?php
require_once '../includes/contact.php'; // Ou charger directement le footer standard pour une mise en page saine
require_once '../includes/footer.php';
?>
