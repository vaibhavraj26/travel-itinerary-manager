{{-- Search and Filter --}}
        <form method="GET" action="{{ route('trips.index') }}" x-data="{ search: @json(request('search')), timer: null }" x-ref="form" class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4 items-center">
            <div class="relative flex-1 w-full">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                  <input name="search" x-model="search"
                       @input="clearTimeout(timer); timer = setTimeout(() => { tripsSubmitForm($refs.form); }, 500)"
                       @keyup="clearTimeout(timer); timer = setTimeout(() => { tripsSubmitForm($refs.form); }, 500)"
                      @keydown.enter.prevent="tripsSubmitForm($refs.form)"
                       oninput="(function(f){ clearTimeout(window.__tripSearchTimer); window.__tripSearchTimer = setTimeout(function(){ try { window.tripsSubmitForm(f); } catch(e){} }, 500); })(this.form)"
                       onkeyup="(function(f){ clearTimeout(window.__tripSearchTimer); window.__tripSearchTimer = setTimeout(function(){ try { window.tripsSubmitForm(f); } catch(e){} }, 500); })(this.form)"
                      type="text" placeholder="Search destinations or trip names..." class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border-transparent rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-[#FF52A7] transition-all outline-none">
            </div>
            <div class="flex items-center gap-2 w-full md:w-auto">
                <select name="status" @change="tripsSubmitForm($refs.form)" onchange="(function(f){ try { window.tripsSubmitForm(f); } catch(e){} })(this.form)" class="bg-slate-50 border-transparent rounded-xl text-sm py-2.5 px-4 focus:ring-2 focus:ring-[#FF52A7] transition-all outline-none text-slate-600">
                    <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
                <select name="sort" @change="tripsSubmitForm($refs.form)" onchange="(function(f){ try { window.tripsSubmitForm(f); } catch(e){} })(this.form)" class="bg-slate-50 border-transparent rounded-xl text-sm py-2.5 px-4 focus:ring-2 focus:ring-[#FF52A7] transition-all outline-none text-slate-600">
                    <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Newest First</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    <option value="date" {{ request('sort') === 'date' ? 'selected' : '' }}>By Date</option>
                </select>
            </div>
        </form>