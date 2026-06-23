@extends('layouts.app')
@section('title', 'Report Submitted')

@section('content')
<div id="vfAutoDial911"></div>

<section class="vf-success-wrap">
    <div class="vf-success-icon">&#10003;</div>
    <h1 style="color:var(--vf-red);">Successfully submitted report</h1>
    <p>Your report has been received. It is currently being handled by the Bureau of Fire Protection, and our team has been notified of your exact location.</p>
    <p>We're now connecting you to 911 so emergency responders can act immediately. Please stay safe and, if possible, move to a clear area away from the fire.</p>
    <a href="{{ route('home') }}" class="vf-btn vf-btn--outline">Back to Home</a>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/camera-report.js') }}"></script>
@endpush
