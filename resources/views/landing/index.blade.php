@extends('layouts.landing')

@section('content')

<div class="min-h-screen bg-transparent text-white overflow-x-hidden font-['Sora',sans-serif] page-root" id="travel-landing">
  
  {{--  HERO SECTION --}}
  @include('landing.partials.hero-section')

  {{-- MOVING CARS STRIP (canvas animation) --}}
  <!-- @include('landing.partials.moving-cars-strip-section') -->

  {{-- STATS STRIP --}}
  @include('landing.partials.stats-strip-section')

  {{-- FEATURES SECTION --}}
  @include('landing.partials.feature-section')

  {{-- HOW IT WORKS --}}
  @include('landing.partials.how-it-work-section')

  {{-- DESTINATION SHOWCASE (animated pins) --}}
  @include('landing.partials.destination-showcase-section')

  {{-- TESTIMONIALS --}}
  @include('landing.partials.testimonials-section')

  {{-- PRICING --}}
  @include('landing.partials.pricing-section')

  {{-- CTA BANNER --}}
  @include('landing.partials.cta-banner-section')

  {{-- component reveal animation SCRIPTS --}}
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