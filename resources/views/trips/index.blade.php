@extends('layouts.dashboard')

@section('header_title', 'My Trips')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 animate-float-up">
    {{-- Header with Action --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-[#071022] font-['Playfair_Display',serif]">Your Adventures</h1>
            <p class="text-slate-500 mt-1">Manage and plan your upcoming journeys with ease.</p>
        </div>
        <div>
            <a href="{{ route('trips.create') }}" class="btn-primary py-3 px-6 rounded-xl text-[#071022] font-bold text-sm shadow-lg shadow-[#FF52A7]/20 hover:-translate-y-1 transition-all inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Plan New Trip
            </a>
        </div>
    </div>

    {{-- Search and Filter --}}
    @include('trips.partials.trip-search-filter')


    {{-- Trips Grid (AJAX-updatable) --}}
    @include('trips.partials.trips-grid')

    {{-- grid Pagination --}}
    @include('partials.trips-search-script')
</div>
@endsection
