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

                <form x-data="{ expenseCategory: 'food' }" action="{{ route('trips.expenses.store', $trip) }}" method="POST" class="space-y-4">
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
                            <div class="relative">
                                <select name="category" x-model="expenseCategory" class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all appearance-none pr-10">
                                    <option value="food">Food & Dining</option>
                                    <option value="transport">Transportation</option>
                                    <option value="accommodation">Accommodation</option>
                                    <option value="activities">Activities</option>
                                    <option value="other">Other</option>
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-show="expenseCategory === 'other'" x-collapse class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Custom Category</label>
                        <input type="text" name="custom_category" placeholder="e.g. Souvenirs" class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Paid By</label>
                        <div class="relative">
                            <select name="paid_by" required class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all appearance-none pr-10">
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

                    <button type="submit" class="w-full py-4 bg-[#FFB800] text-[#071022] font-black rounded-2xl shadow-xl hover:bg-yellow-400 transition-all mt-4">
                        SAVE EXPENSE
                    </button>
                </form>
            </div>
        </div>
    </div>