<?php
/**
 * Kassiri Pulse - Agenda Interactif Mensuel
 * Fichier : pages/agenda.php
 */
require_once '../config/database.php';
require_once '../includes/header.php';
require_once '../includes/navbar.php';

$db_connected = false;
$events_json = [];

try {
    $pdo = Database::getConnection();
    $db_connected = true;

    // Charger les événements
    $stmt = $pdo->query("SELECT id, titre as title, date_debut as start, date_fin as end, slug FROM evenements WHERE statut='actif'");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Convertir au format requis par FullCalendar
    foreach ($results as $row) {
        $events_json[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'start' => $row['start'],
            'end' => $row['end'] ?? $row['start'], // s'assurer d'une date de fin
            'url' => 'evenement.php?slug=' . $row['slug'],
            'color' => '#C0392B' // Couleur d'événement esthétique standard rouge
        ];
    }
} catch (Exception $e) {
    $db_connected = false;
}

// Fallback de secours si BDD non provisionnée
if (empty($events_json)) {
    $events_json = [
        [
            'id' => 1,
            'title' => 'SIAO 2026 — Salon Artisanat',
            'start' => '2026-10-30T08:00:00',
            'end' => '2026-11-08T22:00:00',
            'url' => 'evenement.php?slug=siao-2026',
            'color' => '#D4A017' // Or
        ],
        [
            'id' => 2,
            'title' => 'Concert de Floby — Koudougou',
            'start' => '2026-06-10T19:00:00',
            'end' => '2026-06-10T23:59:00',
            'url' => 'evenement.php?slug=floby-koudougou',
            'color' => '#C0392B' // Rouge
        ],
        [
            'id' => 5,
            'title' => 'Jazz à Ouaga — Club du Sahel',
            'start' => '2026-06-15T19:30:00',
            'end' => '2026-06-16T23:59:00',
            'url' => 'evenement.php?slug=jazz-ouaga-2026',
            'color' => '#1A6B3C' // Vert
        ]
    ];
}
?>

<!-- EN-TÊTE AGENDA -->
<section class="py-5 bg-dark text-white text-center border-bottom border-warning">
    <div class="container py-3" data-aos="zoom-in">
        <h1 class="display-3 font-serif mb-1 uppercase text-brand-gold"><i class="fa-regular fa-calendar-check me-1"></i> Agenda Culturel</h1>
        <p class="lead font-sans text-white-50 max-w-xl mx-auto" style="font-size:16px;">
            Planifiez vos escapades artistiques. Parcourez notre calendrier officiel des scènes, défilés, projections et expositions.
        </p>
    </div>
</section>

<!-- CALENDRIER FULLCALENDAR -->
<section class="py-5">
    <div class="container">
        <div class="bg-white p-4 border border-dark shadow-sm" data-aos="fade-up">
            <div id="calendar-kassiri-main"></div>
        </div>
    </div>
</section>

<!-- MODAL POPUP INTERACTIVE SCELLÉE -->
<div class="modal fade" id="calendarEventModal" tabindex="-1" aria-labelledby="calendarEventModalLabel" aria-hidden="true" style="backdrop-filter: blur(4px);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0 border-dark" style="border-width: 3px;">
            <div class="modal-header bg-dark text-white rounded-0">
                <h5 class="modal-title font-serif text-brand-gold" id="calendarEventModalLabel">Événement Planifié</h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-dark font-sans" id="calendarEventModalBody">
                <p class="mb-0">Détails de l'événement chargé...</p>
            </div>
            <div class="modal-footer bg-light rounded-0">
                <button type="button" class="btn btn-sm btn-outline-dark rounded-0 font-mono text-xs" data-bs-dismiss="modal">Fermer</button>
                <a id="modal-event-link" href="#" class="btn btn-sm btn-kassiri rounded-0 font-serif text-xs">Acheter mon Billet</a>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS CONFIGURATION INTERACTIVE FULLCALENDAR -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar-kassiri-main');
        const eventModal = new bootstrap.Modal(document.getElementById('calendarEventModal'));
        const modalBody = document.getElementById('calendarEventModalBody');
        const modalLink = document.getElementById('modal-event-link');

        if (calendarEl && typeof FullCalendar !== 'undefined') {
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'fr',
                themeSystem: 'standard',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listMonth'
                },
                buttonText: {
                    today: "Aujourd'hui",
                    month: "Mois",
                    week: "Semaine",
                    list: "Planning"
                },
                // Charger la liste des événements convertis
                events: <?php echo json_encode($events_json); ?>,
                
                // Gérer le clic sur l'événement pour afficher la modal au lieu du redirect direct brusque
                eventClick: function(info) {
                    info.jsEvent.preventDefault(); // Annuler redirect direct
                    
                    const evTitle = info.event.title;
                    const evStart = info.event.start.toLocaleDateString('fr-FR', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' });
                    const evUrl = info.event.url;

                    modalBody.innerHTML = `
                        <div class="p-2">
                            <h5 class="font-serif text-danger fw-bold mb-3">${evTitle}</h5>
                            <p class="text-xs text-muted font-mono mb-2"><i class="fa-regular fa-clock"></i> Date de début : ${evStart}</p>
                            <p class="text-xs mb-0 font-sans text-dark">Vous pouvez commander vos tickets dès maintenant pour cet événement phare via notre billetterie mobile.</p>
                        </div>
                    `;
                    modalLink.setAttribute('href', evUrl);
                    
                    eventModal.show();
                }
            });
            calendar.render();
        }
    });
</script>

<?php
require_once '../includes/footer.php';
?>
