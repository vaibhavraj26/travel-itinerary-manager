@extends('layouts.blog')

@section('content')
<section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(255,82,167,0.12),transparent_35%),radial-gradient(circle_at_top_right,rgba(255,209,102,0.18),transparent_30%)] pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-12 pt-16 pb-20">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-party-1/10 text-party-1 text-sm font-semibold shadow-sm">
                Travel stories and planning tips
            </span>
            <h1 class="mt-6 font-['Playfair_Display',serif] text-5xl sm:text-6xl lg:text-7xl font-black leading-tight text-page-text">
                Travel ideas worth <span class="gold-shimmer">saving</span>
            </h1>
            <p class="mt-6 text-slate-600 text-base sm:text-lg leading-relaxed max-w-2xl">
                A simple blog space for destination guides, trip planning advice, and product updates while the full content system is still being built.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="#featured" class="btn-primary inline-flex items-center gap-2 px-6 py-3 rounded-full text-page-text font-bold text-sm btn-glow">
                    Featured stories
                </a>
                <a href="#latest" class="inline-flex items-center gap-2 px-6 py-3 rounded-full border border-slate-200 bg-white text-slate-700 font-semibold text-sm hover:border-party-1/30 hover:text-party-1 transition-colors">
                    Latest posts
                </a>
            </div>
        </div>

        <div id="featured" class="mt-14 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <article class="lg:col-span-2 rounded-3xl overflow-hidden bg-page-text text-white shadow-2xl shadow-black/10 border border-white/5">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-8 sm:p-10 flex flex-col justify-end bg-[linear-gradient(180deg,rgba(255,82,167,0.12),rgba(7,16,34,0.92))]">
                        <span class="inline-flex w-fit items-center px-3 py-1 rounded-full bg-white/10 text-white/90 text-xs font-semibold uppercase tracking-[0.2em]">Featured</span>
                        <h2 class="mt-4 font-['Playfair_Display',serif] text-3xl sm:text-4xl font-bold leading-tight">
                            How to build a stress-free 7-day itinerary
                        </h2>
                        <p class="mt-4 text-slate-300 leading-relaxed">
                            Learn a simple framework for balancing travel time, must-see stops, and enough breathing room to enjoy the trip.
                        </p>
                        <div class="mt-6 flex items-center gap-4 text-sm text-slate-400">
                            <span>Planning</span>
                            <span>•</span>
                            <span>8 min read</span>
                        </div>
                    </div>
                    <div class="min-h-[280px] bg-[linear-gradient(135deg,party-1,white)]"></div>
                </div>
            </article>

            <aside class="rounded-3xl bg-white border border-party-1/10 p-8 shadow-lg shadow-black/5">
                <div class="flex items-center justify-between gap-4">
                    <h2 class="font-['Playfair_Display',serif] text-2xl font-bold text-page-text">Topics</h2>
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Now</span>
                </div>
                <ul class="mt-6 space-y-3 text-sm">
                    <li class="flex items-center justify-between rounded-2xl bg-[#FFF8F3] px-4 py-3 text-slate-700">
                        <span>Destination Guides</span><span class="font-semibold text-party-1">12</span>
                    </li>
                    <li class="flex items-center justify-between rounded-2xl bg-[#FFF8F3] px-4 py-3 text-slate-700">
                        <span>Planning Tips</span><span class="font-semibold text-party-1">08</span>
                    </li>
                    <li class="flex items-center justify-between rounded-2xl bg-[#FFF8F3] px-4 py-3 text-slate-700">
                        <span>Trip Updates</span><span class="font-semibold text-party-1">05</span>
                    </li>
                    <li class="flex items-center justify-between rounded-2xl bg-[#FFF8F3] px-4 py-3 text-slate-700">
                        <span>Travel Gear</span><span class="font-semibold text-party-1">04</span>
                    </li>
                </ul>
            </aside>
        </div>

        <section id="latest" class="mt-16">
            <div class="flex items-end justify-between gap-4 mb-6">
                <div>
                    <h2 class="font-['Playfair_Display',serif] text-3xl font-bold text-page-text">Latest posts</h2>
                    <p class="mt-2 text-slate-600">A starter feed for the blog layout.</p>
                </div>
                <a href="{{ route('landing') }}" class="hidden sm:inline-flex text-sm font-semibold text-party-1 hover:underline">Back to home</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <article class="reveal rounded-3xl bg-white border border-slate-100 shadow-lg shadow-black/5 overflow-hidden">
                    <div class="h-44 bg-[linear-gradient(135deg,page-text,#1A2540)]"></div>
                    <div class="p-6">
                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-party-1">Planning</span>
                        <h3 class="mt-3 font-['Playfair_Display',serif] text-2xl font-bold text-page-text">Picking the right travel pace</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">A quick look at how to balance sightseeing, rest, and transit on short trips.</p>
                    </div>
                </article>

                <article class="reveal rounded-3xl bg-white border border-slate-100 shadow-lg shadow-black/5 overflow-hidden">
                    <div class="h-44 bg-[linear-gradient(135deg,party-1,white)]"></div>
                    <div class="p-6">
                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-party-1">Guide</span>
                        <h3 class="mt-3 font-['Playfair_Display',serif] text-2xl font-bold text-page-text">What to pack for a 10-day trip</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">A compact packing checklist you can adapt for city breaks or beach escapes.</p>
                    </div>
                </article>

                <article class="reveal rounded-3xl bg-white border border-slate-100 shadow-lg shadow-black/5 overflow-hidden">
                    <div class="h-44 bg-[linear-gradient(135deg,gold,#FFF8F3)]"></div>
                    <div class="p-6">
                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-party-1">Product</span>
                        <h3 class="mt-3 font-['Playfair_Display',serif] text-2xl font-bold text-page-text">What's coming to TripTogether blog</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">A placeholder update page for product news, trip inspiration, and customer stories.</p>
                    </div>
                </article>
            </div>
        </section>

        <section class="mt-16 rounded-[2rem] bg-page-text text-white p-8 sm:p-10 shadow-2xl shadow-black/10 border border-white/5">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div class="max-w-2xl">
                    <h2 class="font-['Playfair_Display',serif] text-3xl font-bold">Want this blog to publish real posts next?</h2>
                    <p class="mt-3 text-slate-300 leading-relaxed">
                        This page is ready to be connected to a CMS, markdown posts, or a database-powered article feed later.
                    </p>
                </div>
                <a href="{{ route('register', ['plan' => 'free']) }}" class="btn-primary inline-flex items-center gap-2 px-6 py-3 rounded-full text-page-text font-bold text-sm btn-glow whitespace-nowrap">
                    Start Free
                </a>
            </div>
        </section>
    </div>
</section>
@endsection
