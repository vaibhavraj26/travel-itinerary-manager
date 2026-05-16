@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-transparent page-root pt-4 pb-24">
    <div class="max-w-5xl mx-auto px-6 lg:px-12">
        <div class="text-center mb-10">
            @if(Auth::check() && Auth::user()->plan === 'plus')
                <h2 class="font-['Playfair_Display',serif] text-4xl lg:text-5xl font-black text-[#071022]">
                    Your Current <span class="text-[#FF52A7]">Plan</span>
                </h2>
                <p class="mt-4 text-slate-600 max-w-xl mx-auto text-base">
                    You're on the Explorer Plus plan. Enjoy all the premium features!
                </p>
            @elseif(Auth::check())
                @if(session('onboarding'))
                    <h2 class="font-['Playfair_Display',serif] text-4xl lg:text-5xl font-black text-[#071022]">
                        Choose your <span class="text-[#FF52A7]">Journey</span>
                    </h2>
                    <p class="mt-4 text-slate-600 max-w-xl mx-auto text-base">
                        You've successfully created your account! Choose a plan below to continue to your dashboard.
                    </p>
                @else
                    <h2 class="font-['Playfair_Display',serif] text-4xl lg:text-5xl font-black text-[#071022]">
                        Your Current <span class="text-[#FF52A7]">Plan</span>
                    </h2>
                    <p class="mt-4 text-slate-600 max-w-xl mx-auto text-base">
                        You're currently on the Free plan. Upgrade to Explorer Plus for unlimited features.
                    </p>
                @endif
            @else
                <h2 class="font-['Playfair_Display',serif] text-4xl lg:text-5xl font-black text-[#071022]">
                    Simple, <span class="text-[#FF52A7]">Transparent</span> Plans
                </h2>
                <p class="mt-4 text-slate-600 max-w-xl mx-auto text-base">
                    Start for free, upgrade when you're ready. No hidden fees, cancel anytime.
                </p>
                <p class="mt-2 text-sm text-slate-500">
                    Already have an account? <a href="{{ route('login') }}" class="text-[#FF52A7] font-semibold hover:underline">Sign in</a>
                </p>
            @endif
        </div>

        @if(Auth::check() && Auth::user()->plan === 'plus')
            <x-pricing-cards
                freeLabel="Free Plan"
                :freeUrl="route('trips.index')"
                plusLabel="Current Plan"
                :plusUrl="route('trips.index')"
                plusCurrent
            />
        @elseif(Auth::check())
            @if(session('onboarding'))
                <x-pricing-cards
                    freeLabel="Continue with Free"
                    :freeUrl="route('trips.index')"
                    plusLabel="Upgrade to Plus"
                    :plusUrl="route('checkout')"
                />
            @else
                <x-pricing-cards
                    freeLabel="Current Plan"
                    :freeUrl="route('trips.index')"
                    plusLabel="Upgrade to Plus"
                    :plusUrl="route('checkout')"
                    freeCurrent
                />
            @endif
        @else
            <x-pricing-cards
                freeLabel="Get Started Free"
                :freeUrl="route('register', ['plan' => 'free'])"
                plusLabel="Start 14-Day Free Trial"
                :plusUrl="route('register', ['plan' => 'plus'])"
            />
        @endif
    </div>
</div>
@endsection
