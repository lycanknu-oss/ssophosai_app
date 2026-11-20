<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('dist/img/logo_moph.png') }}" />
    <title>@yield('title', 'สำนักงานสาธารณสุขอำเภอโพธิ์ไทร')</title>

    {{-- Lucide Icons --}}
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.577.0/dist/umd/lucide.min.js" defer></script>

    {{-- Font Awesome 6 Free CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Vite Assets (public/dist) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'], 'dist')

    @stack('styles')
</head>
<body class="selection:bg-[#168d83] selection:text-white">

    {{-- Header, Banner & Navbar --}}
    @include('partials.header')

    {{-- Main Content --}}
    <main class="phs-container pt-[30px]">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    @stack('scripts')
</body>
</html>
