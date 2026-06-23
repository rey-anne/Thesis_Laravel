<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\FireReport;
use Illuminate\Http\Request;

class MetadataController extends Controller
{
    public function index()
    {
        $reports = FireReport::orderByDesc('reported_at')->paginate(20);

        return view('admin.metadata', compact('reports'));
    }

    public function validateMetadata(Request $request, FireReport $report)
    {
        $data = $request->validate([
            'decision' => 'required|in:validated,rejected',
        ]);

        $report->update([
            'verified_by_crowdsourcing' => $data['decision'] === 'validated',
            'status' => $data['decision'] === 'rejected' ? 'rejected' : $report->status,
        ]);

        ActivityLog::record('metadata_validated', "Fire report #{$report->id} metadata marked {$data['decision']}");

        return back()->with('status', 'Metadata validation saved.');
    }
}
