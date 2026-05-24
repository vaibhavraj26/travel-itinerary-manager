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
          ['🏔️','San Francisco','USA'],
          ['🌴','Miami','USA'],
          ['🌉','Denver','USA'],
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
        <a href="/blog" class="btn-outline inline-flex items-center gap-2 px-6 py-3 rounded-full text-[#C9A84C] font-medium text-sm">
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