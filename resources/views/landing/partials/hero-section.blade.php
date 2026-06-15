<section class="relative min-h-screen flex items-center justify-center overflow-hidden">

    {{-- Top-left logo inside hero (mobile: icon only) --}}
    <a href="{{ route('landing') }}" class="absolute top-6 left-6 z-30 flex items-center gap-2">
      
        <x-application-logo />
        <x-application-name />
    </a>

    {{-- Top-right Sign In button --}}
    <a href="{{ route('login') }}" class="absolute top-6 right-6 z-30 btn-outline inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full text-page-text font-semibold text-sm hover:bg-party-1/5">
      Sign In
    </a>

    {{-- Hero content (left content, right illustration) --}}
    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-12 pt-10 pb-24">
      <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-8">

        {{-- Left: minimalist content --}}
        <div class="max-w-xl flex flex-col justify-center">
          {{-- Headline (clean and simple) --}}
          <h1 class="font-['Playfair_Display',serif] text-5xl sm:text-6xl lg:text-7xl font-black leading-tight mb-6 text-page-text animate-float-up">
            Plan Your <span class="gold-shimmer">Next</span> Trip
          </h1>

          {{-- Minimal subheading --}}
          <p class="text-slate-600 text-base lg:text-lg leading-relaxed mb-10 max-w-md animate-float-up delay-100">
            Smart itinerary planner for modern travellers. Design, organize, and share your adventures effortlessly.
          </p>

          {{-- Single CTA --}}
          <div class="animate-float-up delay-200">
            <a href="{{ route('register', ['plan' => 'free']) }}" class="btn-primary inline-flex items-center gap-2 px-8 py-4 rounded-xl text-page-text font-bold text-lg tracking-wide btn-glow hover:shadow-lg transition-all">
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