@php
    $links = [
        'firefighter.home' => 'Home',
        'firefighter.heatmap' => 'Heatmap',
        'firefighter.profile' => 'My Profile',
        'education' => 'Education',
        'cybersecurity' => 'Cybersecurity',
        'about' => 'About Us',
    ];
@endphp

<aside class="vf-admin-sidebar">
    <a href="{{ route('firefighter.home') }}" class="vf-admin-sidebar__brand">VeriFyre</a>

    <nav class="vf-admin-sidebar__nav">
        @foreach($links as $routeName => $label)
            <a href="{{ route($routeName) }}" class="{{ request()->routeIs($routeName) ? 'active' : '' }}">{{ $label }}</a>
        @endforeach
    </nav>

    <form method="POST" action="{{ route('logout') }}" class="vf-admin-sidebar__logout">
        @csrf
        <button type="submit">Logout</button>
    </form>
</aside>
