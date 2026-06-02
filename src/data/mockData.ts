import { Categorie, Artiste, Evenement, GalerieImage, Billet, Podcast, Commentaire } from '../types';

export const INITIAL_CATEGORIES: Categorie[] = [
  { id: 1, nom: 'Musique', slug: 'musique', couleur: '#C0392B', icone: 'Music' },
  { id: 2, nom: 'Danse', slug: 'danse', couleur: '#1A6B3C', icone: 'Flame' },
  { id: 3, nom: 'Arts plastiques', slug: 'arts-plastiques', couleur: '#D4A017', icone: 'Palette' },
  { id: 4, nom: 'Cinéma', slug: 'cinema', couleur: '#1A1A1A', icone: 'Film' },
  { id: 5, nom: 'Théâtre', slug: 'theatre', couleur: '#C0392B', icone: 'Theater' },
  { id: 6, nom: 'Festivals', slug: 'festivals', couleur: '#D4A017', icone: 'Sparkles' }
];

export const INITIAL_ARTISTES: Artiste[] = [
  {
    id: 1,
    nom: 'Alif Naaba',
    slug: 'alif-naaba',
    photo: 'https://images.unsplash.com/photo-1549834185-bd9f078a5dfe?q=80&w=600&auto=format&fit=crop',
    biographie: 'Surnommé "Le Prince aux pieds nus", Alif Naaba est un auteur-compositeur-interprète burkinabè incontournable. Sa voix chaude et ses mélodies mêlent afro-pop, jazz et musique traditionnelle moaga (Peuple Mossi). Originaire de Koudougou, il chante l\'espoir, la paix et le quotidien de son peuple.',
    discipline: 'Musique (Afro-Fusion / Folk)',
    ville: 'Ouagadougou',
    facebook: 'https://facebook.com/alifnaaba',
    instagram: 'https://instagram.com/alifnaaba',
    youtube: 'https://youtube.com/alifnaaba',
    site_web: 'http://www.alifnaaba.com'
  },
  {
    id: 2,
    nom: 'Smarty',
    slug: 'smarty',
    photo: 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?q=80&w=600&auto=format&fit=crop',
    biographie: 'Lauréat du Prix Découvertes RFI en 2013, Smarty (ex-membre du groupe mythique Yeleen) est le pionnier du hip-hop engagé au Burkina Faso. Son écriture ciselée, percutante et pleine de poésie sociale critique le pouvoir, conscientise la jeunesse et célèbre la résilience du Sahel.',
    discipline: 'Hip-Hop / Rap',
    ville: 'Ouagadougou',
    facebook: 'https://facebook.com/smarty.officiel',
    youtube: 'https://youtube.com/smarty',
    instagram: 'https://instagram.com/smarty'
  },
  {
    id: 3,
    nom: 'Siriki Ky',
    slug: 'siriki-ky',
    photo: 'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?q=80&w=600&auto=format&fit=crop',
    biographie: 'Né en 1953, Siriki Ky est un immense artiste plasticien et sculpteur burkinabè. Il est surtout connu pour être l\'initiateur du symposium de sculpture sur granit de Laongo (un musée à ciel ouvert exceptionnel situé à l\'est de Ouagadougou). Les œuvres de Ky mêlent bronze, pierre, bois et interrogent la condition humaine.',
    discipline: 'Arts Plastiques & Sculpture',
    ville: 'Laongo / Ouagadougou',
    site_web: 'http://sirikiky.org'
  },
  {
    id: 4,
    nom: 'Irène Tassembédo',
    slug: 'irene-tassembedo',
    photo: 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?q=80&w=600&auto=format&fit=crop',
    biographie: 'Chorégraphe légendaire et actrice emblématique, Irène Tassembédo a jeté les ponts de la danse contemporaine africaine. Elle a dirigé l\'École de Danse EDIT à Ouagadougou et a chorégraphié des pièces acclamées dans le monde entier. Elle insuffle une énergie athlétique et spirituelle à ses créations.',
    discipline: 'Danse Contemporaine / Chorégraphie',
    ville: 'Ouagadougou',
    facebook: 'https://facebook.com/edit.tassembedo'
  },
  {
    id: 5,
    nom: 'Siriki Coulibaly (Cie Danse-Défi)',
    slug: 'siriki-coulibaly',
    photo: 'https://images.unsplash.com/photo-1547153760-18fc86324498?q=80&w=600&auto=format&fit=crop',
    biographie: 'Originaire de Bobo-Dioulasso, Siriki Coulibaly est danseur classique et traditionnel de formation mandingue. Sa compagnie explore le dialogue entre les mouvements ancestraux et les questions écologiques brûlantes du Sahel burkinabè.',
    discipline: 'Danse Traditionnelle & Fusion',
    ville: 'Bobo-Dioulasso',
    instagram: 'https://instagram.com/siriki_danse'
  },
  {
    id: 6,
    nom: 'Apolline Traoré',
    slug: 'apolline-traore',
    photo: 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?q=80&w=600&auto=format&fit=crop',
    biographie: 'Née à Orodara au Burkina Faso, Apolline Traoré est une réalisatrice majeure. Diplômée de l\'Emerson College de Boston, elle a bouleversé le cinéma mondial avec son chef-d\'œuvre "SIRA", récompensé par l\'Étalon d\'Argent au FESPACO 2023 et le Prix du Public à la Berlinale. Elle relate la vaillance des femmes face au terrorisme.',
    discipline: 'Cinéma (Scénario et Réalisation)',
    ville: 'Ouagadougou',
    instagram: 'https://instagram.com/apolline_traore'
  },
  {
    id: 7,
    nom: 'Étienne Minoungou',
    slug: 'etienne-minoungou',
    photo: 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=600&auto=format&fit=crop',
    biographie: 'Comédien, dramaturge et metteur en scène exceptionnel, Étienne Minoungou est l\'âme des Récréâtrales (Résidences Panafricaines de Création Théâtrale à Ouagadougou). Sa présence scénique immense dans la pièce de Felwine Sarr "M\'appelât-on de l\'aube ?" a marqué les mémoires théâtrales d\'Avignon à Ouaga.',
    discipline: 'Théâtre & Dramaturgie',
    ville: 'Ouagadougou',
    facebook: 'https://facebook.com/recreatrales'
  },
  {
    id: 8,
    nom: 'Floby',
    slug: 'floby',
    photo: 'https://images.unsplash.com/photo-1484755560695-a4c740285a15?q=80&w=600&auto=format&fit=crop',
    biographie: 'Surnommé "Le Kirikou d\'Afrique" ou "Le King Floby", il est l\'un des artistes les plus populaires du pays. Mêlant l\'argot local (mooré) à des rythmes coupé-décalé et variété, il possède plus de 15 Kundé d\'Or à son actif et remplit continuellement les stades nationaux.',
    discipline: 'Musique Populaire / Variété',
    ville: 'Koudougou / Ouagadougou',
    facebook: 'https://facebook.com/flobyking'
  }
];

