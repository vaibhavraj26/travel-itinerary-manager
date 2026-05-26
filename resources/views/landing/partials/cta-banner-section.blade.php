<section class="py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-white/10 via-gold-base to-party-1/10"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] rounded-full bg-party-1 opacity-[0.06] blur-[150px] pointer-events-none"></div>

    <div class="relative max-w-4xl mx-auto px-6 text-center">
      <div class="reveal mb-6">
        <span class="text-6xl">🌍</span>
      </div>
      <h2 class="reveal font-['Playfair_Display',serif] text-4xl lg:text-6xl font-black text-page-text mb-6 leading-tight">
        Your Next Adventure<br>
        <span class="gold-shimmer">Awaits You.</span>
      </h2>
      <p class="reveal delay-200 text-slate-700 text-lg mb-10 max-w-xl mx-auto">
        Join thousands of travellers who plan smarter, travel better, and stress less.
      </p>
      <div class="reveal delay-300 flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('register', ['plan' => 'free']) }}" class="btn-primary inline-flex items-center justify-center gap-2 px-10 py-4 rounded-full text-page-text font-bold text-base btn-glow">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
          </svg>
          Create Free Account
        </a>
        <a href="{{ route('login') }}" class="btn-outline inline-flex items-center justify-center gap-2 px-10 py-4 rounded-full text-page-text font-semibold text-base hover:bg-party-1/5">
          Sign In
        </a>
      </div> 
      <p class="reveal delay-400 text-slate-700 text-xs mt-6">No credit card required · Free forever plan available · Cancel anytime</p>
    </div>
  </section>