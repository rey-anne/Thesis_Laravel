<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\FireReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FireReportController extends Controller
{
    public function index()
    {
        $reports = FireReport::orderByDesc('reported_at')->get();

        return view('admin.reports', compact('reports'));
    }

    public function show(FireReport $report)
    {
        return response()->json([
            'id' => $report->id,
            'latitude' => $report->latitude,
            'longitude' => $report->longitude,
            'status' => $report->status,
            'photo_url' => $report->photo_path ? Storage::url($report->photo_path) : null,
            'reported_at' => $report->reported_at?->diffForHumans(),
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
