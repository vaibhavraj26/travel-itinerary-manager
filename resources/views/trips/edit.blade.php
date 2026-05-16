@extends('layouts.dashboard')

@section('header_title', 'Edit Trip: ' . $trip->title)

@section('content')
<div class="max-w-3xl mx-auto animate-float-up">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
        {{-- Form Header --}}
        <div class="bg-[#071022] p-8 text-white relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-3xl font-bold font['Playfair_Display',serif]">Update Your Adventure</h1>
                <p class="text-slate-400 mt-2">Modify the details of your journey below.</p>
            </div>
            {{-- Abstract background pattern --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-[#FF52A7] rounded-full blur-[100px] opacity-20 -translate-y-1/2 translate-x-1/2"></div>
        </div>

        {{-- Form Body --}}
        <form action="{{ route('trips.update', $trip) }}" method="POST" class="p-8 space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Trip Title --}}
                <div class="md:col-span-2 space-y-2">
                    <label for="title" class="text-sm font-bold text-slate-700">Trip Name</label>
                    <input type="text" name="title" id="title" placeholder="e.g. Summer in Santorini" 
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#FF52A7] transition-all outline-none @error('title') border-red-400 @enderror"
                           value="{{ old('title', $trip->title) }}" required>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Destination --}}
                <div class="space-y-2">
                    <label for="destination" class="text-sm font-bold text-slate-700">Destination</label>
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <input type="text" name="destination" id="destination" placeholder="City, Country" 
                               class="w-full pl-12 pr-5 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#FF52A7] transition-all outline-none @error('destination') border-red-400 @enderror"
                               value="{{ old('destination', $trip->destination) }}" required>
                    </div>
                    @error('destination') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Status --}}
                <div class="space-y-2">
                    <label for="status" class="text-sm font-bold text-slate-700">Trip Status</label>
                    <select name="status" id="status" class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#FF52A7] transition-all outline-none appearance-none">
                        <option value="upcoming" {{ old('status', $trip->status) == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="active" {{ old('status', $trip->status) == 'active' ? 'selected' : '' }}>Currently Active</option>
                        <option value="completed" {{ old('status', $trip->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $trip->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                {{-- Dates --}}
                <div class="space-y-2">
                    <label for="start_date" class="text-sm font-bold text-slate-700">Start Date</label>
                    <input type="date" name="start_date" id="start_date" 
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#FF52A7] transition-all outline-none @error('start_date') border-red-400 @enderror"
                           value="{{ old('start_date', $trip->start_date) }}" required>
                    @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="end_date" class="text-sm font-bold text-slate-700">End Date</label>
                    <input type="date" name="end_date" id="end_date" 
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#FF52A7] transition-all outline-none @error('end_date') border-red-400 @enderror"
                           value="{{ old('end_date', $trip->end_date) }}" required>
                    @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Description --}}
                <div class="md:col-span-2 space-y-2">
                    <label for="description" class="text-sm font-bold text-slate-700">Description (Optional)</label>
                    <textarea name="description" id="description" rows="4" placeholder="What are your goals for this trip?" 
                              class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#FF52A7] transition-all outline-none">{{ old('description', $trip->description) }}</textarea>
                </div>

                {{-- Image URL --}}
                <div class="md:col-span-2 space-y-2">
                    <label for="image_url" class="text-sm font-bold text-slate-700">Cover Image URL (Optional)</label>
                    <input type="url" name="image_url" id="image_url" placeholder="https://example.com/image.jpg" 
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#FF52A7] transition-all outline-none"
                           value="{{ old('image_url', $trip->image_url) }}">
                </div>
            </div>

            {{-- Form Footer --}}
            <div class="flex items-center justify-between pt-6 border-t border-slate-100">
                <button type="button" @click="if(confirm('Are you sure you want to delete this entire trip? This cannot be undone.')) $refs.deleteForm.submit()" class="text-sm font-bold text-red-400 hover:text-red-600 transition-colors flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Delete Trip
                </button>
                <div class="flex items-center gap-4">
                    <a href="{{ route('trips.show', $trip) }}" class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-800 transition-colors">Cancel</a>
                    <button type="submit" class="btn-primary py-3 px-10 rounded-xl text-[#071022] font-bold shadow-lg shadow-[#FF52A7]/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                        Update Trip
                    </button>
                </div>
            </div>
        </form>

        {{-- Hidden Delete Form --}}
        <form x-ref="deleteForm" action="{{ route('trips.destroy', $trip) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection
