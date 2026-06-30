{{-- Members Tab --}}
        <div x-show="activeTab === 'members'" x-cloak class="space-y-6">
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-xl font-bold text-page-text">Travel Buddies</h2>
                        <p class="text-slate-500 text-sm mt-1">Manage who can see and edit this itinerary.</p>
                    </div>
                    @if($trip->user_id === Auth::id() || $trip->sharedUsers()->where('user_id', Auth::id())->wherePivot('role', 'editor')->exists())
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
                            @if($trip->user->avatar)
                                <img src="{{ asset('storage/' . $trip->user->avatar) }}" class="w-12 h-12 rounded-full border-2 border-white object-cover shadow-sm">
                            @else
                                <div class="w-12 h-12 rounded-full border-2 border-white shadow-sm bg-slate-100 text-slate-600 flex items-center justify-center text-lg font-black uppercase">
                                    {{ strtoupper(substr($trip->user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <h3 class="font-bold text-page-text">{{ $trip->user->name }}</h3>
                                <p class="text-slate-500 text-xs">{{ $trip->user->email }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-page-text text-white text-[10px] font-black uppercase rounded-full tracking-widest">Owner</span>
                    </div>

                    {{-- Members --}}
                    @foreach($trip->sharedUsers as $member)
                        <div class="flex items-center justify-between p-4 rounded-2xl border border-slate-100 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-4">
                                @if($member->avatar)
                                    <img src="{{ asset('storage/' . $member->avatar) }}" class="w-12 h-12 rounded-full border-2 border-white object-cover shadow-sm" title="{{ $member->name }}">
                                @else
                                    <div class="w-12 h-12 rounded-full border-2 border-white shadow-sm bg-slate-100 text-slate-600 flex items-center justify-center text-lg font-black uppercase" title="{{ $member->name }}">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-bold text-page-text">{{ $member->name }}</h3>
                                    <p class="text-slate-500 text-xs">{{ $member->email }}</p>
                                    @if(!$member->pivot->is_accepted)
                                        @php
                                            $inviter = isset($inviters) ? $inviters->get($member->pivot->invited_by) : null;
                                            $inviterName = $inviter ? $inviter->name : ($trip->user->name ?? 'Owner');
                                        @endphp
                                        <p class="text-[10px] text-amber-600 font-bold mt-2 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                            Invited by {{ $inviterName }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="flex flex-col items-end gap-1">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full {{ $member->pivot->is_accepted ? 'bg-emerald-500 text-white' : 'bg-amber-500 text-white' }} text-[10px] font-black uppercase tracking-widest shadow-sm">
                                        {{ $member->pivot->is_accepted ? 'Accepted' : 'Pending' }}
                                    </span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest">Role: {{ $member->pivot->role }}</span>
                                </div>
                                @if(Auth::id() === $trip->user_id)
                                    <form id="remove-member-form-{{ $member->id }}" action="{{ route('trips.members.destroy', [$trip, $member]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="p-2 text-slate-400 hover:text-red-500 transition-colors" @click="removingMemberId = {{ $member->id }}; removingMemberName = '{{ addslashes($member->name) }}'; showRemoveMemberModal = true">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    {{-- Unregistered Guest Invitations --}}
                    @foreach($trip->invitations as $invitation)
                        <div class="flex items-center justify-between p-4 rounded-2xl border border-slate-100 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-4">
                                @php
                                    $username = explode('@', $invitation->email)[0];
                                @endphp
                                <div class="w-12 h-12 rounded-full border-2 border-slate-200 bg-slate-50 flex items-center justify-center text-slate-400">
                                    <span class="text-lg font-black uppercase">{{ strtoupper(substr($username, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-page-text">{{ $username }}</h3>
                                    <p class="text-slate-400 text-xs">{{ $invitation->email }} • Registration Pending</p>
                                    @php
                                        $inviter = isset($inviters) ? $inviters->get($invitation->invited_by) : null;
                                        $inviterName = $inviter ? $inviter->name : ($trip->user->name ?? 'Owner');
                                    @endphp
                                    <p class="text-[10px] text-amber-600 font-bold mt-2 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                        Invited by {{ $inviterName }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="flex flex-col items-end gap-1">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-500 text-white text-[10px] font-black uppercase tracking-widest shadow-sm">Invited</span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest">Role: {{ $invitation->role }}</span>
                                </div>
                                @if($trip->user_id === Auth::id())
                                    <form action="{{ route('trips.invitations.destroy', [$trip, $invitation]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition-colors" onclick="return confirm('Cancel invitation for this email?')">
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