@extends('layouts.admin')
@section('title', 'My Profile')

@section('content')
<h1 style="color:var(--vf-red);margin-top:0;">My Profile</h1>

@if($errors->any())
    <div class="vf-error">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('admin.profile.update') }}" class="vf-card" style="max-width:560px;">
    @csrf
    @method('PUT')

    <label class="vf-label">Full Name</label>
    <input class="vf-input" type="text" name="full_name" value="{{ $user->full_name }}" required>

    <label class="vf-label">Email</label>
    <input class="vf-input" type="email" name="email" value="{{ $user->email }}" required>

    <label class="vf-label">Contact Number</label>
    <input class="vf-input" type="text" name="contact_number" value="{{ $user->contact_number }}" required>

    <label class="vf-label">New Password (leave blank to keep current)</label>
    <input class="vf-input" type="password" name="password" minlength="8">

    <label class="vf-label">Rank</label>
    <input class="vf-input" type="text" name="rank" value="{{ $profile->rank }}">

    <label class="vf-label">Command Level</label>
    <input class="vf-input" type="text" name="command_level" value="{{ $profile->command_level }}">

    <label class="vf-label">Unit/Division Handled</label>
    <input class="vf-input" type="text" name="unit_division_handled" value="{{ $profile->unit_division_handled }}">

    <label class="vf-label">Area of Jurisdiction</label>
    <input class="vf-input" type="text" name="area_of_jurisdiction" value="{{ $profile->area_of_jurisdiction }}">

    <label class="vf-label">Official Email</label>
    <input class="vf-input" type="email" name="official_email" value="{{ $profile->official_email }}">

    <label class="vf-label">Official Contact Number</label>
    <input class="vf-input" type="text" name="official_contact_number" value="{{ $profile->official_contact_number }}">

    <button type="submit" class="vf-btn">Save Profile</button>
</form>
@endsection
