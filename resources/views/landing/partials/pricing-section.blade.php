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