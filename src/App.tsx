import React, { useState, useEffect } from 'react';
import { 
  Music, Sparkles, Film, Palette, Radio, Ticket, MapPin, Calendar, 
  User, Plus, Trash2, Edit, CheckCircle, XCircle, Code, Database, 
  ArrowLeft, Clock, Send, Star, Volume2, VolumeX, FileCode, Check, Copy, ExternalLink, ShieldCheck, Search
} from 'lucide-react';
import { motion, AnimatePresence } from 'motion/react';
import { 
  INITIAL_CATEGORIES, INITIAL_ARTISTES, INITIAL_EVENEMENTS, 
  INITIAL_GALERIE, INITIAL_BILLETS, INITIAL_PODCASTS, INITIAL_COMMENTAIRES 
} from './data/mockData';
import { codeFiles } from './data/codeFiles';

export default function App() {
  // Navigation tabs
  const [activeSegment, setActiveSegment] = useState<'public' | 'admin' | 'code'>('public');

  // Search & Filters on Public Side
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedCatId, setSelectedCatId] = useState<number | null>(null);
  const [selectedCity, setSelectedCity] = useState<string>('all');
  
  // Public Interactivity States
  const [selectedEventId, setSelectedEventId] = useState<number | null>(null);
  const [ticketModalEventId, setTicketModalEventId] = useState<number | null>(null);
  const [liveRadioPlaying, setLiveRadioPlaying] = useState(false);
  const [radioIndicator, setRadioIndicator] = useState<'OFF' | 'ON DIRECT'>('OFF');
  const [activeSnippetId, setActiveSnippetId] = useState(0);
  const [copiedIndex, setCopiedIndex] = useState<number | null>(null);

  // Form states on Public Side
  const [ticketName, setTicketName] = useState('');
  const [ticketEmail, setTicketEmail] = useState('');
  const [ticketTel, setTicketTel] = useState('');
  const [ticketType, setTicketType] = useState<'normal' | 'vip'>('normal');
  const [ticketQty, setTicketQty] = useState(1);
  const [ticketGateway, setTicketGateway] = useState<'orange' | 'moov'>('orange');
  const [ticketSuccessData, setTicketSuccessData] = useState<{ code: string; purchaser: string } | null>(null);

  const [commentName, setCommentName] = useState('');
  const [commentText, setCommentText] = useState('');
  const [commentRating, setCommentRating] = useState(5);
  const [userComments, setUserComments] = useState(INITIAL_COMMENTAIRES);

  // Admin Side States
  const [adminSection, setAdminSection] = useState<'stats' | 'events' | 'scanner'>('stats');
  const [searchTicketCode, setSearchTicketCode] = useState('');
  const [scanResult, setScanResult] = useState<{ status: 'valid' | 'invalid' | 'idle'; message: string; buyer?: string } | null>({ status: 'idle', message: '' });
  const [adminEvents, setAdminEvents] = useState(INITIAL_EVENEMENTS);
  const [isAddingEvent, setIsAddingEvent] = useState(false);

  // New Event Form State
  const [newEventTitle, setNewEventTitle] = useState('');
  const [newEventCat, setNewEventCat] = useState(1);
  const [newEventCity, setNewEventCity] = useState('Ouagadougou');
  const [newEventPrice, setNewEventPrice] = useState(2000);
  const [newEventDesc, setNewEventDesc] = useState('');

  // Auto Tick ticker list
  const tickers = [
    "FESPACO 2027 : Rétrospective d'Apolline Traoré en cours au Ciné Neerwaya",
    "SIAO 2026 : Plus de 800 exposants de Bogolan et bronzes d'art confirmés",
    "LIVE RADIO : Floby en direct ce soir sur Kassiri Pulse FM à 21h GMT",
    "BILLETTERIE : Le concert exceptionnel de Smarty à Bobo est presque guichet fermé"
  ];
  const [tickerIndex, setTickerIndex] = useState(0);

  useEffect(() => {
    const timer = setInterval(() => {
      setTickerIndex((prev) => (prev + 1) % tickers.length);
    }, 4500);
    return () => clearInterval(timer);
  }, []);

  // Filter logic on events list
  const filteredEvents = INITIAL_EVENEMENTS.filter(ev => {
    const matchesSearch = ev.titre.toLowerCase().includes(searchTerm.toLowerCase()) || 
                          ev.description.toLowerCase().includes(searchTerm.toLowerCase()) ||
                          ev.lieu.toLowerCase().includes(searchTerm.toLowerCase());
    const matchesCat = selectedCatId ? ev.categorie_id === selectedCatId : true;
    const matchesCity = selectedCity !== 'all' ? ev.ville === selectedCity : true;
    return matchesSearch && matchesCat && matchesCity;
  });

  const selectedEvent = INITIAL_EVENEMENTS.find(e => e.id === selectedEventId);

  // Handle purchase execution
  const handlePurchase = (e: React.FormEvent) => {
    e.preventDefault();
    if (!ticketName || !ticketEmail || !ticketTel) return;
    
    const randomSuffix = Math.floor(1000 + Math.random() * 9000);
    const code = `BIL-KPS-${randomSuffix}-BF`;
    setTicketSuccessData({
      code,
      purchaser: ticketName
    });
  };

  // Handle Comment Submission
  const handleCommentSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (!commentName || !commentText) return;
    const item = {
      id: userComments.length + 1,
      evenement_id: selectedEventId || 1,
      nom: commentName,
      email: 'user@temp.bf',
      contenu: commentText,
      note: commentRating,
      statut: 'approuve' as const,
      created_at: new Date().toISOString()
    };
    setUserComments([item, ...userComments]);
    setCommentName('');
    setCommentText('');
  };

  // Handle scanner simulate
  const handleScanSimulate = (e: React.FormEvent) => {
    e.preventDefault();
    if (!searchTicketCode) return;

    if (searchTicketCode.trim().toUpperCase().startsWith('BIL-')) {
      setScanResult({
        status: 'valid',
        message: 'PASS VALIDÉ - SPECTATEUR RÉPERTORIÉ',
        buyer: 'Adama Sawadogo (Accès Général)'
      });
    } else {
      setScanResult({
        status: 'invalid',
        message: 'CODE REJETÉ - SIGNATURE MAUVAISE'
      });
    }
  };

  // Copy code utility
  const copyToClipboard = (text: string, index: number) => {
    navigator.clipboard.writeText(text);
    setCopiedIndex(index);
    setTimeout(() => setCopiedIndex(null), 2000);
  };

  // Trigger sound helix radio stream on and off
  const toggleRadioDirect = () => {
    setLiveRadioPlaying(!liveRadioPlaying);
    setRadioIndicator(prev => prev === 'OFF' ? 'ON DIRECT' : 'OFF');
  };

  // Add event handler
  const handleAddEventSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (!newEventTitle || !newEventDesc) return;
    const custom = {
      id: adminEvents.length + 10,
      titre: newEventTitle,
      slug: 'custom-event',
      description: newEventDesc,
      image: 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?q=80&w=800&auto=format&fit=crop',
      categorie_id: Number(newEventCat),
      artiste_id: 1,
      lieu: 'Maison de la Culture',
      ville: newEventCity,
      adresse: 'Boulevard National',
      latitude: 12.3683,
      longitude: -1.5172,
      date_debut: '2026-07-20T19:00:00Z',
      date_fin: '2026-07-20T23:00:00Z',
      prix_normal: Number(newEventPrice),
      prix_vip: Number(newEventPrice) * 3,
      capacite: 2500,
      statut: 'actif' as const,
      vues: 45,
      created_at: new Date().toISOString()
    };
    setAdminEvents([custom, ...adminEvents]);
    setIsAddingEvent(false);
    setNewEventTitle('');
    setNewEventDesc('');
  };

  return (
    <div className="min-height-screen bg-[#FAF5E9] text-[#1A1A1A] font-sans antialiased overflow-x-hidden" id="kassiri-layout-root">
      
      {/* BRANDING TOP STRIP (Bogolan Geometric Style) */}
      <div className="w-full bg-[#1A1A1A] py-1 border-b border-[#D4A017] flex justify-between items-center px-4 md:px-8 text-xs font-mono text-white/80">
        <div className="flex items-center gap-2">
          <span className="w-2.5 h-2.5 bg-[#C0392B] rounded-full animate-pulse"></span>
          <span>SAHEL LIVE INDEX MONITOR</span>
        </div>
        <div className="flex gap-4">
          <span className="hidden sm:inline">KOULOUBA STUDIO, OUAGA</span>
          <span className="text-[#D4A017] fw-bold">PHP 8.x MVC ACTIVE</span>
        </div>
      </div>

      {/* PUBLIC TICKER BANNER */}
      <div className="w-full bg-[#1A6B3C] text-white py-2 px-4 shadow-sm flex items-center overflow-hidden border-b-2 border-[#D4A017]">
        <div className="bg-[#C0392B] text-[10px] uppercase font-mono tracking-widest px-2.5 py-0.5 text-xs font-bold border border-[#D4A017] mr-3 whitespace-nowrap shrink-0">
          Radio Ticker
        </div>
        <div className="text-xs font-medium tracking-wide">
          <AnimatePresence mode="wait">
            <motion.p
              key={tickerIndex}
              initial={{ y: 15, opacity: 0 }}
              animate={{ y: 0, opacity: 1 }}
              exit={{ y: -15, opacity: 0 }}
              className="m-0"
            >
              🔥 {tickers[tickerIndex]}
            </motion.p>
          </AnimatePresence>
        </div>
      </div>

      {/* HEADER SECTION WITH INTEGRATED NAVIGATION */}
      <header className="bg-[#1A1A1A] text-white py-6 px-4 md:px-8 relative shadow-lg">
        {/* Bogolan visual overlay borders */}
        <div className="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-[#1A6B3C] via-[#D4A017] to-[#C0392B]"></div>
        
        <div className="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
          <div className="text-center md:text-start">
            <div className="flex justify-center md:justify-start items-center gap-2 mb-1">
              <div className="bg-[#C0392B] w-8 h-8 flex items-center justify-center text-white border border-[#D4A017] font-serif font-bold text-xl">K</div>
              <h1 className="text-2xl md:text-3xl font-serif text-[#D4A017] tracking-wider font-semibold uppercase m-0 leading-none">
                Kassiri Pulse
              </h1>
            </div>
            <p className="text-xs text-white/60 m-0 tracking-widest uppercase font-mono">
              Portail Culturel Muséologique & Billetterie Mobiles
            </p>
          </div>

          {/* MAIN SIMULATOR TABS */}
          <div className="flex gap-2 bg-[#2A2A2A] p-1 border border-white/10 rounded-sm">
            <button 
              onClick={() => { setActiveSegment('public'); setSelectedEventId(null); }}
              className={`px-4 py-2 text-xs font-serif uppercase tracking-widest transition-all ${activeSegment === 'public' ? 'bg-[#C0392B] text-white font-semibold border border-[#D4A017]' : 'text-white/70 hover:text-white'}`}
            >
              ✨ Portail Public
            </button>
            <button 
              onClick={() => setActiveSegment('admin')}
              className={`px-4 py-2 text-xs font-serif uppercase tracking-widest transition-all ${activeSegment === 'admin' ? 'bg-[#C0392B] text-white font-semibold border border-[#D4A017]' : 'text-white/70 hover:text-white'}`}
            >
              🔒 Espace Admin
            </button>
            <button 
              onClick={() => setActiveSegment('code')}
              className={`px-4 py-2 text-xs font-serif uppercase tracking-widest transition-all ${activeSegment === 'code' ? 'bg-[#C0392B] text-white font-semibold border border-[#D4A017]' : 'text-white/70 hover:text-white'}`}
            >
              💻 Explorer Code PHP
            </button>
          </div>
        </div>
      </header>

      {/* MAIN CONTAINER */}
      <main className="max-w-7xl mx-auto px-4 md:px-8 py-8">
        
        {/* PUBLIC INTERACTION TAB */}
        {activeSegment === 'public' && (
          <div>
            {!selectedEventId ? (
              <div className="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                {/* PUBLIC LEFT COLUMN: FILTERS & RETRO DIRECT TUNER */}
                <div className="lg:col-span-1 space-y-6">
                  
                  {/* SEARCH DECK */}
                  <div className="bg-white p-4 border border-[#1A1A1A] shadow-sm relative">
                    <h3 className="text-sm font-serif text-[#1A1A1A] uppercase tracking-wider mb-3 border-b pb-1.5 font-bold">
                      Recherche rapide
                    </h3>
                    <div className="relative">
                      <input 
                        type="text" 
                        value={searchTerm}
                        onChange={(e) => setSearchTerm(e.target.value)}
                        placeholder="Ex: SIAO, Smarty..."
                        className="w-full text-xs font-sans bg-[#FAF5E9] py-2 pl-8 pr-3 border border-[#1A1A1A] outline-none"
                      />
                      <Search className="absolute left-2.5 top-2.5 w-4 h-4 text-[#C0392B]" />
                    </div>
                  </div>

                  {/* CATEGORIES SELECTION */}
                  <div className="bg-white p-4 border border-[#1A1A1A] shadow-sm">
                    <h3 className="text-sm font-serif text-[#1A1A1A] uppercase tracking-wider mb-3 border-b pb-1.5 font-bold">
                      Disciplines
                    </h3>
                    <div className="space-y-1">
                      <button 
                        onClick={() => setSelectedCatId(null)}
                        className={`w-full text-left px-2 py-1 text-xs font-sans flex justify-between items-center ${selectedCatId === null ? 'bg-[#C0392B] text-white font-medium' : 'text-[#1A1A1A] hover:bg-[#FAF5E9]'}`}
                      >
                        <span>Tous les arts</span>
                        <span className="text-[10px] font-mono">15</span>
                      </button>
                      {INITIAL_CATEGORIES.map(cat => (
                        <button 
                          key={cat.id}
                          onClick={() => setSelectedCatId(cat.id)}
                          className={`w-full text-left px-2 py-1 text-xs font-sans flex justify-between items-center ${selectedCatId === cat.id ? 'bg-[#C0392B] text-white font-medium' : 'text-[#1A1A1A] hover:bg-[#FAF5E9]'}`}
                        >
                          <span className="flex items-center gap-2">
                            <span 
                              className="w-1.5 h-1.5 rounded-full" 
                              style={{ backgroundColor: cat.couleur }}
                            ></span>
                            {cat.nom}
                          </span>
                          <span className="text-[10px] font-mono opacity-50">
                            {INITIAL_EVENEMENTS.filter(e => e.categorie_id === cat.id).length}
                          </span>
                        </button>
                      ))}
                    </div>
                  </div>

                  {/* CITIES FILTER */}
                  <div className="bg-white p-4 border border-[#1A1A1A] shadow-sm">
                    <h3 className="text-sm font-serif text-[#1A1A1A] uppercase tracking-wider mb-3 border-b pb-1.5 font-bold">
                      Régions & Villes
                    </h3>
                    <select 
                      value={selectedCity} 
                      onChange={(e) => setSelectedCity(e.target.value)}
                      className="w-full text-xs bg-[#FAF5E9] py-2 px-3 border border-[#1A1A1A] outline-none"
                    >
                      <option value="all">Tout le Burkina</option>
                      <option value="Ouagadougou">Ouagadougou (Centre)</option>
                      <option value="Bobo-Dioulasso">Bobo-Dioulasso (Sya)</option>
                      <option value="Koudougou">Koudougou (Bulkiemdé)</option>
                      <option value="Banfora">Banfora (Cascades)</option>
                      <option value="Dédougou">Dédougou (Boucle du Mouhoun)</option>
                      <option value="Kaya">Kaya (Sanmatenga)</option>
                    </select>
                  </div>

                  {/* SAHELIAN LIVE FM RADIO VISUALIZER */}
                  <div className="p-5 border-2 border-[#D4A017] text-white shadow-md relative overflow-hidden" style={{ backgroundImage: 'radial-gradient(circle, #2A2A2A 0%, #111111 100%)' }}>
                    <div className="absolute top-2 right-2 flex items-center gap-1.5 bg-[#C0392B] px-1.5 py-0.5 text-[8px] font-mono tracking-widest select-none">
                      <span className="w-1.5 h-1.5 bg-white rounded-full animate-ping"></span>
                      <span>{radioIndicator}</span>
                    </div>

                    <h4 className="text-xs font-serif text-[#D4A017] tracking-widest uppercase mb-1 flex items-center gap-1">
                      <Radio className="w-3.5 h-3.5 animate-bounce" /> Kassiri Radio Direct
                    </h4>
                    <p className="text-[10px] text-white/50 font-sans mb-3 leading-snug">
                      Récepteur national ondes courtes FM 95.40 MHz.
                    </p>

                    <div className="p-3 bg-black border border-white/10 rounded-sm mb-4 text-center">
                      <div className="text-[20px] font-mono font-bold text-[#D4A017] tracking-wider">
                        {liveRadioPlaying ? "95.40 FM" : "CH. COUPE"}
                      </div>
                      <div className="text-[9px] text-[#22C55E] uppercase font-mono mt-0.5">
                        {liveRadioPlaying ? "Symphonies du Baobab — ON" : "Ondes muettes"}
                      </div>
                    </div>

                    {liveRadioPlaying && (
                      <div className="flex justify-center items-center gap-1 my-3 h-5">
                        <span className="w-1 bg-[#D4A017] h-3 rounded-full animate-pulse"></span>
                        <span className="w-1 bg-[#D4A017] h-5 rounded-full animate-pulse delay-75"></span>
                        <span className="w-1 bg-[#D4A017] h-2 rounded-full animate-pulse delay-150"></span>
                        <span className="w-1 bg-[#D4A017] h-4 rounded-full animate-pulse delay-100"></span>
                        <span className="w-1 bg-[#D4A017] h-3 rounded-full animate-pulse delay-200"></span>
                      </div>
                    )}

                    <audio 
                      id="helix-player" 
                      src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3" 
                      preload="none"
                    />

                    <button 
                      onClick={toggleRadioDirect}
                      className="w-full bg-[#D4A017] text-black font-semibold text-xs py-1.5 px-3 uppercase tracking-wider font-serif hover:bg-white transition-all flex items-center justify-center gap-1"
                    >
                      {liveRadioPlaying ? (
                        <>
                          <VolumeX className="w-3 h-3" /> Éteindre la FM
                        </>
                      ) : (
                        <>
                          <Volume2 className="w-3 h-3" /> Brancher le live
                        </>
                      )}
                    </button>
                  </div>

                </div>

                {/* PUBLIC MULTI-GRID HERO & RESULTS */}
                <div className="lg:col-span-3 space-y-6">
                  
                  {/* IMMERSIVE BOGOLAN WELCOME PANEL */}
                  <div className="bg-[#1A1A1A] text-white p-6 md:p-8 relative overflow-hidden flex flex-col md:flex-row justify-between items-center border-4 border-[#D4A017] gap-4" style={{ backgroundImage: 'radial-gradient(circle, #2A2A2A 0%, #151515 100%)' }}>
                    <div className="space-y-2 text-center md:text-start">
                      <div className="bg-[#1A6B3C] text-white text-[9px] uppercase font-mono tracking-widest px-2.5 py-0.5 inline-block font-bold mb-1">
                        Burkina Faso Culture
                      </div>
                      <h2 className="text-xl md:text-2xl font-serif text-[#D4A017] tracking-wide uppercase m-0">
                        Ondes Sacrées et Voix du Faso
                      </h2>
                      <p className="text-xs text-white/70 max-w-xl m-0 leading-relaxed font-sans">
                        Parcourez les festivals légendaires du Burkina. Du salon de maroquinerie du SIAO, aux scènes populaires théâtrales de Bougsemtenga, réservez vos laissez-passer instantanés par paiement mobile local.
                      </p>
                    </div>

                    {/* COUNTDOWN TIMER TO FLOXY KOUDOUGOU */}
                    <div className="bg-black/50 p-4 border border-[#D4A017] text-center min-w-[150px]">
                      <div className="text-[10px] text-white/50 uppercase font-mono tracking-widest mb-1">PROCHAIN DIRECT</div>
                      <div className="text-[#C0392B] font-serif font-semibold text-lg leading-tight uppercase">Floby Live</div>
                      <div className="text-xs text-[#22C55E] font-mono mt-1 font-bold animate-pulse">DANS 4 JOURS</div>
                    </div>
                  </div>

                  {/* ACTIVE RESULTS GRID COUNTER */}
                  <div className="flex justify-between items-center border-b border-[#1A1A1A] pb-2">
                    <span className="text-xs font-serif text-[#1A1A1A] uppercase tracking-wider font-bold">
                      Affiches actives ({filteredEvents.length} scènes trouvées)
                    </span>
                    <span className="text-xs font-mono text-[#C0392B] font-semibold">
                      {selectedCity !== 'all' ? `Ville: ${selectedCity}` : 'Tout le pays'}
                    </span>
                  </div>

                  {/* EVENTS CARDS MULTI-GRID */}
                  {filteredEvents.length > 0 ? (
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                      {filteredEvents.map(ev => {
                        const cat = INITIAL_CATEGORIES.find(c => c.id === ev.categorie_id);
                        return (
                          <div 
                            key={ev.id}
                            className="bg-white border border-[#1A1A1A] hover:shadow-md transition-all flex flex-col h-full relative"
                          >
                            {/* Color Discipline tag */}
                            <div 
                              className="absolute top-2 left-2 text-[9px] uppercase font-mono px-2 py-0.5 text-white/90 z-10 font-bold tracking-wider"
                              style={{ backgroundColor: cat?.couleur || '#C0392B' }}
                            >
                              {cat?.nom || 'Culture'}
                            </div>

                            {/* Event Image */}
                            <div className="aspect-video w-full overflow-hidden bg-gray-100 relative">
                              <img 
                                src={ev.image} 
                                alt={ev.titre}
                                className="w-full h-full object-cover hover:scale-105 transition-all duration-300"
                              />
                            </div>

                            {/* Card Details */}
                            <div className="p-4 flex-1 flex flex-col justify-between">
                              <div className="space-y-1.5">
                                <div className="flex items-center gap-1 text-[10px] text-gray-500 font-mono">
                                  <MapPin className="w-3 h-3 text-[#C0392B]" />
                                  <span>{ev.ville} (Faso)</span>
                                </div>
                                <h3 className="font-serif text-[#1A1A1A] font-semibold hover:text-[#C0392B] transition-colors text-sm line-clamp-2 leading-snug">
                                  {ev.titre}
                                </h3>
                                <p className="text-xs text-gray-600 font-sans line-clamp-3 leading-snug">
                                  {ev.description}
                                </p>
                              </div>

                              <div className="pt-4 border-t mt-4 flex items-center justify-between">
                                <div>
                                  <span className="text-[9px] uppercase font-mono block text-gray-400">GUICHET</span>
                                  <span className="text-xs font-mono font-bold text-[#1A6B3C]">
                                    {ev.prix_normal > 0 ? `${ev.prix_normal.toLocaleString()} CFA` : 'Entrée Libre'}
                                  </span>
                                </div>

                                <button 
                                  onClick={() => setSelectedEventId(ev.id)}
                                  className="bg-transparent text-[#C0392B] hover:bg-[#C0392B] hover:text-white border border-[#C0392B] text-xs py-1 px-3 uppercase tracking-wider font-semibold font-serif transition-colors"
                                >
                                  Découvrir →
                                </button>
                              </div>
                            </div>
                          </div>
                        );
                      })}
                    </div>
                  ) : (
                    <div className="bg-white p-12 text-center border border-dashed border-gray-300">
                      <XCircle className="w-12 h-12 text-gray-400 mx-auto mb-2" />
                      <p className="text-sm font-serif text-gray-600">Aucune scène ne correspond à ces critères d'art.</p>
                      <button 
                        onClick={() => { setSearchTerm(''); setSelectedCatId(null); setSelectedCity('all'); }}
                        className="bg-transparent text-[#C0392B] border border-[#C0392B] text-xs px-4 py-1.5 mt-2 uppercase font-mono"
                      >
                        Réinitialiser la carte
                      </button>
                    </div>
                  )}

                  {/* SAHELIAN MUSÉE D'ART CONTEMPORAIN EXCLU */}
                  <div className="bg-white p-5 border border-[#1A1A1A] shadow-sm">
                    <h3 className="text-sm font-serif text-[#1A1A1A] uppercase tracking-wider mb-2 border-b pb-1.5 font-bold">
                      🏞️ Galerie Muséographique Vivante (SIAO & Laongo Bronzes)
                    </h3>
                    <p className="text-xs text-gray-500 font-sans mb-4">
                      Explorez virtuellement les bronzes sculptés à cire perdue etBogolan peints par nos artistes nationaux burkinabè.
                    </p>
                    <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                      {INITIAL_GALERIE.slice(0, 4).map(pic => (
                        <div key={pic.id} className="relative aspect-square overflow-hidden bg-gray-100 group border">
                          <img 
                            src={pic.image} 
                            alt={pic.titre} 
                            className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                          />
                          <div className="absolute inset-0 bg-black/75 opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-3">
                            <span className="text-[10px] text-white font-serif tracking-tight leading-snug">{pic.titre}</span>
                          </div>
                        </div>
                      ))}
                    </div>
                  </div>

                </div>

              </div>
            ) : (
              // PUBLIC ACTIVE DETAIL SCENE SCREEN
              <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {/* BACK NAVIGATION */}
                <div className="col-span-full">
                  <button 
                    onClick={() => { setSelectedEventId(null); setTicketSuccessData(null); }}
                    className="flex items-center gap-1.5 text-xs text-[#C0392B] font-mono hover:underline uppercase bg-transparent border-0 outline-none pb-2"
                  >
                    <ArrowLeft className="w-3.5 h-3.5" /> Retourner à la liste nationale
                  </button>
                </div>

                {/* DETAIL SCENE CORE INFO COLUMN */}
                <div className="lg:col-span-2 space-y-6">
                  
                  <div className="bg-white p-5 md:p-6 border border-[#1A1A1A] shadow-sm space-y-4">
                    <div className="aspect-video w-full overflow-hidden bg-gray-100">
                      <img 
                        src={selectedEvent?.image} 
                        alt={selectedEvent?.titre} 
                        className="w-full h-full object-cover"
                      />
                    </div>
                    
                    <div>
                      <span className="text-xs text-[#C0392B] font-mono block mb-1">
                        FESTIVAL OFFICIEL BURKINABÈ
                      </span>
                      <h2 className="text-lg md:text-xl font-serif text-[#1A1A1A] font-semibold tracking-tight uppercase">
                        {selectedEvent?.titre}
                      </h2>
                    </div>

                    <div className="grid grid-cols-2 gap-4 text-xs font-mono text-gray-600 bg-[#FAF5E9] p-3 border">
                      <div>
                        <span className="text-[9px] uppercase text-gray-400 block">LIEU CENTRAL</span>
                        <span className="text-dark font-bold font-serif">{selectedEvent?.lieu} ({selectedEvent?.ville})</span>
                      </div>
                      <div>
                        <span className="text-[9px] uppercase text-gray-400 block">PROGRAMMATION</span>
                        <span className="text-dark font-bold">
                          {selectedEvent?.date_debut ? new Date(selectedEvent.date_debut).toLocaleDateString('fr-FR') : 'Date à venir'}
                        </span>
                      </div>
                    </div>

                    <p className="text-xs text-gray-700 leading-relaxed font-sans">
                      {selectedEvent?.description}
                    </p>
                  </div>

                  {/* COMMENTS MODULATOR FOR THis SCENE */}
                  <div className="bg-white p-5 border border-[#1A1A1A] shadow-sm space-y-4">
                    <h4 className="text-sm font-serif text-[#1A1A1A] uppercase tracking-wider border-b pb-1.5 font-bold flex justify-between items-center">
                      <span>Laissez votre Avis Critique</span>
                      <span className="text-[10px] text-gray-400 font-mono normal-case">Médiation culturelle</span>
                    </h4>

                    {/* SUBMIT COMMENT FORM */}
                    <form onSubmit={handleCommentSubmit} className="space-y-3">
                      <div className="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
                        <div>
                          <label className="form-label block font-serif font-bold text-dark mb-1">Votre Surnom / Nom :</label>
                          <input 
                            type="text" 
                            required
                            value={commentName}
                            onChange={(e) => setCommentName(e.target.value)}
                            placeholder="Ex: Alassane le Sage"
                            className="w-full bg-[#FAF5E9] p-2 border border-[#1A1A1A] outline-none"
                          />
                        </div>
                        <div>
                          <label className="form-label block font-serif font-bold text-dark mb-1">Note de satisfaction :</label>
                          <select 
                            value={commentRating}
                            onChange={(e) => setCommentRating(Number(e.target.value))}
                            className="w-full bg-[#FAF5E9] p-2 border border-[#1A1A1A] outline-none font-sans"
                          >
                            <option value={5}>⭐⭐⭐⭐⭐ (Excellente)</option>
                            <option value={4}>⭐⭐⭐⭐ (Très Bien)</option>
                            <option value={3}>⭐⭐⭐ (Passable)</option>
                            <option value={2}>⭐⭐ (Mauvais)</option>
                            <option value={1}>⭐ (Inadmissible)</option>
                          </select>
                        </div>
                      </div>
                      <div className="text-xs">
                        <label className="form-label block font-serif font-bold text-dark mb-1">Votre message court :</label>
                        <textarea 
                          required
                          value={commentText}
                          onChange={(e) => setCommentText(e.target.value)}
                          placeholder="Écrivez-nous en détails sur l'exposition..."
                          rows={3}
                          className="w-full bg-[#FAF5E9] p-2 border border-[#1A1A1A] outline-none text-xs"
                        />
                      </div>
                      <button 
                        type="submit"
                        className="bg-[#C0392B] text-white text-xs px-4 py-2 uppercase font-serif tracking-widest font-semibold"
                      >
                        Soumettre mon Avis <Send className="w-3 h-3 inline ms-1" />
                      </button>
                    </form>

                    {/* RENDER LOGICAL REVIEWS FROM STATE */}
                    <div className="space-y-3 pt-3 border-t">
                      {userComments.filter(c => c.evenement_id === selectedEventId).map(comm => (
                        <div key={comm.id} className="bg-[#FAF5E9]/50 p-3 border text-xs">
                          <div className="flex justify-between items-center mb-1">
                            <span className="font-bold text-dark font-serif">{comm.nom}</span>
                            <span className="text-[#D4A017] font-mono">
                              {"★".repeat(comm.note) + "☆".repeat(5 - comm.note)}
                            </span>
                          </div>
                          <p className="text-gray-600 m-0 leading-relaxed font-sans">
                            {comm.contenu}
                          </p>
                        </div>
                      ))}
                    </div>

                  </div>

                </div>

                {/* PUBLIC RIGHT COLUMN: TICKET SHOPPING SECTOR */}
                <div className="lg:col-span-1 space-y-6">
                  
                  {/* DETAILED MOUNT TICKET WIDGET */}
                  <div className="bg-white p-5 border-2 border-[#1A6B3C] shadow-md space-y-4">
                    <div className="border-b pb-2">
                      <span className="bg-[#1A6B3C] text-white text-[9px] uppercase font-mono px-2 py-0.5 inline-block font-bold">
                        Guichet Ticket Mobile
                      </span>
                      <h3 className="font-serif text-[#1A1A1A] uppercase tracking-wider font-bold text-sm mt-1">
                        Prendre vos Pass Instantanés
                      </h3>
                    </div>

                    {!ticketSuccessData ? (
                      <form onSubmit={handlePurchase} className="space-y-3">
                        
                        <div className="text-xs">
                          <label className="form-label block font-serif font-bold text-dark mb-1">Pass choisi :</label>
                          <div className="flex gap-2">
                            <button 
                              type="button" 
                              onClick={() => setTicketType('normal')}
                              className={`flex-1 p-2 border text-xs uppercase font-serif tracking-wider ${ticketType === 'normal' ? 'bg-[#1A6B3C] text-white border-transparent' : 'bg-[#FAF5E9] border-[#1A1A1A] text-dark'}`}
                            >
                              Normal ({selectedEvent?.prix_normal?.toLocaleString() || 0} CFA)
                            </button>
                            <button 
                              type="button" 
                              onClick={() => setTicketType('vip')}
                              className={`flex-1 p-2 border text-xs uppercase font-serif tracking-wider ${ticketType === 'vip' ? 'bg-[#D4A017] text-black border-transparent' : 'bg-[#FAF5E9] border-[#1A1A1A] text-dark'}`}
                            >
                              VIP ({selectedEvent?.prix_vip?.toLocaleString() || 0} CFA)
                            </button>
                          </div>
                        </div>

                        <div className="text-xs">
                          <label className="form-label block font-serif font-bold text-dark mb-1">Quantité :</label>
                          <select 
                            value={ticketQty}
                            onChange={(e) => setTicketQty(Number(e.target.value))}
                            className="w-full bg-[#FAF5E9] p-2 border border-[#1A1A1A] outline-none"
                          >
                            <option value={1}>1 place</option>
                            <option value={2}>2 places</option>
                            <option value={3}>3 places</option>
                            <option value={5}>5 places</option>
                          </select>
                        </div>

                        <div className="text-xs">
                          <label className="form-label block font-serif font-bold text-dark mb-1">Votre Nom complet :</label>
                          <input 
                            type="text" 
                            required 
                            value={ticketName}
                            onChange={(e) => setTicketName(e.target.value)}
                            placeholder="Ex: Ousmane Kaboré"
                            className="w-full bg-[#FAF5E9] p-2 border border-[#1A1A1A] outline-none"
                          />
                        </div>

                        <div className="text-xs">
                          <label className="form-label block font-serif font-bold text-dark mb-1">Votre Email :</label>
                          <input 
                            type="email" 
                            required 
                            value={ticketEmail}
                            onChange={(e) => setTicketEmail(e.target.value)}
                            placeholder="okabore@gmail.com"
                            className="w-full bg-[#FAF5E9] p-2 border border-[#1A1A1A] outline-none"
                          />
                        </div>

                        <div className="text-xs">
                          <label className="form-label block font-serif font-bold text-dark mb-1">Téléphone Securisé (Paiement) :</label>
                          <input 
                            type="text" 
                            required 
                            value={ticketTel}
                            onChange={(e) => setTicketTel(e.target.value)}
                            placeholder="Ex: +226 70 00 00 00"
                            className="w-full bg-[#FAF5E9] p-2 border border-[#1A1A1A] outline-none font-mono"
                          />
                        </div>

                        {/* MOBILE PAYMENT SECTOR MOCK */}
                        <div className="text-xs space-y-2 pt-2 border-t">
                          <label className="form-label block font-serif font-bold text-dark mb-1">Opérateur de Mobile Money :</label>
                          <div className="grid grid-cols-2 gap-2">
                            <label className="flex items-center gap-2 p-2 border bg-[#FAF5E9] cursor-pointer">
                              <input 
                                type="radio" 
                                name="gateway" 
                                checked={ticketGateway === 'orange'} 
                                onChange={() => setTicketGateway('orange')} 
                              />
                              <span className="text-xs font-bold text-[#FF8C00]">Orange Money</span>
                            </label>
                            <label className="flex items-center gap-2 p-2 border bg-[#FAF5E9] cursor-pointer">
                              <input 
                                type="radio" 
                                name="gateway" 
                                checked={ticketGateway === 'moov'} 
                                onChange={() => setTicketGateway('moov')} 
                              />
                              <span className="text-xs font-bold text-[#006400]">Moov Money</span>
                            </label>
                          </div>
                        </div>

                        {/* SUMULATION BUTTON */}
                        <button 
                          type="submit"
                          className="w-full bg-[#1A6B3C] hover:bg-black text-white py-2.5 font-semibold text-xs tracking-wider uppercase font-serif mt-3 transition-colors flex items-center justify-center gap-1"
                        >
                          <Ticket className="w-4 h-4" /> Finaliser mon Pass
                        </button>
                      </form>
                    ) : (
                      // RENDER DETAILED QR GENERATION PASS
                      <div className="p-4 bg-[#FAF5E9] border-2 border-dashed border-[#1A6B3C] text-center space-y-4">
                        <CheckCircle className="w-10 h-10 text-[#1A6B3C] mx-auto" />
                        <div>
                          <div className="text-xs text-uppercase font-mono font-bold tracking-wider text-muted">VOTRE PASS DIGITAL RENDU</div>
                          <div className="text-md font-serif text-dark font-bold uppercase mt-1">BIENVENUE CHEZ KASSIRI</div>
                        </div>

                        {/* Virtual Simulated QR Code box */}
                        <div className="w-44 h-44 bg-white border border-[#1A1A1A] mx-auto p-3 flex flex-col justify-between items-center shadow-sm">
                          {/* QR Mock graphic with pixel look */}
                          <div className="grid grid-cols-6 gap-1 w-full h-full p-2 opacity-80" id="qr-mock-canvas">
                            {[...Array(36)].map((_, idx) => (
                              <div 
                                key={idx} 
                                className={`w-full h-full ${(idx % 3 === 0 || idx % 4 === 1 || idx < 6 || idx % 6 === 0) ? 'bg-[#1A1A1A]' : 'bg-transparent'}`}
                              ></div>
                            ))}
                          </div>
                        </div>

                        <div className="text-xs font-mono text-[#C0392B] font-bold tracking-wide">
                          {ticketSuccessData.code}
                        </div>

                        <div className="text-[10px] text-gray-500 font-sans leading-relaxed">
                          Un message SMS de validation a été envoyé sur <strong className="text-dark">{ticketTel}</strong>. Conservez précieusement ce code pour le portillon !
                        </div>

                        <button 
                          onClick={() => setTicketSuccessData(null)}
                          className="w-full bg-black text-white text-[10px] py-1 uppercase font-mono mt-2"
                        >
                          Acheter un autre pass
                        </button>
                      </div>
                    )}

                  </div>

                  <div className="p-4 bg-[#FAF5E9] border border-gray-300 text-xs">
                    <h5 className="font-serif fw-bold text-brand-dark mb-1">MÉDIATION PROTOCOLE</h5>
                    <p className="text-gray-500 font-sans leading-snug m-0">
                      Les guichets de Kassiri Pulse acceptent l'immense majorité des applications mobiles locales. En cas de blocage d'autorisation, contactez l'administration de Koulouba.
                    </p>
                  </div>

                </div>

              </div>
            )}
          </div>
        )}

        {/* ADMIN INTERACTION TAB */}
        {activeSegment === 'admin' && (
          <div className="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            {/* ADMIN BAR SIDE CONTROLLERS */}
            <div className="lg:col-span-1">
              <div className="bg-[#1A1A1A] text-white p-4 border border-[#D4A017] space-y-2">
                <div className="border-b border-white/20 pb-2 mb-3">
                  <div className="flex items-center gap-1">
                    <ShieldCheck className="w-4 h-4 text-[#D4A017]" />
                    <span className="text-xs uppercase font-serif text-[#D4A017] tracking-wider font-semibold">PANEL SÉCURISÉ</span>
                  </div>
                  <span className="text-[9px] text-white/50 block font-mono">ADMIN: ROOT@KASSIRI</span>
                </div>

                <div className="space-y-1">
                  <button 
                    onClick={() => { setAdminSection('stats'); setIsAddingEvent(false); }}
                    className={`w-full text-left font-serif text-xs px-3 py-2 uppercase tracking-wider block transition-colors ${adminSection === 'stats' && !isAddingEvent ? 'bg-[#C0392B] text-white border border-[#D4A017]' : 'text-white/70 hover:bg-white/5'}`}
                  >
                    📈 Statistiques d'audience
                  </button>
                  <button 
                    onClick={() => { setAdminSection('events'); setIsAddingEvent(false); }}
                    className={`w-full text-left font-serif text-xs px-3 py-2 uppercase tracking-wider block transition-colors ${adminSection === 'events' && !isAddingEvent ? 'bg-[#C0392B] text-white border border-[#D4A017]' : 'text-white/70 hover:bg-white/5'}`}
                  >
                    📅 Événements & Affichage
                  </button>
                  <button 
                    onClick={() => { setAdminSection('scanner'); setIsAddingEvent(false); }}
                    className={`w-full text-left font-serif text-xs px-3 py-2 uppercase tracking-wider block transition-colors ${adminSection === 'scanner' && !isAddingEvent ? 'bg-[#C0392B] text-white border border-[#D4A017]' : 'text-white/70 hover:bg-white/5'}`}
                  >
                    📸 Validations QR Scanner
                  </button>
                </div>
              </div>
            </div>

            {/* ADMIN CONTENT SECTOR VIEWPORTS */}
            <div className="lg:col-span-3">
              
              {/* SECTION 1: STATS DATA DASHBOARD */}
              {adminSection === 'stats' && !isAddingEvent && (
                <div className="space-y-6">
                  
                  {/* METRICS BLOCKS */}
                  <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div className="bg-white p-4 border-l-4 border-[#C0392B] border border-gray-200">
                      <span className="text-[10px] uppercase font-mono tracking-wider text-gray-400 block">SESSIONS DIRECTES</span>
                      <h4 className="text-xl font-serif font-bold text-dark mt-1 mb-0">12 Scènes Actives</h4>
                      <span className="text-success text-[10px] font-bold block mt-1">✔ Index sécurisé</span>
                    </div>
                    <div className="bg-white p-4 border-l-4 border-[#1A6B3C] border border-gray-200">
                      <span className="text-[10px] uppercase font-mono tracking-wider text-gray-400 block">RECETTES LOCALES</span>
                      <h4 className="text-xl font-serif font-bold text-dark mt-1 mb-0">1 450 000 CFA</h4>
                      <span className="text-[#D4A017] text-[10px] font-bold block mt-1">✔ Orange Money & Moov</span>
                    </div>
                    <div className="bg-white p-4 border-l-4 border-[#D4A017] border border-gray-200">
                      <span className="text-[10px] uppercase font-mono tracking-wider text-gray-400 block">CRITIQUES TOTALES</span>
                      <h4 className="text-xl font-serif font-bold text-dark mt-1 mb-0">25 Avis Approuvés</h4>
                      <span className="text-success text-[10px] font-bold block mt-1">✔ Modération OK</span>
                    </div>
                  </div>

                  {/* CHART DECORATORS */}
                  <div className="bg-white p-5 border border-gray-300">
                    <h3 className="text-xs font-serif text-dark uppercase tracking-wider border-b pb-2 mb-4">
                      Ventes cumulées trimestrielles des festivals (CFA)
                    </h3>
                    
                    {/* Visual custom CSS bar chart */}
                    <div className="space-y-3">
                      <div>
                        <div className="flex justify-between text-[11px] font-mono text-gray-500 mb-1">
                          <span>Salon International SIAO (Ouagadougou)</span>
                          <span className="font-bold">650 000 CFA</span>
                        </div>
                        <div className="w-full bg-[#FAF5E9] h-4 border">
                          <div className="bg-[#C0392B] h-full" style={{ width: '85%' }}></div>
                        </div>
                      </div>
                      <div>
                        <div className="flex justify-between text-[11px] font-mono text-gray-500 mb-1">
                          <span>Nuits Atypiques (Koudougou)</span>
                          <span className="font-bold">320 000 CFA</span>
                        </div>
                        <div className="w-full bg-[#FAF5E9] h-4 border">
                          <div className="bg-[#1A6B3C] h-full" style={{ width: '45%' }}></div>
                        </div>
                      </div>
                      <div>
                        <div className="flex justify-between text-[11px] font-mono text-gray-500 mb-1">
                          <span>Jazz à Ouaga (CENASA)</span>
                          <span className="font-bold">240 000 CFA</span>
                        </div>
                        <div className="w-full bg-[#FAF5E9] h-4 border">
                          <div className="bg-[#D4A017] h-full" style={{ width: '35%' }}></div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              )}

              {/* SECTION 2: EVENTS ADMINISTRATOR GRID */}
              {adminSection === 'events' && !isAddingEvent && (
                <div className="bg-white p-5 border border-gray-300 space-y-4">
                  <div className="flex justify-between items-center border-b pb-2 mb-3">
                    <h3 className="text-xs font-serif text-dark uppercase tracking-wider font-bold">
                      Répertoire des thématiques en ligne
                    </h3>
                    <button 
                      onClick={() => setIsAddingEvent(true)}
                      className="bg-[#C0392B] text-white text-[10px] py-1 px-3 uppercase font-mono font-bold"
                    >
                      + Créer un Événement
                    </button>
                  </div>

                  {/* DATA GRID OF EVENTS LIST */}
                  <div className="overflow-x-auto">
                    <table className="w-full text-xs text-left border-collapse font-sans text-gray-600">
                      <thead>
                        <tr className="bg-[#FAF5E9] border font-serif text-[#1A1A1A] text-[13px]">
                          <th className="p-2.5">Titre de la scène</th>
                          <th className="p-2.5">Date début</th>
                          <th className="p-2.5">Lieu / Ville</th>
                          <th className="p-2.5">Prix (CFA)</th>
                          <th className="p-2.5">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        {adminEvents.map(ev => (
                          <tr key={ev.id} className="border-b hover:bg-gray-50">
                            <td className="p-2.5 font-bold text-dark">{ev.titre}</td>
                            <td className="p-2.5 font-mono text-[11px]">{new Date(ev.date_debut).toLocaleDateString()}</td>
                            <td className="p-2.5">{ev.lieu} ({ev.ville})</td>
                            <td className="p-2.5 font-bold text-[#1A6B3C] font-mono">{ev.prix_normal.toLocaleString()} CFA</td>
                            <td className="p-2.5">
                              <button 
                                onClick={() => {
                                  setAdminEvents(adminEvents.filter(e => e.id !== ev.id));
                                }}
                                className="bg-transparent border-0 text-[#C0392B] hover:text-black p-1 cursor-pointer outline-none"
                                title="Supprimer"
                              >
                                <Trash2 className="w-4 h-4" />
                              </button>
                            </td>
                          </tr>
                        ))}
                      </tbody>
                    </table>
                  </div>
                </div>
              )}

              {/* RENDER NEW EVENT FORM INTERACTIVELY */}
              {isAddingEvent && (
                <div className="bg-white p-5 border border-gray-300">
                  <h3 className="text-sm font-serif text-[#1A1A1A] uppercase tracking-wider border-b pb-2 mb-4 font-bold flex justify-between items-center">
                    <span>Création d'Événement Culturel</span>
                    <button 
                      onClick={() => setIsAddingEvent(false)}
                      className="bg-gray-100 hover:bg-gray-200 text-dark text-[10px] py-1 px-3 border border-gray-300 uppercase font-mono"
                    >
                      Annuler
                    </button>
                  </h3>

                  <form onSubmit={handleAddEventSubmit} className="space-y-4 text-xs font-sans">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <div>
                        <label className="form-label block font-serif font-bold mb-1">Titre de l'événement :</label>
                        <input 
                          type="text" 
                          required
                          value={newEventTitle}
                          onChange={(e) => setNewEventTitle(e.target.value)}
                          placeholder="Ex: Conférence des Scaphandriers de Banfora"
                          className="w-full bg-[#FAF5E9] p-2 border outline-none font-sans"
                        />
                      </div>
                      <div>
                        <label className="form-label block font-serif font-bold mb-1">Discipline d'Art :</label>
                        <select 
                          value={newEventCat}
                          onChange={(e) => setNewEventCat(Number(e.target.value))}
                          className="w-full bg-[#FAF5E9] p-2 border outline-none font-sans"
                        >
                          {INITIAL_CATEGORIES.map(cat => (
                            <option key={cat.id} value={cat.id}>{cat.nom}</option>
                          ))}
                        </select>
                      </div>
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <div>
                        <label className="form-label block font-serif font-bold mb-1">Localisation Ville :</label>
                        <select 
                          value={newEventCity}
                          onChange={(e) => setNewEventCity(e.target.value)}
                          className="w-full bg-[#FAF5E9] p-2 border outline-none font-sans"
                        >
                          <option value="Ouagadougou">Ouagadougou</option>
                          <option value="Bobo-Dioulasso">Bobo-Dioulasso</option>
                          <option value="Koudougou">Koudougou</option>
                          <option value="Banfora">Banfora</option>
                        </select>
                      </div>
                      <div>
                        <label className="form-label block font-serif font-bold mb-1">Prix de la place (CFA) :</label>
                        <input 
                          type="number" 
                          required
                          value={newEventPrice}
                          onChange={(e) => setNewEventPrice(Number(e.target.value))}
                          className="w-full bg-[#FAF5E9] p-2 border outline-none font-mono"
                        />
                      </div>
                    </div>

                    <div>
                      <label className="form-label block font-serif font-bold mb-1">Description narrative :</label>
                      <textarea 
                        required
                        value={newEventDesc}
                        onChange={(e) => setNewEventDesc(e.target.value)}
                        placeholder="Précisez en quelques phrases l'esprit de l'événement..."
                        rows={4}
                        className="w-full bg-[#FAF5E9] p-2 border outline-none text-xs"
                      />
                    </div>

                    <button 
                      type="submit"
                      className="w-full bg-[#1A6B3C] text-white py-2 font-serif uppercase tracking-widest font-bold border border-transparent hover:bg-black transition-colors"
                    >
                      Enregistrer et Publier la Scène
                    </button>
                  </form>
                </div>
              )}

              {/* SECTION 3: QR CHECKOUT VALIDATOR SIMULATOR */}
              {adminSection === 'scanner' && !isAddingEvent && (
                <div className="bg-white p-5 border border-gray-300 space-y-4">
                  <h3 className="text-xs font-serif text-dark uppercase tracking-wider border-b pb-2">
                    Terminal sécurisé de vérification de Pass
                  </h3>
                  <p className="text-xs text-gray-500 font-sans">
                    Entrez manuellement un code coupon de réservation unique de spectateur (de forme <strong className="text-[#C0392B]">BIL-KPS-XXXX-BF</strong>) pour tester le scanning aux portiques.
                  </p>

                  <form onSubmit={handleScanSimulate} className="flex gap-2">
                    <input 
                      type="text" 
                      required
                      value={searchTicketCode}
                      onChange={(e) => setSearchTicketCode(e.target.value)}
                      placeholder="Ex: BIL-KPS-1425-BF"
                      className="flex-1 bg-[#FAF5E9] py-2 px-3 border outline-none font-mono text-dark font-bold text-uppercase"
                    />
                    <button 
                      type="submit"
                      className="bg-[#C0392B] hover:bg-black text-white text-xs px-4 py-2 uppercase font-mono font-bold border-0"
                    >
                      Frapper le code
                    </button>
                  </form>

                  {/* DISPLAY RENDER VALIDATION STATUS BOARD */}
                  <div className="p-6 bg-black text-[#1A6B3C] rounded-sm text-center min-h-[160px] flex flex-col justify-center items-center font-mono">
                    {scanResult?.status === 'idle' && (
                      <div className="space-y-2">
                        <ArrowLeft className="w-10 h-10 text-gray-700 animate-pulse mx-auto transform rotate-90" />
                        <div className="text-gray-500 text-xs">SAISIR LE CODE COUPON AUX PORTES</div>
                      </div>
                    )}

                    {scanResult?.status === 'valid' && (
                      <div className="space-y-1">
                        <CheckCircle className="w-10 h-10 text-emerald-500 mx-auto" />
                        <div className="text-emerald-500 text-sm font-bold tracking-widest">{scanResult.message}</div>
                        <div className="text-white text-xs font-bold mt-1">{scanResult.buyer}</div>
                      </div>
                    )}

                    {scanResult?.status === 'invalid' && (
                      <div className="space-y-1">
                        <XCircle className="w-10 h-10 text-rose-500 mx-auto" />
                        <div className="text-rose-500 text-sm font-bold tracking-widest">{scanResult.message}</div>
                        <div className="text-white/60 text-[10px] mt-1 font-bold">Tentez un code commençant par 'BIL-'</div>
                      </div>
                    )}
                  </div>
                </div>
              )}

            </div>
          </div>
        )}

        {/* CODE EXPORT WORKSPACE TAB */}
        {activeSegment === 'code' && (
          <div className="bg-white border border-gray-300 p-5 shadow-sm space-y-4">
            <div className="border-b pb-2 flex flex-col md:flex-row justify-between items-start md:items-center gap-2">
              <div>
                <span className="bg-[#D4A017] text-black text-[9px] uppercase font-mono px-2 py-0.5 inline-block font-bold">
                  Syllabus Technique
                </span>
                <h3 className="font-serif text-[#1A1A1A] uppercase tracking-wider font-bold text-sm mt-1">
                  Revue des Scripts MVC et Schémas SQL Exportables
                </h3>
              </div>
              <span className="text-xs text-gray-500 font-sans hidden md:inline">
                Fichiers prêts pour déploiement Hostinger (Apache/PHP 8.x)
              </span>
            </div>

            <p className="text-xs text-gray-600 font-sans leading-relaxed m-0">
              Ces fichiers représentent l'exacte structure MVC simplifiée qui a été écrite dans le dossier <strong className="text-[#C0392B]">kassiri-pulse/</strong> de votre espace de travail. Vous pouvez d'ores et déjà les copier et les héberger sur votre serveur Apache de production.
            </p>

            <div className="grid grid-cols-1 lg:grid-cols-4 gap-6 pt-2">
              
              {/* FILE SELECTOR VERTICAL RAIL */}
              <div className="lg:col-span-1 space-y-1.5">
                {codeFiles.map((file, idx) => (
                  <button 
                    key={idx}
                    onClick={() => setActiveSnippetId(idx)}
                    className={`w-full text-left font-mono text-[11px] px-3 py-2 border transition-all flex items-center justify-between group cursor-pointer ${activeSnippetId === idx ? 'bg-[#1A1A1A] text-white border-transparent' : 'bg-[#FAF5E9] hover:bg-gray-100 text-dark border-gray-200'}`}
                  >
                    <span className="flex items-center gap-2 truncate">
                      <FileCode className={`w-3.5 h-3.5 ${activeSnippetId === idx ? 'text-[#D4A017]' : 'text-gray-400'}`} />
                      <span className="truncate">{file.name}</span>
                    </span>
                    <span className="text-[9px] uppercase opacity-60 text-[9px]">{file.type}</span>
                  </button>
                ))}
              </div>

              {/* RENDER ACTIVE CODE VIEWER BLOCK */}
              <div className="lg:col-span-3 border border-gray-300 flex flex-col">
                <div className="bg-[#FAF5E9] border-b p-2 flex justify-between items-center text-xs font-mono text-gray-600">
                  <span className="font-semibold text-dark flex items-center gap-1.5">
                    <Database className="w-4 h-4 text-[#C0392B]" /> Path: <span className="font-bold text-[#C0392B]">kassiri-pulse/{codeFiles[activeSnippetId].path}</span>
                  </span>
                  
                  {/* COPY TRIGGER ACTION */}
                  <button 
                    onClick={() => copyToClipboard(codeFiles[activeSnippetId].content, activeSnippetId)}
                    className="bg-white hover:bg-gray-100 border text-[10px] px-2.5 py-1 text-dark flex items-center gap-1 font-mono uppercase cursor-pointer"
                  >
                    {copiedIndex === activeSnippetId ? (
                      <>
                        <Check className="w-3.5 h-3.5 text-green-600" /> Copié
                      </>
                    ) : (
                      <>
                        <Copy className="w-3.5 h-3.5" /> Copier le code
                      </>
                    )}
                  </button>
                </div>

                <div className="p-4 bg-[#1E1E1E] text-[#D4D4D4] font-mono text-xs overflow-x-auto select-all leading-normal max-h-[450px]">
                  <pre className="m-0 select-all">{codeFiles[activeSnippetId].content}</pre>
                </div>
              </div>

            </div>
          </div>
        )}

      </main>

      {/* FOOTER BLOCK WITH METRIC CREDITS */}
      <footer className="bg-[#1A1A1A] text-white py-8 px-4 md:px-8 border-t-4 border-[#C0392B] mt-12">
        <div className="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4 text-center md:text-start">
          <div className="space-y-1">
            <h5 className="font-serif text-[#D4A017] uppercase tracking-wider mb-0 text-md">
              KASSIRI PULSE
            </h5>
            <p className="text-xs text-white/50 m-0 font-sans">
              Portail culturel national burkinabè et billetteries de festivals sahéliens.
            </p>
          </div>
          <div className="text-xs font-mono text-white/40">
            © 2026 KASSIRI PULSE CORP. TOUS DROITS RÉSERVÉS INPI BF.
          </div>
        </div>
      </footer>

    </div>
  );
}