export const INITIAL_EVENEMENTS: Evenement[] = [
  {
    id: 1,
    titre: 'SIAO 2026 — Salon International de l\'Artisanat de Ouagadougou',
    slug: 'siao-2026-salon-international-artisanat',
    description: 'Le plus grand rassemblement de l\'artisanat africain d\'art et de design contemporain. Découvrez des créateurs venus d\'une quarantaine de pays d\'Afrique : maroquinerie, Bogolan raffiné, sculptures d\'artisanat en bronze de Ouaga, poteries, et vannerie fine du désert. Des défilés de mode textile bio et le grand marché d\'exposition-vente transforment la ville de Ouagadougou en capitale créative absolue.',
    image: 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?q=80&w=800&auto=format&fit=crop',
    categorie_id: 6, // Festivals
    artiste_id: 3, // Siriki Ky is related as jury/exposant
    lieu: 'Parc des Expositions du SIAO',
    ville: 'Ouagadougou',
    adresse: 'Boulevard France-Afrique, Quartier Patte d\'Oie',
    latitude: 12.3392,
    longitude: -1.5034,
    date_debut: '2026-10-30T08:00:00Z',
    date_fin: '2026-11-08T22:00:00Z',
    prix_normal: 2000,
    prix_vip: 10000,
    capacite: 95000,
    statut: 'actif',
    vues: 2450,
    created_at: '2026-05-15T12:00:00Z'
  },
  {
    id: 2,
    titre: 'FESPACO 2027 — Édition Spéciale de Lancement Faso',
    slug: 'fespaco-2027-lancement-special',
    description: 'Pré-sélections, projections de plein air et panels thématiques en prélude au Festival Panafricain du Cinéma et de la Télévision de Ouagadougou (FESPACO). Venez célébrer les 55 ans du cinéma d\'Afrique en projetant des rétrospectives mythiques au Ciné Burkina et au Ciné Neerwaya. Un tapis rouge majestueux rendant hommage aux grandes cinéastes d\'Afrique francophone comme Apolline Traoré.',
    image: 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=800&auto=format&fit=crop',
    categorie_id: 4, // Cinéma
    artiste_id: 6, // Apolline Traoré
    lieu: 'Ciné Burkina & Siège du FESPACO',
    ville: 'Ouagadougou',
    adresse: 'Rue Agostino Neto, Centre-Ville',
    latitude: 12.3712,
    longitude: -1.5199,
    date_debut: '2026-12-05T09:00:00Z',
    date_fin: '2026-12-12T23:30:00Z',
    prix_normal: 1500,
    prix_vip: 5000,
    capacite: 15000,
    statut: 'actif',
    vues: 3890,
    created_at: '2026-05-01T10:00:00Z'
  },
  {
    id: 3,
    titre: 'Les Récréâtrales 2026 — Scènes Ouvertes de Bougsemtenga',
    slug: 'recreatrales-2026-bougsemtenga',
    description: 'Les Résidences Panafricaines de Création Théâtrale reviennent dans les cours des concessions familiales de Bougsemtenga ! Metteurs en scène, comédiens et musiciens de toute l\'Afrique investissent le quartier populaire le plus chaleureux de Ouaga pour des créations scéniques exclusives, des soirées de conte traditionnel et un grand bal populaire.',
    image: 'https://images.unsplash.com/photo-1503095391758-11200cf53674?q=80&w=800&auto=format&fit=crop',
    categorie_id: 5, // Théâtre
    artiste_id: 7, // Étienne Minoungou
    lieu: 'Quartier Populaire Bougsemtenga, zone Récréâtrales',
    ville: 'Ouagadougou',
    adresse: 'Rue des Récréâtrales (Bougsemtenga)',
    latitude: 12.3821,
    longitude: -1.5302,
    date_debut: '2026-10-24T17:00:00Z',
    date_fin: '2026-10-31T23:59:00Z',
    prix_normal: 1000,
    prix_vip: 3000,
    capacite: 8000,
    statut: 'actif',
    vues: 1280,
    created_at: '2026-05-20T14:00:00Z'
  },
  {
    id: 4,
    titre: 'Nuits Atypiques de Koudougou 2026 (31ème Édition)',
    slug: 'nuits-atypiques-koudougou-2026',
    description: 'Une explosion culturelle réunissant musique, artisanat et rencontres artistiques à Koudougou. Le festival légendaire du "Faso profond" rassemble des vedettes locales et ouest-africaines sous le signe de l\'union sacrée et de la paix. Floby et Alif Naaba se produiront en concerts géants partagés.',
    image: 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?q=80&w=800&auto=format&fit=crop',
    categorie_id: 6, // Festivals
    artiste_id: 8, // Floby (Originaire / Populaire de Koudougou)
    lieu: 'Théâtre Populaire de Koudougou',
    ville: 'Koudougou',
    adresse: 'Quartier Burkina, Secteur 3',
    latitude: 12.2514,
    longitude: -2.3611,
    date_debut: '2026-11-25T18:00:00Z',
    date_fin: '2026-11-29T23:59:00Z',
    prix_normal: 1000,
    prix_vip: 5000,
    capacite: 25000,
    statut: 'actif',
    vues: 1740,
    created_at: '2026-05-18T09:00:00Z'
  },
  {
    id: 5,
    titre: 'Jazz à Ouaga 2026 — Le Club du Sahel',
    slug: 'jazz-a-ouaga-2026-le-club',
    description: 'La 34ème édition du prestigieux festival Jazz à Ouaga célèbre la fusion du jazz afro-américain et des rythmes polyrythmiques du désert sahélien. Un concert exclusif du "Prince aux pieds nus" Alif Naaba initiant des mélodies croisées avec d\'éminents trompettistes du monde entier.',
    image: 'https://images.unsplash.com/photo-1486591978090-58e619d37fe7?q=80&w=800&auto=format&fit=crop',
    categorie_id: 1, // Musique
    artiste_id: 1, // Alif Naaba
    lieu: 'CENASA (Centre National des Arts du Spectacle et de l\'Audiovisuel)',
    ville: 'Ouagadougou',
    adresse: 'Rue de la Victoire, Koulouba',
    latitude: 12.3698,
    longitude: -1.5164,
    date_debut: '2026-06-15T19:30:00Z',
    date_fin: '2026-06-22T23:00:00Z',
    prix_normal: 3000,
    prix_vip: 15000,
    capacite: 2500,
    statut: 'actif',
    vues: 1980,
    created_at: '2026-04-10T11:00:00Z'
  },
  {
    id: 6,
    titre: 'Concert Solidaire Smarty : L\'Écho de la Paix',
    slug: 'concert-solidaire-smarty-echo-paix',
    description: 'Une soirée engagée par le rappeur philosophe Smarty. Devant les milliers de spectateurs de la Maison de la Culture de Bobo-Dioulasso, Smarty présentera ses nouveaux titres ainsi que ses classiques dénonçant la violence de la crise sécuritaire, en appelant solennellement à la tolérance mutuelle et à l\'unification nationale du peuple burkinabè.',
    image: 'https://images.unsplash.com/photo-1459749411175-04bf5292ceea?q=80&w=800&auto=format&fit=crop',
    categorie_id: 1, // Musique
    artiste_id: 2, // Smarty
    lieu: 'Maison de la Culture Anselme Titianma Sanon',
    ville: 'Bobo-Dioulasso',
    adresse: 'Boulevard Châlons-en-Champagne, Secteur 15',
    latitude: 11.1685,
    longitude: -4.2798,
    date_debut: '2026-06-28T20:00:00Z',
    date_fin: '2026-06-28T23:30:00Z',
    prix_normal: 2000,
    prix_vip: 5000,
    capacite: 3500,
    statut: 'actif',
    vues: 1610,
    created_at: '2026-05-02T15:00:00Z'
  },
  {
    id: 7,
    titre: 'FIDO 2027 — Festival International de Danse de Ouagadougou',
    slug: 'fido-2027-danse-festival',
    description: 'Fondé historiquement par d\'éminentes danseuses, le FIDO rassemble des dizaines de compagnies de danses contemporaines et rituelles venues de d\'Afrique subsaharienne et d\'Europe. Irène Tassembédo présentera sa nouvelle chorégraphie transgressive "Eaux troubles" qui milite pour les droits des femmes du Sahel.',
    image: 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?q=80&w=800&auto=format&fit=crop',
    categorie_id: 2, // Danse
    artiste_id: 4, // Irène Tassembédo
    lieu: 'CDC La Termitière',
    ville: 'Ouagadougou',
    adresse: 'Quartier Samandin',
    latitude: 12.3587,
    longitude: -1.5289,
    date_debut: '2026-11-12T19:00:00Z',
    date_fin: '2026-11-19T22:30:00Z',
    prix_normal: 1000,
    prix_vip: 3000,
    capacite: 1200,
    statut: 'actif',
    vues: 840,
    created_at: '2026-05-22T10:00:00Z'
  },
  {
    id: 8,
    titre: 'Siriki Ky — Rétrospective d\'œuvres "Mémoire de Granit"',
    slug: 'siriki-ky-retrospective',
    description: 'Une exposition d\'arts plastiques unique regroupant les bronzes à cire perdue originaux et les maquettes conceptuelles préparées pour le Musée de Laongo. Siriki Ky propose un parcours initiatique inédit pour revivre 35 ans de création locale au service de l\'émancipation africaine.',
    image: 'https://images.unsplash.com/photo-1605721911519-3dfeb3be25e7?q=80&w=800&auto=format&fit=crop',
    categorie_id: 3, // Arts plastiques
    artiste_id: 3, // Siriki Ky
    lieu: 'Institut Français de Ouagadougou — Galerie Carrée',
    ville: 'Ouagadougou',
    adresse: 'Avenue de la Nation, en face du Premier Ministère',
    latitude: 12.3725,
    longitude: -1.5173,
    date_debut: '2026-07-02T10:00:00Z', // Starts soon!
    date_fin: '2026-07-31T18:00:00Z',
    prix_normal: 500,
    prix_vip: 2000,
    capacite: 500,
    statut: 'actif',
    vues: 920,
    created_at: '2026-05-25T08:00:00Z'
  },
  {
    id: 9,
    titre: 'Transe-Écologie Mandingue par Siriki Coulibaly',
    slug: 'transe-ecologie-mandingue-bobo',
    description: 'Une rencontre poignante entre percussions séculaires mandingues et danse d\'expression écologique. Ce voyage artistique à Banfora nous invite à réfléchir sur l\'avancée implacable du désert nigérien et la disparition des rôles aquatiques légendaires du lac des Cascades.',
    image: 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?q=80&w=800&auto=format&fit=crop',
    categorie_id: 2, // Danse
    artiste_id: 5, // Siriki Coulibaly
    lieu: 'Espace Culturel des Cascades',
    ville: 'Banfora',
    adresse: 'Secteur 2, Route des Cascades',
    latitude: 10.6402,
    longitude: -4.7589,
    date_debut: '2026-08-14T19:00:00Z',
    date_fin: '2026-08-16T22:00:00Z',
    prix_normal: 1000,
    prix_vip: 2500,
    capacite: 1500,
    statut: 'actif',
    vues: 670,
    created_at: '2026-05-19T09:30:00Z'
  },
  {
    id: 10,
    titre: 'L\'Étoile Noire du CITO : "L\'Exil de Soundjata"',
    slug: 'cito-exil-soundjata-theatre',
    description: 'La pièce théâtrale culte d\'Étienne Minoungou relatant les récits épiques d\'exil du fondateur de l\'Empire du Mali, Soundjata Keïta. Un jeu de lumières tamisées spectaculaire mettant à nu la trahison politique, la magie spirituelle d\'Afrique occidentale et la résilience collective d\'un souverain déchu.',
    image: 'https://images.unsplash.com/photo-1460723237483-7a6dc9d0b212?q=80&w=800&auto=format&fit=crop',
    categorie_id: 5, // Théâtre
    artiste_id: 7, // Étienne Minoungou
    lieu: 'CITO (Carrefour International du Théâtre de Ouagadougou)',
    ville: 'Ouagadougou',
    adresse: 'Quartier Samandin, Secteur 14',
    latitude: 12.3551,
    longitude: -1.5273,
    date_debut: '2026-09-10T20:00:00Z',
    date_fin: '2026-09-25T22:30:00Z',
    prix_normal: 1500,
    prix_vip: 4000,
    capacite: 600,
    statut: 'actif',
    vues: 1020,
    created_at: '2026-05-12T14:00:00Z'
  },
  {
    id: 11,
    titre: 'SIRA — Projection Spéciale & Conférence d\'Apolline Traoré',
    slug: 'sira-projection-speciale-ouaga',
    description: 'Une projection d\'immense envergure du film multi-récompensé "SIRA" sous les étoiles du Ciné Neerwaya. À la fin de la séance, un débat exclusif sera modéré par Apolline Traoré elle-même sur l\'indomptable courage des femmes luttant contre l\'extrémisme violent au cœur du Sahel.',
    image: 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=800&auto=format&fit=crop',
    categorie_id: 4, // Cinéma
    artiste_id: 6, // Apolline Traoré
    lieu: 'Ciné Neerwaya',
    ville: 'Ouagadougou',
    adresse: 'Avenue de la Liberté, Quartier Paspanga',
    latitude: 12.3815,
    longitude: -1.5152,
    date_debut: '2026-07-15T19:00:00Z',
    date_fin: '2026-07-15T22:30:00Z',
    prix_normal: 1000,
    prix_vip: 3000,
    capacite: 1500,
    statut: 'actif',
    vues: 3120,
    created_at: '2026-05-24T08:00:00Z'
  },
  {
    id: 12,
    titre: 'Le Grand Kundé d\'Or Floby à Koudougou',
    slug: 'floby-le-grand-kunde-d-or-koudougou',
    description: 'Le Roi Floby revient célébrer son énième sacre musical auprès de sa ville de cœur, Koudougou ! Un show à couper le souffle mêlant guitares mandingues saturées, choeurs guerriers mossis, danses acrobatiques et sonorités afro-beat populaires. Un rassemblement de plus de 10 000 Faso fans promis à la postérité.',
    image: 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?q=80&w=800&auto=format&fit=crop',
    categorie_id: 1, // Musique
    artiste_id: 8, // Floby
    lieu: 'Place de la Nation de Koudougou',
    ville: 'Koudougou',
    adresse: 'Centre-Ville, Secteur 1',
    latitude: 12.2498,
    longitude: -2.3598,
    date_debut: '2026-06-10T19:00:00Z', // Very imminent counting from June 2nd!
    date_fin: '2026-06-11T02:00:00Z',
    prix_normal: 1000,
    prix_vip: 5000,
    capacite: 12000,
    statut: 'actif',
    vues: 2150,
    created_at: '2026-05-10T11:00:00Z'
  },
  {
    id: 13,
    titre: 'FESTIMA 2026 — Festival International des Masques et des Arts',
    slug: 'festima-2026-festival-masques-dedougou',
    description: 'Une plongée magique et ensorcelante dans le mystère des masques d\'Afrique de l\'Ouest à Dédougou. Des centaines de sociétés de masques traditionnels (masques de feuilles, masques de fibres, masques de plumes, masques de squelettes et de bois sculpté) dansent sous les tam-tams hypnotiques pour invoquer le renouveau spirituel burkinabè.',
    image: 'https://images.unsplash.com/photo-1549834185-bd9f078a5dfe?q=80&w=800&auto=format&fit=crop',
    categorie_id: 6, // Festivals
    artiste_id: 3, // Siriki Ky (Related on heritage design)
    lieu: 'Grande Arène Municipale de Dédougou',
    ville: 'Dédougou',
    adresse: 'Route de Bobo, Secteur 4',
    latitude: 12.4632,
    longitude: -3.4611,
    date_debut: '2026-11-01T08:00:00Z',
    date_fin: '2026-11-07T22:00:00Z',
    prix_normal: 500,
    prix_vip: 2000,
    capacite: 45000,
    statut: 'actif',
    vues: 1540,
    created_at: '2026-05-20T10:00:00Z'
  },
  {
    id: 14,
    titre: 'Garba Faso Fest — Édition Bobo 2026',
    slug: 'garba-faso-fest-bobo',
    description: 'L\'incomparable festival culinaire et musical burkinabè mettant à l\'honneur le Garba national (semoule de manioc cuite à la vapeur dorée avec sa friture de thon assaisonnée de piment vert). Un grand concert en plein air avec les têtes d\'affiches du rap burkinabè et ivoirien.',
    image: 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=800&auto=format&fit=crop',
    categorie_id: 6, // Festivals
    artiste_id: 8, // Floby
    lieu: 'Stade Wobi de Bobo-Dioulasso',
    ville: 'Bobo-Dioulasso',
    adresse: 'Avenue de la République, Secteur 5',
    latitude: 11.1712,
    longitude: -4.3005,
    date_debut: '2026-09-04T12:00:00Z',
    date_fin: '2026-09-06T23:30:00Z',
    prix_normal: 1000,
    prix_vip: 3000,
    capacite: 15000,
    statut: 'actif',
    vues: 1250,
    created_at: '2026-05-22T08:00:00Z'
  },
  {
    id: 15,
    titre: 'Nuit Chorégraphique de Kaya — Le Souffle du Sahel',
    slug: 'nuit-choregraphique-kaya',
    description: 'Un plaidoyer chorégraphique fort reliant les artistes nationaux et réfugiés de Kaya. Danse, théâtre, poésie parlée et témoignages chantés dessinent collectivement le portrait poignant d\'un Burkina Faso fort, indivisible et profondément uni face à l\'adversité.',
    image: 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?q=80&w=800&auto=format&fit=crop',
    categorie_id: 2, // Danse
    artiste_id: 4, // Irène Tassembédo
    lieu: 'Place de la Nation de Kaya',
    ville: 'Kaya',
    adresse: 'Centre-Ville, Secteur 2',
    latitude: 13.0905,
    longitude: -1.0841,
    date_debut: '2026-07-24T18:30:00Z',
    date_fin: '2026-07-25T00:00:00Z',
    prix_normal: 500,
    prix_vip: 2000,
    capacite: 4000,
    statut: 'actif',
    vues: 780,
    created_at: '2026-05-26T07:15:00Z'
  }
];

