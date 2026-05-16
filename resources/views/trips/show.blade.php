@extends('layouts.dashboard')

@section('header_title', $trip->title)

@section('content')
<div class="max-w-7xl mx-auto space-y-8 animate-float-up" 
     x-data="{ 
    activeTab: 'overview', 
        showActivityModal: false, 
        showInviteModal: false,
        showExpenseModal: false
     }"
     @keydown.escape.window="showActivityModal = false; showInviteModal = false">
    {{-- Trip Header Section --}}
    <div class="relative h-80 rounded-[2.5rem] overflow-hidden shadow-2xl group">
        <img src="{{ $trip->image_url ?? 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=2021&auto=format&fit=crop' }}" 
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="{{ $trip->title }}">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
        
        <div class="absolute bottom-8 left-8 right-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 bg-[#FF52A7] rounded-full text-[10px] font-black text-white uppercase tracking-widest">
                        {{ $trip->status }}
                    </span>
                    <div class="flex items-center gap-1 text-white/80 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $trip->destination }}
                    </div>
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-white font-['Playfair_Display',serif] tracking-tight">
                    {{ $trip->title }}
                </h1>
                <p class="text-white/60 text-sm md:text-base font-medium max-w-2xl">
                    {{ \Carbon\Carbon::parse($trip->start_date)->format('M d') }} — {{ \Carbon\Carbon::parse($trip->end_date)->format('M d, Y') }} ({{ \Carbon\Carbon::parse($trip->start_date)->diffInDays($trip->end_date) }} days)
                </p>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="flex -space-x-3">
                    @foreach($trip->sharedUsers as $member)
                        <img src="https://i.pravatar.cc/100?u={{ $member->id }}" class="w-10 h-10 rounded-full border-2 border-white shadow-lg" title="{{ $member->name }}">
                    @endforeach
                    @if($trip->user_id === Auth::id())
                        <button type="button" @click="showInviteModal = true" class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md border-2 border-white/30 flex items-center justify-center text-white hover:bg-white/40 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    @endif
                </div>
                @if($trip->user_id === Auth::id())
                    <a href="{{ route('trips.edit', $trip) }}" class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md border-2 border-white/30 flex items-center justify-center text-white hover:bg-white/40 transition-colors shadow-lg">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    </a>
                    <form action="{{ route('trips.destroy', $trip) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this trip? This action cannot be undone.');" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md border-2 border-white/30 flex items-center justify-center text-white hover:bg-red-500/80 transition-colors shadow-lg">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    {{-- Tabs Navigation (Premium Segmented Toggle) --}}
    <div class="p-1.5 bg-slate-100/80 backdrop-blur-md rounded-2xl w-full xl:w-max border border-slate-200/50 shadow-inner overflow-x-auto">
        <div class="relative flex w-full min-w-[320px]">
            <!-- Background Slider -->
            <div class="absolute top-0 bottom-0 left-0 w-1/4 bg-white rounded-xl shadow-sm transition-transform duration-300 ease-out pointer-events-none"
                 :style="
                     activeTab === 'overview' ? 'transform: translateX(0%);' :
                     activeTab === 'itinerary' ? 'transform: translateX(100%);' :
                     activeTab === 'members' ? 'transform: translateX(200%);' :
                     'transform: translateX(300%);'
                 "></div>

            <button type="button" @click.prevent="activeTab = 'overview'" 
                    :class="activeTab === 'overview' ? 'text-[#FF52A7]' : 'text-slate-500 hover:text-slate-800'" 
                    class="relative flex-1 flex items-center justify-center gap-2 px-2 md:px-6 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-colors duration-300 z-10 whitespace-nowrap cursor-pointer">
                <svg class="w-4 h-4 hidden md:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Overview
            </button>
            <button type="button" @click.prevent="activeTab = 'itinerary'" 
                    :class="activeTab === 'itinerary' ? 'text-[#FF52A7]' : 'text-slate-500 hover:text-slate-800'" 
                    class="relative flex-1 flex items-center justify-center gap-2 px-2 md:px-6 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-colors duration-300 z-10 whitespace-nowrap cursor-pointer">
                <svg class="w-4 h-4 hidden md:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Itinerary
            </button>
            <button type="button" @click.prevent="activeTab = 'members'" 
                    :class="activeTab === 'members' ? 'text-[#FF52A7]' : 'text-slate-500 hover:text-slate-800'" 
                    class="relative flex-1 flex items-center justify-center gap-2 px-2 md:px-6 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-colors duration-300 z-10 whitespace-nowrap cursor-pointer">
                <svg class="w-4 h-4 hidden md:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Members
            </button>
            <button type="button" @click.prevent="activeTab = 'budget'" 
                    :class="activeTab === 'budget' ? 'text-[#FF52A7]' : 'text-slate-500 hover:text-slate-800'" 
                    class="relative flex-1 flex items-center justify-center gap-2 px-2 md:px-6 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-colors duration-300 z-10 whitespace-nowrap cursor-pointer">
                <svg class="w-4 h-4 hidden md:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Budget
            </button>
        </div>
    </div>

    {{-- Tab Contents --}}
    <div class="mt-6">
        {{-- Overview Tab --}}
        <div x-show="activeTab === 'overview'" x-cloak class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
                        <h2 class="text-xl font-bold text-[#071022] mb-4">About this trip</h2>
                        <p class="text-slate-600 leading-relaxed">
                            {{ $trip->description ?? 'No description provided for this trip yet. Edit the trip to add more details about your plans, goals, and inspiration for this journey.' }}
                        </p>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
                        <h2 class="text-lg font-bold text-[#071022] mb-4">Quick Stats</h2>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500">Total Activities</span>
                                <span class="font-bold text-[#071022]">{{ $trip->activities->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500">Group Size</span>
                                <span class="font-bold text-[#071022]">{{ $trip->sharedUsers->count() + 1 }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500">Estimated Cost</span>
                                <span class="font-bold text-[#071022]">$0.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Itinerary Tab --}}
        <div x-show="activeTab === 'itinerary'" x-cloak class="space-y-8">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-[#071022]">Daily Schedule</h2>
                @if($trip->user_id === Auth::id())
                    <button @click="showActivityModal = true" class="btn-primary py-2.5 px-5 rounded-xl text-xs font-bold flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Add Activity
                    </button>
                @endif
            </div>

            @if($itinerary->isEmpty())
                <div class="bg-white rounded-3xl p-16 border border-dashed border-slate-300 text-center flex flex-col items-center justify-center space-y-4">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="text-slate-500 font-medium">Your itinerary is empty. Start adding activities to map out your journey!</p>
                    <button @click="showActivityModal = true" class="btn-primary py-3 px-8 rounded-xl text-sm font-bold">Add First Activity</button>
                </div>
            @else
                <div class="space-y-6 relative">
                    {{-- Timeline Line --}}
                    <div class="absolute left-6 top-4 bottom-4 w-0.5 bg-slate-100 hidden md:block"></div>

                    @foreach($itinerary as $date => $activities)
                        <div class="relative" x-data="{ expanded: true }">
                            {{-- Day Toggle Button --}}
                            <button @click="expanded = !expanded" 
                                    class="w-full flex items-center justify-between gap-6 mb-4 p-4 rounded-3xl hover:bg-slate-50 transition-all text-left group">
                                <div class="flex items-center gap-6">
                                    <div class="w-12 h-12 rounded-2xl bg-white border-2 border-[#FF52A7] flex flex-col items-center justify-center shadow-md z-10 group-hover:scale-105 transition-transform">
                                        <span class="text-[10px] font-black text-[#FF52A7] uppercase leading-none">{{ \Carbon\Carbon::parse($date)->format('M') }}</span>
                                        <span class="text-lg font-black text-[#071022] leading-none">{{ \Carbon\Carbon::parse($date)->format('d') }}</span>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-black text-[#071022]">{{ \Carbon\Carbon::parse($date)->format('l, F j') }}</h3>
                                        <p class="text-sm text-slate-500 font-medium">{{ $activities->count() }} activities planned</p>
                                    </div>
                                </div>
                                <div class="p-2 rounded-full bg-slate-100 text-slate-400 group-hover:text-[#FF52A7] group-hover:bg-[#FF52A7]/10 transition-all">
                                    <svg class="w-5 h-5 transition-transform duration-300" :class="expanded ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </button>

                            {{-- Activities Container --}}
                            <div x-show="expanded" x-collapse x-transition.duration.300ms class="space-y-4 ml-0 md:ml-16 mb-8">
                                @foreach($activities as $activity)
                                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-all group relative">
                                        <div class="flex flex-col md:flex-row gap-6">
                                            <div class="w-full md:w-32 shrink-0">
                                                <div class="text-sm font-black text-[#FF52A7]">
                                                    {{ $activity->start_time ? \Carbon\Carbon::parse($activity->start_time)->format('g:i A') : 'All Day' }}
                                                </div>
                                                <div class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-wider">{{ $activity->type }}</div>
                                            </div>
                                            <div class="flex-1 space-y-2">
                                                <h4 class="text-lg font-bold text-[#071022] group-hover:text-[#FF52A7] transition-colors">{{ $activity->title }}</h4>
                                                @if($activity->location)
                                                    <div class="flex items-center gap-1.5 text-slate-500 text-sm font-medium">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                        {{ $activity->location }}
                                                    </div>
                                                @endif
                                                @if($activity->notes)
                                                    <p class="text-slate-600 text-sm leading-relaxed mt-2">{{ $activity->notes }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Members Tab --}}
        <div x-show="activeTab === 'members'" x-cloak class="space-y-6">
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-xl font-bold text-[#071022]">Travel Buddies</h2>
                        <p class="text-slate-500 text-sm mt-1">Manage who can see and edit this itinerary.</p>
                    </div>
                    @if($trip->user_id === Auth::id())
                        <button @click="showInviteModal = true" class="btn-primary py-2.5 px-5 rounded-xl text-xs font-bold flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            Invite Friends
                        </button>
                    @endif
                </div>

                <div class="space-y-4">
                    {{-- Owner --}}
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/100?u={{ $trip->user_id }}" class="w-12 h-12 rounded-full border-2 border-white shadow-sm">
                            <div>
                                <h3 class="font-bold text-[#071022]">{{ $trip->user->name }}</h3>
                                <p class="text-slate-500 text-xs">{{ $trip->user->email }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-[#071022] text-white text-[10px] font-black uppercase rounded-full tracking-widest">Owner</span>
                    </div>

                    {{-- Members --}}
                    @foreach($trip->sharedUsers as $member)
                        <div class="flex items-center justify-between p-4 rounded-2xl border border-slate-100 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-4">
                                <img src="https://i.pravatar.cc/100?u={{ $member->id }}" class="w-12 h-12 rounded-full border-2 border-white shadow-sm">
                                <div>
                                    <h3 class="font-bold text-[#071022]">{{ $member->name }}</h3>
                                    <p class="text-slate-500 text-xs">{{ $member->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                @if($member->pivot->is_accepted)
                                    <span class="px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-black uppercase rounded-full tracking-widest">{{ $member->pivot->role }}</span>
                                @else
                                    <span class="px-3 py-1 bg-amber-50 text-amber-600 border border-amber-200 text-[10px] font-black uppercase rounded-full tracking-widest">Invited as {{ $member->pivot->role }}</span>
                                @endif
                                @if($trip->user_id === Auth::id())
                                    <form action="{{ route('trips.members.destroy', [$trip, $member]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition-colors" onclick="return confirm('Remove this member from the trip?')">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Budget Tab --}}
        <div x-show="activeTab === 'budget'" x-cloak>
            @if(Auth::user()->plan === 'plus')
                <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                        <div>
                            <h2 class="text-xl font-bold text-[#071022]">Budget & Expenses</h2>
                            <p class="text-slate-500 text-sm mt-1">Track your spending for this trip.</p>
                        </div>
                        @if($trip->user_id === Auth::id())
                            <button @click="showExpenseModal = true" class="btn-primary py-2.5 px-5 rounded-xl text-xs font-bold flex items-center justify-center gap-2 shadow-lg shadow-[#FF52A7]/20 hover:-translate-y-0.5 transition-transform">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                Add Expense
                            </button>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 relative overflow-hidden group hover:border-[#FF52A7]/30 transition-colors">
                            <p class="text-slate-500 text-sm font-medium mb-1 relative z-10">Total Budget</p>
                            <p class="text-3xl font-black text-[#071022] relative z-10">$0.00</p>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 relative overflow-hidden group hover:border-[#FF52A7]/30 transition-colors">
                            <p class="text-slate-500 text-sm font-medium mb-1 relative z-10">Total Spent</p>
                            <p class="text-3xl font-black text-[#FF52A7] relative z-10">$0.00</p>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 relative overflow-hidden group hover:border-emerald-500/30 transition-colors">
                            <p class="text-slate-500 text-sm font-medium mb-1 relative z-10">Remaining</p>
                            <p class="text-3xl font-black text-emerald-500 relative z-10">$0.00</p>
                        </div>
                    </div>

                    <div class="text-center py-16 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50/50">
                        <div class="w-20 h-20 bg-white rounded-full shadow-sm flex items-center justify-center text-slate-300 mx-auto mb-5 border border-slate-100">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#071022]">No expenses recorded</h3>
                        <p class="text-slate-500 text-sm mt-2 max-w-sm mx-auto">Start tracking your spending to stay within your trip's budget limit.</p>
                    </div>
                </div>
            @else
                <div class="bg-gradient-to-br from-[#071022] to-[#1a2942] rounded-3xl p-10 md:p-16 text-center flex flex-col items-center justify-center space-y-8 relative overflow-hidden shadow-2xl">
                    <!-- Decorative Background -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-[#FF52A7]/20 to-transparent rounded-full blur-3xl translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tr from-[#7C3AED]/20 to-transparent rounded-full blur-3xl -translate-x-1/2 translate-y-1/2"></div>
                    
                    <div class="w-24 h-24 bg-white/10 backdrop-blur-md rounded-full flex items-center justify-center text-yellow-400 border border-white/20 relative z-10 shadow-[0_0_40px_rgba(250,204,21,0.2)]">
                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    
                    <div class="relative z-10 space-y-3">
                        <h2 class="text-3xl font-black text-white font-['Playfair_Display',serif] tracking-tight">Unlock Premium Features</h2>
                        <p class="text-white/70 max-w-lg mx-auto text-sm md:text-base leading-relaxed">
                            Upgrade to <strong class="text-white">Explorer Plus</strong> to track expenses, set budget limits, and split costs fairly with your travel buddies.
                        </p>
                    </div>
                    
                    <a href="{{ route('pricing') }}" class="relative z-10 btn-primary py-3.5 px-8 rounded-xl text-[#071022] font-black shadow-[0_0_20px_rgba(255,82,167,0.4)] hover:scale-105 hover:shadow-[0_0_30px_rgba(255,82,167,0.6)] transition-all duration-300 flex items-center gap-2">
                        View Premium Plans
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Modals --}}
    
    {{-- Add Activity Modal --}}
    <div x-show="showActivityModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         x-cloak>
        <div class="bg-white rounded-[2rem] w-full max-w-lg overflow-hidden shadow-2xl animate-float-up" @click.away="showActivityModal = false">
            <div class="p-8 space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-black text-[#071022]">Add New Activity</h3>
                    <button @click="showActivityModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form action="{{ route('trips.activities.store', $trip) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Title</label>
                        <input type="text" name="title" required class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Date</label>
                            <input type="date" name="date" required value="{{ $trip->start_date }}" class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Type</label>
                            <select name="type" class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all appearance-none">
                                <option value="activity">Activity</option>
                                <option value="transport">Transport</option>
                                <option value="accommodation">Accommodation</option>
                                <option value="dining">Dining</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Start Time</label>
                            <input type="time" name="start_time" class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">End Time</label>
                            <input type="time" name="end_time" class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Location</label>
                        <input type="text" name="location" class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Notes</label>
                        <textarea name="notes" rows="3" class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all"></textarea>
                    </div>

                    <button type="submit" class="w-full py-4 bg-[#FF52A7] text-white font-black rounded-2xl shadow-lg shadow-[#FF52A7]/30 hover:scale-[1.02] active:scale-[0.98] transition-all mt-4">
                        SAVE ACTIVITY
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Invite Member Modal --}}
    <div x-show="showInviteModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         x-cloak>
        <div class="bg-white rounded-[2rem] w-full max-w-md overflow-hidden shadow-2xl animate-float-up" @click.away="showInviteModal = false">
            <div class="p-8 space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-black text-[#071022]">Invite Buddy</h3>
                    <button @click="showInviteModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form action="{{ route('trips.members.store', $trip) }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Email Address</label>
                        <input type="email" name="email" required placeholder="friend@example.com" class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all">
                        <p class="text-[10px] text-slate-400 font-medium">User must already have an account to be invited.</p>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Role</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="role" value="viewer" checked class="peer sr-only">
                                <div class="p-4 border-2 border-slate-100 rounded-xl peer-checked:border-[#FF52A7] peer-checked:bg-[#FF52A7]/5 transition-all text-center">
                                    <span class="block font-bold text-slate-700">Viewer</span>
                                    <span class="block text-[10px] text-slate-400">Can only view</span>
                                </div>
                            </label>
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="role" value="editor" class="peer sr-only">
                                <div class="p-4 border-2 border-slate-100 rounded-xl peer-checked:border-[#FF52A7] peer-checked:bg-[#FF52A7]/5 transition-all text-center">
                                    <span class="block font-bold text-slate-700">Editor</span>
                                    <span class="block text-[10px] text-slate-400">Can edit itinerary</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-[#071022] text-white font-black rounded-2xl shadow-xl hover:bg-slate-800 transition-all">
                        SEND INVITATION
                    </button>
                </form>
            </div>
        </div>
    </div>
    {{-- Add Expense Modal --}}
    <div x-show="showExpenseModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         x-cloak>
        <div class="bg-white rounded-[2rem] w-full max-w-md overflow-hidden shadow-2xl animate-float-up" @click.away="showExpenseModal = false">
            <div class="p-8 space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-black text-[#071022]">Add Expense</h3>
                    <button @click="showExpenseModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form action="{{ route('trips.expenses.store', $trip) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Title</label>
                        <input type="text" name="title" required placeholder="Dinner at Luigi's" class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Amount ($)</label>
                            <input type="number" step="0.01" name="amount" required placeholder="0.00" class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Category</label>
                            <select name="category" class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all appearance-none">
                                <option value="food">Food & Dining</option>
                                <option value="transport">Transportation</option>
                                <option value="accommodation">Accommodation</option>
                                <option value="activities">Activities</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-[#FFB800] text-[#071022] font-black rounded-2xl shadow-xl hover:bg-yellow-400 transition-all mt-4">
                        SAVE EXPENSE
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
