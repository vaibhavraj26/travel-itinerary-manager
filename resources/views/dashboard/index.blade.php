@extends('layouts.dashboard')

@section('header_title', 'Home')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 animate-float-up">
    @php
        $formatCurrency = fn ($amount) => '₹' . number_format((float) $amount, 2);
        $nextTripDate = $nextTrip ? \Carbon\Carbon::parse($nextTrip->start_date) : null;
        $daysUntilNextTrip = $nextTripDate ? now()->startOfDay()->diffInDays($nextTripDate, false) : null;
    @endphp

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-[#071022] font-['Playfair_Display',serif]">Welcome back, {{ Auth::user()->name ?? 'Traveler' }}!</h1>
            <p class="text-slate-500 mt-1">Here is what's happening with your trips today.</p>
        </div>
        <div>
            <a href="{{ route('trips.create') }}" class="btn-primary py-2.5 px-5 rounded-xl text-[#071022] font-bold text-sm shadow-md shadow-[#FF52A7]/20 hover:-translate-y-0.5 transition-transform inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                New Trip
            </a>
        </div>
    </div>

    <!-- Top Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Upcoming Trips -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-full bg-[#FF52A7]/10 flex items-center justify-center text-[#FF52A7]">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-slate-500 text-sm font-semibold">Upcoming Trips</h3>
                    <p class="text-2xl font-bold text-[#071022]">{{ $upcomingTripsCount }}</p>
                </div>
            </div>
            <p class="text-xs text-slate-500">
                @if($nextTrip)
                    <span class="text-emerald-500 font-medium">Next: {{ $nextTrip->title }}</span>
                    @if($daysUntilNextTrip !== null)
                        in {{ max(0, $daysUntilNextTrip) }} days
                    @endif
                @else
                    No upcoming trips yet. Create one to get started.
                @endif
            </p>
        </div>

        <!-- Active Itineraries -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-full bg-[#7C3AED]/10 flex items-center justify-center text-[#7C3AED]">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <h3 class="text-slate-500 text-sm font-semibold">Active Itineraries</h3>
                    <p class="text-2xl font-bold text-[#071022]">{{ $activeItinerariesCount }}</p>
                </div>
            </div>
            <p class="text-xs text-slate-500">Trips currently in progress</p>
        </div>

        <!-- Total Budget -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-full bg-[#FFB800]/10 flex items-center justify-center text-[#FFB800]">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-slate-500 text-sm font-semibold">Total Budget</h3>
                    <p class="text-2xl font-bold text-[#071022]">{{ $formatCurrency($totalBudget) }}</p>
                </div>
            </div>
            <p class="text-xs text-slate-500">Across {{ $tripSummaries->count() }} trip{{ $tripSummaries->count() === 1 ? '' : 's' }}</p>
        </div>
    </div>

    <!-- Two-column Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-[#071022]">Recent Activity</h2>
                <a href="{{ route('trips.index') }}" class="text-sm font-medium text-[#7C3AED] hover:underline">View All</a>
            </div>
            
            <div class="space-y-6">
                @forelse($recentEvents as $event)
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 shrink-0">
                            @if($event['kind'] === 'trip')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            @elseif($event['kind'] === 'activity')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            @else
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm text-slate-800">
                                <span class="font-semibold">{{ $event['title'] }}</span>
                                <span class="text-slate-500">• {{ $event['description'] }}</span>
                            </p>
                            <p class="text-xs text-slate-500 mt-1">{{ $event['time_label'] }}</p>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-8 text-center">
                        <p class="text-sm font-medium text-slate-700">No recent activity yet.</p>
                        <p class="text-xs text-slate-500 mt-1">Create your first trip or add an itinerary item to start the feed.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions & Account settings -->
        <div class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-bold text-[#071022] mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('trips.create') }}" class="w-full text-left px-4 py-3 rounded-xl border border-slate-200 hover:border-[#FF52A7] hover:bg-[#FF52A7]/5 transition-colors flex items-center gap-3 group">
                        <div class="text-slate-400 group-hover:text-[#FF52A7]">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700 group-hover:text-slate-900">Create New Trip</span>
                    </a>
                    <a href="{{ route('trips.index') }}" class="w-full text-left px-4 py-3 rounded-xl border border-slate-200 hover:border-[#7C3AED] hover:bg-[#7C3AED]/5 transition-colors flex items-center gap-3 group">
                        <div class="text-slate-400 group-hover:text-[#7C3AED]">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700 group-hover:text-slate-900">View All Trips</span>
                    </a>
                    <a href="{{ route('ai.planner') }}" class="w-full text-left px-4 py-3 rounded-xl border border-slate-200 hover:border-[#FFB800] hover:bg-[#FFB800]/5 transition-colors flex items-center gap-3 group">
                        <div class="text-slate-400 group-hover:text-[#FFB800]">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700 group-hover:text-slate-900">Open AI Planner</span>
                    </a>
                    <a href="{{ route('profile.show') }}" class="w-full text-left px-4 py-3 rounded-xl border border-slate-200 hover:border-emerald-500 hover:bg-emerald-500/5 transition-colors flex items-center gap-3 group">
                        <div class="text-slate-400 group-hover:text-emerald-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.879 6.196M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700 group-hover:text-slate-900">Edit Profile</span>
                    </a>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-red-50 border border-red-100 rounded-2xl p-6">
                <h3 class="text-red-800 font-bold text-sm mb-2">Danger Zone</h3>
                <p class="text-xs text-red-600 mb-4">Permanently delete your account and all associated data. This action cannot be undone.</p>
                <form method="POST" action="{{ route('account.delete') }}" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-white border border-red-200 text-red-600 font-medium text-xs hover:bg-red-100 transition-colors">
                        Delete Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
