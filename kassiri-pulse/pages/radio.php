<?php
/**
 * Kassiri Pulse - Diffusion Radiophonique FM Interactive
 * Fichier : pages/radio.php
 */
require_once '../config/database.php';
require_once '../includes/header.php';
require_once '../includes/navbar.php';
?>

<!-- EN-TÊTE RADIO -->
<section class="py-5 bg-dark text-white text-center border-bottom border-warning">
    <div class="container py-3" data-aos="zoom-in">
        <h1 class="display-3 font-serif mb-1 uppercase text-brand-gold"><i class="fa-solid fa-radio me-2 animate-bounce"></i> Kassiri Radio FM</h1>
        <p class="lead font-sans text-white-50 max-w-xl mx-auto" style="font-size:16px;">
            Écoutez en direct la quintessence métissée de l'Afrique Sahélienne. Des classiques folkloriques aux voix de la jeunesse engagée du Faso.
        </p>
    </div>
</section>

<!-- MODULE TUNER RETRO ET PROGRAMMES -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Lecteur Tuner Retro Radio -->
            <div class="col-lg-7" data-aos="fade-right">
                <div class="bg-dark text-white p-5 border-bogolan shadow-lg rounded-0 mb-4 position-relative" style="background-image: radial-gradient(circle, #2A2A2A 0%, #111111 100%);">
                    <span class="position-absolute top-2 right-2 badge bg-danger uppercase font-mono animate-pulse" id="live-indicator" style="font-size:9px;">● HORS ANTENNE</span>
                    
                    <h4 class="font-serif text-warning text-center mb-4 uppercase tracking-wider"><i class="fa-solid fa-volume-high text-danger me-2"></i> Récepteur Sahélien</h4>
                    
                    <!-- Tuner Digital -->
                    <div class="p-4 bg-black border border-warning text-center rounded-0 mx-auto my-4 text-warning font-mono" style="max-width:380px;">
                        <div class="text-[10px] text-white-50 uppercase tracking-widest mb-1">TUNER NUMÉRIQUE NATIONAL</div>
                        <div class="display-4 fw-bold text-success mb-2" id="tuner-freq">95.40<span style="font-size: 18px;"> MHz</span></div>
                        <div class="text-[12px] text-success font-semibold tracking-wide" id="tuner-status">STUDIO PRINCIPAL : OUAGADOUGOU (KOULOUBA)</div>
                    </div>

                    <!-- Plyr Live Audio -->
                    <div class="plyr-audio-player w-100 my-4" style="max-width:420px; margin:0 auto;">
                        <audio id="live-antenna-player" preload="none">
                            <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-4.mp3" type="audio/mp3">
                        </audio>
                    </div>

                    <div class="text-center mt-3">
                        <button class="btn btn-kassiri-gold btn-sm px-4 uppercase font-serif" id="btn-toggle-antenna"><i class="fa-solid fa-play me-1"></i> Se Brancher au Direct</button>
                    </div>
                </div>

                <!-- Formulaire dédicace -->
                <div class="bg-white p-4 border border-dark rounded-0 mb-4 text-dark shadow-sm">
                    <h5 class="font-serif text-brand-charcoal border-bottom pb-2 mb-3">Dédicaces et Messages Antenne</h5>
                    <form id="radio-dedication-form">
                        <div class="row g-2 mb-3">
                            <div class="col-md-6 mb-2 text-xs">
                                <label class="form-label font-serif fw-bold block text-dark">Votre Surnom :</label>
                                <input type="text" id="dedi-name" class="form-control rounded-0 font-sans" placeholder="Ex: Souley le Koudas" required>
                            </div>
                            <div class="col-md-6 mb-2 text-xs">
                                <label class="form-label font-serif fw-bold block text-dark">Dédicace pour :</label>
                                <input type="text" id="dedi-target" class="form-control rounded-0 font-sans" placeholder="Pour toute ma famille de Banfora" required>
                            </div>
                        </div>
                        <div class="mb-3 text-xs">
                            <label class="form-label font-serif fw-bold block text-dark">Votre message court :</label>
                            <textarea id="dedi-content" class="form-control rounded-0 font-sans" rows="2" placeholder="Un grand coucou, je vous écoute en boucle !" required maxlength="120"></textarea>
                        </div>
                        <button type="submit" class="btn btn-kassiri py-2 px-4 text-xs font-serif">Envoyer au studio</button>
                    </form>
                </div>
            </div>

            <!-- Grille de programmation hebdomadaire -->
            <div class="col-lg-5" data-aos="fade-left">
                <div class="p-4 bg-light border border-dark text-dark rounded-0 shadow-sm">
                    <h5 class="font-serif text-brand-charcoal text-center mb-3">Agenda des Ondes FM</h5>
                    <table class="table table-sm table-striped font-sans text-xs text-dark" style="line-height:2.2;">
                        <thead>
                            <tr class="font-serif border-bottom border-dark table-active">
                                <th>Heure / Jour</th>
                                <th>Émission sportive / culturelle</th>
                                <th>Animateur</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-danger rounded-0 font-mono">07:00 — 09:00</span></td>
                                <td class="fw-bold text-dark">Le Réveil du Sahel</td>
                                <td>Adama Coulibaly</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger rounded-0 font-mono">12:00 — 14:00</span></td>
                                <td class="fw-bold text-dark">Palabre sous le Baobab</td>
                                <td>Mariam Sanogo</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger rounded-0 font-mono">18:00 — 20:00</span></td>
                                <td class="fw-bold text-dark">L'Heure de l'Écorce d'Or</td>
                                <td>Seydou Ouattara</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger rounded-0 font-mono">22:00 — 00:00</span></td>
                                <td class="fw-bold text-dark">Ondes de Nuit Sahéliennes</td>
                                <td>DJ Banforas</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-warning-subtle text-dark border border-warning mt-4">
                    <h5 class="font-serif mb-2 text-warning-emphasis">Participez à la Radio !</h5>
                    <p class="text-xs font-sans text-muted mb-0">Devenez l'acteur du direct. Envoyez vos requêtes de dédicace via le formulaire. Les messages approuvés feront l'objet d'une lecture en direct par nos animateurs vedettes lors des Ondes de Nuit Sahéliennes.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- LOGICAL FM ACTIONS SCRIPT -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const liveIndicator = document.getElementById("live-indicator");
        const btnAntenna = document.getElementById("btn-toggle-antenna");
        const audioAntenna = document.getElementById("live-antenna-player");
        const dediForm = document.getElementById("radio-dedication-form");

        // Gérer le branchement radio live
        if (btnAntenna && audioAntenna) {
            btnAntenna.addEventListener("click", function() {
                if (audioAntenna.paused) {
                    audioAntenna.play();
                    liveIndicator.innerText = "● EN DIRECT LIVE";
                    liveIndicator.classList.remove("bg-danger");
                    liveIndicator.classList.add("bg-success");
                    btnAntenna.innerHTML = '<i class="fa-solid fa-pause me-1"></i> Couper la Radio';
                    btnAntenna.classList.remove("btn-kassiri-gold");
                    btnAntenna.classList.add("btn-danger");
                } else {
                    audioAntenna.pause();
                    liveIndicator.innerText = "● HORS ANTENNE";
                    liveIndicator.classList.remove("bg-success");
                    liveIndicator.classList.add("bg-danger");
                    btnAntenna.innerHTML = '<i class="fa-solid fa-play me-1"></i> Se Brancher au Direct';
                    btnAntenna.classList.remove("btn-danger");
                    btnAntenna.classList.add("btn-kassiri-gold");
                }
            });
        }

        // Dédicace Enregistrée
        if (dediForm) {
            dediForm.addEventListener("submit", function(e) {
                e.preventDefault();
                const surnom = document.getElementById("dedi-name").value;
                const message = document.getElementById("dedi-content").value;

                Swal.fire({
                    title: 'Dédicace Envoyée !',
                    text: `Merci ${surnom}. Votre dédicace a bien été transmise au studio de Koulouba. Écoutez attentivement l'antenne ce soir !`,
                    icon: 'success',
                    confirmButtonColor: '#C0392B',
                    confirmButtonText: 'Barika (Merci)'
                });

                dediForm.reset();
            });
        }
    });
</script>

<?php
require_once '../includes/footer.php';
?>
