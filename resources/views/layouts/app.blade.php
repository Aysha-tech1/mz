<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'محمود الدرعي - خبير التجارة الإلكترونية' }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak]{display:none !important}</style>
</head>
<body class="antialiased bg-canvas text-primary selection:bg-accent selection:text-primary">
    <div id="app" class="min-h-screen flex flex-col">
        @include('partials.header')

        <main id="main" class="flex-1">
            @yield('content')
        </main>

        @include('partials.footer')
    </div>
    @include('partials.file-email-modal')
</body>
</html>
