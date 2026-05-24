@extends('layouts.dashboard')

@section('header_title', 'Profile Settings')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-float-up pb-12">
    
    {{-- Header Banner --}}
    <div class="relative h-48 rounded-[2rem] overflow-hidden shadow-lg group">
        <div class="absolute inset-0 bg-gradient-to-r from-violet-600 to-[#FF52A7] group-hover:scale-105 transition-transform duration-700"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        
        <div class="absolute -bottom-10 left-8 flex items-end gap-6">
            <div class="relative">
                <div class="w-32 h-32 rounded-3xl bg-white p-2 shadow-2xl rotate-3 hover:rotate-0 transition-transform duration-300">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover rounded-2xl" alt="{{ $user->name }}">
                    @else
                        <div class="w-full h-full rounded-2xl bg-gradient-to-tr from-[#FF52A7] to-violet-500 flex items-center justify-center text-4xl text-white font-black">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-emerald-400 border-4 border-white rounded-full shadow-md z-10" title="Online"></div>
            </div>
            
            <div class="mb-12 text-white drop-shadow-md">
                <h1 class="text-3xl font-black">{{ $user->name }}</h1>
                <p class="text-white/80 font-medium">{{ $user->plan === 'plus' ? 'Explorer Plus Member' : 'Free Explorer' }}</p>
            </div>
        </div>
    </div>

    <div class="h-8"></div> {{-- Spacer for the overlapping avatar --}}

    {{-- Forms Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-12">
        
        {{-- Profile Information --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-[2rem] p-8 border border-slate-200 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-5 text-[#FF52A7] pointer-events-none">
                    <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
                
                <h2 class="text-xl font-bold text-[#071022] mb-1">Personal Information</h2>
                <p class="text-slate-500 text-sm mb-6">Update your account's profile information and email address.</p>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6 relative z-10">
                    @csrf
                    @method('PUT')

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Profile Picture</label>
                        <input type="file" name="avatar" accept="image/*" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 @error('avatar') border-red-300 bg-red-50 @enderror">
                        @error('avatar') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-5 py-3.5 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all @error('name') border-red-300 bg-red-50 @enderror">
                            @error('name') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-5 py-3.5 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all @error('email') border-red-300 bg-red-50 @enderror">
                            @error('email') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Bio / About Me</label>
                        <textarea name="bio" rows="3" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all @error('bio') border-red-300 bg-red-50 @enderror">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Location</label>
                            <input type="text" name="location" value="{{ old('location', $user->location) }}" placeholder="e.g. New York, USA" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all @error('location') border-red-300 bg-red-50 @enderror">
                            @error('location') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-5 py-3.5 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all @error('phone') border-red-300 bg-red-50 @enderror">
                            @error('phone') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <h3 class="text-lg font-bold text-[#071022] mt-8 mb-4">Social Links</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Instagram Username</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-slate-400">@</span>
                                <input type="text" name="instagram" value="{{ old('instagram', $user->social_links['instagram'] ?? '') }}" class="w-full pl-10 pr-5 py-3.5 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all @error('instagram') border-red-300 bg-red-50 @enderror">
                            </div>
                            @error('instagram') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Twitter / X Username</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-slate-400">@</span>
                                <input type="text" name="twitter" value="{{ old('twitter', $user->social_links['twitter'] ?? '') }}" class="w-full pl-10 pr-5 py-3.5 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all @error('twitter') border-red-300 bg-red-50 @enderror">
                            </div>
                            @error('twitter') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="py-3 px-8 bg-[#071022] text-white font-black font-bold rounded-xl shadow-lg hover:bg-slate-800 hover:scale-[1.02] active:scale-[0.98] transition-all">
                            SAVE CHANGES
                        </button>
                        
                        @if (session('success') && !request()->has('password_updated'))
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm text-emerald-600 font-bold flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Saved.
                            </p>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Update Password --}}
            <div class="bg-white rounded-[2rem] p-8 border border-slate-200 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-5 text-violet-600 pointer-events-none">
                    <svg class="w-24 h-24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>

                <h2 class="text-xl font-bold text-[#071022] mb-1">Update Password</h2>
                <p class="text-slate-500 text-sm mb-6">Ensure your account is using a long, random password to stay secure.</p>

                <form method="POST" action="{{ route('profile.password') }}" class="space-y-6 relative z-10">
                    @csrf
                    @method('PUT')

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Current Password</label>
                        <input type="password" name="current_password" required class="w-full px-5 py-3.5 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-violet-500 outline-none transition-all @error('current_password') border-red-300 bg-red-50 @enderror">
                        @error('current_password') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">New Password</label>
                            <input type="password" name="password" required class="w-full px-5 py-3.5 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-violet-500 outline-none transition-all @error('password') border-red-300 bg-red-50 @enderror">
                            @error('password') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Confirm Password</label>
                            <input type="password" name="password_confirmation" required class="w-full px-5 py-3.5 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-violet-500 outline-none transition-all">
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="py-3 px-8 bg-[#071022] text-white font-black rounded-xl shadow-lg hover:bg-slate-800 hover:scale-[1.02] active:scale-[0.98] transition-all">
                            UPDATE PASSWORD
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Side Column --}}
        <div class="space-y-8">
            {{-- Account Plan Status --}}
            <div class="bg-gradient-to-br from-[#071022] to-slate-800 rounded-[2rem] p-8 shadow-xl text-white relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
                
                <h2 class="text-lg font-bold mb-4">Account Status</h2>
                
                @if($user->plan === 'plus')
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-amber-200 to-yellow-400 text-yellow-900 rounded-lg text-xs font-black tracking-wider uppercase mb-6 shadow-lg">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        Plus Active
                    </div>
                    <p class="text-white/70 text-sm leading-relaxed mb-6">You have full access to all premium features, including unlimited collaboration and priority AI generation.</p>
                @else
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 text-white rounded-lg text-xs font-black tracking-wider uppercase mb-6">
                        Free Tier
                    </div>
                    <p class="text-white/70 text-sm leading-relaxed mb-6">Upgrade to Explorer Plus to unlock unlimited itineraries, collaboration, and advanced trip building features.</p>
                    <a href="{{ route('pricing') }}" class="block text-center w-full py-3 bg-gradient-to-r from-[#FF52A7] to-violet-500 text-white font-black rounded-xl shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all">
                        UPGRADE NOW
                    </a>
                @endif
            </div>

            {{-- Danger Zone --}}
            <div class="bg-red-50 rounded-[2rem] p-8 border border-red-100 shadow-sm" x-data="{ showDeleteModal: false }">
                <div class="flex items-center gap-3 text-red-600 mb-2">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <h2 class="text-xl font-bold">Danger Zone</h2>
                </div>
                <p class="text-red-400 text-sm mb-6">Once you delete your account, there is no going back. All of your trips, plans, and data will be permanently deleted.</p>

                <button @click="showDeleteModal = true" class="w-full py-3 bg-white border-2 border-red-200 text-red-600 font-bold rounded-xl hover:bg-red-600 hover:text-white hover:border-red-600 transition-all">
                    DELETE ACCOUNT
                </button>

                {{-- Delete Account Modal --}}
                <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
                    <div class="bg-white rounded-[2rem] w-full max-w-md overflow-hidden shadow-2xl p-8" @click.away="showDeleteModal = false">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center text-red-600 mx-auto mb-6">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        
                        <h3 class="text-2xl font-black text-center text-[#071022] mb-2">Are you absolutely sure?</h3>
                        <p class="text-center text-slate-500 mb-8">This action cannot be undone. All of your data, including trips and activities, will be permanently removed.</p>

                        <form method="POST" action="{{ route('account.delete') }}">
                            @csrf
                            @method('DELETE')
                            <div class="flex gap-4">
                                <button type="button" @click="showDeleteModal = false" class="flex-1 py-3.5 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition-all">
                                    Cancel
                                </button>
                                <button type="submit" class="flex-1 py-3.5 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/30 hover:bg-red-700 transition-all">
                                    Yes, Delete
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
