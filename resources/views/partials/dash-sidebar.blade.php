@php
    $links = $role === 'firefighter'
        ? [
            'firefighter.home' => 'Home (Heatmap)',
            'firefighter.reports' => 'Reports',
            'firefighter.profile' => 'My Profile',
          ]
        : [
            'admin.home' => 'Home (Heatmap)',
            'admin.activity' => 'Activity',
            'admin.reports' => 'Reports',
          ];
@endphp

<aside class="vf-dash__sidebar">
    @foreach($links as $routeName => $label)
        <a href="{{ route($routeName) }}" class="{{ request()->routeIs($routeName) ? 'active' : '' }}">{{ $label }}</a>
    @endforeach
</aside>
