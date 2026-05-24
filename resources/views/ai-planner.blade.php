@extends('layouts.dashboard')

@section('header_title', 'AI Planner')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <div x-data="{ showBanner: true }" x-show="showBanner" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-amber-50 via-white to-emerald-50 border border-amber-100 p-8">
        <div class="absolute -top-24 -right-16 h-64 w-64 rounded-full bg-amber-200/30 blur-3xl"></div>
        <div class="absolute -bottom-24 -left-16 h-64 w-64 rounded-full bg-emerald-200/30 blur-3xl"></div>
        <div class="relative z-10">
            <button type="button" @click="showBanner = false" class="absolute right-0 top-0 p-2 rounded-full hover:bg-white/70 text-slate-500 transition-colors" aria-label="Dismiss">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <span class="inline-flex items-center gap-2 rounded-full bg-[#071022] text-white text-[10px] font-black uppercase tracking-widest px-3 py-1">
                AI Planner
            </span>
            <h1 class="mt-4 text-3xl sm:text-4xl font-black text-[#071022] tracking-tight">
                Plan your trip in minutes
            </h1>
            <p class="mt-3 text-slate-600 text-sm sm:text-base max-w-2xl">
                Tell us where you are going and what you love. We will draft a day-by-day itinerary you can tweak and share.
            </p>
            <p class="mt-3 text-slate-600 text-sm sm:text-base max-w-2xl">
                We create a new trip with day-by-day draft activities. You can edit each activity afterward.
            </p>
        </div>
    </div>

    @if(Auth::user()->plan !== 'plus')
        <div class="rounded-[2rem] border border-amber-200 bg-amber-50/60 p-8">
            <h2 class="text-xl font-black text-[#071022]">Upgrade to Explorer Plus</h2>
            <p class="mt-2 text-slate-600 text-sm">
                AI Planner is available on Explorer Plus. Upgrade to generate full itineraries and share them with your travel buddies.
            </p>
            <div class="mt-6 flex flex-wrap items-center gap-3">
                <a href="{{ route('pricing') }}" class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-[#FF52A7] text-white font-black text-sm shadow-lg shadow-[#FF52A7]/20">
                    View Plans
                </a>
                <span class="text-xs font-semibold text-amber-700">Free plan users can still browse existing trips.</span>
            </div>
        </div>
    @else
        @if($errors->any())
            <div x-data="{ showErrorsPopup: true }" x-show="showErrorsPopup" x-transition class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" x-cloak>
                <div class="relative w-full max-w-lg rounded-[2rem] border border-rose-200 bg-white p-6 text-sm text-rose-700 shadow-2xl" @click.away="showErrorsPopup = false">
                    <button type="button" @click="showErrorsPopup = false" class="absolute right-4 top-4 p-1 rounded-full hover:bg-rose-50 text-rose-500 transition-colors" aria-label="Dismiss errors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <p class="font-black text-rose-700 mb-2">Please fix the following:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <form method="POST" action="{{ route('ai.planner.store') }}" class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm space-y-6" x-data="{ submitting: false }" @submit.prevent="if(!submitting){ submitting = true; $el.submit(); }">
            @csrf
            <div class="grid gap-6 sm:grid-cols-2">
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Destination</label>
                    <input type="text" name="destination" value="{{ old('destination') }}" placeholder="Goa, Japan, Paris..." required class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-emerald-400 outline-none transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Trip Length (days)</label>
                    <input type="number" min="1" max="30" name="days" value="{{ old('days') }}" placeholder="5" required class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-emerald-400 outline-none transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}" required class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-emerald-400 outline-none transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Travel Style</label>
                    <select name="style" required class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-emerald-400 outline-none transition-all appearance-none">
                        @foreach(['Balanced','Relaxed','Adventure','Culture','Foodie'] as $style)
                            <option value="{{ $style }}" {{ old('style') === $style ? 'selected' : '' }}>{{ $style }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Budget Range</label>
                    <select name="budget" required class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-emerald-400 outline-none transition-all appearance-none">
                        @foreach(['Budget','Comfort','Luxury'] as $budget)
                            <option value="{{ $budget }}" {{ old('budget') === $budget ? 'selected' : '' }}>{{ $budget }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Interests</label>
                <div class="flex flex-wrap gap-2">
                    @foreach(['Nature','Museums','Nightlife','Shopping','Local Food','Wellness'] as $interest)
                        <label class="inline-flex items-center gap-2 px-3 py-2 rounded-full bg-slate-50 border border-slate-200 text-xs font-semibold text-slate-600">
                            <input type="checkbox" name="interests[]" value="{{ $interest }}" {{ is_array(old('interests')) && in_array($interest, old('interests')) ? 'checked' : '' }}>
                            {{ $interest }}
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" :disabled="submitting" :class="submitting ? 'opacity-60 cursor-not-allowed' : ''" class="w-full py-4 rounded-2xl bg-[#071022] text-white font-black text-sm shadow-lg shadow-slate-900/20 hover:translate-y-[-1px] transition-transform">
                <span x-show="!submitting">Generate & Save AI Plan</span>
                <span x-show="submitting" x-cloak class="inline-flex items-center gap-3">
                    <svg class="w-5 h-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    Creating best plan for you...
                </span>
            </button>

            {{-- Submitting overlay for visual feedback when generating plan --}}
            <div x-show="submitting" x-cloak class="fixed inset-0 bg-white/70 backdrop-blur-sm z-50 flex items-center justify-center pointer-events-none">
                <div class="flex flex-col items-center gap-4 p-6 rounded-xl">
                    <svg class="w-12 h-12 animate-spin text-[#071022]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <div class="text-sm font-black text-[#071022]">Creating best plan for you</div>
                    <div class="text-xs text-slate-500">This might take a few moments — please keep this tab open.</div>
                </div>
            </div>
        </form>

    @endif
</div>
@endsection
