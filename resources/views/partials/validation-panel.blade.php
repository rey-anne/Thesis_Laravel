@php
    $results = $results ?? ['location' => 'warning', 'timestamp' => 'warning', 'metadata' => 'warning'];
@endphp
<div class="vf-validation-panel">
    <div class="vf-validation-item">
        <span class="vf-validation-icon vf-validation-icon--{{ $results['location'] }}" title="{{ ucfirst($results['location']) }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-7-6.2-7-11a7 7 0 1 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
        </span>
        <span class="vf-validation-label">Reporter's Location</span>
    </div>
    <div class="vf-validation-item">
        <span class="vf-validation-icon vf-validation-icon--{{ $results['timestamp'] }}" title="{{ ucfirst($results['timestamp']) }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></svg>
        </span>
        <span class="vf-validation-label">Date and Time Submitted</span>
    </div>
    <div class="vf-validation-item">
        <span class="vf-validation-icon vf-validation-icon--{{ $results['metadata'] }}" title="{{ ucfirst($results['metadata']) }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h3l1.5-2h7L17 7h3a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1z"/><circle cx="12" cy="13" r="3.5"/></svg>
        </span>
        <span class="vf-validation-label">Image's Metadata</span>
    </div>
</div>