export const INITIAL_GALERIE: GalerieImage[] = [
  { id: 1, titre: 'SIAO Stand d\'Exposition Artisanat de Bronze', image: 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?q=80&w=600&auto=format&fit=crop', evenement_id: 1, created_at: '2026-11-01T15:00:00Z' },
  { id: 2, titre: 'Exposants de Bogolan Fin d\'Afrique Centrafrique', image: 'https://images.unsplash.com/photo-1549834185-bd9f078a5dfe?q=80&w=600&auto=format&fit=crop', evenement_id: 1, created_at: '2026-11-02T10:00:00Z' },
  { id: 3, titre: 'Tapis Rouge FESPACO Foule Ouagadougou', image: 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=600&auto=format&fit=crop', evenement_id: 2, created_at: '2026-12-06T19:30:00Z' },
  { id: 4, titre: 'Scène de théâtre en plein air à Bougsemtenga', image: 'https://images.unsplash.com/photo-1503095391758-11200cf53674?q=80&w=600&auto=format&fit=crop', evenement_id: 3, created_at: '2026-10-25T18:00:00Z' },
  { id: 5, titre: 'Spectateurs réunis aux Nuits Atypiques de Koudougou', image: 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?q=80&w=600&auto=format&fit=crop', evenement_id: 4, created_at: '2026-11-26T21:00:00Z' },
  { id: 6, titre: 'SIRA Projection sous les Étoiles au Ciné Neerwaya', image: 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=600&auto=format&fit=crop', evenement_id: 11, created_at: '2026-07-15T21:00:00Z' },
  { id: 7, titre: 'Siriki Ky en train de tailler le Granit de Laongo', image: 'https://images.unsplash.com/photo-1605721911519-3dfeb3be25e7?q=80&w=600&auto=format&fit=crop', evenement_id: 8, created_at: '2026-07-05T11:00:00Z' },
  { id: 8, titre: 'Chorégraphie majestueuse d\'Irène Tassembédo', image: 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?q=80&w=600&auto=format&fit=crop', evenement_id: 7, created_at: '2026-11-14T20:00:00Z' }
];

export const INITIAL_BILLETS: Billet[] = [
  { id: 1, evenement_id: 1, nom_acheteur: 'Abdoulaye Traoré', email: 'abdoul@gmail.com', telephone: '+22670111213', type_billet: 'normal', quantite: 2, montant_total: 4000, code_billet: 'BIL-SIAO-2026-A1X98', statut_paiement: 'paye', created_at: '2026-05-18T10:15:00Z' },
  { id: 2, evenement_id: 1, nom_acheteur: 'Fatoumata Ouédraogo', email: 'fatou@outlook.com', telephone: '+22676451234', type_billet: 'vip', quantite: 1, montant_total: 10000, code_billet: 'BIL-SIAO-2026-VIP7', statut_paiement: 'paye', created_at: '2026-05-19T14:45:00Z' },
  { id: 3, evenement_id: 2, nom_acheteur: 'Jean-Baptiste Sawadogo', email: 'jb.sawa@gmail.com', telephone: '+22660142536', type_billet: 'normal', quantite: 3, montant_total: 4500, code_billet: 'BIL-FES-2027-H29P3', statut_paiement: 'paye', created_at: '2026-05-20T08:30:00Z' },
  { id: 4, evenement_id: 3, nom_acheteur: 'Mariam Diallo', email: 'mariam@univ-ouaga.bf', telephone: '+22678965412', type_billet: 'normal', quantite: 1, montant_total: 1000, code_billet: 'BIL-REC-2026-N29D1', statut_paiement: 'paye', created_at: '2026-05-21T11:20:00Z' },
  { id: 5, evenement_id: 5, nom_acheteur: 'Marc Dubois', email: 'm.dubois@ambassade-fr.org', telephone: '+22670258525', type_billet: 'vip', quantite: 2, montant_total: 30000, code_billet: 'BIL-JAZ-2026-VIP1A', statut_paiement: 'paye', created_at: '2026-05-22T17:10:00Z' },
  { id: 6, evenement_id: 6, nom_acheteur: 'Alizatou Barry', email: 'aliza.barry@live.fr', telephone: '+22671550099', type_billet: 'normal', quantite: 5, montant_total: 10000, code_billet: 'BIL-SMY-2026-BB110', statut_paiement: 'paye', created_at: '2026-05-23T09:05:00Z' },
  { id: 7, evenement_id: 11, nom_acheteur: 'Pascaline Sanon', email: 'p.sanon@bobo.bf', telephone: '+22650123456', type_billet: 'normal', quantite: 2, montant_total: 2000, code_billet: 'BIL-SIRA-2026-T6F2', statut_paiement: 'paye', created_at: '2026-05-24T16:22:00Z' },
  { id: 8, evenement_id: 12, nom_acheteur: 'Ibrahim Konaté', email: 'ib@yandex.ru', telephone: '+22675889900', type_billet: 'normal', quantite: 4, montant_total: 4000, code_billet: 'BIL-FLB-2026-KK09', statut_paiement: 'paye', created_at: '2026-05-25T13:40:00Z' }
];

export const INITIAL_PODCASTS: Podcast[] = [
  {
    id: 1,
    titre: 'Alif Naaba : "L\'Écho de notre résilience moderne"',
    slug: 'alif-naaba-echo-resilience',
    description: 'Une discussion fleuve exclusive avec le Prince aux pieds nus dans son studio d\'enregistrement de la Cour du Naaba à Ouaga, sur le rôle civique du chanteur en temps de tumulte sahélien.',
    fichier_audio: 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3', // Stable safe sample audio files
    image: 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?q=80&w=200&auto=format&fit=crop',
    duree: '14:25',
    artiste_id: 1, // Alif Naaba
    categorie_id: 1, // Musique
    vues: 340,
    created_at: '2026-05-20T10:00:00Z'
  },
  {
    id: 2,
    titre: 'Aux origines de Laongo : Entretien majeur Siriki Ky',
    slug: 'origines-laongo-entretien-siriki-ky',
    description: 'Comment transformer un champ de granit désertique en musée international de sculpture d\'art contemporain moderne à ciel ouvert ? Le sculpteur Siriki Ky livre les anecdotes secrètes de 30 ans d\'effort national.',
    fichier_audio: 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3',
    image: 'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?q=80&w=200&auto=format&fit=crop',
    duree: '22:10',
    artiste_id: 3, // Siriki Ky
    categorie_id: 3, // Arts Plastiques
    vues: 215,
    created_at: '2026-05-22T11:00:00Z'
  },
  {
    id: 3,
    titre: 'Smarty : "Rimes percutantes et poésie sociale"',
    slug: 'smarty-rimes-percutantes-sagesse',
    description: 'Écriture, engagement politique, de la gloire de Yeleen jusqu\'à son sacre solo. Smarty décrypte le texte de "Rimer debout" et sa vision du militantisme africain moderne.',
    fichier_audio: 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-3.mp3',
    image: 'https://images.unsplash.com/photo-1484755560695-a4c740285a15?q=80&w=200&auto=format&fit=crop',
    duree: '18:50',
    artiste_id: 2, // Smarty
    categorie_id: 1, // Musique
    vues: 490,
    created_at: '2026-05-24T15:00:00Z'
  },
  {
    id: 4,
    titre: 'Apolline Traoré : Le Cri des Femmes de Sira',
    slug: 'apolline-traore-cri-femmes-sira',
    description: 'À l\'occasion de la rafle de l\'Étalon d\'Argent au FESPACO, la réalisatrice revient sur les conditions héroïques d\'écriture et de tournage de SIRA dans les dunes caniculaires.',
    fichier_audio: 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-4.mp3',
    image: 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?q=80&w=200&auto=format&fit=crop',
    duree: '25:40',
    artiste_id: 6, // Apolline Traoré
    categorie_id: 4, // Cinéma
    vues: 512,
    created_at: '2026-05-26T09:00:00Z'
  },
  {
    id: 5,
    titre: 'Récréâtrales : Le Théâtre comme catharsis populaire',
    slug: 'recreatrales-theatre-catharsis-ouaga',
    description: 'Le comédien fétiche Étienne Minoungou raconte l\'immense histoire d\'amour entre le théâtre de résistance et les habitants de Bougsemtenga, ouvrant leurs portes familiales aux créateurs.',
    fichier_audio: 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-5.mp3',
    image: 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=200&auto=format&fit=crop',
    duree: '16:05',
    artiste_id: 7, // Étienne Minoungou
    categorie_id: 5, // Théâtre
    vues: 165,
    created_at: '2026-05-28T14:00:00Z'
  }
];

export const INITIAL_COMMENTAIRES: Commentaire[] = [
  { id: 1, evenement_id: 1, nom: 'Seydou Ouattara', email: 'seydou.ouat@live.fr', contenu: 'Le SIAO est vraiment le fleuron de l\'artisanat africain ! Magnifique organisation, j\'ai adoré les textiles Bogolan revisités de Banfora.', note: 5, statut: 'approuve', created_at: '2026-05-18T18:30:00Z' },
  { id: 2, evenement_id: 1, nom: 'Claire Boulanger', email: 'claire.b@yahoo.fr', contenu: 'Des artisans talentueux de partout. Petit bémol sur la chaleur sous les halls d\'exposition de Ouaga, mais les créations compensent largement.', note: 4, statut: 'approuve', created_at: '2026-05-19T10:00:00Z' },
  { id: 3, evenement_id: 5, nom: 'Salif Sanfo', email: 'salif@cultural.bf', contenu: 'Le concert d\'Alif Naaba au CENASA était sublime, de l\'émotion à l\'état brut. Le duo jazz avec le saxophoniste était magique.', note: 5, statut: 'approuve', created_at: '2026-06-16T08:20:00Z' },
  { id: 4, evenement_id: 6, nom: 'Inoussa Kaboré', email: 'inou@gmail.com', contenu: 'Smarty fidèle à lui-même. Des textes profonds qui font réfléchir. Bobo a vibré à l\'unisson hier soir, bravo l\'artiste !', note: 5, statut: 'approuve', created_at: '2026-06-29T11:45:00Z' },
  { id: 5, evenement_id: 11, nom: 'Rasmata Traoré', email: 'rasou@univ-ouaga.bf', contenu: 'Sira est un chef-d\'œuvre absolu. J\'ai pleuré devant la force de cette jeune fille. Merci Apolline d\'avoir donné une voix à nos sœurs.', note: 5, statut: 'approuve', created_at: '2026-07-16T09:12:00Z' }
];

export const INITIAL_SUBSCRIBERS = [
  { id: 1, email: 'ismael.k@fasonet.bf', nom: 'Ismael Kaboré', created_at: '2026-05-10T12:00:00Z' },
  { id: 2, email: 'mariam@outlook.com', nom: 'Mariam Diallo', created_at: '2026-05-12T14:20:00Z' },
  { id: 3, email: 'bobo.culture@bobo.bf', nom: 'Association Bobo Culture', created_at: '2026-05-15T09:40:00Z' }
];

export const INITIAL_CONTACTS = [
  { id: 1, nom: 'Boukari Compaoré', email: 'comp.bouk@gmail.com', sujet: 'Demande de stand exposant SIAO', message: 'Bonjour, j\'aimerais savoir s\'il reste des stands créateur de cuir pour la section artisanat de Kaya. Merci.', statut: 'lu', created_at: '2026-05-20T10:15:00Z' },
  { id: 2, nom: 'Sabine Lallemand', email: 's.lall@culture.gouv.fr', sujet: 'Partenariat d\'échange culturel FESPACO', message: 'Dans le cadre du soutien de la francophonie, nous aimerions enter en contact avec l\'équipe d\'Apolline Traoré pour organiser un cycle d\'écriture.', statut: 'non_lu', created_at: '2026-05-25T14:40:00Z' }
];
