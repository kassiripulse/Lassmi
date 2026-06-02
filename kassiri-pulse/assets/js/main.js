/**
 * KASSIRI PULSE - SCRIPT DE STYLE DYNAMIQUE ET ANIMATIONS
 * Fichier : assets/js/main.js
 */

document.addEventListener("DOMContentLoaded", function () {
    // 1. SUPPRESSION DU LOADER CULTUREL
    const loader = document.getElementById("cultural-loader");
    if (loader) {
        window.addEventListener("load", function () {
            // Un petit délai pour admirer le sablier
            setTimeout(() => {
                loader.style.opacity = "0";
                setTimeout(() => {
                    loader.style.display = "none";
                }, 500);
            }, 600);
        });
    }

    // 2. INITIALISATION AOS (Animations au défilement)
    if (typeof AOS !== "undefined") {
        AOS.init({
            duration: 800,
            easing: "ease-in-out",
            once: true,
            mirror: false
        });
    }

    // 3. INITIALISATION DU BANDEAU DÉFILANT (SWIPER TICKER)
    if (typeof Swiper !== "undefined") {
        new Swiper('.swiper-ticker', {
            direction: 'vertical',
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            }
        });
        
        // Swiper pour les événements à l'affiche (Hero)
        new Swiper('.swiper-hero-container', {
            loop: true,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        // Swiper pour les artistes vedettes
        new Swiper('.swiper-artistes-container', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: true,
            },
            breakpoints: {
                576: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 3,
                },
                1200: {
                    slidesPerView: 4,
                }
            },
            pagination: {
                el: '.swiper-artist-pagination',
                clickable: true,
            }
        });
    }

    // 4. INITIATEURS DE LECTEURS AUDIO (PLYR.JS)
    if (typeof Plyr !== "undefined") {
        Plyr.setup('.plyr-audio-player', {
            controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume']
        });
    }

    // 5. GESTION DU MODE SOMBRE / CLAIR (LOCAL STORAGE)
    const themeBtn = document.getElementById("theme-toggle-btn");
    if (themeBtn) {
        // Appliquer le thème au clic
        themeBtn.addEventListener("click", function () {
            const currentTheme = localStorage.getItem("kassiri-theme") || "light";
            if (currentTheme === "light") {
                document.body.classList.add("dark-mode");
                localStorage.setItem("kassiri-theme", "dark");
                themeBtn.innerHTML = '<i class="fa-solid fa-sun me-1"></i> Mode Clair';
            } else {
                document.body.classList.remove("dark-mode");
                localStorage.setItem("kassiri-theme", "light");
                themeBtn.innerHTML = '<i class="fa-solid fa-moon me-1"></i> Mode Sombre';
            }
        });

        // Appliquer le thème sauvegardé initialement
        const savedTheme = localStorage.getItem("kassiri-theme") || "light";
        if (savedTheme === "dark") {
            document.body.classList.add("dark-mode");
            themeBtn.innerHTML = '<i class="fa-solid fa-sun me-1"></i> Mode Clair';
        } else {
            document.body.classList.remove("dark-mode");
            themeBtn.innerHTML = '<i class="fa-solid fa-moon me-1"></i> Mode Sombre';
        }
    }

    // 6. BARRE DE RECHERCHE AJAX DYNAMIQUE (SIMULATION JSON)
    const searchInput = document.getElementById("search-input");
    const searchSuggestions = document.getElementById("search-suggestions");
    if (searchInput && searchSuggestions) {
        // Jeu de suggestions fictives burkinabè
        const localData = [
            { title: "SIAO 2026 Salon Artisanat", url: "evenement/siao-2026" },
            { title: "FESPACO Film SIRA", url: "evenement/fespaco-2027" },
            { title: "Concert de Floby Koudougou", url: "evenement/floby-koudougou" },
            { title: "Smarty Rappeur Rimes", url: "artiste/smarty" },
            { title: "Alif Naaba Folk", url: "artiste/alif-naaba" },
            { title: "Siriki Ky Sculpteur Laongo", url: "artiste/siriki-ky" },
            { title: "Nuits Atypiques de Koudougou", url: "evenement/nak-2026" }
        ];

        searchInput.addEventListener("input", function () {
            const query = searchInput.value.toLowerCase().trim();
            if (query.length < 2) {
                searchSuggestions.classList.add("d-none");
                return;
            }

            const results = localData.filter(item => item.title.toLowerCase().includes(query));
            if (results.length === 0) {
                searchSuggestions.innerHTML = '<div class="p-3 text-xs text-muted font-mono text-center">Aucun festival ou artiste trouvé</div>';
            } else {
                searchSuggestions.innerHTML = results.map(item => `
                    <a href="${item.url}" class="d-block p-2 text-decoration-none text-dark border-bottom hover-gold text-xs font-mono">
                        <i class="fa-solid fa-arrow-right me-1 text-danger"></i> ${item.title}
                    </a>
                `).join('');
            }
            searchSuggestions.classList.remove("d-none");
        });

        // Fermer le panneau si on clique à l'extérieur
        document.addEventListener("click", function (e) {
            if (!searchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
                searchSuggestions.classList.add("d-none");
            }
        });
    }

    // 7. SYSTÈME RESERVATION AVEC SWEETALERT ET QRCODE
    const inscriptionForm = document.getElementById("newsletter-form-footer");
    if (inscriptionForm && typeof Swal !== "undefined") {
        inscriptionForm.addEventListener("submit", function (e) {
            e.preventDefault();
            const nom = inscriptionForm.querySelector("input[name='nom']").value;
            const email = inscriptionForm.querySelector("input[name='email']").value;

            Swal.fire({
                title: 'Succès !',
                text: `Félicitations ${nom}, vous êtes bien inscrit à l'Écho du Sahel (${email}) !`,
                icon: 'success',
                confirmButtonColor: '#C0392B',
                confirmButtonText: 'Wobrigo (Merci)'
            });
            inscriptionForm.reset();
        });
    }
});
