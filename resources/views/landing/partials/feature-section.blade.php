<section class="relative py-28 overflow-hidden" id="features">
    <div class="absolute inset-0 opacity-50 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-12">
      {{-- Section label --}}
      <div class="reveal text-center mb-20">
        <span class="inline-block border border-gold/30 text-gold text-xs font-semibold tracking-[0.2em] uppercase px-4 py-1.5 rounded-full mb-5">Everything You Need</span>
        <h2 class="font-['Playfair_Display',serif] text-4xl lg:text-5xl font-bold text-white">
          Built for <span class="gold-shimmer">Real Travellers</span>
        </h2>
        <p class="mt-4 text-slate-400 max-w-xl mx-auto text-base leading-relaxed">
          From weekend getaways to month-long expeditions — manage every detail with elegance.
        </p>
      </div>

      {{-- Feature grid --}}
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach([
          ['assets/feature-section/map.png','Smart Itinerary Builder','Drag-and-drop days, add stops, and reorder activities. Your perfect day, perfectly arranged.','from-blue-500/10 to-blue-600/5','border-blue-500/20'],
          ['assets/feature-section/location.png','Live Destination Pins','Drop pins on interactive maps, link to hotels & attractions, and see your route come alive.','from-gold/10 to-gold/5','border-gold/20'],
          ['assets/feature-section/aeroplane.png','Booking Tracker','Store flight numbers, hotel confirmations, and car rentals in one organized timeline.','from-purple-500/10 to-purple-600/5','border-purple-500/20'],
          ['assets/feature-section/team.png','Collaborative Planning','Invite your travel crew, assign tasks, and plan together in real-time — no more WhatsApp chaos.','from-emerald-500/10 to-emerald-600/5','border-emerald-500/20'],
          ['assets/feature-section/money-bag.png','Budget Manager','Set budgets per trip, log expenses as you go, and see clear breakdowns by category.','from-rose-500/10 to-rose-600/5','border-rose-500/20'],
          ['assets/feature-section/no-wifi.png','Offline Access','Download your itinerary for offline use. No Wi-Fi? No problem. Your trip is always with you.','from-amber-500/10 to-amber-600/5','border-amber-500/20'],
        ] as [$iconPath, $title, $desc, $grad, $border])
        <div class="reveal feature-card bg-gradient-to-br {{ $grad }} border {{ $border }} rounded-2xl p-7 backdrop-blur-sm cursor-default group">
          <div class="mb-4 group-hover:scale-110 transition-transform inline-block">
            <img src="{{ asset($iconPath) }}" alt="{{ $title }} icon" class="w-10 h-10" />
          </div>
          <h3 class="text-white font-semibold text-lg mb-2">{{ $title }}</h3>
          <p class="text-slate-400 text-sm leading-relaxed">{{ $desc }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </section>