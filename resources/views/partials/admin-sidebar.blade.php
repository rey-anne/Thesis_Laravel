@php
    $authUser = auth()->user();

    $links = [
        'admin.home' => 'Dashboard',
    ];

    if ($authUser->hasPermission('manage_users')) {
        $links['admin.users'] = 'User Management';
    }
    if ($authUser->hasPermission('manage_roles_permissions')) {
        $links['admin.roles'] = 'Roles & Permissions';
    }
    if ($authUser->hasPermission('manage_reports')) {
        $links['admin.reports'] = 'Fire Reports';
    }
    if ($authUser->hasPermission('validate_metadata')) {
        $links['admin.metadata'] = 'Metadata Validation';
    }
    if ($authUser->hasPermission('view_heatmap')) {
        $links['admin.heatmap'] = 'Heatmap Monitoring';
    }
    if ($authUser->hasPermission('manage_post_operations')) {
        $links['admin.post-operations'] = 'Post-Operation Records';
    }
    if ($authUser->hasPermission('view_audit_logs')) {
        $links['admin.audit-logs'] = 'Audit Logs';
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
