/**
 * Types définis pour les données de Kassiri Pulse
 */

export interface Categorie {
  id: number;
  nom: string;
  slug: string;
  couleur: string;
  icone: string;
}

export interface Artiste {
  id: number;
  nom: string;
  slug: string;
  photo: string;
  biographie: string;
  discipline: string;
  ville: string;
  facebook?: string;
  instagram?: string;
  youtube?: string;
  soundcloud?: string;
  site_web?: string;
}

export interface Evenement {
  id: number;
  titre: string;
  slug: string;
  description: string;
  image: string;
  categorie_id: number;
  artiste_id: number;
  lieu: string;
  ville: string;
  adresse: string;
  latitude: number;
  longitude: number;
  date_debut: string;
  date_fin: string;
  prix_normal: number;
  prix_vip: number;
  capacite: number;
  statut: 'actif' | 'archive' | 'annule';
  vues: number;
  created_at: string;
}

export interface GalerieImage {
  id: number;
  titre: string;
  image: string;
  evenement_id: number;
  created_at: string;
}

export interface Billet {
  id: number;
  evenement_id: number;
  nom_acheteur: string;
  email: string;
  telephone: string;
  type_billet: 'normal' | 'vip';
  quantite: number;
  montant_total: number;
  code_billet: string;
  statut_paiement: 'paye' | 'en_attente' | 'echoue';
  created_at: string;
}

export interface Podcast {
  id: number;
  titre: string;
  slug: string;
  description: string;
  fichier_audio: string;
  image: string;
  duree: string;
  artiste_id: number;
  categorie_id: number;
  vues: number;
  created_at: string;
}

export interface Commentaire {
  id: number;
  evenement_id: number;
  nom: string;
  email: string;
  contenu: string;
  note: number; // 1-5 étoiles
  statut: 'approuve' | 'suspendu' | 'en_attente';
  created_at: string;
}

export interface NewsletterSubscriber {
  id: number;
  email: string;
  nom?: string;
  created_at: string;
}

export interface ContactMessage {
  id: number;
  nom: string;
  email: string;
  sujet: string;
  message: string;
  statut: 'non_lu' | 'lu' | 'repondu';
  created_at: string;
}

export interface AdminLog {
  id: number;
  utilisateur: string;
  action: string;
  details: string;
  timestamp: string;
}
