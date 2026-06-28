@extends('layouts.admin')
@section('title', 'User Management')

@section('content')
<h1 style="color:var(--vf-red);margin-top:0;">User Management</h1>

<button type="button" class="vf-btn" style="margin-bottom:18px;" onclick="vfToggleRow('vfAddUserForm')">Add User</button>

<div id="vfAddUserForm" class="vf-card" style="display:none;margin-bottom:24px;">
    <h3 style="margin-top:0;color:var(--vf-red);">Add User</h3>
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <label class="vf-label">Full Name</label>
        <input class="vf-input" type="text" name="full_name" required>

        <label class="vf-label">Email</label>
        <input class="vf-input" type="email" name="email" required>

        <label class="vf-label">Contact Number</label>
        <input class="vf-input" type="text" name="contact_number" required>

        <label class="vf-label">Role</label>
        <select class="vf-input" name="role" required>
            <option value="admin">Admin</option>
            <option value="bfp_firefighter">Firefighter</option>
            <option value="superadmin">Superadmin</option>
        </select>

        <label class="vf-label">Temporary Password</label>
        <input class="vf-input" type="text" name="password" required minlength="8">

        <button type="submit" class="vf-btn">Create User</button>
    </form>
</div>

@if($errors->any())
    <div class="vf-error">{{ $errors->first() }}</div>
@endif

<table class="vf-admin-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>ID</th>
            <th>Rank</th>
            <th>Account Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->full_name }}</td>
                <td>{{ $user->id }}</td>
                <td>{{ $user->adminProfile->rank ?? $user->firefighterProfile->rank ?? '—' }}</td>
                <td>
                    <span class="{{ $user->account_status === 'active' ? 'vf-status--verified' : 'vf-status--unverified' }}">
                        {{ $user->account_status === 'active' ? 'Verified' : ucfirst($user->account_status) }}
                    </span>
                </td>
                <td>
                    <div class="vf-admin-table__actions">
                        <button type="button" class="vf-icon-btn vf-icon-btn--role" title="Change role"
                            onclick="vfToggleRow('vfRoleUser{{ $user->id }}')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="15" r="3.5"/><path d="M10.5 12.5L18 5"/><path d="M15.5 7.5l2 2"/><path d="M13 10l2 2"/></svg>
                        </button>
                        <button type="button" class="vf-icon-btn vf-icon-btn--edit" title="Edit information"
                            onclick="vfToggleRow('vfEditUser{{ $user->id }}')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20h4l11-11-4-4L4 16v4z"/><path d="M14.5 5.5l4 4"/></svg>
                        </button>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete {{ $user->full_name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="vf-icon-btn vf-icon-btn--delete" title="Delete user">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M6 7l1 13a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1l1-13"/><path d="M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <tr id="vfRoleUser{{ $user->id }}" style="display:none;">
                <td colspan="5">
                    <form method="POST" action="{{ route('admin.users.update-role', $user) }}" style="display:flex;gap:10px;align-items:flex-end;">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="vf-label">Role for {{ $user->full_name }}</label>
                            <select class="vf-input" name="role" required>
                                @foreach(['admin' => 'Admin', 'bfp_firefighter' => 'Firefighter', 'superadmin' => 'Superadmin'] as $value => $label)
                                    <option value="{{ $value }}" {{ $user->role === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="vf-btn">Save Role</button>
                    </form>
                </td>
            </tr>
            <tr id="vfEditUser{{ $user->id }}" style="display:none;">
                <td colspan="5">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}" style="display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end;">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="vf-label">Full Name</label>
                            <input class="vf-input" type="text" name="full_name" value="{{ $user->full_name }}" required>
                        </div>
                        <div>
                            <label class="vf-label">Email</label>
                            <input class="vf-input" type="email" name="email" value="{{ $user->email }}" required>
                        </div>
                        <div>
                            <label class="vf-label">Contact Number</label>
                            <input class="vf-input" type="text" name="contact_number" value="{{ $user->contact_number }}" required>
                        </div>
                        <div>
                            <label class="vf-label">Account Status</label>
                            <select class="vf-input" name="account_status" required>
                                @foreach(['pending' => 'Pending', 'active' => 'Active', 'suspended' => 'Suspended', 'revoked' => 'Revoked'] as $value => $label)
                                    <option value="{{ $value }}" {{ $user->account_status === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if($user->role === 'admin')
                            <div style="flex-basis:100%;border-top:1px dashed var(--vf-line);margin:8px 0;"></div>
                            <div>
                                <label class="vf-label">ID Number</label>
                                <input class="vf-input" type="text" name="id_number" value="{{ $user->adminProfile?->id_number }}">
                            </div>
                            <div>
                                <label class="vf-label">Rank</label>
                                <input class="vf-input" type="text" name="rank" value="{{ $user->adminProfile?->rank }}">
                            </div>
                            <div>
                                <label class="vf-label">Command Level</label>
                                <input class="vf-input" type="text" name="command_level" value="{{ $user->adminProfile?->command_level }}">
                            </div>
                            <div>
                                <label class="vf-label">Unit / Division Handled</label>
                                <input class="vf-input" type="text" name="unit_division_handled" value="{{ $user->adminProfile?->unit_division_handled }}">
                            </div>
                            <div>
                                <label class="vf-label">Area of Jurisdiction</label>
                                <input class="vf-input" type="text" name="area_of_jurisdiction" value="{{ $user->adminProfile?->area_of_jurisdiction }}">
                            </div>
                            <div>
                                <label class="vf-label">Assigned Fire Station ID</label>
                                <input class="vf-input" type="number" name="assigned_fire_station_id" value="{{ $user->adminProfile?->assigned_fire_station_id }}">
                            </div>
                            <div>
                                <label class="vf-label">Official Email</label>
                                <input class="vf-input" type="email" name="official_email" value="{{ $user->adminProfile?->official_email }}">
                            </div>
                            <div>
                                <label class="vf-label">Official Contact Number</label>
                                <input class="vf-input" type="text" name="official_contact_number" value="{{ $user->adminProfile?->official_contact_number }}">
                            </div>
                            <div style="flex-basis:100%;">
                                <label class="vf-label">Managed Units</label>
                                <input class="vf-input" type="text" name="managed_units" value="{{ $user->adminProfile?->managed_units }}">
                            </div>
                        @elseif($user->role === 'bfp_firefighter')
                            <div style="flex-basis:100%;border-top:1px dashed var(--vf-line);margin:8px 0;"></div>
                            <div>
                                <label class="vf-label">BFP ID Number</label>
                                <input class="vf-input" type="text" name="bfp_id_number" value="{{ $user->firefighterProfile?->bfp_id_number }}">
                            </div>
                            <div>
                                <label class="vf-label">Rank</label>
                                <input class="vf-input" type="text" name="rank" value="{{ $user->firefighterProfile?->rank }}">
                            </div>
                            <div>
                                <label class="vf-label">Duty Status</label>
                                <input class="vf-input" type="text" name="duty_status" value="{{ $user->firefighterProfile?->duty_status }}">
                            </div>
                            <div>
                                <label class="vf-label">Unit / Division</label>
                                <input class="vf-input" type="text" name="unit_division" value="{{ $user->firefighterProfile?->unit_division }}">
                            </div>
                            <div>
                                <label class="vf-label">Assigned Fire Station ID</label>
                                <input class="vf-input" type="number" name="assigned_fire_station_id" value="{{ $user->firefighterProfile?->assigned_fire_station_id }}">
                            </div>
                            <div>
                                <label class="vf-label">Official Email</label>
                                <input class="vf-input" type="email" name="official_email" value="{{ $user->firefighterProfile?->official_email }}">
                            </div>
                            <div>
                                <label class="vf-label">Official Contact Number</label>
                                <input class="vf-input" type="text" name="official_contact_number" value="{{ $user->firefighterProfile?->official_contact_number }}">
                            </div>
                        @endif

                        <button type="submit" class="vf-btn">Save</button>
                    </form>
                    <form method="POST" action="{{ route('admin.users.reset-password', $user) }}" style="margin-top:10px;" onsubmit="return confirm('Reset password for {{ $user->full_name }}?')">
                        @csrf
                        <button type="submit" class="vf-btn vf-btn--outline">Reset Password</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top:18px;">{{ $users->links() }}</div>

<script>
function vfToggleRow(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.style.display = (el.style.display === 'block') ? 'none' : 'block';
}
</script>
@endsection
