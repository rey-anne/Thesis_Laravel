<?php

namespace App\Http\Controllers;

use App\Models\FireReport;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function heatmapData()
    {
        $points = FireReport::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('is_archived', false)
            ->get(['latitude', 'longitude'])
            ->map(fn ($report) => [
                'lat' => (float) $report->latitude,
                'lng' => (float) $report->longitude,
            ]);

        return response()->json($points);
    }

    public function education()
    {
        return view('education');
    }

    public function crowdsource()
    {
        return view('crowdsource');
    }

    public function cybersecurity()
    {
        return view('cybersecurity');
    }

    public function about()
    {
        return view('about');
    }

    public function firefighterHome()
    {
        $reports = FireReport::where('is_archived', false)
            ->orderByDesc('reported_at')
            ->get();

        return view('firefighter.reports', compact('reports'));
    }

    public function firefighterHeatmap()
    {
        return view('firefighter.heatmap');
    }
}
