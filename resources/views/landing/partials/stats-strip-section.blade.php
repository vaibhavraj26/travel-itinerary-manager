<section class="bg-[#FFF8F3] border-y border-party-1/10 py-10" id="stats">
  
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