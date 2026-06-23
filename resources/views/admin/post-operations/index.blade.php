@extends('layouts.admin')
@section('title', 'Post-Operation Records')

@section('content')
<h1 style="color:var(--vf-red);margin-top:0;">Post-Operation Records</h1>

<a href="{{ route('admin.post-operations.create') }}" class="vf-btn" style="margin-bottom:18px;display:inline-block;">Add Record</a>

<table class="vf-admin-table">
    <thead>
        <tr>
            <th>Fire Report</th>
            <th>Personnel</th>
            <th>Summary</th>
            <th>Extinguished</th>
            <th>Filed</th>
        </tr>
    </thead>
    <tbody>
        @forelse($postOperations as $postOp)
            <tr>
                <td>#{{ $postOp->fire_report_id }}</td>
                <td>{{ $postOp->personnel_name }}</td>
                <td>{{ \Illuminate\Support\Str::limit($postOp->incident_summary, 60) }}</td>
                <td>{{ $postOp->extinguished_at?->format('M j, Y g:i A') ?? '—' }}</td>
                <td>{{ $postOp->created_at->diffForHumans() }}</td>
            </tr>
        @empty
            <tr><td colspan="5">No post-operation records yet.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:18px;">{{ $postOperations->links() }}</div>
@endsection
