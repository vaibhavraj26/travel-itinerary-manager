@extends('layouts.dashboard')

@section('header_title', 'Plan a New Trip')

@section('content')
<div class="max-w-3xl mx-auto animate-float-up">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
        {{-- Form Header --}}
        <div class="bg-[#071022] p-8 text-white relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-3xl font-bold font['Playfair_Display',serif]">Start Your Journey</h1>
                <p class="text-slate-400 mt-2">Fill in the details to create your travel masterpiece.</p>
            </div>
            {{-- Abstract background pattern --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-[#FF52A7] rounded-full blur-[100px] opacity-20 -translate-y-1/2 translate-x-1/2"></div>
        </div>

        {{-- Form Body --}}
        <form action="{{ route('trips.store') }}" method="POST" class="p-8 space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Trip Title --}}
                <div class="md:col-span-2 space-y-2">
                    <label for="title" class="text-sm font-bold text-slate-700">Trip Name</label>
                    <input type="text" name="title" id="title" placeholder="e.g. Summer in Santorini" 
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#FF52A7] transition-all outline-none @error('title') border-red-400 @enderror"
                           value="{{ old('title') }}" required>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Destination --}}
                <div class="space-y-2">
                    <label for="destination" class="text-sm font-bold text-slate-700">Destination</label>
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <input type="text" name="destination" id="destination" placeholder="City, Country" 
                               class="w-full pl-12 pr-5 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#FF52A7] transition-all outline-none @error('destination') border-red-400 @enderror"
                               value="{{ old('destination') }}" required>
                    </div>
                    @error('destination') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Status --}}
                <div class="space-y-2">
                    <label for="status" class="text-sm font-bold text-slate-700">Trip Status</label>
                    <div class="relative">
                        <select name="status" id="status" class="w-full px-5 pr-12 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#FF52A7] transition-all outline-none appearance-none">
                            <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Currently Active</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>

                {{-- Dates --}}
                <div class="space-y-2">
                    <label for="start_date" class="text-sm font-bold text-slate-700">Start Date</label>
                    <input type="date" name="start_date" id="start_date" 
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#FF52A7] transition-all outline-none @error('start_date') border-red-400 @enderror"
                           value="{{ old('start_date') }}" required>
                    @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="end_date" class="text-sm font-bold text-slate-700">End Date</label>
                    <input type="date" name="end_date" id="end_date" 
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#FF52A7] transition-all outline-none @error('end_date') border-red-400 @enderror"
                           value="{{ old('end_date') }}" required>
                    @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Budget --}}
                <div class="md:col-span-2 space-y-2">
                    <label for="budget" class="text-sm font-bold text-slate-700">Budget <span class="text-xs text-slate-400">(Optional - You can update it later)</span></label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 font-bold">$</span>
                        <input type="number" name="budget" id="budget" placeholder="0.00" step="0.01" min="0"
                               class="w-full pl-9 pr-5 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#FF52A7] transition-all outline-none @error('budget') border-red-400 @enderror"
                               value="{{ old('budget') }}">
                    </div>
                    @error('budget') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Description --}}
                <div class="md:col-span-2 space-y-2">
                    <label for="description" class="text-sm font-bold text-slate-700">Description (Optional)</label>
                    <textarea name="description" id="description" rows="4" placeholder="What are your goals for this trip?" 
                              class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#FF52A7] transition-all outline-none">{{ old('description') }}</textarea>
                </div>

                {{-- Image URL --}}
                <div class="md:col-span-2 space-y-2">
                    <label for="image_url" class="text-sm font-bold text-slate-700">Cover Image URL (Optional)</label>
                    <input type="url" name="image_url" id="image_url" placeholder="https://example.com/image.jpg" 
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#FF52A7] transition-all outline-none"
                           value="{{ old('image_url') }}">
                </div>
            </div>

            {{-- Form Footer --}}
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-100">
                <a href="{{ route('trips.index') }}" class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-800 transition-colors">Cancel</a>
                <button type="submit" class="btn-primary py-3 px-10 rounded-xl text-[#071022] font-bold shadow-lg shadow-[#FF52A7]/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    Create Trip
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
