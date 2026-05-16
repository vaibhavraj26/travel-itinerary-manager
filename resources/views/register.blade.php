@extends('layouts.app')

@section('content')
@php
    $isRegister = Route::currentRouteName() === 'register';
@endphp

<div class="min-h-screen flex font-['Sora',sans-serif] relative overflow-hidden page-root">
    <!-- Global background elements matching landing aesthetics -->

    <div class="w-full flex z-10 relative">
        <!-- Left Side: Branding / Visual (Hidden on mobile) -->
        <div class="hidden lg:flex w-1/2 flex-col justify-between p-6 lg:p-8 relative">
            <!-- Glassy background container -->
            <div class="absolute inset-4 lg:inset-6 rounded-[2rem] bg-gradient-to-br from-[#071022] to-[#1A2540] overflow-hidden shadow-2xl shadow-indigo-900/20">
                <!-- Abstract Map/Travel graphic background -->
                <div class="absolute inset-0 opacity-50 bg-[url('https://images.unsplash.com/photo-1488646953014-85cb44e25828?q=80&w=2000&auto=format&fit=crop')] bg-cover bg-center"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-[#071022] via-[#071022]/80 to-[#071022]/20"></div>
                
                <!-- Content --> 
                <div class="absolute inset-0 flex flex-col justify-between p-8 lg:p-10">
                    <a href="{{ route('landing') }}" class="flex items-center gap-2 group w-max">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 h-8 text-[#FF52A7] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="1.5">
                          <path d="M12 2C8.134 2 5 5.134 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.866-3.134-7-7-7z" fill="#FF52A7" stroke="none"/>
                          <circle cx="12" cy="9" r="2.5" fill="#FFF" />
                        </svg>
                        <span class="font-bold text-xl tracking-tight text-white">triptogether</span>
                    </a>

                    <div class="animate-float-up">
                        <div class="inline-flex border border-white/20 bg-white/10 backdrop-blur-md text-white text-[10px] font-semibold tracking-widest uppercase px-3 py-1.5 rounded-full mb-4">
                            Start Your Journey
                        </div>
                        <h1 class="font-['Playfair_Display',serif] text-3xl lg:text-4xl xl:text-5xl font-bold text-white leading-tight mb-4 lg:mb-6">
                            Every great journey begins with a single step.
                        </h1>
                        <div class="flex items-center gap-3">
                            <div class="flex -space-x-3">
                                <img class="w-8 h-8 lg:w-10 lg:h-10 rounded-full border-2 border-[#071022]" src="https://i.pravatar.cc/100?img=1" alt="User">
                                <img class="w-8 h-8 lg:w-10 lg:h-10 rounded-full border-2 border-[#071022]" src="https://i.pravatar.cc/100?img=2" alt="User">
                                <img class="w-8 h-8 lg:w-10 lg:h-10 rounded-full border-2 border-[#071022]" src="https://i.pravatar.cc/100?img=3" alt="User">
                                <div class="w-8 h-8 lg:w-10 lg:h-10 rounded-full border-2 border-[#071022] bg-[#334155] flex items-center justify-center text-[10px] lg:text-xs text-white font-medium">+2k</div>
                            </div>
                            <p class="text-slate-300 text-xs lg:text-sm">Join a community of modern explorers.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Auth Forms -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-4 sm:p-8">
            <div class="w-full max-w-md animate-float-up">
                
                <!-- Mobile Logo -->
                <div class="lg:hidden flex items-center justify-center gap-2 mb-6">
                    <a href="{{ route('landing') }}" class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-10 h-10 text-[#FF52A7]" fill="none" stroke="currentColor" stroke-width="1.5">
                          <path d="M12 2C8.134 2 5 5.134 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.866-3.134-7-7-7z" fill="#FF52A7" stroke="none"/>
                          <circle cx="12" cy="9" r="2.5" fill="#FFF" />
                        </svg>
                        <span class="font-bold text-3xl tracking-tight text-[#071022]">triptogether</span>
                    </a>
                </div>

                <div class="bg-white/60 backdrop-blur-xl border border-white/60 rounded-[2rem] p-6 sm:p-8 shadow-2xl shadow-[#7C3AED]/10 relative overflow-hidden">
                    
                    <!-- Form Header & Toggle -->
                    <div class="mb-6 relative z-10">
                        <div class="bg-slate-200/50 p-1.5 rounded-2xl flex relative mb-6 backdrop-blur-sm">
                            <div id="toggle-slider" class="absolute top-1.5 bottom-1.5 left-1.5 w-[calc(50%-0.375rem)] bg-white rounded-xl shadow-sm transition-transform duration-300 ease-out {{ $isRegister ? 'translate-x-full' : '' }}"></div>
                            <button onclick="switchTab('login')" id="btn-login" class="flex-1 py-2.5 text-sm font-semibold z-10 transition-colors duration-300 {{ $isRegister ? 'text-slate-500 hover:text-slate-700' : 'text-[#071022]' }}">Sign In</button>
                            <button onclick="switchTab('register')" id="btn-register" class="flex-1 py-2.5 text-sm font-semibold z-10 transition-colors duration-300 {{ $isRegister ? 'text-[#071022]' : 'text-slate-500 hover:text-slate-700' }}">Create Account</button>
                        </div>
                        
                        <h2 id="form-title" class="font-['Playfair_Display',serif] text-3xl font-bold text-[#071022] mb-2 transition-all duration-300">
                            {{ $isRegister ? 'Create an account' : 'Welcome back' }}
                        </h2>
                        <p id="form-subtitle" class="text-slate-500 text-sm transition-all duration-300">
                            {{ $isRegister ? 'Enter your details to begin your journey.' : 'Enter your credentials to access your account.' }}
                        </p>
                    </div>

                    <!-- Forms Container -->
                    <div class="relative z-10">
                        <!-- Login Form -->
                        <form id="form-login" action="{{ route('login.submit') }}" method="POST" class="transition-opacity duration-300 {{ $isRegister ? 'hidden opacity-0 absolute' : 'block opacity-100 relative' }}">
                            @csrf
                            @if(request('plan'))
                                <input type="hidden" name="plan" value="{{ request('plan') }}">
                            @endif
                            
                            <div class="space-y-3 sm:space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Email Address</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                                        </div>
                                        <input type="email" name="email" value="{{ old('email') }}" class="w-full pl-11 pr-4 py-2.5 bg-white/70 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF52A7]/30 focus:border-[#FF52A7] transition-all outline-none text-slate-800 placeholder-slate-400" placeholder="you@example.com" required>
                                    </div>
                                    @error('email') <span class="text-xs text-red-500 mt-1 block">{!! $message !!}</span> @enderror
                                </div>
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="block text-sm font-semibold text-slate-700">Password</label>
                                        <a href="#" onclick="switchTab('forgot'); return false;" class="text-xs font-semibold text-[#7C3AED] hover:text-[#5B21B6] transition-colors">Forgot password?</a>
                                    </div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                        </div>
                                        <input type="password" name="password" class="w-full pl-11 pr-4 py-2.5 bg-white/70 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF52A7]/30 focus:border-[#FF52A7] transition-all outline-none text-slate-800 placeholder-slate-400" placeholder="••••••••" required>
                                    </div>
                                    @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    @if ($errors->has('login'))
                                        <span class="text-xs text-red-500 mt-1 block">{{ $errors->first('login') }}</span>
                                    @endif
                                </div>
                                <button type="submit" class="w-full btn-primary py-3 rounded-xl text-[#071022] font-bold text-sm shadow-lg shadow-[#FF52A7]/20 hover:-translate-y-0.5 transition-transform mt-4">
                                    Sign In to Dashboard
                                </button>
                            </div>
                        </form>

                        <!-- Register Form -->
                        <form id="form-register" action="{{ route('register.submit') }}" method="POST" class="transition-opacity duration-300 {{ $isRegister ? 'block opacity-100 relative' : 'hidden opacity-0 absolute' }}">
                            @csrf
                            @if(request('plan'))
                                <input type="hidden" name="plan" value="{{ request('plan') }}">
                            @endif
                            <div class="space-y-3 sm:space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Full Name</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                        </div>
                                        <input type="text" name="name" value="{{ old('name') }}" class="w-full pl-11 pr-4 py-2.5 bg-white/70 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF52A7]/30 focus:border-[#FF52A7] transition-all outline-none text-slate-800 placeholder-slate-400" placeholder="John Doe" required>
                                    </div>
                                    @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Email Address</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                                        </div>
                                        <input type="email" name="email" value="{{ old('email') }}" class="w-full pl-11 pr-4 py-2.5 bg-white/70 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF52A7]/30 focus:border-[#FF52A7] transition-all outline-none text-slate-800 placeholder-slate-400" placeholder="you@example.com" required>
                                    </div>
                                    @error('email') <span class="text-xs text-red-500 mt-1 block">{!! $message !!}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                        </div>
                                        <input type="password" name="password" class="w-full pl-11 pr-4 py-2.5 bg-white/70 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF52A7]/30 focus:border-[#FF52A7] transition-all outline-none text-slate-800 placeholder-slate-400" placeholder="••••••••" required>
                                    </div>
                                    @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <button type="submit" class="w-full btn-primary py-3 rounded-xl text-[#071022] font-bold text-sm shadow-lg shadow-[#FF52A7]/20 hover:-translate-y-0.5 transition-transform mt-4">
                                    Create Account
                                </button>
                            </div>
                        </form>

                        <!-- Forgot Password Form -->
                        <form id="form-forgot" action="#" method="POST" class="hidden opacity-0 absolute transition-opacity duration-300">
                            @csrf
                            <div class="space-y-3 sm:space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Email Address</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                                        </div>
                                        <input type="email" id="forgot-email" name="email" class="w-full pl-11 pr-24 py-2.5 bg-white/70 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF52A7]/30 focus:border-[#FF52A7] transition-all outline-none text-slate-800 placeholder-slate-400" placeholder="you@example.com" required>
                                        <div class="absolute inset-y-1 right-1">
                                            <button type="button" id="btn-send-otp" class="h-full px-3 bg-slate-800 hover:bg-slate-900 disabled:bg-slate-300 disabled:cursor-not-allowed text-white text-xs font-bold rounded-lg transition-colors">
                                                Send OTP
                                            </button>
                                        </div>
                                    </div>
                                    <div id="otp-message" class="text-xs font-semibold text-slate-500 mt-1 hidden"></div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Verification OTP</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                        </div>
                                        <input type="text" id="otp-input" name="otp" maxlength="6" pattern="\d{6}" class="w-full pl-11 pr-4 py-2.5 bg-white/70 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF52A7]/30 focus:border-[#FF52A7] transition-all outline-none text-slate-800 placeholder-slate-400 tracking-widest font-mono text-center text-lg" placeholder="• • • • • •" required>
                                    </div>
                                </div>
                                <button type="button" id="btn-verify" disabled class="w-full py-3 rounded-xl font-bold text-sm transition-all mt-4 bg-slate-200 text-slate-400 cursor-not-allowed">
                                    Verify OTP
                                </button>
                                <div class="text-center mt-3">
                                    <a href="#" onclick="switchTab('login'); return false;" class="text-xs font-semibold text-slate-500 hover:text-slate-700 transition-colors">Back to Sign In</a>
                                </div>
                            </div>
                        </form>

                        <div id="social-login-section">
                            <div class="mt-6 flex items-center justify-center gap-4">
                                <div class="h-px bg-slate-200 flex-1"></div>
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-widest">Or continue with</span>
                                <div class="h-px bg-slate-200 flex-1"></div>
                            </div>

                            <div class="mt-5 grid grid-cols-2 gap-4">
                            <button type="button" class="flex items-center justify-center gap-2 py-2.5 border border-slate-200 bg-white/80 hover:bg-white transition-colors rounded-xl text-sm font-semibold text-slate-700 shadow-sm">
                                <svg class="w-5 h-5" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/><path d="M1 1h22v22H1z" fill="none"/></svg>
                                Google
                            </button>
                            <button type="button" class="flex items-center justify-center gap-2 py-2.5 border border-slate-200 bg-white/80 hover:bg-white transition-colors rounded-xl text-sm font-semibold text-slate-700 shadow-sm">
                                <svg class="w-5 h-5 text-black" fill="currentColor" viewBox="0 0 24 24"><path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.04 2.26-.74 3.58-.8 1.58.016 2.9.46 3.87 1.25-.87 1.05-1.49 1.93-1.44 3.47.05 1.7 1.14 2.81 2.04 3.53-.88 1.41-1.89 3.01-3.05 4.72zm-2.48-15.6c-.05 1.78-1.02 3.16-2.45 3.96-.58-1.57-1.39-2.92-2.31-3.69-.94-.78-2.01-1.36-2.55-1.44.06-1.8 1.01-3.3 2.5-4.14 1.48-.84 3.07-.98 3.94-.96.11 1.35-.07 2.7-.87 3.86z"/></svg>
                                Apple
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-[11px] text-slate-500 leading-relaxed">
                        By continuing, you agree to TripTogether's <br>
                        <a href="#" class="text-[#7C3AED] font-semibold hover:underline">Terms of Service</a> and <a href="#" class="text-[#7C3AED] font-semibold hover:underline">Privacy Policy</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const initialQueryString = window.location.search;

    function switchTab(tab) {
        const isLogin = tab === 'login';
        const isForgot = tab === 'forgot';
        
        // Clear any server validation errors when switching tabs
        document.querySelectorAll('.text-red-500').forEach(el => el.style.display = 'none');
        
        // Update slider position
        const slider = document.getElementById('toggle-slider');
        if (isLogin || isForgot) {
            slider.classList.remove('translate-x-full');
        } else {
            slider.classList.add('translate-x-full');
        }

        // Update button text colors
        document.getElementById('btn-login').className = `flex-1 py-2.5 text-sm font-semibold z-10 transition-colors duration-300 ${(isLogin || isForgot) ? 'text-[#071022]' : 'text-slate-500 hover:text-slate-700'}`;
        document.getElementById('btn-register').className = `flex-1 py-2.5 text-sm font-semibold z-10 transition-colors duration-300 ${(isLogin || isForgot) ? 'text-slate-500 hover:text-slate-700' : 'text-[#071022]'}`;

        // Update titles with fade effect
        const title = document.getElementById('form-title');
        const subtitle = document.getElementById('form-subtitle');
        
        title.style.opacity = 0;
        subtitle.style.opacity = 0;
        
        setTimeout(() => {
            if (isForgot) {
                title.innerText = 'Reset Password';
                subtitle.innerText = 'Enter your email and the 6-digit OTP to verify your identity.';
            } else if (isLogin) {
                title.innerText = 'Welcome back';
                subtitle.innerText = 'Enter your credentials to access your account.';
            } else {
                title.innerText = 'Create an account';
                subtitle.innerText = 'Enter your details to begin your journey.';
            }
            title.style.opacity = 1;
            subtitle.style.opacity = 1;
        }, 150);

        // Toggle form visibility
        const formLogin = document.getElementById('form-login');
        const formRegister = document.getElementById('form-register');
        const formForgot = document.getElementById('form-forgot');
        
        [formLogin, formRegister, formForgot].forEach(form => {
            if (form) {
                form.classList.remove('block', 'opacity-100', 'relative');
                form.classList.add('hidden', 'opacity-0', 'absolute');
            }
        });

        if (isForgot) {
            formForgot.classList.remove('hidden', 'opacity-0', 'absolute');
            formForgot.classList.add('block', 'opacity-100', 'relative');
        } else if (isLogin) {
            formLogin.classList.remove('hidden', 'opacity-0', 'absolute');
            formLogin.classList.add('block', 'opacity-100', 'relative');
            window.history.pushState({}, '', '{{ route('login') }}');
        } else {
            formRegister.classList.remove('hidden', 'opacity-0', 'absolute');
            formRegister.classList.add('block', 'opacity-100', 'relative');
            window.history.pushState({}, '', '{{ route('register') }}' + initialQueryString);
        }

        // Toggle social section
        const socialSection = document.getElementById('social-login-section');
        if (socialSection) {
            socialSection.style.display = isForgot ? 'none' : 'block';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const otpInput = document.getElementById('otp-input');
        const verifyBtn = document.getElementById('btn-verify');
        if (otpInput && verifyBtn) {
            otpInput.addEventListener('input', (e) => {
                e.target.value = e.target.value.replace(/\D/g, ''); // Allow only numbers
                if (e.target.value.length === 6) {
                    verifyBtn.disabled = false;
                    verifyBtn.className = 'w-full btn-primary py-3 rounded-xl text-[#071022] font-bold text-sm shadow-lg shadow-[#FF52A7]/20 hover:-translate-y-0.5 transition-all mt-4';
                } else {
                    verifyBtn.disabled = true;
                    verifyBtn.className = 'w-full py-3 rounded-xl font-bold text-sm transition-all mt-4 bg-slate-200 text-slate-400 cursor-not-allowed';
                }
            });

            verifyBtn.addEventListener('click', () => {
                // Clear input and reset button state
                otpInput.value = '';
                verifyBtn.disabled = true;
                verifyBtn.className = 'w-full py-3 rounded-xl font-bold text-sm transition-all mt-4 bg-slate-200 text-slate-400 cursor-not-allowed';
                
                // Switch back to login
                switchTab('login');
            });
        }

        const sendOtpBtn = document.getElementById('btn-send-otp');
        const forgotEmail = document.getElementById('forgot-email');
        const otpMessage = document.getElementById('otp-message');

        if (sendOtpBtn && forgotEmail && otpMessage) {
            sendOtpBtn.addEventListener('click', () => {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(forgotEmail.value)) {
                    forgotEmail.focus();
                    // Optionally show a quick visual cue
                    forgotEmail.classList.add('ring-2', 'ring-red-500/50', 'border-red-500');
                    setTimeout(() => forgotEmail.classList.remove('ring-2', 'ring-red-500/50', 'border-red-500'), 1500);
                    return;
                }

                // Valid email, start countdown
                sendOtpBtn.disabled = true;
                sendOtpBtn.innerText = 'Email Sent!';
                
                let timeLeft = 120; // 2 minutes
                otpMessage.classList.remove('hidden');
                
                const updateMessage = () => {
                    const m = Math.floor(timeLeft / 60);
                    const s = timeLeft % 60;
                    otpMessage.innerText = `Resend in ${m}:${s.toString().padStart(2, '0')}`;
                };
                
                updateMessage();
                
                const timer = setInterval(() => {
                    timeLeft--;
                    if (timeLeft <= 0) {
                        clearInterval(timer);
                        sendOtpBtn.disabled = false;
                        sendOtpBtn.innerText = 'Send OTP';
                        otpMessage.classList.add('hidden');
                    } else {
                        updateMessage();
                    }
                }, 1000);
            });
        }
    });
</script>
@endsection
