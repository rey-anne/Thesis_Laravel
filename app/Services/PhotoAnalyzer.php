<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

/**
 * Bridges to python/analyze_photo.py to extract real EXIF metadata
 * (exifread) and run OpenCV/numpy-based image checks (blur, validity,
 * a basic warm-color ratio) on a fire report photo.
 *
 * Never throws - on any failure (python missing, script error, bad
 * file) it returns the same "empty but valid" shape so callers don't
 * need special-case handling, and report submission is never blocked.
 */
class PhotoAnalyzer
{
    private static function emptyResult(): array
    {
        return [
            'exif' => [],
            'datetime_original' => null,
            'gps' => null,
            'image' => [
                'is_valid' => null,
                'width' => null,
                'height' => null,
                'blur_score' => null,
                'is_blurry' => null,
                'warm_color_ratio' => null,
            ],
            'error' => null,
        ];
    }

    public function analyze(string $absolutePath): array
    {
        $script = base_path('python/analyze_photo.py');
        $pythonBin = env('PYTHON_BIN', 'python');

        if (!file_exists($script) || !file_exists($absolutePath)) {
            return self::emptyResult();
        }

        try {
            $result = Process::timeout(15)->run([$pythonBin, $script, $absolutePath]);

            if (!$result->successful()) {
                Log::warning('PhotoAnalyzer: python process failed', [
                    'exit_code' => $result->exitCode(),
                    'stderr' => $result->errorOutput(),
                ]);

                return self::emptyResult();
            }

            $decoded = json_decode($result->output(), true);

            if (!is_array($decoded)) {
                Log::warning('PhotoAnalyzer: could not decode python output', [
                    'output' => $result->output(),
                ]);

                return self::emptyResult();
            }

            return array_merge(self::emptyResult(), $decoded);
        } catch (\Throwable $e) {
            Log::warning('PhotoAnalyzer: exception while analyzing photo', [
                'message' => $e->getMessage(),
            ]);

            return self::emptyResult();
        }
    }
}
