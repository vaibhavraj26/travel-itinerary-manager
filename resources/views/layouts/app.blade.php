<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'TripTogether') }} - Travel Itinerary Manager</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
    
</head>
<body>
    @if(!request()->routeIs('login') && !request()->routeIs('register'))
        <x-data-warning />
    @endif
 
    @yield('content')
    
    @if(!request()->routeIs('login') && !request()->routeIs('register'))
        <x-footer /> 
    @endif

    <x-toaster />
</body>
</html> 