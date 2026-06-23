<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'VeriFyre Firefighter')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">

    @yield('styles')
    @stack('styles')
</head>
<body class="vf-admin-body">

<div class="vf-admin-shell">

    @include('partials.firefighter-sidebar')

    <div class="vf-admin-main">

        <header class="vf-admin-topbar">
            <span class="vf-admin-role-label">Firefighter Dashboard</span>

            <div class="vf-admin-topbar__right">
                <form class="vf-admin-search" action="#" onsubmit="return false;">
                    <input type="search" placeholder="Search...">
                </form>
                <button type="button" class="vf-admin-bell" aria-label="Notifications">&#128276;</button>
                <span class="vf-admin-greeting">Hi, {{ explode(' ', auth()->user()->full_name)[0] }}!</span>
            </div>
        </header>

        <main class="vf-admin-content">
            @if (session('status'))
                <div class="vf-admin-flash">{{ session('status') }}</div>
            @endif
            @yield('content')
        </main>

    </div>

</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

@yield('scripts')
@stack('scripts')

</body>
</html>
