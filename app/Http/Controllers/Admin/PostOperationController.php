<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\FireReport;
use App\Models\PostOperation;
use Illuminate\Http\Request;

class PostOperationController extends Controller
{
    public function index()
    {
        $postOperations = PostOperation::with(['fireReport', 'personnel'])->latest()->paginate(20);

        return view('admin.post-operations.index', compact('postOperations'));
    }

    public function create()
    {
        $fireReports = FireReport::orderByDesc('reported_at')->get();

        return view('admin.post-operations.create', compact('fireReports'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fire_report_id' => 'required|exists:fire_reports,id',
            'personnel_name' => 'required|string|max:150',
            'id_number' => 'nullable|string|max:50',
            'incident_summary' => 'required|string',
            'action_taken' => 'required|string',
            'extinguished_at' => 'nullable|date',
            'remarks' => 'nullable|string',
            'report_file' => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('report_file')) {
            $file = $request->file('report_file');
            $data['report_file_path'] = $file->store('post_operations', 'public');
            $data['report_file_original_name'] = $file->getClientOriginalName();
        }

        $data['user_id'] = auth()->id();
        unset($data['report_file']);

        $postOperation = PostOperation::create($data);

        ActivityLog::record('post_operation_recorded', "Logged post-operation record for fire report #{$postOperation->fire_report_id}");

        return redirect()->route('admin.post-operations')->with('status', 'Post-operation record saved.');
    }
}
