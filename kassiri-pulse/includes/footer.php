<?php
/**
 * Kassiri Pulse - Footer commun
 * Fichier : includes/footer.php
 */
?>
<!-- SECTION NEWSLETTER & ENGAGEMENT SAHÉLIEN -->
<section class="py-5 bg-dark text-white border-top border-warning position-relative" style="background-image: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.95)), url('assets/images/bogolan_pattern_dark.jpg'); background-size: cover;">
    <div class="container relative z-2">
        <div class="row items-center justify-between">
            <div class="col-lg-5 mb-4 mb-lg-0" data-aos="fade-right">
                <h3 class="font-serif text-brand-gold">Inscrivez-vous à l'Écho du Sahel</h3>
                <p class="text-white-50 font-sans mt-2" style="font-size: 15px;">
                    Ne manquez aucune vibration culturelle burkinabè. Recevez chaque semaine l'agenda exclusif des festivals, l'histoire de nos masques, nos concerts inédits et nos nouveaux podcasts.
                </p>
                <div class="d-flex gap-3 text-warning font-mono mt-4 text-xs">
                    <div><i class="fa-solid fa-check text-success me-1"></i> Gratuit</div>
                    <div><i class="fa-solid fa-check text-success me-1"></i> Aucun spam</div>
                    <div><i class="fa-solid fa-check text-success me-1"></i> Désinscription en 1 clic</div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <form id="newsletter-form-footer" class="bg-light p-4 text-dark border-bogolan-subtle" style="border-width: 3px;">
                    <h5 class="font-serif mb-3 text-brand-charcoal">Rejoindre la communauté</h5>
                    <div class="row g-2">
                        <div class="col-md-6 mb-2">
                            <input type="text" class="form-control rounded-0 font-sans" placeholder="Votre nom" name="nom" required style="border-color: #1A1A1A;">
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="email" class="form-control rounded-0 font-sans" placeholder="Votre adresse email" name="email" required style="border-color: #1A1A1A;">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-kassiri w-100 font-serif mt-3 py-2 text-uppercase">
                        <i class="fa-solid fa-paper-plane me-1"></i> Recevoir l'Écho Culturel
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- PIED DE PAGE PRINCIPAL -->
<footer class="bg-black text-white pt-5 pb-3">
    <div class="container">
        <div class="row">
            <!-- Branding et Coordonnées -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="font-serif text-uppercase tracking-wider text-danger mb-3">KASSIRI PULSE</h5>
                <p class="text-white-50 font-sans text-xs">
                    Première plateforme et encyclopédie interactive dédiée à la préservation et au rayonnement de l'art, de la musique et du patrimoine culturel du Faso. Du granit sculpté de Laongo aux percussions mandingues de Banfora.
                </p>
                <div class="mt-4 font-mono text-xs text-white-50">
                    <p class="mb-1"><i class="fa-solid fa-location-dot text-brand-gold me-2"></i> Koulouba, Rue de la Victoire, Ouagadougou, Burkina Faso</p>
                    <p class="mb-1"><i class="fa-solid fa-phone text-brand-gold me-2"></i> +226 25 30 00 00 / +226 70 00 00 00</p>
                    <p><i class="fa-solid fa-envelope text-brand-gold me-2"></i> contact@kassiripulse.bf</p>
                </div>
            </div>

            <!-- Liens de navigation culturelle -->
            <div class="col-lg-2 col-md-6 mb-4 offset-lg-1">
                <h6 class="font-serif text-brand-gold text-uppercase tracking-wider mb-3">Catégories</h6>
                <ul class="list-unstyled font-sans text-xs" style="line-height:2.2;">
                    <li><a href="categorie/musique" class="text-white-50 text-decoration-none hover-gold">Musique & Afro-fusion</a></li>
                    <li><a href="categorie/danse" class="text-white-50 text-decoration-none hover-gold">Danse sacrée & Contemporaine</a></li>
                    <li><a href="categorie/arts-plastiques" class="text-white-50 text-decoration-none hover-gold">Arts Plastiques & Bronze</a></li>
                    <li><a href="categorie/cinema" class="text-white-50 text-decoration-none hover-gold">Cinéma Panafricain</a></li>
                    <li><a href="categorie/theatre" class="text-white-50 text-decoration-none hover-gold">Théâtre engagé</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6 mb-4">
                <h6 class="font-serif text-brand-gold text-uppercase tracking-wider mb-3">La Plateforme</h6>
                <ul class="list-unstyled font-sans text-xs" style="line-height:2.2;">
                    <li><a href="agenda" class="text-white-50 text-decoration-none hover-gold">Calendrier Mensuel</a></li>
                    <li><a href="carte" class="text-white-50 text-decoration-none hover-gold">Carte des Événements</a></li>
                    <li><a href="galerie" class="text-white-50 text-decoration-none hover-gold">Galerie de Masques</a></li>
                    <li><a href="podcasts" class="text-white-50 text-decoration-none hover-gold">Podcasts & Émissions</a></li>
                    <li><a href="radio" class="text-white-50 text-decoration-none hover-gold">Radio live Kassiri</a></li>
                </ul>
            </div>

            <!-- Réseaux Sociaux & QR Code direct -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 class="font-serif text-brand-gold text-uppercase tracking-wider mb-3">Suivez le Pouls du Faso</h6>
                <div class="d-flex gap-2 mb-3">
                    <a href="#" class="btn btn-sm btn-outline-light rounded-circle flex items-center justify-center" style="width: 36px; height: 36px;"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-light rounded-circle flex items-center justify-center" style="width: 36px; height: 36px;"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-light rounded-circle flex items-center justify-center" style="width: 36px; height: 36px;"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-light rounded-circle flex items-center justify-center" style="width: 36px; height: 36px;"><i class="fa-brands fa-x-twitter"></i></a>
                </div>
                <div class="p-2 bg-white d-inline-block border border-warning" style="width: 100px;">
                    <!-- Simulacre d'autorisation -->
                    <div id="footer-qr" class="w-full h-full bg-light flex items-center justify-center text-[10px] text-dark text-center leading-1 font-mono">Billet App</div>
                </div>
                <div class="text-xs text-white-50 mt-1 font-mono">Scan pour Billets Mobiles</div>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="row align-items-center justify-between">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-xs text-white-50 font-sans mb-md-0">&copy; 2026 KASSIRI PULSE. Tous droits réservés. Inspiré par l'artisanat du Burkina Faso.</p>
            </div>
            <div class="col-md-6 text-center text-md-end text-xs font-mono text-white-50">
                <span>Code Source hébergé sur Hostinger Premium</span>
                <span class="mx-2">|</span>
                <a href="sitemap.xml" class="text-white-50 hover-gold text-decoration-none">Sitemap XML</a>
            </div>
        </div>
    </div>
</footer>

<!-- SCRIPT CARGEMENT CDN ABSOLU (Vanilla JS + jQuery) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6Rz83DN6zBxLv1NM79Hg3OMmI3uriS7356208/h3By8z3SI91R3g169oa8MSRLw" crossorigin="anonymous"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="</script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://rawgit.com/davidshimjs/qrcodejs/master/qrcode.min.js"></script> <!-- QR Code direct -->

<!-- Script d'init commun et gestion mode sombre -->
<script src="assets/js/main.js"></script>

</body>
</html>
