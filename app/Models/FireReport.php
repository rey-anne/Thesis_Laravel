<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FireReport extends Model
{
    protected $table = 'fire_reports';

    protected $fillable = [
        'reporter_contact', 'has_gps_pin', 'latitude', 'longitude',
        'has_file_attachment', 'photo_path', 'photo_metadata', 'validation_results', 'exif_metadata',
        'status', 'verified_by_crowdsourcing',
        'reported_at', 'extinguished_at', 'archived_at', 'is_archived',
    ];

    protected $casts = [
        'photo_metadata' => 'array',
        'validation_results' => 'array',
        'exif_metadata' => 'array',
        'is_archived' => 'boolean',
        'reported_at' => 'datetime',
        'extinguished_at' => 'datetime',
        'archived_at' => 'datetime',
    ];

    const STATUS_PASSED = 'passed';
    const STATUS_WARNING = 'warning';
    const STATUS_FAILED = 'failed';

    /**
     * Reporter's GPS location: did we get a real, plausible coordinate pair?
     */
    public function evaluateLocationStatus(): string
    {
        if (!$this->has_gps_pin || $this->latitude === null || $this->longitude === null) {
            return self::STATUS_WARNING;
        }

        $lat = (float) $this->latitude;
        $lng = (float) $this->longitude;

        if ($lat < -90 || $lat > 90 || $lng < -180 || $lng > 180) {
            return self::STATUS_FAILED;
        }

        if ($lat === 0.0 && $lng === 0.0) {
            return self::STATUS_FAILED;
        }

        return self::STATUS_PASSED;
    }

    /**
     * Date/time submitted: compares the client-reported capture time
     * (photo_metadata.captured_at, set by the browser at the moment of
     * capture) against the trusted server-side reported_at timestamp.
     */
    public function evaluateTimestampStatus(): string
    {
        $capturedAt = $this->photo_metadata['captured_at'] ?? null;

        if (!$capturedAt || !$this->reported_at) {
            return self::STATUS_WARNING;
        }

        try {
            $captured = Carbon::parse($capturedAt);
        } catch (\Exception $e) {
            return self::STATUS_FAILED;
        }

        $diffMinutes = abs($captured->diffInMinutes($this->reported_at));

        if ($diffMinutes <= 5) {
            return self::STATUS_PASSED;
        }

        if ($diffMinutes <= 30) {
            return self::STATUS_WARNING;
        }

        return self::STATUS_FAILED;
    }

    /**
     * Image metadata: combines two sources.
     *  - photo_metadata: device info, capture timestamp, and GPS accuracy
     *    reported by the browser at capture time.
     *  - exif_metadata: real EXIF (via exifread) and OpenCV/numpy pixel
     *    checks (validity, blur, warm-color ratio) extracted server-side
     *    by python/analyze_photo.py from the actual saved file. This is
     *    more trustworthy than the browser-reported values since it
     *    can't be spoofed by editing page JS, but real EXIF is usually
     *    empty for canvas-captured photos - that's expected, not an error.
     */
    public function evaluateMetadataStatus(): string
    {
        $meta = $this->photo_metadata;
        $exif = $this->exif_metadata;

        // A file OpenCV can't even decode is a hard failure regardless
        // of what the browser claimed about it.
        if ($exif && ($exif['image']['is_valid'] ?? null) === false) {
            return self::STATUS_FAILED;
        }

        if (!$meta || empty($meta['device'])) {
            return self::STATUS_FAILED;
        }

        if (empty($meta['captured_at'])) {
            return self::STATUS_WARNING;
        }

        $accuracy = $meta['gps_accuracy_m'] ?? null;
        $status = self::STATUS_WARNING;

        if ($accuracy !== null) {
            $accuracy = (float) $accuracy;

            if ($accuracy <= 100) {
                $status = self::STATUS_PASSED;
            } elseif ($accuracy <= 5000) {
                $status = self::STATUS_WARNING;
            } else {
                $status = self::STATUS_FAILED;
            }
        }

        // A blurry photo is hard for BFP to visually verify - never
        // let that pass cleanly even if the other signals look fine.
        if ($status === self::STATUS_PASSED && ($exif['image']['is_blurry'] ?? false)) {
            $status = self::STATUS_WARNING;
        }

        // Real EXIF capture time, when present, is more authoritative
        // than the browser-reported captured_at - cross-check it too.
        $exifDatetime = $exif['datetime_original'] ?? null;
        if ($exifDatetime && $this->reported_at) {
            try {
                $diffMinutes = abs(Carbon::parse($exifDatetime)->diffInMinutes($this->reported_at));

                if ($diffMinutes > 30) {
                    return self::STATUS_FAILED;
                }
            } catch (\Exception $e) {
                // Unparseable EXIF datetime - ignore and keep the browser-based status.
            }
        }

        return $status;
    }

    public function computeValidationResults(): array
    {
        $location = $this->evaluateLocationStatus();
        $timestamp = $this->evaluateTimestampStatus();
        $metadata = $this->evaluateMetadataStatus();

        $statuses = [$location, $timestamp, $metadata];
        $summary = self::STATUS_PASSED;
        if (in_array(self::STATUS_FAILED, $statuses, true)) {
            $summary = self::STATUS_FAILED;
        } elseif (in_array(self::STATUS_WARNING, $statuses, true)) {
            $summary = self::STATUS_WARNING;
        }

        return [
            'location' => $location,
            'timestamp' => $timestamp,
            'metadata' => $metadata,
            'summary' => $summary,
        ];
    }

    /**
     * Stored validation results if available, otherwise computed live -
     * keeps reports created before this feature shipped working too.
     */
    public function validationSummary(): array
    {
        return $this->validation_results ?? $this->computeValidationResults();
    }

    public static function statusColor(string $status): string
    {
        return match ($status) {
            self::STATUS_PASSED => 'green',
            self::STATUS_WARNING => 'orange',
            self::STATUS_FAILED => 'red',
            default => 'orange',
        };
    }
}
