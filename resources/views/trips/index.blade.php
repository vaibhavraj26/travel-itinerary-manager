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
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4 items-center">
        <div class="relative flex-1 w-full">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" placeholder="Search destinations or trip names..." class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border-transparent rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-[#FF52A7] transition-all outline-none">
        </div>
        <div class="flex items-center gap-2 w-full md:w-auto">
            <select class="bg-slate-50 border-transparent rounded-xl text-sm py-2.5 px-4 focus:ring-2 focus:ring-[#FF52A7] transition-all outline-none text-slate-600">
                <option value="all">All Status</option>
                <option value="upcoming">Upcoming</option>
                <option value="active">Active</option>
                <option value="completed">Completed</option>
            </select>
            <select class="bg-slate-50 border-transparent rounded-xl text-sm py-2.5 px-4 focus:ring-2 focus:ring-[#FF52A7] transition-all outline-none text-slate-600">
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
                <option value="date">By Date</option>
            </select>
        </div>
    </div>

    {{-- Trips Grid --}}
    @if($trips->isEmpty())
        <div class="bg-white rounded-3xl p-12 border border-dashed border-slate-300 text-center flex flex-col items-center justify-center space-y-6">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center text-slate-300">
                <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-[#071022]">No trips planned yet</h2>
                <p class="text-slate-500 mt-2 max-w-sm mx-auto">Start your journey by creating your first travel itinerary. It only takes a few minutes!</p>
            </div>
            <a href="{{ route('trips.create') }}" class="btn-primary py-3 px-8 rounded-xl text-[#071022] font-bold shadow-lg shadow-[#FF52A7]/20 hover:scale-105 transition-transform">
                Get Started
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($trips as $trip)
                <a href="{{ route('trips.show', $trip) }}" class="group bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full focus:outline-none focus:ring-2 focus:ring-[#FF52A7] focus:ring-offset-2">
                    {{-- Card Image --}}
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $trip->image_url ?? 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=2021&auto=format&fit=crop' }}" 
                             alt="{{ $trip->destination }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="px-2 py-1 bg-white/20 backdrop-blur-md rounded-lg text-[10px] font-bold text-white uppercase tracking-wider border border-white/30">
                                {{ $trip->status }}
                            </span>
                            <h3 class="text-white font-bold text-xl mt-1">{{ $trip->title }}</h3>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center gap-2 text-slate-500 text-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span class="font-medium text-slate-700">{{ $trip->destination }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-500 text-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>{{ \Carbon\Carbon::parse($trip->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($trip->end_date)->format('M d, Y') }}</span>
                            </div>
                            <p class="text-slate-600 text-sm line-clamp-2 mt-2">
                                {{ $trip->description ?? 'No description added yet for this adventure.' }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-50 flex items-center justify-between">
                            <div class="flex -space-x-2">
                                <img src="https://i.pravatar.cc/100?u=1" class="w-8 h-8 rounded-full border-2 border-white shadow-sm" alt="User">
                                <img src="https://i.pravatar.cc/100?u=2" class="w-8 h-8 rounded-full border-2 border-white shadow-sm" alt="User">
                                <div class="w-8 h-8 rounded-full bg-slate-100 border-2 border-white flex items-center justify-center text-[10px] font-bold text-slate-500 shadow-sm">+2</div>
                            </div>
                            <div class="text-sm font-bold text-[#FF52A7] group-hover:underline flex items-center gap-1">
                                Details
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
