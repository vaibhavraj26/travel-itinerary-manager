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
                            <div class="flex items-center gap-3">
                                @if(!$trip->budget)
                                    <button @click="showBudgetModal = true" class="btn-primary py-2.5 px-5 rounded-xl text-xs font-bold flex items-center justify-center gap-2 shadow-lg shadow-[#FF52A7]/20 hover:-translate-y-0.5 transition-transform">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                        Add Budget
                                    </button>
                                @else
                                    <button @click="showBudgetModal = true" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        Update Budget
                                    </button>
                                    <button @click="showExpenseModal = true" class="btn-primary py-2.5 px-5 rounded-xl text-xs font-bold flex items-center justify-center gap-2 shadow-lg shadow-[#FF52A7]/20 hover:-translate-y-0.5 transition-transform">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                        Add Expense
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 relative overflow-hidden group hover:border-[#FF52A7]/30 transition-colors">
                            <p class="text-slate-500 text-sm font-medium mb-1 relative z-10">Total Budget</p>
                            <p class="text-3xl font-black text-[#071022] relative z-10">₹{{ number_format($trip->budget ?? 0, 2) }}</p>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 relative overflow-hidden group hover:border-[#FF52A7]/30 transition-colors">
                            <p class="text-slate-500 text-sm font-medium mb-1 relative z-10">Total Spent</p>
                            <p class="text-3xl font-black text-[#FF52A7] relative z-10">₹{{ number_format($totalSpent, 2) }}</p>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 relative overflow-hidden group hover:border-emerald-500/30 transition-colors">
                            <p class="text-slate-500 text-sm font-medium mb-1 relative z-10">Remaining</p>
                            <p class="text-3xl font-black {{ $remaining < 0 ? 'text-red-500' : 'text-emerald-500' }} relative z-10">₹{{ number_format($remaining, 2) }}</p>
                        </div>
                    </div>

                    {{-- Settlements moved to its own tab --}}

                    @if($trip->expenses->isEmpty() && !$trip->budget)
                        <div class="text-center py-16 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50/50">
                            <div class="w-20 h-20 bg-white rounded-full shadow-sm flex items-center justify-center text-slate-300 mx-auto mb-5 border border-slate-100">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            </div>
                            <h3 class="text-xl font-bold text-[#071022]">No transactions yet</h3>
                            <p class="text-slate-500 text-sm mt-2 max-w-sm mx-auto">Set a budget or start tracking your spending for this trip.</p>
                        </div>
                    @else
                        {{-- Transaction List --}}
                        <div class="space-y-4">
                            @foreach($trip->expenses->sortByDesc('created_at') as $transaction)
                                @php
                                    $isDeleted = $transaction->deleted_at !== null;
                                    $containerClass = $isDeleted ? 'bg-red-50 border-red-200 opacity-50' : 'bg-white border-slate-100 hover:shadow-sm';
                                    $textClass = $isDeleted ? 'text-red-500' : 'text-[#071022]';
                                @endphp
                                @if($transaction->type === 'expense')
                                    <div class="flex items-center justify-between p-4 border rounded-2xl transition-shadow {{ $containerClass }}">
                                        <div class="flex items-center gap-4 flex-1">
                                            <div class="w-10 h-10 rounded-full {{ $isDeleted ? 'bg-red-100 text-red-600' : 'bg-red-50 text-red-500' }} flex items-center justify-center">
                                                @if($isDeleted)
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-bold {{ $textClass }}">{{ $transaction->title }}</p>
                                                <div class="flex items-center gap-2 mt-0.5 flex-wrap">
                                                    <p class="text-xs {{ $isDeleted ? 'text-red-500' : 'text-slate-500' }} uppercase tracking-widest">{{ $transaction->category }}</p>
                                                    @if($transaction->paidBy)
                                                        <span class="w-1 h-1 rounded-full {{ $isDeleted ? 'bg-red-300' : 'bg-slate-300' }}"></span>
                                                        <p class="text-[10px] {{ $isDeleted ? 'text-red-500' : 'text-slate-400' }} font-medium tracking-wide">Paid by {{ $transaction->paidBy->name }}</p>
                                                    @endif
                                                    @if($transaction->user)
                                                        <span class="w-1 h-1 rounded-full {{ $isDeleted ? 'bg-red-300' : 'bg-slate-300' }}"></span>
                                                        <p class="text-[10px] {{ $isDeleted ? 'text-red-500' : 'text-slate-400' }} font-medium tracking-wide">Added by {{ $transaction->user->name }}</p>
                                                    @endif
                                                    @if($transaction->edited_by && $transaction->editedBy)
                                                        <span class="w-1 h-1 rounded-full {{ $isDeleted ? 'bg-red-300' : 'bg-slate-300' }}"></span>
                                                        <p class="text-[10px] {{ $isDeleted ? 'text-red-500' : 'text-amber-600' }} font-medium tracking-wide">Edited by {{ $transaction->editedBy->name }}</p>
                                                    @endif
                                                    @if($isDeleted && $transaction->deletedBy)
                                                        <span class="w-1 h-1 rounded-full bg-red-300"></span>
                                                        <p class="text-[10px] text-red-500 font-medium tracking-wide">Deleted by {{ $transaction->deletedBy->name }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <p class="text-base font-black {{ $isDeleted ? 'text-slate-400' : 'text-red-500' }} whitespace-nowrap">- ₹{{ number_format($transaction->amount, 2) }}</p>
                                            @if(!$isDeleted && (Auth::user()->id === $trip->user_id || Auth::user()->trips()->where('trip_user.user_id', Auth::id())->where('trip_user.role', 'editor')->exists()))
                                                <button @click="editingExpense = {{ $transaction->id }}; editForm.title = '{{ addslashes($transaction->title) }}'; editForm.amount = parseFloat('{{ $transaction->amount }}'); editForm.category = '{{ addslashes($transaction->category) }}'; editForm.paid_by = {{ $transaction->paid_by ?? 'null' }}; editForm.type = '{{ $transaction->type }}'; showEditModal = true" class="p-2 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                                    <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </button>
                                                <button @click="deletingExpense = {{ $transaction->id }}; showDeleteModal = true" class="p-2 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                                    <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center justify-between p-4 border rounded-2xl transition-shadow {{ $containerClass }}">
                                        <div class="flex items-center gap-4 flex-1">
                                            <div class="w-10 h-10 rounded-full {{ $isDeleted ? 'bg-red-100 text-red-600' : 'bg-emerald-50 text-emerald-500' }} flex items-center justify-center">
                                                @if($isDeleted)
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-bold {{ $textClass }}">{{ $transaction->title }}</p>
                                                <div class="flex items-center gap-2 mt-0.5 flex-wrap">
                                                    <p class="text-xs {{ $isDeleted ? 'text-red-500' : 'text-slate-500' }} uppercase tracking-widest">BUDGET</p>
                                                    @if($transaction->paidBy)
                                                        <span class="w-1 h-1 rounded-full {{ $isDeleted ? 'bg-red-300' : 'bg-slate-300' }}"></span>
                                                        <p class="text-[10px] {{ $isDeleted ? 'text-red-500' : 'text-slate-400' }} font-medium tracking-wide">Paid by {{ $transaction->paidBy->name }}</p>
                                                    @endif
                                                    @if($transaction->user)
                                                        <span class="w-1 h-1 rounded-full {{ $isDeleted ? 'bg-red-300' : 'bg-slate-300' }}"></span>
                                                        <p class="text-[10px] {{ $isDeleted ? 'text-red-500' : 'text-slate-400' }} font-medium tracking-wide">Added by {{ $transaction->user->name }}</p>
                                                    @endif
                                                    @if($transaction->edited_by && $transaction->editedBy)
                                                        <span class="w-1 h-1 rounded-full {{ $isDeleted ? 'bg-red-300' : 'bg-slate-300' }}"></span>
                                                        <p class="text-[10px] {{ $isDeleted ? 'text-red-500' : 'text-amber-600' }} font-medium tracking-wide">Edited by {{ $transaction->editedBy->name }}</p>
                                                    @endif
                                                    @if($isDeleted && $transaction->deletedBy)
                                                        <span class="w-1 h-1 rounded-full bg-red-300"></span>
                                                        <p class="text-[10px] text-red-500 font-medium tracking-wide">Deleted by {{ $transaction->deletedBy->name }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <p class="text-base font-black {{ $isDeleted ? 'text-slate-400' : 'text-emerald-500' }} whitespace-nowrap">+ ₹{{ number_format($transaction->amount, 2) }}</p>
                                            @if(!$isDeleted && (Auth::user()->id === $trip->user_id || Auth::user()->trips()->where('trip_user.user_id', Auth::id())->where('trip_user.role', 'editor')->exists()))
                                                <button @click="editingExpense = {{ $transaction->id }}; editForm.title = '{{ addslashes($transaction->title) }}'; editForm.amount = parseFloat('{{ $transaction->amount }}'); editForm.category = '{{ addslashes($transaction->category) }}'; editForm.paid_by = {{ $transaction->paid_by ?? 'null' }}; editForm.type = '{{ $transaction->type }}'; showEditModal = true" class="p-2 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                                    <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </button>
                                                <button @click="deletingExpense = {{ $transaction->id }}; showDeleteModal = true" class="p-2 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                                    <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
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