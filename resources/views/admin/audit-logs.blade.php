@extends('layouts.admin')
@section('title', 'Audit Logs')

@section('content')
<h1 style="color:var(--vf-red);margin-top:0;">Audit Logs</h1>
<p style="color:var(--vf-muted);">Login, edit, verification, and system change history.</p>

<table class="vf-admin-table">
    <thead>
        <tr>
            <th>User</th>
            <th>Action</th>
            <th>Description</th>
            <th>IP Address</th>
            <th>When</th>
        </tr>
    </thead>
    <tbody>
        @forelse($logs as $log)
            <tr>
                <td>{{ $log->user?->full_name ?? 'System' }}</td>
                <td>{{ $log->action }}</td>
                <td>{{ $log->description }}</td>
                <td>{{ $log->ip_address }}</td>
                <td>{{ $log->created_at->format('M j, Y g:i A') }}</td>
            </tr>
        @empty
            <tr><td colspan="5">No activity recorded yet.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:18px;">{{ $logs->links() }}</div>
@endsection
