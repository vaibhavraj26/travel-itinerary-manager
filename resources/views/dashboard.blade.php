@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center font-['Sora',sans-serif] page-root">
    <div class="bg-white/60 backdrop-blur-xl border border-white/60 rounded-[2rem] p-8 max-w-md w-full shadow-2xl shadow-[#7C3AED]/10 text-center animate-float-up">
        <h1 class="text-3xl font-bold text-[#071022] mb-4 font-['Playfair_Display',serif]">Dashboard</h1>
        <p class="text-slate-600 mb-6">Welcome, {{ Auth::user()->name ?? 'Traveler' }}!</p>
        
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium rounded-xl px-4 py-3 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-50 border border-blue-200 text-blue-700 text-sm font-medium rounded-xl px-4 py-3 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('info') }}
            </div>
        @endif
        {{-- Plan Badge --}}
        <div class="mb-8">
            @if(Auth::user()->plan === 'plus')
                <div class="inline-flex items-center gap-2 bg-gradient-to-r from-[#FFF2E6] to-[#fae593]/30 border border-[#C9A84C]/30 rounded-full px-5 py-2.5">
                    <svg class="w-4 h-4 text-[#C9A84C]" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <span class="text-sm font-bold text-[#071022]">Explorer Plus</span>
                </div>
            @else
                <div class="inline-flex items-center gap-2 bg-emerald-50 border border-emerald-200 rounded-full px-5 py-2.5">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span class="text-sm font-bold text-[#071022]">Free Plan</span>
                </div>
                <p class="text-xs text-slate-500 mt-2">
                    <a href="{{ route('checkout') }}" class="text-[#FF52A7] font-semibold hover:underline">Upgrade to Plus</a> for unlimited features.
                </p>
            @endif
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-outline w-full py-3 rounded-xl text-[#FF52A7] font-semibold text-sm hover:bg-[#FF52A7]/10 transition-colors">
                Log Out
            </button>
        </form>

        <form method="POST" action="{{ route('account.delete') }}" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full py-2.5 mt-3 rounded-xl text-red-400 font-medium text-xs hover:text-red-600 hover:bg-red-50 transition-colors">
                Delete Account
            </button>
        </form>
    </div>
</div>
@endsection
