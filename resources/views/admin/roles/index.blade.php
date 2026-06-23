@extends('layouts.admin')
@section('title', 'Roles & Permissions')

@section('content')
<h1 style="color:var(--vf-red);margin-top:0;">Roles & Permissions</h1>
<p style="color:var(--vf-muted);">Superadmin always has full access. Choose which modules the Admin role can reach.</p>

<form method="POST" action="{{ route('admin.roles.update') }}">
    @csrf
    <table class="vf-admin-table">
        <thead>
            <tr>
                <th>Permission</th>
                <th>Admin</th>
                <th>Superadmin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permissions as $permission)
                <tr>
                    <td>{{ $permission->label }}</td>
                    <td>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                            {{ in_array($permission->id, $adminPermissionIds) ? 'checked' : '' }}>
                    </td>
                    <td><input type="checkbox" checked disabled></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button type="submit" class="vf-btn" style="margin-top:18px;">Save Permissions</button>
</form>
@endsection
