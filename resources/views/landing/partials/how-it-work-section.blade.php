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