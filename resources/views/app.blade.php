<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
           {{-- SEO Meta Tags --}}
    <!-- <title>@yield('title', 'Auditoría 2025 - Congreso Nacional de Auditores')</title> -->
    <meta name="description" content="@yield('description', 'Congreso Nacional de Auditoría 2025. Registro oficial de auditores, contadores públicos y profesionales del control interno.')">
    <meta name="keywords" content="@yield('keywords', 'auditoría, auditores, congreso, CPA, control interno, auditoría financiera, auditoría gubernamental, 2025')">
    <meta name="author" content="Colegio de Contadores Públicos">

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Inline style to set the HTML background color based on our theme in app.css --}}
        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>

        {{-- <title inertia>{{ config('app.name', 'audita2025') }}</title> --}}
        <title>Audita 2025 - Puno</title>

        <link rel="icon" href="/images/logo1.png" sizes="any">
        <link rel="icon" href="/images/logo1.png" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/images/logo1.png">
            <link rel="icon" type="image/png" href="{{ asset('images/logo1.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo1.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo1.png') }}">
   <meta name="description" content="@yield('description', 'Congreso Nacional de Auditoría 2025. Registro oficial de auditores, contadores públicos y profesionales del control interno.')">
    <meta name="keywords" content="@yield('keywords', 'auditoría, auditores, congreso, CPA, control interno, auditoría financiera, auditoría gubernamental, 2025')">
    <meta name="author" content="Colegio de Contadores Públicos">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @routes
        @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
