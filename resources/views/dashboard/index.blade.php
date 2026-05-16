@extends('layouts.dashboard')

@section('header_title', 'Home')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 animate-float-up">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-[#071022] font-['Playfair_Display',serif]">Welcome back, {{ Auth::user()->name ?? 'Traveler' }}!</h1>
            <p class="text-slate-500 mt-1">Here is what's happening with your trips today.</p>
        </div>
        <div>
            <a href="#" class="btn-primary py-2.5 px-5 rounded-xl text-[#071022] font-bold text-sm shadow-md shadow-[#FF52A7]/20 hover:-translate-y-0.5 transition-transform inline-flex items-center gap-2">
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
                    <p class="text-2xl font-bold text-[#071022]">2</p>
                </div>
            </div>
            <p class="text-xs text-slate-500"><span class="text-emerald-500 font-medium">Next: Paris</span> in 14 days</p>
        </div>

        <!-- Active Itineraries -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-full bg-[#7C3AED]/10 flex items-center justify-center text-[#7C3AED]">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <h3 class="text-slate-500 text-sm font-semibold">Active Itineraries</h3>
                    <p class="text-2xl font-bold text-[#071022]">4</p>
                </div>
            </div>
            <p class="text-xs text-slate-500"><span class="text-emerald-500 font-medium">+1</span> drafted this week</p>
        </div>

        <!-- Total Budget -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-full bg-[#FFB800]/10 flex items-center justify-center text-[#FFB800]">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-slate-500 text-sm font-semibold">Total Budget</h3>
                    <p class="text-2xl font-bold text-[#071022]">$4,250</p>
                </div>
            </div>
            <p class="text-xs text-slate-500">Across all planned trips</p>
        </div>
    </div>

    <!-- Two-column Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-[#071022]">Recent Activity</h2>
                <a href="#" class="text-sm font-medium text-[#7C3AED] hover:underline">View All</a>
            </div>
            
            <div class="space-y-6">
                <!-- Activity Item -->
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-800"><span class="font-semibold">You</span> updated the itinerary for <span class="font-semibold text-[#7C3AED]">Kyoto Exploration</span></p>
                        <p class="text-xs text-slate-500 mt-1">2 hours ago</p>
                    </div>
                </div>

                <!-- Activity Item -->
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-800"><span class="font-semibold">Sarah M.</span> joined your trip <span class="font-semibold text-[#7C3AED]">Euro Summer 2026</span></p>
                        <p class="text-xs text-slate-500 mt-1">Yesterday at 4:30 PM</p>
                    </div>
                </div>

                <!-- Activity Item -->
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-800">Booking confirmed for <span class="font-semibold">Hilton Paris Opera</span></p>
                        <p class="text-xs text-slate-500 mt-1">Oct 12, 2025</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Account settings -->
        <div class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-bold text-[#071022] mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <button class="w-full text-left px-4 py-3 rounded-xl border border-slate-200 hover:border-[#FF52A7] hover:bg-[#FF52A7]/5 transition-colors flex items-center gap-3 group">
                        <div class="text-slate-400 group-hover:text-[#FF52A7]">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700 group-hover:text-slate-900">Create New Trip</span>
                    </button>
                    <button class="w-full text-left px-4 py-3 rounded-xl border border-slate-200 hover:border-[#7C3AED] hover:bg-[#7C3AED]/5 transition-colors flex items-center gap-3 group">
                        <div class="text-slate-400 group-hover:text-[#7C3AED]">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700 group-hover:text-slate-900">Sync Calendar</span>
                    </button>
                    <button class="w-full text-left px-4 py-3 rounded-xl border border-slate-200 hover:border-[#FFB800] hover:bg-[#FFB800]/5 transition-colors flex items-center gap-3 group">
                        <div class="text-slate-400 group-hover:text-[#FFB800]">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700 group-hover:text-slate-900">Invite Friends</span>
                    </button>
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
