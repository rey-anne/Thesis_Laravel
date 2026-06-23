@extends('layouts.firefighter')
@section('title', 'Heatmap')

@section('content')
<h1 style="color:var(--vf-red);margin-top:0;">Real-Time Heatmap</h1>
<p style="color:var(--vf-muted);">Fire incident density across the monitored area.</p>
<div id="vfHeatmap" class="vf-map" style="height:520px;"></div>
@endsection

@push('scripts')
<script src="{{ asset('assets/heatmap/heatmap.min.js') }}"></script>
<script src="{{ asset('assets/heatmap/leaflet-heatmap.js') }}"></script>
<script src="{{ asset('js/leaflet-map.js') }}"></script>
<script>vfInitHeatmap('vfHeatmap', "{{ route('heatmap.data') }}");</script>
@endpush
