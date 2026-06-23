@php
    $isSuperadmin = auth()->user()->role === 'superadmin';

    $links = [
        'admin.home' => 'Dashboard',
    ];

    if ($isSuperadmin) {
        $links['admin.users'] = 'User Management';
        $links['admin.roles'] = 'Roles & Permissions';
    }

    $links['admin.reports'] = 'Fire Reports';
    $links['admin.metadata'] = 'Metadata Validation';
    $links['admin.heatmap'] = 'Heatmap Monitoring';
    $links['admin.post-operations'] = 'Post-Operation Records';

    if ($isSuperadmin) {
        $links['admin.audit-logs'] = 'Audit Logs';
        $links['admin.settings'] = 'System Settings';
    }

    $links['admin.profile'] = 'My Profile';
@endphp

<aside class="vf-admin-sidebar">
    <a href="{{ route('admin.home') }}" class="vf-admin-sidebar__brand">VeriFyre</a>

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
