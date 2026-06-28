<?php

namespace App\Http\Controllers;

use App\Models\CrowdsourceVerification;
use App\Models\FireReport;
use App\Services\PhotoAnalyzer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function create()
    {
        return view('report');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'gps_accuracy' => 'nullable|numeric',
            'captured_at' => 'nullable|date',
            'photo_data' => 'required|string',
        ]);

        $photoPath = $this->saveBase64Image($data['photo_data'], 'fire_reports');

        $report = FireReport::create([
            // Keep this as null only if your database still has reporter_contact column
            'reporter_contact' => null,

            'has_gps_pin' => !empty($data['latitude']) && !empty($data['longitude']),
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,

            'has_file_attachment' => !empty($photoPath),
            'photo_path' => $photoPath,
            'photo_metadata' => [
                'device' => $request->userAgent(),
                'gps_accuracy_m' => $data['gps_accuracy'] ?? null,
                'captured_at' => $data['captured_at'] ?? null,
            ],

            'status' => 'active',
            'reported_at' => now(),
        ]);

        $exifMetadata = (new PhotoAnalyzer())->analyze(Storage::disk('public')->path($photoPath));
        $report->update(['exif_metadata' => $exifMetadata]);

        $report->update(['validation_results' => $report->computeValidationResults()]);

        return redirect()->route('report.success');
    }

    public function success()
    {
        return view('report-success');
    }

    public function storeCrowdsourceVerification(Request $request)
    {
        $data = $request->validate([
            'fire_report_id' => 'required|exists:fire_reports,id',
            'verification_photo_data' => 'required|string',
        ]);

        $photoPath = $this->saveBase64Image(
            $data['verification_photo_data'],
            'crowdsource_verifications'
        );

        CrowdsourceVerification::create([
            'fire_report_id' => $data['fire_report_id'],
            'verification_photo_path' => $photoPath,
            'submitted_at' => now(),
        ]);

        FireReport::where('id', $data['fire_report_id'])
            ->update(['verified_by_crowdsourcing' => true]);

        return response()->json(['status' => 'ok']);
    }

    private function saveBase64Image(string $base64, string $folder): string
    {
        if (!str_contains($base64, ',')) {
            abort(422, 'Invalid image data.');
        }

        [$meta, $encoded] = explode(',', $base64, 2);

        if (!str_contains($meta, 'image/')) {
            abort(422, 'Uploaded file must be an image.');
        }

        $imageData = base64_decode($encoded, true);

        if ($imageData === false) {
            abort(422, 'Invalid image encoding.');
        }

        $filename = $folder . '/' . Str::uuid() . '.jpg';

        Storage::disk('public')->put($filename, $imageData);

        return $filename;
    }
}