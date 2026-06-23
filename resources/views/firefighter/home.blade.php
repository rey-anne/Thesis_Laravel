@extends('layouts.app')
@section('title', 'Firefighter Dashboard')

@section('content')
<div class="vf-dash">
    @include('partials.dash-sidebar', ['role' => 'firefighter'])
    <div class="vf-dash__main">
        <h1 style="color:var(--vf-red);margin-top:0;">Real-Time Heatmap</h1>
        <p style="color:var(--vf-muted);">Fire incident density across the monitored area.</p>
        <div id="vfHeatmap" class="vf-map" style="height:520px;"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/leaflet-map.js') }}"></script>
<script>vfInitHeatmap('vfHeatmap');</script>
@endpush
