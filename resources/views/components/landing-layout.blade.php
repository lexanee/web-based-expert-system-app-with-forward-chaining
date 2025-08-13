<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased h-full">
    <div
        class="min-h-full {{ request()->routeIs('diagnosis.*') || request()->routeIs('lapor.*') || str_contains(request()->url(), 'lapor') || str_contains(request()->url(), 'diagnosis') ? 'bg-slate-800 min-h-screen' : 'bg-white' }}">
        <!-- Header -->
        @unless (request()->routeIs('diagnosis.*') ||
                request()->routeIs('lapor.*') ||
                str_contains(request()->url(), 'lapor') ||
                str_contains(request()->url(), 'diagnosis'))
            @include('landing.partials.header')
        @endunless

        <!-- Page Content -->
        <main
            {{ request()->routeIs('diagnosis.*') || request()->routeIs('lapor.*') || str_contains(request()->url(), 'lapor') || str_contains(request()->url(), 'diagnosis') ? 'class=min-h-screen flex items-center justify-center py-8' : '' }}>
            {{ $slot }}
        </main>

        <!-- Footer -->
        @unless (request()->routeIs('diagnosis.*') ||
                request()->routeIs('lapor.*') ||
                str_contains(request()->url(), 'lapor') ||
                str_contains(request()->url(), 'diagnosis'))
            @include('landing.partials.footer')
        @endunless
    </div>
</body>

</html>
