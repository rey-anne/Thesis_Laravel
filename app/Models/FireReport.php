<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FireReport extends Model
{
    protected $table = 'fire_reports';

    protected $fillable = [
        'reporter_contact', 'has_gps_pin', 'latitude', 'longitude',
        'has_file_attachment', 'photo_path', 'photo_metadata',
        'status', 'verified_by_crowdsourcing',
        'reported_at', 'extinguished_at', 'archived_at', 'is_archived',
    ];

    protected $casts = [
        'photo_metadata' => 'array',
        'is_archived' => 'boolean',
        'reported_at' => 'datetime',
        'extinguished_at' => 'datetime',
        'archived_at' => 'datetime',
    ];
}
