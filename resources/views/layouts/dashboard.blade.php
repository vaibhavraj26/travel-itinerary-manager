<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'TripTogether') }} - Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#F8F9FB] text-slate-800 font-sans antialiased" 
      x-data="{ 
          sidebarOpen: localStorage.getItem('sidebarOpen') !== null 
              ? localStorage.getItem('sidebarOpen') === 'true' 
              : window.innerWidth >= 1024 
      }" 
      x-init="$watch('sidebarOpen', value => localStorage.setItem('sidebarOpen', value))">

    <!-- Mobile sidebar backdrop -->
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-20 bg-slate-900/50 lg:hidden backdrop-blur-sm" @click="sidebarOpen = false"></div>

    <!-- App Shell: sidebar + main side-by-side -->
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content wrapper -->
        <div class="flex-1 flex flex-col min-h-screen overflow-hidden">
        
        <!-- Top Navbar -->
        @include('partials.topbar')

        <!-- Main Dashboard Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#F8F9FB] p-4 sm:p-6 lg:p-8">

            @yield('content')
        </main>

        </div>{{-- end: main content wrapper --}}

    </div>{{-- end: flex shell --}}

    <x-toaster />

</body>
</html>
