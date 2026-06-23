@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="vf-dash">
    @include('partials.dash-sidebar', ['role' => 'firefighter'])
    <div class="vf-dash__main" style="max-width:640px;">
        <h1 style="color:var(--vf-red);margin-top:0;">My Profile</h1>

        <div class="vf-card" style="margin-bottom:20px;">
            <h3 style="margin-top:0;">Editable by you</h3>
            <form>
                <label class="vf-label">Profile Photo</label>
                <input type="file" class="vf-input">

                <label class="vf-label">Full Name</label>
                <input type="text" class="vf-input" value="Juan Dela Cruz">

                <label class="vf-label">BFP ID Number</label>
                <input type="text" class="vf-input" value="BFP-2024-00123">

                <label class="vf-label">Email</label>
                <input type="email" class="vf-input" value="juandelacruz@example.com">

                <label class="vf-label">Official Email</label>
                <input type="email" class="vf-input" value="j.delacruz@bfp.gov.ph">

                <label class="vf-label">Official Contact Number</label>
                <input type="text" class="vf-input" value="0917 000 0000">

                <label class="vf-label">Duty Status</label>
                <select class="vf-input">
                    <option>On Duty</option>
                    <option>Off Duty</option>
                    <option>On Call</option>
                </select>

                <button type="submit" class="vf-btn">Save Changes</button>
            </form>
        </div>

        <div class="vf-card" style="margin-bottom:20px;background:var(--vf-red-light);">
            <h3 style="margin-top:0;color:var(--vf-red);">Set by Admin (view only)</h3>
            <p><strong>Rank:</strong> Fire Officer 1</p>
            <p><strong>Unit/Division:</strong> Rescue Unit</p>
            <p><strong>Assigned Fire Station:</strong> Manila Fire District HQ</p>
        </div>

        <div class="vf-card">
            <h3 style="margin-top:0;">System Information</h3>
            <p><strong>Account Status:</strong> Active</p>
            <p><strong>Last Log In:</strong> June 21, 2026, 9:42 AM</p>
            <p><strong>Date Registered:</strong> March 3, 2026</p>
        </div>
    </div>
</div>
@endsection
