@extends('layouts.admin')
@section('title', 'User Management')

@section('content')
<h1 style="color:var(--vf-red);margin-top:0;">User Management</h1>

<button type="button" class="vf-btn" style="margin-bottom:18px;" onclick="document.getElementById('vfAddUserForm').style.display='block'">Add User</button>

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
                        <button type="button" onclick="document.getElementById('vfEditUser{{ $user->id }}').style.display='block'">Edit</button>
                        <form method="POST" action="{{ route('admin.users.reset-password', $user) }}" onsubmit="return confirm('Reset password for {{ $user->full_name }}?')">
                            @csrf
                            <button type="submit">Reset</button>
                        </form>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete {{ $user->full_name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </div>
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
                            <label class="vf-label">Role</label>
                            <select class="vf-input" name="role" required>
                                @foreach(['admin' => 'Admin', 'bfp_firefighter' => 'Firefighter', 'superadmin' => 'Superadmin'] as $value => $label)
                                    <option value="{{ $value }}" {{ $user->role === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="vf-label">Account Status</label>
                            <select class="vf-input" name="account_status" required>
                                @foreach(['pending' => 'Pending', 'active' => 'Active', 'suspended' => 'Suspended', 'revoked' => 'Revoked'] as $value => $label)
                                    <option value="{{ $value }}" {{ $user->account_status === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="vf-btn">Save</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top:18px;">{{ $users->links() }}</div>
@endsection
