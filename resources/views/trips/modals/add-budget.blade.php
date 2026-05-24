{{-- Add Budget Modal --}}
    <div x-show="showBudgetModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         x-cloak>
        <div @click.away="showBudgetModal = false" 
             class="bg-white rounded-[2.5rem] w-full max-w-md p-8 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-[#FFB800] to-[#FF52A7]"></div>
            
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-[#071022]">
                    @if(!$trip->budget)
                        Add Budget
                    @else
                        Add More Budget
                    @endif
                </h3>
                <button @click="showBudgetModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Current Budget & Remaining Status Card -->
            @if($trip->budget)
            <div class="grid grid-cols-2 gap-4 p-5 bg-slate-50 rounded-[2rem] border border-slate-100/80 mb-6">
                <div>
                    <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Current Budget</span>
                    <span class="text-lg font-black text-slate-800">₹{{ number_format($trip->budget ?? 0, 2) }}</span>
                </div>
                <div>
                    <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Remaining</span>
                    <span class="text-lg font-black {{ $remaining < 0 ? 'text-red-500' : 'text-emerald-500' }}">
                        ₹{{ number_format($remaining ?? 0, 2) }}
                    </span>
                </div>
            </div>
            @endif

            <form action="{{ route('trips.budget.update', $trip) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="budget" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                        @if(!$trip->budget)
                            Set Budget Amount (₹)
                        @else
                            Amount to Add (₹)
                        @endif
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">₹</span>
                        <input type="number" step="0.01" min="1" name="budget" id="budget" required 
                               class="w-full pl-8 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-[#FFB800]/30 focus:border-[#FFB800] outline-none text-slate-800 font-bold" 
                               placeholder="0.00">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Paid By</label>
                    <div class="relative">
                        <select name="paid_by" required class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FFB800] outline-none transition-all appearance-none pr-10">
                            <option value="">Select who paid...</option>
                            <option value="{{ $trip->user_id }}">{{ $trip->user->name }} (Owner)</option>
                            @foreach($trip->sharedUsers as $member)
                                @if($member->pivot->is_accepted)
                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full btn-primary py-4 rounded-2xl text-[#071022] font-black text-sm hover:-translate-y-1 transition-transform">
                    @if(!$trip->budget)
                        Set Budget
                    @else
                        Add to Budget
                    @endif
                </button>
            </form>
        </div>
    </div>