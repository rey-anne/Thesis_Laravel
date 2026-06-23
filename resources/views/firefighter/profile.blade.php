@extends('layouts.firefighter')
@section('title', 'My Profile')

@section('content')
<h1 style="color:var(--vf-red);margin-top:0;">My Profile</h1>

@if($errors->any())
    <div class="vf-error">{{ $errors->first() }}</div>
@endif

<div style="max-width:640px;">
    <div class="vf-card" style="margin-bottom:20px;">
        <h3 style="margin-top:0;">Editable by you</h3>
        <form method="POST" action="{{ route('firefighter.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label class="vf-label">Profile Photo</label>
            @if($user->profile_photo_path)
                <img src="{{ \Illuminate\Support\Facades\Storage::url($user->profile_photo_path) }}" alt="Profile photo" style="width:64px;height:64px;border-radius:50%;object-fit:cover;display:block;margin-bottom:8px;">
            @endif
            <input type="file" name="profile_photo" class="vf-input" accept="image/*">

            <label class="vf-label">Full Name</label>
            <input type="text" name="full_name" class="vf-input" value="{{ old('full_name', $user->full_name) }}" required>

            <label class="vf-label">BFP ID Number</label>
            <input type="text" name="bfp_id_number" class="vf-input" value="{{ old('bfp_id_number', $profile->bfp_id_number) }}">

            <label class="vf-label">Email</label>
            <input type="email" name="email" class="vf-input" value="{{ old('email', $user->email) }}" required>

            <label class="vf-label">Official Email</label>
            <input type="email" name="official_email" class="vf-input" value="{{ old('official_email', $profile->official_email) }}">

            <label class="vf-label">Contact Number</label>
            <input type="text" name="contact_number" class="vf-input" value="{{ old('contact_number', $user->contact_number) }}" required>

            <label class="vf-label">Official Contact Number</label>
            <input type="text" name="official_contact_number" class="vf-input" value="{{ old('official_contact_number', $profile->official_contact_number) }}">

            <label class="vf-label">New Password (leave blank to keep current)</label>
            <input type="password" name="password" class="vf-input" minlength="8">

            <label class="vf-label">Duty Status</label>
            <select name="duty_status" class="vf-input">
                @foreach(['On Duty', 'Off Duty', 'On Call'] as $status)
                    <option value="{{ $status }}" {{ $profile->duty_status === $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>

            <button type="submit" class="vf-btn">Save Changes</button>
        </form>
    </div>

    <div class="vf-card" style="margin-bottom:20px;background:var(--vf-red-light);">
        <h3 style="margin-top:0;color:var(--vf-red);">Set by Admin (view only)</h3>
        <p><strong>Rank:</strong> {{ $profile->rank ?? 'Not yet set' }}</p>
        <p><strong>Unit/Division:</strong> {{ $profile->unit_division ?? 'Not yet assigned' }}</p>
        <p><strong>Assigned Fire Station:</strong> {{ $profile->assigned_fire_station_id ? "Station #{$profile->assigned_fire_station_id}" : 'Not yet assigned' }}</p>
    </div>

    <div class="vf-card">
        <h3 style="margin-top:0;">System Information</h3>
        <p><strong>Account Status:</strong> {{ ucfirst($user->account_status) }}</p>
        <p><strong>Last Log In:</strong> {{ $user->last_login_at?->format('F j, Y, g:i A') ?? 'Never' }}</p>
        <p><strong>Date Registered:</strong> {{ $user->date_registered?->format('F j, Y') ?? $user->created_at->format('F j, Y') }}</p>
    </div>
</div>
@endsection
