@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-transparent text-white overflow-x-hidden font-['Sora',sans-serif] page-root" id="travel-landing">
  
  {{-- ════════════════════════════════════════
       HERO SECTION (redesigned with action.webm background)
  ════════════════════════════════════════ --}}
  <section class="relative min-h-screen flex items-center justify-center overflow-hidden gradient-bg">

    {{-- Top-left logo inside hero (mobile: icon only) --}}
    <a href="{{ route('landing') }}" class="absolute top-6 left-6 z-30 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 h-8 text-[#FF52A7]" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M12 2C8.134 2 5 5.134 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.866-3.134-7-7-7z" fill="#FF52A7" stroke="none"/>
          <circle cx="12" cy="9" r="2.5" fill="#FFF" />
        </svg>
        <span class="font-bold text-lg text-[#071022] tracking-tight hidden sm:inline">triptogether</span>
    </a>

    {{-- Top-right Sign In button --}}
    <a href="{{ route('login') }}" class="absolute top-6 right-6 z-30 btn-outline inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full text-[#071022] font-semibold text-sm hover:bg-[#FF52A7]/5">
      Sign In
    </a>

    {{-- Hero content (left content, right illustration) --}}
    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-12 pt-10 pb-24">
      <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-8">

        {{-- Left: minimalist content --}}
        <div class="max-w-xl flex flex-col justify-center">
          {{-- Headline (clean and simple) --}}
          <h1 class="font-['Playfair_Display',serif] text-5xl sm:text-6xl lg:text-7xl font-black leading-tight mb-6 text-[#071022] animate-float-up">
            Plan Your <span class="gold-shimmer">Next</span> Trip
          </h1>

          {{-- Minimal subheading --}}
          <p class="text-slate-600 text-base lg:text-lg leading-relaxed mb-10 max-w-md animate-float-up delay-100">
            Smart itinerary planner for modern travellers. Design, organize, and share your adventures effortlessly.
          </p>

          {{-- Single CTA --}}
          <div class="animate-float-up delay-200">
            <a href="{{ route('register', ['plan' => 'free']) }}" class="btn-primary inline-flex items-center gap-2 px-8 py-4 rounded-xl text-[#071022] font-bold text-lg tracking-wide btn-glow hover:shadow-lg transition-all">
              Get Started Free
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
              </svg>
            </a>
          </div>
        </div>

        {{-- Right: decorative SVG illustration (added to public/assets) --}}
        <div class="hidden md:flex justify-center items-center">
          <img src="{{ asset('assets/travel.svg') }}" alt="Travel illustration" class="w-full max-w-lg animate-slide-right pointer-events-none">
        </div>
      </div>
    </div>
  </section>

  {{-- ════════════════════════════════════════
       STATS STRIP
  ════════════════════════════════════════ --}}
  <section class="bg-[#FFF8F3] border-y border-[#FF52A7]/10 py-10" id="stats">
      <div class="max-w-6xl mx-auto px-6 grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
      @foreach([
        ['12K+','Active Travellers'],
        ['95K+','Trips Planned'],
        ['500+','Destinations Covered'],
        ['4.9★','Average Rating'],
      ] as $stat)
      <div class="reveal">
        <div class="font-['Playfair_Display',serif] text-4xl font-bold gold-shimmer mb-1">{{ $stat[0] }}</div>
        <div class="text-slate-500 text-sm tracking-wide">{{ $stat[1] }}</div>
      </div>
      @endforeach
    </div>
  </section>

  {{-- ════════════════════════════════════════
       FEATURES SECTION
  ════════════════════════════════════════ --}}
  <section class="relative py-28 overflow-hidden" id="features">
    <div class="absolute inset-0 opacity-50 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-12">
      {{-- Section label --}}
      <div class="reveal text-center mb-20">
        <span class="inline-block border border-[#C9A84C]/30 text-[#C9A84C] text-xs font-semibold tracking-[0.2em] uppercase px-4 py-1.5 rounded-full mb-5">Everything You Need</span>
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
          ['🗺️','Smart Itinerary Builder','Drag-and-drop days, add stops, and reorder activities. Your perfect day, perfectly arranged.','from-blue-500/10 to-blue-600/5','border-blue-500/20'],
          ['📍','Live Destination Pins','Drop pins on interactive maps, link to hotels & attractions, and see your route come alive.','from-[#C9A84C]/10 to-[#C9A84C]/5','border-[#C9A84C]/20'],
          ['✈️','Booking Tracker','Store flight numbers, hotel confirmations, and car rentals in one organized timeline.','from-purple-500/10 to-purple-600/5','border-purple-500/20'],
          ['👥','Collaborative Planning','Invite your travel crew, assign tasks, and plan together in real-time — no more WhatsApp chaos.','from-emerald-500/10 to-emerald-600/5','border-emerald-500/20'],
          ['💰','Budget Manager','Set budgets per trip, log expenses as you go, and see clear breakdowns by category.','from-rose-500/10 to-rose-600/5','border-rose-500/20'],
          ['📱','Offline Access','Download your itinerary for offline use. No Wi-Fi? No problem. Your trip is always with you.','from-amber-500/10 to-amber-600/5','border-amber-500/20'],
        ] as [$icon, $title, $desc, $grad, $border])
        <div class="reveal feature-card bg-gradient-to-br {{ $grad }} border {{ $border }} rounded-2xl p-7 backdrop-blur-sm cursor-default">
          <div class="text-3xl mb-4">{{ $icon }}</div>
          <h3 class="text-white font-semibold text-lg mb-2">{{ $title }}</h3>
          <p class="text-slate-400 text-sm leading-relaxed">{{ $desc }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ════════════════════════════════════════
       HOW IT WORKS
  ════════════════════════════════════════ --}}
  <section class="py-28 bg-[#FFF8F3] relative overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[1px] bg-gradient-to-r from-transparent via-[#FF52A7]/40 to-transparent"></div>

    <div class="max-w-6xl mx-auto px-6 lg:px-12">
      <div class="reveal text-center mb-20">
        <span class="inline-block border border-[#C9A84C]/30 text-[#C9A84C] text-xs font-semibold tracking-[0.2em] uppercase px-4 py-1.5 rounded-full mb-5">Simple Process</span>
        <h2 class="font-['Playfair_Display',serif] text-4xl lg:text-5xl font-bold text-white">
          Three Steps to <span class="gold-shimmer">Your Dream Trip</span>
        </h2>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 relative">
        {{-- Connector line (desktop) --}}
        <div class="hidden lg:block absolute top-12 left-[20%] right-[20%] h-[2px] bg-gradient-to-r from-[#FF52A7]/20 via-[#FF52A7]/60 to-[#FF52A7]/20"></div>
        {{-- Center mask to cut the line behind the middle step --}}
        <div class="hidden lg:block absolute top-0 left-1/2 -translate-x-1/2 w-24 h-24 rounded-full bg-[#FFF8F3] border border-[#FF52A7]/10 pointer-events-none"></div>

        @foreach([
          ['01','Create Your Trip','Name your adventure, set dates, and invite your travel companions.'],
          ['02','Build Itinerary','Add destinations, activities, flights, and hotels day by day.'],
          ['03','Travel & Track','Go explore! Track expenses, check off activities, and share memories.'],
        ] as [$num, $title, $desc])
        <div class="reveal text-center relative">
          <div class="relative inline-flex items-center justify-center w-24 h-24 mb-6">
            <div class="absolute inset-0  rounded-full border-2 border-[#FF52A7]/30 bg-[#FFD166]/20"></div>
            <div class="absolute inset-2 rounded-full border border-[#FF52A7]/20"></div>
            <span class="font-['Playfair_Display',serif] text-3xl font-black gold-shimmer relative z-10">{{ $num }}</span>
          </div>
          <h3 class="text-white font-semibold text-xl mb-3">{{ $title }}</h3>
          <p class="text-slate-400 text-sm leading-relaxed">{{ $desc }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ════════════════════════════════════════
       DESTINATION SHOWCASE (animated pins)
  ════════════════════════════════════════ --}}
  <section class="py-28 relative overflow-hidden" id="destinations">
    <div class="absolute inset-0 opacity-30 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-12">
      <div class="reveal text-center mb-6">
        <span class="inline-block border border-[#C9A84C]/30 text-[#C9A84C] text-xs font-semibold tracking-[0.2em] uppercase px-4 py-1.5 rounded-full mb-5">Trending Destinations</span>
        <h2 class="font-['Playfair_Display',serif] text-4xl lg:text-5xl font-bold text-white">
          Worlds to <span class="gold-shimmer">Explore</span>
        </h2>
      </div>

      {{-- Toggle: International / National --}}
      <div class="flex justify-center mb-8">
        <div class="inline-flex bg-[#FFF7F0] border border-[#EDE1D8] rounded-full p-1">
          <button type="button" class="dest-toggle px-5 py-2 rounded-full text-sm font-semibold text-[#071022]" data-scope="international" aria-pressed="true">International</button>
          <button type="button" class="dest-toggle px-5 py-2 rounded-full text-sm font-semibold text-slate-500" data-scope="national" aria-pressed="false">National</button>
        </div>
      </div>

      @php
        $international = [
          ['🗼','Paris','France'],
          ['⛩️','Tokyo','Japan'],
          ['🌉','Bali','Indonesia'],
          ['🏛️','Rome','Italy'],
          ['🏔️','Manali','India'],
          ['🕌','Istanbul','Turkey'],
        ];
        $national = [
          ['🗽','New York','USA'],
          ['🌆','Los Angeles','USA'],
          ['🌉','San Francisco','USA'],
          ['🌴','Miami','USA'],
          ['🏔️','Denver','USA'],
          ['🏝️','Honolulu','USA'],
        ];
      @endphp

      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4" id="dest-grid">
        @foreach($international as [$emoji, $city, $country])
        <div class="reveal dest-card feature-card bg-[#FFF7F0] border border-[#EDE1D8] hover:border-[#FF52A7]/40 rounded-2xl p-5 text-center cursor-pointer group" data-scope="international">
          <div class="text-4xl mb-3 group-hover:scale-110 transition-transform inline-block">{{ $emoji }}</div>
          <div class="text-white font-semibold text-sm">{{ $city }}</div>
          <div class="text-slate-500 text-xs mt-0.5">{{ $country }}</div>
        </div>
        @endforeach

        @foreach($national as [$emoji, $city, $country])
        <div class="reveal dest-card feature-card bg-[#FFF7F0] border border-[#EDE1D8] rounded-2xl p-5 text-center cursor-pointer group hidden" data-scope="national">
          <div class="text-4xl mb-3 group-hover:scale-110 transition-transform inline-block">{{ $emoji }}</div>
          <div class="text-white font-semibold text-sm">{{ $city }}</div>
          <div class="text-slate-500 text-xs mt-0.5">{{ $country }}</div>
        </div>
        @endforeach
      </div>

      <div class="reveal text-center mt-10">
        <a href="" class="btn-outline inline-flex items-center gap-2 px-6 py-3 rounded-full text-[#C9A84C] font-medium text-sm">
          Browse All Destinations
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
          </svg>
        </a>
      </div>

      <script>
        (function(){
          const toggles = document.querySelectorAll('.dest-toggle');
          const cards = document.querySelectorAll('.dest-card');
          function setScope(scope){
            toggles.forEach(btn=>{
              const isActive = btn.dataset.scope === scope;
              btn.setAttribute('aria-pressed', String(isActive));
              btn.classList.toggle('text-slate-500', !isActive);
              btn.classList.toggle('text-[#071022]', isActive);
              if(isActive){ btn.classList.add('bg-white','shadow-sm'); } else { btn.classList.remove('bg-white','shadow-sm'); }
            });
            cards.forEach(card=>{
              if(card.dataset.scope === scope){ card.classList.remove('hidden'); }
              else { card.classList.add('hidden'); }
            });
          }
          toggles.forEach(btn=> btn.addEventListener('click', ()=> setScope(btn.dataset.scope)) );
          // initial state
          setScope('international');
        })();
      </script>
    </div>
  </section>

  {{-- ════════════════════════════════════════
       TESTIMONIALS
  ════════════════════════════════════════ --}}
  <section class="py-28 bg-[#FFF8F3] relative">
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#FF52A7]/30 to-transparent"></div>

    <div class="max-w-6xl mx-auto px-6 lg:px-12">
      <div class="reveal text-center mb-16">
        <h2 class="font-['Playfair_Display',serif] text-4xl lg:text-5xl font-bold text-white">
          Loved by <span class="gold-shimmer">Explorers</span>
        </h2>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach([
          ['"Planned our 3-week Europe trip in an afternoon. The itinerary builder is insanely intuitive."','Priya S.','Solo Traveller', '🇮🇳'],
          ['"Finally, a travel app that handles group trips without the chaos. My whole friend group uses it now."','Marcus L.','Adventure Group Lead', '🇺🇸'],
          ['"The budget tracker alone saved our honeymoon from going over. 10/10 would recommend."','Anika & Raj','Newlyweds', '🇬🇧'],
        ] as [$quote, $name, $role, $flag])
        <div class="reveal feature-card bg-[#FFF7F0] border border-[#EDE1D8] rounded-2xl p-7">
          <div class="flex mb-4">
            @for($i=0;$i<5;$i++)
            <svg class="w-4 h-4 text-[#C9A84C]" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            @endfor
          </div>
          <p class="text-slate-300 text-sm leading-relaxed mb-5 italic">{{ $quote }}</p>
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-[#1A2540] border border-[#C9A84C]/20 flex items-center justify-center text-base">{{ $flag }}</div>
            <div>
              <div class="text-white font-semibold text-sm">{{ $name }}</div>
              <div class="text-slate-500 text-xs">{{ $role }}</div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ════════════════════════════════════════
       PRICING
  ════════════════════════════════════════ --}}
  <section class="py-28 relative overflow-hidden" id="pricing">
    <div class="absolute inset-0 opacity-40 pointer-events-none"></div>
    <div class="max-w-5xl mx-auto px-6 lg:px-12">
      <div class="reveal text-center mb-16">
        <span class="inline-block border border-[#C9A84C]/30 text-[#C9A84C] text-xs font-semibold tracking-[0.2em] uppercase px-4 py-1.5 rounded-full mb-5">Pricing</span>
        <h2 class="font-['Playfair_Display',serif] text-4xl lg:text-5xl font-bold text-white">
          Simple, <span class="gold-shimmer">Transparent</span> Plans
        </h2>
      </div>

      <x-pricing-cards
        freeLabel="Get Started Free"
        :freeUrl="route('register', ['plan' => 'free'])"
        plusLabel="Start 14-Day Free Trial"
        :plusUrl="route('register', ['plan' => 'plus'])"
        :animated="true"
      />
    </div>
  </section>

  {{-- ════════════════════════════════════════
       CTA BANNER
  ════════════════════════════════════════ --}}
  <section class="py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-[#FFD166]/10 via-[#FFF7F0] to-[#FF52A7]/10"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] rounded-full bg-[#FF52A7] opacity-[0.06] blur-[150px] pointer-events-none"></div>

    <div class="relative max-w-4xl mx-auto px-6 text-center">
      <div class="reveal mb-6">
        <span class="text-6xl">🌍</span>
      </div>
      <h2 class="reveal font-['Playfair_Display',serif] text-4xl lg:text-6xl font-black text-[#071022] mb-6 leading-tight">
        Your Next Adventure<br>
        <span class="gold-shimmer">Awaits You.</span>
      </h2>
      <p class="reveal delay-200 text-slate-700 text-lg mb-10 max-w-xl mx-auto">
        Join thousands of travellers who plan smarter, travel better, and stress less.
      </p>
      <div class="reveal delay-300 flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('register', ['plan' => 'free']) }}" class="btn-primary inline-flex items-center justify-center gap-2 px-10 py-4 rounded-full text-[#071022] font-bold text-base btn-glow">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
          </svg>
          Create Free Account
        </a>
        <a href="{{ route('login') }}" class="btn-outline inline-flex items-center justify-center gap-2 px-10 py-4 rounded-full text-[#071022] font-semibold text-base hover:bg-[#FF52A7]/5">
          Sign In
        </a>
      </div> 
      <p class="reveal delay-400 text-slate-700 text-xs mt-6">No credit card required · Free forever plan available · Cancel anytime</p>
    </div>
  </section>

  {{-- ════════════════════════════════════════
       SCRIPTS
  ════════════════════════════════════════ --}}
  <script>
    // Intersection observer for reveal animations
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.classList.add('visible');
        }
      });
    }, { threshold: 0.15 });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
  </script>

</div>
@endsection
