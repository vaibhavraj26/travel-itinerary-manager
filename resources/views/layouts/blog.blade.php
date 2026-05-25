<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - {{ config('app.name', 'TripTogether') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#FFF8F3] text-[#071022]">
    <div class="min-h-screen flex flex-col overflow-x-hidden font-['Sora',sans-serif]">

        <x-blog-topbar />

        <main class="flex-1">
            @yield('content')
        </main>

        <x-footer />
    </div>

    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.15 });

        document.querySelectorAll('.reveal').forEach((element) => observer.observe(element));
    </script>

    <x-toaster />
</body>
</html>
