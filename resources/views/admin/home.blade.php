@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<h1 style="color:var(--vf-red);margin-top:0;">Dashboard</h1>
<p style="color:var(--vf-muted);">Overview of system activity.</p>

<div class="vf-admin-stats">
    <div class="vf-admin-stat-card">
        <strong>{{ $stats['total_reports'] }}</strong>
        <span>Total Fire Reports</span>
    </div>
    <div class="vf-admin-stat-card">
        <strong>{{ $stats['active_fires'] }}</strong>
        <span>Active Fires</span>
    </div>
    @if(auth()->user()->role === 'superadmin')
        <div class="vf-admin-stat-card">
            <strong>{{ $stats['total_users'] }}</strong>
            <span>Total Users</span>
        </div>
        <div class="vf-admin-stat-card">
            <strong>{{ $stats['pending_approvals'] }}</strong>
            <span>Pending Approvals</span>
        </div>
    @endif
</div>

<div class="vf-card">
    <h3 style="margin-top:0;color:var(--vf-red);">Recent Activity</h3>
    @if($recentActivity->isEmpty())
        <p style="color:var(--vf-muted);">No activity yet.</p>
    @else
        <div class="vf-report-list">
            @foreach($recentActivity as $log)
                <div class="vf-report-item" style="cursor:default;">
                    <div style="flex:1;">
                        <strong>{{ $log->description ?? $log->action }}</strong>
                        <p style="margin:2px 0;color:var(--vf-muted);font-size:13px;">
                            {{ $log->user?->full_name ?? 'System' }} &middot; {{ $log->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
