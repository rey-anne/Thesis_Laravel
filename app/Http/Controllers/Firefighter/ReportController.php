<?php

namespace App\Http\Controllers\Firefighter;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\FireReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function show(FireReport $report)
    {
        return response()->json([
            'id' => $report->id,
            'latitude' => $report->latitude,
            'longitude' => $report->longitude,
            'status' => $report->status,
            'photo_url' => $report->photo_path ? Storage::url($report->photo_path) : null,
            'reported_at' => $report->reported_at?->diffForHumans(),
            'validation' => $report->validationSummary(),
        ]);
    }

    public function updateStatus(Request $request, FireReport $report)
    {
        $data = $request->validate([
            'status' => 'required|in:active,extinguished',
        ]);

        $report->update([
            'status' => $data['status'],
            'extinguished_at' => $data['status'] === 'extinguished' ? now() : null,
        ]);

        ActivityLog::record('fire_report_status_updated', "Fire report #{$report->id} marked {$data['status']}");

        return back()->with('status', 'Report status updated.');
    }
}
