<?php
/**
 * Kassiri Pulse - Navbar principale
 * Fichier : includes/navbar.php
 */
?>
<!-- Bandeau de défilement Swiper des événements récents ou alertes culturelles -->
<div class="bg-dark text-white py-1 py-md-2 border-bottom border-warning">
    <div class="container-fluid px-4 flex items-center justify-between">
        <div class="row align-items-center g-0">
            <div class="col-auto">
                <span class="badge bg-danger text-uppercase font-serif px-2 py-1 me-2" style="font-size: 10px;">En ce moment 🇧🇫</span>
            </div>
            <div class="col overflow-hidden">
                <div class="swiper-container swiper-ticker overflow-hidden" style="max-height: 25px;">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide text-xs text-white-50 font-mono">Floby enflammera Koudougou très bientôt le 10 Juin ! Prenez vos places !</div>
                        <div class="swiper-slide text-xs text-white-50 font-mono">Le Symposium de Laongo de Siriki Ky s'apprête à accueillir 15 sculpteurs panafricains.</div>
                        <div class="swiper-slide text-xs text-white-50 font-mono">Projection exceptionnelle et débat exclusif du chef-d'œuvre de SIRA le 15 Juillet à Ouaga.</div>
                    </div>
                </div>
            </div>
            <div class="col-auto d-none d-md-flex align-items-center">
                <span class="text-xs text-warning-emphasis font-mono me-3"><i class="fa-regular fa-clock me-1"></i> Fuseau : Ouagadougou UTC+0</span>
                <button id="theme-toggle-btn" class="btn btn-sm btn-outline-warning rounded-0 py-0 px-2 font-mono" style="font-size: 11px;">
                    <i class="fa-solid fa-moon me-1"></i> Mode Sombre
                </button>
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg bg-white sticky-top shadow-sm py-3 border-bottom border-info border-2" style="border-bottom-color: var(--primary-gold) !important;">
    <div class="container">
        <!-- Logo inspiré du Bogolan -->
        <a class="navbar-brand d-flex align-items-center" href="accueil" style="gap: 10px;">
            <div class="bg-danger d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px; border: 3px solid var(--primary-gold);">
                <span class="font-serif fw-bold" style="font-size: 22px;">K</span>
            </div>
            <div>
                <span class="font-serif fw-extrabold text-uppercase text-dark tracking-wide mb-0 block h5" style="line-height:1;">KASSIRI <span class="text-danger">PULSE</span></span>
                <span class="text-xs text-muted block font-mono uppercase" style="letter-spacing: 1px; font-size:9px;">Vibration Culturelle du Burkina</span>
            </div>
        </a>

        <!-- Hamburger Bouton Animé -->
        <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="collapse" data-bs-target="#kassiriNavbar" aria-controls="kassiriNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="kassiriNavbar">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 font-serif">
                <li class="nav-item">
                    <a class="nav-link active py-2 text-dark font-semibold transition" href="accueil">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 text-dark font-semibold transition" href="accueil#evenements">Événements</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 text-dark font-semibold transition" href="agenda">Agenda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 text-dark font-semibold transition" href="carte">Carte</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 text-dark font-semibold transition" href="galerie">Galerie</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 text-dark font-semibold transition" href="billetterie">Billetterie</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 text-dark font-semibold transition" href="podcasts">Podcasts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 text-dark font-semibold transition" href="radio">Radio FM</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-2 text-dark font-semibold transition" href="contact">Contact</a>
                </li>
            </ul>

            <!-- Barre de Recherche en temps réel jQuery -->
            <form action="recherche" method="GET" class="d-flex position-relative me-2" id="ajax-search-form">
                <input class="form-control form-control-sm rounded-0 border-dark bg-light font-sans" type="search" placeholder="Rechercher un artiste, festival..." aria-label="Search" name="q" id="search-input" autocomplete="off" style="width: 220px;">
                <button class="btn btn-sm btn-dark rounded-0 px-2" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                
                <!-- Panneau de suggestions JSON dynamique -->
                <div id="search-suggestions" class="position-absolute bg-white border border-dark w-100 shadow mt-5 z-3 d-none font-sans" style="top:0; left:0; max-height:300px; overflow-y:auto;">
                    <!-- Rempli en Ajax -->
                </div>
            </form>

            <div class="d-flex align-items-center mt-3 mt-lg-0">
                <a href="admin/connexion" class="btn btn-sm btn-outline-danger rounded-0 font-serif font-bold">
                    <i class="fa-solid fa-user-shield me-1"></i> Admin
                </a>
            </div>
        </div>
    </div>
</nav>
