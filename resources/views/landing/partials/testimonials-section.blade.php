<section class="py-28 bg-[#FFF8F3] relative">
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-party-1/30 to-transparent"></div>

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
        <div class="reveal feature-card bg-gold-base border border-[#EDE1D8] rounded-2xl p-7">
          <div class="flex mb-4">
            @for($i=0;$i<5;$i++)
            <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            @endfor
          </div>
          <p class="text-slate-300 text-sm leading-relaxed mb-5 italic">{{ $quote }}</p>
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-[#1A2540] border border-gold/20 flex items-center justify-center text-base">{{ $flag }}</div>
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