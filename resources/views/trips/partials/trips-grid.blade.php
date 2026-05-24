{{-- Trips Grid (AJAX-updatable) --}}
    <div id="trips-grid-shell" class="relative">
        <div id="trips-grid-loading" class="hidden absolute inset-0 z-10 rounded-3xl bg-white/80 backdrop-blur-sm p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm animate-pulse">
                    <div class="h-40 bg-slate-200 rounded-md mb-4"></div>
                    <div class="h-4 bg-slate-200 rounded w-3/4 mb-2"></div>
                    <div class="h-3 bg-slate-200 rounded w-1/2"></div>
                </div>
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm animate-pulse">
                    <div class="h-40 bg-slate-200 rounded-md mb-4"></div>
                    <div class="h-4 bg-slate-200 rounded w-3/4 mb-2"></div>
                    <div class="h-3 bg-slate-200 rounded w-1/2"></div>
                </div>
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm animate-pulse hidden lg:block">
                    <div class="h-40 bg-slate-200 rounded-md mb-4"></div>
                    <div class="h-4 bg-slate-200 rounded w-3/4 mb-2"></div>
                    <div class="h-3 bg-slate-200 rounded w-1/2"></div>
                </div>
            </div>
        </div>
        <div id="trips-grid-container">
            @include('trips.skelton._grid', ['trips' => $trips, 'hasAnyTrips' => $hasAnyTrips ?? null])
        </div>
    </div>