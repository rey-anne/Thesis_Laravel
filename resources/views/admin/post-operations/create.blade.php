@extends('layouts.admin')
@section('title', 'Add Post-Operation Record')

@section('content')
<h1 style="color:var(--vf-red);margin-top:0;">Add Post-Operation Record</h1>

@if($errors->any())
    <div class="vf-error">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('admin.post-operations.store') }}" enctype="multipart/form-data" class="vf-card">
    @csrf

    <label class="vf-label">Fire Report</label>
    <select class="vf-input" name="fire_report_id" required>
        @foreach($fireReports as $fireReport)
            <option value="{{ $fireReport->id }}">#{{ $fireReport->id }} &middot; {{ $fireReport->reported_at?->format('M j, Y g:i A') }}</option>
        @endforeach
    </select>

    <label class="vf-label">Personnel Name</label>
    <input class="vf-input" type="text" name="personnel_name" value="{{ auth()->user()->full_name }}" required>

    <label class="vf-label">ID Number</label>
    <input class="vf-input" type="text" name="id_number">

    <label class="vf-label">Incident Summary</label>
    <textarea class="vf-input" name="incident_summary" rows="3" required></textarea>

    <label class="vf-label">Action Taken</label>
    <textarea class="vf-input" name="action_taken" rows="3" required></textarea>

    <label class="vf-label">Extinguished At</label>
    <input class="vf-input" type="datetime-local" name="extinguished_at">

    <label class="vf-label">Remarks</label>
    <textarea class="vf-input" name="remarks" rows="2"></textarea>

    <label class="vf-label">Report File (optional)</label>
    <input class="vf-input" type="file" name="report_file">

    <button type="submit" class="vf-btn">Save Record</button>
</form>
@endsection
