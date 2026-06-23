<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\FireReport;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'pending_approvals' => User::where('account_status', 'pending')->count(),
            'total_reports' => FireReport::count(),
            'active_fires' => FireReport::where('status', 'active')->count(),
        ];

        $recentActivity = ActivityLog::with('user')->latest()->take(5)->get();

        return view('admin.home', compact('stats', 'recentActivity'));
    }

    public function heatmap()
    {
        return view('admin.heatmap');
    }
}
